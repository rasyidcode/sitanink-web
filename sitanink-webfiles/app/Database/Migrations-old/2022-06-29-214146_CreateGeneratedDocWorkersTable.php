<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGeneratedDocWorkersTable extends Migration
{
    public function up()
    {
        // create table [generated_doc_attachments]
        $this->forge->addField('id');
        $this->forge->addField([
            'id_generated_doc'    => [
                'type'          => 'INT',
                'constraint'    => 9,
                'null'          => true
            ],
            'id_pekerja'    => [
                'type'          => 'INT',
                'constraint'    => 9,
                'null'          => true
            ],
            'created_at timestamp default current_timestamp() null',
            'updated_at timestamp default current_timestamp() null',
        ]);
        $this->forge->addForeignKey('id_generated_doc', 'generated_docs', 'id');
        $this->forge->addForeignKey('id_pekerja', 'pekerja', 'id');
        $this->forge->createTable('generated_doc_attachments');

        // add field to [generated_docs]
        // - number
        // - year
        // - valid_until
        // - set_date
        // - name
        // - nip
        $this->forge->addColumn('generated_docs', [
            'boss_name'    => [
                'type'  => 'VARCHAR',
                'constraint'    => 255,
                'null'  => true,
                'after' => 'id'
            ],
            'boss_nip'    => [
                'type'  => 'VARCHAR',
                'constraint'    => 100,
                'null'  => true,
                'after' => 'id'
            ],
            'set_date'    => [
                'type'  => 'DATE',
                'null'  => true,
                'after' => 'id'
            ],
            'valid_until'    => [
                'type'  => 'DATE',
                'null'  => true,
                'after' => 'id'
            ],
            'year'    => [
                'type'  => 'CHAR',
                'constraint'    => 4,
                'null'  => true,
                'after' => 'id'
            ],
            'number'    => [
                'type'  => 'VARCHAR',
                'constraint'    => 100,
                'null'  => true,
                'after' => 'id'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('generated_doc_attachments');
        $this->forge->dropColumn('generated_docs', [
            'number',
            'year',
            'valid_until',
            'set_date',
            'boss_nip',
            'boss_name'
        ]);
    }
}
