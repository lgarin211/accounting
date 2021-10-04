<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use App\Models\Asset\KelompokAktiva;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function AssetKelompok($id)
    {
        $metode = KelompokAktiva::find($id);
        return response()->json($metode);
    }
    public function AssetKategori($value)
    {
        $kategori = Akun::where('kategori_asset', $value)->get();
        return response()->json($kategori);
    }
}
