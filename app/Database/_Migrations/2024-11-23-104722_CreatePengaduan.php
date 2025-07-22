<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengaduan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pengaduan'    => [
                'type'              => 'INT',
                'constraint'        => 11,
                'auto_increment'    => TRUE,
            ],
            'nama_pengadu'       => [
                'type'          => 'VARCHAR',
                'constraint'    => 80,
                'null'          => TRUE,
            ],
            'no_hp' => [
                'type'          => 'VARCHAR',
                'constraint'    => 15,
                'null'          => TRUE,
            ],
            'jenis_masalah'  => [
                'type'          => 'VARCHAR',
                'constraint'    => 40,
                'null'          => TRUE,
            ],
            'masalah' => [
                'type'          => 'TEXT',
                'null'          => TRUE,
            ],
            'lampiran'   => [
                'type'          => 'TEXT',
                'null'          => TRUE,
            ],
            'nama_penjawab'    => [
                'type'          => 'VARCHAR',
                'constraint'    => 80,
                'null'          => TRUE,
            ],
            'jawaban'    => [
                'type'          => 'TEXT',
                'constraint'    => 11,
            ],
            'status'    => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'user_id'   => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'created_at'    => [
                'type'          => 'DATETIME',
                'null'          => TRUE,
            ],
            'updated_at'    => [
                'type'          => 'DATETIME',
                'null'          => TRUE,
            ],
        ]);

        $this->forge->addKey('id_pengaduan', TRUE);
        $this->forge->addForeignKey('user_id', 'tb_users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_pengaduan');
    }

    public function down()
    {
        $this->forge->dropTable('tb_pengaduan');
    }
}
