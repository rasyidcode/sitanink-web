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

    /**
     * Get card by id
     * 
     * @param int $id
     * 
     * @return object|null
     */
    public function get(int $id)
    {
        return $this->db
            ->table('generated_cards')
            ->select('
                generated_cards.id,
                generated_cards.valid_until,
                pekerja.id as id_pekerja,
                pekerja.nama as name,
                generated_cards.id_berkas,
                berkas.path,
                berkas.filename
            ')
            ->join('berkas', 'generated_cards.id_berkas = berkas.id', 'left')
            ->join('pekerja', 'berkas.id_pekerja = pekerja.id', 'left')
            ->where('generated_cards.id', $id)
            ->get()
            ->getRowObject();
    }

    /**
     * Delete generated card by id
     * 
     * @param int $id
     * 
     * @return void
     */
    public function delete(int $id)
    {
        return $this->db
            ->table('generated_cards')
            ->where('id', $id)
            ->delete();
    }

    /**
     * Get berkas by id
     * 
     * @param int $id
     * 
     * @return object|null
     */
    public function getBerkas(int $id) : ?object
    {
        return $this->db
            ->table('berkas')
            ->where('id', $id)
            ->get()
            ->getRowObject();
    }

    /**
     * Delete berkas by id
     * 
     * @param int $id
     * 
     * @return void
     */
    public function deleteBerkas(int $id)
    {
        return $this->db
            ->table('berkas')
            ->where('id', $id)
            ->delete();
    }

}