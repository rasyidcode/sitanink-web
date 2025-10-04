<?php

namespace Modules\Admin\Wilayah\Models;

use CodeIgniter\Database\ConnectionInterface;

class WilayahModel
{

    protected $db;

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
    }

    public function getList()
    {
        $data = $this->db
            ->table('lokasi_kerja')
            ->select('
                lokasi_kerja.id,
                lokasi_kerja.nama,
                lokasi_kerja.lon,
                lokasi_kerja.lat,
                lokasi_kerja.created_at,
                count(pekerja.id) as total_pekerja,
            ')
            ->join('pekerja', 'lokasi_kerja.id = pekerja.id_lokasi_kerja', 'left')
            ->groupBy('pekerja.id_lokasi_kerja')
            ->get()
            ->getResultObject();

        return $data;
    }
}
