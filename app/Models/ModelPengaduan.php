<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPengaduan extends Model
{
    public function AllData()
    {
        return $this->db->table('tb_pengaduan')
            ->orderBy('status')
            ->orderBy('updated_at DESC')
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
                'status' => 1,
                'user_id' => session()->get('user_id'),
                'updated_at' => date('Y-m-d H:i:s')
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
