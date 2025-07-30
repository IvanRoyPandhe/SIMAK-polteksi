<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMataKuliah;

class MataKuliah extends BaseController
{
    protected $ModelMataKuliah;

    public function __construct()
    {
        $this->ModelMataKuliah = new ModelMataKuliah();
    }

    public function index()
    {
        $data = [
            'judul'     => 'Mata Kuliah',
            'menu'      => 'akademik',
            'submenu'   => 'mata-kuliah',
            'page'      => 'admin/v_mata_kuliah',
            'matkul'    => $this->ModelMataKuliah->AllData(),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function InsertData()
    {
        if ($this->validate([
            'kode_matkul' => [
                'label' => 'Kode Mata Kuliah',
                'rules' => 'required|max_length[10]|is_unique[tb_mata_kuliah.kode_matkul]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} maksimal 10 karakter',
                    'is_unique' => '{field} sudah ada',
                ]
            ],
            'nama_matkul' => [
                'label' => 'Nama Mata Kuliah',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} maksimal 100 karakter',
                ]
            ],
            'sks' => [
                'label' => 'SKS',
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} harus berupa angka',
                    'greater_than' => '{field} harus lebih dari 0',
                ]
            ],
            'semester' => [
                'label' => 'Semester',
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} harus berupa angka',
                    'greater_than' => '{field} harus lebih dari 0',
                ]
            ],
        ])) {
            $data = [
                'kode_matkul' => esc($this->request->getPost('kode_matkul')),
                'nama_matkul' => esc($this->request->getPost('nama_matkul')),
                'prodi_id' => esc($this->request->getPost('prodi_id')),
                'kurikulum_id' => esc($this->request->getPost('kurikulum_id')),
                'jenis' => esc($this->request->getPost('jenis')),
                'sks' => esc($this->request->getPost('sks')),
                'semester' => esc($this->request->getPost('semester')),
            ];
            $this->ModelMataKuliah->InsertData($data);
            session()->setFlashdata('info', 'Data mata kuliah berhasil ditambahkan!');
            return redirect()->to(base_url('MataKuliah'));
        } else {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->to(base_url('MataKuliah'))->withInput();
        }
    }

    public function UpdateData($id_matkul)
    {
        if ($this->validate([
            'kode_matkul' => [
                'label' => 'Kode Mata Kuliah',
                'rules' => 'required|max_length[10]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} maksimal 10 karakter',
                ]
            ],
            'nama_matkul' => [
                'label' => 'Nama Mata Kuliah',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} maksimal 100 karakter',
                ]
            ],
            'sks' => [
                'label' => 'SKS',
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} harus berupa angka',
                    'greater_than' => '{field} harus lebih dari 0',
                ]
            ],
            'semester' => [
                'label' => 'Semester',
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} harus berupa angka',
                    'greater_than' => '{field} harus lebih dari 0',
                ]
            ],
        ])) {
            $data = [
                'id_matkul' => $id_matkul,
                'kode_matkul' => esc($this->request->getPost('kode_matkul')),
                'nama_matkul' => esc($this->request->getPost('nama_matkul')),
                'sks' => esc($this->request->getPost('sks')),
                'semester' => esc($this->request->getPost('semester')),
            ];
            $this->ModelMataKuliah->UpdateData($data);
            session()->setFlashdata('info', 'Data mata kuliah berhasil diubah!');
            return redirect()->to(base_url('MataKuliah'));
        } else {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->to(base_url('MataKuliah'))->withInput();
        }
    }

    public function Delete($id_matkul)
    {
        $this->ModelMataKuliah->DeleteData($id_matkul);
        session()->setFlashdata('info', 'Data mata kuliah berhasil dihapus!');
        return redirect()->to(base_url('MataKuliah'));
    }
}