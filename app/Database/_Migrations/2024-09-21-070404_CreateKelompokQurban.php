<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKelompokQurban extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kelompok'            => [
                'type'               => 'INT',
                'constraint'         => 11,
                'auto_increment'     => TRUE,
            ],
            'nama_kelompok'     => [
                'type'          => 'VARCHAR',
                'constraint'    => 25,
                'null'          => TRUE,
            ],
            'tahun_id'      => [
                'type'           => 'int',
                'constraint'     => 11,
            ],
        ]);

        $this->forge->addKey('id_kelompok', TRUE);
        $this->forge->addForeignKey('tahun_id', 'tb_tahun_qurban', 'id_tahun', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_kelompok_qurban');
    }

    public function down()
    {
        $this->forge->dropTable('tb_kelompok_qurban');
    }
}
