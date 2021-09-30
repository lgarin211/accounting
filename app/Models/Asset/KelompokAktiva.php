<?php

namespace App\Models\Asset;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokAktiva extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeSearch($query, $terms)
    {
        return $query->where('nama', 'like', "%{$terms}%")
            ->orWhere('umur', 'like', "%{$terms}%")
            ->orWhere('metode', 'like', "%{$terms}%");
    }
    public function asset()
    {
        return $this->hasMany(Asset::class, 'kelompok_id');
    }
}
