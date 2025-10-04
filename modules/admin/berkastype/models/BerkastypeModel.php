<?php

namespace Modules\Admin\Berkastype\Models;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\ConnectionInterface;

class BerkastypeModel
{

    protected $db;

    /**
     * @var BaseBuilder
     */
    private BaseBuilder $builder;

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
        $this->builder = $this->db->table('berkas_types');
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

}