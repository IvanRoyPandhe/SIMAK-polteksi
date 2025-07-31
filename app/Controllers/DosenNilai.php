<?php

namespace App\Controllers;

use App\Models\ModelMataKuliah;
use App\Models\ModelNilai;
use App\Models\ModelMahasiswa;
use App\Models\ModelKelas;
use App\Models\ModelUser;

class DosenNilai extends BaseController
{
    protected $ModelMataKuliah;
    protected $ModelNilai;
    protected $ModelMahasiswa;
    protected $ModelKelas;
    protected $user;

    public function __construct()
    {
        $this->ModelMataKuliah = new ModelMataKuliah();
        $this->ModelNilai = new ModelNilai();
        $this->ModelMahasiswa = new ModelMahasiswa();
        $this->ModelKelas = new ModelKelas();
        
        // Get user data from session
        $userModel = new ModelUser();
        $this->user = $userModel->find(session()->get('user_id'));
    }

    public function index()
    {
        // Get dosen_id from user email
        $db = \Config\Database::connect();
        $dosen = $db->table('tb_dosen')
                   ->where('email', $this->user['email'])
                   ->get()->getRowArray();
        
        if (!$dosen) {
            session()->setFlashdata('error', 'Data dosen tidak ditemukan');
            return redirect()->to('/Dashboard/Dosen');
        }

        $data = [
            'judul' => 'Mata Kuliah yang Diampu',
            'menu' => 'mata-kuliah',
            'submenu' => '',
            'page' => 'dosen/mata_kuliah/index',
            'mata_kuliah' => $this->ModelMataKuliah->getByDosen($dosen['id_dosen'])
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function nilai($matkul_id)
    {
        // Get dosen_id from user email
        $db = \Config\Database::connect();
        $dosen = $db->table('tb_dosen')
                   ->where('email', $this->user['email'])
                   ->get()->getRowArray();
        
        if (!$dosen) {
            session()->setFlashdata('error', 'Data dosen tidak ditemukan');
            return redirect()->to('/dosen/mata-kuliah');
        }

        $mata_kuliah = $this->ModelMataKuliah->find($matkul_id);
        
        if (!$mata_kuliah || $mata_kuliah['dosen_id'] != $dosen['id_dosen']) {
            session()->setFlashdata('error', 'Akses ditolak untuk mata kuliah ini');
            return redirect()->to('/dosen/mata-kuliah');
        }

        $data = [
            'judul' => 'Input Nilai - ' . $mata_kuliah['nama_matkul'],
            'menu' => 'mata-kuliah',
            'submenu' => '',
            'page' => 'dosen/nilai/index',
            'mata_kuliah' => $mata_kuliah,
            'mahasiswa' => $this->ModelNilai->getMahasiswaByMatkul($matkul_id)
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function updateNilai()
    {
        $matkul_id = $this->request->getPost('matkul_id');
        $mahasiswa_id = $this->request->getPost('mahasiswa_id');
        $nilai_tugas = floatval($this->request->getPost('nilai_tugas'));
        $nilai_uts = floatval($this->request->getPost('nilai_uts'));
        $nilai_uas = floatval($this->request->getPost('nilai_uas'));

        // Hitung nilai akhir (30% tugas, 30% UTS, 40% UAS)
        $nilai_akhir = ($nilai_tugas * 0.3) + ($nilai_uts * 0.3) + ($nilai_uas * 0.4);
        
        // Konversi ke huruf dan bobot
        $nilai_huruf = $this->getNilaiHuruf($nilai_akhir);
        $bobot = $this->getBobot($nilai_huruf);

        $data = [
            'mahasiswa_id' => $mahasiswa_id,
            'matkul_id' => $matkul_id,
            'kelas_id' => 1, // Default, bisa disesuaikan
            'periode_id' => 1, // Default, bisa disesuaikan
            'nilai_tugas' => $nilai_tugas,
            'nilai_uts' => $nilai_uts,
            'nilai_uas' => $nilai_uas,
            'nilai_akhir' => round($nilai_akhir, 2),
            'nilai_huruf' => $nilai_huruf,
            'bobot' => $bobot,
            'status' => 'Draft',
            'created_by' => session()->get('user_id')
        ];

        try {
            // Check if nilai already exists
            $existing = $this->ModelNilai->where([
                'mahasiswa_id' => $mahasiswa_id,
                'matkul_id' => $matkul_id
            ])->first();

            if ($existing) {
                $this->ModelNilai->update($existing['id_nilai'], $data);
                $message = 'Nilai berhasil diupdate';
            } else {
                $this->ModelNilai->insert($data);
                $message = 'Nilai berhasil disimpan';
            }

            return $this->response->setJSON([
                'status' => 'success', 
                'message' => $message,
                'nilai_akhir' => round($nilai_akhir, 2),
                'nilai_huruf' => $nilai_huruf
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'Gagal menyimpan nilai: ' . $e->getMessage()
            ]);
        }
    }

    public function finalisasiNilai()
    {
        $matkul_id = $this->request->getPost('matkul_id');
        
        try {
            $this->ModelNilai->where('matkul_id', $matkul_id)
                            ->set('status', 'Final')
                            ->update();
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Nilai berhasil difinalisasi'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal finalisasi nilai: ' . $e->getMessage()
            ]);
        }
    }

    private function getNilaiHuruf($nilai)
    {
        if ($nilai >= 85) return 'A';
        if ($nilai >= 80) return 'A-';
        if ($nilai >= 75) return 'B+';
        if ($nilai >= 70) return 'B';
        if ($nilai >= 65) return 'B-';
        if ($nilai >= 60) return 'C+';
        if ($nilai >= 55) return 'C';
        if ($nilai >= 50) return 'C-';
        if ($nilai >= 45) return 'D';
        return 'E';
    }

    private function getBobot($huruf)
    {
        $bobot = [
            'A' => 4.00, 'A-' => 3.70, 'B+' => 3.30, 'B' => 3.00,
            'B-' => 2.70, 'C+' => 2.30, 'C' => 2.00, 'C-' => 1.70,
            'D' => 1.00, 'E' => 0.00
        ];
        return $bobot[$huruf] ?? 0.00;
    }
}