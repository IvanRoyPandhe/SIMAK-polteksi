<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KeuanganInternalSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('tb_keuangan_internal')->truncate();
    }
}
