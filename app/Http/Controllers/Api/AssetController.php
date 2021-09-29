<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asset\KelompokAktiva;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function AssetKelompok($id)
    {
        $metode = KelompokAktiva::find($id);
        return response()->json($metode);
    }
}
