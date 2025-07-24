<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@bps.go.id',
            'nip' => '200110282024121003',
            'role' => 'admin',
            'password' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'User',
            'email' => 'user@bps.go.id',
            'nip' => '200110282024121003',
            'role' => 'pegawai',
            'password' => 'user',
        ]);

        $this->call([
            SatuanSeeder::class,
            UserSeeder::class,
            StatusSeeder::class,
            ReferensiSeeder::class,
            StokSeeder::class,
        ]);

    }
}
