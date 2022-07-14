<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAllTable extends Migration
{
    public function up()
    {
        // create [jenis_pekerja] table
        $this->forge->addField('id');
        $this->forge->addField([
            'nama' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        $this->forge->createTable('jenis_pekerja');

        // create [lokasi_kerja] table
        $this->forge->addField('id');
        $this->forge->addField([
            'nama'  => ['type' => 'VARCHAR', 'constraint' => 255,   'null' => false],
            'lon'   => ['type' => 'DOUBLE',                         'null' => false, 'default' => 0],
            'lat'   => ['type' => 'DOUBLE',                         'null' => false, 'default' => 0],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        $this->forge->createTable('lokasi_kerja');

        // create [site_config] table
        $this->forge->addField('id');
        $this->forge->addField([
            'key'               => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'value'             => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'related_table'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at timestamp default current_timestamp() null',
            'updated_at timestamp default current_timestamp() null',
        ]);
        $this->forge->createTable('site_config');

        // create [users] table
        $this->forge->addField('id');
        $this->forge->addField([
            'username'      => ['type' => 'VARCHAR', 'constraint' => 20,                    'null' => true],
            'password'      => ['type' => 'VARCHAR', 'constraint' => 255,                   'null' => true],
            'email'         => ['type' => 'VARCHAR', 'constraint' => 255,                   'null' => true],
            'level'         => ['type' => 'ENUM',    'constraint' => ['admin', 'reguler'],  'null' => true],
            'last_login'    => ['type' => 'DATETIME',                                       'null' => true],
            'created_at timestamp default current_timestamp() null',
            'updated_at timestamp default current_timestamp() null'
        ]);
        $this->forge->createTable('users');

        // create [pekerja] table
        $this->forge->addField('id');
        $this->forge->addField([
            'nik'               => ['type' => 'CHAR',       'constraint' => 16,     'null' => true],
            'nama'              => ['type' => 'VARCHAR',    'constraint' => 255,    'null' => true],
            'tempat_lahir'      => ['type' => 'VARCHAR',    'constraint' => 255,    'null' => true],
            'tgl_lahir'         => ['type' => 'DATE',                               'null' => true],
            'alamat'            => ['type' => 'TEXT',                               'null' => true],
            'qr_secret'         => ['type' => 'VARCHAR',    'constraint' => 64,     'null' => true],
            'pekerjaan'         => ['type' => 'VARCHAR',    'constraint' => 255,    'null' => true],
            'id_lokasi_kerja'   => ['type' => 'INT',        'constraint' => 9,      'null' => true],
            'id_jenis_pekerja'  => ['type' => 'INT',        'constraint' => 9,      'null' => true],
            'created_at timestamp default current_timestamp() null',
            'updated_at timestamp default current_timestamp() null'
        ]);
        $this->forge->addForeignKey('id_lokasi_kerja', 'lokasi_kerja', 'id');
        $this->forge->addForeignKey('id_jenis_pekerja', 'jenis_pekerja', 'id');
        $this->forge->createTable('pekerja');

        // create [activities] table
        $this->forge->addField('id');
        $this->forge->addField([
            'type'      => ['type' => 'ENUM',       'constraint' => ['info', 'reminder'],   'null' => true],
            'message'   => ['type' => 'TEXT',                                               'null' => true],
            'is_read'   => ['type' => 'TINYINT',    'constraint' => 1,                      'null' => true],
            'created_at timestamp default current_timestamp() null',
        ]);
        $this->forge->createTable('activities');

        // create [berkas_types] table
        $this->forge->addField('id');
        $this->forge->addField([
            'name' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'created_at timestamp default current_timestamp() null',
            'updated_at timestamp default current_timestamp() null',
        ]);
        $this->forge->createTable('berkas_types');

        // create [berkas] table
        $this->forge->addField('id');
        $this->forge->addField([
            'id_pekerja'        => ['type' => 'INT',        'constraint' => 9,      'null' => true],
            'path'              => ['type' => 'VARCHAR',    'constraint' => 255,    'null' => true],
            'filename'          => ['type' => 'VARCHAR',    'constraint' => 100,    'null' => true],
            'size_in_mb'        => ['type' => 'DOUBLE',                             'null' => true],
            'mime'              => ['type' => 'VARCHAR',    'constraint' => 100,    'null' => true],
            'ext'               => ['type' => 'CHAR',       'constraint' => 20,     'null' => true],
            'berkas_type_id'    => ['type'  => 'INT',       'constraint' => 9,      'null' => true],
            'created_at timestamp default current_timestamp() null',
        ]);
        $this->forge->addForeignKey('berkas_type_id', 'berkas_types', 'id');
        $this->forge->createTable('berkas');

        // create [generated_cards] table
        $this->forge->addField('id');
        $this->forge->addField([
            'id_berkas'     => ['type' => 'INT',    'constraint' => 9,  'null' => true],
            'generated_by'  => ['type' => 'INT',    'constraint' => 9,  'null' => true],
            'valid_until'   => ['type' => 'DATE',                       'null' => true],
            'created_at timestamp default current_timestamp() null',
            'updated_at timestamp default current_timestamp() null',
        ]);
        $this->forge->addForeignKey('id_berkas', 'berkas', 'id');
        $this->forge->addForeignKey('generated_by', 'users', 'id');
        $this->forge->createTable('generated_cards');

        // create [generated_docs] table
        $this->forge->addField('id');
        $this->forge->addField([
            'number'        => ['type' => 'VARCHAR',    'constraint' => 100,'null' => true],
            'year'          => ['type' => 'CHAR',       'constraint' => 4,  'null' => true],
            'valid_until'   => ['type' => 'DATE',                           'null' => true],
            'set_date'      => ['type' => 'DATE',                           'null' => true],
            'boss_nip'      => ['type' => 'VARCHAR',    'constraint' => 100,'null' => true],
            'boss_name'     => ['type' => 'VARCHAR',    'constraint' => 255,'null' => true],
            'id_berkas'     => ['type' => 'INT',        'constraint' => 9,  'null' => true],
            'generated_by'  => ['type' => 'INT',        'constraint' => 9,  'null' => true],
            'recipient'     => ['type' => 'INT',        'constraint' => 9,  'null' => true],
            'created_at timestamp default current_timestamp() null',
            'updated_at timestamp default current_timestamp() null',
        ]);
        $this->forge->addForeignKey('id_berkas', 'berkas', 'id');
        $this->forge->addForeignKey('generated_by', 'users', 'id');
        $this->forge->addForeignKey('recipient', 'pekerja', 'id');
        $this->forge->createTable('generated_docs');

        // create [generated_doc_attachments] table
        $this->forge->addField('id');
        $this->forge->addField([
            'id_generated_doc'  => ['type' => 'INT', 'constraint' => 9, 'null' => true],
            'id_pekerja'        => ['type' => 'INT', 'constraint' => 9, 'null' => true],
            'created_at timestamp default current_timestamp() null',
            'updated_at timestamp default current_timestamp() null',
        ]);
        $this->forge->addForeignKey('id_generated_doc', 'generated_docs', 'id');
        $this->forge->addForeignKey('id_pekerja', 'pekerja', 'id');
        $this->forge->createTable('generated_doc_attachments');
    }

    public function down()
    {
        // disable foreign key check
        $this->db->disableForeignKeyChecks();

        // drop [jenis_pekerja] table
        $this->forge->dropTable('jenis_pekerja');
        // drop [lokasi_kerja] table
        $this->forge->dropTable('lokasi_kerja');
        // drop [site_config] table
        $this->forge->dropTable('site_config');
        // drop [users] table
        $this->forge->dropTable('users');
        // drop [pekerja] table
        $this->forge->dropTable('pekerja');
        // drop [activities] table
        $this->forge->dropTable('activities');
        // drop [berkas_types] table
        $this->forge->dropTable('berkas_types');
        // drop [berkas] table
        $this->forge->dropTable('berkas');
        // drop [generated_cards] table
        $this->forge->dropTable('generated_cards');
        // drop [generated_docs] table
        $this->forge->dropTable('generated_docs');
        // drop [generated_doc_attachments] table
        $this->forge->dropTable('generated_doc_attachments');

        // enable foreign key check
        $this->db->enableForeignKeyChecks();
    }
}
