<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RekeningSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('tb_rekening')->emptyTable();
        $this->db->query('ALTER TABLE tb_rekening AUTO_INCREMENT = 1');

        $data = [
            [
                'nama_bank' => 'Bank Mandiri',
                'no_rek' => '1234567890',
                'nama_rek' => 'Ahmad Fauzi',
                'user_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_bank' => 'Bank BCA',
                'no_rek' => '0987654321',
                'nama_rek' => 'Rina Permata',
                'user_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_bank' => 'Bank BRI',
                'no_rek' => '1122334455',
                'nama_rek' => 'Budi Santoso',
                'user_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('tb_rekening')->insertBatch($data);
    }
}
