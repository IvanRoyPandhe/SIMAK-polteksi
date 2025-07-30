<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUser extends Model
{
    protected $table = 'tb_users';
    protected $primaryKey = 'id_user';

    public function getUserLevel($level = null, $search = null)
    {
        $this->select('tb_users.*, tb_level_user.nama_level')
            ->join('tb_level_user', 'tb_level_user.id_level = tb_users.level_id');
        if ($level) {
            if ($level == 'admin') {
                $this->whereIn('tb_users.level_id', [1, 2]);
            } elseif ($level == 'mahasiswa') {
                $this->where('tb_users.level_id', 4);
            } elseif ($level == 'petugas') {
                $this->where('tb_users.level_id', 3);
            }
        }
        if ($search) {
            $this->groupStart()
                ->like('tb_users.nama', $search)
                ->orLike('tb_users.email', $search)
                ->groupEnd();
        }
        return $this->paginate(9, 'user');
    }

    public function AllDataUser()
    {
        return $this->db->table('tb_users')
            ->orderBy('created_at DESC')
            ->get()->getResultArray();
    }

    public function AllDataLevelUser()
    {
        return $this->db->table('tb_level_user')
            ->get()->getResultArray();
    }

    public function InsertUser($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->table('tb_users')->insert($data);
    }

    public function getUserById($id_user)
    {
        return $this->where('id_user', $id_user)->first();
    }

    public function EditUser($id_user, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->table($this->table)
            ->where('id_user', $id_user)
            ->update($data);
    }
}
