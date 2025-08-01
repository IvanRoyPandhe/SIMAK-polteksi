<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelMataKuliah extends Model
{
    protected $table = 'tb_mata_kuliah';
    protected $primaryKey = 'id_matkul';
    protected $allowedFields = ['kode_matkul', 'nama_matkul', 'prodi_id', 'kurikulum_id', 'jenis', 'sks', 'semester', 'dosen_id'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getAllWithDosen()
    {
        return $this->select('tb_mata_kuliah.id_matkul, tb_mata_kuliah.kode_matkul, tb_mata_kuliah.nama_matkul, tb_mata_kuliah.sks, tb_mata_kuliah.semester, tb_prodi.nama_prodi, tb_dosen.nama as nama_dosen')
                    ->join('tb_prodi', 'tb_prodi.id_prodi = tb_mata_kuliah.prodi_id', 'left')
                    ->join('tb_dosen', 'tb_dosen.id_dosen = tb_mata_kuliah.dosen_id', 'left')
                    ->orderBy('tb_mata_kuliah.prodi_id', 'ASC')
                    ->orderBy('tb_mata_kuliah.semester', 'ASC')
                    ->limit(100)
                    ->findAll();
    }

    public function getByDosen($dosen_id)
    {
        return $this->select('tb_mata_kuliah.*, tb_prodi.nama_prodi')
                    ->join('tb_prodi', 'tb_prodi.id_prodi = tb_mata_kuliah.prodi_id', 'left')
                    ->where('tb_mata_kuliah.dosen_id', $dosen_id)
                    ->findAll();
    }

    public function getMatkulForKRS($prodi_id, $semester)
    {
        return $this->select('tb_mata_kuliah.*, tb_dosen.nama as nama_dosen')
                    ->join('tb_dosen', 'tb_dosen.id_dosen = tb_mata_kuliah.dosen_id', 'left')
                    ->where('tb_mata_kuliah.prodi_id', $prodi_id)
                    ->where('tb_mata_kuliah.semester', $semester)
                    ->findAll();
    }

    public function AllData()
    {
        return $this->select('tb_mata_kuliah.*, tb_prodi.nama_prodi, tb_dosen.nama as nama_dosen')
                    ->join('tb_prodi', 'tb_prodi.id_prodi = tb_mata_kuliah.prodi_id', 'left')
                    ->join('tb_dosen', 'tb_dosen.id_dosen = tb_mata_kuliah.dosen_id', 'left')
                    ->orderBy('tb_mata_kuliah.prodi_id', 'ASC')
                    ->orderBy('tb_mata_kuliah.semester', 'ASC')
                    ->findAll();
    }
}