<?php

namespace Modules\Api\Pekerja\Models;

use CodeIgniter\Database\ConnectionInterface;

class PekerjaModel
{

    protected $db;

    private $builder;

    private $columnSearch = [
        null,
        'pekerja.nik',
        'pekerja.nama',
        'pekerja.tempat_lahir',
        'pekerja.tgl_lahir',
        'pekerja.alamat',
        'pekerja.pekerjaan',
        'lokasi_kerja.nama',
        'jenis_pekerja.nama',
        null,
        null
    ];

    private $columnOrder = [
        null,
        'pekerja.nik',
        'pekerja.nama',
        'pekerja.tempat_lahir',
        'pekerja.tgl_lahir',
        'pekerja.alamat',
        'pekerja.pekerjaan',
        'lokasi_kerja.nama',
        'jenis_pekerja.nama',
        'pekerja.created_at',
        null
    ];

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
        $this->builder = $this
            ->db
            ->table('pekerja');
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
        $this
            ->builder
            ->select('
                pekerja.*,
                CONCAT(pekerja.tempat_lahir, ", ", pekerja.tgl_lahir) as ttl,
                lokasi_kerja.nama as lokasi_kerja,
                jenis_pekerja.nama as jenis_pekerja,
            ')
            ->join('lokasi_kerja', 'pekerja.id_lokasi_kerja = lokasi_kerja.id', 'left')
            ->join('jenis_pekerja', 'pekerja.id_jenis_pekerja = jenis_pekerja.id', 'left');

        if (!empty($dtParams['search']['value'])) {
            $this
                ->builder
                ->groupStart();
            foreach ($this->columnSearch as $index => $columnItem) {
                if (!is_null($columnItem)) {
                    if ($index == 0) {
                        $this
                            ->builder
                            ->like($columnItem, $dtParams['search']['value']);
                    } else {
                        $this
                            ->builder
                            ->orLike($columnItem, $dtParams['search']['value']);
                    }
                }
            }
            $this
                ->builder
                ->groupEnd();
        }


        if (isset($dtParams['order'])) {
            $this
                ->builder
                ->orderBy(
                    $this->columnOrder[$dtParams['order']['0']['column']],
                    $dtParams['order']['0']['dir']
                );
        }

        if (isset($dtParams['length']) && isset($dtParams['start'])) {
            if ($dtParams['length'] !== -1) {
                $this
                    ->builder
                    ->limit(
                        $dtParams['length'],
                        $dtParams['start']
                    );
            }
        }

        return $this
            ->builder
            ->get()
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
        $this
            ->builder
            ->select('
                pekerja.*,
                CONCAT(pekerja.tempat_lahir, ", ", pekerja.tgl_lahir) as ttl,
                lokasi_kerja.nama as lokasi_kerja,
                jenis_pekerja.nama as jenis_pekerja,
            ')
            ->join('lokasi_kerja', 'pekerja.id_lokasi_kerja = lokasi_kerja.id', 'left')
            ->join('jenis_pekerja', 'pekerja.id_jenis_pekerja = jenis_pekerja.id', 'left');

        if (!empty($dtParams['search']['value'])) {
            $this
                ->builder
                ->groupStart();
            foreach ($this->columnSearch as $index => $columnItem) {
                if (!is_null($columnItem)) {
                    if ($index == 0) {
                        $this
                            ->builder
                            ->like($columnItem, $dtParams['search']['value']);
                    } else {
                        $this
                            ->builder
                            ->orLike($columnItem, $dtParams['search']['value']);
                    }
                }
            }
            $this
                ->builder
                ->groupEnd();
        }

        if (isset($dtParams['order'])) {
            $this
                ->builder
                ->orderBy(
                    $this->columnOrder[$dtParams['order']['0']['column']],
                    $dtParams['order']['0']['dir']
                );
        }

        if (isset($dtParams['length']) && isset($dtParams['start'])) {
            if ($dtParams['length'] !== -1) {
                $this->builder->limit($dtParams['length'], $dtParams['start']);
            }
        }

        return $this
            ->builder
            ->countAllResults();
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
        return $this
            ->builder
            ->countAllResults();
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
     * Get pekerja by id, with lokasi_kerja, tipe_pekerja, and berkas
     * 
     * @param int $id
     * 
     * @return object|null
     */
    public function getDetailWithBerkas(int $id, int $berkasTypeFotoId): ?object
    {
        return $this
            ->builder
            ->select('
                pekerja.*,
                CONCAT(pekerja.tempat_lahir, ", ", pekerja.tgl_lahir) as ttl,
                lokasi_kerja.nama as lokasi_kerja,
                jenis_pekerja.nama as jenis_pekerja,
                berkas.filename,
                berkas.path
            ')
            ->join('lokasi_kerja', 'pekerja.id_lokasi_kerja = lokasi_kerja.id', 'left')
            ->join('jenis_pekerja', 'pekerja.id_jenis_pekerja = jenis_pekerja.id', 'left')
            ->join('berkas', 'pekerja.id = berkas.id_pekerja', 'left')
            ->where('pekerja.id', $id)
            ->where('berkas.berkas_type_id', $berkasTypeFotoId)
            ->get()
            ->getRowObject();
    }
}
