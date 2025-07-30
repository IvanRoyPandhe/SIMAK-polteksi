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
            ->join('tb_kategori_keuangan', 'tb_kategori_keuangan.id_kategori = tb_keuangan_internal.kategori_id', 'left')
            ->select('tb_keuangan_internal.*, tb_kategori_keuangan.nama_kategori, tb_kategori_keuangan.kode_kategori')
            ->where('month(tgl)', date('m'))
            ->where('year(tgl)', date('Y'))
            ->orderBy('tgl', 'DESC')
            ->get()->getResultArray();
    }

    public function getKeuanganStats()
    {
        $currentMonth = date('Y-m');
        $lastMonth = date('Y-m', strtotime('-1 month'));
        
        // Total pemasukan bulan ini
        $pemasukan_bulan_ini = $this->db->table('tb_keuangan_internal')
            ->selectSum('dana_masuk')
            ->where('DATE_FORMAT(tgl, "%Y-%m")', $currentMonth)
            ->get()->getRowArray()['dana_masuk'] ?? 0;
            
        // Total pengeluaran bulan ini
        $pengeluaran_bulan_ini = $this->db->table('tb_keuangan_internal')
            ->selectSum('dana_keluar')
            ->where('DATE_FORMAT(tgl, "%Y-%m")', $currentMonth)
            ->get()->getRowArray()['dana_keluar'] ?? 0;
            
        // Saldo bank
        $total_saldo_bank = $this->db->table('tb_rekening_bank')
            ->selectSum('saldo_akhir')
            ->where('is_active', 1)
            ->get()->getRowArray()['saldo_akhir'] ?? 0;
            
        // Transaksi pending approval
        $pending_approval = $this->db->table('tb_keuangan_internal')
            ->where('status_approval', 'Pending')
            ->countAllResults();
            
        return [
            'pemasukan_bulan_ini' => $pemasukan_bulan_ini,
            'pengeluaran_bulan_ini' => $pengeluaran_bulan_ini,
            'saldo_bersih' => $pemasukan_bulan_ini - $pengeluaran_bulan_ini,
            'total_saldo_bank' => $total_saldo_bank,
            'pending_approval' => $pending_approval
        ];
    }

    public function getTopKategoriPengeluaran($limit = 5)
    {
        return $this->db->table('tb_keuangan_internal')
            ->join('tb_kategori_keuangan', 'tb_kategori_keuangan.id_kategori = tb_keuangan_internal.kategori_id')
            ->select('tb_kategori_keuangan.nama_kategori, SUM(tb_keuangan_internal.dana_keluar) as total')
            ->where('tb_kategori_keuangan.jenis', 'Pengeluaran')
            ->where('MONTH(tb_keuangan_internal.tgl)', date('m'))
            ->where('YEAR(tb_keuangan_internal.tgl)', date('Y'))
            ->groupBy('tb_kategori_keuangan.id_kategori')
            ->orderBy('total', 'DESC')
            ->limit($limit)
            ->get()->getResultArray();
    }

    public function getCashFlowTrend($months = 6)
    {
        $result = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $monthName = date('M Y', strtotime("-$i months"));
            
            $pemasukan = $this->db->table('tb_keuangan_internal')
                ->selectSum('dana_masuk')
                ->where('DATE_FORMAT(tgl, "%Y-%m")', $month)
                ->get()->getRowArray()['dana_masuk'] ?? 0;
                
            $pengeluaran = $this->db->table('tb_keuangan_internal')
                ->selectSum('dana_keluar')
                ->where('DATE_FORMAT(tgl, "%Y-%m")', $month)
                ->get()->getRowArray()['dana_keluar'] ?? 0;
                
            $result[] = [
                'bulan' => $monthName,
                'pemasukan' => $pemasukan,
                'pengeluaran' => $pengeluaran,
                'saldo' => $pemasukan - $pengeluaran
            ];
        }
        return $result;
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



    public function getUserById($user_id)
    {
        return $this->db->table('tb_users')
            ->select('tb_users.*, tb_users.mahasiswa_id, tb_users.dosen_id')
            ->where('id_user', $user_id)
            ->get()
            ->getRowArray();
    }
}
