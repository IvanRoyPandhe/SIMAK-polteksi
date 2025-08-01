<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ModelKasInternal;
use App\Models\ModelAdmin;
use App\Models\ModelLaporan;
use App\Models\ModelUser;

class Laporan extends BaseController
{
    protected $ModelKasInternal;
    protected $ModelAdmin;
    protected $ModelLaporan;
    protected $user;

    public function __construct()
    {
        $this->ModelKasInternal = new ModelKasInternal();
        $this->ModelAdmin = new ModelAdmin();
        $this->ModelLaporan = new ModelLaporan();
        
        // Get user data from session
        $userModel = new ModelUser();
        $this->user = $userModel->find(session()->get('user_id'));
    }
    public function index()
    {
        //
    }

    public function LaporanKas()
    {
        try {
            $tahunData = $this->ModelLaporan->getTahunKeuangan();
            $tahunList = [];
            if (!empty($tahunData)) {
                foreach ($tahunData as $tahun) {
                    $tahunList[] = $tahun->tahun;
                }
            }
            // Add current year if not exists
            if (empty($tahunList)) {
                $tahunList[] = date('Y');
            }
            
            $kategoriData = $this->ModelLaporan->getKategoriKeuangan();
            $kategoriList = [];
            if (!empty($kategoriData)) {
                foreach ($kategoriData as $kategori) {
                    $kategoriList[] = $kategori->keterangan;
                }
            }
            
            $data = [
                'judul'         => 'Laporan Kas Internal',
                'menu'          => 'laporan',
                'submenu'       => 'laporan-kas-internal',
                'page'          => 'admin/laporan/v_laporan_kas_internal',
                'tahunList'     => $tahunList,
                'kategoriList'  => $kategoriList,
                'dataTableKas'  => [],
            ];
            $data['user'] = $this->user;
            return view('v_template_admin', $data);
        } catch (\Exception $e) {
            $data = [
                'judul'         => 'Laporan Kas Internal',
                'menu'          => 'laporan',
                'submenu'       => 'laporan-kas-internal',
                'page'          => 'admin/laporan/v_laporan_kas_internal',
                'tahunList'     => [date('Y')],
                'kategoriList'  => [],
                'dataTableKas'  => [],
            ];
            $data['user'] = $this->user;
            return view('v_template_admin', $data);
        }
    }

    public function ViewLaporanKas()
    {
        $bulan = $this->request->getPost('bulan');
        $kategori = $this->request->getPost('kategori');
        $status = $this->request->getPost('status');
        $tahun = $this->request->getPost('tahun');
        $nama_bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];
        $bulan_text = !empty($bulan) ? ($nama_bulan[$bulan] ?? 'Bulan tidak valid') : 'Semua Bulan';
        $kategori_text = !empty($kategori) ? $kategori : '';
        $status_text = !empty($status) ? $status : '';
        if (!empty($bulan)) {
            $bulan_text = $nama_bulan[$bulan] ?? 'Bulan tidak valid';
        }
        if (empty($tahun)) {
            return json_encode(['error' => 'Tahun wajib diisi.']);
        }
        if (!empty($bulan) && !empty($kategori) && empty($status)) {
            $dataKas = $this->ModelLaporan->AllDataLaporanByBulanKategoriTahun($bulan, $kategori, $tahun);
        } elseif (!empty($bulan) && !empty($status) && empty($kategori)) {
            $dataKas = $this->ModelLaporan->AllDataLaporanByBulanStatusTahun($bulan, $status, $tahun);
        } elseif (!empty($kategori) && !empty($status) && empty($bulan)) {
            $dataKas = $this->ModelLaporan->AllDataLaporanByKategoriStatusTahun($kategori, $status, $tahun);
        } elseif (!empty($bulan) && !empty($kategori) && !empty($status)) {
            $dataKas = $this->ModelLaporan->AllDataLaporanByAll($bulan, $kategori, $status, $tahun);
        } elseif (empty($bulan) && !empty($kategori)) {
            $dataKas = $this->ModelLaporan->AllDataLaporanByKategoriTahun($kategori, $tahun);
        } elseif (empty($bulan) && !empty($status)) {
            $dataKas = $this->ModelLaporan->AllDataLaporanByStatusTahun($status, $tahun);
        } elseif (!empty($bulan)) {
            $dataKas = $this->ModelLaporan->AllDataLaporanByBulanTahun($bulan, $tahun);
        } else {
            $dataKas = $this->ModelLaporan->AllDataLaporanByYear($tahun);
        }
        if (empty($dataKas)) {
            $dataKas = [];
        }
        $data = [
            'judul'         => 'Laporan Kas Internal',
            'kas'           => $dataKas,
            'bulan'         => $bulan_text,
            'kategori'      => $kategori_text,
            'status'        => $status_text,
            'tahun'         => $tahun,
            'user_name'     => session()->get('nama'),
            'masjid'        => $this->ModelAdmin->ViewSetting(),
            'kasinternal'   => $this->ModelKasInternal->AllData(),
        ];
        if (empty($dataKas)) {
            $response = [
                'data' => '<p><b>Tidak ada data keuangan pada filter yang dipilih.</b></p>',
            ];
        } else {
            $response = [
                'data' => view('admin/laporan/v_data_laporan_kas_internal', $data),
            ];
        }
        echo json_encode($response);
    }

    public function LaporanBisyaroh()
    {
        $tahunData = $this->ModelLaporan->getTahunBisyaroh();
        $tahunList = [];
        foreach ($tahunData as $tahun) {
            $tahunList[] = $tahun->tahun;
        }
        $data = [
            'judul'     => 'Laporan Bisyaroh',
            'menu'      => 'laporan',
            'submenu'   => 'laporan-bisyaroh',
            'page'      => 'admin/laporan/v_laporan_bisyaroh',
            'masjid'    => $this->ModelAdmin->ViewSetting(),
            'tahunList' => $tahunList,
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function ViewLaporanBisyaroh()
    {
        $bulan = esc($this->request->getPost('bulan'));
        $tahun = esc($this->request->getPost('tahun'));
        $jabatan = esc($this->request->getPost('jabatan'));
        $nama = esc($this->request->getPost('nama'));
        $nama_bulan = [
            1 => 'JANUARI',
            2 => 'FEBRUARI',
            3 => 'MARET',
            4 => 'APRIL',
            5 => 'MEI',
            6 => 'JUNI',
            7 => 'JULI',
            8 => 'AGUSTUS',
            9 => 'SEPTEMBER',
            10 => 'OKTOBER',
            11 => 'NOVEMBER',
            12 => 'DESEMBER'
        ];
        if (isset($nama_bulan[$bulan])) {
            $bulan_text = $nama_bulan[$bulan];
        } else {
            $bulan_text = 'Bulan tidak valid';
        }
        $data = [
            'judul'     => 'Laporan Bisyaroh',
            'bisyaroh'  => $this->ModelLaporan->AllDataLaporanBisyaroh($bulan, $tahun),
            'bulan'     => $bulan_text,
            'tahun'     => $tahun,
            'jabatan'   => $jabatan,
            'nama'      => $nama,
            'user_name' => session()->get('nama'),
            'masjid'    => $this->ModelAdmin->ViewSetting(),
        ];
        $response = [
            'data' => view('admin/laporan/v_data_laporan_bisyaroh', $data),
        ];
        echo json_encode($response);
    }

    public function LaporanInventaris()
    {
        $tahunData = $this->ModelLaporan->getTahunInventaris();
        $tahunList = [];
        foreach ($tahunData as $tahun) {
            $tahunList[] = $tahun->tahun;
        }
        if (empty($tahunList)) {
            $tahunList[] = date('Y');
        }
        
        $data = [
            'judul'     => 'Laporan Inventaris',
            'menu'      => 'laporan',
            'submenu'   => 'laporan-inventaris',
            'page'      => 'admin/laporan/v_laporan_inventaris',
            'tahunList' => $tahunList,
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function ViewLaporanInventaris()
    {
        $tahun = $this->request->getPost('tahun') ?? date('Y');
        
        $data = [
            'judul'             => 'Laporan Inventaris',
            'inventaris_masuk'  => $this->ModelLaporan->AllDataLaporanInventarisMasukByYear($tahun),
            'inventaris_keluar' => $this->ModelLaporan->AllDataLaporanInventarisKeluarByYear($tahun),
            'tahun'             => $tahun,
            'user_name'         => session()->get('nama'),
            'masjid'            => $this->ModelAdmin->ViewSetting(),
        ];
        $response = [
            'data' => view('admin/laporan/v_data_laporan_inventaris', $data),
        ];
        echo json_encode($response);
    }
}
