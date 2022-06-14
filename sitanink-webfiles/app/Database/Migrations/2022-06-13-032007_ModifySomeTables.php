<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifySomeTables extends Migration
{
    public function up()
    {
        // remove table [domisili]
        $this->forge->dropTable('domisili', true);
        // remove table [pekerja_temp]
        $this->forge->dropTable('pekerja_temp', true);
        // remove table [pekerja_temp_berkas]
        $this->forge->dropTable('pekerja_temp_berkas', true);
        // remove table [pekerja_berkas]
        $this->forge->dropTable('pekerja_berkas', true);
        // modify table [berkas]
        // - modify kolom type, tambah value 'spiu'
        $this->forge->modifyColumn('berkas', [
            'type'  => [
                'type'          => 'ENUM',
                'constraint'    => ['foto', 'ktp', 'kk', 'sp', 'spiu'], // sp = Surat Perijinan, spiu = Surat Pernyataan Ijin Usaha
            ]
        ]);
        // - tambah kolom id_pekerja
        $this->forge->addColumn('berkas', [
            'id_pekerja'    => [
                'type'          => 'INT',
                'constraint'    => 9,
                'null'          => true,
                'after'         => 'id'
            ]
        ]);
        $this->db->query('ALTER TABLE `berkas` ADD FOREIGN KEY (id_pekerja) REFERENCES pekerja(id)');
    }

    public function down()
    {
        // create table [domisili]
        $this->forge->addField('id');
        $this->forge->addField([
            'nama'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        $this->forge->createTable('domisili');
        // create table [pekerja_temp]
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
        // create table [pekerja_temp_berkas]
        $this->forge->addField('id');
        $this->forge->addField([
            'id_pekerja' => ['type'  => 'int', 'constraint'    => 9, 'null'  => true],
            'id_berkas' => ['type'  => 'int', 'constraint'    => 9, 'null'  => true]
        ]);
        $this->forge->createTable('pekerja_temp_berkas');
        // create table [pekerja_berkas]
        $this->forge->addField('id');
        $this->forge->addField([
            'id_pekerja' => ['type'  => 'int', 'constraint'    => 9, 'null'  => true],
            'id_berkas' => ['type'  => 'int', 'constraint'    => 9, 'null'  => true]
        ]);
        $this->forge->createTable('pekerja_berkas');
        // modify table [berkas]
        // - modify kolom type, hilangkan value 'spiu'
        $this->forge->modifyColumn('berkas', [
            'type'  => [
                'type'          => 'ENUM',
                'constraint'    => ['foto', 'ktp', 'sp'], // sp = Surat Perijinan, spiu = Surat Pernyataan Ijin Usaha
            ]
        ]);
        // - hapus kolom id_pekerja
        $this->forge->dropForeignKey('berkas', 'id_pekerja');
        $this->forge->dropColumn('berkas', 'id_pekerja');
    }
}
