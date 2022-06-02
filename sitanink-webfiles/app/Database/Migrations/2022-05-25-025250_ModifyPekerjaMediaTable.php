<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyPekerjaMediaTable extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('pekerja_media', [
            'type'  => [
                'type'  => 'enum("foto","ktp","sp")',
                'null'  => true
            ]
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('pekerja_media', [
            'type'  => [
                'type'  => 'enum("foto","ktp","sk")',
                'null'  => true
            ]
        ]);
    }
}
