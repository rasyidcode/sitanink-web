<?php

namespace Modules\Admin\Kartu\Models;

use CodeIgniter\Database\ConnectionInterface;

class KartuModel
{

    protected $db;

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
    }

    public function getPekerjaNoCard()
    {
        return $this->db->table('pekerja')
            ->select('
                id, nama
            ')
            ->where("id NOT IN (
                SELECT id_pekerja FROM berkas WHERE berkas_type_id IN (
                        SELECT id FROM berkas_types WHERE name LIKE '%Kartu Pekerja%'
                    ) AND id_pekerja is NOT NULL
                )")
            ->get()
            ->getResultObject();
    }

}