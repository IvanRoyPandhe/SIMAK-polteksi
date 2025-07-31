<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelProdi extends Model
{
    protected $table = 'tb_prodi';
    protected $primaryKey = 'id_prodi';
    protected $allowedFields = ['kode_prodi', 'nama_prodi', 'jenjang'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}