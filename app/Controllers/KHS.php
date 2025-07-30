<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelKHS;
use App\Models\ModelKRS;
use App\Models\ModelMahasiswa;

class KHS extends BaseController
{
    protected $ModelKHS;
    protected $ModelKRS;
    protected $ModelMahasiswa;

    public function __construct()
    {
        $this->ModelKHS = new ModelKHS();
        $this->ModelKRS = new ModelKRS();
        $this->ModelMahasiswa = new ModelMahasiswa();
    }

    public function index()
    {
        $data = [
            'judul'     => 'Manajemen KHS',
            'menu'      => 'akademik',
            'submenu'   => 'khs',
            'page'      => 'admin/v_khs',
            'khs'       => $this->ModelKHS->AllData(),
            'mahasiswa' => $this->ModelMahasiswa->AllData(),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function InsertData()
    {
        if ($this->validate([
            'mahasiswa_id' => [
                'label' => 'Mahasiswa',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'matkul_id' => [
                'label' => 'Mata Kuliah',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'semester_aktif' => [
                'label' => 'Semester Aktif',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'tahun_akademik' => [
                'label' => 'Tahun Akademik',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'nilai_angka' => [
                'label' => 'Nilai Angka',
                'rules' => 'required|decimal|greater_than_equal_to[0]|less_than_equal_to[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'decimal' => '{field} harus berupa angka',
                    'greater_than_equal_to' => '{field} minimal 0',
                    'less_than_equal_to' => '{field} maksimal 100',
                ]
            ],
        ])) {
            $nilai_angka = $this->request->getPost('nilai_angka');
            $nilai_huruf = $this->convertToGrade($nilai_angka);
            $bobot = $this->convertToPoint($nilai_huruf);

            $data = [
                'mahasiswa_id' => esc($this->request->getPost('mahasiswa_id')),
                'matkul_id' => esc($this->request->getPost('matkul_id')),
                'semester_aktif' => esc($this->request->getPost('semester_aktif')),
                'tahun_akademik' => esc($this->request->getPost('tahun_akademik')),
                'nilai_angka' => $nilai_angka,
                'nilai_huruf' => $nilai_huruf,
                'bobot' => $bobot,
            ];
            $this->ModelKHS->InsertData($data);
            session()->setFlashdata('info', 'Data KHS berhasil ditambahkan!');
            return redirect()->to(base_url('KHS'));
        } else {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->to(base_url('KHS'))->withInput();
        }
    }

    public function Delete($id_khs)
    {
        $this->ModelKHS->DeleteData($id_khs);
        session()->setFlashdata('info', 'Data KHS berhasil dihapus!');
        return redirect()->to(base_url('KHS'));
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

    public function getKRSByMahasiswa()
    {
        $mahasiswa_id = $this->request->getPost('mahasiswa_id');
        $semester_aktif = $this->request->getPost('semester_aktif');
        $tahun_akademik = $this->request->getPost('tahun_akademik');
        
        $krs = $this->ModelKRS->getKRSByMahasiswa($mahasiswa_id, $semester_aktif, $tahun_akademik);
        return $this->response->setJSON($krs);
    }
}