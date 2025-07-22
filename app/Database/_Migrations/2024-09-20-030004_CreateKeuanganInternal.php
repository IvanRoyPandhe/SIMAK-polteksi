<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKeuanganInternal extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_keuangan'   => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => TRUE,
            ],
            'tgl'   => [
                'type'           => 'DATE',
                'null'           => TRUE,
            ],
            'dana_masuk'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => TRUE,
            ],
            'dana_keluar'   => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => TRUE,
            ],
            'kategori'  => [
                'type'           => 'VARCHAR',
                'constraint'     => 50,
                'null'           => TRUE,
            ],
            'keterangan'    => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'           => TRUE,
            ],
            'status' => [
                'type'          => 'ENUM',
                'constraint'    => ['Masuk', 'Keluar'],
                'null'          => TRUE,
            ],
            'user_id'   => [
                'type'           => 'INT',
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

        $this->forge->addKey('id_keuangan', TRUE);
        $this->forge->addForeignKey('user_id', 'tb_users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_keuangan_internal');
    }

    public function down()
    {
        $this->forge->dropTable('tb_keuangan_internal');
    }
}
