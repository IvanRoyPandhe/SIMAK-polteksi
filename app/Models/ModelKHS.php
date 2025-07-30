<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKHS extends Model
{
    protected $table = 'tb_khs';
    protected $primaryKey = 'id_khs';
    protected $allowedFields = ['mahasiswa_id', 'matkul_id', 'semester_aktif', 'tahun_akademik', 'nilai_angka', 'nilai_huruf', 'bobot'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function AllData()
    {
        return $this->db->table('tb_khs')
            ->join('tb_mahasiswa', 'tb_mahasiswa.id_mahasiswa = tb_khs.mahasiswa_id')
            ->join('tb_mata_kuliah', 'tb_mata_kuliah.id_matkul = tb_khs.matkul_id')
            ->select('tb_khs.*, tb_mahasiswa.nama as nama_mahasiswa, tb_mahasiswa.nim, tb_mata_kuliah.kode_matkul, tb_mata_kuliah.nama_matkul, tb_mata_kuliah.sks')
            ->orderBy('tb_khs.created_at', 'DESC')
            ->get()->getResultArray();
    }

    public function InsertData($data)
    {
        return $this->db->table('tb_khs')->insert($data);
    }

    public function DeleteData($id_khs)
    {
        return $this->db->table('tb_khs')
            ->where('id_khs', $id_khs)
            ->delete();
    }

    public function getKHSByMahasiswa($mahasiswa_id, $semester_aktif, $tahun_akademik)
    {
        return $this->db->table('tb_khs')
            ->join('tb_mata_kuliah', 'tb_mata_kuliah.id_matkul = tb_khs.matkul_id')
            ->select('tb_khs.*, tb_mata_kuliah.kode_matkul, tb_mata_kuliah.nama_matkul, tb_mata_kuliah.sks')
            ->where('tb_khs.mahasiswa_id', $mahasiswa_id)
            ->where('tb_khs.semester_aktif', $semester_aktif)
            ->where('tb_khs.tahun_akademik', $tahun_akademik)
            ->get()->getResultArray();
    }

    public function calculateIPK($mahasiswa_id)
    {
        $result = $this->db->table('tb_khs')
            ->join('tb_mata_kuliah', 'tb_mata_kuliah.id_matkul = tb_khs.matkul_id')
            ->select('SUM(tb_khs.bobot * tb_mata_kuliah.sks) as total_bobot, SUM(tb_mata_kuliah.sks) as total_sks')
            ->where('tb_khs.mahasiswa_id', $mahasiswa_id)
            ->get()->getRowArray();
        
        if ($result['total_sks'] > 0) {
            return round($result['total_bobot'] / $result['total_sks'], 2);
        }
        return 0.00;
    }

    public function getKelasByDosen($dosen_id)
    {
        return $this->db->table('tb_kelas')
            ->join('tb_mata_kuliah', 'tb_mata_kuliah.id_matkul = tb_kelas.matkul_id')
            ->join('tb_periode_akademik', 'tb_periode_akademik.id_periode = tb_kelas.periode_id')
            ->select('tb_kelas.*, tb_mata_kuliah.kode_matkul, tb_mata_kuliah.nama_matkul, tb_mata_kuliah.sks, tb_periode_akademik.semester, tb_periode_akademik.tahun_akademik')
            ->where('tb_kelas.dosen_id', $dosen_id)
            ->orderBy('tb_periode_akademik.tahun_akademik', 'DESC')
            ->get()->getResultArray();
    }

    public function saveOrUpdateNilai($data)
    {
        $existing = $this->db->table('tb_khs')
            ->where('mahasiswa_id', $data['mahasiswa_id'])
            ->where('matkul_id', $data['matkul_id'])
            ->where('semester_aktif', $data['semester_aktif'])
            ->where('tahun_akademik', $data['tahun_akademik'])
            ->get()->getRowArray();
        
        if ($existing) {
            return $this->db->table('tb_khs')
                ->where('id_khs', $existing['id_khs'])
                ->update($data);
        } else {
            return $this->db->table('tb_khs')->insert($data);
        }
    }
}