<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelNilai extends Model
{
    protected $table = 'tb_nilai';
    protected $primaryKey = 'id_nilai';
    protected $allowedFields = ['mahasiswa_id', 'matkul_id', 'kelas_id', 'periode_id', 'nilai_tugas', 'nilai_uts', 'nilai_uas', 'nilai_akhir', 'nilai_huruf', 'bobot', 'status'];

    public function getAllNilaiWithDetails()
    {
        return $this->db->table('tb_nilai')
            ->join('tb_mahasiswa', 'tb_mahasiswa.id_mahasiswa = tb_nilai.mahasiswa_id')
            ->join('tb_mata_kuliah', 'tb_mata_kuliah.id_matkul = tb_nilai.matkul_id')
            ->join('tb_periode_akademik', 'tb_periode_akademik.id_periode = tb_nilai.periode_id')
            ->join('tb_prodi', 'tb_prodi.id_prodi = tb_mahasiswa.prodi_id')
            ->select('tb_nilai.*, tb_mahasiswa.nama, tb_mahasiswa.nim, tb_mata_kuliah.nama_matkul, tb_mata_kuliah.kode_matkul, tb_mata_kuliah.sks, tb_periode_akademik.semester, tb_periode_akademik.tahun_akademik, tb_prodi.nama_prodi')
            ->orderBy('tb_periode_akademik.tahun_akademik', 'DESC')
            ->orderBy('tb_mahasiswa.nim', 'ASC')
            ->get()->getResultArray();
    }

    public function getNilaiByMahasiswa($mahasiswa_id)
    {
        return $this->db->table('tb_nilai')
            ->join('tb_mata_kuliah', 'tb_mata_kuliah.id_matkul = tb_nilai.matkul_id')
            ->join('tb_periode_akademik', 'tb_periode_akademik.id_periode = tb_nilai.periode_id')
            ->select('tb_nilai.*, tb_mata_kuliah.nama_matkul, tb_mata_kuliah.kode_matkul, tb_mata_kuliah.sks, tb_periode_akademik.semester, tb_periode_akademik.tahun_akademik')
            ->where('tb_nilai.mahasiswa_id', $mahasiswa_id)
            ->orderBy('tb_periode_akademik.tahun_akademik', 'DESC')
            ->orderBy('tb_mata_kuliah.kode_matkul', 'ASC')
            ->get()->getResultArray();
    }

    public function hitungNilaiAkhir($nilai_tugas, $nilai_uts, $nilai_uas)
    {
        // Bobot: Tugas 30%, UTS 30%, UAS 40%
        return ($nilai_tugas * 0.3) + ($nilai_uts * 0.3) + ($nilai_uas * 0.4);
    }

    public function konversiNilaiHuruf($nilai_akhir)
    {
        if ($nilai_akhir >= 85) return ['huruf' => 'A', 'bobot' => 4.00];
        if ($nilai_akhir >= 80) return ['huruf' => 'A-', 'bobot' => 3.70];
        if ($nilai_akhir >= 75) return ['huruf' => 'B+', 'bobot' => 3.30];
        if ($nilai_akhir >= 70) return ['huruf' => 'B', 'bobot' => 3.00];
        if ($nilai_akhir >= 65) return ['huruf' => 'B-', 'bobot' => 2.70];
        if ($nilai_akhir >= 60) return ['huruf' => 'C+', 'bobot' => 2.30];
        if ($nilai_akhir >= 55) return ['huruf' => 'C', 'bobot' => 2.00];
        if ($nilai_akhir >= 50) return ['huruf' => 'C-', 'bobot' => 1.70];
        if ($nilai_akhir >= 45) return ['huruf' => 'D', 'bobot' => 1.00];
        return ['huruf' => 'E', 'bobot' => 0.00];
    }

    public function updateIPK($mahasiswa_id)
    {
        $nilai_mahasiswa = $this->getNilaiByMahasiswa($mahasiswa_id);
        $total_bobot = 0;
        $total_sks = 0;

        foreach ($nilai_mahasiswa as $nilai) {
            if ($nilai['status'] == 'Final') {
                $total_bobot += ($nilai['bobot'] * $nilai['sks']);
                $total_sks += $nilai['sks'];
            }
        }

        $ipk = $total_sks > 0 ? $total_bobot / $total_sks : 0;

        // Update IPK di tabel mahasiswa
        $this->db->table('tb_mahasiswa')
            ->where('id_mahasiswa', $mahasiswa_id)
            ->update(['ipk' => $ipk, 'sks_lulus' => $total_sks]);

        return $ipk;
    }
}