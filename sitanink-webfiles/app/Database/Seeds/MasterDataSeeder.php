<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run()
    {
        // lokasi kerja
        $this->db->table('lokasi_kerja')
            ->insertBatch([
                [
                    'nama'  => 'Jakarta',
                    'lon'   => -6.20336262411038,
                    'lat'   => 106.76374510054606,
                ],
                [
                    'nama'  => 'Karang Tengah',
                    'lon'   => -6.893941586752559,
                    'lat'   => 110.51547340170778
                ],
                [
                    'nama'  => 'Yogyakarta',
                    'lon'   => -7.795256638156904,
                    'lat'   => 110.36008193310285
                ]
            ]);
        // pekerjaan
        $this->db->table('pekerjaan')
            ->insertBatch([
                ['nama'  => 'Wiraswasta'],
                ['nama'  => 'PNS'],
            ]);
        // jenis pekerja
        $this->db->table('jenis_pekerja')
            ->insertBatch([
                ['nama'  => 'Petani'],
                ['nama'  => 'Penderes'],
                ['nama'  => 'Pekerja Koprasi'],
                ['nama'  => 'Pembelanjaan Kantin Permisan'],
            ]);
        // domisili
        // $this->db->table('domisili')
        //     ->insertBatch([
        //         ['nama'  => 'Lapas Terbuka'],
        //         ['nama'  => 'Lapas Permisan'],
        //         ['nama'  => 'Nirbaya'],
        //         ['nama'  => 'Lapas Kelas 1 Batu'],
        //         ['nama'  => 'Lapas Kembangkuning'],
        //     ]);
    }
}
