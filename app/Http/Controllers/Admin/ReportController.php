<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LabarugiExport;
use App\Exports\NeracaExport;
use App\Http\Controllers\Controller;
use App\Models\{Akun, Jurnalumumdetail, Bkk, BkkDetail, Transaction};
use App\Models\Purchase\FakturBuy;
use App\Models\Sale\FakturSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

use PDF;

class ReportController extends Controller
{
    private $startDate;
    private $endDate;

    public function __construct()
    {
        $this->startDate = request('startDate');
        $this->endDate = request('endDate');
    }

    public function menu()
    {
        return view('report.menu');
    }

    public function jurnalumum()
    {
        return view('report.keuangan.jurnalumum');
    }

    public function jurnalumumcari(Request $request)
    {
        $request->validate([
            'startDate' => 'required',
            'endDate' => 'required',
        ]);
        $from = $this->startDate;
        $to = $this->endDate;
        $startDate = $from;
        $endDate = $to;
        $data = Jurnalumumdetail::whereBetween('created_at', [$startDate, $endDate])->latest()->paginate(10);
        return view('report.keuangan.jurnalumum', compact('data', 'startDate', 'endDate'));
    }

    public function kas($nama)
    {
        if ($nama == 'Bkk') {
            $bkk = Bkk::where('status', 'BKK')->latest()->paginate(10);
            return view('report.keuangan.bkk', compact('bkk'));
        }
        $bkm = Bkk::where('status', 'BKM')->latest()->paginate(10);
        return view('report.keuangan.bkm', compact('bkm'));
    }

    public function kascari(Request $request, $nama)
    {
        if ($nama == 'Bkk') {
            $request->validate([
                'startDate' => 'required',
                'endDate' => 'required',
            ]);
            $from = $request->startDate;
            $to = $request->endDate;
            $startDate = $from;
            $endDate = $to;
            $bkk = Bkk::where('status', 'BKK')->whereBetween('tanggal', [$startDate, $endDate])->latest()->paginate(10);
            return view('report.keuangan.bkk', compact('bkk', 'startDate', 'endDate'));
        }
        $request->validate([
            'startDate' => 'required',
            'endDate' => 'required',
        ]);
        $from = $request->startDate;
        $to = $request->endDate;
        $startDate = $from;
        $endDate = $to;
        $bkm = Bkk::where('status', 'BKM')->whereBetween('tanggal', [$startDate, $endDate])->latest()->paginate(10);
        return view('report.keuangan.bkm', compact('bkm', 'startDate', 'endDate'));
    }
    public function neraca()
    {
        // $akuns = Akun::where('saldo_berjalan','!=',0)->where('level','Aktiva')->orderBy('subklasifikasi_id','asc')->get();

        // foreach($akuns->unique('subklasifikasi_id') as $data){
        //     echo $data->subklasifikasi->name.'<br>';
        // }
        $start = $this->startDate;
        $end = $this->endDate;

        if ($start && $end) {
            $akun_aktiva = Akun::where('level', 'Aktiva')
                ->with(['transactions' => function ($q) use ($start, $end) {
                    $q->whereBetween('tanggal', [$start, $end]);
                }])
                ->orderBy('kode', 'asc')->get();
            $hitung_aktiva = [];
            foreach ($akun_aktiva as $key) {
                array_push($hitung_aktiva, $key->saldo_awal + ($key->transactions->sum('debit') - $key->transactions->sum('kredit')));
            }
            $total_aktiva = array_sum($hitung_aktiva);

            $akun_modal = Akun::where('level', 'Modal')
                ->with(['transactions' => function ($q) use ($start, $end) {
                    $q->whereBetween('tanggal', [$start, $end]);
                }])
                ->orderBy('kode', 'asc')->get();

            $hitung_modal = [];
            foreach ($akun_modal as $key) {
                array_push($hitung_modal, $key->saldo_awal + ($key->transactions->sum('debit') - $key->transactions->sum('kredit')));
            }
            $total_modal = array_sum($hitung_modal);

            $akun_kewajiban = Akun::where('level', 'Kewajiban')
                ->with(['transactions' => function ($q) use ($start, $end) {
                    $q->whereBetween('tanggal', [$start, $end]);
                }])
                ->orderBy('kode', 'asc')->get();

            $hitung_kewajiban = [];
            foreach ($akun_kewajiban as $key) {
                array_push($hitung_kewajiban, $key->saldo_awal + ($key->transactions->sum('debit') - $key->transactions->sum('kredit')));
            }
            $total_kewajiban = array_sum($hitung_kewajiban);

            $aktiva = Akun::where('level', 'Aktiva')->orderBy('kode', 'asc')->get();
            $modal = Akun::where('level', 'Modal')->orderBy('kode', 'asc')->get();
            $kewajiban = Akun::where('level', 'Kewajiban')->orderBy('kode', 'asc')->get();
        } else {
            $akun_aktiva = Akun::where('level', 'Aktiva')->orderBy('kode', 'asc')->get();
            $hitung_aktiva = [];
            foreach ($akun_aktiva as $key) {
                array_push($hitung_aktiva, $key->debit - $key->kredit);
            }
            $total_aktiva = array_sum($hitung_aktiva);

            $akun_modal = Akun::where('level', 'Modal')->orderBy('kode', 'asc')->get();
            $hitung_modal = [];
            foreach ($akun_modal as $key) {
                array_push($hitung_modal, $key->debit - $key->kredit);
            }
            $total_modal = array_sum($hitung_modal);

            $akun_kewajiban = Akun::where('level', 'Kewajiban')->orderBy('kode', 'asc')->get();
            $hitung_kewajiban = [];
            foreach ($akun_kewajiban as $key) {
                array_push($hitung_kewajiban, $key->debit - $key->kredit);
            }

            $total_kewajiban = array_sum($hitung_kewajiban);
            $aktiva = Akun::where('level', 'Aktiva')->orderBy('kode', 'asc')->get();
            $modal = Akun::where('level', 'Modal')->orderBy('kode', 'asc')->get();
            $kewajiban = Akun::where('level', 'Kewajiban')->orderBy('kode', 'asc')->get();
        }

        return view('report.neraca.index', [
            'aktiva' => $aktiva,
            'modal' => $modal,
            'kewajiban' => $kewajiban,
            'total_aktiva' => $total_aktiva,
            'total_modal' => $total_modal,
            'total_kewajiban' => $total_kewajiban,
            'tempat' => request('tempat'),
            'nowDate' => request('tanggal'),
            'kodam' => request('kodam'),
            'jabatan_fungsional' => request('jabatan_fungsional'),
            'nama' => request('nama'),
            'pangkat' => request('pangkat'),
            'nrp' => request('nrp')
        ]);
    }
    public function labarugi()
    {
        $start = $this->startDate;
        $end = $this->endDate;

        if ($start && $end) {
            $pendapatan = FakturSale::whereBetween('created_at', [$start, $end])->sum('total');
            $beban = FakturBuy::whereBetween('created_at', [$start, $end])->sum('total');
            $laba_kotor = $pendapatan - $beban;

            $JU_AkunBO = Jurnalumumdetail::whereBetween('created_at', [$start, $end])->whereHas('akun', function ($query) {
                $query->where('level', 'BiayaOperasional');
            })->sum('debit');

            $JU_Akun = Jurnalumumdetail::whereBetween('created_at', [$start, $end])->whereHas('akun', function ($query) {
                $query->where('level', 'BiayaOperasional');
            })->get();

            $BKK_AkunBO = DB::table('bkk_details')->join('akuns', 'bkk_details.rekening_id', '=', 'akuns.id')
                ->join('bkks', 'bkk_details.bkk_id', '=', 'bkks.id')
                ->where('akuns.level', 'BiayaOperasional')
                ->where('bkks.status', 'BKK')
                ->whereBetween('bkks.tanggal', [$start, $end])
                ->select('jml_uang')
                ->sum('jml_uang');

            $BKK_Biaya = DB::table('bkk_details')->join('akuns', 'bkk_details.rekening_id', '=', 'akuns.id')
                ->join('bkks', 'bkk_details.bkk_id', '=', 'bkks.id')
                ->where('akuns.level', 'BiayaOperasional')
                ->where('bkks.status', 'BKK')
                ->whereBetween('bkks.tanggal', [$start, $end])
                ->select('jml_uang', 'akuns.name as name', 'akuns.kode as kode')
                ->get();

            $BKM_PendapatLain = DB::table('bkk_details')->join('akuns', 'bkk_details.rekening_id', '=', 'akuns.id')
                ->join('bkks', 'bkk_details.bkk_id', '=', 'bkks.id')
                ->where('akuns.level', 'PendapatanLain')
                ->where('bkks.status', 'BKM')
                ->whereBetween('bkks.tanggal', [$start, $end])
                ->select('jml_uang')
                ->sum('jml_uang');

            $BiayaOperasional = $JU_AkunBO + $BKK_AkunBO;
            $laba_bersih = $laba_kotor - $BiayaOperasional;
        } else {
            $pendapatan = FakturSale::sum('total');
            $beban = FakturBuy::sum('total');
            $laba_kotor = $pendapatan - $beban;

            $JU_AkunBO = Jurnalumumdetail::whereHas('akun', function ($query) {
                $query->where('level', 'BiayaOperasional')->orderBy('kode', 'asc');
            })->sum('debit');

            $JU_Akun = Jurnalumumdetail::whereHas('akun', function ($query) {
                $query->where('level', 'BiayaOperasional')->orderBy('kode', 'asc');
            })->get();

            $BKK_AkunBO = DB::table('bkk_details')->join('akuns', 'bkk_details.rekening_id', '=', 'akuns.id')
                ->join('bkks', 'bkk_details.bkk_id', '=', 'bkks.id')
                ->where('akuns.level', 'BiayaOperasional')
                ->where('bkks.status', 'BKK')
                ->orderBy('akuns.kode', 'asc')
                ->select('jml_uang')
                ->sum('jml_uang');

            $BKK_Biaya = DB::table('bkk_details')->join('akuns', 'bkk_details.rekening_id', '=', 'akuns.id')
                ->join('bkks', 'bkk_details.bkk_id', '=', 'bkks.id')
                ->where('akuns.level', 'BiayaOperasional')
                ->where('bkks.status', 'BKK')
                ->orderBy('akuns.kode', 'asc')
                ->select('jml_uang', 'akuns.name as name', 'akuns.kode as kode')
                ->get();

            $BKM_PendapatLain = DB::table('bkk_details')->join('akuns', 'bkk_details.rekening_id', '=', 'akuns.id')
                ->join('bkks', 'bkk_details.bkk_id', '=', 'bkks.id')
                ->where('akuns.level', 'PendapatanLain')
                ->where('bkks.status', 'BKM')
                ->select('jml_uang')
                ->sum('jml_uang');

            $BiayaOperasional = $JU_AkunBO + $BKK_AkunBO;
            $laba_bersih = $laba_kotor - $BiayaOperasional;
        }

        return view('report.keuangan.labarugi', [
            'pendapatan' => $pendapatan,
            'laba_kotor' => $laba_kotor,
            'laba_bersih' => $laba_bersih,
            'beban' => $beban,
            'BiayaOperasional' => $BiayaOperasional,
            'PendapatanLain' => $BKM_PendapatLain,
            'tempat' => request('tempat'),
            'nowDate' => request('tanggal'),
            'kodam' => request('kodam'),
            'jabatan_fungsional' => request('jabatan_fungsional'),
            'nama' => request('nama'),
            'pangkat' => request('pangkat'),
            'nrp' => request('nrp'),
            'Biaya' => $BKK_Biaya,
            'Biaya_JU' => $JU_Akun
        ]);
    }

    public function bukubesar()
    {
        return view('report.bukubesar.index', [
            'kontak' => Akun::get(),
            'akun' => Akun::get(),
            'rowsCount' => Bkk::orderBy('id', 'DESC')->get()->count()
        ]);
    }
    public function bukubesarcari(Request $request)
    {
        $from = $request->startDate;
        $to = $request->endDate;
        $kontak = $request->kontak;
        if ($kontak == 'all') {
            $akun = Akun::whereHas('jurnalumumdetails', function ($q) use ($from, $to, $kontak) {
                return $q->whereHas('jurnalumum', function ($qr) use ($from, $to, $kontak) {
                    return
                        $qr->whereBetween('tanggal', [$from, $to]);
                });
            })->get();
        } else {
            $akun = Akun::where('id', $kontak)->whereHas('jurnalumumdetails', function ($q) use ($from, $to, $kontak) {
                return $q->whereHas('jurnalumum', function ($qr) use ($from, $to, $kontak) {
                    return
                        $qr->whereBetween('tanggal', [$from, $to]);
                });
            })->get();
        }
        return view('report.bukubesar.index', [
            'selected' => $kontak,
            'kontak' => Akun::get(),
            'akun' => $akun,
            'startDate' => $from,
            'endDate' => $to,
            'rowsCount' => Bkk::orderBy('id', 'DESC')->get()->count()
        ]);
    }

    public function neraca_detail($id)
    {
        return view('admin.bukubesar.index', [
            'kontak' => Akun::where('id', $id)->get(),
            'akun' => Akun::where('id', $id)->get(),
            'select' => Akun::get()
        ]);
    }
    public function neraca_pdf(Request $request)
    {
        $akun_aktiva = Akun::where('level', 'Aktiva')->orderBy('id', 'asc')->get();
        $hitung_aktiva = [];
        foreach ($akun_aktiva as $key) {
            array_push($hitung_aktiva, $key->debit - $key->kredit);
        }
        $total_aktiva = array_sum($hitung_aktiva);

        $akun_modal = Akun::where('level', 'Modal')->orderBy('id', 'asc')->get();
        $hitung_modal = [];
        foreach ($akun_modal as $key) {
            array_push($hitung_modal, $key->debit - $key->kredit);
        }
        $total_modal = array_sum($hitung_modal);

        $akun_kewajiban = Akun::where('level', 'Kewajiban')->orderBy('id', 'asc')->get();
        $hitung_kewajiban = [];
        foreach ($akun_kewajiban as $key) {
            array_push($hitung_kewajiban, $key->debit - $key->kredit);
        }

        $total_kewajiban = array_sum($hitung_kewajiban);
        $aktiva = Akun::where('level', 'Aktiva')->orderBy('id', 'asc')->get();
        $modal = Akun::where('level', 'Modal')->orderBy('id', 'asc')->get();
        $kewajiban = Akun::where('level', 'Kewajiban')->orderBy('id', 'asc')->get();

        $pdf = PDF::loadview('report.neraca.pdf', [
            'aktiva' => $aktiva,
            'modal' => $modal,
            'kewajiban' => $kewajiban,
            'total_aktiva' => $total_aktiva,
            'total_modal' => $total_modal,
            'total_kewajiban' => $total_kewajiban,
            'tempat' => $request->get('tempat'),
            'kodam' => $request->get('kodam'),
            'nowDate' => $request->get('tanggal'),
            'jabatan_fungsional' => $request->get('jabatan_fungsional'),
            'nama' => $request->get('nama'),
            'pangkat' => $request->get('pangkat'),
            'nrp' => $request->get('nrp')
        ]);

        return $pdf->stream();
    }
    public function labarugi_pdf(Request $request)
    {
        $pendapatan = FakturSale::sum('total');
        $beban = FakturBuy::sum('total');
        $laba_kotor = $pendapatan - $beban;

        $JU_AkunBO = Jurnalumumdetail::whereHas('akun', function ($query) {
            $query->where('level', 'BiayaOperasional');
        })->sum('debit');

        $BKK_AkunBO = DB::table('bkk_details')->join('akuns', 'bkk_details.rekening_id', '=', 'akuns.id')
            ->join('bkks', 'bkk_details.bkk_id', '=', 'bkks.id')
            ->where('akuns.level', 'BiayaOperasional')
            ->where('bkks.status', 'BKK')
            ->select('jml_uang')
            ->sum('jml_uang');

        $BKM_PendapatLain = DB::table('bkk_details')->join('akuns', 'bkk_details.rekening_id', '=', 'akuns.id')
            ->join('bkks', 'bkk_details.bkk_id', '=', 'bkks.id')
            ->where('akuns.level', 'PendapatanLain')
            ->where('bkks.status', 'BKM')
            ->select('jml_uang')
            ->sum('jml_uang');

        $BiayaOperasional = $JU_AkunBO + $BKK_AkunBO;
        $laba_bersih = $laba_kotor - $BiayaOperasional;

        $pdf = PDF::loadview('report.keuangan.pdf', [
            'pendapatan' => $pendapatan,
            'laba_kotor' => $laba_kotor,
            'laba_bersih' => $laba_bersih,
            'beban' => $beban,
            'BiayaOperasional' => $BiayaOperasional,
            'PendapatanLain' => $BKM_PendapatLain,
            'tempat' => $request->get('tempat'),
            'kodam' => $request->get('kodam'),
            'nowDate' => $request->get('tanggal'),
            'jabatan_fungsional' => $request->get('jabatan_fungsional'),
            'nama' => $request->get('nama'),
            'pangkat' => $request->get('pangkat'),
            'nrp' => $request->get('nrp')
        ]);

        return $pdf->stream();
    }
    public function neraca_excel()
    {

        ob_end_clean();
        ob_start();
        return Excel::download(new NeracaExport(), 'NeracaExport.xlsx');
    }
    public function labarugi_excel()
    {
        ob_end_clean();
        ob_start();
        return Excel::download(new LabarugiExport(), 'LabarugiExport.xlsx');
    }
}
