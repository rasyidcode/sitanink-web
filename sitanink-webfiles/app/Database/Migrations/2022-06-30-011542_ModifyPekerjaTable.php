<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyPekerjaTable extends Migration
{
    public function up()
    {
        $this->forge->dropTable('pekerjaan');

        $this->forge->dropForeignKey('pekerja', 'pekerja_ibfk_3');
        $this->forge->dropColumn('pekerja', 'id_pekerjaan');

        $this->forge->addColumn('pekerja', [
            'pekerjaan' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
                'null'          => true,
                'after'         => 'qr_secret'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->addField('id');
        $this->forge->addField([
            'nama'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'created_at'    => ['type' => 'DATETIME', 'null' => false],
            'updated_at'    => ['type' => 'DATETIME', 'null' => false]
        ]);
        $this->forge->createTable('pekerjaan');

        $this->forge->dropColumn('pekerja', 'pekerjaan');

        $this->forge->addColumn('pekerja', [
            'id_pekerjaan' => [
                'type'          => 'INT',
                'constraint'    => 9,
                'null'          => true,
                'after'         => 'qr_secret'
            ]
        ]);
        $this->db->query('ALTER TABLE `pekerja` ADD FOREIGN KEY (id_pekerjaan) REFERENCES pekerjaan(id)');
    }
}
