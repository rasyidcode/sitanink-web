<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePekerjaBerkasConnectionTable extends Migration
{
    public function up()
    {
        // pekerja_berkas
        $this->forge->addField('id');
        $this->forge->addField([
            'id_pekerja' => ['type'  => 'int', 'constraint'    => 9, 'null'  => true],
            'id_berkas' => ['type'  => 'int', 'constraint'    => 9, 'null'  => true]
        ]);
        $this->forge->createTable('pekerja_berkas');

        // pekerja_temp_berkas
        $this->forge->addField('id');
        $this->forge->addField([
            'id_pekerja' => ['type'  => 'int', 'constraint'    => 9, 'null'  => true],
            'id_berkas' => ['type'  => 'int', 'constraint'    => 9, 'null'  => true]
        ]);
        $this->forge->createTable('pekerja_temp_berkas');
    }

    public function down()
    {
        $this->forge->dropTable('pekerja_berkas');
        $this->forge->dropTable('pekerja_temp_berkas');
    }
}
