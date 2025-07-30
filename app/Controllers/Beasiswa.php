<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBeasiswa;

class Beasiswa extends BaseController
{
    protected $ModelBeasiswa;

    public function __construct()
    {
        $this->ModelBeasiswa = new ModelBeasiswa();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'judul'     => 'Data Beasiswa',
            'menu'      => 'beasiswa',
            'submenu'   => '',
            'page'      => 'admin/beasiswa/v_beasiswa',
            'beasiswa'  => $this->ModelBeasiswa->AllData(),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function Insert()
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'nama_beasiswa' => [
                'label' => 'Nama Beasiswa',
                'rules' => 'required|max_length[150]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} maksimal 150 karakter',
                ]
            ],
            'jenis' => [
                'label' => 'Jenis Beasiswa',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus dipilih',
                ]
            ],
            'jumlah_dana' => [
                'label' => 'Jumlah Dana',
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} harus berupa angka',
                    'greater_than' => '{field} harus lebih besar dari 0',
                ]
            ],
        ])) {
            $data = [
                'nama_beasiswa'     => esc($this->request->getPost('nama_beasiswa')),
                'jenis'             => esc($this->request->getPost('jenis')),
                'jumlah_dana'       => esc($this->request->getPost('jumlah_dana')),
                'kuota'             => esc($this->request->getPost('kuota')),
                'persyaratan'       => esc($this->request->getPost('persyaratan')),
                'batas_pendaftaran' => esc($this->request->getPost('batas_pendaftaran')),
                'status'            => esc($this->request->getPost('status')),
            ];
            $this->ModelBeasiswa->InsertData($data);
            session()->setFlashdata('info', 'Data beasiswa berhasil ditambahkan');
            return redirect()->to(base_url('Beasiswa'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Beasiswa'))->withInput();
        }
    }

    public function Update($id_beasiswa)
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'nama_beasiswa' => [
                'label' => 'Nama Beasiswa',
                'rules' => 'required|max_length[150]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} maksimal 150 karakter',
                ]
            ],
            'jenis' => [
                'label' => 'Jenis Beasiswa',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus dipilih',
                ]
            ],
            'jumlah_dana' => [
                'label' => 'Jumlah Dana',
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} harus berupa angka',
                    'greater_than' => '{field} harus lebih besar dari 0',
                ]
            ],
        ])) {
            $data = [
                'nama_beasiswa'     => esc($this->request->getPost('nama_beasiswa')),
                'jenis'             => esc($this->request->getPost('jenis')),
                'jumlah_dana'       => esc($this->request->getPost('jumlah_dana')),
                'kuota'             => esc($this->request->getPost('kuota')),
                'persyaratan'       => esc($this->request->getPost('persyaratan')),
                'batas_pendaftaran' => esc($this->request->getPost('batas_pendaftaran')),
                'status'            => esc($this->request->getPost('status')),
            ];
            $this->ModelBeasiswa->UpdateData($id_beasiswa, $data);
            session()->setFlashdata('info', 'Data beasiswa berhasil diupdate');
            return redirect()->to(base_url('Beasiswa'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Beasiswa'))->withInput();
        }
    }

    public function Delete($id_beasiswa)
    {
        $this->ModelBeasiswa->DeleteData($id_beasiswa);
        session()->setFlashdata('info', 'Data beasiswa berhasil dihapus');
        return redirect()->to(base_url('Beasiswa'));
    }
}