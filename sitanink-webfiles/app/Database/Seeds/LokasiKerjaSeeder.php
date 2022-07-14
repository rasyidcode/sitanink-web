<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LokasiKerjaSeeder extends Seeder
{
    public function run()
    {
        $this
            ->db
            ->table('lokasi_kerja')
            ->insertBatch([
                ['nama' => 'Yogyakarta',    'lon' => 110.35767867410678, 'lat' => -7.791600008324188],
                ['nama' => 'Palu',          'lon' => 119.89377161896019, 'lat' => -0.8801872421238066],
                ['nama' => 'Klaten',        'lon' => 110.65993777686806, 'lat' => -7.714719048097784],
                ['nama' => 'Bandung',       'lon' => 107.60830973481205, 'lat' => -6.906004417428799],
                ['nama' => 'Jakarta',       'lon' => 106.8089163923531, 'lat' => -6.193563325343597],
            ]);
    }
}
