<?php

namespace Modules\Pub\Showdata\Models;

use CodeIgniter\Model;

class ShowdataModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * get data pekerja by qr_secret
     * 
     * @param string $qrSecret
     * 
     * @return object|null
     */
    public function getDataPekerja(string $qrSecret): ?object
    {
        return $this->builder('pekerja')
            ->select('
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
                jenis_pekerja.nama as jenis_pekerja,
                berkas.filename as foto
            ')
            ->join('lokasi_kerja', 'pekerja.id_lokasi_kerja = lokasi_kerja.id', 'left')
            ->join('pekerjaan', 'pekerja.id_pekerjaan = pekerjaan.id', 'left')
            ->join('jenis_pekerja', 'pekerja.id_jenis_pekerja = jenis_pekerja.id', 'left')
            ->join('berkas', 'pekerja.id = berkas.id_pekerja', 'left')
            ->where('pekerja.qr_secret', $qrSecret)
            ->get()
            ->getRowObject();
    }
    
}