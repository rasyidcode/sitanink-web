<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLokasiKerjaTable extends Migration
{
    public function up()
    {
        // lokasi_kerja
        $this->forge->addField('id');
        $this->forge->addField([
            'nama'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'lon'           => ['type' => 'DOUBLE', 'null' => false, 'default' => 0],
            'lat'           => ['type' => 'DOUBLE', 'null' => false, 'default' => 0],
            'created_at'    => ['type' => 'DATETIME', 'null' => false],
            'updated_at'    => ['type' => 'DATETIME', 'null' => false]
        ]);
        $this->forge->createTable('lokasi_kerja');

        // pekerjaan
        $this->forge->addField('id');
        $this->forge->addField([
            'nama'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'created_at'    => ['type' => 'DATETIME', 'null' => false],
            'updated_at'    => ['type' => 'DATETIME', 'null' => false]
        ]);
        $this->forge->createTable('pekerjaan');

        // jenis_pekerja
        $this->forge->addField('id');
        $this->forge->addField([
            'nama'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'created_at'    => ['type' => 'DATETIME', 'null' => false],
            'updated_at'    => ['type' => 'DATETIME', 'null' => false]
        ]);
        $this->forge->createTable('jenis_pekerja');
        
        // domisili
        $this->forge->addField('id');
        $this->forge->addField([
            'nama'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'created_at'    => ['type' => 'DATETIME', 'null' => false],
            'updated_at'    => ['type' => 'DATETIME', 'null' => false]
        ]);
        $this->forge->createTable('domisili');
    }

    public function down()
    {
        $this->forge->dropTable('lokasi_kerja');
        $this->forge->dropTable('pekerjaan');
        $this->forge->dropTable('jenis_pekerja');
        $this->forge->dropTable('domisili');
    }
}
