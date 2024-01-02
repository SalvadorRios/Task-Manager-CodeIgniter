<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>[
                'type'=>'INT',
                'auto_increment'=>TRUE
            ],
            'name'=>[
                'type'=>'NVARCHAR',
                'constraint'=>255
            ],
            'email'=>[
                'type'=>'NVARCHAR',
                'constraint'=>255
            ],
            'password'=>[
                'type'=>'NVARCHAR',
                'constraint'=>1000
            ],
            'created_at'=>[
                'type'=>'DATETIME',
                'null' => false
            ],
            'updated_at'=>[
                'type'=>'DATETIME',
                'null' => false
            ]
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
