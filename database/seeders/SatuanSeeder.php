<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $satuans = [
            'Lusin',
            'Buah',
            'Rim',
            'Gros',
            'Bks',
            'Pcs',
            'Botol',
            'Kotak',
            'Dokumen',
            'Kotak Besar',
        ];

        foreach ($satuans as $satuan) {
            DB::table('satuans')->insert([
                'nama_satuan' => $satuan,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
