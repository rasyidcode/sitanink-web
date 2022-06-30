<?php

namespace Modules\Admin\Sk\Models;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\ConnectionInterface;

class SkModel
{

    protected $db;

    /**
     * @var BaseBuilder
     */
    private BaseBuilder $builder;

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
        $this->builder = $this->db->table('generated_docs');
    }

}