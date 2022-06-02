<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyPekerjaTable extends Migration
{
    public function up()
    {
        // table pekerja
        // drop column domisili, pekerjaan, lokasi_kerja, jenis_pekerja
        $this->forge->dropColumn('pekerja', ['domisili', 'pekerjaan', 'lokasi_kerja', 'jenis_pekerja']);
        // add column after alamat starting with id_jenis_pekerja, followed by id_lokasi_kerja, id_pekerjaan, id_domisili
        $this->forge->addColumn('pekerja', [
            'id_jenis_pekerja'  => [
                'type'          => 'INT',
                'constraint'    => 9,
                'null'          => true,
                'after'         => 'alamat'
            ],
            'id_lokasi_kerja'  => [
                'type'          => 'INT',
                'constraint'    => 9,
                'null'          => true,
                'after'         => 'alamat'
            ],
            'id_pekerjaan'  => [
                'type'          => 'INT',
                'constraint'    => 9,
                'null'          => true,
                'after'         => 'alamat'
            ],
            'id_domisili'  => [
                'type'          => 'INT',
                'constraint'    => 9,
                'null'          => true,
                'after'         => 'alamat'
            ],
        ]);
        // add foreign to each tables
        $this->db->query('ALTER TABLE `pekerja` ADD FOREIGN KEY (id_jenis_pekerja) REFERENCES jenis_pekerja(id)');
        $this->db->query('ALTER TABLE `pekerja` ADD FOREIGN KEY (id_lokasi_kerja) REFERENCES lokasi_kerja(id)');
        $this->db->query('ALTER TABLE `pekerja` ADD FOREIGN KEY (id_pekerjaan) REFERENCES pekerjaan(id)');
        $this->db->query('ALTER TABLE `pekerja` ADD FOREIGN KEY (id_domisili) REFERENCES domisili(id)');
    }

    public function down()
    {
        // table pekerja
        // remove foreign key from each table
        $this->forge->dropForeignKey('pekerja', 'id_jenis_pekerja');
        $this->forge->dropForeignKey('pekerja', 'id_lokasi_kerja');
        $this->forge->dropForeignKey('pekerja', 'id_pekerjaan');
        $this->forge->dropForeignKey('pekerja', 'id_domisili');
        // drop column id_jenis_pekerja, id_lokasi_kerja, id_pekerjaan, id_domisili
        $this->forge->dropColumn('pekerja', ['id_jenis_pekerja', 'id_lokasi_kerja', 'id_pekerjaan', 'id_domisili']);
        // add column after alamat starting with jenis_pekerja, followed by lokasi_kerja , pekerjaan, domisili
        $this->forge->addColumn('pekerja', [
            'jenis_pekerja' => [
                'type'  => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'alamat'
            ],
            'lokasi_kerja' => [
                'type'  => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'alamat'
            ],
            'pekerjaan' => [
                'type'  => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'alamat'
            ],
            'domisili' => [
                'type'  => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'alamat'
            ],
        ]);
    }
}
