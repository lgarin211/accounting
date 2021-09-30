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
}
