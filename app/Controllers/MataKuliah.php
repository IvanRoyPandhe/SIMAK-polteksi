<?php

namespace App\Controllers;

use App\Models\ModelMataKuliah;
use App\Models\ModelDosen;
use App\Models\ModelProdi;

class MataKuliah extends BaseController
{
    protected $ModelMataKuliah;
    protected $ModelDosen;
    protected $ModelProdi;

    public function __construct()
    {
        $this->ModelMataKuliah = new ModelMataKuliah();
        $this->ModelDosen = new ModelDosen();
        $this->ModelProdi = new ModelProdi();
    }

    public function index()
    {
        try {
            $mata_kuliah = $this->ModelMataKuliah->getAllWithDosen();
            $prodi = $this->ModelProdi->findAll();
            
            $data = [
                'judul' => 'Data Mata Kuliah',
                'menu' => 'mata_kuliah',
                'submenu' => '',
                'page' => 'admin/mata_kuliah/index',
                'mata_kuliah' => $mata_kuliah ?: [],
                'prodi' => $prodi ?: []
            ];
            $data['user'] = $this->user;
            return view('v_template_admin', $data);
        } catch (\Exception $e) {
            log_message('error', 'MataKuliah index error: ' . $e->getMessage());
            return redirect()->to('/admin')->with('error', 'Terjadi kesalahan saat memuat data mata kuliah');
        }
    }

    public function create()
    {
        try {
            $data = [
                'judul' => 'Tambah Mata Kuliah',
                'menu' => 'mata_kuliah',
                'submenu' => '',
                'page' => 'admin/mata_kuliah/create',
                'prodi' => $this->ModelProdi->findAll(),
                'dosen' => $this->ModelDosen->findAll()
            ];
            $data['user'] = $this->user;
            return view('v_template_admin', $data);
        } catch (\Exception $e) {
            return redirect()->to('/admin/mata-kuliah')->with('error', 'Terjadi kesalahan');
        }
    }

    public function store()
    {
        $data = [
            'kode_matkul' => $this->request->getPost('kode_matkul'),
            'nama_matkul' => $this->request->getPost('nama_matkul'),
            'prodi_id' => $this->request->getPost('prodi_id'),
            'kurikulum_id' => $this->request->getPost('prodi_id'), // Same as prodi_id for simplicity
            'jenis' => $this->request->getPost('jenis'),
            'sks' => $this->request->getPost('sks'),
            'semester' => $this->request->getPost('semester'),
            'dosen_id' => $this->request->getPost('dosen_id')
        ];

        $this->ModelMataKuliah->insert($data);
        session()->setFlashdata('success', 'Mata kuliah berhasil ditambahkan');
        return redirect()->to('/admin/mata-kuliah');
    }

    public function edit($id)
    {
        try {
            $mata_kuliah = $this->ModelMataKuliah->find($id);
            if (!$mata_kuliah) {
                return redirect()->to('/admin/mata-kuliah')->with('error', 'Data tidak ditemukan');
            }
            
            $data = [
                'judul' => 'Edit Mata Kuliah',
                'menu' => 'mata_kuliah',
                'submenu' => '',
                'page' => 'admin/mata_kuliah/edit',
                'mata_kuliah' => $mata_kuliah,
                'prodi' => $this->ModelProdi->findAll(),
                'dosen' => $this->ModelDosen->findAll()
            ];
            $data['user'] = $this->user;
            return view('v_template_admin', $data);
        } catch (\Exception $e) {
            return redirect()->to('/admin/mata-kuliah')->with('error', 'Terjadi kesalahan');
        }
    }

    public function update($id)
    {
        $data = [
            'kode_matkul' => $this->request->getPost('kode_matkul'),
            'nama_matkul' => $this->request->getPost('nama_matkul'),
            'prodi_id' => $this->request->getPost('prodi_id'),
            'kurikulum_id' => $this->request->getPost('prodi_id'),
            'jenis' => $this->request->getPost('jenis'),
            'sks' => $this->request->getPost('sks'),
            'semester' => $this->request->getPost('semester'),
            'dosen_id' => $this->request->getPost('dosen_id')
        ];

        $this->ModelMataKuliah->update($id, $data);
        session()->setFlashdata('success', 'Mata kuliah berhasil diupdate');
        return redirect()->to('/admin/mata-kuliah');
    }

    public function delete($id)
    {
        $this->ModelMataKuliah->delete($id);
        session()->setFlashdata('success', 'Mata kuliah berhasil dihapus');
        return redirect()->to('/admin/mata-kuliah');
    }

    public function getDosenByProdi()
    {
        $prodi_id = $this->request->getPost('prodi_id');
        $dosen = $this->ModelDosen->where('prodi_id', $prodi_id)->findAll();
        return $this->response->setJSON($dosen);
    }
}