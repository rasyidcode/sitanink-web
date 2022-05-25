<?php

namespace Modules\Admin\Pekerja\Models;

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
    public function insertMedias(array $medias)
    {
        $this->builder('pekerja_media')
            ->insertBatch($medias);
    }

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
                pekerja_temp.*,
                CONCAT(pekerja_temp.tempat_lahir, ", ", pekerja_temp.tgl_lahir) as ttl
            ')
            ->join('pekerja_temp_berkas', 'pekerja_temp_berkas.id_pekerja_temp = pekerja_temp.id', 'left')
            ->join('berkas', 'berkas.id = pekerja_temp_berkas.id_berkas', 'left')
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
}
