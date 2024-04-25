<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\DetailPenjualan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PembelianController extends Controller
{
    public function index()
    {
        $produk = Produk::get();
        $title = 'Pembelian';
        return view('layouts.pembelian', compact('title', 'produk'));
    }
    public function create(Request $request)
    {
        $validates = $request->validate([
            'produk_id' => 'required|min:1',
        ]);
        $produkIds = $request->input('produk_id');

        $produk = Produk::whereIn('produk_id', $produkIds)->get();

        if ($produk->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada produk yang ditemukan.');
        }

        session(['produk_id' => $produkIds]);

        $title = 'Pembelian';
        return view('layouts.pembelian_lanjutan', compact('produk', 'title'));
    }

    public function store(Request $request)
    {
        $data_pelanggan = $request->input('nama_pelanggan');
        $alamat = $request->input('alamat');
        $notelpon = $request->input('notelpon');
        $produk_id = session('produk_id');
        // dd($produk_id);

        // Simpan data pelanggan
        $pelanggan = new Pelanggan;
        $pelanggan->nama_pelanggan = $data_pelanggan;
        $pelanggan->alamat = $alamat; // Simpan alamat
        $pelanggan->notelpon = $notelpon; // Simpan nomor telepon
        $pelanggan->save();

        $produk_ids = session('produk_id');
        if (!is_null($produk_ids)) {
            $total_harga = 0;

            foreach ($produk_ids as $produk_id) {
                $jumlah_produk = $request->input('jumlah_' . $produk_id);

                // Periksa apakah jumlah produk tidak null dan array
                if (!is_null($jumlah_produk) && is_array($jumlah_produk)) {
                    $produk = Produk::find($produk_id);

                    // Periksa apakah produk ditemukan
                    if ($produk) {
                        $harga = intval($produk->harga);
                        $subtotal = array_sum($jumlah_produk) * $harga;
                        $total_harga += $subtotal;
                    }
                }
            }

            $penjualan = new Penjualan;
            $penjualan->pelanggan_id = $pelanggan->pelanggan_id;
            $penjualan->tanggalpenjualan = now();
            $penjualan->totalharga = $total_harga;
            $penjualan->save();
        }
        $pembelianDetail = [];


        foreach ($produk_ids as $produk_id) {
            $produk = Produk::find($produk_id);
            $harga = intval($produk->harga);
            $jumlah_produk = $request->input('jumlah_' . $produk_id);
            foreach ($jumlah_produk as $jumlah) {
                $subtotal = $jumlah * $harga;
                $pembelianDetail[] = [
                    'produk' => $produk->nama_produk,
                    'jumlah' => $jumlah,
                    'harga' => $harga,
                    'subtotal' => $subtotal,
                ];
                $detail = new DetailPenjualan;
                $detail->petugas_id = Auth::user()->id;
                $detail->penjualan_id = $penjualan->penjualan_id;
                $detail->produk_id = $produk_id;
                $detail->jumlah = $jumlah;
                $detail->subtotal = $subtotal;
                $detail->bayar = $request->bayar;
                $detail->struk = 'INV-' . Carbon::now()->format('Ymd') . '-' . $penjualan->id; // Format nomor struk
                $detail->save();

                if ($produk) {
                    Session::flash('status', 'success');
                    Session::flash('message', 'Produk berhasil dibeli.');
                }
            }
        }
        // $pembelianDetail = [
        //     'produk' => $produk->nama_produk,
        //     'jumlah' => $jumlah_produk,
        //     'harga' => $harga,
        //     'subtotal' => $subtotal,
        // ];
        $title = 'Struk';
        $bayar = $detail->bayar;
        $totalHargaKeseluruhan = $total_harga;
        $kembalian = $detail->bayar - $total_harga;
        $currentTime = Carbon::now()->format('Ymd');
        $noStruk = $detail->struk;
        $petugasName = Auth::user()->name;

        return view('layouts.struk', compact('title', 'bayar', 'totalHargaKeseluruhan', 'currentTime', 'noStruk', 'petugasName', 'data_pelanggan', 'pembelianDetail', 'kembalian'));
    }
}
