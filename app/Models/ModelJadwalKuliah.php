<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelJadwalKuliah extends Model
{
    protected $table = 'tb_jadwal_kuliah';
    protected $primaryKey = 'id_jadwal';
    protected $allowedFields = ['mata_kuliah', 'dosen', 'hari', 'jam_mulai', 'jam_selesai', 'ruangan_id', 'semester'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function AllData()
    {
        return $this->db->table('tb_jadwal_kuliah')
            ->orderBy('hari', 'ASC')
            ->orderBy('jam_mulai', 'ASC')
            ->get()->getResultArray();
    }

    public function InsertData($data)
    {
        return $this->db->table('tb_jadwal_kuliah')->insert($data);
    }

    public function UpdateData($data)
    {
        return $this->db->table('tb_jadwal_kuliah')
            ->where('id_jadwal', $data['id_jadwal'])
            ->update($data);
    }

    public function DeleteData($id_jadwal)
    {
        return $this->db->table('tb_jadwal_kuliah')
            ->where('id_jadwal', $id_jadwal)
            ->delete();
    }
}