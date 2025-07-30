<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMahasiswa;
use App\Models\ModelNilai;
use App\Models\ModelMataKuliah;
use App\Models\ModelPeriodeAkademik;

class Dashboard extends BaseController
{
    protected $ModelMahasiswa;
    protected $ModelNilai;
    protected $ModelMataKuliah;
    protected $ModelPeriodeAkademik;

    public function __construct()
    {
        $this->ModelMahasiswa = new ModelMahasiswa();
        $this->ModelNilai = new ModelNilai();
        $this->ModelMataKuliah = new ModelMataKuliah();
        $this->ModelPeriodeAkademik = new ModelPeriodeAkademik();
    }

    public function Mahasiswa()
    {
        $data = [
            'judul' => 'Dashboard Mahasiswa',
            'menu' => 'dashboard',
            'submenu' => '',
            'page' => 'mahasiswa/v_dashboard_mahasiswa',
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function ProfileMahasiswa()
    {
        $mahasiswa = $this->ModelMahasiswa->getBiodataWithAkademik(session()->get('user_id'));
        
        $data = [
            'judul' => 'My Profile',
            'menu' => 'profile',
            'submenu' => '',
            'page' => 'mahasiswa/v_profile_mahasiswa',
            'mahasiswa' => $mahasiswa,
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function LaporanNilai()
    {
        $nilai = $this->ModelNilai->getNilaiByMahasiswa(session()->get('user_id'));
        
        $data = [
            'judul' => 'Laporan Nilai',
            'menu' => 'nilai',
            'submenu' => 'laporan-nilai',
            'page' => 'mahasiswa/v_laporan_nilai',
            'nilai' => $nilai,
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function TranskripNilai()
    {
        $mahasiswa = $this->ModelMahasiswa->getBiodataWithAkademik(session()->get('user_id'));
        $nilai = $this->ModelNilai->getNilaiByMahasiswa(session()->get('user_id'));
        
        $data = [
            'judul' => 'Transkrip Nilai',
            'menu' => 'nilai',
            'submenu' => 'transkrip-nilai',
            'page' => 'mahasiswa/v_transkrip_mahasiswa',
            'mahasiswa' => $mahasiswa,
            'nilai' => $nilai,
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function KRS()
    {
        $mahasiswa = $this->ModelMahasiswa->getBiodataWithAkademik(session()->get('user_id'));
        $matkul_tersedia = $this->ModelMataKuliah->getMatkulForKRS($mahasiswa['prodi_id'], $mahasiswa['semester_aktif']);
        
        // Get existing KRS
        $db = \Config\Database::connect();
        $krs_existing = $db->table('tb_krs')
            ->join('tb_mata_kuliah', 'tb_mata_kuliah.id_matkul = tb_krs.mata_kuliah_id')
            ->select('tb_krs.*, tb_mata_kuliah.kode_matkul, tb_mata_kuliah.nama_matkul, tb_mata_kuliah.sks')
            ->where('tb_krs.mahasiswa_id', session()->get('user_id'))
            ->where('tb_krs.status !=', 'Ditolak')
            ->get()->getResultArray();
            
        // Get periode aktif dan validasi SKS
        $periode_aktif_data = $this->ModelPeriodeAkademik->getPeriodeAktif();
        
        // Determine max SKS based on IPK and periode setting
        $max_sks_periode = $periode_aktif_data['max_sks'] ?? 24;
        $max_sks_ipk = 24;
        
        if ($mahasiswa['ipk'] < 2.0) $max_sks_ipk = 18;
        elseif ($mahasiswa['ipk'] < 2.5) $max_sks_ipk = 20;
        elseif ($mahasiswa['ipk'] < 3.5) $max_sks_ipk = 22;
        elseif ($mahasiswa['ipk'] >= 3.5) $max_sks_ipk = 24;
        
        $max_sks = min($max_sks_periode, $max_sks_ipk);
        
        $status_krs = !empty($krs_existing) ? $krs_existing[0]['status'] : 'Draft';
        
        $data = [
            'judul' => 'Kartu Rencana Studi (KRS)',
            'menu' => 'krs-mahasiswa',
            'submenu' => '',
            'page' => 'mahasiswa/v_krs_mahasiswa',
            'mahasiswa' => $mahasiswa,
            'matkul_tersedia' => $matkul_tersedia,
            'krs_existing' => $krs_existing,
            'max_sks' => $max_sks,
            'max_sks_periode' => $max_sks_periode,
            'max_sks_ipk' => $max_sks_ipk,
            'periode_aktif_data' => $periode_aktif_data,
            'status_krs' => $status_krs,
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function SubmitKRS()
    {
        $mahasiswa_id = session()->get('user_id');
        $matkul_selected = $this->request->getPost('matkul') ?? [];
        
        if (empty($matkul_selected)) {
            session()->setFlashdata('error', 'Pilih minimal 1 mata kuliah!');
            return redirect()->to(base_url('Dashboard/KRS'));
        }
        
        $db = \Config\Database::connect();
        
        // Delete existing KRS
        $db->table('tb_krs')->where('mahasiswa_id', $mahasiswa_id)->delete();
        
        // Insert new KRS
        foreach ($matkul_selected as $matkul_id) {
            $db->table('tb_krs')->insert([
                'mahasiswa_id' => $mahasiswa_id,
                'mata_kuliah_id' => $matkul_id,
                'kelas_id' => 1, // Default kelas
                'periode_id' => 1, // Current period
                'status' => 'Menunggu Persetujuan',
                'tgl_pengajuan' => date('Y-m-d H:i:s')
            ]);
        }
        
        session()->setFlashdata('info', 'KRS berhasil disubmit dan menunggu persetujuan!');
        return redirect()->to(base_url('Dashboard/KRS'));
    }

    public function KHS()
    {
        $mahasiswa = $this->ModelMahasiswa->getBiodataWithAkademik(session()->get('user_id'));
        $nilai = $this->ModelNilai->getNilaiByMahasiswa(session()->get('user_id'));
        
        $data = [
            'judul' => 'Kartu Hasil Studi (KHS)',
            'menu' => 'khs-mahasiswa',
            'submenu' => '',
            'page' => 'mahasiswa/v_khs_mahasiswa',
            'mahasiswa' => $mahasiswa,
            'nilai' => $nilai,
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function UpdateProfile()
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'tempat_lahir' => 'permit_empty|max_length[100]',
            'tanggal_lahir' => 'permit_empty|valid_date',
            'jenis_kelamin' => 'permit_empty|in_list[Laki-laki,Perempuan]',
            'agama' => 'permit_empty|max_length[20]',
            'alamat' => 'permit_empty',
            'no_hp' => 'permit_empty|max_length[15]',
            'nama_ayah' => 'permit_empty|max_length[100]',
            'nama_ibu' => 'permit_empty|max_length[100]',
            'pekerjaan_ayah' => 'permit_empty|max_length[50]',
            'pekerjaan_ibu' => 'permit_empty|max_length[50]',
            'no_hp_ortu' => 'permit_empty|max_length[15]',
            'foto' => 'permit_empty|uploaded[foto]|max_size[foto,2048]|is_image[foto]',
        ])) {
            $data = [
                'tempat_lahir' => $this->request->getPost('tempat_lahir'),
                'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                'agama' => $this->request->getPost('agama'),
                'alamat' => $this->request->getPost('alamat'),
                'no_hp' => $this->request->getPost('no_hp'),
                'nama_ayah' => $this->request->getPost('nama_ayah'),
                'nama_ibu' => $this->request->getPost('nama_ibu'),
                'pekerjaan_ayah' => $this->request->getPost('pekerjaan_ayah'),
                'pekerjaan_ibu' => $this->request->getPost('pekerjaan_ibu'),
                'no_hp_ortu' => $this->request->getPost('no_hp_ortu'),
            ];
            
            // Handle foto upload
            $foto = $this->request->getFile('foto');
            if ($foto && $foto->isValid() && !$foto->hasMoved()) {
                $newName = $foto->getRandomName();
                $foto->move('uploaded/mahasiswa/', $newName);
                $data['foto'] = $newName;
            }
            
            $this->ModelMahasiswa->updateBiodata(session()->get('user_id'), $data);
            session()->setFlashdata('info', 'Profile berhasil diupdate!');
            return redirect()->to(base_url('Dashboard/ProfileMahasiswa'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Dashboard/ProfileMahasiswa'))->withInput();
        }
    }
}