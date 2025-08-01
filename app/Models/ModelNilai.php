<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelNilai extends Model
{
    protected $table = 'tb_nilai';
    protected $primaryKey = 'id_nilai';
    protected $allowedFields = ['mahasiswa_id', 'matkul_id', 'kelas_id', 'periode_id', 'nilai_tugas', 'nilai_uts', 'nilai_uas', 'nilai_akhir', 'nilai_huruf', 'bobot', 'status'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getMahasiswaByMatkul($matkul_id)
    {
        return $this->db->table('tb_krs')
                       ->select('tb_mahasiswa.id_mahasiswa, tb_mahasiswa.nim, tb_mahasiswa.nama, 
                                tb_nilai.nilai_tugas, tb_nilai.nilai_uts, tb_nilai.nilai_uas, 
                                tb_nilai.nilai_akhir, tb_nilai.nilai_huruf')
                       ->join('tb_kelas', 'tb_kelas.id_kelas = tb_krs.kelas_id')
                       ->join('tb_mahasiswa', 'tb_mahasiswa.id_mahasiswa = tb_krs.mahasiswa_id')
                       ->join('tb_nilai', 'tb_nilai.mahasiswa_id = tb_mahasiswa.id_mahasiswa AND tb_nilai.matkul_id = tb_kelas.matkul_id', 'left')
                       ->where('tb_kelas.matkul_id', $matkul_id)
                       ->where('tb_krs.status', 'Disetujui')
                       ->groupBy('tb_mahasiswa.id_mahasiswa')
                       ->get()
                       ->getResultArray();
    }

    public function getNilaiByMahasiswa($mahasiswa_id)
    {
        return $this->db->table('tb_nilai')
                       ->select('tb_nilai.*, tb_mata_kuliah.kode_matkul, tb_mata_kuliah.nama_matkul, tb_mata_kuliah.sks')
                       ->join('tb_mata_kuliah', 'tb_mata_kuliah.id_matkul = tb_nilai.matkul_id')
                       ->where('tb_nilai.mahasiswa_id', $mahasiswa_id)
                       ->orderBy('tb_mata_kuliah.semester', 'ASC')
                       ->get()
                       ->getResultArray();
    }

    public function getAllNilaiWithDetails()
    {
        return $this->db->table('tb_nilai')
                       ->select('tb_nilai.*, tb_mahasiswa.nim, tb_mahasiswa.nama as nama_mahasiswa, 
                                tb_mata_kuliah.kode_matkul, tb_mata_kuliah.nama_matkul, tb_mata_kuliah.sks,
                                tb_periode_akademik.semester, tb_periode_akademik.tahun_akademik')
                       ->join('tb_mahasiswa', 'tb_mahasiswa.id_mahasiswa = tb_nilai.mahasiswa_id')
                       ->join('tb_mata_kuliah', 'tb_mata_kuliah.id_matkul = tb_nilai.matkul_id')
                       ->join('tb_periode_akademik', 'tb_periode_akademik.id_periode = tb_nilai.periode_id', 'left')
                       ->orderBy('tb_nilai.created_at', 'DESC')
                       ->get()
                       ->getResultArray();
    }
}