<?php

namespace Modules\Admin\Activities\Models;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\ConnectionInterface;

class ActivityModel
{

    protected $db;

    /**
     * @var BaseBuilder
     */
    private BaseBuilder $builder;

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
        $this->builder = $this
            ->db
            ->table('activities');
    }

    /**
     * Get all
     * 
     * @return array
     */
    public function all() : array
    {
        return [];
    }

    /**
     * Get all ordered by created_at
     * 
     * @return array
     */
    public function allForNotification() : array
    {
        return $this
            ->builder
            ->orderBy('created_at', 'desc')
            ->get()
            ->getResultObject();
    }

    /**
     * Get all not read
     * 
     * @return array
     */
    public function allNotRead() : array
    {
        return $this
            ->builder
            ->where('is_read', 0)
            ->get()
            ->getResultObject();
    }

}