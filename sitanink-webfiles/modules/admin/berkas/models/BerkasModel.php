<?php

namespace Modules\Admin\Berkas\Models;

use CodeIgniter\Database\ConnectionInterface;

class BerkasModel
{

    protected $db;

    /**
     * @var BaseBuilder
     */
    private $builder;

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
        $this->builder = $this
            ->db
            ->table('berkas');
    }

    /**
     * Create new berkas
     * 
     * @param array $data
     * @param bool $returnId
     * 
     * @return int|null
     */
    public function create(array $data, bool $returnId = false) : ?int
    {
        $this
            ->builder
            ->insert($data);
        
        if ($returnId) {
            $row = $this
                ->db
                ->query('SELECT LAST_INSERT_ID() as last_id')
                ->getRowObject() ?? 0;

            return $row
                ->last_id ?? 0;
        }

        return null;
    }

    /**
     * Delete berkas by id
     */
    public function delete($id)
    {
        $this
            ->builder
            ->where('id', $id)
            ->delete();
    }

    /**
     * Update berkas by id
     * 
     * @param int $id
     * @param array $data
     * 
     * @return void
     */
    public function update(int $id, array $data)
    {
        $this
            ->builder
            ->where('id', $id)
            ->update($data);
    }

    
    /**
     * Get berkas by id_pekerja
     * 
     * @param int $pekerjaId
     * 
     * @return array
     */
    public function getByPekerjaId(int $pekerjaId): array
    {
        return $this
            ->db
            ->table('berkas')
            ->where('id_pekerja', $pekerjaId)
            ->get()
            ->getResultObject();
    }

    /**
     * Get berkas by id_pekerja and berkas_type_id
     * 
     * @param int $pekerjaId
     * @param int $berkasTypeId
     * 
     * @return object|null
     */
    public function getByPekerjaIdWithTypeId(int $pekerjaId, int $berkasTypeId): ?object
    {
        return $this
            ->db
            ->table('berkas')
            ->where('id_pekerja', $pekerjaId)
            ->where('berkas_type_id', $berkasTypeId)
            ->get()
            ->getRowObject();
    }
}