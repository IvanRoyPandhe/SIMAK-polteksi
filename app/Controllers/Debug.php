<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Debug extends BaseController
{
    public function checkKRS()
    {
        $db = \Config\Database::connect();
        
        echo "<h2>Debug KRS System</h2>";
        
        // Check users
        echo "<h3>1. Users (Mahasiswa & Dosen)</h3>";
        $users = $db->table('tb_user')
            ->select('id_user, nama, email, level_id')
            ->whereIn('level_id', [4, 5]) // 4=mahasiswa, 5=dosen
            ->get()->getResultArray();
        echo "<pre>" . print_r($users, true) . "</pre>";
        
        // Check mata kuliah
        echo "<h3>2. Mata Kuliah</h3>";
        $matkul = $db->table('tb_mata_kuliah')
            ->select('id_matkul, kode_matkul, nama_matkul, dosen_id')
            ->get()->getResultArray();
        echo "<pre>" . print_r($matkul, true) . "</pre>";
        
        // Check KRS
        echo "<h3>3. Data KRS</h3>";
        $krs = $db->table('tb_krs')
            ->join('tb_mahasiswa', 'tb_mahasiswa.id_mahasiswa = tb_krs.mahasiswa_id', 'left')
            ->join('tb_mata_kuliah', 'tb_mata_kuliah.id_matkul = tb_krs.mata_kuliah_id', 'left')
            ->select('tb_krs.*, tb_mahasiswa.nama as nama_mahasiswa, tb_mata_kuliah.nama_matkul, tb_mata_kuliah.dosen_id')
            ->get()->getResultArray();
        echo "<pre>" . print_r($krs, true) . "</pre>";
        
        // Check mahasiswa table
        echo "<h3>4. Data Mahasiswa</h3>";
        $mahasiswa = $db->table('tb_mahasiswa')
            ->select('id_mahasiswa, nim, nama, user_id')
            ->get()->getResultArray();
        echo "<pre>" . print_r($mahasiswa, true) . "</pre>";
    }
}