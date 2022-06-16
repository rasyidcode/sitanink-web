<?php

namespace Modules\Admin\Wilayah\Models;

use CodeIgniter\Database\ConnectionInterface;

class WilayahModel
{

    protected $db;

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
    }

}