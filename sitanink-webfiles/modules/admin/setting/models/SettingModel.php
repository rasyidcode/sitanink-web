<?php

namespace Modules\Admin\Setting\Models;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\ConnectionInterface;

class SettingModel
{

    /**
     * @var ConnectionInterface
     */
    protected $db;

    /**
     * @var BaseBuilder
     */
    private BaseBuilder $builder;

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
        $this->builder = $this->db->table('site_config');
    }

    public function getListBerkasType()
    {
        return $this->db->table('berkas_types')
            ->select('
                id as value,
                name as text
            ')
            ->get()
            ->getResultObject();
    }

    /**
     * Get site config by key
     * 
     * @param string $key
     * 
     * @return object|null
     */
    public function getSiteConfig(string $key) : ?object
    {
        return $this->builder
            ->where('key', $key)
            ->get()
            ->getRowObject();
    }

    /**
     * Get all config
     * 
     * @return array
     */
    public function getAllConfig() : array
    {
        return $this->builder
            ->get()
            ->getResultObject();
    }

    /**
     * Create new config
     * 
     * @param array $data
     * 
     * @return void
     */
    public function createConfig(array $data)
    {
        return $this->builder
            ->insert($data);
    }

    /**
     * Update config
     * 
     * @param array $data
     * 
     * @return void
     */
    public function updateConfig(array $data)
    {
        return $this->builder
            ->where('key', $data['key'])
            ->update($data);
    }

}