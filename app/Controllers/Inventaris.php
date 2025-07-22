<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ModelInventaris;
use App\Models\ModelAdmin;

class Inventaris extends BaseController
{
    protected $ModelInventaris;
    protected $ModelAdmin;

    public function __construct()
    {
        $this->ModelInventaris = new ModelInventaris();
        $this->ModelAdmin = new ModelAdmin();
    }

    public function getNamaBarangMasuk()
    {
        return $this->ModelInventaris->getNamaBarangMasuk();
    }

    public function index()
    {
        $inventaris_masuk = $this->ModelInventaris->AllDataMasuk();
        $kategoriList_masuk = array_unique(array_column($inventaris_masuk, 'kategori'));
        $jumlahKategori_masuk = [];
        foreach ($kategoriList_masuk as $kategori_masuk) {
            $jumlahKategori_masuk[$kategori_masuk] = $this->ModelInventaris->countByKategori($kategori_masuk);
        }
        $inventaris_keluar = $this->ModelInventaris->AllDataKeluar();
        $kategoriList_keluar = array_unique(array_column($inventaris_keluar, 'kategori'));
        $jumlahKategori_keluar = [];
        foreach ($kategoriList_keluar as $kategori_keluar) {
            $jumlahKategori_keluar[$kategori_keluar] = $this->ModelInventaris->countByKategori($kategori_keluar);
        }
        $nama_barang_masuk = $this->ModelInventaris->getNamaBarangMasuk();
        $data = [
            'judul'                 => 'Inventaris Masuk',
            'subjudul'              => '',
            'menu'                  => 'inventaris',
            'submenu'               => '',
            'page'                  => 'admin/v_inventaris',
            'inventaris_masuk'      => $inventaris_masuk,
            'jumlahKategori_masuk'  => $jumlahKategori_masuk,
            'kategoriList_masuk'    => $kategoriList_masuk,
            'inventaris_keluar'     => $inventaris_keluar,
            'jumlahKategori_keluar' => $jumlahKategori_keluar,
            'kategoriList_keluar'   => $kategoriList_keluar,
            'nama_barang_masuk'     => $nama_barang_masuk,
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function InsertData()
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
            'nama' => [
                'label' => 'Nama',
                'rules' => 'required|max_length[80]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 80 karakter',
                ]
            ],
            'jumlah' => [
                'label' => 'Jumlah',
                'rules' => 'required|numeric|greater_than[0]|less_than_equal_to[2147483647]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} harus berupa angka',
                    'greater_than' => '{field} harus lebih besar dari 0',
                    'less_than_equal_to' => '{field} tidak boleh lebih dari 10 digit (Rp. 2,147,483,647)',
                ]
            ],
            'harga' => [
                'label' => 'Harga',
                'rules' => 'numeric|greater_than[0]|less_than_equal_to[2147483647]',
                'errors' => [
                    'numeric' => '{field} harus berupa angka',
                    'greater_than' => '{field} harus lebih besar dari 0',
                    'less_than_equal_to' => '{field} tidak boleh lebih dari 10 digit (Rp. 2,147,483,647)',
                ]
            ],
            'satuan' => [
                'label' => 'Satuan',
                'rules' => 'required|max_length[25]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 25 karakter',
                ]
            ],
            'kondisi' => [
                'label' => 'Kondisi',
                'rules' => 'required|max_length[20]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 20 karakter',
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
                'nama'          => esc($this->request->getPost('nama')),
                'jumlah'        => esc($this->request->getPost('jumlah')),
                'harga'         => esc($this->request->getPost('harga')),
                'satuan'        => esc($this->request->getPost('satuan')),
                'kondisi'       => esc($this->request->getPost('kondisi')),
                'keterangan'    => esc($this->request->getPost('keterangan')),
                'status'        => 0,
                'user_id'       => session()->get('user_id'),
            ];
            $this->ModelInventaris->InsertData($data);
            session()->setFlashdata('info', 'Data inventaris masuk berhasil ditambahkan!');
            return redirect()->to(base_url('Inventaris'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Inventaris'))->withInput();
        }
    }

    public function EditData($id_inventaris)
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
            'nama' => [
                'label' => 'Nama',
                'rules' => 'required|max_length[80]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 80 karakter',
                ]
            ],
            'jumlah' => [
                'label' => 'Jumlah',
                'rules' => 'required|numeric|greater_than[0]|less_than_equal_to[2147483647]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} harus berupa angka',
                    'greater_than' => '{field} harus lebih besar dari 0',
                    'less_than_equal_to' => '{field} tidak boleh lebih dari 10 digit (Rp. 2,147,483,647)',
                ]
            ],
            'harga' => [
                'label' => 'Harga',
                'rules' => 'numeric|greater_than[0]|less_than_equal_to[2147483647]',
                'errors' => [
                    'numeric' => '{field} harus berupa angka',
                    'greater_than' => '{field} harus lebih besar dari 0',
                    'less_than_equal_to' => '{field} tidak boleh lebih dari 10 digit (Rp. 2,147,483,647)',
                ]
            ],
            'satuan' => [
                'label' => 'Satuan',
                'rules' => 'required|max_length[25]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 25 karakter',
                ]
            ],
            'kondisi' => [
                'label' => 'Kondisi',
                'rules' => 'required|max_length[20]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 20 karakter',
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
                'id_inventaris' => $id_inventaris,
                'kategori'      => $kategori,
                'nama'          => esc($this->request->getPost('nama')),
                'jumlah'        => esc($this->request->getPost('jumlah')),
                'harga'         => esc($this->request->getPost('harga')),
                'satuan'        => esc($this->request->getPost('satuan')),
                'kondisi'       => esc($this->request->getPost('kondisi')),
                'keterangan'    => esc($this->request->getPost('keterangan')),
                'status'        => 0,
                'user_id'       => session()->get('user_id'),
            ];
            $this->ModelInventaris->EditData($data);
            session()->setFlashdata('info', 'Data Inventaris masuk berhasil diubah!');
            return redirect()->to(base_url('Inventaris'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Inventaris'))->withInput();
        }
    }

    public function DeleteData($id_inventaris)
    {
        $data = [
            'id_inventaris' => $id_inventaris,
        ];
        $this->ModelInventaris->DeleteData($data);
        session()->setFlashdata('info', 'Data Inventaris masuk berhasil dihapus!');
        return redirect()->to(base_url('Inventaris'));
    }

    public function InsertDataKeluar()
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'nama_select' => [
                'label' => 'Nama Barang',
                'rules' => 'required|max_length[80]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 80 karakter',
                ]
            ],
            'jumlah_keluar' => [
                'label' => 'Jumlah',
                'rules' => 'required|numeric|greater_than[0]|less_than_equal_to[2147483647]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} harus berupa angka',
                    'greater_than' => '{field} harus lebih besar dari 0',
                    'less_than_equal_to' => '{field} tidak boleh lebih dari 10 digit',
                ]
            ],
        ])) {
            $nama = $this->request->getPost('nama_select');
            $existingItem = $this->ModelInventaris->getInventarisByNama($nama);
            if (!$existingItem) {
                session()->setFlashdata('errors_ik', ['Barang tidak ditemukan!']);
                return redirect()->to(base_url('Inventaris/' . '#inventariskeluar'));
            }
            $jumlahKeluar = (int)$this->request->getPost('jumlah_keluar');
            if ($jumlahKeluar > $existingItem['jumlah']) {
                session()->setFlashdata('errors_ik', ['Jumlah keluar melebihi stok yang tersedia!']);
                return redirect()->to(base_url('Inventaris/' . '#inventariskeluar'));
            }
            $dataKeluar = [
                'kategori'      => $this->request->getPost('kategori'),
                'nama'          => $nama,
                'jumlah'        => $jumlahKeluar,
                'satuan'        => $this->request->getPost('satuan'),
                'kondisi'       => $this->request->getPost('kondisi'),
                'harga'         => $this->request->getPost('harga'),
                'keterangan'    => $this->request->getPost('keterangan'),
                'status'        => 1,
                'user_id'       => session()->get('user_id'),
            ];
            $dataUpdate = [
                'id_inventaris' => $existingItem['id_inventaris'],
                'jumlah' => $existingItem['jumlah'] - $jumlahKeluar
            ];
            try {
                $result = $this->ModelInventaris->insertDataKeluarTransaction($dataKeluar, $dataUpdate);
                if ($result) {
                    session()->setFlashdata('info_ik', 'Data inventaris keluar berhasil ditambahkan!');
                } else {
                    session()->setFlashdata('errors_ik', ['Terjadi kesalahan saat memproses data!']);
                }
            } catch (\Exception $e) {
                session()->setFlashdata('errors_ik', ['Terjadi kesalahan saat memproses data!']);
            }
            return redirect()->to(base_url('Inventaris/' . '#inventariskeluar'));
        } else {
            session()->setFlashdata('errors_ik', $validation->getErrors());
            return redirect()->to(base_url('Inventaris/' . '#inventariskeluar'))->withInput();
        }
    }

    public function EditDataKeluar($id_inventaris)
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'harga' => [
                'label' => 'Harga',
                'rules' => 'numeric|greater_than[0]|less_than_equal_to[2147483647]',
                'errors' => [
                    'numeric' => '{field} harus berupa angka',
                    'greater_than' => '{field} harus lebih besar dari 0',
                    'less_than_equal_to' => '{field} tidak boleh lebih dari 10 digit (Rp. 2,147,483,647)',
                ]
            ],
            'kondisi' => [
                'label' => 'Kondisi',
                'rules' => 'required|max_length[20]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 20 karakter',
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
                'id_inventaris' => $id_inventaris,
                'harga'         => esc($this->request->getPost('harga')),
                'kondisi'       => esc($this->request->getPost('kondisi')),
                'keterangan'    => esc($this->request->getPost('keterangan')),
                'status'        => 1,
                'user_id'       => session()->get('user_id'),
            ];
            $this->ModelInventaris->EditData($data);
            session()->setFlashdata('info_ik', 'Data Inventaris masuk berhasil diubah!');
            return redirect()->to(base_url('Inventaris/' . '#inventariskeluar'));
        } else {
            session()->setFlashdata('errors_ik', $validation->getErrors());
            return redirect()->to(base_url('Inventaris/' . '#inventariskeluar'))->withInput();
        }
    }

    public function DeleteDataKeluar($id_inventaris)
    {
        $data = [
            'id_inventaris' => $id_inventaris,
        ];
        $this->ModelInventaris->DeleteData($data);
        session()->setFlashdata('info_ik', 'Data Inventaris keluar berhasil dihapus!');
        return redirect()->to(base_url('Inventaris/' . '#inventariskeluar'));
    }
}
