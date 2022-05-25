<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyPekerjaMediaTable2 extends Migration
{
    public function up()
    {
        // drop id_media on pekerja
        $this->forge->dropForeignKey('pekerja', 'pekerja_ibfk_1');
        $this->forge->dropColumn('pekerja', 'id_media');
        // drop id_media on pekerja_temp
        $this->forge->dropForeignKey('pekerja_temp', 'pekerja_temp_ibfk_1');
        $this->forge->dropColumn('pekerja_temp', 'id_media');
        // rename pekerja_media to berkas
        $this->forge->renameTable('pekerja_media', 'berkas');
    }

    public function down()
    {
        $this->forge->renameTable('berkas', 'pekerja_media');

        $this->forge->addColumn('pekerja', [
            'id_media' => [
                'type'  => 'int',
                'constraint'    => 9,
                'null'  => true,
                'after' => 'jenis_pekerja'
            ]
        ]);
        $this->db->query('ALTER TABLE `pekerja` ADD FOREIGN KEY (id_media) REFERENCES pekerja_media(id)');

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
}
