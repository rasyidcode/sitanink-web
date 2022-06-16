<?php

namespace Modules\Admin\Kartu\Models;

use CodeIgniter\Database\ConnectionInterface;

class KartuModel
{

    protected $db;

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
    }

}