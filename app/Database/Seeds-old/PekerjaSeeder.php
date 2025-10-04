<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PekerjaSeeder extends Seeder
{
    public function run()
    {
        $pekerja = [
            [
                'nik'               => '1234567891234511',
                'nama'              => 'Test 1',
                'tempat_lahir'      => 'Palu',
                'tgl_lahir'         => '1990-08-10',
                'alamat'            => 'Jln. Test 1',
                'id_pekerjaan'      => $this->getRandomPekerjaanID(),
                'id_lokasi_kerja'   => $this->getRandomLokasiPekerjaID(),
                'id_jenis_pekerja'  => $this->getRandomJenisPekerjaID(),
            ],
            [
                'nik'               => '1234567891234512',
                'nama'              => 'Test 2',
                'tempat_lahir'      => 'Yogyakarta',
                'tgl_lahir'         => '1994-03-24',
                'alamat'            => 'Jln. Test 2',
                'id_pekerjaan'      => $this->getRandomPekerjaanID(),
                'id_lokasi_kerja'   => $this->getRandomLokasiPekerjaID(),
                'id_jenis_pekerja'  => $this->getRandomJenisPekerjaID(),
            ],
            [
                'nik'               => '1234567891234513',
                'nama'              => 'Test 3',
                'tempat_lahir'      => 'Maluku',
                'tgl_lahir'         => '1998-01-20',
                'alamat'            => 'Jln. Test 3',
                'id_pekerjaan'      => $this->getRandomPekerjaanID(),
                'id_lokasi_kerja'   => $this->getRandomLokasiPekerjaID(),
                'id_jenis_pekerja'  => $this->getRandomJenisPekerjaID(),
            ],
            [
                'nik'               => '1234567891234514',
                'nama'              => 'Test 4',
                'tempat_lahir'      => 'Aceh',
                'tgl_lahir'         => '1998-02-14',
                'alamat'            => 'Jln. Test 4',
                'id_pekerjaan'      => $this->getRandomPekerjaanID(),
                'id_lokasi_kerja'   => $this->getRandomLokasiPekerjaID(),
                'id_jenis_pekerja'  => $this->getRandomJenisPekerjaID(),
            ],
            [
                'nik'               => '1234567891234515',
                'nama'              => 'Test 5',
                'tempat_lahir'      => 'Manado',
                'tgl_lahir'         => '1997-08-12',
                'alamat'            => 'Jln. Test 5',
                'id_pekerjaan'      => $this->getRandomPekerjaanID(),
                'id_lokasi_kerja'   => $this->getRandomLokasiPekerjaID(),
                'id_jenis_pekerja'  => $this->getRandomJenisPekerjaID(),
            ],
        ];

        $this->db
            ->table('pekerja')
            ->insertBatch($pekerja);
    }

    private function getRandomJenisPekerjaID()
    {
        $data = $this->db
            ->table('jenis_pekerja')
            ->select('id')
            ->get()
            ->getResultObject();
        
        return $data[random_int(0, count($data) - 1)]->id;
    }

    private function getRandomLokasiPekerjaID()
    {
        $data = $this->db
            ->table('lokasi_kerja')
            ->select('id')
            ->get()
            ->getResultObject();
        
        return $data[random_int(0, count($data) - 1)]->id;
    }

    private function getRandomPekerjaanID()
    {
        $data = $this->db
            ->table('pekerjaan')
            ->select('id')
            ->get()
            ->getResultObject();
        
        return $data[random_int(0, count($data) - 1)]->id;
    }
}
