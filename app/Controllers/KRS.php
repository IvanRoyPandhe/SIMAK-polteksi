<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelKRS;
use App\Models\ModelMahasiswa;
use App\Models\ModelMataKuliah;
use App\Models\ModelPeriodeAkademik;

class KRS extends BaseController
{
    protected $ModelKRS;
    protected $ModelMahasiswa;
    protected $ModelMataKuliah;
    protected $ModelPeriodeAkademik;

    public function __construct()
    {
        $this->ModelKRS = new ModelKRS();
        $this->ModelMahasiswa = new ModelMahasiswa();
        $this->ModelMataKuliah = new ModelMataKuliah();
        $this->ModelPeriodeAkademik = new ModelPeriodeAkademik();
    }

    public function index()
    {
        $periode_aktif = $this->ModelPeriodeAkademik->getPeriodeAktif();
        
        $data = [
            'judul'     => 'Manajemen KRS',
            'menu'      => 'akademik',
            'submenu'   => 'krs',
            'page'      => 'admin/v_krs',
            'krs'       => $this->ModelKRS->AllData(),
            'mahasiswa' => $this->ModelMahasiswa->AllData(),
            'matkul'    => $this->ModelMataKuliah->AllData(),
            'periode_aktif' => $periode_aktif,
            'periode_list' => $this->ModelPeriodeAkademik->AllData(),
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
        ])) {
            $data = [
                'mahasiswa_id' => esc($this->request->getPost('mahasiswa_id')),
                'matkul_id' => esc($this->request->getPost('matkul_id')),
                'semester_aktif' => esc($this->request->getPost('semester_aktif')),
                'tahun_akademik' => esc($this->request->getPost('tahun_akademik')),
                'status' => 'Pending',
            ];
            $this->ModelKRS->InsertData($data);
            session()->setFlashdata('info', 'Data KRS berhasil ditambahkan!');
            return redirect()->to(base_url('KRS'));
        } else {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->to(base_url('KRS'))->withInput();
        }
    }

    public function UpdateStatus($id_krs, $status)
    {
        $data = [
            'id_krs' => $id_krs,
            'status' => $status,
        ];
        $this->ModelKRS->UpdateStatus($data);
        session()->setFlashdata('info', 'Status KRS berhasil diubah!');
        return redirect()->to(base_url('KRS'));
    }

    public function Delete($id_krs)
    {
        $this->ModelKRS->DeleteData($id_krs);
        session()->setFlashdata('info', 'Data KRS berhasil dihapus!');
        return redirect()->to(base_url('KRS'));
    }

    public function Approve($id_krs)
    {
        $data = [
            'id_krs' => $id_krs,
            'status' => 'Disetujui',
        ];
        $this->ModelKRS->UpdateData($data);
        session()->setFlashdata('info', 'KRS berhasil disetujui!');
        return redirect()->to(base_url('KRS'));
    }

    public function Reject($id_krs)
    {
        $data = [
            'id_krs' => $id_krs,
            'status' => 'Ditolak',
        ];
        $this->ModelKRS->UpdateData($data);
        session()->setFlashdata('info', 'KRS berhasil ditolak!');
        return redirect()->to(base_url('KRS'));
    }

    public function Laporan()
    {
        $krs_data = $this->ModelKRS->AllData();
        
        $data = [
            'judul' => 'Laporan KRS',
            'menu' => 'akademik',
            'submenu' => 'krs',
            'page' => 'admin/v_laporan_krs',
            'krs_data' => $krs_data,
            'total_krs' => count($krs_data)
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function UpdatePeriode()
    {
        $periode_id = $this->request->getPost('periode_id');
        $status_krs = $this->request->getPost('status_krs');
        $tgl_mulai_krs = $this->request->getPost('tgl_mulai_krs');
        $tgl_selesai_krs = $this->request->getPost('tgl_selesai_krs');
        $max_sks = $this->request->getPost('max_sks');
        
        // Update periode akademik
        $this->ModelPeriodeAkademik->UpdateData([
            'id_periode' => $periode_id,
            'status_krs' => $status_krs,
            'tgl_mulai_krs' => $tgl_mulai_krs,
            'tgl_selesai_krs' => $tgl_selesai_krs,
            'max_sks' => $max_sks
        ]);
        
        session()->setFlashdata('info', 'Pengaturan periode KRS berhasil diupdate!');
        return redirect()->to(base_url('KRS'));
    }

    public function ValidasiSKS($mahasiswa_id, $periode_id)
    {
        $db = \Config\Database::connect();
        
        // Get mahasiswa data
        $mahasiswa = $this->ModelMahasiswa->find($mahasiswa_id);
        
        // Get periode data
        $periode = $this->ModelPeriodeAkademik->find($periode_id);
        
        // Get current KRS
        $current_krs = $db->table('tb_krs')
            ->join('tb_mata_kuliah', 'tb_mata_kuliah.id_matkul = tb_krs.mata_kuliah_id')
            ->where('tb_krs.mahasiswa_id', $mahasiswa_id)
            ->where('tb_krs.periode_id', $periode_id)
            ->selectSum('tb_mata_kuliah.sks', 'total_sks')
            ->get()->getRowArray();
            
        $total_sks = $current_krs['total_sks'] ?? 0;
        
        // Determine max SKS based on IPK and periode setting
        $max_sks_periode = $periode['max_sks'] ?? 24;
        $max_sks_ipk = 24;
        
        if ($mahasiswa['ipk'] < 2.0) $max_sks_ipk = 18;
        elseif ($mahasiswa['ipk'] < 2.5) $max_sks_ipk = 20;
        elseif ($mahasiswa['ipk'] >= 3.5) $max_sks_ipk = 24;
        
        $max_sks_allowed = min($max_sks_periode, $max_sks_ipk);
        
        return [
            'total_sks' => $total_sks,
            'max_sks_periode' => $max_sks_periode,
            'max_sks_ipk' => $max_sks_ipk,
            'max_sks_allowed' => $max_sks_allowed,
            'can_add_more' => $total_sks < $max_sks_allowed
        ];
    }
}