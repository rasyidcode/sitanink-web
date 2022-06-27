<?php

namespace Modules\Api\Card\Models;

use CodeIgniter\Database\ConnectionInterface;

class CardModel
{

    protected $db;

    private $builder;

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
        $this->builder = $this->db->table('generated_cards');
    }

    /**
     * Get list with datatable params
     * 
     * @param array $dtParams
     * 
     * @return array|null
     */
    public function getData(array $dtParams): ?array
    {
        $this->builder->select('
            generated_cards.id,
            generated_cards.valid_until,
            generated_cards.id_berkas,
            pekerja.nama as card_owner,
            users.username as generated_by,
            generated_cards.created_at
        ');

        $this->builder->join('users', 'generated_cards.generated_by = users.id', 'left');
        $this->builder->join('berkas', 'generated_cards.id_berkas = berkas.id', 'left');
        $this->builder->join('pekerja', 'berkas.id_pekerja = pekerja.id', 'left');

        if (isset($dtParams['length']) && isset($dtParams['start'])) {
            if ($dtParams['length'] !== -1) {
                $this->builder->limit($dtParams['length'], $dtParams['start']);
            }
        }

        return $this->builder->get()
            ->getResultObject();
    }

    /**
     * count filtered data
     * 
     * @param array $dtParams
     * 
     * @return int|null
     */
    public function countFilteredData(array $dtParams): int
    {
        $this->builder->select('
            generated_cards.id,
            generated_cards.valid_until,
            generated_cards.id_berkas,
            pekerja.name as card_owner,
            users.username as generated_by,
            generated_cards.created_at
        ');

        $this->builder->join('users', 'generated_cards.generated_by = users.id', 'left');
        $this->builder->join('berkas', 'generated_cards.id_berkas = berkas.id', 'left');
        $this->builder->join('pekerja', 'berkas.id_pekerja = pekerja.id', 'left');
        
        if (isset($dtParams['length']) && isset($dtParams['start'])) {
            if ($dtParams['length'] !== -1) {
                $this->builder->limit($dtParams['length'], $dtParams['start']);
            }
        }

        return $this->builder->countAllResults();
    }

    /**
     * count total data
     * 
     * @param array $dt_params
     * 
     * @return int
     */
    public function countData(): int
    {
        return $this->builder->countAllResults();
    }

    /**
     * Get pas foto pekerja by id_pekerja
     * 
     * @param int $idPekerja
     * 
     * @return object
     */
    public function getPasFoto(int $idPekerja) : ?object
    {
        return $this->db
            ->table('pekerja')
            ->select('
                pekerja.id,
                pekerja.nik,
                pekerja.nama,
                lokasi_kerja.nama as lokasi_kerja,
                pekerja.alamat,
                pekerjaan.nama as pekerjaan,
                pekerja.tempat_lahir,
                pekerja.tgl_lahir,
                CONCAT(pekerja.tempat_lahir, ",", pekerja.tgl_lahir) as ttl,
                pekerja.qr_secret,
                berkas.path,
                berkas.filename
            ')
            ->join('berkas', 'berkas.id_pekerja = pekerja.id', 'left')
            ->join('lokasi_kerja', 'pekerja.id_lokasi_kerja = lokasi_kerja.id', 'left')
            ->join('pekerjaan', 'pekerja.id_pekerjaan = pekerjaan.id', 'left')
            ->where('berkas.berkas_type_id', 1)
            ->where('berkas.id_pekerja', $idPekerja)
            ->get()
            ->getRowObject();
    }

    /**
     * Insert new generated file
     * 
     * @param array $data
     * 
     * @return void
     */
    public function insert(array $data)
    {
        $this->builder
            ->insert($data);
    }

    /**
     * Update generated file
     * 
     * @param array $data
     * 
     * @return void
     */
    public function update(array $data)
    {
        $cardId = $data['card_id'];
        unset($data['card_id']);

        $this->builder
            ->where('id', $cardId)
            ->update($data);
    }

    /**
     * Get data by id
     * 
     * @param int $id
     * 
     * @return object|null
     */
    public function get(int $id) : ?object
    {
        return $this->builder
            ->select('
                generated_cards.id,
                berkas.path,
                berkas.filename,
                pekerja.nama as name
            ')
            ->join('berkas', 'generated_cards.id_berkas = berkas.id', 'left')
            ->join('pekerja', 'berkas.id_pekerja = pekerja.id', 'left')
            ->where('generated_cards.id', $id)
            ->get()
            ->getRowObject();
    }
}