<?php

namespace App\Models\Sale;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakturSaleDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function faktur()
    {
        return $this->belongsTo(FakturSale::class, 'faktur_id');
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }
}
