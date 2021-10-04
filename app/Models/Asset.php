<?php

namespace App\Models;

use App\Models\Asset\KelompokAktiva;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function kelompok()
    {
        return $this->belongsTo(KelompokAktiva::class, 'kelompok_id');
    }
    public function akun_asset_harta()
    {
        return $this->belongsTo(Akun::class, 'asset_harta');
    }
    public function akun_akumulasi_depresiasi()
    {
        return $this->belongsTo(Akun::class, 'akumulasi_depresiasi');
    }
    public function akun_depresiasi()
    {
        return $this->belongsTo(Akun::class, 'depresiasi');
    }
}
