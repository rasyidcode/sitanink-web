<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMediaTable extends Migration
{
    public function up()
    {
        // drop users.deleted_at
        $this->forge->dropColumn('users', 'deleted_at');
        // create pekerja_media table
        $this->forge->addField('id');
        $this->forge->addField([
            'path'          => ['type'  => 'varchar', 'constraint'  => 255, 'null'   => true],
            'filename'      => ['type'  => 'varchar', 'constraint'  => 100, 'null'   => true],
            'size_in_mb'    => ['type'  => 'double', 'null'   => true],
            'mime'          => ['type'  => 'varchar', 'constraint'  => 100, 'null'   => true],
            'ext'           => ['type'  => 'char', 'constraint'  => 20, 'null'   => true],
            'type'          => ['type'  => 'enum("foto","ktp","sk")', 'null'   => true],
            'created_at timestamp default current_timestamp() null',
        ]);
        $this->forge->createTable('pekerja_media');
    }

    public function down()
    {
        // add users.deleted_at
        $this->forge->addColumn('users', [
            'deleted_at'    => [
                'type'  => 'datetime',
                'null'  => true
            ]
        ]);
        // drop pekerja_media
        $this->forge->dropTable('pekerja_media');
    }
}
