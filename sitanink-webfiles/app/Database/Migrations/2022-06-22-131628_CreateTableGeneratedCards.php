<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableGeneratedCards extends Migration
{
    public function up()
    {
        // drop table [kartu]
        $this->forge->dropTable('kartu');
        // create table [generated_cards]
        $this->forge->addField('id');
        $this->forge->addField([
            'id_berkas'    => [
                'type'          => 'INT',
                'constraint'    => 9,
                'null'          => true
            ],
            'generated_by'    => [
                'type'          => 'INT',
                'constraint'    => 9,
                'null'          => true
            ],
            'valid_until'   => [
                'type'  => 'DATE',
                'null'  => true
            ],
            'created_at timestamp default current_timestamp() null',
            'updated_at timestamp default current_timestamp() null',
        ]);
        $this->forge->addForeignKey('id_berkas', 'berkas', 'id');
        $this->forge->addForeignKey('generated_by', 'users', 'id');
        $this->forge->createTable('generated_cards');
        // create table [berkas_types]
        $this->forge->addField('id');
        $this->forge->addField([
            'name'  => [
                'type'  => 'VARCHAR',
                'constraint'    => 100,
                'null'  => true
            ],
            'created_at timestamp default current_timestamp() null',
            'updated_at timestamp default current_timestamp() null',
        ]);
        $this->forge->createTable('berkas_types');
        // modify table [berkas]
        // - drop type enum
        // - add column berkas_type_id
        $this->forge->dropColumn('berkas', 'type');
        $this->forge->addColumn('berkas', [
            'berkas_type_id'  => [
                'type'  => 'INT',
                'constraint'    => 9,
                'null'  => true,
                'after' => 'ext'
            ]
        ]);
        $this->db->query('ALTER TABLE `berkas` ADD FOREIGN KEY (berkas_type_id) REFERENCES berkas_types(id)');
        // create table [generated_docs]
        $this->forge->addField('id');
        $this->forge->addField([
            'id_berkas'    => [
                'type'          => 'INT',
                'constraint'    => 9,
                'null'          => true
            ],
            'generated_by'    => [
                'type'          => 'INT',
                'constraint'    => 9,
                'null'          => true
            ],
            'recipient'         => [
                'type'          => 'INT',
                'constraint'    => 9,
                'null'          => true
            ],
            'created_at timestamp default current_timestamp() null',
            'updated_at timestamp default current_timestamp() null',
        ]);
        $this->forge->addForeignKey('id_berkas', 'berkas', 'id');
        $this->forge->addForeignKey('generated_by', 'users', 'id');
        $this->forge->addForeignKey('recipient', 'pekerja', 'id');
        $this->forge->createTable('generated_docs');
    }

    public function down()
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
        // drop table [generated_cards]
        $this->forge->dropTable('generated_cards');
        // drop table [berkas_types]
        $this->forge->dropTable('berkas_types');
        // modify [berkas] table back
        $this->forge->dropColumn('berkas', 'berkas_type_id');
        $this->forge->addColumn('berkas', [
            'type'  => [
                'name'  => 'type',
                'type'          => 'ENUM',
                'constraint'    => ['foto', 'ktp', 'kk', 'sp', 'spiu'], // sp = Surat Perijinan, spiu = Surat Pernyataan Ijin Usaha
                'after' => 'ext'
            ]
        ]);
        // drop table [generated_docs]
        $this->forge->dropTable('generated_docs');
    }
}
