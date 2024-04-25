<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function index()
    {
        $produk = Produk::with('penjualan', 'detailPenjualans')->get();
        $title = 'Detail Penjualan';
        return view('layouts.detail', compact('title', 'produk'));
    }
    public function show($id)
    {
        $produk = Produk::with('penjualan', 'detailPenjualans.Penjualan.Pelanggan')->findOrFail($id);
        $title = 'Detail Penjualan';
        return view('layouts.detail-pembelian', compact('title', 'produk'));
    }

    //
}
