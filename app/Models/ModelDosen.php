<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDosen extends Model
{
    protected $table = 'tb_dosen';
    protected $primaryKey = 'id_dosen';
    protected $allowedFields = ['nip', 'nama', 'email', 'prodi_id', 'jabatan', 'status'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getAllWithProdi()
    {
        return $this->select('tb_dosen.*, tb_prodi.nama_prodi')
                    ->join('tb_prodi', 'tb_prodi.id_prodi = tb_dosen.prodi_id', 'left')
                    ->where('tb_dosen.status', 'Aktif')
                    ->orderBy('tb_dosen.prodi_id', 'ASC')
                    ->findAll();
    }

    public function AllData()
    {
        return $this->select('tb_dosen.*, tb_prodi.nama_prodi')
                    ->join('tb_prodi', 'tb_prodi.id_prodi = tb_dosen.prodi_id', 'left')
                    ->orderBy('tb_dosen.nama', 'ASC')
                    ->findAll();
    }
}