<?php

namespace App\Models\Sale;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenawaranSale extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pelanggan()
    {
        return $this->belongsTo(\App\Models\Kontak::class);
    }
}
