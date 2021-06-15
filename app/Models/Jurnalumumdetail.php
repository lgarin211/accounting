<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnalumumdetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function jurnalumum()
    {
        return $this->belongsTo(Jurnalumum::class);
    }
}
