<?php

namespace Modules\Api\Qrcode\Models;

use CodeIgniter\Database\ConnectionInterface;

class QrcodeModel
{

    protected $db;

    private $columnOrder = ['nik', 'nama'];

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
        $pekerja = $this->db->table('pekerja');

        $pekerja->select('
            pekerja.id,
            pekerja.nik,
            pekerja.nama,
            pekerja.qr_secret
        ');

        $pekerja->groupStart();
        $pekerja->like('pekerja.nik', $dtParams['search']['value']);
        $pekerja->like('pekerja.nama', $dtParams['search']['value']);
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
        $pekerja = $this->db->table('pekerja');

        $pekerja->select('
            pekerja.id,
            pekerja.nik,
            pekerja.nama,
            pekerja.qr_code
        ');

        $pekerja->groupStart();
        $pekerja->like('pekerja.nik', $dtParams['search']['value']);
        $pekerja->like('pekerja.nama', $dtParams['search']['value']);
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
        return $this->db
            ->table('pekerja')
            ->countAllResults();
    }

    /**
     * generate new qr secret by id
     * 
     * @param int $id
     * 
     * @return void
     */
    public function generate(int $id)
    {
        $qrsecret = bin2hex(random_bytes(64));
        $this->db
            ->table('pekerja')
            ->where('id', $id)
            ->update([
                'qr_secret' => $qrsecret
            ]);
    }
}
