<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyPekerjaTempTable extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('pekerja_temp', 'foto');
        $this->forge->addColumn('pekerja_temp', [
            'id_media' => [
                'type'  => 'int',
                'constraint'    => 9,
                'null'  => true,
                'after' => 'jenis_pekerja'
            ]
        ]);
        $this->db->query('ALTER TABLE `pekerja_temp` ADD FOREIGN KEY (id_media) REFERENCES pekerja_media(id)');
    }

    public function down()
    {
        $this->forge->addColumn('pekerja_temp', [
            'foto' => ['type'  => 'text', 'null' => true],
        ]);
        $this->forge->dropColumn('pekerja_temp', 'id_media');
        $this->forge->dropForeignKey('pekerja_temp', 'id_media');
    }
}
