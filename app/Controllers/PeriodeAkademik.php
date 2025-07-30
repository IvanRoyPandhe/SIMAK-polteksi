<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelPeriodeAkademik;

class PeriodeAkademik extends BaseController
{
    protected $ModelPeriodeAkademik;

    public function __construct()
    {
        $this->ModelPeriodeAkademik = new ModelPeriodeAkademik();
    }

    public function index()
    {
        $periode_aktif = $this->ModelPeriodeAkademik->getPeriodeAktif();
        $data = [
            'judul'     => 'Periode Akademik',
            'menu'      => 'periode-akademik',
            'submenu'   => '',
            'page'      => 'admin/akademik/v_periode_akademik',
            'periode'   => $this->ModelPeriodeAkademik->AllData(),
            'periode_aktif' => $periode_aktif,
            'statistik' => $periode_aktif ? $this->ModelPeriodeAkademik->getStatistik($periode_aktif['id_periode']) : null,
            'jadwal_penting' => $periode_aktif ? $this->ModelPeriodeAkademik->getJadwalPenting($periode_aktif['id_periode']) : [],
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function InsertData()
    {
        if ($this->validate([
            'semester' => [
                'label' => 'Semester',
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
            'tgl_mulai_krs' => [
                'label' => 'Tanggal Mulai KRS',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'tgl_selesai_krs' => [
                'label' => 'Tanggal Selesai KRS',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
        ])) {
            $data = [
                'semester' => esc($this->request->getPost('semester')),
                'tahun_akademik' => esc($this->request->getPost('tahun_akademik')),
                'tgl_mulai_krs' => esc($this->request->getPost('tgl_mulai_krs')),
                'tgl_selesai_krs' => esc($this->request->getPost('tgl_selesai_krs')),
                'tgl_mulai_kuliah' => esc($this->request->getPost('tgl_mulai_kuliah')),
                'tgl_selesai_kuliah' => esc($this->request->getPost('tgl_selesai_kuliah')),
                'tgl_uts_mulai' => esc($this->request->getPost('tgl_uts_mulai')),
                'tgl_uts_selesai' => esc($this->request->getPost('tgl_uts_selesai')),
                'tgl_uas_mulai' => esc($this->request->getPost('tgl_uas_mulai')),
                'tgl_uas_selesai' => esc($this->request->getPost('tgl_uas_selesai')),
                'max_sks_normal' => esc($this->request->getPost('max_sks_normal')),
                'max_sks_remedial' => esc($this->request->getPost('max_sks_remedial')),
                'keterangan' => esc($this->request->getPost('keterangan')),
                'status_krs' => 'Tutup',
                'status_khs' => 'Draft',
                'is_active' => 0,
            ];
            $this->ModelPeriodeAkademik->InsertData($data);
            session()->setFlashdata('info', 'Periode akademik berhasil ditambahkan!');
            return redirect()->to(base_url('PeriodeAkademik'));
        } else {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->to(base_url('PeriodeAkademik'))->withInput();
        }
    }

    public function UpdateStatus($id_periode, $field, $status)
    {
        $data = [
            'id_periode' => $id_periode,
            $field => $status,
        ];
        $this->ModelPeriodeAkademik->UpdateData($data);
        session()->setFlashdata('info', 'Status berhasil diubah!');
        return redirect()->to(base_url('PeriodeAkademik'));
    }

    public function Delete($id_periode)
    {
        $this->ModelPeriodeAkademik->DeleteData($id_periode);
        session()->setFlashdata('info', 'Periode akademik berhasil dihapus!');
        return redirect()->to(base_url('PeriodeAkademik'));
    }

    public function SetAktif($id_periode)
    {
        $this->ModelPeriodeAkademik->setAktif($id_periode);
        session()->setFlashdata('info', 'Periode akademik berhasil diaktifkan!');
        return redirect()->to(base_url('PeriodeAkademik'));
    }

    public function Detail($id_periode)
    {
        $periode = $this->ModelPeriodeAkademik->find($id_periode);
        if (!$periode) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Periode tidak ditemukan');
        }
        
        $data = [
            'judul'     => 'Detail Periode Akademik',
            'menu'      => 'periode-akademik',
            'submenu'   => '',
            'page'      => 'admin/akademik/v_detail_periode',
            'periode'   => $periode,
            'statistik' => $this->ModelPeriodeAkademik->getStatistik($id_periode),
            'jadwal_penting' => $this->ModelPeriodeAkademik->getJadwalPenting($id_periode),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function GenerateKalender($id_periode)
    {
        $periode = $this->ModelPeriodeAkademik->find($id_periode);
        $jadwal = $this->ModelPeriodeAkademik->getJadwalPenting($id_periode);
        
        header('Content-Type: application/json');
        
        $events = [];
        foreach ($jadwal as $item) {
            $dates = explode(' - ', $item['tanggal']);
            $events[] = [
                'title' => $item['nama'],
                'start' => $dates[0],
                'end' => isset($dates[1]) ? $dates[1] : $dates[0],
                'color' => $item['status'] == 'active' ? '#28a745' : ($item['status'] == 'upcoming' ? '#ffc107' : '#6c757d')
            ];
        }
        
        echo json_encode($events);
    }
}