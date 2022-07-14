<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifySomeTables2 extends Migration
{
    public function up()
    {
        $this->forge->dropForeignKey('pekerja', 'pekerja_ibfk_4');
        $this->forge->dropColumn('pekerja', 'id_domisili');
    }

    public function down()
    {
        $this->forge->addColumn('pekerja', [
            'id_domisili'   => [
                'type'          => 'INT',
                'constraint'    => '9',
                'null'          => true,
                'after'         => 'alamat'
            ]
        ]);
        $this->db->query('ALTER TABLE `pekerja` ADD FOREIGN KEY (id_domisili) REFERENCES domisili(id)');
    }
}
