<?php

namespace Modules\Admin\User\Models;

use CodeIgniter\Model;

class UserModel extends Model
{

    private $columnOrder = ['username', 'email', 'level'];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get user list with datatable params
     * 
     * @param array $dtParams
     * 
     * @return array|null
     */
    public function getData(array $dtParams) : ?array
    {
        $user = $this->builder('users');

        $user->groupStart();
        $user->like('username', $dtParams['search']['value']);
        $user->orLike('email', $dtParams['search']['value']);
        $user->orLike('level', $dtParams['search']['value']);
        $user->groupEnd();

        if (isset($dtParams['order'])) {
            $user->orderBy($this->columnOrder[$dtParams['order']['0']['column']], $dtParams['order']['0']['dir']);
        }

        if (isset($dtParams['length']) && isset($dtParams['start'])) {
            if ($dtParams['length'] !== -1) {
                $user->limit($dtParams['length'], $dtParams['start']);
            }
        }

        return $user->get()
            ->getResultObject();
    }

    /**
     * count filtered data
     * 
     * @param array $dtParams
     * 
     * @return int|null
     */
    public function countFilteredData(array $dtParams) : int
    {
        $user = $this->builder('users');

        $user->groupStart();
        $user->like('username', $dtParams['search']['value']);
        $user->orLike('email', $dtParams['search']['value']);
        $user->orLike('level', $dtParams['search']['value']);
        $user->groupEnd();

        if (isset($dtParams['order'])) {
            $user->orderBy($this->columnOrder[$dtParams['order']['0']['column']], $dtParams['order']['0']['dir']);
        }

        if (isset($dtParams['length']) && isset($dtParams['start'])) {
            if ($dtParams['length'] !== -1) {
                $user->limit($dtParams['length'], $dtParams['start']);
            }
        }

        return $user->countAllResults();
    }

    /**
     * count total data
     * 
     * @param array $dt_params
     * 
     * @return int
     */
    public function countData() : int
    {
        return $this->builder('users')
                    ->countAllResults();
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
    public function get($userId) : ?object
    {
        return $this->builder('users')
            ->select('
                id,
                username,
                email,
                level
            ')
            ->where('id', $userId)
            ->get(limit:1)
            ->getRowObject();
    }

    /**
     * Update user data
     * 
     * @param array $data
     * 
     * @return void
     */
    public function updateUser(array $data)
    {
        $id = array_shift($data);
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


}