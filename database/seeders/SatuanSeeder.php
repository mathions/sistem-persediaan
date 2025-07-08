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
            'Gros',
            'Bks',
            'Pcs',
            'Botol',
            'Kotak',
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
