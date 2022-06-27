<?php

namespace Modules\Api\Berkas\Models;

use CodeIgniter\Database\ConnectionInterface;

class BerkasModel
{

    protected $db;

    private $builder;

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
        $this->builder = $this->db->table('berkas');
    }

    public function delete($id)
    {
        $this->builder
            ->where('id', $id)
            ->delete();
    }

    /**
     * Get by id
     * 
     * @param int $id
     * 
     * @param object
     */
    public function get(int $id)
    {
        return $this->builder
            ->where('id', $id)
            ->get()
            ->getRowObject();
    }

}