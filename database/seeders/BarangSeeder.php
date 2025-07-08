<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Satuan;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('barangs')->insert([
            [
                'nama_barang' => 'Rautan Pensil',
                'satuan_id' => Satuan::where('nama_satuan', 'Lusin')->value('id'),
                'harga_beli' => 3000,
                'stok' => 1,
            ],
            [
                'nama_barang' => 'Double Tape (Hijau) tebal',
                'satuan_id' => Satuan::where('nama_satuan', 'Buah')->value('id'),
                'harga_beli' => 12430,
                'stok' => 1,
            ],
            [
                'nama_barang' => 'Trigonal Kecil',
                'satuan_id' => Satuan::where('nama_satuan', 'Gros')->value('id'),
                'harga_beli' => 20000,
                'stok' => 1,
            ],
            [
                'nama_barang' => 'Kertas HVS A4 SIDU 75 gram',
                'satuan_id' => Satuan::where('nama_satuan', 'Kotak')->value('id'),
                'harga_beli' => 250000,
                'stok' => 2,
            ],
            [
                'nama_barang' => 'Sticky Note',
                'satuan_id' => Satuan::where('nama_satuan', 'Bks')->value('id'),
                'harga_beli' => 13214,
                'stok' => 14,
            ],
            [
                'nama_barang' => 'Pulpen Kenko',
                'satuan_id' => Satuan::where('nama_satuan', 'Kotak')->value('id'),
                'harga_beli' => 40000,
                'stok' => 4,
            ],
        ]);
    }
}
