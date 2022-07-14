<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JenisPekerjaSeeder extends Seeder
{
    public function run()
    {
        $this
            ->db
            ->table('jenis_pekerja')
            ->insertBatch([
                ['nama' => 'Petani'],
                ['nama' => 'Penderes'],
                ['nama' => 'Pekerja Koprasi'],
                ['nama' => 'Pembelanjaan Kantin Permisan']
            ]);
    }
}
