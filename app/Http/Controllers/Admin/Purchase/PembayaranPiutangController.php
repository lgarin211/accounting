<?php

namespace App\Http\Controllers\Admin\Purchase;

use App\Http\Controllers\Admin\JurnalUmumController;
use App\Http\Controllers\Controller;
use App\Models\Akun;
use App\Models\Divisi;
use App\Models\Jurnalumum;
use App\Models\Jurnalumumdetail;
use App\Models\Purchase\FakturBuy;
use App\Models\Purchase\PembayaranPiutangBuy;
use App\Models\Purchase\PembayaranPiutangDetailBuy;
use App\Models\Purchase\PiutangBuy;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Validator};

class PembayaranPiutangController extends Controller
{
    protected $kode;

    public function __construct()
    {
        $number = PembayaranPiutangBuy::count();
        if ($number > 0) {
            $number = PembayaranPiutangBuy::max('kode');
            $strnum = substr($number, 2, 3);
            $strnum = $strnum + 1;
            if (strlen($strnum) == 3) {
                $kode = 'CN' . $strnum;
            } else if (strlen($strnum) == 2) {
                $kode = 'CN' . "0" . $strnum;
            } else if (strlen($strnum) == 1) {
                $kode = 'CN' . "00" . $strnum;
            }
        } else {
            $kode = 'CN' . "001";
        }
        $this->kode = $kode;
        $this->ju = new JurnalUmumController();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pembayarans =  PembayaranPiutangBuy::select('id', 'tanggal', 'kode', 'pemasok_id', 'total')->with('pemasok')->paginate(10);
        return view('admin.purchase.pembayaran.index', compact('pembayarans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.purchase.pembayaran.create', [
            'kode' => $this->kode
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'pemasok_id' => 'required|exists:kontaks,id',
            'akun_id' => 'exists:akuns,id',
            'tanggal' => 'required|date|date_format:Y-m-d',
            'pembayarans.*.faktur_id' => 'required|exists:faktur_buys,id',
            'pembayarans.*.jumlah' => 'required',
            'pembayarans.*.bayar' => 'required',
            'total' => 'required',
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        try {
            DB::transaction(function () use ($request) {
                $pembayarans = PembayaranPiutangBuy::create(
                    array_merge(
                        $request->except('pembayarans', 'total', 'jumlah'),
                        [
                            'total' => preg_replace('/[^\d.]/', '', $request->total)
                        ]
                    )
                );

                $jml = (int)preg_replace('/[^\d.]/', '', $request->total);
                $akun = Akun::find($request->akun_id);
                $kredit = $akun->kredit + $jml;
                $akun->update([
                    'kredit' => $kredit,
                    'saldo_akhir' => $akun->saldo_awal + ($akun->debit - $kredit)
                ]);

                $akun_hutang = Akun::findByCode(20100);
                $debit = $akun_hutang->debit + $jml;
                $akun_hutang->update([
                    'debit' => $debit,
                    'saldo_akhir' => $akun_hutang->saldo_awal + ($debit - $akun_hutang->kredit)
                ]);

                $akuns = [
                    [
                        'id' => $akun->id,
                        'debit' => $jml,
                        'kredit' => 0,
                    ],
                    [
                        'id' => $akun_hutang->id,
                        'debit' => 0,
                        'kredit' => $jml,
                    ]
                ];

                foreach ($request->pembayarans as $pembayaran) {
                    PembayaranPiutangDetailBuy::create([
                        'pembayaran_piutang_buy_id' => $pembayarans->id,
                        'faktur_id' => $pembayaran['faktur_id'],
                        'bayar' => preg_replace('/[^\d.]/', '', $pembayaran['bayar']),
                    ]);

                    $piutang = PiutangBuy::where('faktur_id', $pembayaran['faktur_id'])->first();

                    $piutang->update([
                        'lunas' => preg_replace('/[^\d.]/', '', $pembayaran['bayar']),
                        'sisa' => $piutang->total_hutang - preg_replace('/[^\d.]/', '', $pembayaran['bayar']),
                        'status' => $piutang->total_hutang == preg_replace('/[^\d.]/', '', $pembayaran['bayar']) ? '1' : '0'
                    ]);

                    Transaction::create([
                        'name' => 'Pembayaran Tidak Lunas ' . date('d-M-Y'),
                        'akun_id' => $request->akun_id,
                        'debit' => preg_replace('/[^\d.]/', '', $pembayaran['bayar']),
                        'type' => 'Pembelian Lunas',
                    ]);

                    // $akun = Akun::findOrFail($request->akun_id);
                    // $akun->update([
                    //     'debit' => preg_replace('/[^\d.]/', '', $pembayaran['bayar'])
                    // ]);

                    if ($piutang->status == 1) {
                        $faktur = FakturBuy::findOrFail($pembayaran['faktur_id']);
                        $faktur->update([
                            'status' => '1'
                        ]);
                    }
                }

                // Buat JURNAL ===============================
                $divisi = Divisi::findByCode(1000); // belum tentu fix kodenya
                $jurnal = Jurnalumum::create([
                    'tanggal' => $request->tanggal,
                    'kode_jurnal' => $this->ju->kode_jurnal(),
                    'kontak_id' => $request->pemasok_id,
                    'divisi_id' => $divisi->id, // nginput ngasal
                    'uraian' => "Pembayaran Hutang " . $pembayarans->pemasok->nama,
                ]);

                for ($i = 0; $i < count($akuns); $i++) {
                    Jurnalumumdetail::create([
                        'akun_id' => $akuns[$i]['id'],
                        'jurnalumum_id' => $jurnal->id,
                        'debit' => $akuns[$i]['debit'],
                        'kredit' => $akuns[$i]['kredit'],
                    ]);
                }
                // END Buat JURNAL ===============================
            });

            return redirect()->route('admin.purchase.pembayaran.index')->with('success', 'Pembayaran berhasil Tersimpan');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
