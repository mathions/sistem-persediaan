<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pegawaiList = [
            ['name' => 'Darma Beriman Telaumbanua, SE, MM', 'email' => 'darmabt@bps.go.id'],
            ['name' => 'Karya Jaya Zendrato, SST, M.SE.', 'email' => 'karya.zendrato@bps.go.id'],
            ['name' => 'Agus Mardin Zai', 'email' => 'agus.mardin@bps.go.id'],
            ['name' => 'Anotona Nazara', 'email' => 'anotona@bps.go.id'],
            ['name' => 'Duta Saniskara, S.Tr.Stat.', 'email' => 'duta.saniskara@bps.go.id'],
            ['name' => 'Elisaro Perdamaian Baeha, S.Tr.Stat.', 'email' => 'elisaro.baeha@bps.go.id'],
            ['name' => 'Elvis Purnama Zega, S.E.', 'email' => 'elvis@bps.go.id'],
            ['name' => 'Imran Machdani Zega', 'email' => 'imran.zega@bps.go.id'],
            ['name' => 'Krisna Yanuar, S.Tr.Stat.', 'email' => 'krisna.yanuar@bps.go.id'],
            ['name' => 'Margaret Janice Waruwu, SE', 'email' => 'janice@bps.go.id'],
            ['name' => 'Marsweet Karunia Gulo, SST', 'email' => 'marsweet@bps.go.id'],
            ['name' => 'Nur Hidayat, S.Tr.Stat.', 'email' => 'nur.hidayat@bps.go.id'],
            ['name' => 'Purim Kharisman Hulu, S.Tr.Stat.', 'email' => 'purim.hulu@bps.go.id'],
            ['name' => 'Roni Candra Lase, A.Md', 'email' => 'roni.lase@bps.go.id'],
            ['name' => 'Supriadi Hia, SST, M.Stat', 'email' => 'supriadi.hia@bps.go.id'],
        ];

        foreach ($pegawaiList as $pegawai) {
            User::factory()->create([
                'name' => $pegawai['name'],
                'email' => $pegawai['email'],
                'role' => 'pegawai',
                'password' => '123456',
            ]);
        }
    }
}
