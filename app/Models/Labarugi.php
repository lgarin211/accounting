<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Labarugi extends Model
{
    use HasFactory;
    
    protected $table = 'labarugi';
    protected $guarded = [];

    public function akun()
    {
        return $this->belongsTo(Akun::class);
    }
}
