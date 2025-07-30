<?php

namespace App\Controllers;

use App\Models\ModelHome;
use App\Models\ModelAdmin;
use App\Models\ModelKasInternal;
use App\Models\ModelBeasiswa;
use App\Controllers\ConvertHijriyah;
use IntlDateFormatter;
use DateTime;
use Exception;

class Home extends BaseController
{
    protected $ModelHome;
    protected $ModelAdmin;
    protected $ModelKasInternal;
    protected $ModelBeasiswa;
    protected $convertHijriyah;

    public function __construct()
    {
        $pager = \Config\Services::pager();
        $this->ModelHome = new ModelHome();
        $this->ModelAdmin = new ModelAdmin();
        $this->ModelKasInternal = new ModelKasInternal();
        $this->ModelBeasiswa = new ModelBeasiswa();
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
        $jadwal_akademik = [
            'semester_aktif' => 'Semester Ganjil 2024/2025',
            'minggu_ke' => 'Minggu ke-' . ceil(date('j')/7),
            'tahun_akademik' => '2024/2025'
        ];
        $data = [
            'judul'         => 'Beranda',
            'menu'          => 'home',
            'page'          => 'home/v_home',
            'jadwal_akademik' => $jadwal_akademik,
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
            'judul'                 => 'Rekapitulasi Keuangan Kampus',
            'judul_inventaris'      => 'Rekapitulasi Inventaris Kampus',
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

    public function Beasiswa()
    {
        $data = [
            'judul'         => 'Informasi Beasiswa',
            'menu'          => 'beasiswa',
            'page'          => 'home/v_beasiswa',
            'beasiswa'      => $this->ModelBeasiswa->getActiveScholarships(),
            'all_beasiswa'  => $this->ModelBeasiswa->AllData(),
        ];
        return view('v_template_home', $data);
    }



    public function ProfilKampus()
    {
        $data = [
            'judul'         => 'Profil Kampus',
            'menu'          => 'tentang',
            'page'          => 'home/v_profil_kampus',
            'tentang'       => $this->ModelHome->ViewSetting(),
        ];
        return view('v_template_home', $data);
    }

    public function Pengaduan()
    {
        $data = [
            'judul'     => 'Pengaduan Mahasiswa',
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
            session()->setFlashdata('info', 'Pengaduan berhasil dikirim, menunggu jawaban dari admin kampus');
            return redirect()->to(base_url('Home/Pengaduan'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Home/Pengaduan'))->withInput('validation', \Config\Services::validation());
        }
    }
}
