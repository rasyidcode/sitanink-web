<?php

namespace Modules\Api\User\Models;

use CodeIgniter\Database\ConnectionInterface;

class UserModel
{

    protected $db;

    private $builder;

    private $columnOrder = ['username', 'email', 'level'];

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
        $this->builder = $this->db->table('users');
    }

    /**
     * Get user list with datatable params
     * 
     * @param array $dtParams
     * 
     * @return array|null
     */
    public function getData(array $dtParams): ?array
    {
        $this->builder->groupStart();
        $this->builder->like('username', $dtParams['search']['value']);
        $this->builder->orLike('email', $dtParams['search']['value']);
        $this->builder->orLike('level', $dtParams['search']['value']);
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
        $this->builder->groupStart();
        $this->builder->like('username', $dtParams['search']['value']);
        $this->builder->orLike('email', $dtParams['search']['value']);
        $this->builder->orLike('level', $dtParams['search']['value']);
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
}
