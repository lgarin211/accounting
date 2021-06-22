<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurnalumum;
use App\Models\Jurnalumumdetail;
use Illuminate\Http\Request;

class ReportController extends Controller
{
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
            'startDate'=> 'required',
            'endDate'=> 'required',
        ]);
        $from = $request->startDate;
        $to = $request->endDate;
        $startDate = $from;
        $endDate = $to;
        $data = Jurnalumumdetail::whereBetween('created_at', [$startDate,$endDate])->latest()->paginate(10);
        return view('report.keuangan.jurnalumum', compact('data', 'startDate', 'endDate'));
    }
}
