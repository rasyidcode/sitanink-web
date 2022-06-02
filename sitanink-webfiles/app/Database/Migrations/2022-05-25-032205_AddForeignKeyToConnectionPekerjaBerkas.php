<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddForeignKeyToConnectionPekerjaBerkas extends Migration
{
    public function up()
    {
        $this->db->query('ALTER TABLE `pekerja_berkas` ADD FOREIGN KEY (id_pekerja) REFERENCES pekerja(id)');
        $this->db->query('ALTER TABLE `pekerja_berkas` ADD FOREIGN KEY (id_berkas) REFERENCES berkas(id)');
        $this->forge->modifyColumn('pekerja_temp_berkas', [
            'id_pekerja'    => [
                'name'  => 'id_pekerja_temp',
                'type'  => 'int',
                'constraint'    => 9,
                'null'  => true
            ]
        ]);
        $this->db->query('ALTER TABLE `pekerja_temp_berkas` ADD FOREIGN KEY (id_pekerja_temp) REFERENCES pekerja_temp(id)');
        $this->db->query('ALTER TABLE `pekerja_temp_berkas` ADD FOREIGN KEY (id_berkas) REFERENCES berkas(id)');
    }

    public function down()
    {
        $this->forge->dropForeignKey('pekerja_berkas', 'id_pekerja');
        $this->forge->dropForeignKey('pekerja_berkas', 'id_berkas');
        $this->forge->modifyColumn('pekerja_temp_berkas', [
            'id_pekerja_temp'    => [
                'name'  => 'id_pekerja',
                'type'  => 'int',
                'constraint'    => 9,
                'null'  => true
            ]
        ]);
        $this->forge->dropForeignKey('pekerja_temp_berkas', 'id_pekerja');
        $this->forge->dropForeignKey('pekerja_temp_berkas', 'id_berkas');
    }
}
