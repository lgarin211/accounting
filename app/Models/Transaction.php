<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'transactions';

    public function akun()
    {
        return $this->belongsTo(Akun::class);
    }
}
