<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelMahasiswa extends Model
{
    protected $table = 'tb_mahasiswa';
    protected $primaryKey = 'id_mahasiswa';
    protected $allowedFields = ['nim', 'nama', 'email', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama', 'alamat', 'no_hp', 'nama_ayah', 'nama_ibu', 'pekerjaan_ayah', 'pekerjaan_ibu', 'no_hp_ortu', 'foto', 'prodi_id', 'kurikulum_id', 'tahun_angkatan', 'dosen_pa_id', 'semester', 'ipk', 'sks_lulus', 'semester_aktif', 'status_akademik', 'status'];

    public function AllData()
    {
        return $this->db->table('tb_mahasiswa')
            ->join('tb_prodi', 'tb_prodi.id_prodi = tb_mahasiswa.prodi_id', 'left')
            ->join('tb_dosen', 'tb_dosen.id_dosen = tb_mahasiswa.dosen_pa_id', 'left')
            ->select('tb_mahasiswa.*, tb_prodi.nama_prodi, tb_dosen.nama as nama_dosen_pa')
            ->orderBy('tb_prodi.nama_prodi', 'ASC')
            ->orderBy('tb_mahasiswa.nim', 'ASC')
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

    public function getByNim($nim)
    {
        return $this->where('nim', $nim)->first();
    }

    public function getByProdi($prodi_id)
    {
        return $this->where('prodi_id', $prodi_id)->findAll();
    }

    public function getBiodataWithAkademik($user_id)
    {
        return $this->db->table('tb_mahasiswa')
            ->join('tb_prodi', 'tb_prodi.id_prodi = tb_mahasiswa.prodi_id', 'left')
            ->join('tb_dosen', 'tb_dosen.id_dosen = tb_mahasiswa.dosen_pa_id', 'left')
            ->select('tb_mahasiswa.*, tb_prodi.nama_prodi, tb_dosen.nama as nama_dosen_pa')
            ->where('tb_mahasiswa.id_mahasiswa', $user_id)
            ->get()->getRowArray();
    }

    public function updateBiodata($id_mahasiswa, $data)
    {
        return $this->update($id_mahasiswa, $data);
    }

    public function getActiveStudents()
    {
        return $this->where('status', 'Aktif')->findAll();
    }
}