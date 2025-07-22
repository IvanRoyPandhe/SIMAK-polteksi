<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRekening extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_rekening'           => [
                'type'              => 'INT',
                'constraint'        => 11,
                'auto_increment'    => TRUE,
            ],
            'nama_bank'         => [
                'type'          => 'VARCHAR',
                'constraint'    => 100,
                'null'          => TRUE,
            ],
            'no_rek'            => [
                'type'          => 'varchar',
                'constraint'    => 25,
                'null'          => TRUE,
            ],
            'nama_rek'         => [
                'type'          => 'varchar',
                'constraint'    => 100,
                'null'          => TRUE,
            ],
            'user_id'       => [
                'type'          => 'int',
                'constraint'    => 11,
            ],
            'created_at'    => [
                'type'           => 'DATETIME',
                'null'           => TRUE,
            ],
            'updated_at'    => [
                'type'           => 'DATETIME',
                'null'           => TRUE,
            ],
        ]);

        $this->forge->addKey('id_rekening', TRUE);
        $this->forge->addForeignKey('user_id', 'tb_users', 'id_user', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('tb_rekening');
    }

    public function down()
    {
        $this->forge->dropTable('tb_rekening');
    }
}
