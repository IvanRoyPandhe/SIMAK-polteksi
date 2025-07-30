<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKelas extends Model
{
    protected $table = 'tb_kelas';
    protected $primaryKey = 'id_kelas';
    protected $allowedFields = ['matkul_id', 'periode_id', 'dosen_id', 'ruangan_id', 'kapasitas', 'hari', 'jam_mulai', 'jam_selesai'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';

    public function AllData()
    {
        return $this->db->table('tb_kelas')
            ->join('tb_mata_kuliah', 'tb_mata_kuliah.id_matkul = tb_kelas.matkul_id')
            ->join('tb_periode_akademik', 'tb_periode_akademik.id_periode = tb_kelas.periode_id')
            ->join('tb_dosen', 'tb_dosen.id_dosen = tb_kelas.dosen_id')
            ->select('tb_kelas.*, tb_mata_kuliah.kode_matkul, tb_mata_kuliah.nama_matkul, tb_mata_kuliah.sks, tb_periode_akademik.semester, tb_periode_akademik.tahun_akademik, tb_dosen.nama as nama_dosen')
            ->orderBy('tb_periode_akademik.tahun_akademik', 'DESC')
            ->get()->getResultArray();
    }

    public function getKelasByMahasiswa($mahasiswa_id, $periode_id)
    {
        return $this->db->table('tb_kelas')
            ->join('tb_mata_kuliah', 'tb_mata_kuliah.id_matkul = tb_kelas.matkul_id')
            ->join('tb_mahasiswa', 'tb_mahasiswa.prodi_id = tb_mata_kuliah.prodi_id')
            ->join('tb_dosen', 'tb_dosen.id_dosen = tb_kelas.dosen_id')
            ->select('tb_kelas.*, tb_mata_kuliah.kode_matkul, tb_mata_kuliah.nama_matkul, tb_mata_kuliah.sks, tb_mata_kuliah.semester, tb_dosen.nama as nama_dosen')
            ->where('tb_mahasiswa.id_mahasiswa', $mahasiswa_id)
            ->where('tb_kelas.periode_id', $periode_id)
            ->where('tb_mata_kuliah.semester <=', 6) // Batasi semester maksimal
            ->get()->getResultArray();
    }

    public function InsertData($data)
    {
        return $this->db->table('tb_kelas')->insert($data);
    }

    public function UpdateData($data)
    {
        return $this->db->table('tb_kelas')
            ->where('id_kelas', $data['id_kelas'])
            ->update($data);
    }

    public function DeleteData($id_kelas)
    {
        return $this->db->table('tb_kelas')
            ->where('id_kelas', $id_kelas)
            ->delete();
    }
}