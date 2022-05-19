<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PekerjaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nik'           => 'admin',
                'nama'          => '',
                'tempat_lahir'  => 'admin@sitanink.com',
                'tgl_lahir'     => 'admin',
                'alamat'        => 'admin',
                'domisili'      => 'admin',
                'pekerjaan'     => 'admin',
                'lokasi_kerja'  => 'admin',
                'jenis_pekerja' => 'admin',
                'foto'          => 'admin',
            ],
            [
                'username'  => 'lapas1',
                'password'  => password_hash('12345', PASSWORD_BCRYPT),
                'email'     => 'lapas1@sitanink.com',
                'level'     => 'reguler',
            ],
            [
                'username'  => 'lapas2',
                'password'  => password_hash('12345', PASSWORD_BCRYPT),
                'email'     => 'lapas2@sitanink.com',
                'level'     => 'reguler',
            ],
        ];

        $this->db->table('users')
            ->insertBatch($data);
    }
}
