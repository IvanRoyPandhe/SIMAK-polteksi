<?php

namespace App\Controllers;

use App\Models\ModelHome;
use App\Models\ModelAdmin;
use App\Models\ModelKasInternal;
use App\Models\ModelDonasi;
use App\Controllers\ConvertHijriyah;
use IntlDateFormatter;
use DateTime;
use Exception;

class Home extends BaseController
{
    protected $ModelHome;
    protected $ModelAdmin;
    protected $ModelKasInternal;
    protected $ModelDonasi;
    protected $convertHijriyah;

    public function __construct()
    {
        $pager = \Config\Services::pager();
        $this->ModelHome = new ModelHome();
        $this->ModelAdmin = new ModelAdmin();
        $this->ModelKasInternal = new ModelKasInternal();
        $this->ModelDonasi = new ModelDonasi();
        $this->convertHijriyah = new ConvertHijriyah();
    }

    public function index()
    {
        $kategori = $this->request->getPost('kategori');
        $search = $this->request->getPost('search');
        $data_setting = $this->ModelAdmin->ViewSetting();
        $tahun = date('Y');
        $bulan = date('m');
        $tanggal = date('d');
        $default_jadwal = [
            'data' => [
                'lokasi' => 'Tidak tersedia',
                'jadwal' => [
                    'tanggal' => 'N/A',
                    'imsak' => 'N/A',
                    'subuh' => 'N/A',
                    'dzuhur' => 'N/A',
                    'ashar' => 'N/A',
                    'maghrib' => 'N/A',
                    'isya' => 'N/A'
                ]
            ]
        ];
        try {
            $url = 'https://api.myquran.com/v2/sholat/jadwal/' . $data_setting['id_lokasi'] . '/' . $tahun . '/' . $bulan . '/' . $tanggal . '';
            $response = @file_get_contents($url);
            if ($response === FALSE) {
                $jadwal_sholat = $default_jadwal;
            } else {
                $jadwal_sholat = json_decode($response, true);
                if (!$jadwal_sholat || !isset($jadwal_sholat['data']['jadwal'])) {
                    $jadwal_sholat = $default_jadwal;
                }
            }
        } catch (Exception $e) {
            $jadwal_sholat = $default_jadwal;
        }
        $data = [
            'judul'         => 'Beranda',
            'menu'          => 'home',
            'page'          => 'home/v_home',
            'jadwal_sholat' => $jadwal_sholat,
            'kasinternal'   => $this->ModelKasInternal->AllData(),
            'kegiatan'      => $this->ModelHome->DataKegiatan(),
            'pengumuman'    => $this->ModelHome->DataPengumuman(),
            'artikel'       => $this->ModelHome->getArtikelWithFilters($kategori, $search),
            'kat_artikel'   => $this->ModelHome->AllDataKategoriArtikel(),
            'pager'         => $this->ModelHome->pager,
            'total_artikel' => $this->ModelHome->getArtikelCount($kategori, $search),
            'kategori'      => $kategori,
            'search'        => $search
        ];
        return view('v_template_home', $data);
    }

    public function DetailArtikel($slug)
    {
        $artikel = $this->ModelHome->getArtikelById($slug);
        if (!$artikel) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Artikel dengan SLUG $slug tidak ditemukan");
        }
        if ($artikel['status'] === 'Private' && !session()->get('user_id')) {
            return redirect()->to('Home')->with('error', 'Anda harus login untuk melihat artikel ini.');
        }
        $data = [
            'judul'         => 'Detail Artikel',
            'menu'          => '',
            'page'          => 'home/v_detail_artikel',
            'artikel'       => $artikel,
            'kat_artikel'   => $this->ModelHome->AllDataArtikel(),
        ];
        return view('v_template_home', $data);
    }

    public function RekapKeuangan()
    {
        $inventaris_masuk = $this->ModelHome->DataInventarisMasuk();
        $inventaris_keluar = $this->ModelHome->DataInventarisKeluar();
        $kategoriList_masuk = array_unique(array_column($inventaris_masuk, 'kategori'));
        $jumlahKategori_masuk = [];
        foreach ($kategoriList_masuk as $kategori) {
            $jumlahKategori_masuk[$kategori] = $this->ModelHome->InventariscountByKategori($kategori);
        }
        $kategoriList_keluar = array_unique(array_column($inventaris_keluar, 'kategori'));
        $jumlahKategori_keluar = [];
        foreach ($kategoriList_keluar as $kategori) {
            $jumlahKategori_keluar[$kategori] = $this->ModelHome->InventariscountByKategori($kategori);
        }
        $data = [
            'judul'                 => 'Rekapitulasi Keuangan Internal',
            'judul_inventaris'      => 'Rekapitulasi Inventaris Barang',
            'menu'                  => 'keuangan',
            'page'                  => 'home/v_rekap_keuangan',
            'kas'                   => $this->ModelHome->DataKasInternal(),
            'inventaris_masuk'      => $inventaris_masuk,
            'inventaris_keluar'     => $inventaris_keluar,
            'jumlahKategori_masuk'  => $jumlahKategori_masuk,
            'jumlahKategori_keluar' => $jumlahKategori_keluar,
            'kategoriList_masuk'    => $kategoriList_masuk,
            'kategoriList_keluar'   => $kategoriList_keluar,
            'last_update'           => $this->ModelHome->getLastUpdate(),
        ];
        return view('v_template_home', $data);
    }

    public function Kegiatan()
    {
        $data = [
            'judul'         => 'Kegiatan',
            'menu'          => 'kegiatan',
            'page'          => 'home/v_kegiatan',
            'kegiatan'      => $this->ModelHome->DataKegiatan(),
            'pengumuman'    => $this->ModelHome->DataPengumuman(),
        ];
        return view('v_template_home', $data);
    }

    public function Donasi()
    {
        $data = [
            'judul'         => 'Donasi',
            'menu'          => 'donasi',
            'subjudul'      => 'Rekening Masjid',
            'page'          => 'home/v_donasi',
            'rekening'      => $this->ModelDonasi->AllData(),
            'donasi'        => $this->ModelDonasi->AllDataDonasi(),
            'donasi_db'     => $this->ModelDonasi->AllDataDonasiBarang(),
            'validation'    => \Config\Services::validation(),
        ];
        return view('v_template_home', $data);
    }

    public function InsertDonasi()
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'nama_bank_p' => [
                'label' => 'Nama Bank Pengirim',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 100 karakter',
                ]
            ],
            'no_rek_p' => [
                'label' => 'No Rekening Pengirim',
                'rules' => 'required|max_length[25]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 25 karakter',
                ]
            ],
            'nama_rek_p' => [
                'label' => 'Nama Rekening Pengirim',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 100 karakter',
                ]
            ],
            'nama_p' => [
                'label' => 'Nama Pengirim',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 100 karakter',
                ]
            ],
            'jumlah' => [
                'label' => 'jumlah',
                'rules' => 'required|numeric|greater_than[0]|less_than_equal_to[2147483647]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} harus berupa angka',
                    'greater_than' => '{field} harus lebih besar dari 0',
                    'less_than_equal_to' => '{field} tidak boleh lebih dari 10 digit (Rp. 2,147,483,647)',
                ]
            ],
            'bukti_transfer' => [
                'label' => 'Bukti Transfer',
                'rules' => 'uploaded[bukti_transfer]|max_size[bukti_transfer,5000]|mime_in[bukti_transfer,image/png,image/jpg,image/jpeg]',
                'errors' => [
                    'uploaded' => '{field} harus di upload',
                    'max_size' => '{field} ukuran maksimal 5MB',
                    'mime_in' => '{field} hanya bisa mengirim format gambar',
                ]
            ],
            'rekening_id' => [
                'label' => 'Rekening Penerima',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus dipilih'
                ]
            ],
        ])) {
            $bukti = $this->request->getFile('bukti_transfer');
            $file_bukti = $bukti->getRandomName();
            $data = [
                'rekening_id'       => esc($this->request->getPost('rekening_id')),
                'nama_bank_p'       => esc($this->request->getPost('nama_bank_p')),
                'no_rek_p'          => esc($this->request->getPost('no_rek_p')),
                'nama_rek_p'        => esc($this->request->getPost('nama_rek_p')),
                'nama_p'            => esc($this->request->getPost('nama_p')),
                'jumlah'            => esc($this->request->getPost('jumlah')),
                'status'            => 'Belum Tervalidasi',
                'jenis'             => 'Tunai',
                'bukti_transfer'    => $file_bukti,
            ];
            $bukti->move('uploaded/bukti_transfer', $file_bukti);
            $this->ModelHome->InsertDonasi($data);
            session()->setFlashdata('info', 'Bukti Transfer berhasil dikirim, menunggu di validasi takmir dan akan tampil di Halaman Keuangan');
            return redirect()->to(base_url('Home/Donasi'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Home/Donasi'))->withInput('validation', \Config\Services::validation());
        }
    }

    public function ProfilMasjid()
    {
        $data = [
            'judul'         => 'Profil Masjid',
            'menu'          => 'tentang',
            'page'          => 'home/v_profil_masjid',
            'tentang'       => $this->ModelHome->ViewSetting(),
        ];
        return view('v_template_home', $data);
    }

    public function Pengaduan()
    {
        $data = [
            'judul'     => 'Pengaduan Masjid',
            'menu'      => 'pengaduan',
            'page'      => 'home/v_pengaduan',
            'pengaduan' => $this->ModelHome->AllDataPengaduan(),
        ];
        return view('v_template_home', $data);
    }

    public function InsertPengaduan()
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'nama_pengadu' => [
                'label' => 'Nama Pengadu',
                'rules' => 'required|max_length[80]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 80 karakter',
                ]
            ],
            'no_hp' => [
                'label' => 'No HP',
                'rules' => 'max_length[15]',
                'errors' => [
                    'max_length' => '{field} tidak boleh lebih dari 15 karakter',
                ]
            ],
            'jenis_masalah' => [
                'label' => 'Jenis Masalah',
                'rules' => 'required|max_length[40]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 40 karakter',
                ]
            ],
            'masalah' => [
                'label' => 'Masalah',
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 255 karakter',
                ]
            ],
            'lampiran' => [
                'label' => 'lampiran Pengaduan',
                'rules' => 'max_size[lampiran,5000]|mime_in[lampiran,image/png,image/jpg,image/jpeg]',
                'errors' => [
                    'max_size' => '{field} ukuran maksimal 5MB',
                    'mime_in' => '{field} hanya bisa mengirim format gambar',
                ]
            ],
        ])) {
            $lampiran = $this->request->getFile('lampiran');
            if ($lampiran && $lampiran->isValid()) {
                $file_lampiran = $lampiran->getRandomName();
                $lampiran->move('uploaded/lampiran_pengaduan', $file_lampiran);
            } else {
                $file_lampiran = 'null.png';
            }
            $data = [
                'nama_pengadu'  => esc($this->request->getPost('nama_pengadu')),
                'no_hp'         => esc($this->request->getPost('no_hp')),
                'jenis_masalah' => esc($this->request->getPost('jenis_masalah')),
                'masalah'       => esc($this->request->getPost('masalah')),
                'lampiran'      => $file_lampiran,
                'status'        => 0,
            ];
            $this->ModelHome->InsertPengaduan($data);
            session()->setFlashdata('info', 'Pengaduan berhasil dikirim, menunggu di jawaban takmir');
            return redirect()->to(base_url('Home/Pengaduan'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Home/Pengaduan'))->withInput('validation', \Config\Services::validation());
        }
    }
}
