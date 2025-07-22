<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKasInternal extends Model
{
    public function AllData()
    {
        return $this->db->table('tb_keuangan_internal')
            ->orderBy('created_at DESC')
            ->get()->getResultArray();
    }

    public function AllDataDanaMasuk()
    {
        return $this->db->table('tb_keuangan_internal')
            ->where('status', 'Masuk')
            ->orderBy('created_at DESC')
            ->get()->getResultArray();
    }

    public function AllDataDanaKeluar()
    {
        return $this->db->table('tb_keuangan_internal')
            ->where('status', 'Keluar')
            ->orderBy('created_at DESC')
            ->get()->getResultArray();
    }

    public function InsertData($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->table('tb_keuangan_internal')->insert($data);
    }

    public function EditData($data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->table('tb_keuangan_internal')
            ->where('id_keuangan', $data['id_keuangan'])
            ->update($data);
    }

    public function DeleteData($data)
    {
        $this->db->table('tb_keuangan_internal')
            ->where('id_keuangan', $data['id_keuangan'])
            ->delete($data);
    }

    public function TruncateData()
    {
        $this->db->table('tb_keuangan_internal')->truncate();
    }

    public function AllDataLaporan($bulan, $tahun)
    {
        return $this->db->table('tb_keuangan_internal')
            ->where('month(tgl)', $bulan)
            ->where('year(tgl)', $tahun)
            ->get()->getResultArray();
    }

    public function countByKategori($kategori)
    {
        return $this->db->table('tb_keuangan_internal')
            ->where('kategori', $kategori)
            ->countAllResults();
    }

    public function getTotalBalance()
    {
        $result = $this->db->table('tb_keuangan_internal')
            ->select('(SUM(dana_masuk) - SUM(dana_keluar)) as total_balance')
            ->get()
            ->getRowArray();
        return (float)$result['total_balance'];
    }
}
