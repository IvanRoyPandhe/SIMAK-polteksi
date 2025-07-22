<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAdmin extends Model
{
    protected $table = 'tb_keuangan_internal';

    public function ViewSetting()
    {
        return $this->db->table('tb_setting')
            ->where('id_set', 1)
            ->get()->getRowArray();
    }

    public function EditSetting($data)
    {
        $this->db->table('tb_setting')
            ->where('id_set', 1)
            ->update($data);
    }

    public function AllDataKasInternal()
    {
        return $this->db->table('tb_keuangan_internal')
            ->where('month(tgl)', date('m'))
            ->where('year(tgl)', date('Y'))
            ->orderBy('tgl')
            ->get()->getResultArray();
    }

    public function getMonthlyData()
    {
        $month1 = date('Y-m', strtotime('-2 months'));
        $month2 = date('Y-m', strtotime('-1 months'));
        $month3 = date('Y-m');
        $query = $this->db->query("
            SELECT 
                DATE_FORMAT(tgl, '%Y-%m') AS bulan,
                SUM(dana_masuk) AS total_masuk,
                SUM(dana_keluar) AS total_keluar
            FROM tb_keuangan_internal
            WHERE 
                DATE_FORMAT(tgl, '%Y-%m') IN ('$month1', '$month2', '$month3')
            GROUP BY DATE_FORMAT(tgl, '%Y-%m')
            ORDER BY bulan ASC
        ");
        return $query->getResultArray();
    }

    public function getMonthlyKegiatan()
    {
        $month1 = date('Y-m', strtotime('-2 months'));
        $month2 = date('Y-m', strtotime('-1 months'));
        $month3 = date('Y-m');
        $query = $this->db->query("
            SELECT 
                DATE_FORMAT(tgl, '%Y-%m') AS bulan,
                COUNT(*) AS total_kegiatan
            FROM tb_kegiatan
            WHERE 
                DATE_FORMAT(tgl, '%Y-%m') IN ('$month1', '$month2', '$month3')
            GROUP BY DATE_FORMAT(tgl, '%Y-%m')
            ORDER BY bulan ASC
        ");
        return $query->getResultArray();
    }

    public function getMonthlyArtikel()
    {
        $month1 = date('Y-m', strtotime('-2 months'));
        $month2 = date('Y-m', strtotime('-1 months'));
        $month3 = date('Y-m');
        $query = $this->db->query("
            SELECT 
                DATE_FORMAT(created_at, '%Y-%m') AS bulan,
                COUNT(*) AS total_artikel
            FROM tb_artikel
            WHERE 
                DATE_FORMAT(created_at, '%Y-%m') IN ('$month1', '$month2', '$month3')
            GROUP BY DATE_FORMAT(created_at, '%Y-%m')
            ORDER BY bulan ASC
        ");
        return $query->getResultArray();
    }

    public function AllDataPengaduan()
    {
        return $this->db->table('tb_pengaduan')
            ->where('status', '0')
            ->get()->getResultArray();
    }

    public function AllDataDonasi()
    {
        return $this->db->table('tb_donasi')
            ->join('tb_rekening', 'tb_rekening.id_rekening = tb_donasi.rekening_id', 'left')
            ->select('tb_rekening.no_rek as no_rek_tujuan')
            ->select('tb_rekening.nama_bank as nama_bank_tujuan')
            ->select('tb_rekening.nama_rek as nama_rek_tujuan')
            ->select('tb_donasi.*, tb_rekening.nama_rek as nama_rekening')
            ->where('jenis', 'Tunai')
            ->where('status', 'Belum Tervalidasi')
            ->orderBy('created_at DESC')
            ->get()->getResultArray();
    }

    public function getUserById($user_id)
    {
        return $this->db->table('tb_users')
            ->where('id_user', $user_id)
            ->get()
            ->getRowArray();
    }
}
