<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyPekerjaTable extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('pekerja', 'foto');
        $this->forge->addColumn('pekerja', [
            'id_media' => [
                'type'  => 'int',
                'constraint'    => 9,
                'null'  => true,
                'after' => 'jenis_pekerja'
            ]
        ]);
        $this->db->query('ALTER TABLE `pekerja` ADD FOREIGN KEY (id_media) REFERENCES pekerja_media(id)');
    }

    public function down()
    {
        $this->forge->addColumn('pekerja', [
            'foto' => ['type'  => 'text', 'null' => true],
        ]);
        $this->forge->dropColumn('pekerja', 'id_media');
        $this->forge->dropForeignKey('pekerja', 'id_media');
    }
}
