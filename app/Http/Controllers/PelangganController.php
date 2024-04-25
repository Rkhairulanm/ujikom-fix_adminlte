<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::with('penjualan.detailPenjualans')->get();
        $title = 'Kelola Pelanggan';
        return view('layouts.pelanggan', compact('pelanggan', 'title'));
    }

    public function show($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $title = 'Detail Pelanggan';
        return view('layouts.detail_pelanggan', compact('pelanggan', 'title'));
    }
    //
}
