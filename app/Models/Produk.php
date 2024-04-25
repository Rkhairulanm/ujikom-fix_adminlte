<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $primaryKey = 'produk_id';

    public function penjualan()
    {
        return $this->belongsToMany(Penjualan::class, 'detailpenjualans', 'produk_id', 'penjualan_id');
    }

    public function detailPenjualans()
    {
        return $this->hasMany(DetailPenjualan::class, 'produk_id');
    }
}
