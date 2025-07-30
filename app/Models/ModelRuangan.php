<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelRuangan extends Model
{
    protected $table = 'tb_ruangan';
    protected $primaryKey = 'id_ruangan';
    protected $allowedFields = ['nama_ruangan', 'kapasitas', 'fasilitas', 'status', 'user_id'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function AllData()
    {
        return $this->db->table('tb_ruangan')
            ->join('tb_users', 'tb_users.id_user = tb_ruangan.user_id')
            ->select('tb_ruangan.*, tb_users.nama as nama_user')
            ->orderBy('tb_ruangan.created_at', 'DESC')
            ->get()->getResultArray();
    }

    public function InsertData($data)
    {
        return $this->db->table('tb_ruangan')->insert($data);
    }

    public function UpdateData($data)
    {
        return $this->db->table('tb_ruangan')
            ->where('id_ruangan', $data['id_ruangan'])
            ->update($data);
    }

    public function DeleteData($id_ruangan)
    {
        return $this->db->table('tb_ruangan')
            ->where('id_ruangan', $id_ruangan)
            ->delete();
    }

    public function getRuanganTersedia()
    {
        return $this->db->table('tb_ruangan')
            ->where('status', 'Tersedia')
            ->orderBy('nama_ruangan', 'ASC')
            ->get()->getResultArray();
    }
}