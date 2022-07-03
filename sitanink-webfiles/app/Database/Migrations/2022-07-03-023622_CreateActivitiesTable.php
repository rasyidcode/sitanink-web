<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateActivitiesTable extends Migration
{
    public function up()
    {
        $this->forge->addField('id');
        $this->forge->addField([
            'type'          => [
                'type' => 'ENUM', 
                'constraint' => ['info', 'reminder'], 
                'null' => true
            ],
            'message'    => [
                'type' => 'TEXT', 
                'null' => true
            ],
            'is_read'    => [
                'type' => 'TINYINT', 
                'constraint' => 1, 
                'null' => true
            ],
            'created_at timestamp default current_timestamp() null',
        ]);
        $this->forge->createTable('activities');
    }

    public function down()
    {
        $this->forge->dropTable('activities');
    }
}
