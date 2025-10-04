<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SiteConfigTable extends Migration
{
    public function up()
    {
        $this->forge->addField('id');
        $this->forge->addField([
            'key'    => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
                'null'          => true
            ],
            'value'    => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
                'null'          => true
            ],
            'related_table'   => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
                'null'          => true
            ],
            'created_at timestamp default current_timestamp() null',
            'updated_at timestamp default current_timestamp() null',
        ]);
        $this->forge->createTable('site_config');
    }

    public function down()
    {
        $this->forge->dropTable('site_config');
    }
}
