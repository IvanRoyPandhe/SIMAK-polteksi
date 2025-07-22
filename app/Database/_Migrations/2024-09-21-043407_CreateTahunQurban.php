<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTahunQurban extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_tahun'          => [
                'type'              => 'INT',
                'constraint'        => 11,
                'auto_increment'    => TRUE,
            ],
            'tahun_hijriyah'      => [
                'type'           => 'VARCHAR',
                'constraint'     => 5,
                'null'           => TRUE,
            ],
            'tahun_masehi'      => [
                'type'           => 'VARCHAR',
                'constraint'     => 5,
                'null'           => TRUE,
            ],
        ]);

        $this->forge->addKey('id_tahun', TRUE);
        $this->forge->createTable('tb_tahun_qurban');
    }

    public function down()
    {
        $this->forge->dropTable('tb_tahun_qurban');
    }
}
