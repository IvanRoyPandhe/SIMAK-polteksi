<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelNilai;
use App\Models\ModelMahasiswa;
use App\Models\ModelMataKuliah;
use App\Models\ModelPeriodeAkademik;

class Nilai extends BaseController
{
    protected $ModelNilai;
    protected $ModelMahasiswa;
    protected $ModelMataKuliah;
    protected $ModelPeriodeAkademik;

    public function __construct()
    {
        $this->ModelNilai = new ModelNilai();
        $this->ModelMahasiswa = new ModelMahasiswa();
        $this->ModelMataKuliah = new ModelMataKuliah();
        $this->ModelPeriodeAkademik = new ModelPeriodeAkademik();
    }

    public function index()
    {
        $data = [
            'judul'     => 'Manajemen Nilai',
            'menu'      => 'akademik',
            'submenu'   => 'nilai',
            'page'      => 'admin/nilai/v_nilai',
            'nilai'     => $this->ModelNilai->getAllNilaiWithDetails(),
            'mahasiswa' => $this->ModelMahasiswa->AllData(),
            'matkul'    => $this->ModelMataKuliah->AllData(),
            'periode'   => $this->ModelPeriodeAkademik->AllData(),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function Insert()
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'mahasiswa_id' => 'required|integer',
            'matkul_id' => 'required|integer',
            'periode_id' => 'required|integer',
            'nilai_tugas' => 'required|decimal|greater_than_equal_to[0]|less_than_equal_to[100]',
            'nilai_uts' => 'required|decimal|greater_than_equal_to[0]|less_than_equal_to[100]',
            'nilai_uas' => 'required|decimal|greater_than_equal_to[0]|less_than_equal_to[100]',
        ])) {
            $nilai_tugas = $this->request->getPost('nilai_tugas');
            $nilai_uts = $this->request->getPost('nilai_uts');
            $nilai_uas = $this->request->getPost('nilai_uas');
            
            $nilai_akhir = $this->ModelNilai->hitungNilaiAkhir($nilai_tugas, $nilai_uts, $nilai_uas);
            $konversi = $this->ModelNilai->konversiNilaiHuruf($nilai_akhir);

            $data = [
                'mahasiswa_id' => $this->request->getPost('mahasiswa_id'),
                'matkul_id' => $this->request->getPost('matkul_id'),
                'kelas_id' => 1, // Default kelas
                'periode_id' => $this->request->getPost('periode_id'),
                'nilai_tugas' => $nilai_tugas,
                'nilai_uts' => $nilai_uts,
                'nilai_uas' => $nilai_uas,
                'nilai_akhir' => $nilai_akhir,
                'nilai_huruf' => $konversi['huruf'],
                'bobot' => $konversi['bobot'],
                'status' => 'Draft',
            ];

            $this->ModelNilai->InsertData($data);
            session()->setFlashdata('info', 'Nilai berhasil ditambahkan!');
            return redirect()->to(base_url('Nilai'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Nilai'))->withInput();
        }
    }

    public function Update($id_nilai)
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'nilai_tugas' => 'required|decimal|greater_than_equal_to[0]|less_than_equal_to[100]',
            'nilai_uts' => 'required|decimal|greater_than_equal_to[0]|less_than_equal_to[100]',
            'nilai_uas' => 'required|decimal|greater_than_equal_to[0]|less_than_equal_to[100]',
        ])) {
            $nilai_tugas = $this->request->getPost('nilai_tugas');
            $nilai_uts = $this->request->getPost('nilai_uts');
            $nilai_uas = $this->request->getPost('nilai_uas');
            
            $nilai_akhir = $this->ModelNilai->hitungNilaiAkhir($nilai_tugas, $nilai_uts, $nilai_uas);
            $konversi = $this->ModelNilai->konversiNilaiHuruf($nilai_akhir);

            $data = [
                'nilai_tugas' => $nilai_tugas,
                'nilai_uts' => $nilai_uts,
                'nilai_uas' => $nilai_uas,
                'nilai_akhir' => $nilai_akhir,
                'nilai_huruf' => $konversi['huruf'],
                'bobot' => $konversi['bobot'],
            ];

            $this->ModelNilai->UpdateData($id_nilai, $data);
            session()->setFlashdata('info', 'Nilai berhasil diupdate!');
            return redirect()->to(base_url('Nilai'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Nilai'))->withInput();
        }
    }

    public function Finalisasi($id_nilai)
    {
        $nilai = $this->ModelNilai->find($id_nilai);
        if ($nilai) {
            $this->ModelNilai->UpdateData($id_nilai, ['status' => 'Final']);
            $this->ModelNilai->updateIPK($nilai['mahasiswa_id']);
            session()->setFlashdata('info', 'Nilai berhasil difinalisasi dan IPK diupdate!');
        }
        return redirect()->to(base_url('Nilai'));
    }

    public function Delete($id_nilai)
    {
        $this->ModelNilai->DeleteData($id_nilai);
        session()->setFlashdata('info', 'Nilai berhasil dihapus!');
        return redirect()->to(base_url('Nilai'));
    }

    public function Transkrip($mahasiswa_id)
    {
        $mahasiswa = $this->ModelMahasiswa->getBiodataWithAkademik($mahasiswa_id);
        $nilai = $this->ModelNilai->getNilaiByMahasiswa($mahasiswa_id);
        
        $data = [
            'judul'     => 'Transkrip Nilai',
            'menu'      => 'akademik',
            'submenu'   => 'nilai',
            'page'      => 'admin/nilai/v_transkrip',
            'mahasiswa' => $mahasiswa,
            'nilai'     => $nilai,
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }
}