<?php

namespace Modules\Admin\Pekerja\Models;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\ConnectionInterface;

class PekerjaModel
{
    protected $db;

    /**
     * @var BaseBuilder
     */
    private BaseBuilder $builder;

    public function __construct(ConnectionInterface &$db)
    {
        $this->db       = &$db;
        $this->builder  = $this
            ->db
            ->table('pekerja');
    }

    /**
     * Create pekerja
     * 
     * @param array $data
     * @param bool $returnId
     * 
     * @return int|null
     * 
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
     * Get pekerja by id
     * 
     * @param int $id
     * 
     * @return object|null
     */
    public function get(int $id): ?object
    {
        return $this
            ->builder
            ->where('id', $id)
            ->get()
            ->getRowObject();
    }


    /**
     * update pekerja by id
     * 
     * @param array $data
     * 
     * @return void
     */
    public function update(int $id, array $data)
    {
        $this
            ->db
            ->table('pekerja')
            ->where('id', $id)
            ->update($data);
    }

    /**
     * Delete pekerja by id
     * 
     * @param int $id
     * 
     * @return void
     */
    public function delete($id)
    {
        $this
            ->builder
            ->where('id', $id)
            ->delete();
    }

    /**
     * Get pekerja by id, with lokasi_kerja and tipe_pekerja type
     * 
     * @param int $id
     * 
     * @return object|null
     */
    public function getDetail(int $id): ?object
    {
        return $this
            ->builder
            ->select('
                pekerja.*,
                CONCAT(pekerja.tempat_lahir, ", ", pekerja.tgl_lahir) as ttl,
                lokasi_kerja.nama as lokasi_kerja,
                jenis_pekerja.nama as jenis_pekerja
            ')
            ->join('lokasi_kerja', 'pekerja.id_lokasi_kerja = lokasi_kerja.id', 'left')
            ->join('jenis_pekerja', 'pekerja.id_jenis_pekerja = jenis_pekerja.id', 'left')
            ->where('pekerja.id', $id)
            ->get()
            ->getRowObject();
    }
    
    /**
     * Get pekerja by id, with lokasi_kerja, tipe_pekerja, and berkas_foto
     * 
     * @param int $id
     * 
     * @return object|null
     */
    public function getDetailWithBerkas(int $id, int $berkasTypeId): ?object
    {
        return $this
            ->builder
            ->select('
                pekerja.*,
                CONCAT(pekerja.tempat_lahir, ", ", pekerja.tgl_lahir) as ttl,
                lokasi_kerja.nama as lokasi_kerja,
                jenis_pekerja.nama as jenis_pekerja,
                berkas.filename as foto_filename
            ')
            ->join('lokasi_kerja', 'pekerja.id_lokasi_kerja = lokasi_kerja.id', 'left')
            ->join('jenis_pekerja', 'pekerja.id_jenis_pekerja = jenis_pekerja.id', 'left')
            ->join('berkas', 'pekerja.id = berkas.id_pekerja', 'left')
            ->where('pekerja.id', $id)
            ->where('berkas.berkas_type_id', $berkasTypeId)
            ->get()
            ->getRowObject();
    }

    /**
     * Get list pekerja to export
     * 
     * @return array
     */
    public function getExportList() : array
    {
        return $this
            ->builder
            ->select('
                pekerja.*,
                lokasi_kerja.nama as lokasi_kerja,
                jenis_pekerja.nama as jenis_pekerja
            ')
            ->join('lokasi_kerja', 'pekerja.id_lokasi_kerja = lokasi_kerja.id', 'left')
            ->join('jenis_pekerja', 'pekerja.id_jenis_pekerja = jenis_pekerja.id', 'left')
            ->get()
            ->getResultObject();
    }
    
    /**
     * Get list pekerja for sk dropdown
     * 
     * @return array
     */
    public function getListPekerjaForSK()
    {
        return $this
            ->builder
            ->select('
                pekerja.id,
                pekerja.nama,
                pekerja.nik
            ')
            ->get()
            ->getResultObject();
    }

    /**
     * Get list pekerja by ids as sk attachments
     * 
     * @param array $ids
     * 
     * @return array
     */
    public function getListPekerjaAsAttachments(array $ids) : array
    {
        return $this
            ->builder
            ->select('
                pekerja.nik,
                pekerja.nama,
                pekerja.tempat_lahir,
                pekerja.tgl_lahir,
                pekerja.alamat,
                pekerja.pekerjaan,
                jenis_pekerja.nama as jenis_pekerja,
                lokasi_kerja.nama as lokasi_kerja,
            ')
            ->join('lokasi_kerja', 'pekerja.id_lokasi_kerja = lokasi_kerja.id', 'left')
            ->join('jenis_pekerja', 'pekerja.id_jenis_pekerja = jenis_pekerja.id', 'left')
            ->whereIn('pekerja.id', $ids)
            ->get()
            ->getResultObject();
    }

    /**
     * Count total pekerja
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