<?php

namespace Modules\Admin\Qrcode\Models;

use CodeIgniter\Database\ConnectionInterface;

class QrcodeModel
{

    protected $db;

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
    }

}