<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelRuangan;

class Ruangan extends BaseController
{
    protected $ModelRuangan;

    public function __construct()
    {
        $this->ModelRuangan = new ModelRuangan();
    }

    public function index()
    {
        $data = [
            'judul'     => 'Manajemen Ruangan',
            'menu'      => 'jadwal',
            'submenu'   => 'ruangan',
            'page'      => 'admin/v_ruangan',
            'ruangan'   => $this->ModelRuangan->AllData(),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function InsertData()
    {
        if ($this->validate([
            'nama_ruangan' => [
                'label' => 'Nama Ruangan',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} maksimal 100 karakter',
                ]
            ],
            'kapasitas' => [
                'label' => 'Kapasitas',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} harus berupa angka',
                ]
            ],
            'fasilitas' => [
                'label' => 'Fasilitas',
                'rules' => 'max_length[255]',
                'errors' => [
                    'max_length' => '{field} maksimal 255 karakter',
                ]
            ],
        ])) {
            $data = [
                'nama_ruangan' => esc($this->request->getPost('nama_ruangan')),
                'kapasitas' => esc($this->request->getPost('kapasitas')),
                'fasilitas' => esc($this->request->getPost('fasilitas')),
                'status' => 'Tersedia',
                'user_id' => session()->get('user_id'),
            ];
            $this->ModelRuangan->InsertData($data);
            session()->setFlashdata('info', 'Data ruangan berhasil ditambahkan!');
            return redirect()->to(base_url('Ruangan'));
        } else {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->to(base_url('Ruangan'))->withInput();
        }
    }

    public function UpdateData($id_ruangan)
    {
        if ($this->validate([
            'nama_ruangan' => [
                'label' => 'Nama Ruangan',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} maksimal 100 karakter',
                ]
            ],
            'kapasitas' => [
                'label' => 'Kapasitas',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} harus berupa angka',
                ]
            ],
            'fasilitas' => [
                'label' => 'Fasilitas',
                'rules' => 'max_length[255]',
                'errors' => [
                    'max_length' => '{field} maksimal 255 karakter',
                ]
            ],
        ])) {
            $data = [
                'id_ruangan' => $id_ruangan,
                'nama_ruangan' => esc($this->request->getPost('nama_ruangan')),
                'kapasitas' => esc($this->request->getPost('kapasitas')),
                'fasilitas' => esc($this->request->getPost('fasilitas')),
                'status' => esc($this->request->getPost('status')),
                'user_id' => session()->get('user_id'),
            ];
            $this->ModelRuangan->UpdateData($data);
            session()->setFlashdata('info', 'Data ruangan berhasil diubah!');
            return redirect()->to(base_url('Ruangan'));
        } else {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->to(base_url('Ruangan'))->withInput();
        }
    }

    public function Delete($id_ruangan)
    {
        $this->ModelRuangan->DeleteData($id_ruangan);
        session()->setFlashdata('info', 'Data ruangan berhasil dihapus!');
        return redirect()->to(base_url('Ruangan'));
    }
}