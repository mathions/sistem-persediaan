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
            ['name' => 'Darma Beriman Telaumbanua, SE, MM', 'email' => 'darmabt@bps.go.id', 'nip' => '197810182001121003'],
            ['name' => 'Karya Jaya Zendrato, SST, M.SE.', 'email' => 'karya.zendrato@bps.go.id', 'nip' => '199206082014121001'],
            ['name' => 'Agus Mardin Zai', 'email' => 'agus.mardin@bps.go.id', 'nip' => '198508172010031002'],
            ['name' => 'Anotona Nazara', 'email' => 'anotona@bps.go.id', 'nip' => '197102221999101001'],
            ['name' => 'Duta Saniskara, S.Tr.Stat.', 'email' => 'duta.saniskara@bps.go.id', 'nip' => '200110282024121003'],
            ['name' => 'Elisaro Perdamaian Baeha, S.Tr.Stat.', 'email' => 'elisaro.baeha@bps.go.id', 'nip' => '200106232023101002'],
            ['name' => 'Elvis Purnama Zega, S.E.', 'email' => 'elvis@bps.go.id', 'nip' => '198611022008011002'],
            ['name' => 'Imran Machdani Zega', 'email' => 'imran.zega@bps.go.id', 'nip' => '199304272014121001'],
            ['name' => 'Krisna Yanuar, S.Tr.Stat.', 'email' => 'krisna.yanuar@bps.go.id', 'nip' => '200110142023101001'],
            ['name' => 'Margaret Janice Waruwu, SE', 'email' => 'janice@bps.go.id', 'nip' => '198808292014122013'],
            ['name' => 'Marsweet Karunia Gulo, SST', 'email' => 'marsweet@bps.go.id', 'nip' => '199310271602201001'],
            ['name' => 'Nur Hidayat, S.Tr.Stat.', 'email' => 'nur.hidayat@bps.go.id', 'nip' => '200106292023101002'],
            ['name' => 'Purim Kharisman Hulu, S.Tr.Stat.', 'email' => 'purim.hulu@bps.go.id', 'nip' => '200307232023101002'],
            ['name' => 'Roni Candra Lase, A.Md', 'email' => 'roni.lase@bps.go.id', 'nip' => '198207272007101001'],
            ['name' => 'Supriadi Hia, SST, M.Stat', 'email' => 'supriadi.hia@bps.go.id', 'nip' => '199310292016021001'],
        ];


        foreach ($pegawaiList as $pegawai) {
            User::factory()->create([
                'name' => $pegawai['name'],
                'email' => $pegawai['email'],
                'nip' => $pegawai['nip'],
                'role' => 'pegawai',
                'password' => '123456',
            ]);
        }
    }
}
