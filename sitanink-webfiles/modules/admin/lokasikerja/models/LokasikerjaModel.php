<?php

namespace Modules\Admin\Lokasikerja\Models;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\ConnectionInterface;

class LokasikerjaModel
{

    protected $db;

    /**
     * @var BaseBuilder
     */
    private BaseBuilder $builder;

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
        $this->builder = $this
            ->db
            ->table('lokasi_kerja');
    }

    /**
     * Create new lokasi kerja
     * 
     * @param array $data
     * 
     * @return void
     */
    public function create(array $data)
    {
        $now = date('Y-m-d H:i:s');
        $data['created_at'] = $now;
        $data['updated_at'] = $now;
        $this->builder->insert($data);
    }

    /**
     * Get lokasi kerja by id
     * 
     * @param int $id
     * 
     * @return object|null
     */
    public function get(int $id) : ?object
    {
        return $this->builder
            ->where('id', $id)
            ->get()
            ->getRowObject();
    }

    /**
     * Update lokasi kerja by id
     * 
     * @param array $data
     * @param int $id
     * 
     * @return void
     */
    public function update(array $data, int $id)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->builder
            ->where('id', $id)
            ->update($data);
    }

    /**
     * Delete lokasi kerja by id
     * 
     * @param int $id
     * 
     * @return void
     */
    public function delete(int $id)
    {
        $this->builder
            ->where('id', $id)
            ->delete();
    }

    /**
     * Get all as select dropdown
     * 
     * @return array
     */
    public function getAllAsDropdown()
    {
        return $this
            ->builder
            ->select('
                id as value,
                nama as text
            ')
            ->get()
            ->getResultObject();
    }

    /**
     * Count total lokasi kerja
     * 
     * @return int
     */
    public function countTotal() : int
    {
        return $this
            ->builder
            ->countAllResults();
    }

}