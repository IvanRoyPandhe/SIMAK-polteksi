<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelHome;
use App\Models\ModelAdmin;

class HomePublic extends BaseController
{
    protected $ModelHome;
    protected $ModelAdmin;

    public function __construct()
    {
        $this->ModelHome = new ModelHome();
        $this->ModelAdmin = new ModelAdmin();
    }

    public function Program()
    {
        $data = [
            'judul'     => 'Program Studi',
            'menu'      => 'program',
            'page'      => 'home/v_program',
        ];
        return view('v_template_home', $data);
    }

    public function Fasilitas()
    {
        $data = [
            'judul'     => 'Fasilitas Kampus',
            'menu'      => 'fasilitas',
            'page'      => 'home/v_fasilitas',
        ];
        return view('v_template_home', $data);
    }

    public function Artikel()
    {
        $db = \Config\Database::connect();
        $artikel = $db->table('tb_artikel')
            ->join('tb_kategori_artikel', 'tb_kategori_artikel.id_kat_artikel = tb_artikel.kat_artikel_id', 'left')
            ->select('tb_artikel.*, COALESCE(tb_kategori_artikel.nama, "Umum") as nama_kategori')
            ->where('tb_artikel.status', 'Publish')
            ->orderBy('tb_artikel.created_at', 'DESC')
            ->get()->getResultArray();

        $data = [
            'judul'     => 'Artikel Kampus',
            'menu'      => 'artikel',
            'page'      => 'home/v_artikel_public',
            'artikel'   => $artikel,
        ];
        return view('v_template_home', $data);
    }
}