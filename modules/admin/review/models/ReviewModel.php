<?php

namespace Modules\Admin\Review\Models;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Insert new medias
     * 
     * @param array $medias
     * 
     * @return void
     */
    // public function insertMedias(array $medias)
    // {
    //     $this->builder('pekerja_media')
    //         ->insertBatch($medias);
    // }

    /**
     * Get one
     * 
     * @param int $id
     * 
     * @return object|null
     */
    public function getOne(int $id): ?object
    {
        return $this->builder('pekerja_temp')
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
    public function getPekerja(int $id): ?object
    {
        return $this->builder('pekerja_temp')
            ->select('
                pekerja_temp.id,
                pekerja_temp.nik,
                pekerja_temp.nama,
                pekerja_temp.tempat_lahir,
                pekerja_temp.tgl_lahir,
                CONCAT(pekerja_temp.tempat_lahir, ", ", pekerja_temp.tgl_lahir) as ttl,
                pekerja_temp.alamat,
                domisili.nama as domisili,
                pekerjaan.nama as pekerjaan,
                lokasi_kerja.nama as lokasi_kerja,
                jenis_pekerja.nama as jenis_pekerja,
                pekerja_temp.created_at,
                pekerja_temp.deleted_at
            ')
            ->join('domisili', 'pekerja_temp.id_domisili = domisili.id', 'left')
            ->join('lokasi_kerja', 'pekerja_temp.id_lokasi_kerja = lokasi_kerja.id', 'left')
            ->join('pekerjaan', 'pekerja_temp.id_pekerjaan = pekerjaan.id', 'left')
            ->join('jenis_pekerja', 'pekerja_temp.id_jenis_pekerja = jenis_pekerja.id', 'left')
            ->where('pekerja_temp.id', $id)
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
            ->join('pekerja_temp_berkas', 'pekerja_temp_berkas.id_berkas = berkas.id', 'left')
            ->where('pekerja_temp_berkas.id_pekerja_temp', $id)
            ->get()
            ->getResultObject();
    }

    /**
     * Get data review
     * 
     * @return array|null
     */
    public function getData() : array
    {
        return $this->builder('pekerja_temp')
            ->select('
                id,
                nama,
                nik,
                IF(deleted_at IS NULL,"pending","cancel") as status,
                created_at,
                deleted_at
            ')
            ->get()
            ->getResultObject();
    }

    /**
     * Insert to pekerja table
     * 
     * @param array $data
     * 
     * @return mixed
     */
    public function insertNew(array $data)
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
    public function insertBerkas(array $data)
    {
        $this->builder('pekerja_berkas')
            ->insertBatch($data);
    }

    /**
     * Get berkas pekerja_temp ids by id_pekerja_temp
     * 
     * @param int $id
     * 
     * @return array|null
     */
    public function getBerkasPekerjaTemp($id) : array
    {
        return $this->builder('pekerja_temp_berkas')
            ->select('id, id_berkas')
            ->where('id_pekerja_temp', $id)
            ->get()
            ->getResultObject();
    }

    /**
     * Remove pekerja_temp by id
     * 
     * @param int $id
     * 
     * @return void
     */
    public function removePekerjaTemp(int $id)
    {
        $this->builder('pekerja_temp')
            ->where('id', $id)
            ->delete();
    }

    /**
     * Remove pekerja_temp_berkas by ids
     * 
     * @param array $id
     * 
     * @return void
     */
    public function removePekerjaBerkasTemp(array $ids)
    {
        $this->builder('pekerja_temp_berkas')
            ->whereIn('id', $ids)
            ->delete();
    }

    /**
     * Remove pekerja_temp by softdelete
     * 
     * @param array $id
     * 
     * @return void
     */
    public function removePekerjaTempSd(int $id)
    {
        $this->builder('pekerja_temp')
            ->where('id', $id)
            ->update([
                'deleted_at'    => date('Y-m-d H:i:s')
            ]);
    }
}
