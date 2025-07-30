<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\ModelKRS;
use App\Models\ModelKHS;

class Mahasiswa extends BaseController
{
    protected $ModelKRS;
    protected $ModelKHS;

    public function __construct()
    {
        $this->ModelKRS = new ModelKRS();
        $this->ModelKHS = new ModelKHS();
    }

    public function index()
    {
        $mahasiswa_id = session()->get('mahasiswa_id') ?? 1;
        $data = [
            'judul'     => 'Dashboard Mahasiswa',
            'menu'      => 'dashboard',
            'submenu'   => '',
            'page'      => 'mahasiswa/v_dashboard',
            'mahasiswa_id' => $mahasiswa_id,
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function KRS()
    {
        $mahasiswa_id = session()->get('mahasiswa_id') ?? 1;
        $data = [
            'judul'     => 'Kartu Rencana Studi (KRS)',
            'menu'      => 'krs-mahasiswa',
            'submenu'   => '',
            'page'      => 'mahasiswa/v_krs',
            'mahasiswa_id' => $mahasiswa_id,
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function KHS()
    {
        $mahasiswa_id = session()->get('mahasiswa_id') ?? 1;
        $data = [
            'judul'     => 'Kartu Hasil Studi (KHS)',
            'menu'      => 'khs-mahasiswa',
            'submenu'   => '',
            'page'      => 'mahasiswa/v_khs',
            'mahasiswa_id' => $mahasiswa_id,
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }
}