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
        // Redirect mahasiswa ke dashboard mereka
        if (session()->get('level') == 4) {
            return redirect()->to(base_url('Dashboard/Mahasiswa'));
        }
        
        // Redirect petugas ke dashboard mereka
        if (session()->get('level') == 3) {
            return redirect()->to(base_url('Dashboard/Petugas'));
        }
        
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
            'judul'             => 'Dashboard Admin SIMAK',
            'menu'              => 'dashboard',
            'submenu'           => '',
            'page'              => 'admin/v_dashboard_enhanced',
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
            'stats'             => $this->getDashboardStats(),
            'recent_activities' => $this->getRecentActivities(),
            'financial_summary' => $this->getFinancialSummary(),
            'academic_overview' => $this->getAcademicOverview(),
            'system_health' => $this->getSystemHealth(),
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
        $setting = $this->ModelAdmin->ViewSetting();
        $id_lokasi = $setting['id_lokasi'] ?? '1418';
        $pilih_lokasi = '';
        foreach ($lokasi as $isi_lokasi) {
            if ($isi_lokasi['id'] == $id_lokasi) {
                $pilih_lokasi = $isi_lokasi['lokasi'];
                break;
            }
        }
        $data = [
            'judul'         => 'Pengaturan Kampus',
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
            'nama_kampus' => [
                'label' => 'Nama Kampus',
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
            'alamat_kampus' => [
                'label' => 'Alamat Kampus',
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
            'fasilitas' => [
                'label' => 'Fasilitas',
                'rules' => 'permit_empty',
            ],
        ])) {
            $data = [
                'id_set'        => 1,
                'nama_kampus'   => $this->request->getPost('nama_kampus'),
                'alamat_kampus' => $this->request->getPost('alamat_kampus'),
                'keterangan'    => $keterangan,
                'fasilitas'     => $this->request->getPost('fasilitas'),
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

    private function getDashboardStats()
    {
        $db = \Config\Database::connect();
        
        // Basic counts
        $total_mahasiswa = $db->table('tb_mahasiswa')->where('status', 'Aktif')->countAllResults();
        $total_dosen = $db->table('tb_dosen')->where('status', 'Aktif')->countAllResults();
        $total_prodi = $db->table('tb_prodi')->countAllResults();
        $total_matkul = $db->table('tb_mata_kuliah')->countAllResults();
        
        // Periode aktif
        $periode_aktif = $db->table('tb_periode_akademik')
            ->where('is_active', 1)
            ->get()->getRowArray();
            
        // KRS statistics
        $krs_pending = $db->table('tb_krs')
            ->where('status', 'Menunggu Persetujuan')
            ->countAllResults();
        $krs_disetujui = $db->table('tb_krs')
            ->where('status', 'Disetujui')
            ->countAllResults();
        $krs_ditolak = $db->table('tb_krs')
            ->where('status', 'Ditolak')
            ->countAllResults();
            
        // Academic data
        $total_kelas = $db->table('tb_kelas')
            ->where('periode_id', $periode_aktif['id_periode'] ?? 1)
            ->countAllResults();
        $total_beasiswa = $db->table('tb_beasiswa')
            ->where('status', 'Aktif')
            ->countAllResults();
        $total_inventaris = $db->table('tb_inventaris')
            ->where('status', 'Baik')
            ->countAllResults();
        $total_pengaduan = $db->table('tb_pengaduan')
            ->where('status', 'Pending')
            ->countAllResults();
        $total_artikel = $db->table('tb_artikel')
            ->where('status', 'Published')
            ->countAllResults();
        $total_kegiatan = $db->table('tb_kegiatan')
            ->where('status', 'Aktif')
            ->countAllResults();
            
        // Financial quick stats
        $currentMonth = date('Y-m');
        $pemasukan_hari_ini = $db->table('tb_keuangan_internal')
            ->selectSum('dana_masuk')
            ->where('DATE(tgl)', date('Y-m-d'))
            ->get()->getRowArray()['dana_masuk'] ?? 0;
        $pengeluaran_hari_ini = $db->table('tb_keuangan_internal')
            ->selectSum('dana_keluar')
            ->where('DATE(tgl)', date('Y-m-d'))
            ->get()->getRowArray()['dana_keluar'] ?? 0;
            
        return [
            'total_mahasiswa' => $total_mahasiswa,
            'total_dosen' => $total_dosen,
            'total_prodi' => $total_prodi,
            'total_matkul' => $total_matkul,
            'krs_pending' => $krs_pending,
            'krs_disetujui' => $krs_disetujui,
            'krs_ditolak' => $krs_ditolak,
            'total_kelas' => $total_kelas,
            'total_beasiswa' => $total_beasiswa,
            'total_inventaris' => $total_inventaris,
            'total_pengaduan' => $total_pengaduan,
            'total_artikel' => $total_artikel,
            'total_kegiatan' => $total_kegiatan,
            'pemasukan_hari_ini' => $pemasukan_hari_ini,
            'pengeluaran_hari_ini' => $pengeluaran_hari_ini,
            'periode_aktif' => $periode_aktif
        ];
    }

    private function getRecentActivities()
    {
        $db = \Config\Database::connect();
        
        $activities = [];
        
        // Recent KRS submissions
        $recent_krs = $db->table('tb_krs')
            ->join('tb_mahasiswa', 'tb_mahasiswa.id_mahasiswa = tb_krs.mahasiswa_id')
            ->select('tb_krs.tgl_pengajuan, tb_mahasiswa.nama, tb_krs.status')
            ->orderBy('tb_krs.tgl_pengajuan', 'DESC')
            ->limit(5)
            ->get()->getResultArray();
            
        foreach ($recent_krs as $krs) {
            $activities[] = [
                'type' => 'KRS',
                'message' => $krs['nama'] . ' mengajukan KRS',
                'time' => $krs['tgl_pengajuan'],
                'status' => $krs['status'],
                'icon' => 'fas fa-file-alt',
                'color' => $krs['status'] == 'Disetujui' ? 'success' : 'warning'
            ];
        }
        
        // Recent financial transactions
        $recent_finance = $db->table('tb_keuangan_internal')
            ->select('tgl, keterangan, dana_masuk, dana_keluar')
            ->orderBy('tgl', 'DESC')
            ->limit(3)
            ->get()->getResultArray();
            
        foreach ($recent_finance as $finance) {
            $activities[] = [
                'type' => 'Finance',
                'message' => $finance['keterangan'],
                'time' => $finance['tgl'],
                'amount' => $finance['dana_masuk'] > 0 ? $finance['dana_masuk'] : $finance['dana_keluar'],
                'is_income' => $finance['dana_masuk'] > 0,
                'icon' => 'fas fa-money-bill-wave',
                'color' => $finance['dana_masuk'] > 0 ? 'success' : 'danger'
            ];
        }
        
        // Sort by time
        usort($activities, function($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });
        
        return array_slice($activities, 0, 8);
    }

    private function getFinancialSummary()
    {
        $db = \Config\Database::connect();
        $currentMonth = date('Y-m');
        
        $pemasukan = $db->table('tb_keuangan_internal')
            ->selectSum('dana_masuk')
            ->where('DATE_FORMAT(tgl, "%Y-%m")', $currentMonth)
            ->get()->getRowArray()['dana_masuk'] ?? 0;
            
        $pengeluaran = $db->table('tb_keuangan_internal')
            ->selectSum('dana_keluar')
            ->where('DATE_FORMAT(tgl, "%Y-%m")', $currentMonth)
            ->get()->getRowArray()['dana_keluar'] ?? 0;
            
        $saldo_bank = $db->table('tb_rekening_bank')
            ->selectSum('saldo_akhir')
            ->where('is_active', 1)
            ->get()->getRowArray()['saldo_akhir'] ?? 0;
            
        return [
            'pemasukan_bulan_ini' => $pemasukan,
            'pengeluaran_bulan_ini' => $pengeluaran,
            'saldo_bersih' => $pemasukan - $pengeluaran,
            'total_saldo_bank' => $saldo_bank
        ];
    }

    private function getAcademicOverview()
    {
        $db = \Config\Database::connect();
        
        // Mahasiswa per prodi
        $mahasiswa_per_prodi = $db->table('tb_mahasiswa')
            ->join('tb_prodi', 'tb_prodi.id_prodi = tb_mahasiswa.prodi_id')
            ->select('tb_prodi.nama_prodi, COUNT(tb_mahasiswa.id_mahasiswa) as jumlah')
            ->groupBy('tb_prodi.id_prodi')
            ->get()->getResultArray();
            
        // Dosen per prodi
        $dosen_per_prodi = $db->table('tb_dosen')
            ->join('tb_prodi', 'tb_prodi.id_prodi = tb_dosen.prodi_id')
            ->select('tb_prodi.nama_prodi, COUNT(tb_dosen.id_dosen) as jumlah')
            ->groupBy('tb_prodi.id_prodi')
            ->get()->getResultArray();
            
        // KRS statistics
        $krs_stats = $db->table('tb_krs')
            ->select('status, COUNT(*) as jumlah')
            ->groupBy('status')
            ->get()->getResultArray();
            
        return [
            'mahasiswa_per_prodi' => $mahasiswa_per_prodi,
            'dosen_per_prodi' => $dosen_per_prodi,
            'krs_stats' => $krs_stats
        ];
    }

    private function getSystemHealth()
    {
        $db = \Config\Database::connect();
        
        // Database size (real)
        $db_size = $db->query("SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 1) AS 'db_size' FROM information_schema.tables WHERE table_schema = DATABASE()")
            ->getRowArray()['db_size'] ?? 0;
            
        // Total users in system
        $total_users = $db->table('tb_users')->countAllResults();
            
        // Total tables in database
        $total_tables = $db->query("SELECT COUNT(*) as total FROM information_schema.tables WHERE table_schema = DATABASE()")
            ->getRowArray()['total'] ?? 0;
        
        // Total records across main tables
        $total_records = $db->table('tb_mahasiswa')->countAllResults() + 
                        $db->table('tb_dosen')->countAllResults() + 
                        $db->table('tb_keuangan_internal')->countAllResults() + 
                        $db->table('tb_krs')->countAllResults();
        
        // System status based on data
        $system_status = 'Optimal';
        if ($db_size > 100) $system_status = 'Warning';
        if ($db_size > 500) $system_status = 'Critical';
        
        return [
            'db_size' => $db_size,
            'total_users' => $total_users,
            'total_tables' => $total_tables,
            'total_records' => $total_records,
            'system_status' => $system_status
        ];
    }
}
