<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPeriodeAkademik extends Model
{
    protected $table = 'tb_periode_akademik';
    protected $primaryKey = 'id_periode';
    protected $allowedFields = ['semester', 'tahun_akademik', 'status_krs', 'tgl_mulai_krs', 'tgl_selesai_krs', 'tgl_mulai_kuliah', 'tgl_selesai_kuliah', 'tgl_uts_mulai', 'tgl_uts_selesai', 'tgl_uas_mulai', 'tgl_uas_selesai', 'max_sks_normal', 'max_sks_remedial', 'is_active', 'status_khs', 'keterangan'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';

    public function AllData()
    {
        return $this->db->table('tb_periode_akademik')
            ->orderBy('tahun_akademik', 'DESC')
            ->orderBy('semester', 'DESC')
            ->get()->getResultArray();
    }

    public function getPeriodeAktif()
    {
        return $this->db->table('tb_periode_akademik')
            ->where('is_active', 1)
            ->get()->getRowArray();
    }

    public function setAktif($id_periode)
    {
        // Set semua periode jadi tidak aktif
        $this->db->table('tb_periode_akademik')->update(['is_active' => 0]);
        // Set periode terpilih jadi aktif
        return $this->db->table('tb_periode_akademik')
            ->where('id_periode', $id_periode)
            ->update(['is_active' => 1]);
    }

    public function getStatistik($id_periode)
    {
        $db = \Config\Database::connect();
        
        $total_mahasiswa = $db->table('tb_krs')
            ->where('periode_id', $id_periode)
            ->countAllResults(false);
            
        $krs_disetujui = $db->table('tb_krs')
            ->where('periode_id', $id_periode)
            ->where('status', 'Disetujui')
            ->countAllResults();
            
        $krs_pending = $db->table('tb_krs')
            ->where('periode_id', $id_periode)
            ->where('status', 'Menunggu Persetujuan')
            ->countAllResults();
            
        $total_kelas = $db->table('tb_kelas')
            ->where('periode_id', $id_periode)
            ->countAllResults();
            
        return [
            'total_mahasiswa' => $total_mahasiswa,
            'krs_disetujui' => $krs_disetujui,
            'krs_pending' => $krs_pending,
            'total_kelas' => $total_kelas
        ];
    }

    public function getJadwalPenting($id_periode)
    {
        $periode = $this->find($id_periode);
        if (!$periode) return [];
        
        $jadwal = [];
        $today = date('Y-m-d');
        
        if ($periode['tgl_mulai_krs'] && $periode['tgl_selesai_krs']) {
            $status = ($today >= $periode['tgl_mulai_krs'] && $today <= $periode['tgl_selesai_krs']) ? 'active' : 
                     ($today < $periode['tgl_mulai_krs'] ? 'upcoming' : 'completed');
            $jadwal[] = [
                'nama' => 'Periode KRS',
                'tanggal' => $periode['tgl_mulai_krs'] . ' - ' . $periode['tgl_selesai_krs'],
                'status' => $status
            ];
        }
        
        if ($periode['tgl_uts_mulai'] && $periode['tgl_uts_selesai']) {
            $status = ($today >= $periode['tgl_uts_mulai'] && $today <= $periode['tgl_uts_selesai']) ? 'active' : 
                     ($today < $periode['tgl_uts_mulai'] ? 'upcoming' : 'completed');
            $jadwal[] = [
                'nama' => 'Ujian Tengah Semester',
                'tanggal' => $periode['tgl_uts_mulai'] . ' - ' . $periode['tgl_uts_selesai'],
                'status' => $status
            ];
        }
        
        if ($periode['tgl_uas_mulai'] && $periode['tgl_uas_selesai']) {
            $status = ($today >= $periode['tgl_uas_mulai'] && $today <= $periode['tgl_uas_selesai']) ? 'active' : 
                     ($today < $periode['tgl_uas_mulai'] ? 'upcoming' : 'completed');
            $jadwal[] = [
                'nama' => 'Ujian Akhir Semester',
                'tanggal' => $periode['tgl_uas_mulai'] . ' - ' . $periode['tgl_uas_selesai'],
                'status' => $status
            ];
        }
        
        return $jadwal;
    }

    public function InsertData($data)
    {
        return $this->db->table('tb_periode_akademik')->insert($data);
    }

    public function UpdateData($data)
    {
        return $this->db->table('tb_periode_akademik')
            ->where('id_periode', $data['id_periode'])
            ->update($data);
    }

    public function DeleteData($id_periode)
    {
        return $this->db->table('tb_periode_akademik')
            ->where('id_periode', $id_periode)
            ->delete();
    }
}