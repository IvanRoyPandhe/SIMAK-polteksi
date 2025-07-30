<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBeasiswa extends Model
{
    protected $table = 'tb_beasiswa';
    protected $primaryKey = 'id_beasiswa';
    protected $allowedFields = ['nama_beasiswa', 'jenis', 'jumlah_dana', 'kuota', 'persyaratan', 'batas_pendaftaran', 'status'];

    public function AllData()
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    public function InsertData($data)
    {
        return $this->insert($data);
    }

    public function UpdateData($id, $data)
    {
        return $this->update($id, $data);
    }

    public function DeleteData($id)
    {
        return $this->delete($id);
    }

    public function getActiveScholarships()
    {
        return $this->where('status', 'Buka')
                   ->where('batas_pendaftaran >=', date('Y-m-d'))
                   ->findAll();
    }

    public function getByJenis($jenis)
    {
        return $this->where('jenis', $jenis)->findAll();
    }
}