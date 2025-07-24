<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Referensi;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('Stoks')->insert([
            [
                'referensi_id' => Referensi::where('nama_barang', 'Rautan Pensil')->value('id'),
                'harga_beli' => 24000, // per lusin
                'volume' => 22,
                'total' => 528000, // 24000 * 22
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'referensi_id' => Referensi::where('nama_barang', 'Double Tape (Hijau) tebal')->value('id'),
                'harga_beli' => 6000,
                'volume' => 25,
                'total' => 150000, // 6000 * 25
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'referensi_id' => Referensi::where('nama_barang', 'Trigonal Kecil')->value('id'),
                'harga_beli' => 12000,
                'volume' => 20,
                'total' => 240000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'referensi_id' => Referensi::where('nama_barang', 'Kertas HVS A4 SIDU 75 gram')->value('id'),
                'harga_beli' => 55000,
                'volume' => 30,
                'total' => 1650000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'referensi_id' => Referensi::where('nama_barang', 'Sticky Note')->value('id'),
                'harga_beli' => 9000,
                'volume' => 26,
                'total' => 234000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'referensi_id' => Referensi::where('nama_barang', 'Pulpen Kenko')->value('id'),
                'harga_beli' => 27000,
                'volume' => 24,
                'total' => 648000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
