<?php

namespace Modules\Api\Pekerja\Models;

use CodeIgniter\Database\ConnectionInterface;

class PekerjaModel
{

    protected $db;

    private $builder;

    private $columnOrder = ['nama', 'tempat_lahir', 'tgl_lahir', 'alamat'];

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
        $this->builder = $this->db->table('pekerja');
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
        $this->builder->select('
            pekerja.id,
            pekerja.nik,
            pekerja.nama,
            pekerja.tempat_lahir,
            pekerja.tgl_lahir,
            CONCAT(pekerja.tempat_lahir, ", ", pekerja.tgl_lahir) as ttl,
            pekerja.alamat,
            lokasi_kerja.nama as lokasi_kerja,
            jenis_pekerja.nama as jenis_pekerja,
            pekerjaan.nama as pekerjaan,
            pekerja.created_at
        ');

        $this->builder->join('pekerjaan', 'pekerja.id_pekerjaan = pekerjaan.id', 'left');
        $this->builder->join('lokasi_kerja', 'pekerja.id_lokasi_kerja = lokasi_kerja.id', 'left');
        $this->builder->join('jenis_pekerja', 'pekerja.id_jenis_pekerja = jenis_pekerja.id', 'left');

        $this->builder->groupStart();
        $this->builder->like('pekerja.nik', $dtParams['search']['value']);
        $this->builder->orLike('pekerja.nama', $dtParams['search']['value']);
        $this->builder->orLike('pekerja.tempat_lahir', $dtParams['search']['value']);
        $this->builder->orLike('pekerja.tgl_lahir', $dtParams['search']['value']);
        $this->builder->orLike('pekerja.alamat', $dtParams['search']['value']);
        $this->builder->orLike('jenis_pekerja.nama', $dtParams['search']['value']);
        $this->builder->orLike('pekerjaan.nama', $dtParams['search']['value']);
        $this->builder->orLike('lokasi_kerja.nama', $dtParams['search']['value']);
        $this->builder->groupEnd();

        if (isset($dtParams['order'])) {
            $this->builder->orderBy($this->columnOrder[$dtParams['order']['0']['column']], $dtParams['order']['0']['dir']);
        }

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
            pekerja.id,
            pekerja.nik,
            pekerja.nama,
            pekerja.tempat_lahir,
            pekerja.tgl_lahir,
            CONCAT(pekerja.tempat_lahir, ", ", pekerja.tgl_lahir) as ttl,
            pekerja.alamat,
            lokasi_kerja.nama as lokasi_kerja,
            jenis_pekerja.nama as jenis_pekerja,
            pekerjaan.nama as pekerjaan,
            pekerja.created_at
        ');

        $this->builder->join('pekerjaan', 'pekerja.id_pekerjaan = pekerjaan.id', 'left');
        $this->builder->join('lokasi_kerja', 'pekerja.id_lokasi_kerja = lokasi_kerja.id', 'left');
        $this->builder->join('jenis_pekerja', 'pekerja.id_jenis_pekerja = jenis_pekerja.id', 'left');

        $this->builder->groupStart();
        $this->builder->like('pekerja.nik', $dtParams['search']['value']);
        $this->builder->orLike('pekerja.nama', $dtParams['search']['value']);
        $this->builder->orLike('pekerja.tempat_lahir', $dtParams['search']['value']);
        $this->builder->orLike('pekerja.tgl_lahir', $dtParams['search']['value']);
        $this->builder->orLike('pekerja.alamat', $dtParams['search']['value']);
        // $this->builder->orLike('domisili.nama', $dtParams['search']['value']);
        $this->builder->orLike('jenis_pekerja.nama', $dtParams['search']['value']);
        $this->builder->orLike('pekerjaan.nama', $dtParams['search']['value']);
        $this->builder->orLike('lokasi_kerja.nama', $dtParams['search']['value']);
        $this->builder->groupEnd();

        if (isset($dtParams['order'])) {
            $this->builder->orderBy($this->columnOrder[$dtParams['order']['0']['column']], $dtParams['order']['0']['dir']);
        }

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
     * get berkas by id_pekerja
     * 
     * @param int $id
     * 
     * @return array|object
     */
    public function getBerkas($id, $tipe = null)
    {
        $berkas = $this->db->table('berkas')
            ->where('id_pekerja', $id);
        if (!is_null($tipe)) {
            return $berkas->where('berkas_type_id', $tipe)
                ->get()
                ->getRowObject();
        }

        return $berkas->get()
            ->getResultObject();
    }

    /**
     * delete berkas by id_pekerja
     * 
     * @param int $id
     * 
     * @return void
     */
    public function deleteBerkas($id, $tipe = null) {
        $berkas = $this->db->table('berkas')
            ->where('id_pekerja', $id);
        
        if (!is_null($tipe)) {
            $berkas->where('tipe', $tipe)
                ->delete();
        }

        $berkas->delete();
    }
}
