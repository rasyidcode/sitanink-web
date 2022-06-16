<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKartuTable extends Migration
{
    public function up()
    {
        // create table [kartu]
        $this->forge->addField('id');
        $this->forge->addField([
            'path'          => ['type'  => 'varchar',   'constraint'  => 255, 'null'   => true],
            'filename'      => ['type'  => 'varchar',   'constraint'  => 100, 'null'   => true],
            'size_in_kb'    => ['type'  => 'double',    'null'          => true],
            'mime'          => ['type'  => 'varchar',   'constraint'  => 100, 'null'   => true],
            'ext'           => ['type'  => 'char',      'constraint'  => 20, 'null'   => true],
            'valid_until'   => ['type'  => 'date',      'null'          => true],
            'id_pekerja'    => [
                'type'          => 'INT',
                'constraint'    => 9,
                'null'          => true,
                'after'         => 'id'
            ],
            'created_at timestamp default current_timestamp() null',
            'updated_at timestamp default current_timestamp() null',
        ]);
        $this->forge->addForeignKey('id_pekerja', 'pekerja', 'id');
        $this->forge->createTable('kartu');
    }

    public function down()
    {
        $this->forge->dropTable('kartu');
    }
}
