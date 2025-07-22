<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ModelAdmin;
use App\Models\ModelKasInternal;
use App\Models\ModelUser;

class Admin extends BaseController
{
    protected $ModelAdmin;
    protected $ModelKasInternal;
    protected $ModelUser;

    public function __construct()
    {
        $this->ModelAdmin = new ModelAdmin();
        $this->ModelKasInternal = new ModelKasInternal();
        $this->ModelUser = new ModelUser();
    }

    public function index()
    {
        $bulanIndonesia = [
            'Jan' => 'Jan',
            'Feb' => 'Feb',
            'Mar' => 'Mar',
            'Apr' => 'Apr',
            'May' => 'Mei',
            'Jun' => 'Jun',
            'Jul' => 'Jul',
            'Aug' => 'Ags',
            'Sep' => 'Sep',
            'Oct' => 'Okt',
            'Nov' => 'Nov',
            'Dec' => 'Des'
        ];
        $monthlyData = $this->ModelAdmin->getMonthlyData();
        $bulan = [];
        $danaMasuk = [];
        $danaKeluar = [];
        foreach ($monthlyData as $data) {
            $bulanFormat = date('M Y', strtotime($data['bulan']));
            $bulan[] = $bulanIndonesia[date('M', strtotime($data['bulan']))] . ' ' . date('Y', strtotime($data['bulan']));
            $danaMasuk[] = $data['total_masuk'];
            $danaKeluar[] = $data['total_keluar'];
        }
        $kegiatanData = $this->ModelAdmin->getMonthlyKegiatan();
        $kegiatanBulan = [];
        $totalKegiatan = [];
        foreach ($kegiatanData as $data) {
            $kegiatanBulan[] = $bulanIndonesia[date('M', strtotime($data['bulan']))] . ' ' . date('Y', strtotime($data['bulan']));
            $totalKegiatan[] = $data['total_kegiatan'];
        }
        $artikelData = $this->ModelAdmin->getMonthlyArtikel();
        $artikelBulan = [];
        $totalArtikel = [];
        foreach ($artikelData as $data) {
            $artikelBulan[] = $bulanIndonesia[date('M', strtotime($data['bulan']))] . ' ' . date('Y', strtotime($data['bulan']));
            $totalArtikel[] = $data['total_artikel'];
        }
        $data = [
            'judul'             => 'Dashboard',
            'menu'              => 'dashboard',
            'submenu'           => '',
            'page'              => 'admin/v_dashboard',
            'bulan'             => json_encode($bulan),
            'danaMasuk'         => json_encode($danaMasuk),
            'danaKeluar'        => json_encode($danaKeluar),
            'kegiatanBulan'     => json_encode($kegiatanBulan),
            'totalKegiatan'     => json_encode($totalKegiatan),
            'artikelBulan'      => json_encode($artikelBulan),
            'totalArtikel'      => json_encode($totalArtikel),
            'setting'           => $this->ModelAdmin->ViewSetting(),
            'kasinternal'       => $this->ModelKasInternal->AllData(),
            'kasinternal_MA'    => $this->ModelAdmin->AllDataKasInternal(),
            'pengaduan'         => $this->ModelAdmin->AllDataPengaduan(),
            'donasi'            => $this->ModelAdmin->AllDataDonasi(),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function Setting()
    {
        $url = 'https://api.myquran.com/v2/sholat/kota/semua';
        $response = @file_get_contents($url);
        if ($response === FALSE) {
            $lokasi = [
                ['id' => 0000, 'lokasi' => 'Tidak Ada Data Karena Api Bermasalah'],
                ['id' => 1418, 'lokasi' => 'KAB. PEKALONGAN (API Bermasalah)']
            ];
        } else {
            $data_lokasi = json_decode($response, true);
            $lokasi = $data_lokasi['data'];
        }
        $id_lokasi = $this->ModelAdmin->ViewSetting()['id_lokasi'];
        $pilih_lokasi = '';
        foreach ($lokasi as $isi_lokasi) {
            if ($isi_lokasi['id'] == $id_lokasi) {
                $pilih_lokasi = $isi_lokasi['lokasi'];
                break;
            }
        }
        $data = [
            'judul'         => 'Setting',
            'menu'          => 'web-setting',
            'submenu'       => '',
            'page'          => 'admin/v_setting',
            'setting'       => $this->ModelAdmin->ViewSetting(),
            'lokasi'        => $lokasi,
            'pilih_lokasi'  => $pilih_lokasi,
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function EditSetting()
    {
        $validation = \Config\Services::validation();
        $keterangan = $this->request->getPost('keterangan');
        $keterangan_trimmed = trim($keterangan);
        $keterangan_plain = strip_tags($keterangan_trimmed);
        if (empty($keterangan_plain)) {
            $validation->setError('keterangan', 'Keterangan konten tidak boleh kosong');
        }
        if ($this->validate([
            'nama_masjid' => [
                'label' => 'Nama Masjid',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 100 karakter',
                ]
            ],
            'id_lokasi' => [
                'label' => 'ID Lokasi',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'alamat_masjid' => [
                'label' => 'Nama Masjid',
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 255 karakter',
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
            $data = [
                'id_set'        => 1,
                'nama_masjid'   => $this->request->getPost('nama_masjid'),
                'id_lokasi'     => $this->request->getPost('id_lokasi'),
                'alamat_masjid' => $this->request->getPost('alamat_masjid'),
                'keterangan'    => $keterangan,
                'user_id'       => session()->get('user_id'),
            ];
            $this->ModelAdmin->EditSetting($data);
            session()->setFlashdata('info', 'Data setting berhasil diubah!');
            return redirect()->to(base_url('Admin/Setting'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Admin/Setting'))->withInput();
        }
    }
}
