<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAuth extends Model
{
    protected $table = 'tb_users';
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['id_user', 'nama', 'email', 'password', 'level'];

    public function findUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function EditProfile($id_user, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->table($this->table)
            ->where('id_user', $id_user)
            ->update($data);
    }
}
