<?php

namespace Modules\Api\Wilayah\Models;

use CodeIgniter\Database\ConnectionInterface;

class WilayahModel
{

    protected $db;

    private $columnOrder = [];

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
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
        $lokasi = $this->db->table('lokasi_kerja');

        $lokasi->select('
            lokasi_kerja.id,
            lokasi_kerja.nama,
            lokasi_kerja.lon,
            lokasi_kerja.lat,
            lokasi_kerja.created_at,
            count(pekerja.id) as total_pekerja,
        ');

        $lokasi->join('pekerja', 'lokasi_kerja.id = pekerja.id_lokasi_kerja', 'left');

        $lokasi->groupStart();
        $lokasi->like('lokasi_kerja.nama', $dtParams['search']['value']);
        $lokasi->groupEnd();

        if (isset($dtParams['order'])) {
            $lokasi->orderBy($this->columnOrder[$dtParams['order']['0']['column']], $dtParams['order']['0']['dir']);
        }

        if (isset($dtParams['length']) && isset($dtParams['start'])) {
            if ($dtParams['length'] !== -1) {
                $lokasi->limit($dtParams['length'], $dtParams['start']);
            }
        }

        $lokasi->groupBy('pekerja.id_lokasi_kerja');

        return $lokasi->get()
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
        $lokasi = $this->db->table('lokasi_kerja');

        $lokasi->select('
            lokasi_kerja.id,
            lokasi_kerja.nama,
            lokasi_kerja.lon,
            lokasi_kerja.lat,
            lokasi_kerja.created_at,
            count(pekerja.id) as total_pekerja,
        ');

        $lokasi->join('pekerja', 'lokasi_kerja.id = pekerja.id_lokasi_kerja', 'left');

        $lokasi->groupStart();
        $lokasi->like('lokasi_kerja.nama', $dtParams['search']['value']);
        $lokasi->groupEnd();

        if (isset($dtParams['order'])) {
            $lokasi->orderBy($this->columnOrder[$dtParams['order']['0']['column']], $dtParams['order']['0']['dir']);
        }

        if (isset($dtParams['length']) && isset($dtParams['start'])) {
            if ($dtParams['length'] !== -1) {
                $lokasi->limit($dtParams['length'], $dtParams['start']);
            }
        }

        $lokasi->groupBy('pekerja.id_lokasi_kerja');

        return $lokasi->countAllResults();
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
        return $this->db
            ->table('lokasi_kerja')
            ->countAllResults();
    }

    /**
     * list of pekerja by id_lokasi_kerja
     * 
     * @param int $idLokasiKerja
     * 
     * @return array
     */
    public function getListPekerja(int $idLokasiKerja)
    {
        return $this->db
            ->table('pekerja')
            ->select('
                pekerja.nik,
                pekerja.nama,
                jenis_pekerja.nama as jenis_pekerja
            ')
            ->join('jenis_pekerja', 'pekerja.id_jenis_pekerja = jenis_pekerja.id', 'left')
            ->where('id_lokasi_kerja', $idLokasiKerja)
            ->get()
            ->getResultObject();
    }
}
