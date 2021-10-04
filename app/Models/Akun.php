<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Akun extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('status', '=', '1');
    }

    public function scopeFindByCode($query, $code)
    {
        return $query->where('kode', $code)->first();
    }

    public static function getPossibleLevels()
    {
        $level = DB::select(DB::raw('SHOW COLUMNS FROM akuns WHERE Field = "level"'))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $level, $matches);
        $values = [];
        foreach (explode(',', $matches[1]) as $value) {
            $values[] = trim($value, "'");
        }

        return $values;
    }

    public function jurnalumumdetails()
    {
        return $this->hasMany(Jurnalumumdetail::class);
    }

    public function bkk()
    {
        return $this->hasMany(Bkk::class, 'rekening_id', 'id');
    }

    public function faktur_sales()
    {
        return $this->hasMany(\App\Models\Sale\FakturSale::class, 'akun_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'akun_id');
    }
    public function asset_harta()
    {
        return $this->hasMany(Asset::class, 'asset_harta');
    }
    public function akumulasi_depresiasi()
    {
        return $this->hasMany(Asset::class, 'akumulasi_depresiasi');
    }
    public function depresiasi()
    {
        return $this->hasMany(Asset::class, 'depresiasi');

    }
}
