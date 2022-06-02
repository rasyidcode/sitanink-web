<?php

namespace Modules\Admin\User\Models;

use CodeIgniter\Model;

class UserModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create a new user
     * 
     * @param array $data
     * 
     * @return void
     */
    public function create(array $data)
    {
        $this->builder('users')
            ->insert($data);
    }

    /**
     * Update user password
     * 
     * @param int $userId
     * @param string $newPass
     * 
     * @return void
     */
    public function updatePassword(int $userId, string $newPass)
    {
        $this->builder('users')
            ->where('id', $userId)
            ->update([
                'password'  => $newPass
            ]);
    }

    /**
     * Get by id
     * 
     * @param int $userId
     * 
     * @return object|null
     */
    public function get($userId): ?object
    {
        return $this->builder('users')
            ->select('
                id,
                username,
                email,
                level
            ')
            ->where('id', $userId)
            ->get(limit: 1)
            ->getRowObject();
    }

    /**
     * Update user data
     * 
     * @param array $data
     * @param int $id
     * 
     * @return void
     */
    public function updateUser(array $data, int $id)
    {
        $this->builder('users')
            ->where('id', $id)
            ->update($data);
    }

    /**
     * Delete user
     * 
     * @param int $userId
     * 
     * @return void
     */
    public function deleteUser(int $userId)
    {
        $this->builder('users')
            ->where('id', $userId)
            ->delete();
    }

    /**
     * Check username
     * 
     * @param string $username
     * 
     * @return object|null
     */
    public function getByUsername(string $username) : ?object
    {
        return $this->db->table('users')
            ->where('username', $username)
            ->get()
            ->getRowObject();
    }

    /**
     * Check email
     * 
     * @param string $email
     * 
     * @return object|null
     */
    public function getByEmail(string $email) : ?object
    {
        return $this->db->table('users')
            ->where('email', $email)
            ->get()
            ->getRowObject();
    }
}
