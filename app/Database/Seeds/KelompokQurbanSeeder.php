<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KelompokQurbanSeeder extends Seeder
{
    public function run()
    {
        $query = $this->db->table('tb_kelompok_qurban')->countAllResults();

        if ($query > 0) {
            $this->db->table('tb_kelompok_qurban')->truncate();
        }

        $data = [
            [
                'nama_kelompok' => 'Kelompok 1',
                'tahun_id'      => 1,
            ],
            [
                'nama_kelompok' => 'Kelompok 2',
                'tahun_id'      => 1,
            ],
            [
                'nama_kelompok' => 'Kelompok 3',
                'tahun_id'      => 1,
            ],
            [
                'nama_kelompok' => 'Kelompok 4',
                'tahun_id'      => 1,
            ],
        ];

        $this->db->table('tb_kelompok_qurban')->insertBatch($data);
    }
}
