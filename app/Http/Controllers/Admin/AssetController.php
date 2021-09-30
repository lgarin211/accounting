<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use App\Models\Asset;
use App\Models\Asset\KelompokAktiva;
use Illuminate\Http\Request;
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
        return view('admin.asset.index',[
            'asset' => Asset::get()
        ]);
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
            'kelompok' => KelompokAktiva::get(),
            'akun' => Akun::get()
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
        Asset::create($request->except(['_token']));
        return redirect()->route('admin.asset.index');
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
        return view('admin.asset.edit', [
            'asset' => Asset::find($id),
            'kelompok' => KelompokAktiva::get(),
            'akun' => Akun::get()
        ]);
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
            "tanggal_beli" => 'required',
            "harga_beli" => 'required',
            "nilai_residu" => 'required',
            "umur_ekonomis" => 'required',
            "metode" => 'required'
        ]);

        $harga_beli =  str_replace(',','',$request->harga_beli);

        $tanggal_beli = $request->tanggal_beli;
        $terhitung_tanggal = $request->terhitung_tanggal;
        $selisih = Carbon::parse($tanggal_beli)->diffInMonths($terhitung_tanggal);

        $beban_tahun = $harga_beli / $request->umur_ekonomis;

        $beban_bulan = $beban_tahun / 12;

        $akumulasi_beban = $beban_bulan * $selisih;

        $nilai_buku = $harga_beli - $akumulasi_beban;


        $collection = new Collection();
        $attr = $request->all();

        $bulan = Carbon::parse($request->tanggal_beli)->format('m');
        $hasil = $request->umur_ekonomis * 12;
        $total = $hasil - $bulan;
        $request->harga_beli = str_replace(',','',$request->harga_beli);
        for ($i = 0; $i <= $total; $i++) {
            $collection->push((object)[
                'tanggal' => Carbon::parse($request->tanggal_beli)->addMonths($i)->endOfMonth()->format('Y-m-d'),
                'akumulasi_penyusutan' => Akun::find($request->asset_harta)->kode,
                'penyusutan_bulanan' => $beban_bulan,
                'nilai_buku' => $request->harga_beli -= $beban_bulan
            ]);
        }

        // dd($request->all());
        $carbon = Carbon::parse($attr['tanggal_beli'])->addYear($attr['umur_ekonomis'])->format('Y-m-d');
        // dd($carbon, $request->umur_ekonomis, $collection);
        $attr['harga_beli'] = $harga_beli;
        $attr['nilai_residu'] = str_replace(',', '', $request->nilai_residu);
        $attr['akumulasi_beban'] = Akun::find($request->asset_harta)->kode;
        $attr['beban_tahun'] = $beban_tahun;
        $attr['nilai_buku'] = $nilai_buku;
        $attr['beban_bulan'] = $beban_bulan;
        $attr['kelompok'] = KelompokAktiva::find($request->kelompok);
        return view('admin.asset.print', [
            'attr' => $attr,
            'collection' => $collection
        ]);
    }
    public function print_update(Request $request)
    {
        $this->validate($request, [
            "nama" => 'required',
            "kelompok" => "required",
            "tanggal_beli" => 'required',
            "harga_beli" => 'required',
            "nilai_residu" => 'required',
            "umur_ekonomis" => 'required',
            "metode" => 'required'
        ]);

        $harga_beli =  str_replace(',','',$request->harga_beli);

        $tanggal_beli = $request->tanggal_beli;
        $terhitung_tanggal = $request->terhitung_tanggal;
        $selisih = Carbon::parse($tanggal_beli)->diffInMonths($terhitung_tanggal);

        $beban_tahun = $harga_beli / $request->umur_ekonomis;

        $beban_bulan = $beban_tahun / 12;

        $akumulasi_beban = $beban_bulan * $selisih;

        $nilai_buku = $harga_beli - $akumulasi_beban;


        $collection = new Collection();
        $attr = $request->all();

        $bulan = Carbon::parse($request->tanggal_beli)->format('m');
        $hasil = $request->umur_ekonomis * 12;
        $total = $hasil - $bulan;
        $request->harga_beli = str_replace(',','',$request->harga_beli);
        for ($i = 0; $i <= $total; $i++) {
            $collection->push((object)[
                'tanggal' => Carbon::parse($request->tanggal_beli)->addMonths($i)->endOfMonth()->format('Y-m-d'),
                'akumulasi_penyusutan' => Akun::find($request->asset_harta)->kode,
                'penyusutan_bulanan' => $beban_bulan,
                'nilai_buku' => $request->harga_beli -= $beban_bulan
            ]);
        }

        // dd($request->all());
        $carbon = Carbon::parse($attr['tanggal_beli'])->addYear($attr['umur_ekonomis'])->format('Y-m-d');
        // dd($carbon, $request->umur_ekonomis, $collection);
        $attr['harga_beli'] = $harga_beli;
        $attr['nilai_residu'] = str_replace(',', '', $request->nilai_residu);
        $attr['akumulasi_beban'] = Akun::find($request->asset_harta)->kode;
        $attr['beban_tahun'] = $beban_tahun;
        $attr['nilai_buku'] = $nilai_buku;
        $attr['beban_bulan'] = $beban_bulan;
        $attr['kelompok'] = KelompokAktiva::find($request->kelompok);
        return view('admin.asset.print', [
            'attr' => $attr,
            'collection' => $collection
        ]);
    }
}
