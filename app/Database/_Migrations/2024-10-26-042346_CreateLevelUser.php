<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLevelUser extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_level' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_level' => [
                'type'       => 'VARCHAR',
                'constraint' => 25,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('id_level', true);
        $this->forge->createTable('tb_level_user');
    }

    public function down()
    {
        $this->forge->dropTable('tb_level_user');
    }
}
