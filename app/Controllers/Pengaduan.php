<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ModelPengaduan;

class Pengaduan extends BaseController
{
    protected $ModelPengaduan;

    public function __construct()
    {
        $this->ModelPengaduan = new ModelPengaduan();
    }

    public function index()
    {
        $data = [
            'judul'     => 'Pengaduan',
            'menu'      => 'pengaduan',
            'submenu'   => '',
            'page'      => 'admin/kegiatan/v_pengaduan',
            'pengaduan' => $this->ModelPengaduan->AllData(),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function ValidasiPengaduan($id_pengaduan)
    {
        $this->ModelPengaduan->UpdatePengaduanStatus($id_pengaduan, 'Validated');
        session()->setFlashdata('info', 'Pengaduan berhasil dikonfirmasi dan silahkan dijawab');
        return redirect()->to(base_url('Pengaduan'));
    }

    public function JawabPengaduan($id_pengaduan)
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'jawaban' => [
                'label' => 'Jawaban',
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 255 karakter',
                ]
            ],
        ])) {
            $data = [
                'id_pengaduan'  => $id_pengaduan,
                'nama_penjawab' => session()->get('nama'),
                'jawaban'       => esc($this->request->getPost('jawaban')),
                'user_id'       => session()->get('user_id'),
            ];
            $this->ModelPengaduan->JawabPengaduan($data);
            session()->setFlashdata('info', 'Pengaduan berhasil dijawab');
            return redirect()->to(base_url('Pengaduan'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Pengaduan'));
        }
    }

    public function DeletePengaduan($id_pengaduan)
    {
        $data = [
            'id_pengaduan' => $id_pengaduan,
        ];
        $this->ModelPengaduan->DeletePengaduan($data);
        session()->setFlashdata('info', 'Data pengaduan berhasil dihapus!');
        return redirect()->to(base_url('Pengaduan'));
    }
}
