<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produk = [
            [
                'nama_produk' => 'Margarin',
                'harga' => '20000',
                'stok' => '33',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'Susu',
                'harga' => '43000',
                'stok' => '33',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'Chiki',
                'harga' => '12000',
                'stok' => '33',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'Kecap',
                'harga' => '20000',
                'stok' => '33',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'Mie',
                'harga' => '33000',
                'stok' => '33',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'Saos',
                'harga' => '22400',
                'stok' => '33',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'Sosis',
                'harga' => '20000',
                'stok' => '33',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Produk::insert($produk);
    }
}
