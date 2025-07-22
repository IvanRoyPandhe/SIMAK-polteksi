<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDonasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_donasi'             => [
                'type'              => 'INT',
                'constraint'        => 11,
                'auto_increment'    => TRUE,
            ],
            'nama_bank_p'       => [
                'type'          => 'VARCHAR',
                'constraint'    => 100,
                'null'          => TRUE,
            ],
            'no_rek_p'          => [
                'type'          => 'varchar',
                'constraint'    => 25,
                'null'          => TRUE,
            ],
            'nama_rek_p'        => [
                'type'          => 'varchar',
                'constraint'    => 100,
                'null'          => TRUE,
            ],
            'nama_pengirim'     => [
                'type'          => 'varchar',
                'constraint'    => 100,
                'null'          => TRUE,
            ],
            'jumlah'            => [
                'type'          => 'int',
                'constraint'    => 11,
                'null'          => TRUE,
            ],
            'bukti_transfer'     => [
                'type'  => 'text',
                'null'  => TRUE,
            ],
            'status'            => [
                'type'          => 'int',
                'constraint'    => 1,
                'null'          => TRUE,
            ],
            'jenis_donasi' => [
                'type'       => 'ENUM',
                'constraint' => ['Internal', 'Sosial'],
                'null'       => TRUE,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Belum Tervalidasi', 'Telah Tervalidasi'],
                'null'       => TRUE,
            ],
            'rekening_id'       => [
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

        $this->forge->addKey('id_donasi', TRUE);
        $this->forge->addForeignKey('rekening_id', 'tb_rekening', 'id_rekening', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_donasi');
    }

    public function down()
    {
        $this->forge->dropTable('tb_donasi');
    }
}
