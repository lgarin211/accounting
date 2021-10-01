<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use App\Models\Asset;
use App\Models\Asset\KelompokAktiva;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Validator;
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
        return view('admin.asset.index', [
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
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'kelompok_id' => 'required',
            'tanggal_beli' => 'required',
            'harga_beli' => 'required',
            'nilai_residu' => 'required',
            'umur_ekonomis' => 'required',
            'lokasi' => 'required',
            'departemen' => 'required',
            'terhitung_tanggal' => 'required',
            'asset_harta' => 'required',
            'akumulasi_depresiasi' => 'required',
            'depresiasi' => 'required',
        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return redirect('/admin/data-store/asset')->with('error', implode(' | ', $message));
        }
        try {
            Asset::create($request->except(['_token']));
            return redirect('/admin/data-store/asset')->with('success', 'Success Store Data Asset');
        } catch (Exception $th) {
            return redirect('/admin/data-store/asset')->with('error', $th);
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
        $asset = Asset::findOrFail($id);
        $harga_beli =  str_replace(',', '', $asset->harga_beli);
        //DATE NGAB
        $tanggal_beli = $asset->tanggal_beli;
        $terhitung_tanggal = $asset->terhitung_tanggal;

        $selisih = Carbon::parse($tanggal_beli)->diffInMonths($terhitung_tanggal);

        $beban_tahun = $harga_beli / $asset->umur_ekonomis;

        $beban_bulan = $beban_tahun / 12;

        $akumulasi_beban = $beban_bulan * $selisih;

        $nilai_buku = $harga_beli - $akumulasi_beban;


        $collection = new Collection();

        $bulan = (int)Carbon::parse($asset->tanggal_beli)->format('m');

        $hasil = $asset->umur_ekonomis * 12;

        for ($i = 0; $i < $hasil; $i++) {
            $collection->push((object)[
                'tanggal' => Carbon::parse($asset->tanggal_beli)->addMonths($i)->endOfMonth()->format('Y-m-d'),
                'akumulasi_penyusutan' => Akun::find($asset->akumulasi_depresiasi)->kode,
                'penyusutan_bulanan' => $beban_bulan,
                'nilai_buku' => $harga_beli -= $beban_bulan
            ]);
        }

        // dd($asset->all());
        $carbon = Carbon::parse($asset->tanggal_beli)->addYear($asset->umur_ekonomis)->format('Y-m-d');
        // dd($carbon, $asset->umur_ekonomis, $collection);
        $attr['harga_beli'] = str_replace(',', '', $asset->harga_beli);
        $attr['nilai_residu'] = str_replace(',', '', $asset->nilai_residu);
        $attr['akumulasi_beban'] = Akun::find($asset->asset_harta)->kode;
        $attr['beban_tahun'] = $beban_tahun;
        $attr['nilai_buku'] = $nilai_buku;
        $attr['beban_bulan'] = $beban_bulan;
        $attr['kelompok'] = KelompokAktiva::find($asset->kelompok_id);
        $attr['asset_harta'] = $asset->asset_harta;
        $attr['akumulasi_depresiasi'] = $asset->akumulasi_depresiasi;
        $attr['depresiasi'] = $asset->depresiasi;
        $attr['umur_ekonomis'] = $asset->umur_ekonomis;
        $attr['nama'] = $asset->nama;
        $attr['tanggal_beli'] = $asset->tanggal_beli;
        $attr['lokasi'] = $asset->lokasi;
        $attr['metode'] = $asset->kelompok->metode;
        $attr['departemen'] = $asset->departemen;
        $attr['terhitung_tanggal'] = $asset->terhitung_tanggal;
        $attr['btn_asset_harta'] = Akun::find($asset->asset_harta);
        $attr['btn_akumulasi_depresiasi'] = Akun::find($asset->akumulasi_depresiasi);
        $attr['btn_depresiasi'] = Akun::find($asset->depresiasi);
        return view('admin.asset.show', [
            'attr' => $attr,
            'collection' => $collection
        ]);
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
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'kelompok_id' => 'required',
            'tanggal_beli' => 'required',
            'harga_beli' => 'required',
            'nilai_residu' => 'required',
            'umur_ekonomis' => 'required',
            'lokasi' => 'required',
            'departemen' => 'required',
            'terhitung_tanggal' => 'required',
            'asset_harta' => 'required',
            'akumulasi_depresiasi' => 'required',
            'depresiasi' => 'required',
        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return redirect('/admin/data-store/asset')->with('error', implode(' | ', $message));
        }
        try {
            Asset::where('id', $id)->update($request->except(['_token','_method']));
            return redirect('/admin/data-store/asset')->with('success', 'Success Update Data Asset');
        } catch (Exception $th) {
            return redirect('/admin/data-store/asset')->with('error', $th);
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
        Asset::findOrFail($id)->delete();
        return back()->with('success', 'Success Delete Data Asset');
    }
    public function print_store(Request $request)
    {
        $this->validate($request, [
            "nama" => 'required',
            "kelompok" => "required",
            "tanggal_beli" => 'required',
            "harga_beli" => 'required',
            "nilai_residu" => 'required',
            "umur_ekonomis" => 'required',
            'terhitung_tanggal' => 'required',
            'departemen' => 'required',
            "metode" => 'required',
            'lokasi' => 'required',
            'asset_harta' => 'required',
            'akumulasi_depresiasi' => 'required',
            'depresiasi' => 'required'
        ]);

        $harga_beli =  str_replace(',', '', $request->harga_beli);

        //DATE NGAB
        $tanggal_beli = $request->tanggal_beli;
        $terhitung_tanggal = $request->terhitung_tanggal;

        $selisih = Carbon::parse($tanggal_beli)->diffInMonths($terhitung_tanggal);
        if ($request->umur_ekonomis == 0) {
            $beban_tahun = $harga_beli;
        } else {
            $beban_tahun = $harga_beli / $request->umur_ekonomis;
        }

        $beban_bulan = $beban_tahun / 12;

        $akumulasi_beban = $beban_bulan * $selisih;

        $nilai_buku = $harga_beli - $akumulasi_beban;


        $collection = new Collection();
        $attr = $request->all();

        $bulan = (int)Carbon::parse($request->tanggal_beli)->format('m');

        $hasil = $request->umur_ekonomis * 12;

        for ($i = 0; $i < $hasil; $i++) {
            $collection->push((object)[
                'tanggal' => Carbon::parse($request->tanggal_beli)->addMonths($i)->endOfMonth()->format('Y-m-d'),
                'akumulasi_penyusutan' => Akun::find($request->akumulasi_depresiasi)->kode,
                'penyusutan_bulanan' => $beban_bulan,
                'nilai_buku' => $harga_beli -= $beban_bulan
            ]);
        }

        // dd($request->all());
        $carbon = Carbon::parse($attr['tanggal_beli'])->addYear($attr['umur_ekonomis'])->format('Y-m-d');
        // dd($carbon, $request->umur_ekonomis, $collection);
        $attr['harga_beli'] = str_replace(',', '', $request->harga_beli);
        $attr['nilai_residu'] = str_replace(',', '', $request->nilai_residu);
        $attr['akumulasi_beban'] = Akun::find($request->asset_harta)->kode;
        $attr['beban_tahun'] = $beban_tahun;
        $attr['nilai_buku'] = $nilai_buku;
        $attr['beban_bulan'] = $beban_bulan;
        $attr['kelompok'] = KelompokAktiva::find($request->kelompok);
        $attr['asset_harta'] = $request->asset_harta;
        $attr['akumulasi_depresiasi'] = $request->akumulasi_depresiasi;
        $attr['depresiasi'] = $request->depresiasi;

        $attr['btn_asset_harta'] = Akun::find($request->asset_harta);
        $attr['btn_akumulasi_depresiasi'] = Akun::find($request->akumulasi_depresiasi);
        $attr['btn_depresiasi'] = Akun::find($request->depresiasi);
        return view('admin.asset.print_store', [
            'attr' => $attr,
            'collection' => $collection
        ]);
    }
    public function print_update(Request $request, $id)
    {
        $this->validate($request, [
            "nama" => 'required',
            "kelompok" => "required",
            "tanggal_beli" => 'required',
            "harga_beli" => 'required',
            "nilai_residu" => 'required',
            "umur_ekonomis" => 'required',
            'terhitung_tanggal' => 'required',
            'departemen' => 'required',
            "metode" => 'required',
            'lokasi' => 'required',
            'asset_harta' => 'required',
            'akumulasi_depresiasi' => 'required',
            'depresiasi' => 'required'
        ]);
        $asset = Asset::findOrFail($id);
        $harga_beli =  str_replace(',', '', $request->harga_beli);

        //DATE NGAB
        $tanggal_beli = $request->tanggal_beli;
        $terhitung_tanggal = $request->terhitung_tanggal;

        $selisih = Carbon::parse($tanggal_beli)->diffInMonths($terhitung_tanggal);
        if ($request->umur_ekonomis == 0) {
            $beban_tahun = $harga_beli;
        } else {
            $beban_tahun = $harga_beli / $request->umur_ekonomis;
        }

        $beban_bulan = $beban_tahun / 12;

        $akumulasi_beban = $beban_bulan * $selisih;

        $nilai_buku = $harga_beli - $akumulasi_beban;


        $collection = new Collection();
        $attr = $request->all();

        $bulan = (int)Carbon::parse($request->tanggal_beli)->format('m');

        $hasil = $request->umur_ekonomis * 12;

        for ($i = 0; $i < $hasil; $i++) {
            $collection->push((object)[
                'tanggal' => Carbon::parse($request->tanggal_beli)->addMonths($i)->endOfMonth()->format('Y-m-d'),
                'akumulasi_penyusutan' => Akun::find($request->akumulasi_depresiasi)->kode,
                'penyusutan_bulanan' => $beban_bulan,
                'nilai_buku' => $harga_beli -= $beban_bulan
            ]);
        }

        // dd($request->all());
        $carbon = Carbon::parse($attr['tanggal_beli'])->addYear($attr['umur_ekonomis'])->format('Y-m-d');
        // dd($carbon, $request->umur_ekonomis, $collection);
        $attr['harga_beli'] = str_replace(',', '', $request->harga_beli);
        $attr['nilai_residu'] = str_replace(',', '', $request->nilai_residu);
        $attr['akumulasi_beban'] = Akun::find($request->asset_harta)->kode;
        $attr['beban_tahun'] = $beban_tahun;
        $attr['nilai_buku'] = $nilai_buku;
        $attr['beban_bulan'] = $beban_bulan;
        $attr['kelompok'] = KelompokAktiva::find($request->kelompok);
        $attr['asset_harta'] = $request->asset_harta;
        $attr['akumulasi_depresiasi'] = $request->akumulasi_depresiasi;
        $attr['depresiasi'] = $request->depresiasi;

        $attr['btn_asset_harta'] = Akun::find($request->asset_harta);
        $attr['btn_akumulasi_depresiasi'] = Akun::find($request->akumulasi_depresiasi);
        $attr['btn_depresiasi'] = Akun::find($request->depresiasi);
        return view('admin.asset.print_update', [
            'attr' => $attr,
            'collection' => $collection,
            'asset' => $asset
        ]);
    }
}
