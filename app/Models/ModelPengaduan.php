<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPengaduan extends Model
{
    protected $table = 'tb_pengaduan';
    protected $primaryKey = 'id_pengaduan';
    protected $allowedFields = ['nama_pengadu', 'no_hp', 'jenis_masalah', 'masalah', 'status', 'jawaban'];

    public function AllData()
    {
        return $this->db->table('tb_pengaduan')
            ->orderBy('status')
            ->orderBy('updated_at DESC')
            ->get()->getResultArray();
    }

    public function getPengaduanByUser($nama_pengadu)
    {
        return $this->db->table('tb_pengaduan')
            ->where('nama_pengadu', $nama_pengadu)
            ->orderBy('created_at DESC')
            ->get()->getResultArray();
    }

    public function DonasiMasukById($id_pengaduan)
    {
        return $this->db->table('tb_pengaduan')
            ->where('id_pengaduan', $id_pengaduan)
            ->get()
            ->getRowArray();
    }

    public function UpdatePengaduanStatus($id_pengaduan)
    {
        $this->db->table('tb_pengaduan')
            ->where('id_pengaduan', $id_pengaduan)
            ->update([
                'status' => 1
            ]);
    }

    public function JawabPengaduan($data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->table('tb_pengaduan')
            ->where('id_pengaduan', $data['id_pengaduan'])
            ->update($data);
    }

    public function DeletePengaduan($data)
    {
        $this->db->table('tb_pengaduan')
            ->where('id_pengaduan', $data['id_pengaduan'])
            ->delete($data);
    }
}
