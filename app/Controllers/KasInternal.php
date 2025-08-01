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
    protected $user;

    public function __construct()
    {
        $this->ModelKasInternal = new ModelKasInternal();
        $this->ModelAdmin = new ModelAdmin();
        
        // Get user data from session
        $userModel = new ModelUser();
        $this->user = $userModel->find(session()->get('user_id'));
    }

    public function index()
    {
        $data = [
            'judul'     => 'Dashboard Keuangan Internal',
            'subjudul'  => '',
            'menu'      => 'kas-internal',
            'submenu'   => 'dashboard-keuangan',
            'page'      => 'admin/keuangan/v_dashboard_keuangan',
            'stats'     => $this->ModelAdmin->getKeuanganStats(),
            'top_kategori' => $this->ModelAdmin->getTopKategoriPengeluaran(),
            'cashflow_trend' => $this->ModelAdmin->getCashFlowTrend(),
            'recent_transactions' => $this->ModelAdmin->AllDataKasInternal(),
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
        $currentTransaction = $this->ModelKasInternal->db->table('tb_keuangan_internal')->where('id_kas_internal', $id_keuangan)->get()->getRowArray();
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

    public function Anggaran()
    {
        $data = [
            'judul'     => 'Manajemen Anggaran',
            'menu'      => 'kas-internal',
            'submenu'   => 'anggaran',
            'page'      => 'admin/keuangan/v_anggaran',
            'anggaran'  => $this->getAnggaranData(),
            'periode'   => $this->getPeriodeOptions(),
            'kategori'  => $this->getKategoriOptions(),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function RekeningBank()
    {
        $data = [
            'judul'     => 'Manajemen Rekening Bank',
            'menu'      => 'kas-internal',
            'submenu'   => 'rekening-bank',
            'page'      => 'admin/keuangan/v_rekening_bank',
            'rekening'  => $this->getRekeningData(),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function Kategori()
    {
        $data = [
            'judul'     => 'Kategori Keuangan',
            'menu'      => 'kas-internal',
            'submenu'   => 'kategori-keuangan',
            'page'      => 'admin/keuangan/v_kategori',
            'kategori'  => $this->getKategoriData(),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function Laporan()
    {
        $periode = $this->request->getGet('periode') ?? '2024-12';
        $data = [
            'judul'     => 'Laporan Keuangan',
            'menu'      => 'kas-internal',
            'submenu'   => 'laporan-keuangan',
            'page'      => 'admin/keuangan/v_laporan',
            'periode'   => $periode,
            'periode_options' => $this->getAvailablePeriods(),
            'summary'   => $this->getLaporanSummary($periode),
            'pemasukan' => $this->getLaporanPemasukan($periode),
            'pengeluaran' => $this->getLaporanPengeluaran($periode),
            'transaksi' => $this->getLaporanTransaksi($periode),
            'saldo_bank' => $this->getTotalSaldoBank(),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    private function getAnggaranData()
    {
        $db = \Config\Database::connect();
        return $db->table('tb_anggaran')
            ->join('tb_kategori_keuangan', 'tb_kategori_keuangan.id_kategori = tb_anggaran.kategori_id', 'left')
            ->join('tb_periode_akademik', 'tb_periode_akademik.id_periode = tb_anggaran.periode_id', 'left')
            ->select('tb_anggaran.*, tb_kategori_keuangan.nama_kategori, tb_periode_akademik.semester, tb_periode_akademik.tahun_akademik')
            ->orderBy('tb_anggaran.created_at', 'DESC')
            ->get()->getResultArray();
    }

    private function getPeriodeOptions()
    {
        $db = \Config\Database::connect();
        return $db->table('tb_periode_akademik')
            ->where('is_active', 1)
            ->orderBy('tahun_akademik', 'DESC')
            ->get()->getResultArray();
    }

    private function getKategoriOptions()
    {
        $db = \Config\Database::connect();
        return $db->table('tb_kategori_keuangan')
            ->where('is_active', 1)
            ->orderBy('nama_kategori')
            ->get()->getResultArray();
    }

    private function getRekeningData()
    {
        $db = \Config\Database::connect();
        return $db->table('tb_rekening_bank')
            ->where('is_active', 1)
            ->orderBy('nama_bank')
            ->get()->getResultArray();
    }

    private function getKategoriData()
    {
        $db = \Config\Database::connect();
        return $db->table('tb_kategori_keuangan')
            ->where('is_active', 1)
            ->orderBy('jenis')
            ->orderBy('nama_kategori')
            ->get()->getResultArray();
    }

    public function ApproveTransaction($id)
    {
        $db = \Config\Database::connect();
        $db->table('tb_keuangan_internal')
            ->where('id_keuangan_internal', $id)
            ->update([
                'status_approval' => 'Approved',
                'approved_by' => session()->get('user_id'),
                'approved_at' => date('Y-m-d H:i:s')
            ]);
        
        session()->setFlashdata('info', 'Transaksi berhasil disetujui!');
        return redirect()->to(base_url('KasInternal'));
    }

    public function InsertRekening()
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'nama_bank' => 'required|max_length[50]',
            'no_rekening' => 'required|max_length[30]',
            'nama_pemilik' => 'required|max_length[100]',
            'saldo_awal' => 'required|numeric|greater_than_equal_to[0]',
        ])) {
            $db = \Config\Database::connect();
            $db->table('tb_rekening_bank')->insert([
                'nama_bank' => esc($this->request->getPost('nama_bank')),
                'no_rekening' => esc($this->request->getPost('no_rekening')),
                'nama_pemilik' => esc($this->request->getPost('nama_pemilik')),
                'saldo_awal' => esc($this->request->getPost('saldo_awal')),
                'saldo_akhir' => esc($this->request->getPost('saldo_awal')),
                'is_active' => 1
            ]);
            session()->setFlashdata('info', 'Rekening bank berhasil ditambahkan!');
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
        }
        return redirect()->to(base_url('KasInternal/RekeningBank'));
    }

    public function UpdateRekening($id)
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'nama_bank' => 'required|max_length[50]',
            'no_rekening' => 'required|max_length[30]',
            'nama_pemilik' => 'required|max_length[100]',
            'saldo_awal' => 'required|numeric|greater_than_equal_to[0]',
        ])) {
            $db = \Config\Database::connect();
            $db->table('tb_rekening_bank')
                ->where('id_rekening', $id)
                ->update([
                    'nama_bank' => esc($this->request->getPost('nama_bank')),
                    'no_rekening' => esc($this->request->getPost('no_rekening')),
                    'nama_pemilik' => esc($this->request->getPost('nama_pemilik')),
                    'saldo_awal' => esc($this->request->getPost('saldo_awal'))
                ]);
            session()->setFlashdata('info', 'Rekening bank berhasil diupdate!');
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
        }
        return redirect()->to(base_url('KasInternal/RekeningBank'));
    }

    public function DeleteRekening($id)
    {
        $db = \Config\Database::connect();
        $db->table('tb_rekening_bank')
            ->where('id_rekening', $id)
            ->update(['is_active' => 0]);
        session()->setFlashdata('info', 'Rekening bank berhasil dihapus!');
        return redirect()->to(base_url('KasInternal/RekeningBank'));
    }

    public function RejectTransaction($id)
    {
        $db = \Config\Database::connect();
        $db->table('tb_keuangan_internal')
            ->where('id_keuangan_internal', $id)
            ->update([
                'status_approval' => 'Rejected',
                'approved_by' => session()->get('user_id'),
                'approved_at' => date('Y-m-d H:i:s')
            ]);
        
        session()->setFlashdata('info', 'Transaksi ditolak!');
        return redirect()->to(base_url('KasInternal'));
    }

    public function InsertKategori()
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'kode_kategori' => 'required|is_unique[tb_kategori_keuangan.kode_kategori]|max_length[10]',
            'nama_kategori' => 'required|max_length[100]',
            'jenis' => 'required|in_list[Pemasukan,Pengeluaran]',
        ])) {
            $db = \Config\Database::connect();
            $db->table('tb_kategori_keuangan')->insert([
                'kode_kategori' => esc($this->request->getPost('kode_kategori')),
                'nama_kategori' => esc($this->request->getPost('nama_kategori')),
                'jenis' => esc($this->request->getPost('jenis')),
                'is_active' => 1
            ]);
            session()->setFlashdata('info', 'Kategori berhasil ditambahkan!');
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
        }
        return redirect()->to(base_url('KasInternal/Kategori'));
    }

    public function UpdateKategori($id)
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'kode_kategori' => 'required|max_length[10]',
            'nama_kategori' => 'required|max_length[100]',
            'jenis' => 'required|in_list[Pemasukan,Pengeluaran]',
        ])) {
            $db = \Config\Database::connect();
            $db->table('tb_kategori_keuangan')
                ->where('id_kategori', $id)
                ->update([
                    'kode_kategori' => esc($this->request->getPost('kode_kategori')),
                    'nama_kategori' => esc($this->request->getPost('nama_kategori')),
                    'jenis' => esc($this->request->getPost('jenis'))
                ]);
            session()->setFlashdata('info', 'Kategori berhasil diupdate!');
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
        }
        return redirect()->to(base_url('KasInternal/Kategori'));
    }

    public function DeleteKategori($id)
    {
        $db = \Config\Database::connect();
        $db->table('tb_kategori_keuangan')
            ->where('id_kategori', $id)
            ->update(['is_active' => 0]);
        session()->setFlashdata('info', 'Kategori berhasil dihapus!');
        return redirect()->to(base_url('KasInternal/Kategori'));
    }

    private function getLaporanSummary($periode)
    {
        $db = \Config\Database::connect();
        $year = substr($periode, 0, 4);
        $month = substr($periode, 5, 2);
        
        $result = $db->table('tb_keuangan_internal')
            ->select('SUM(dana_masuk) as total_masuk, SUM(dana_keluar) as total_keluar')
            ->where('YEAR(tgl)', $year)
            ->where('MONTH(tgl)', $month)
            ->get()->getRowArray();
            
        return [
            'total_masuk' => $result['total_masuk'] ?? 0,
            'total_keluar' => $result['total_keluar'] ?? 0,
            'saldo_bersih' => ($result['total_masuk'] ?? 0) - ($result['total_keluar'] ?? 0)
        ];
    }

    private function getLaporanPemasukan($periode)
    {
        $db = \Config\Database::connect();
        $year = substr($periode, 0, 4);
        $month = substr($periode, 5, 2);
        
        return $db->table('tb_keuangan_internal k')
            ->join('tb_kategori_keuangan kat', 'kat.id_kategori = k.kategori_id', 'left')
            ->select('COALESCE(kat.nama_kategori, "Tidak ada kategori") as kategori, SUM(k.dana_masuk) as total')
            ->where('YEAR(k.tgl)', $year)
            ->where('MONTH(k.tgl)', $month)
            ->where('k.dana_masuk >', 0)
            ->groupBy('k.kategori_id')
            ->orderBy('total', 'DESC')
            ->get()->getResultArray();
    }

    private function getLaporanPengeluaran($periode)
    {
        $db = \Config\Database::connect();
        $year = substr($periode, 0, 4);
        $month = substr($periode, 5, 2);
        
        return $db->table('tb_keuangan_internal k')
            ->join('tb_kategori_keuangan kat', 'kat.id_kategori = k.kategori_id', 'left')
            ->select('COALESCE(kat.nama_kategori, "Tidak ada kategori") as kategori, SUM(k.dana_keluar) as total')
            ->where('YEAR(k.tgl)', $year)
            ->where('MONTH(k.tgl)', $month)
            ->where('k.dana_keluar >', 0)
            ->groupBy('k.kategori_id')
            ->orderBy('total', 'DESC')
            ->get()->getResultArray();
    }

    private function getLaporanTransaksi($periode)
    {
        $db = \Config\Database::connect();
        $year = substr($periode, 0, 4);
        $month = substr($periode, 5, 2);
        
        return $db->table('tb_keuangan_internal k')
            ->join('tb_kategori_keuangan kat', 'kat.id_kategori = k.kategori_id', 'left')
            ->select('k.*, COALESCE(kat.nama_kategori, "Tidak ada kategori") as kategori')
            ->where('YEAR(k.tgl)', $year)
            ->where('MONTH(k.tgl)', $month)
            ->orderBy('k.tgl', 'ASC')
            ->get()->getResultArray();
    }

    private function getTotalSaldoBank()
    {
        $db = \Config\Database::connect();
        $result = $db->table('tb_rekening_bank')
            ->select('SUM(saldo_akhir) as total_saldo')
            ->where('is_active', 1)
            ->get()->getRowArray();
            
        return $result['total_saldo'] ?? 0;
    }

    private function getAvailablePeriods()
    {
        $db = \Config\Database::connect();
        return $db->table('tb_keuangan_internal')
            ->select('MAX(YEAR(tgl)) as year, MAX(MONTH(tgl)) as month, CONCAT(MAX(YEAR(tgl)), "-", LPAD(MAX(MONTH(tgl)), 2, "0")) as periode, DATE_FORMAT(MIN(tgl), "%M %Y") as periode_name')
            ->groupBy('YEAR(tgl), MONTH(tgl)')
            ->orderBy('MAX(YEAR(tgl))', 'DESC')
            ->orderBy('MAX(MONTH(tgl))', 'DESC')
            ->get()->getResultArray();
    }

    public function InsertAnggaran()
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'periode_id' => 'required|integer',
            'kategori_id' => 'required|integer',
            'jumlah_anggaran' => 'required|numeric|greater_than[0]',
        ])) {
            $db = \Config\Database::connect();
            $db->table('tb_anggaran')->insert([
                'periode_id' => esc($this->request->getPost('periode_id')),
                'kategori_id' => esc($this->request->getPost('kategori_id')),
                'jumlah_anggaran' => esc($this->request->getPost('jumlah_anggaran')),
                'keterangan' => esc($this->request->getPost('keterangan')),
                'status' => 'Draft'
            ]);
            session()->setFlashdata('info', 'Anggaran berhasil ditambahkan!');
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
        }
        return redirect()->to(base_url('KasInternal/Anggaran'));
    }

    public function UpdateAnggaran($id)
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'periode_id' => 'required|integer',
            'kategori_id' => 'required|integer',
            'jumlah_anggaran' => 'required|numeric|greater_than[0]',
        ])) {
            $db = \Config\Database::connect();
            $db->table('tb_anggaran')
                ->where('id_anggaran', $id)
                ->update([
                    'periode_id' => esc($this->request->getPost('periode_id')),
                    'kategori_id' => esc($this->request->getPost('kategori_id')),
                    'jumlah_anggaran' => esc($this->request->getPost('jumlah_anggaran')),
                    'keterangan' => esc($this->request->getPost('keterangan'))
                ]);
            session()->setFlashdata('info', 'Anggaran berhasil diupdate!');
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
        }
        return redirect()->to(base_url('KasInternal/Anggaran'));
    }

    public function DeleteAnggaran($id)
    {
        $db = \Config\Database::connect();
        $db->table('tb_anggaran')
            ->where('id_anggaran', $id)
            ->delete();
        session()->setFlashdata('info', 'Anggaran berhasil dihapus!');
        return redirect()->to(base_url('KasInternal/Anggaran'));
    }
}
