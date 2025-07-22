<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLaporan extends Model
{
    public function FilterDataLaporan($bulan = null, $kategori = null, $status = null, $tahun = null)
    {
        $builder = $this->db->table('tb_keuangan_internal');
        if ($bulan !== null) {
            $builder->where('month(tgl)', $bulan);
        }
        if ($kategori !== null) {
            $builder->where('kategori', $kategori);
        }
        if ($status !== null) {
            $builder->where('status', $status);
        }
        if ($tahun !== null) {
            $builder->where('year(tgl)', $tahun);
        }
        return $builder->get()->getResultArray();
    }

    public function AllDataLaporanByAll($bulan, $kategori, $status, $tahun)
    {
        return $this->db->table('tb_keuangan_internal')
            ->where('month(tgl)', $bulan)
            ->where('kategori', $kategori)
            ->where('status', $status)
            ->where('year(tgl)', $tahun)
            ->orderBy('tgl')
            ->get()->getResultArray();
    }

    public function AllDataLaporanByBulanTahun($bulan, $tahun)
    {
        return $this->db->table('tb_keuangan_internal')
            ->where('month(tgl)', $bulan)
            ->where('year(tgl)', $tahun)
            ->orderBy('tgl')
            ->get()->getResultArray();
    }

    public function AllDataLaporanByKategoriTahun($kategori, $tahun)
    {
        return $this->db->table('tb_keuangan_internal')
            ->where('kategori', $kategori)
            ->where('year(tgl)', $tahun)
            ->orderBy('tgl')
            ->get()->getResultArray();
    }

    public function AllDataLaporanByStatusTahun($status, $tahun)
    {
        return $this->db->table('tb_keuangan_internal')
            ->where('status', $status)
            ->where('year(tgl)', $tahun)
            ->orderBy('tgl')
            ->get()->getResultArray();
    }

    public function AllDataLaporanByBulanKategoriTahun($bulan, $kategori, $tahun)
    {
        return $this->db->table('tb_keuangan_internal')
            ->where('month(tgl)', $bulan)
            ->where('kategori', $kategori)
            ->where('year(tgl)', $tahun)
            ->orderBy('tgl')
            ->get()->getResultArray();
    }

    public function AllDataLaporanByBulanStatusTahun($bulan, $status, $tahun)
    {
        return $this->db->table('tb_keuangan_internal')
            ->where('month(tgl)', $bulan)
            ->where('status', $status)
            ->where('year(tgl)', $tahun)
            ->orderBy('tgl')
            ->get()->getResultArray();
    }

    public function AllDataLaporanByKategoriStatusTahun($kategori, $status, $tahun)
    {
        return $this->db->table('tb_keuangan_internal')
            ->where('kategori', $kategori)
            ->where('status', $status)
            ->where('year(tgl)', $tahun)
            ->orderBy('tgl')
            ->get()->getResultArray();
    }

    public function AllDataLaporanByYear($tahun)
    {
        return $this->db->table('tb_keuangan_internal')
            ->where('year(tgl)', $tahun)
            ->orderBy('kategori')
            ->orderBy('tgl')
            ->get()->getResultArray();
    }

    public function getTahunKeuangan()
    {
        return $this->db->table('tb_keuangan_internal')
            ->select('YEAR(tgl) AS tahun')
            ->distinct()->orderBy('tahun', 'ASC')
            ->get()->getResult();
    }

    public function getKategoriKeuangan()
    {
        return $this->db->table('tb_keuangan_internal')
            ->select('kategori')
            ->distinct()
            ->orderBy('kategori', 'ASC')
            ->get()->getResult();
    }

    public function getTahunBisyaroh()
    {
        return $this->db->table('tb_bisyaroh')
            ->select('tahun')
            ->distinct()->orderBy('tahun', 'ASC')
            ->get()->getResult();
    }

    public function AllDataLaporanBisyaroh($bulan, $tahun)
    {
        return $this->db->table('tb_bisyaroh')
            ->where('bulan_id', $bulan)
            ->where('tahun', $tahun)
            ->get()->getResultArray();
    }

    public function AllDataLaporanInventarisMasuk()
    {
        return $this->db->table('tb_inventaris')
            ->where('status', '0')
            ->get()->getResultArray();
    }

    public function AllDataLaporanInventarisKeluar()
    {
        return $this->db->table('tb_inventaris')
            ->where('status', '1')
            ->get()->getResultArray();
    }
}
