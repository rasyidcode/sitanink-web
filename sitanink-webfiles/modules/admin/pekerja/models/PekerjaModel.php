<?php

namespace Modules\Admin\Pekerja\Models;

use CodeIgniter\Model;

class PekerjaModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get list domisili
     * 
     * @return array
     */
    // public function getListDomisili(): array
    // {
    //     return $this->builder('pekerja')
    //         ->select('
    //             LOWER(domisili) as value,
    //             domisili as text
    //         ')
    //         ->distinct()
    //         ->get()
    //         ->getResultObject();
    // }

    /**
     * Get list lokasi kerja
     * 
     * @return array
     */
    // public function getListLokasiKerja(): array
    // {
    //     return $this->builder('pekerja')
    //         ->select('
    //             LOWER(lokasi_kerja) as value,
    //             lokasi_kerja as text
    //         ')
    //         ->distinct()
    //         ->get()
    //         ->getResultObject();
    // }

    /**
     * Get list pekerjaan
     * 
     * @return array
     */
    // public function getListPekerjaan(): array
    // {
    //     return $this->builder('pekerja')
    //         ->select('
    //             LOWER(pekerjaan) as value,
    //             pekerjaan as text
    //         ')
    //         ->distinct()
    //         ->get()
    //         ->getResultObject();
    // }

    /**
     * Get list jenis_pekerja
     * 
     * @return array
     */
    // public function getListJenisPekerja(): array
    // {
    //     return $this->builder('pekerja')
    //         ->select('
    //             LOWER(jenis_pekerja) as value,
    //             jenis_pekerja as text
    //         ')
    //         ->distinct()
    //         ->get()
    //         ->getResultObject();
    // }

    /**
     * Create new pekerja to review
     * 
     * @param array $data
     * 
     * @return int|string
     * 
     */
    // public function insertToReview(array $data)
    // {
    //     $this->builder('pekerja_temp')
    //         ->insert($data);

    //     return $this->db->insertID();
    // }

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
     * Create new pekerja
     * 
     * @param array $data
     * 
     * @return int|string
     * 
     */
    public function insertPekerja(array $data)
    {
        $this->builder('pekerja')
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
    // public function insertReviewBerkas(array $data)
    // {
    //     $this->builder('pekerja_temp_berkas')
    //         ->insertBatch($data);
    // }

    /**
     * Get total data to review
     * 
     * @return int|null
     */
    // public function getTotalDataToReview()
    // {
    //     return $this->builder('pekerja_temp')
    //         ->where('deleted_at', null)
    //         ->countAllResults();
    // }

    /**
     * Get pekerja by id
     * 
     * @param int $id
     * 
     * @return object|null
     */
    public function getPekerja(int $id, $withFoto = false): ?object
    {
        $select = '
            pekerja.id,
            pekerja.nik,
            pekerja.nama,
            pekerja.alamat,
            pekerja.tempat_lahir,
            pekerja.tgl_lahir,
            pekerja.id_pekerjaan,
            pekerja.id_lokasi_kerja,
            pekerja.id_jenis_pekerja,
            CONCAT(pekerja.tempat_lahir, ", ", pekerja.tgl_lahir) as ttl,
            pekerjaan.nama as pekerjaan,
            lokasi_kerja.nama as lokasi_kerja,
            jenis_pekerja.nama as jenis_pekerja
        ';
        
        if ($withFoto) {
            $select .= ',berkas.filename as foto';
        }

        $pekerja = $this->builder('pekerja')
            ->select($select)
            ->join('lokasi_kerja', 'pekerja.id_lokasi_kerja = lokasi_kerja.id', 'left')
            ->join('pekerjaan', 'pekerja.id_pekerjaan = pekerjaan.id', 'left')
            ->join('jenis_pekerja', 'pekerja.id_jenis_pekerja = jenis_pekerja.id', 'left');
        
        if ($withFoto) {
           $pekerja->join('berkas', 'pekerja.id = berkas.id_pekerja', 'left') ;
        }

        $pekerja->where('pekerja.id', $id);
        
        if ($withFoto) {
            $pekerja->where('berkas.berkas_type_id', 1);
        }
        
        return $pekerja->get()
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
            pekerja.id,
            pekerja.nik,
            pekerja.nama,
            pekerja.tempat_lahir,
            pekerja.tgl_lahir,
                CONCAT(pekerja.tempat_lahir, ", ", pekerja.tgl_lahir) as ttl,
                pekerja.alamat,
                domisili.nama as domisili,
                pekerjaan.nama as pekerjaan,
                lokasi_kerja.nama as lokasi_kerja,
                jenis_pekerja.nama as jenis_pekerja,
                pekerja.created_at,
                pekerja.updated_at
            ')
            ->join('domisili', 'pekerja.id_domisili = domisili.id', 'left')
            ->join('lokasi_kerja', 'pekerja.id_lokasi_kerja = lokasi_kerja.id', 'left')
            ->join('pekerjaan', 'pekerja.id_pekerjaan = pekerjaan.id', 'left')
            ->join('jenis_pekerja', 'pekerja.id_jenis_pekerja = jenis_pekerja.id', 'left')
            ->where('pekerja.id', $id)
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

    /**
     * Get dropdown data
     * 
     * @return array
     */
    public function getDropdownData()
    {
        $lokasiKerja = $this->db->table('lokasi_kerja')
            ->select('
                id as value,
                nama as text
            ')
            ->get()
            ->getResultObject();
        $pekerjaan = $this->db->table('pekerjaan')
            ->select('
                id as value,
                nama as text
            ')
            ->get()
            ->getResultObject();
        // $domisili = $this->db->table('domisili')
        //     ->select('
        //         id as value,
        //         nama as text
        //     ')
        //     ->get()
        //     ->getResultObject();
        $jenisPekerja = $this->db->table('jenis_pekerja')
            ->select('
                id as value,
                nama as text
            ')
            ->get()
            ->getResultObject();
        return [
            'lokasi_kerja'  => $lokasiKerja,
            'pekerjaan' => $pekerjaan,
            // 'domisili'  => $domisili,
            'jenis_pekerja' => $jenisPekerja
        ];
    }

    /**
     * get berkas by id
     * 
     * @param int $id
     * @param string $tipe
     * 
     * @return array|object
     */
    public function getBerkas($id, $tipe = null)
    {
        $berkas = $this->db->table('berkas')
            ->where('id_pekerja', $id);
        
        if (!is_null($berkas)) {
            return $berkas->where('berkas_type_id', $tipe)
                ->get()
                ->getRowObject();
        }

        return $berkas->get()
            ->getResultObject();
    }

    /**
     * update pekerja by id
     * 
     * @param array $data
     * 
     */
    public function updatePekerja(int $id, array $data)
    {
        $this->db->table('pekerja')
            ->where('id', $id)
            ->update($data);
    }

    /**
     * get berkas by id_pekerja
     * 
     * @param int $id
     * 
     * @return array|object
     */
}
