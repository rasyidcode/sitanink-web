<?php

namespace Modules\Admin\Pekerja\Models;

use CodeIgniter\Model;

class PekerjaModel extends Model
{

    private $columnOrder = [];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get pekerja list with datatable params
     * 
     * @param array $dtParams
     * 
     * @return array|null
     */
    public function getData(array $dtParams): ?array
    {
        $pekerja = $this->builder('pekerja');

        $pekerja->select('
            *,
            CONCAT(tempat_lahir, ", ", tgl_lahir) as ttl
        ');

        $pekerja->groupStart();
        $pekerja->like('nik', $dtParams['search']['value']);
        $pekerja->orLike('nama', $dtParams['search']['value']);
        $pekerja->orLike('tempat_lahir', $dtParams['search']['value']);
        $pekerja->orLike('tgl_lahir', $dtParams['search']['value']);
        $pekerja->orLike('alamat', $dtParams['search']['value']);
        $pekerja->orLike('jenis_pekerja', $dtParams['search']['value']);
        $pekerja->orLike('lokasi_kerja', $dtParams['search']['value']);
        $pekerja->groupEnd();

        if (isset($dtParams['order'])) {
            $pekerja->orderBy($this->columnOrder[$dtParams['order']['0']['column']], $dtParams['order']['0']['dir']);
        }

        if (isset($dtParams['length']) && isset($dtParams['start'])) {
            if ($dtParams['length'] !== -1) {
                $pekerja->limit($dtParams['length'], $dtParams['start']);
            }
        }

        return $pekerja->get()
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
        $pekerja = $this->builder('pekerja');

        $pekerja->groupStart();
        $pekerja->like('nik', $dtParams['search']['value']);
        $pekerja->orLike('nama', $dtParams['search']['value']);
        $pekerja->orLike('tempat_lahir', $dtParams['search']['value']);
        $pekerja->orLike('tgl_lahir', $dtParams['search']['value']);
        $pekerja->orLike('alamat', $dtParams['search']['value']);
        $pekerja->orLike('jenis_pekerja', $dtParams['search']['value']);
        $pekerja->orLike('lokasi_kerja', $dtParams['search']['value']);
        $pekerja->groupEnd();

        if (isset($dtParams['order'])) {
            $pekerja->orderBy($this->columnOrder[$dtParams['order']['0']['column']], $dtParams['order']['0']['dir']);
        }

        if (isset($dtParams['length']) && isset($dtParams['start'])) {
            if ($dtParams['length'] !== -1) {
                $pekerja->limit($dtParams['length'], $dtParams['start']);
            }
        }

        return $pekerja->countAllResults();
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
        return $this->builder('pekerja')
            ->countAllResults();
    }

    /**
     * Get list domisili
     * 
     * @return array
     */
    public function getListDomisili(): array
    {
        return $this->builder('pekerja')
            ->select('
                LOWER(domisili) as value,
                domisili as text
            ')
            ->distinct()
            ->get()
            ->getResultObject();
    }

    /**
     * Get list lokasi kerja
     * 
     * @return array
     */
    public function getListLokasiKerja(): array
    {
        return $this->builder('pekerja')
            ->select('
                LOWER(lokasi_kerja) as value,
                lokasi_kerja as text
            ')
            ->distinct()
            ->get()
            ->getResultObject();
    }

    /**
     * Get list pekerjaan
     * 
     * @return array
     */
    public function getListPekerjaan(): array
    {
        return $this->builder('pekerja')
            ->select('
                LOWER(pekerjaan) as value,
                pekerjaan as text
            ')
            ->distinct()
            ->get()
            ->getResultObject();
    }

    /**
     * Get list jenis_pekerja
     * 
     * @return array
     */
    public function getListJenisPekerja(): array
    {
        return $this->builder('pekerja')
            ->select('
                LOWER(jenis_pekerja) as value,
                jenis_pekerja as text
            ')
            ->distinct()
            ->get()
            ->getResultObject();
    }

    /**
     * Create new pekerja to review
     * 
     * @param array $data
     * 
     * @return int|string
     * 
     */
    public function insertToReview(array $data)
    {
        $this->builder('pekerja_temp')
            ->insert($data);

        return $this->db->insertID();
    }

    /**
     * Create new pekerja to review
     * 
     * @param array $data
     * 
     * @return int|string
     * 
     */
    public function insertBerkas(array $data)
    {
        $this->builder('berkas')
            ->insert($data);

        return $this->db->insertID();
    }

    /**
     * Insert new pekerja review berkas
     * 
     * @param array $data
     * 
     * @return void
     */
    public function insertReviewBerkas(array $data)
    {
        $this->builder('pekerja_temp_berkas')
            ->insertBatch($data);
    }

    /**
     * Get total data to review
     * 
     * @return int|null
     */
    public function getTotalDataToReview()
    {
        return $this->builder('pekerja_temp')
            ->where('deleted_at', null)
            ->countAllResults();
    }

    /**
     * Get pekerja by id
     * 
     * @param int $id
     * 
     * @return object|null
     */
    public function getPekerja(int $id): ?object
    {
        return $this->builder('pekerja')
            ->where('id', $id)
            ->get()
            ->getRowObject();
    }

    /**
     * Get pekerja
     * 
     * @param int $id
     * 
     * @return object|null
     */
    public function getPekerjaFull(int $id): ?object
    {
        return $this->builder('pekerja')
            ->select('
                *,
                CONCAT(tempat_lahir, ", ", tgl_lahir) as ttl
            ')
            ->where('id', $id)
            ->get()
            ->getRowObject();
    }

    /**
     * Get pekerja with berkas
     * 
     * @param int $id
     * 
     * @return object|null
     */
    public function getBerkasPekerja(int $id): array
    {
        return $this->builder('berkas')
            ->select('
                berkas.*
            ')
            ->join('pekerja_berkas', 'pekerja_berkas.id_berkas = berkas.id', 'left')
            ->where('pekerja_berkas.id_pekerja', $id)
            ->get()
            ->getResultObject();
    }

    /**
     * Delete pekerja by id
     * 
     * @param int $id
     * 
     * @return void
     */
    public function deletePekerja($id)
    {
        $this->db->disableForeignKeyChecks();
        $this->builder('pekerja')
            ->where('id', $id)
            ->delete();
        $this->db->enableForeignKeyChecks();
    }
}
