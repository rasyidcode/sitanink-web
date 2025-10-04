<?php

namespace Modules\Api\Sk\Models;

use CodeIgniter\Database\ConnectionInterface;

class SkModel
{

    protected $db;

    private $builder;

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
        $this->builder = $this->db->table('generated_docs');
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
        if (isset($dtParams['length']) && isset($dtParams['start'])) {
            if ($dtParams['length'] !== -1) {
                $this->builder->limit($dtParams['length'], $dtParams['start']);
            }
        }

        return $this->builder
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
        if (isset($dtParams['length']) && isset($dtParams['start'])) {
            if ($dtParams['length'] !== -1) {
                $this->builder->limit($dtParams['length'], $dtParams['start']);
            }
        }

        return $this->builder
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
        return $this->builder
            ->countAllResults();
    }

    /**
     * get attachment by id
     * 
     * @param int $id
     * 
     * @return array
     */
    public function getAttachment(int $id) : array
    {
        return [];
    }
}
