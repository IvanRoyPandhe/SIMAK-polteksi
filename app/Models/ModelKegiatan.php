<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKegiatan extends Model
{
    public function AllData()
    {
        return $this->db->table('tb_kegiatan')
            ->orderBy('created_at DESC')
            ->get()->getResultArray();
    }

    public function InsertData($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->table('tb_kegiatan')->insert($data);
    }

    public function EditData($data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->table('tb_kegiatan')
            ->where('id_kegiatan', $data['id_kegiatan'])
            ->update($data);
    }

    public function DeleteData($data)
    {
        $this->db->table('tb_kegiatan')
            ->where('id_kegiatan', $data['id_kegiatan'])
            ->delete($data);
    }
}
