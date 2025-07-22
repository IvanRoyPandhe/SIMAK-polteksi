<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBisyaroh extends Model
{
    public function AllDataBulan()
    {
        return $this->db->table('tb_bulan_bisyaroh')
            ->get()->getResultArray();
    }

    public function AllDataBisyaroh($id_bulan)
    {
        return $this->db->table('tb_bisyaroh')
            ->where('bulan_id', $id_bulan)
            ->orderBy('created_at DESC')
            ->get()->getResultArray();
    }

    public function DetailData($id_bulan)
    {
        return $this->db->table('tb_bulan_bisyaroh')
            ->where('id_bulan_bisyaroh', $id_bulan)
            ->get()->getRowArray();
    }

    public function getTotalByMonthAndYear($bulan_id, $tahun)
    {
        return $this->db->table('tb_bisyaroh')
            ->select('SUM(sumbangan_transport) AS total_jumlah')
            ->where('bulan_id', $bulan_id)
            ->where('tahun', $tahun)
            ->get()->getRowArray();
    }

    public function getTotalByMonthAndYearConfirmation($bulan_id, $tahun, $status = 0)
    {
        return $this->db->table('tb_bisyaroh')
            ->select('SUM(sumbangan_transport) AS total_jumlah_konfirmasi')
            ->where('bulan_id', $bulan_id)
            ->where('tahun', $tahun)
            ->where('status', $status)
            ->get()->getRowArray();
    }

    public function UpdateBisyarohStatus($bulan_id, $tahun, $new_status)
    {
        return $this->db->table('tb_bisyaroh')
            ->where('bulan_id', $bulan_id)
            ->where('tahun', $tahun)
            ->where('status', 0)
            ->update(['status' => $new_status]);
    }

    public function InsertData($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->table('tb_bisyaroh')->insert($data);
    }

    public function EditData($data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->table('tb_bisyaroh')
            ->where('id_bisyaroh', $data['id_bisyaroh'])
            ->update($data);
    }

    public function DeleteData($data)
    {
        $this->db->table('tb_bisyaroh')
            ->where('id_bisyaroh', $data['id_bisyaroh'])
            ->delete($data);
    }

    public function getDataStatusZero($bulan_id, $tahun)
    {
        return $this->db->table('tb_bisyaroh')
            ->where('bulan_id', $bulan_id)
            ->where('tahun', $tahun)
            ->where('status', 0)
            ->orderBy('id_bisyaroh', 'desc')
            ->get()->getResultArray();
    }
}
