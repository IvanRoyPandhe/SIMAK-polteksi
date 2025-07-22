<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBulanBisyaroh extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_bulan_bisyaroh'            => [
                'type'               => 'INT',
                'constraint'         => 11,
                'auto_increment'     => TRUE,
            ],
            'nama_bulan'     => [
                'type'          => 'VARCHAR',
                'constraint'    => 25,
                'null'          => TRUE,
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

        $this->forge->addKey('id_bulan_bisyaroh', TRUE);
        $this->forge->createTable('tb_bulan_bisyaroh');
    }

    public function down()
    {
        $this->forge->dropTable('tb_bulan_bisyaroh');
    }
}
