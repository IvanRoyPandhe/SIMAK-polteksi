<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KeuanganSosialSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('tb_keuangan_sosial')->truncate();
    }
}
