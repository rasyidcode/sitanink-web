<?php

namespace Modules\Public\Login\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get user by username
     * 
     * @param string $username
     * 
     * @return object|null
     */
    public function getUser(string $username) : ?object
    {
        return $this->builder('users')
            ->where('username', $username)
            ->get(limit:1)
            ->getRowObject();
    }

    /**
     * 
     */

}
