<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\ModelKRS;
use App\Models\ModelKHS;
use App\Models\ModelMahasiswa;

class Dosen extends BaseController
{
    protected $ModelKRS;
    protected $ModelKHS;
    protected $ModelMahasiswa;

    public function __construct()
    {
        $this->ModelKRS = new ModelKRS();
        $this->ModelKHS = new ModelKHS();
        $this->ModelMahasiswa = new ModelMahasiswa();
    }

    public function index()
    {
        $dosen_id = session()->get('user_id');
        $data = [
            'judul'     => 'Dashboard Dosen',
            'menu'      => 'dashboard',
            'submenu'   => '',
            'page'      => 'dosen/v_dashboard_dosen',
            'stats'     => $this->getDosenStats($dosen_id),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function JadwalMengajar()
    {
        $dosen_id = session()->get('user_id');
        $data = [
            'judul'     => 'Jadwal Mengajar',
            'menu'      => 'jadwal',
            'submenu'   => '',
            'page'      => 'dosen/v_jadwal_mengajar',
            'jadwal'    => $this->getJadwalMengajar($dosen_id),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function MataKuliahDiampu()
    {
        $dosen_id = session()->get('dosen_id') ?? 1;
        $data = [
            'judul'     => 'Mata Kuliah Diampu',
            'menu'      => 'mata-kuliah-diampu',
            'submenu'   => '',
            'page'      => 'dosen/v_mata_kuliah_diampu',
            'matkul'    => $this->ModelKHS->getKelasByDosen($dosen_id),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function MahasiswaBimbingan()
    {
        $dosen_id = session()->get('dosen_id') ?? 1;
        $data = [
            'judul'     => 'Mahasiswa Bimbingan',
            'menu'      => 'mahasiswa-bimbingan',
            'submenu'   => '',
            'page'      => 'dosen/v_mahasiswa_bimbingan',
            'mahasiswa' => $this->getMahasiswaBimbingan($dosen_id),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function RekapNilai()
    {
        $dosen_id = session()->get('dosen_id') ?? 1;
        $data = [
            'judul'     => 'Rekap Nilai',
            'menu'      => 'rekap-nilai',
            'submenu'   => '',
            'page'      => 'dosen/v_rekap_nilai',
            'rekap'     => $this->getRekapNilai($dosen_id),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function Absensi()
    {
        $dosen_id = session()->get('dosen_id') ?? 1;
        $data = [
            'judul'     => 'Absensi Mahasiswa',
            'menu'      => 'absensi',
            'submenu'   => '',
            'page'      => 'dosen/v_absensi',
            'kelas'     => $this->ModelKHS->getKelasByDosen($dosen_id),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function MateriKuliah()
    {
        $dosen_id = session()->get('dosen_id') ?? 1;
        $data = [
            'judul'     => 'Materi Kuliah',
            'menu'      => 'materi-kuliah',
            'submenu'   => '',
            'page'      => 'dosen/v_materi_kuliah',
            'materi'    => $this->getMateriKuliah($dosen_id),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function Tugas()
    {
        $dosen_id = session()->get('dosen_id') ?? 1;
        $data = [
            'judul'     => 'Tugas & Quiz',
            'menu'      => 'tugas',
            'submenu'   => '',
            'page'      => 'dosen/v_tugas',
            'tugas'     => $this->getTugasByDosen($dosen_id),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function Konsultasi()
    {
        $dosen_id = session()->get('dosen_id') ?? 1;
        $data = [
            'judul'     => 'Konsultasi Online',
            'menu'      => 'konsultasi',
            'submenu'   => '',
            'page'      => 'dosen/v_konsultasi',
            'konsultasi' => $this->getKonsultasi($dosen_id),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function BimbinganAkademik()
    {
        $dosen_id = session()->get('user_id');
        $data = [
            'judul'     => 'Bimbingan Akademik',
            'menu'      => 'bimbingan',
            'submenu'   => '',
            'page'      => 'dosen/v_bimbingan_akademik',
            'mahasiswa_bimbingan' => $this->getMahasiswaBimbingan($dosen_id),
            'krs_list'  => $this->ModelKRS->getKRSForApproval($dosen_id),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function ApproveKRS($id_krs)
    {
        $catatan = $this->request->getPost('catatan');
        $this->ModelKRS->approveKRS($id_krs, 'Disetujui', $catatan);
        session()->setFlashdata('info', 'KRS berhasil disetujui!');
        return redirect()->to(base_url('Dashboard/Dosen/ApprovalKRS'));
    }

    public function RejectKRS($id_krs)
    {
        $catatan = $this->request->getPost('catatan');
        $this->ModelKRS->approveKRS($id_krs, 'Ditolak', $catatan);
        session()->setFlashdata('info', 'KRS berhasil ditolak!');
        return redirect()->to(base_url('Dashboard/Dosen/ApprovalKRS'));
    }

    public function InputNilai()
    {
        $dosen_id = session()->get('user_id');
        $data = [
            'judul'     => 'Input Nilai',
            'menu'      => 'nilai',
            'submenu'   => '',
            'page'      => 'dosen/v_input_nilai',
            'kelas'     => $this->getKelasDosen($dosen_id),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function SaveNilai()
    {
        $nilai_data = $this->request->getPost('nilai');
        foreach ($nilai_data as $mahasiswa_id => $nilai) {
            if (!empty($nilai['nilai_angka'])) {
                $data = [
                    'mahasiswa_id' => $mahasiswa_id,
                    'matkul_id' => $this->request->getPost('matkul_id'),
                    'semester_aktif' => $this->request->getPost('semester_aktif'),
                    'tahun_akademik' => $this->request->getPost('tahun_akademik'),
                    'nilai_angka' => $nilai['nilai_angka'],
                    'nilai_huruf' => $this->convertToGrade($nilai['nilai_angka']),
                    'bobot' => $this->convertToPoint($this->convertToGrade($nilai['nilai_angka'])),
                ];
                $this->ModelKHS->saveOrUpdateNilai($data);
            }
        }
        session()->setFlashdata('info', 'Nilai berhasil disimpan!');
        return redirect()->to(base_url('Dashboard/Dosen/InputNilai'));
    }

    private function convertToGrade($nilai_angka)
    {
        if ($nilai_angka >= 85) return 'A';
        if ($nilai_angka >= 80) return 'A-';
        if ($nilai_angka >= 75) return 'B+';
        if ($nilai_angka >= 70) return 'B';
        if ($nilai_angka >= 65) return 'B-';
        if ($nilai_angka >= 60) return 'C+';
        if ($nilai_angka >= 55) return 'C';
        if ($nilai_angka >= 50) return 'C-';
        if ($nilai_angka >= 45) return 'D+';
        if ($nilai_angka >= 40) return 'D';
        return 'E';
    }

    private function convertToPoint($nilai_huruf)
    {
        $points = [
            'A' => 4.00, 'A-' => 3.70, 'B+' => 3.30, 'B' => 3.00, 'B-' => 2.70,
            'C+' => 2.30, 'C' => 2.00, 'C-' => 1.70, 'D+' => 1.30, 'D' => 1.00, 'E' => 0.00
        ];
        return $points[$nilai_huruf] ?? 0.00;
    }

    private function getDosenStats($dosen_id)
    {
        $db = \Config\Database::connect();
        
        $total_kelas = $db->table('tb_kelas')
            ->where('dosen_id', $dosen_id)
            ->countAllResults();
            
        $total_mahasiswa = $db->table('tb_kelas')
            ->join('tb_krs', 'tb_krs.kelas_id = tb_kelas.id_kelas')
            ->where('tb_kelas.dosen_id', $dosen_id)
            ->where('tb_krs.status', 'Disetujui')
            ->countAllResults();
            
        $mahasiswa_bimbingan = $db->table('tb_mahasiswa')
            ->where('dosen_pa_id', $dosen_id)
            ->countAllResults();
            
        $nilai_pending = $db->table('tb_nilai')
            ->join('tb_kelas', 'tb_kelas.id_kelas = tb_nilai.kelas_id')
            ->where('tb_kelas.dosen_id', $dosen_id)
            ->where('tb_nilai.status', 'Draft')
            ->countAllResults();
            
        return [
            'total_kelas' => $total_kelas,
            'total_mahasiswa' => $total_mahasiswa,
            'mahasiswa_bimbingan' => $mahasiswa_bimbingan,
            'nilai_pending' => $nilai_pending
        ];
    }

    private function getJadwalMengajar($dosen_id)
    {
        $db = \Config\Database::connect();
        
        return $db->table('tb_kelas')
            ->join('tb_mata_kuliah', 'tb_mata_kuliah.id_matkul = tb_kelas.matkul_id')
            ->join('tb_periode_akademik', 'tb_periode_akademik.id_periode = tb_kelas.periode_id')
            ->select('tb_kelas.*, tb_mata_kuliah.kode_matkul, tb_mata_kuliah.nama_matkul, tb_mata_kuliah.sks, tb_periode_akademik.semester, tb_periode_akademik.tahun_akademik')
            ->where('tb_kelas.dosen_id', $dosen_id)
            ->where('tb_periode_akademik.is_active', 1)
            ->get()->getResultArray();
    }

    private function getKelasDosen($dosen_id)
    {
        $db = \Config\Database::connect();
        
        return $db->table('tb_kelas')
            ->join('tb_mata_kuliah', 'tb_mata_kuliah.id_matkul = tb_kelas.matkul_id')
            ->select('tb_kelas.*, tb_mata_kuliah.kode_matkul, tb_mata_kuliah.nama_matkul')
            ->where('tb_kelas.dosen_id', $dosen_id)
            ->get()->getResultArray();
    }

    private function getMahasiswaBimbingan($dosen_id)
    {
        $db = \Config\Database::connect();
        return $db->table('tb_mahasiswa')
            ->join('tb_prodi', 'tb_prodi.id_prodi = tb_mahasiswa.prodi_id')
            ->select('tb_mahasiswa.*, tb_prodi.nama_prodi')
            ->where('tb_mahasiswa.dosen_pa_id', $dosen_id)
            ->get()->getResultArray();
    }

    private function getRekapNilai($dosen_id)
    {
        $db = \Config\Database::connect();
        return $db->table('tb_khs')
            ->join('tb_mata_kuliah', 'tb_mata_kuliah.id_matkul = tb_khs.matkul_id')
            ->join('tb_kelas', 'tb_kelas.matkul_id = tb_mata_kuliah.id_matkul')
            ->join('tb_mahasiswa', 'tb_mahasiswa.id_mahasiswa = tb_khs.mahasiswa_id')
            ->select('tb_khs.*, tb_mata_kuliah.nama_matkul, tb_mahasiswa.nama, tb_mahasiswa.nim')
            ->where('tb_kelas.dosen_id', $dosen_id)
            ->orderBy('tb_mata_kuliah.nama_matkul')
            ->get()->getResultArray();
    }

    private function getMateriKuliah($dosen_id)
    {
        $db = \Config\Database::connect();
        return $db->table('tb_materi_kuliah')
            ->join('tb_kelas', 'tb_kelas.id_kelas = tb_materi_kuliah.kelas_id')
            ->join('tb_mata_kuliah', 'tb_mata_kuliah.id_matkul = tb_kelas.matkul_id')
            ->select('tb_materi_kuliah.*, tb_mata_kuliah.nama_matkul')
            ->where('tb_kelas.dosen_id', $dosen_id)
            ->orderBy('tb_materi_kuliah.tanggal_upload', 'DESC')
            ->get()->getResultArray();
    }

    private function getTugasByDosen($dosen_id)
    {
        $db = \Config\Database::connect();
        return $db->table('tb_tugas')
            ->join('tb_kelas', 'tb_kelas.id_kelas = tb_tugas.kelas_id')
            ->join('tb_mata_kuliah', 'tb_mata_kuliah.id_matkul = tb_kelas.matkul_id')
            ->select('tb_tugas.*, tb_mata_kuliah.nama_matkul')
            ->where('tb_kelas.dosen_id', $dosen_id)
            ->orderBy('tb_tugas.deadline', 'DESC')
            ->get()->getResultArray();
    }

    private function getKonsultasi($dosen_id)
    {
        $db = \Config\Database::connect();
        return $db->table('tb_konsultasi')
            ->join('tb_mahasiswa', 'tb_mahasiswa.id_mahasiswa = tb_konsultasi.mahasiswa_id')
            ->select('tb_konsultasi.*, tb_mahasiswa.nama, tb_mahasiswa.nim')
            ->where('tb_konsultasi.dosen_id', $dosen_id)
            ->orderBy('tb_konsultasi.tanggal_konsultasi', 'DESC')
            ->get()->getResultArray();
    }
}