<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tasks extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>[
                'type'=>'INT',
                'auto_increment'=>true,
                'null' => false
            ],
            'title'=>[
                'type'=>'NVARCHAR',
                'constraint'=>255,
                'null' => false
            ],
            'description'=>[
                'type'=>'NVARCHAR',
                'constraint'=>255,
                'null' => false
            ],
            'status'=>[
                'type'=>'NVARCHAR',
                'constraint'=>255,
                'null' => false
            ],
            'created_at'=>[
                'type'=>'DATETIME',
                'null' => false
            ],
            'updated_at'=>[
                'type'=>'DATETIME',
                'null' => false
            ],
            'user_tasks'=>[
                'type'=>'INT',
                'null' => false
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_tasks','users','id', 'cascade', 'cascade');
        $this->forge->createTable('tasks');
    }

    public function down()
    {
        $this->forge->dropTable('tasks');
    }
}
