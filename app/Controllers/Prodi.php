<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelProdi;
use App\Models\ModelUser;

class Prodi extends BaseController
{
    protected $ModelProdi;
    protected $user;

    public function __construct()
    {
        $this->ModelProdi = new ModelProdi();
        helper(['form', 'url']);
        
        $userModel = new ModelUser();
        $this->user = $userModel->find(session()->get('user_id'));
    }

    public function index()
    {
        $data = [
            'judul' => 'Data Program Studi',
            'menu' => 'prodi',
            'submenu' => '',
            'page' => 'admin/prodi/index',
            'prodi' => $this->ModelProdi->findAll(),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function create()
    {
        $data = [
            'judul' => 'Tambah Program Studi',
            'menu' => 'prodi',
            'submenu' => '',
            'page' => 'admin/prodi/create',
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'kode_prodi' => [
                'label' => 'Kode Prodi',
                'rules' => 'required|is_unique[tb_prodi.kode_prodi]|max_length[10]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'is_unique' => '{field} sudah terdaftar',
                    'max_length' => '{field} maksimal 10 karakter',
                ]
            ],
            'nama_prodi' => [
                'label' => 'Nama Prodi',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} maksimal 100 karakter',
                ]
            ],
        ])) {
            $data = [
                'kode_prodi' => esc($this->request->getPost('kode_prodi')),
                'nama_prodi' => esc($this->request->getPost('nama_prodi')),
                'jenjang' => esc($this->request->getPost('jenjang')),
            ];
            $this->ModelProdi->insert($data);
            session()->setFlashdata('info', 'Data prodi berhasil ditambahkan');
            return redirect()->to(base_url('Prodi'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Prodi/create'))->withInput();
        }
    }

    public function edit($id_prodi)
    {
        $data = [
            'judul' => 'Edit Program Studi',
            'menu' => 'prodi',
            'submenu' => '',
            'page' => 'admin/prodi/edit',
            'prodi' => $this->ModelProdi->find($id_prodi),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function update($id_prodi)
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'kode_prodi' => [
                'label' => 'Kode Prodi',
                'rules' => 'required|max_length[10]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} maksimal 10 karakter',
                ]
            ],
            'nama_prodi' => [
                'label' => 'Nama Prodi',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} maksimal 100 karakter',
                ]
            ],
        ])) {
            $data = [
                'kode_prodi' => esc($this->request->getPost('kode_prodi')),
                'nama_prodi' => esc($this->request->getPost('nama_prodi')),
                'jenjang' => esc($this->request->getPost('jenjang')),
            ];
            $this->ModelProdi->update($id_prodi, $data);
            session()->setFlashdata('info', 'Data prodi berhasil diupdate');
            return redirect()->to(base_url('Prodi'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Prodi/edit/' . $id_prodi))->withInput();
        }
    }

    public function delete($id_prodi)
    {
        $this->ModelProdi->delete($id_prodi);
        session()->setFlashdata('info', 'Data prodi berhasil dihapus');
        return redirect()->to(base_url('Prodi'));
    }
}