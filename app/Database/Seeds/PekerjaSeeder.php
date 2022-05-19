<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PekerjaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nik'           => '7202190801012009',
                'nama'          => 'Joko Widodo',
                'tempat_lahir'  => 'jokowidodo@sitanink.com',
                'tgl_lahir'     => '1978-09-09',
                'alamat'        => 'Jl. Slamet Riyadi No.261, Sriwedari, Kec. Laweyan, Kota Surakarta, Jawa Tengah 57141',
                'domisili'      => 'Jakarta',
                'pekerjaan'     => 'Presiden',
                'lokasi_kerja'  => 'Jakarta',
                'jenis_pekerja' => 'Presiden',
                'foto'          => 'uploads/foto-pekerja/jokowi.jpg',
            ],
            [
                'nik'           => '7202190801012002',
                'nama'          => 'Ghozali Everyday',
                'tempat_lahir'  => 'ghozali-everyday@sitanink.com',
                'tgl_lahir'     => '1998-09-09',
                'alamat'        => 'Jl. Lodan Timur No.7, RW.10, Ancol, Kec. Pademangan, Kota Jkt Utara, Daerah Khusus Ibukota Jakarta 14430',
                'domisili'      => 'Kalimantan',
                'pekerjaan'     => 'Content Creator',
                'lokasi_kerja'  => 'Kalimantan',
                'jenis_pekerja' => 'Content Creator',
                'foto'          => 'uploads/foto-pekerja/ghozali.jpg',
            ],
        ];

        $this->db->table('pekerja')
            ->insertBatch($data);
    }
}
