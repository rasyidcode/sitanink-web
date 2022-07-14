<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifySomeTables3 extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pekerja', [
            'qr_secret'  => [
                'type'          => 'VARCHAR',
                'constraint'    => 64,
                'null'          => true,
                'after'         => 'alamat'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pekerja', 'qr_secret');
    }
}
