<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelMataKuliah extends Model
{
    protected $table = 'tb_mata_kuliah';
    protected $primaryKey = 'id_matkul';
    protected $allowedFields = ['kode_matkul', 'nama_matkul', 'sks', 'semester', 'prodi_id'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function AllData()
    {
        return $this->db->table('tb_mata_kuliah')
            ->join('tb_prodi', 'tb_prodi.id_prodi = tb_mata_kuliah.prodi_id', 'left')
            ->select('tb_mata_kuliah.*, tb_prodi.nama_prodi')
            ->orderBy('tb_prodi.nama_prodi', 'ASC')
            ->orderBy('tb_mata_kuliah.semester', 'ASC')
            ->orderBy('tb_mata_kuliah.kode_matkul', 'ASC')
            ->get()->getResultArray();
    }

    public function InsertData($data)
    {
        return $this->db->table('tb_mata_kuliah')->insert($data);
    }

    public function UpdateData($data)
    {
        return $this->db->table('tb_mata_kuliah')
            ->where('id_matkul', $data['id_matkul'])
            ->update($data);
    }

    public function DeleteData($id_matkul)
    {
        return $this->db->table('tb_mata_kuliah')
            ->where('id_matkul', $id_matkul)
            ->delete();
    }

    public function getMatkulBySemester($semester)
    {
        return $this->db->table('tb_mata_kuliah')
            ->where('semester', $semester)
            ->orderBy('kode_matkul', 'ASC')
            ->get()->getResultArray();
    }

    public function getByProdi($prodi_id)
    {
        return $this->db->table('tb_mata_kuliah')
            ->join('tb_prodi', 'tb_prodi.id_prodi = tb_mata_kuliah.prodi_id')
            ->select('tb_mata_kuliah.*, tb_prodi.nama_prodi')
            ->where('tb_mata_kuliah.prodi_id', $prodi_id)
            ->orderBy('tb_mata_kuliah.semester', 'ASC')
            ->orderBy('tb_mata_kuliah.kode_matkul', 'ASC')
            ->get()->getResultArray();
    }

    public function getMatkulForKRS($prodi_id, $semester)
    {
        return $this->db->table('tb_mata_kuliah')
            ->where('prodi_id', $prodi_id)
            ->where('semester', $semester)
            ->orderBy('kode_matkul', 'ASC')
            ->get()->getResultArray();
    }
}