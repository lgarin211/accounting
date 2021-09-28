<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Asset\KelompokAktiva;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Asset\KelompokAktiva;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.asset.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.asset.create', [
            'asset' => new Asset(),
            'kelompok' => KelompokAktiva::get()
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
        //
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
    public function print(Request $request)
    {
        $this->validate($request, [
            "nama" => 'required',
            "kelompok" => "required",
            "date" => 'required',
            "harga_beli" => 'required',
            "nilai_residu" => 'required',
            "umur_ekonomis" => 'required',
            "lokasi" => 'required',
            "metode" => 'required',
            "nomor_aktiva" => 'required',
            "departemen" => "required",
            "akumulasi_beban" => 'required',
            "beban_tahun" => 'required',
            "terhitung_tanggal" => 'required',
            "nilai_buku" => 'required',
            "beban_bulan" => 'required'
        ]);
        $collection = new Collection();
        $attr = $request->all();
        $bulan = Carbon::parse($request->date)->format('m');
        $hasil = $request->umur_ekonomis * 12;
        $total = $hasil - $bulan;
        for ($i = 1; $i <= $total; $i++) {
            $collection->push([
                'tanggal' => Carbon::now()->lastOfMonth()->format(''),
                'akumulasi_penyusutan' => 'asd',
                'penyusutan_bulanan' => 'asd',
                'nilai_buku' => 'asd'
            ]);
        }
        $carbon = Carbon::parse($attr['date'])->addYear($attr['umur_ekonomis'])->format('Y-m-d');
        dd($carbon, $request->umur_ekonomis, $collection);
        $attr['harga_beli'] = str_replace(',', '', $request->harga_beli);
        $attr['nilai_residu'] = str_replace(',', '', $request->nilai_residu);
        $attr['akumulasi_beban'] = str_replace(',', '', $request->akumulasi_beban);
        $attr['beban_tahun'] = str_replace(',', '', $request->beban_tahun);
        $attr['nilai_buku'] = str_replace(',', '', $request->nilai_buku);
        $attr['beban_bulan'] = str_replace(',', '', $request->beban_bulan);
        return view('admin.asset.print', [
            'attr' => $attr
        ]);
    }
}
