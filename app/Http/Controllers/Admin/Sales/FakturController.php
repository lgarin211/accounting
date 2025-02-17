<?php

namespace App\Http\Controllers\Admin\Sales;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use App\Models\Jurnalumum;
use App\Models\Purchase\FakturBuy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Validator};
use App\Models\Sale\{FakturSale, FakturSaleDetail, PiutangSale};
use App\Models\Transaction;
use App\Http\Controllers\Admin\JurnalUmumController;
use App\Models\Divisi;
use App\Models\Jurnalumumdetail;

class FakturController extends Controller
{
    protected $kode;

    public function __construct()
    {
        $number = FakturSale::count();
        if ($number > 0) {
            $number = FakturSale::max('kode');
            $strnum = substr($number, 2, 3);
            $strnum = $strnum + 1;
            if (strlen($strnum) == 3) {
                $kode = 'PF' . $strnum;
            } else if (strlen($strnum) == 2) {
                $kode = 'PF' . "0" . $strnum;
            } else if (strlen($strnum) == 1) {
                $kode = 'PF' . "00" . $strnum;
            }
        } else {
            $kode = 'PF' . "001";
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
        $fakturs = FakturSale::select('id', 'tanggal', 'kode', 'pelanggan_id', 'total', 'status')
            ->with('pelanggan')
            ->paginate(10);

        return view('admin.sales.faktur.index', compact('fakturs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sales.faktur.create', [
            'kode' => $this->kode,
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
            'pelanggan_id' => 'required|exists:kontaks,id',
            'pesanan_id' => 'exists:pesanan_sales,id',
            'tanggal' => 'required|date|date_format:Y-m-d',
            'status' => 'sometimes',
            'akun_penjualan_id' => 'required|exists:akuns,id',
            'fakturs.*.product_id' => 'required|exists:products,id',
            'fakturs.*.jumlah' => 'required|numeric',
            'fakturs.*.satuan' => 'required',
            'fakturs.*.harga' => 'required',
            'fakturs.*.total' => 'required',
            'total' => 'required',
        ];

        if (!empty($request->status)) {;
            $rules['akun_id'] = 'required|exists:akuns,id';
        }

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        try {
            DB::transaction(function () use ($request) {
                $fakturs = FakturSale::create(array_merge(
                    $request->except('fakturs', 'akun_id', 'akun_penjualan_id', 'status', 'total'),
                    [
                        'akun_id' => $request->akun_id ?? null,
                        'status' => !empty($request->status) && !empty($request->akun_id) ? '1' : '0',
                        'total' => preg_replace('/[^\d.]/', '', $request->total),
                    ]
                ));

                $akun_penjualan = Akun::find($request->akun_penjualan_id); // Akun Penjualan
                $saldo_akhir_penjualan = $akun_penjualan->saldo_awal + ($akun_penjualan->debit - $fakturs->total);

                $akun_penjualan->update([
                    'kredit' => $akun_penjualan->kredit + $fakturs->total,
                    'saldo_akhir' => $saldo_akhir_penjualan
                ]);

                $akuns = [[
                    'id' => $akun_penjualan->id,
                    'debit' => 0,
                    'kredit' => $fakturs->total,
                ]];

                if (empty($request->status) && empty($request->akun_id)) {
                    $akun = Akun::findByCode(11000); // Akun Piutang Usaha
                    $saldo_akhir = $akun->saldo_awal + ($fakturs->total - $akun->kredit);

                    $akun->update([
                        'debit' => $akun->debit + $fakturs->total,
                        'saldo_akhir' => $saldo_akhir
                    ]);

                    array_unshift($akuns, [
                        'id' => $akun->id,
                        'debit' => $fakturs->total,
                        'kredit' => 0,
                    ]);

                    Transaction::create([
                        'name' => 'Pembayaran Tidak Lunas ' . date('d-M-Y'),
                        'akun_id' => $akun->id,
                        'kredit' => $fakturs->total,
                        'type' => 'Penjualan Hutang',
                    ]);

                    PiutangSale::create([
                        'pelanggan_id' => $fakturs->pelanggan_id,
                        'faktur_id' => $fakturs->id,
                        'total_hutang' => $fakturs->total,
                        'lunas' => null,
                        'sisa' => $fakturs->total,
                        'status' => '0'
                    ]);
                } else {
                    $akun = Akun::find($request->akun_id);
                    $saldo_akhir = $akun->saldo_awal + ($fakturs->total - $akun->kredit);

                    $akun->update([
                        'debit' => $akun->debit + $fakturs->total,
                        'saldo_akhir' => $saldo_akhir
                    ]);

                    array_unshift($akuns, [
                        'id' => $akun->id,
                        'debit' => $fakturs->total,
                        'kredit' => 0
                    ]);

                    Transaction::create([
                        'name' => 'Pembayaran Lunas ' . date('d-M-Y'),
                        'akun_id' => $akun->id,
                        'kredit' => $fakturs->total,
                        'type' => 'Penjualan Lunas',
                    ]);
                }

                // Buat JURNAL ===============================
                $divisi = Divisi::findByCode(1000); // belum tentu fix kodenya
                $jurnal = Jurnalumum::create([
                    'tanggal' => $request->tanggal,
                    'kode_jurnal' => $this->ju->kode_jurnal(),
                    'kontak_id' => $request->pelanggan_id,
                    'divisi_id' => $divisi->id,
                    'uraian' => "Piutang {$fakturs->pelanggan->nama}",
                ]);

                for ($i = 0; $i < 2; $i++) {
                    Jurnalumumdetail::create([
                        'akun_id' => $akuns[$i]['id'],
                        'jurnalumum_id' => $jurnal->id,
                        'debit' => $akuns[$i]['debit'],
                        'kredit' => $akuns[$i]['kredit'],
                    ]);
                }
                // END Buat JURNAL ===============================

                foreach ($request->fakturs as $faktur) {
                    FakturSaleDetail::create([
                        'faktur_id' => $fakturs->id,
                        'product_id' => $faktur['product_id'],
                        'satuan' => $faktur['satuan'],
                        'harga' => preg_replace('/[^\d.]/', '', $faktur['harga']),
                        'jumlah' => $faktur['jumlah'],
                        'total' => preg_replace('/[^\d.]/', '', $faktur['total']),
                    ]);
                }
            });

            return redirect()->route('admin.sales.faktur.index')->with('success', 'Faktur berhasil tersimpan');
        } catch (\Exception $e) {
            return back()->with('error', 'Faktur tidak Tersimpan!' . $e->getMessage());
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
        $faktur = FakturSale::with('faktur_details.product', 'pelanggan')->findOrFail($id);

        return view('admin.sales.faktur.show', compact('faktur'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $faktur = FakturSale::with('pelanggan:id,nama,kode_kontak', 'akun:id,kode,name', 'pesanan:id,kode', 'faktur_details')
            ->find($id);

        if (empty($faktur)) {
            return redirect()->route('admin.sales.faktur.index')->with('error', 'Faktur tidak ditemukan.');
        }

        return view('admin.sales.faktur.edit', compact('faktur'));
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
        $req = $request->except('_token', '_method');

        $validate = Validator::make($req, [
            'fakturs.*.product_id' => 'required|exists:products,id',
            'fakturs.*.jumlah' => 'required|numeric',
            'fakturs.*.satuan' => 'required',
            'fakturs.*.harga' => 'required',
            'fakturs.*.total' => 'required',
            'total' => 'required',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        $faktur = FakturSale::find($id);

        if (empty($faktur)) {
            return redirect()->route('admin.sales.faktur.index')->with('error', 'Faktur tidak ada.');
        }

        try {
            DB::transaction(function () use ($id, $req, $faktur) {
                $detail_id = [];

                foreach ($req['fakturs'] as $value) {
                    $detail_id[] = $value['id'];
                }

                $detail_id = array_filter($detail_id, fn ($value) => !is_null($value) && $value !== '');

                FakturSaleDetail::where('faktur_id', $id)
                    ->whereNotIn('id', $detail_id)
                    ->delete();

                foreach ($req['fakturs'] as $item) {
                    if ($item['id'] != null) {
                        FakturSaleDetail::where('id', $item['id'])->update([
                            'product_id' => $item['product_id'],
                            'satuan' => $item['satuan'],
                            'harga' => preg_replace('/[^\d.]/', '', $item['harga']),
                            'jumlah' => $item['jumlah'],
                            'total' => preg_replace('/[^\d.]/', '', $item['total']),
                        ]);
                    } else {
                        FakturSaleDetail::create([
                            'faktur_id' => $id,
                            'product_id' => $item['product_id'],
                            'jumlah' => $item['jumlah'],
                            'satuan' => $item['satuan'],
                            'harga' => preg_replace('/[^\d.]/', '', $item['harga']),
                            'total' => preg_replace('/[^\d.]/', '', $item['total']),
                        ]);
                    }
                }

                $faktur->update([
                    'total' => preg_replace('/[^\d.]/', '', $req['total'])
                ]);
            });

            return redirect()->route('admin.sales.faktur.index')->with('success', 'Faktur berhasil diedit');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fakturs = FakturSale::findOrFail($id);
        $fakturs->delete();

        return redirect()->back()->with('success', 'Faktur berhasil Dihapus');
    }
}
