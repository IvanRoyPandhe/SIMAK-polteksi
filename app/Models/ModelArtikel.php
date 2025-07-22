<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelArtikel extends Model
{
    protected $table = 'tb_artikel';
    protected $primaryKey = 'id_artikel';

    public function AllDataArtikel()
    {
        return $this->db->table('tb_artikel')
            ->join('tb_kategori_artikel', 'tb_kategori_artikel.id_kat_artikel = tb_artikel.kat_artikel_id', 'left')
            ->select('tb_artikel.*, tb_kategori_artikel.nama as nama_kategori')
            ->orderBy('created_at DESC')
            ->get()->getResultArray();
    }

    public function InsertArtikel($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->table('tb_artikel')->insert($data);
    }

    public function getArtikelById($id_artikel)
    {
        return $this->where('id_artikel', $id_artikel)->first();
    }

    public function EditArtikel($id_artikel, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');

        return $this->db->table($this->table)
            ->where('id_artikel', $id_artikel)
            ->update($data);
    }

    public function AllDataKategori()
    {
        return $this->db->table('tb_kategori_artikel')
            ->orderBy('created_at DESC')
            ->get()->getResultArray();
    }

    public function InsertKategori($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->table('tb_kategori_artikel')->insert($data);
    }

    public function EditKategori($data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->table('tb_kategori_artikel')
            ->where('id_kat_artikel', $data['id_kat_artikel'])
            ->update($data);
    }

    public function DeleteKategori($data)
    {
        $this->db->table('tb_kategori_artikel')
            ->where('id_kat_artikel', $data['id_kat_artikel'])
            ->delete($data);
    }
}
