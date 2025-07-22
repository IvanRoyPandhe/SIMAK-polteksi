<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ModelKasInternal;
use App\Models\ModelAdmin;
use App\Models\ModelUser;

class KasInternal extends BaseController
{
    protected $ModelKasInternal;
    protected $ModelAdmin;

    public function __construct()
    {
        $this->ModelKasInternal = new ModelKasInternal();
        $this->ModelAdmin = new ModelAdmin();
    }

    public function index()
    {
        $data = [
            'judul'     => 'Rekapitulasi Kas Internal',
            'subjudul'  => '',
            'menu'      => 'kas-internal',
            'submenu'   => 'rekap-kas-internal',
            'page'      => 'admin/kas-internal/v_rekap_kas_internal',
            'kas'       => $this->ModelKasInternal->AllData(),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function DeleteAll()
    {
        $this->ModelKasInternal->TruncateData();
        session()->setFlashdata('info', 'Semua data berhasil dihapus!');
        return redirect()->to(base_url('KasInternal'));
    }

    public function DanaMasuk()
    {
        $kas = $this->ModelKasInternal->AllDataDanaMasuk();
        $kategoriList = array_unique(array_column($kas, 'kategori'));
        $jumlahKategori = [];
        foreach ($kategoriList as $kategori) {
            $jumlahKategori[$kategori] = $this->ModelKasInternal->countByKategori($kategori);
        }
        $data = [
            'judul'             => 'Dana Masuk (Kas Internal)',
            'subjudul'          => 'Dana Masuk',
            'menu'              => 'kas-internal',
            'submenu'           => 'dana-masuk-internal',
            'page'              => 'admin/kas-internal/v_masuk_kas_internal',
            'kas'               => $kas,
            'jumlahKategori'    => $jumlahKategori,
            'kategoriList'      => $kategoriList,
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function InsertDanaMasuk()
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'kategori_select' => [
                'label' => 'Kategori',
                'rules' => 'required|max_length[50]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 50 karakter',
                ]
            ],
            'kategori_input' => [
                'label' => 'Kategori Baru',
                'rules' => 'permit_empty|max_length[50]',
                'errors' => [
                    'max_length' => '{field} tidak boleh lebih dari 50 karakter',
                ]
            ],
            'tanggal' => [
                'label' => 'Tanggal',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'dana_masuk' => [
                'label' => 'Dana Masuk',
                'rules' => 'required|numeric|greater_than[0]|less_than_equal_to[2147483647]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} harus berupa angka',
                    'greater_than' => '{field} harus lebih besar dari 0',
                    'less_than_equal_to' => '{field} tidak boleh lebih dari 10 digit (Rp. 2,147,483,647)',
                ]
            ],
            'keterangan' => [
                'label' => 'Keterangan',
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 255 karakter',
                ]
            ],
        ])) {
            $kategori = esc($this->request->getPost('kategori_select'));
            if ($kategori === 'new') {
                $kategori = $this->request->getPost('kategori_input');
            }
            $data = [
                'kategori'      => $kategori,
                'tgl'           => esc($this->request->getPost('tanggal')),
                'dana_masuk'    => esc($this->request->getPost('dana_masuk')),
                'dana_keluar'   => 0,
                'keterangan'    => esc($this->request->getPost('keterangan')),
                'status'        => 'Masuk',
                'user_id'       => session()->get('user_id'),
            ];
            $this->ModelKasInternal->InsertData($data);
            session()->setFlashdata('info', 'Dana masuk berhasil ditambahkan!');
            return redirect()->to(base_url('KasInternal/DanaMasuk'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('KasInternal/DanaMasuk'))->withInput();
        }
    }

    public function EditDanaMasuk($id_keuangan)
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'kategori_select' => [
                'label' => 'Kategori',
                'rules' => 'required|max_length[50]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 50 karakter',
                ]
            ],
            'kategori_input' => [
                'label' => 'Kategori Baru',
                'rules' => 'permit_empty|max_length[50]',
                'errors' => [
                    'max_length' => '{field} tidak boleh lebih dari 50 karakter',
                ]
            ],
            'tanggal' => [
                'label' => 'Tanggal',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'dana_masuk' => [
                'label' => 'Dana Masuk',
                'rules' => 'required|numeric|greater_than[0]|less_than_equal_to[2147483647]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} harus berupa angka',
                    'greater_than' => '{field} harus lebih besar dari 0',
                    'less_than_equal_to' => '{field} tidak boleh lebih dari 10 digit (Rp. 2,147,483,647)',
                ]
            ],
            'keterangan' => [
                'label' => 'Keterangan',
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 255 karakter',
                ]
            ],
        ])) {
            $kategori = esc($this->request->getPost('kategori_select'));
            if ($kategori === 'new') {
                $kategori = $this->request->getPost('kategori_input');
            }
            $data = [
                'id_keuangan'   => $id_keuangan,
                'kategori'      => $kategori,
                'tgl'           => esc($this->request->getPost('tanggal')),
                'dana_masuk'    => esc($this->request->getPost('dana_masuk')),
                'dana_keluar'   => 0,
                'keterangan'    => esc($this->request->getPost('keterangan')),
                'status'        => 'Masuk',
                'user_id'       => session()->get('user_id'),
            ];
            $this->ModelKasInternal->EditData($data);
            session()->setFlashdata('info', 'Dana keluar berhasil diubah!');
            return redirect()->to(base_url('KasInternal/DanaMasuk'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('KasInternal/DanaMasuk'))->withInput();
        }
    }

    public function DanaKeluar()
    {
        $kas = $this->ModelKasInternal->AllDataDanaKeluar();
        $kategoriList = array_unique(array_column($kas, 'kategori'));
        $jumlahKategori = [];
        foreach ($kategoriList as $kategori) {
            $jumlahKategori[$kategori] = $this->ModelKasInternal->countByKategori($kategori);
        }
        $data = [
            'judul'             => 'Dana Keluar (Kas Internal)',
            'subjudul'          => 'Dana Keluar',
            'menu'              => 'kas-internal',
            'submenu'           => 'dana-keluar-internal',
            'page'              => 'admin/kas-internal/v_keluar_kas_internal',
            'kas'               => $kas,
            'jumlahKategori'    => $jumlahKategori,
            'kategoriList'      => $kategoriList,
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function InsertDanaKeluar()
    {
        $validation = \Config\Services::validation();
        $currentBalance = $this->ModelKasInternal->getTotalBalance();
        $requestedAmount = (float)$this->request->getPost('dana_keluar');
        if ($requestedAmount > $currentBalance) {
            session()->setFlashdata('errors', ['dana_keluar' => 'Kas tidak mencukupi. Sisa kas: Rp. ' . number_format($currentBalance, 0, ',', '.')]);
            return redirect()->to(base_url('KasInternal/DanaKeluar'))->withInput();
        }
        if ($this->validate([
            'kategori_select' => [
                'label' => 'Kategori',
                'rules' => 'required|max_length[50]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 50 karakter',
                ]
            ],
            'kategori_input' => [
                'label' => 'Kategori Baru',
                'rules' => 'permit_empty|max_length[50]',
                'errors' => [
                    'max_length' => '{field} tidak boleh lebih dari 50 karakter',
                ]
            ],
            'tanggal' => [
                'label' => 'Tanggal',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'dana_keluar' => [
                'label' => 'Dana keluar',
                'rules' => 'required|numeric|greater_than[0]|less_than_equal_to[2147483647]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} harus berupa angka',
                    'greater_than' => '{field} harus lebih besar dari 0',
                    'less_than_equal_to' => '{field} tidak boleh lebih dari 10 digit (Rp. 2,147,483,647)',
                ]
            ],
            'keterangan' => [
                'label' => 'Keterangan',
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 255 karakter',
                ]
            ],
        ])) {
            $kategori = esc($this->request->getPost('kategori_select'));
            if ($kategori === 'new') {
                $kategori = $this->request->getPost('kategori_input');
            }
            $data = [
                'kategori'      => $kategori,
                'tgl'           => esc($this->request->getPost('tanggal')),
                'dana_masuk'    => 0,
                'dana_keluar'   => esc($this->request->getPost('dana_keluar')),
                'keterangan'    => esc($this->request->getPost('keterangan')),
                'status'        => 'Keluar',
                'user_id'       => session()->get('user_id'),
            ];
            $this->ModelKasInternal->InsertData($data);
            session()->setFlashdata('info', 'Dana keluar berhasil ditambahkan!');
            return redirect()->to(base_url('KasInternal/DanaKeluar'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('KasInternal/DanaKeluar'))->withInput();
        }
    }

    public function EditDanaKeluar($id_keuangan)
    {
        $validation = \Config\Services::validation();
        $currentTransaction = $this->ModelKasInternal->where('id_keuangan', $id_keuangan)->first();
        $currentBalance = $this->ModelKasInternal->getTotalBalance() + $currentTransaction['dana_keluar'];
        $requestedAmount = (float)$this->request->getPost('dana_keluar');
        if ($requestedAmount > $currentBalance) {
            session()->setFlashdata('errors', ['dana_keluar' => 'Kas tidak mencukupi. Sisa kas: Rp. ' . number_format($currentBalance, 0, ',', '.')]);
            return redirect()->to(base_url('KasInternal/DanaKeluar'))->withInput();
        }
        if ($this->validate([
            'kategori_select' => [
                'label' => 'Kategori',
                'rules' => 'required|max_length[50]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 50 karakter',
                ]
            ],
            'kategori_input' => [
                'label' => 'Kategori Baru',
                'rules' => 'permit_empty|max_length[50]',
                'errors' => [
                    'max_length' => '{field} tidak boleh lebih dari 50 karakter',
                ]
            ],
            'tanggal' => [
                'label' => 'Tanggal',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'dana_keluar' => [
                'label' => 'Dana Keluar',
                'rules' => 'required|numeric|greater_than[0]|less_than_equal_to[2147483647]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} harus berupa angka',
                    'greater_than' => '{field} harus lebih besar dari 0',
                    'less_than_equal_to' => '{field} tidak boleh lebih dari 10 digit (Rp. 2,147,483,647)',
                ]
            ],
            'keterangan' => [
                'label' => 'Keterangan',
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 255 karakter',
                ]
            ],
        ])) {
            $kategori = esc($this->request->getPost('kategori_select'));
            if ($kategori === 'new') {
                $kategori = $this->request->getPost('kategori_input');
            }
            $data = [
                'id_keuangan'   => $id_keuangan,
                'kategori'      => $kategori,
                'tgl'           => esc($this->request->getPost('tanggal')),
                'dana_masuk'    => 0,
                'dana_keluar'   => esc($this->request->getPost('dana_keluar')),
                'keterangan'    => esc($this->request->getPost('keterangan')),
                'status'        => 'Keluar',
                'user_id'       => session()->get('user_id'),
            ];
            $this->ModelKasInternal->EditData($data);
            session()->setFlashdata('info', 'Dana keluar berhasil diubah!');
            return redirect()->to(base_url('KasInternal/DanaKeluar'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('KasInternal/DanaKeluar'))->withInput();
        }
    }

    public function DeleteData($id_keuangan, $type)
    {
        $data = [
            'id_keuangan' => $id_keuangan,
        ];
        $this->ModelKasInternal->DeleteData($data);
        if ($type === 'kasinternal-masuk') {
            session()->setFlashdata('info', 'Dana masuk berhasil dihapus!');
            return redirect()->to(base_url('KasInternal/DanaMasuk'));
        } else if ($type === 'kasinternal-keluar') {
            session()->setFlashdata('info', 'Dana keluar berhasil dihapus!');
            return redirect()->to(base_url('KasInternal/DanaKeluar'));
        }
    }
}
