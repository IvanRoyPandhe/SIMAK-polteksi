<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnggotaQurban extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_anggota'            => [
                'type'              => 'INT',
                'constraint'        => 11,
                'auto_increment'    => TRUE,
            ],
            'nama_anggota'      => [
                'type'          => 'VARCHAR',
                'constraint'    => 100,
                'null'          => TRUE,
            ],
            'biaya'      => [
                'type'          => 'int',
                'constraint'    => 11,
                'null'          => TRUE,
            ],
            'kelompok_id'       => [
                'type'          => 'int',
                'constraint'    => 11,
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

        $this->forge->addKey('id_anggota', TRUE);
        $this->forge->addForeignKey('kelompok_id', 'tb_kelompok_qurban', 'id_kelompok', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'tb_users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_anggota_qurban');
    }

    public function down()
    {
        $this->forge->dropTable('tb_anggota_qurban');
    }
}
