<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDosen extends Model
{
    protected $table = 'tb_dosen';
    protected $primaryKey = 'id_dosen';
    protected $allowedFields = ['nip', 'nama', 'email', 'prodi_id', 'jabatan', 'status'];

    public function AllData()
    {
        return $this->db->table('tb_dosen')
            ->join('tb_prodi', 'tb_prodi.id_prodi = tb_dosen.prodi_id', 'left')
            ->select('tb_dosen.*, tb_prodi.nama_prodi')
            ->orderBy('tb_prodi.nama_prodi', 'ASC')
            ->orderBy('tb_dosen.nama', 'ASC')
            ->get()->getResultArray();
    }

    public function InsertData($data)
    {
        return $this->insert($data);
    }

    public function UpdateData($id, $data)
    {
        return $this->update($id, $data);
    }

    public function DeleteData($id)
    {
        return $this->delete($id);
    }

    public function getByNip($nip)
    {
        return $this->where('nip', $nip)->first();
    }

    public function getByProdi($prodi_id)
    {
        return $this->where('prodi_id', $prodi_id)->findAll();
    }

    public function getActiveLecturers()
    {
        return $this->where('status', 'Aktif')->findAll();
    }
}