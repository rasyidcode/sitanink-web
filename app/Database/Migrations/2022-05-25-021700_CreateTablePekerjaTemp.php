<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTablePekerjaTemp extends Migration
{
    public function up()
    {
        // table pekerja_temp
        $this->forge->addField('id');
        $this->forge->addField([
            'nik'           => ['type'  => 'char',      'constraint'    => 16,  'null'  => true],
            'nama'          => ['type'  => 'varchar',   'constraint'    => 255, 'null'  => true],
            'tempat_lahir'  => ['type'  => 'varchar',   'constraint'    => 255, 'null'  => true],
            'tgl_lahir'     => ['type'  => 'date',      'null'          => true],
            'alamat'        => ['type'  => 'text',      'null'          => true],
            'domisili'      => ['type'  => 'varchar',   'constraint'    => 255,'null'   => true],
            'pekerjaan'     => ['type'  => 'varchar',   'constraint'    => 100,'null'   => true],
            'lokasi_kerja'  => ['type'  => 'varchar',   'constraint'    => 255,'null'   => true],
            'jenis_pekerja' => ['type'  => 'varchar',   'constraint'    => 255,'null'   => true],
            'foto'          => ['type'  => 'text',      'null'          => true],
            'created_at timestamp default current_timestamp() null',
            'updated_at timestamp default current_timestamp() null',
            'deleted_at'    => ['type'          => 'datetime','null'          => true],
        ]);
        $this->forge->createTable('pekerja_temp');
    }

    public function down()
    {
        $this->forge->dropTable('pekerja_temp');
    }
}
