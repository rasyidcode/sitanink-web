<?php

namespace Modules\Admin\Berkas\Models;

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
     * update berkas by id
     * 
     * @param int $id
     * @param array $data
     * 
     * @return void
     */
    public function update(int $id, array $data)
    {
        $this->builder
            ->where('id', $id)
            ->update($data);
    }
}