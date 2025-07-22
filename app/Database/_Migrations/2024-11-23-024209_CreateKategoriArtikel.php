<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKategoriArtikel extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kat_artikel' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => TRUE,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => TRUE,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => TRUE,
            ],
        ]);

        $this->forge->addKey('id_kat_artikel', TRUE);
        $this->forge->createTable('tb_kategori_artikel');
    }

    public function down()
    {
        $this->forge->dropTable('tb_kategori_artikel');
    }
}
