<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ModelKegiatan;

class Kegiatan extends BaseController
{
    protected $ModelKegiatan;

    public function __construct()
    {
        $this->ModelKegiatan = new ModelKegiatan();
    }

    public function index()
    {
        $data = [
            'judul'     => 'Pengumuman/ Kegiatan',
            'menu'      => 'kegiatan',
            'submenu'   => '',
            'page'      => 'admin/kegiatan/v_kegiatan',
            'kegiatan'  => $this->ModelKegiatan->AllData(),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function InsertData()
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'judul' => [
                'label' => 'Judul',
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 255 karakter',
                ]
            ],
            'kategori' => [
                'label' => 'Kategori',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'tanggal' => [
                'label' => 'Tanggal',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'keterangan' => [
                'label' => 'Keterangan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
        ])) {
            $kategori = $this->request->getPost('kategori');
            $waktu = $this->request->getPost('waktu');
            if ($kategori == 'pengumuman') {
                $waktu = '00:00:00';
            }
            $data = [
                'judul'         => esc($this->request->getPost('judul')),
                'kategori'      => $kategori,
                'tgl'           => esc($this->request->getPost('tanggal')),
                'waktu'         => $waktu,
                'tempat'        => esc($this->request->getPost('tempat')),
                'status'        => $this->request->getPost('status'),
                'keterangan'    => esc($this->request->getPost('keterangan')),
                'user_id'       => session()->get('user_id'),
            ];
            $this->ModelKegiatan->InsertData($data);
            session()->setFlashdata('info', 'Data kegiatan berhasil ditambahkan!');
            return redirect()->to(base_url('Kegiatan'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Kegiatan'));
        }
    }

    public function EditData($id_kegiatan)
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'judul' => [
                'label' => 'Judul',
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 255 karakter',
                ]
            ],
            'kategori' => [
                'label' => 'Kategori',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'tanggal' => [
                'label' => 'Tanggal',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'keterangan' => [
                'label' => 'Keterangan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
        ])) {
            $kategori = $this->request->getPost('kategori');
            $waktu = $this->request->getPost('waktu');
            if ($kategori == 'pengumuman') {
                $waktu = '00:00:00';
            }
            $data = [
                'id_kegiatan'   => $id_kegiatan,
                'judul'         => esc($this->request->getPost('judul')),
                'kategori'      => $kategori,
                'tgl'           => esc($this->request->getPost('tanggal')),
                'waktu'         => $waktu,
                'tempat'        => esc($this->request->getPost('tempat')),
                'status'        => $this->request->getPost('status'),
                'keterangan'    => esc($this->request->getPost('keterangan')),
                'user_id'       => session()->get('user_id'),
            ];
            $this->ModelKegiatan->EditData($data);
            session()->setFlashdata('info', 'Data kegiatan berhasil diubah!');
            return redirect()->to(base_url('Kegiatan'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Kegiatan'))->withInput();
        }
    }

    public function DeleteData($id_kegiatan)
    {
        $data = [
            'id_kegiatan' => $id_kegiatan,
        ];
        $this->ModelKegiatan->DeleteData($data);
        session()->setFlashdata('info', 'Data kegiatan berhasil dihapus!');
        return redirect()->to(base_url('Kegiatan'));
    }
}
