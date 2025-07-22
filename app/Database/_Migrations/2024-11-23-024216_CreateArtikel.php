<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateArtikel extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_artikel'    => [
                'type'              => 'INT',
                'constraint'        => 11,
                'auto_increment'    => TRUE,
            ],
            'penulis'       => [
                'type'          => 'VARCHAR',
                'constraint'    => 50,
                'null'          => TRUE,
            ],
            'judul' => [
                'type'          => 'VARCHAR',
                'constraint'    => 80,
                'null'          => TRUE,
            ],
            'slug'  => [
                'type'          => 'VARCHAR',
                'constraint'    => 80,
                'null'          => TRUE,
            ],
            'thumbnail' => [
                'type'          => 'TEXT',
                'null'          => TRUE,
            ],
            'isi'   => [
                'type'          => 'TEXT',
                'null'          => TRUE,
            ],
            'status'    => [
                'type'          => 'ENUM',
                'constraint'    => ['publish', 'private', 'draft'],
                'null'          => TRUE,
            ],
            'kat_artikel_id'    => [
                'type'          => 'int',
                'constraint'    => 11,
            ],
            'user_id'   => [
                'type'          => 'int',
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

        $this->forge->addKey('id_artikel', TRUE);
        $this->forge->addForeignKey('kat_artikel_id', 'tb_kategori_artikel', 'id_kat_artikel', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'tb_users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_artikel');
    }

    public function down()
    {
        $this->forge->dropTable('tb_artikel');
    }
}
