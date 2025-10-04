<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BerkasTypeSeeder extends Seeder
{
    public function run()
    {
        $this
            ->db
            ->table('berkas_types')
            ->insertBatch([
                ['name' => 'Foto'],
                ['name' => 'Kartu Tanda Penduduk'],
                ['name' => 'Kartu Keluarga'],
                ['name' => 'Surat Permohonan Ijin Usaha'],
                ['name' => 'Surat Pernyataan'],
                ['name' => 'Kartu Pekerja'],
                ['name' => 'Surat Kerja'],
            ]);
    }
}
