<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BukuBesarExport;
use App\Exports\LaporanBukuBesarExport;
use App\Http\Controllers\Controller;
use App\Models\Akun;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BukuBesarController extends Controller
{
    public function index()
    {

        return view('admin.bukubesar.index', [
            'kontak' => Akun::get(),
            'akun' => null,
            'select' => Akun::get(),
            'ada' => 'ada'
        ]);
    }

    public function cariakun(Request $request)
    {
        return view('admin.bukubesar.index', [
            'kontak' => Akun::where('id', $request->id)->get(),
            'akun' => Akun::where('id', $request->id)->get(),
            'select' => Akun::get(),
            'ada' => 'ada'
        ]);
    }
    public function excelexport($akun)
    {
        try {
            ob_end_clean();
            ob_start();
            return Excel::download(new BukuBesarExport($akun),'Buku Besar Excel.xlsx');
        } catch (Exception $err) {
            return back()->with('error', $err->getMessage());
        }
    }
    public function LaporanExcelExport(Request $request)
    {
        try {

            ob_end_clean();
            ob_start();
            return Excel::download(new LaporanBukuBesarExport($request->except(['_token'])), 'Laporan Buku Besar.xlsx');
        } catch (Exception $err) {
            return back()->with('error', $err->getMessage());

        }
    }
}
