<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelNilai extends Model
{
    protected $table = 'tb_nilai';
    protected $primaryKey = 'id_nilai';
    protected $allowedFields = ['mahasiswa_id', 'matkul_id', 'kelas_id', 'periode_id', 'nilai_tugas', 'nilai_uts', 'nilai_uas', 'nilai_akhir', 'nilai_huruf', 'bobot', 'status', 'created_by'];
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
}