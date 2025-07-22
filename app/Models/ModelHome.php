<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelHome extends Model
{
    protected $table = 'tb_artikel';
    protected $primaryKey = 'id_artikel';
    protected $allowedFields = ['judul', 'penulis', 'kat_artikel_id', 'slug', 'created_at'];

    public function DataKegiatan()
    {
        return $this->db->table('tb_kegiatan')
            ->where('month(tgl)', date('m'))
            ->where('year(tgl)', date('Y'))
            ->where('kategori', 'kegiatan')
            ->where('status', 'public')
            ->orderBy('tgl', 'ASC')
            ->get()->getResultArray();
    }

    public function DataPengumuman()
    {
        return $this->db->table('tb_kegiatan')
            ->where('kategori', 'pengumuman')
            ->where('status', 'public')
            ->orderBy('tgl', 'ASC')
            ->get()->getResultArray();
    }

    public function DataKasInternal()
    {
        return $this->db->table('tb_keuangan_internal')
            ->where('month(tgl)', date('m'))
            ->where('year(tgl)', date('Y'))
            ->orderBy('tgl')
            ->get()->getResultArray();
    }

    public function DataInventarisMasuk()
    {
        return $this->db->table('tb_inventaris')
            ->where('status', 0)
            ->get()->getResultArray();
    }

    public function DataInventarisKeluar()
    {
        return $this->db->table('tb_inventaris')
            ->where('status', 1)
            ->get()->getResultArray();
    }

    public function InventariscountByKategori($kategori)
    {
        return $this->db->table('tb_inventaris')
            ->where('kategori', $kategori)
            ->countAllResults();
    }

    public function InsertDonasi($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->table('tb_donasi')->insert($data);
    }

    public function ViewSetting()
    {
        return $this->db->table('tb_setting')
            ->where('id_set', 1)
            ->get()->getRowArray();
    }

    public function AllDataArtikel()
    {
        return $this->db->table('tb_artikel')
            ->select('tb_artikel.*, tb_kategori_artikel.nama as nama_kategori')
            ->join('tb_kategori_artikel', 'tb_kategori_artikel.id_kat_artikel = tb_artikel.kat_artikel_id', 'left')
            ->get()->getResultArray();
    }

    public function getArtikelById($slug)
    {
        return $this->select('tb_artikel.*, tb_kategori_artikel.nama as nama_kategori')
            ->join('tb_kategori_artikel', 'tb_kategori_artikel.id_kat_artikel = tb_artikel.kat_artikel_id', 'left')
            ->where('slug', $slug)
            ->first();
    }

    public function AllDataKategoriArtikel()
    {
        return $this->db->table('tb_kategori_artikel')
            ->get()->getResultArray();
    }

    public function getArtikelWithFilters($kategori = null, $search = null)
    {
        $this->select('tb_artikel.*, tb_kategori_artikel.nama as nama_kategori')
            ->join('tb_kategori_artikel', 'tb_kategori_artikel.id_kat_artikel = tb_artikel.kat_artikel_id', 'left');
        $user_id = session()->get('user_id');
        if ($user_id) {
            $this->whereIn('status', ['Private', 'Publish']);
        } else {
            $this->where('status', 'Publish');
        }
        if (!empty($kategori)) {
            $this->where('tb_artikel.kat_artikel_id', $kategori);
        }
        if (!empty($search)) {
            $this->groupStart()
                ->like('tb_artikel.judul', $search)
                ->orLike('tb_artikel.penulis', $search)
                ->groupEnd();
        }
        $this->orderBy('tb_artikel.created_at', 'DESC');
        return $this->paginate(6, 'artikel');
    }

    public function getArtikelCount($kategori = null, $search = null)
    {
        $builder = $this->db->table($this->table);
        $user_id = session()->get('user_id');
        if ($user_id) {
            $builder->whereIn('status', ['Private', 'Publish']);
        } else {
            $builder->where('status', 'Publish');
        }
        if (!empty($kategori)) {
            $builder->where('kat_artikel_id', $kategori);
        }
        if (!empty($search)) {
            $builder->groupStart()
                ->like('judul', $search)
                ->orLike('penulis', $search)
                ->groupEnd();
        }
        return $builder->countAllResults();
    }

    public function AllDataPengaduan()
    {
        return $this->db->table('tb_pengaduan')
            ->orderBy('status')
            ->orderBy('updated_at DESC')
            ->get()->getResultArray();
    }

    public function InsertPengaduan($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->table('tb_pengaduan')->insert($data);
    }

    public function getLastUpdate()
    {
        return $this->db->table('tb_inventaris')
            ->select('updated_at')
            ->orderBy('updated_at', 'DESC')
            ->limit(1)
            ->get()
            ->getRowArray();
    }
}
