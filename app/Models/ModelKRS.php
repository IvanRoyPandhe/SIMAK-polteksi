<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKRS extends Model
{
    protected $table = 'tb_krs';
    protected $primaryKey = 'id_krs';
    protected $allowedFields = ['mahasiswa_id', 'mata_kuliah_id', 'kelas_id', 'periode_id', 'status', 'catatan', 'tgl_pengajuan', 'tgl_persetujuan'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function AllData()
    {
        return $this->db->table('tb_krs')
            ->join('tb_mahasiswa', 'tb_mahasiswa.id_mahasiswa = tb_krs.mahasiswa_id')
            ->join('tb_mata_kuliah', 'tb_mata_kuliah.id_matkul = tb_krs.mata_kuliah_id')
            ->join('tb_periode_akademik', 'tb_periode_akademik.id_periode = tb_krs.periode_id', 'left')
            ->select('tb_krs.*, tb_mahasiswa.nama as nama_mahasiswa, tb_mahasiswa.nim, tb_mahasiswa.semester_aktif, tb_mata_kuliah.kode_matkul, tb_mata_kuliah.nama_matkul, tb_mata_kuliah.sks, tb_periode_akademik.tahun_akademik')
            ->orderBy('tb_krs.created_at', 'DESC')
            ->get()->getResultArray();
    }

    public function InsertData($data)
    {
        return $this->db->table('tb_krs')->insert($data);
    }

    public function UpdateStatus($data)
    {
        return $this->db->table('tb_krs')
            ->where('id_krs', $data['id_krs'])
            ->update(['status' => $data['status']]);
    }

    public function DeleteData($id_krs)
    {
        return $this->db->table('tb_krs')
            ->where('id_krs', $id_krs)
            ->delete();
    }

    public function getKRSByMahasiswa($mahasiswa_id, $periode_id)
    {
        return $this->db->table('tb_krs')
            ->join('tb_kelas', 'tb_kelas.id_kelas = tb_krs.kelas_id')
            ->join('tb_mata_kuliah', 'tb_mata_kuliah.id_matkul = tb_kelas.matkul_id')
            ->select('tb_krs.*, tb_mata_kuliah.kode_matkul, tb_mata_kuliah.nama_matkul, tb_mata_kuliah.sks')
            ->where('tb_krs.mahasiswa_id', $mahasiswa_id)
            ->where('tb_krs.periode_id', $periode_id)
            ->get()->getResultArray();
    }

    public function getKRSForApproval($dosen_id)
    {
        return $this->db->table('tb_krs')
            ->join('tb_mahasiswa', 'tb_mahasiswa.id_mahasiswa = tb_krs.mahasiswa_id')
            ->join('tb_kelas', 'tb_kelas.id_kelas = tb_krs.kelas_id')
            ->join('tb_mata_kuliah', 'tb_mata_kuliah.id_matkul = tb_kelas.matkul_id')
            ->join('tb_periode_akademik', 'tb_periode_akademik.id_periode = tb_krs.periode_id')
            ->select('tb_krs.*, tb_mahasiswa.nama as nama_mahasiswa, tb_mahasiswa.nim, tb_mata_kuliah.kode_matkul, tb_mata_kuliah.nama_matkul, tb_mata_kuliah.sks, tb_periode_akademik.semester, tb_periode_akademik.tahun_akademik')
            ->where('tb_mahasiswa.dosen_pa_id', $dosen_id)
            ->where('tb_krs.status', 'Menunggu Persetujuan')
            ->orderBy('tb_krs.tgl_pengajuan', 'DESC')
            ->get()->getResultArray();
    }

    public function approveKRS($id_krs, $status, $catatan = null)
    {
        $data = [
            'status' => $status,
            'catatan' => $catatan,
            'tgl_persetujuan' => date('Y-m-d H:i:s')
        ];
        return $this->db->table('tb_krs')
            ->where('id_krs', $id_krs)
            ->update($data);
    }

    public function ajukanKRS($mahasiswa_id, $periode_id)
    {
        return $this->db->table('tb_krs')
            ->where('mahasiswa_id', $mahasiswa_id)
            ->where('periode_id', $periode_id)
            ->where('status', 'Draft')
            ->update([
                'status' => 'Menunggu Persetujuan',
                'tgl_pengajuan' => date('Y-m-d H:i:s')
            ]);
    }

    public function countPesertaKelas($kelas_id)
    {
        return $this->db->table('tb_krs')
            ->where('kelas_id', $kelas_id)
            ->where('status !=', 'Ditolak')
            ->countAllResults();
    }

    public function getTotalSKSMahasiswa($mahasiswa_id, $periode_id)
    {
        $result = $this->db->table('tb_krs')
            ->join('tb_kelas', 'tb_kelas.id_kelas = tb_krs.kelas_id')
            ->join('tb_mata_kuliah', 'tb_mata_kuliah.id_matkul = tb_kelas.matkul_id')
            ->select('SUM(tb_mata_kuliah.sks) as total_sks')
            ->where('tb_krs.mahasiswa_id', $mahasiswa_id)
            ->where('tb_krs.periode_id', $periode_id)
            ->where('tb_krs.status !=', 'Ditolak')
            ->get()->getRowArray();
        
        return $result['total_sks'] ?? 0;
    }
}