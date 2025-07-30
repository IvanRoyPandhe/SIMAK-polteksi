<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelJadwalKuliah;
use App\Models\ModelRuangan;

class JadwalKuliah extends BaseController
{
    protected $ModelJadwalKuliah;
    protected $ModelRuangan;

    public function __construct()
    {
        $this->ModelJadwalKuliah = new ModelJadwalKuliah();
        $this->ModelRuangan = new ModelRuangan();
    }

    public function index()
    {
        $data = [
            'judul'     => 'Jadwal Kuliah',
            'menu'      => 'jadwal',
            'submenu'   => 'jadwal-kuliah',
            'page'      => 'admin/v_jadwal_kuliah',
            'jadwal'    => $this->ModelJadwalKuliah->AllData(),
            'ruangan'   => $this->ModelRuangan->getRuanganTersedia(),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function InsertData()
    {
        if ($this->validate([
            'mata_kuliah' => [
                'label' => 'Mata Kuliah',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} maksimal 100 karakter',
                ]
            ],
            'dosen' => [
                'label' => 'Dosen',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} maksimal 100 karakter',
                ]
            ],
            'hari' => [
                'label' => 'Hari',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'jam_mulai' => [
                'label' => 'Jam Mulai',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'jam_selesai' => [
                'label' => 'Jam Selesai',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'ruangan_id' => [
                'label' => 'Ruangan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
        ])) {
            $data = [
                'mata_kuliah' => esc($this->request->getPost('mata_kuliah')),
                'dosen' => esc($this->request->getPost('dosen')),
                'hari' => esc($this->request->getPost('hari')),
                'jam_mulai' => esc($this->request->getPost('jam_mulai')),
                'jam_selesai' => esc($this->request->getPost('jam_selesai')),
                'ruangan_id' => esc($this->request->getPost('ruangan_id')),
                'semester' => esc($this->request->getPost('semester')),
            ];
            $this->ModelJadwalKuliah->InsertData($data);
            session()->setFlashdata('info', 'Jadwal kuliah berhasil ditambahkan!');
            return redirect()->to(base_url('JadwalKuliah'));
        } else {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->to(base_url('JadwalKuliah'))->withInput();
        }
    }

    public function UpdateData($id_jadwal)
    {
        if ($this->validate([
            'mata_kuliah' => [
                'label' => 'Mata Kuliah',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} maksimal 100 karakter',
                ]
            ],
            'dosen' => [
                'label' => 'Dosen',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} maksimal 100 karakter',
                ]
            ],
            'hari' => [
                'label' => 'Hari',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'jam_mulai' => [
                'label' => 'Jam Mulai',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'jam_selesai' => [
                'label' => 'Jam Selesai',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'ruangan_id' => [
                'label' => 'Ruangan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
        ])) {
            $data = [
                'id_jadwal' => $id_jadwal,
                'mata_kuliah' => esc($this->request->getPost('mata_kuliah')),
                'dosen' => esc($this->request->getPost('dosen')),
                'hari' => esc($this->request->getPost('hari')),
                'jam_mulai' => esc($this->request->getPost('jam_mulai')),
                'jam_selesai' => esc($this->request->getPost('jam_selesai')),
                'ruangan_id' => esc($this->request->getPost('ruangan_id')),
                'semester' => esc($this->request->getPost('semester')),
            ];
            $this->ModelJadwalKuliah->UpdateData($data);
            session()->setFlashdata('info', 'Jadwal kuliah berhasil diubah!');
            return redirect()->to(base_url('JadwalKuliah'));
        } else {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->to(base_url('JadwalKuliah'))->withInput();
        }
    }

    public function Delete($id_jadwal)
    {
        $this->ModelJadwalKuliah->DeleteData($id_jadwal);
        session()->setFlashdata('info', 'Jadwal kuliah berhasil dihapus!');
        return redirect()->to(base_url('JadwalKuliah'));
    }
}