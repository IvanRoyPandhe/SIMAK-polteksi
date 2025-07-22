<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInventaris extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_inventaris'             => [
                'type'              => 'INT',
                'constraint'        => 11,
                'auto_increment'    => TRUE,
            ],
            'nama'       => [
                'type'          => 'VARCHAR',
                'constraint'    => 80,
                'null'          => TRUE,
            ],
            'jumlah'          => [
                'type'          => 'INT',
                'constraint'    => 11,
                'null'          => TRUE,
            ],
            'satuan'        => [
                'type'          => 'VARCHAR',
                'constraint'    => 25,
                'null'          => TRUE,
            ],
            'kategori'        => [
                'type'          => 'VARCHAR',
                'constraint'    => 50,
                'null'          => TRUE,
            ],
            'kondisi'        => [
                'type'          => 'VARCHAR',
                'constraint'    => 20,
                'null'          => TRUE,
            ],
            'keterangan'        => [
                'type'          => 'VARCHAR',
                'constraint'    => 20,
                'null'          => TRUE,
            ],
            'user_id'       => [
                'type'          => 'int',
                'constraint'    => 11,
            ],
            'created_at'    => [
                'type'      => 'DATETIME',
                'null'      => TRUE,
            ],
            'updated_at'    => [
                'type'      => 'DATETIME',
                'null'      => TRUE,
            ],
        ]);

        $this->forge->addKey('id_inventaris', TRUE);
        $this->forge->addForeignKey('user_id', 'tb_users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_inventaris');
    }

    public function down()
    {
        $this->forge->dropTable('tb_inventaris');
    }
}
