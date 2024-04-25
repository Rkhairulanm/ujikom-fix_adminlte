<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::orderBy('produk_id', 'DESC')->paginate(10);
        $title = 'Kelola Produk';
        return view('layouts.produk', compact('produk', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Kelola Produk';
        return view('layouts.produk-tambah', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        // Proses upload gambar
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambarName = Str::slug($request->nama_produk) . '-' . Carbon::now()->format('Ymd') . '.' . $gambar->getClientOriginalExtension();

            // Simpan gambar ke dalam folder public/images (buat folder 'images' jika belum ada)
            $gambar->move(public_path('images'), $gambarName);

            $data['gambar'] = $gambarName;
        }

        $produk = Produk::create($data);

        if ($produk) {
            Session::flash('status', 'success');
            Session::flash('message', 'Produk berhasil ditambahkan.');
            return redirect('/produk'); // Redirect ke halaman index produk setelah menambahkan produk baru
        } else {
            Session::flash('status', 'danger');
            Session::flash('message', 'Gagal menambahkan produk.');
            return redirect()->back()->withInput(); // Kembali ke halaman sebelumnya dengan input yang diisi sebelumnya
        }
    }


    /**
     * Display the specified resource.
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $title = 'Kelola Produk';
        return view('layouts.edit-produk', compact('title', 'produk'));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $produk = Produk::findOrFail($id);

        // Proses upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambarName = Carbon::now()->format('Ymd') . '.' . $gambar->getClientOriginalExtension();

            // Simpan gambar ke dalam folder public/images (buat folder 'images' jika belum ada)
            $gambar->move(public_path('images'), $gambarName);

            // Hapus gambar lama jika ada

            // Perbarui nama gambar dalam data yang akan diupdate
            $produk->gambar = $gambarName;
        }

        $produk->update($request->except(['_token', '_method', 'gambar'])); // Ambil semua data kecuali token, method, dan gambar

        // if ($produk->gambar && file_exists(public_path('images/' . $produk->gambar))) {
        //     unlink(public_path('images/' . $produk->gambar));
        // }
        if ($produk) {
            Session::flash('status', 'info');
            Session::flash('message', 'Produk berhasil diubah.');
        }
        return redirect('/produk');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();
        $title = 'Kelola Produk';

        if ($produk) {
            Session::flash('status', 'success');
            Session::flash('message', 'Produk berhasil dihapus.');
        }
        return redirect('/produk');
    }
}
