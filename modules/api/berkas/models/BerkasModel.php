<?php

namespace Modules\Api\Berkas\Models;

use CodeIgniter\Database\ConnectionInterface;

class BerkasModel
{

    protected $db;

    private $builder;

    public function __construct(ConnectionInterface &$db)
    {
        $this->db       = &$db;
        $this->builder  = $this
            ->db
            ->table('berkas');
    }

    public function delete($id)
    {
        $this
            ->builder
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
        return $this
            ->builder
            ->where('id', $id)
            ->get()
            ->getRowObject();
    }

    /**
     * Get by id_pekerja
     * 
     * @param int $idPekerja
     * 
     * @param object
     */
    public function getByPekerjaId(int $idPekerja)
    {

    }

    /**
     * Get by id_pekerja and berkas_type_id
     * 
     * @param int $idPekerja
     * @param int $berkasTypeId
     * 
     * @return object
     */
    public function getByPekerjaAndType(int $idPekerja, int $berkasTypeId)
    {
        return $this
            ->builder
            ->where('id_pekerja', $idPekerja)
            ->where('berkas_type_id', $berkasTypeId)
            ->get()
            ->getRowObject();
    }

    /**
     * Delete by id_pekerja and berkas_type_id
     * 
     * @param int $idPekerja
     * @param int $berkasTypeId
     * 
     * @return void
     */
    public function deleteByPekerjaAndType(int $idPekerja, int $berkasTypeId)
    {
        $this
            ->builder
            ->where('id_pekerja', $idPekerja)
            ->where('berkas_type_id', $berkasTypeId)
            ->delete();
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

}