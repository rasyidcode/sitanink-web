<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'  => 'admin',
                'password'  => password_hash('12345', PASSWORD_BCRYPT),
                'email'     => 'admin@sitanink.com',
                'level'     => 'admin',
            ],
            [
                'username'  => 'lapas1',
                'password'  => password_hash('12345', PASSWORD_BCRYPT),
                'email'     => 'lapas1@sitanink.com',
                'level'     => 'reguler',
            ],
            [
                'username'  => 'lapas2',
                'password'  => password_hash('12345', PASSWORD_BCRYPT),
                'email'     => 'lapas2@sitanink.com',
                'level'     => 'reguler',
            ],
        ];

        $this->db->table('users')
            ->insertBatch($data);
    }
}
