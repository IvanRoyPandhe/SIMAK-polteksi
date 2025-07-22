<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDonasi extends Model
{
    protected $useTimestamps = true;
    protected $table = 'tb_donasi';
    protected $primaryKey = 'id_donasi';

    public function AllData()
    {
        return $this->db->table('tb_rekening')
            ->orderBy('created_at DESC')->get()->getResultArray();
    }

    public function InsertData($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->table('tb_rekening')->insert($data);
    }

    public function EditData($data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->table('tb_rekening')
            ->where('id_rekening', $data['id_rekening'])
            ->update($data);
    }

    public function DeleteData($data)
    {
        $this->db->table('tb_rekening')
            ->where('id_rekening', $data['id_rekening'])
            ->delete($data);
    }

    public function AllDataDonasi()
    {
        return $this->db->table('tb_donasi')
            ->join('tb_rekening', 'tb_rekening.id_rekening = tb_donasi.rekening_id', 'left')
            ->select('tb_rekening.no_rek as no_rek_tujuan')
            ->select('tb_rekening.nama_bank as nama_bank_tujuan')
            ->select('tb_rekening.nama_rek as nama_rek_tujuan')
            ->select('tb_donasi.*')
            ->where('jenis', 'Tunai')
            ->orderBy('status')
            ->orderBy('updated_at DESC')
            ->get()->getResultArray();
    }

    public function DonasiMasukById($id_donasi)
    {
        return $this->db->table('tb_donasi')
            ->where('id_donasi', $id_donasi)
            ->get()
            ->getRowArray();
    }

    public function UpdateDonasiStatus($id_donasi)
    {
        $this->db->table('tb_donasi')
            ->where('id_donasi', $id_donasi)
            ->update(['status' => 'Telah Tervalidasi', 'updated_at' => date('Y-m-d H:i:s')]);
    }

    public function DeleteDonasiMasuk($data)
    {
        $this->db->table('tb_donasi')
            ->where('id_donasi', $data['id_donasi'])
            ->delete($data);
    }

    public function AllDataDonasiBarang()
    {
        return $this->db->table('tb_donasi')
            ->where('jenis', 'Barang')
            ->orderBy('created_at DESC')
            ->get()->getResultArray();
    }

    public function InsertDonasiBarang($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->table('tb_donasi')->insert($data);
    }

    public function EditDonasiBarang($id_donasi, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->table($this->table)
            ->where('id_donasi', $id_donasi)
            ->update($data);
    }

    public function DeleteDonasiMasukBarang($data)
    {
        $this->db->table('tb_donasi')
            ->where('id_donasi', $data['id_donasi'])
            ->delete($data);
    }
}
