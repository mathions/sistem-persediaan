<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Satuan;

class ReferensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('Referensis')->insert([
            [
                'nama_barang' => 'Rautan Pensil',
                'satuan_id' => Satuan::where('nama_satuan', 'Lusin')->value('id'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'Double Tape (Hijau) tebal',
                'satuan_id' => Satuan::where('nama_satuan', 'Buah')->value('id'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'Trigonal Kecil',
                'satuan_id' => Satuan::where('nama_satuan', 'Lusin')->value('id'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'Kertas HVS A4 SIDU 75 gram',
                'satuan_id' => Satuan::where('nama_satuan', 'Rim')->value('id'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'Sticky Note',
                'satuan_id' => Satuan::where('nama_satuan', 'Bks')->value('id'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_barang' => 'Pulpen Kenko',
                'satuan_id' => Satuan::where('nama_satuan', 'Kotak')->value('id'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
