<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBisyaroh extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_bisyaroh'   => [
                'type'               => 'INT',
                'constraint'         => 11,
                'auto_increment'     => TRUE,
            ],
            'nama'  => [
                'type'          => 'VARCHAR',
                'constraint'    => 25,
                'null'          => TRUE,
            ],
            'tugas' => [
                'type'          => 'VARCHAR',
                'constraint'    => 100,
                'null'          => TRUE,
            ],
            'sumbangan_transport'   => [
                'type'          => 'int',
                'constraint'    => 11,
                'null'          => TRUE,
            ],
            'tahun'      => [
                'type'           => 'VARCHAR',
                'constraint'     => 5,
                'null'           => TRUE,
            ],
            'status'            => [
                'type'          => 'int',
                'constraint'    => 1,
                'null'          => TRUE,
            ],
            'bulan_id'  => [
                'type'           => 'int',
                'constraint'     => 11,
            ],
            'user_id'   => [
                'type'           => 'int',
                'constraint'     => 11,
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

        $this->forge->addKey('id_bisyaroh', TRUE);
        $this->forge->addForeignKey('bulan_id', 'tb_bulan_bisyaroh', 'id_bulan_bisyaroh', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'tb_users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_bisyaroh');
    }

    public function down()
    {
        $this->forge->dropTable('tb_bisyaroh');
    }
}
