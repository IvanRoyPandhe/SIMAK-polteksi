<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelDosen;

class Dosen extends BaseController
{
    protected $ModelDosen;

    public function __construct()
    {
        $this->ModelDosen = new ModelDosen();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'judul'     => 'Data Dosen',
            'menu'      => 'dosen',
            'submenu'   => '',
            'page'      => 'admin/dosen/v_dosen',
            'dosen'     => $this->ModelDosen->AllData(),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function Insert()
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'nip' => [
                'label' => 'NIP',
                'rules' => 'required|is_unique[tb_dosen.nip]|max_length[20]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'is_unique' => '{field} sudah terdaftar',
                    'max_length' => '{field} maksimal 20 karakter',
                ]
            ],
            'nama' => [
                'label' => 'Nama',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} maksimal 100 karakter',
                ]
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|is_unique[tb_dosen.email]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'valid_email' => '{field} tidak valid',
                    'is_unique' => '{field} sudah terdaftar',
                ]
            ],
        ])) {
            $data = [
                'nip'       => esc($this->request->getPost('nip')),
                'nama'      => esc($this->request->getPost('nama')),
                'email'     => esc($this->request->getPost('email')),
                'jurusan'   => esc($this->request->getPost('jurusan')),
                'jabatan'   => esc($this->request->getPost('jabatan')),
                'status'    => esc($this->request->getPost('status')),
            ];
            $this->ModelDosen->InsertData($data);
            session()->setFlashdata('info', 'Data dosen berhasil ditambahkan');
            return redirect()->to(base_url('Dosen'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Dosen'))->withInput();
        }
    }

    public function Update($id_dosen)
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'nip' => [
                'label' => 'NIP',
                'rules' => 'required|max_length[20]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} maksimal 20 karakter',
                ]
            ],
            'nama' => [
                'label' => 'Nama',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} maksimal 100 karakter',
                ]
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'valid_email' => '{field} tidak valid',
                ]
            ],
        ])) {
            $data = [
                'nip'       => esc($this->request->getPost('nip')),
                'nama'      => esc($this->request->getPost('nama')),
                'email'     => esc($this->request->getPost('email')),
                'jurusan'   => esc($this->request->getPost('jurusan')),
                'jabatan'   => esc($this->request->getPost('jabatan')),
                'status'    => esc($this->request->getPost('status')),
            ];
            $this->ModelDosen->UpdateData($id_dosen, $data);
            session()->setFlashdata('info', 'Data dosen berhasil diupdate');
            return redirect()->to(base_url('Dosen'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Dosen'))->withInput();
        }
    }

    public function Delete($id_dosen)
    {
        $this->ModelDosen->DeleteData($id_dosen);
        session()->setFlashdata('info', 'Data dosen berhasil dihapus');
        return redirect()->to(base_url('Dosen'));
    }
}