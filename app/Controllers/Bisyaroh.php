<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ModelBisyaroh;
use App\Models\ModelKasInternal;
use App\Models\ModelAdmin;

class Bisyaroh extends BaseController
{
    protected $ModelBisyaroh;
    protected $ModelKasInternal;
    protected $ModelAdmin;

    public function __construct()
    {
        $this->ModelBisyaroh = new ModelBisyaroh();
        $this->ModelKasInternal = new ModelKasInternal();
        $this->ModelAdmin = new ModelAdmin();
    }

    public function index()
    {
        $data = [
            'judul'     => 'Bulan Bisyaroh',
            'menu'      => 'bisyaroh',
            'submenu'   => '',
            'page'      => 'admin/bisyaroh/v_bulan_bisyaroh',
            'bisyaroh'  => $this->ModelBisyaroh->AllDataBulan(),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function detailBisyaroh($id_bulan)
    {
        $model = new ModelBisyaroh();
        $bulan = $model->DetailData($id_bulan);
        $bisyaroh = $model->AllDataBisyaroh($id_bulan);
        $tahunArray = array_unique(array_column($bisyaroh, 'tahun'));
        $data['tahunArray'] = $tahunArray;
        $data['judul'] = 'Data Bisyaroh Bulan ' . $bulan['nama_bulan'];
        $data['menu'] = 'bisyaroh';
        $data['submenu'] = '';
        $data['page'] = 'admin/bisyaroh/v_bisyaroh';
        $data['bulan'] = $bulan;
        $data['bisyaroh'] = $bisyaroh;
        foreach ($tahunArray as $tahun) {
            $total1 = $model->getTotalByMonthAndYear($id_bulan, $tahun);
            $data['totalPerTahun'][$tahun] = $total1['total_jumlah'];
            $total2 = $model->getTotalByMonthAndYearConfirmation($id_bulan, $tahun);
            $data['totalPerTahunKonfirmasi'][$tahun] = $total2['total_jumlah_konfirmasi'];
        }
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function InsertData()
    {
        $id_bulan = $this->request->getPost('bulan_id');
        $validation = \Config\Services::validation();
        if ($this->validate([
            'nama' => [
                'label' => 'Nama',
                'rules' => 'required|max_length[50]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 50 karakter',
                ]
            ],
            'tugas' => [
                'label' => 'Tugas',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 100 karakter',
                ]
            ],
            'sumbangan_transport' => [
                'label' => 'Sumbangan Transport',
                'rules' => 'required|numeric|greater_than[0]|less_than_equal_to[2147483647]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} harus berupa angka',
                    'greater_than' => '{field} harus lebih besar dari 0',
                    'less_than_equal_to' => '{field} tidak boleh lebih dari 10 digit (Rp. 2,147,483,647)',
                ]
            ],
            'tahun' => [
                'label' => 'Tahun',
                'rules' => 'required|max_length[4]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 4 karakter',
                ]
            ],
        ])) {
            $data = [
                'nama'                  => esc($this->request->getPost('nama')),
                'tugas'                 => esc($this->request->getPost('tugas')),
                'sumbangan_transport'   => esc($this->request->getPost('sumbangan_transport')),
                'tahun'                 => esc($this->request->getPost('tahun')),
                'status'                => 0,
                'bulan_id'              => $id_bulan,
                'user_id'               => session()->get('user_id'),
            ];
            $this->ModelBisyaroh->InsertData($data);
            session()->setFlashdata('info', 'Bisyaroh berhasil ditambahkan!');
            return redirect()->to(base_url('Bisyaroh/detailBisyaroh/' . $id_bulan));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Bisyaroh/detailBisyaroh/' . $id_bulan))->withInput();
        }
    }

    public function DeleteData($id_bulan, $id_bisyaroh)
    {
        $data = [
            'id_bisyaroh' => $id_bisyaroh,
        ];
        $this->ModelBisyaroh->DeleteData($data);
        session()->setFlashdata('info', 'Data Bisyaroh berhasil dihapus!');
        return redirect()->to(base_url('Bisyaroh/detailBisyaroh/' . $id_bulan));
    }

    public function ValidasiBisyaroh()
    {
        $bulan_id = $this->request->getPost('bulan_id');
        $tahun = $this->request->getPost('tahun_konfirmasi');
        $total = $this->ModelBisyaroh->getTotalByMonthAndYearConfirmation($bulan_id, $tahun, 0);
        if ($total) {
            $bulan = [
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
            $nama_bulan = isset($bulan[$bulan_id]) ? $bulan[$bulan_id] : 'Bulan tidak valid';
            $data = [
                'tgl'           => date('Y-m-d'),
                'dana_masuk'    => 0,
                'dana_keluar'   => $total['total_jumlah_konfirmasi'],
                'Kategori'      => 'Bisyaroh ' . $bulan_id . ' ' . $tahun,
                'keterangan'    => 'Dana Bisyaroh Bulan ' . $nama_bulan . ' ' . $tahun,
                'status'        => 'Keluar',
                'user_id'       => session()->get('user_id'),
            ];
            $this->ModelKasInternal->InsertData($data);
            $this->ModelBisyaroh->UpdateBisyarohStatus($bulan_id, $tahun, 1);
            session()->setFlashdata('info', 'Data Bisyaroh berhasil divalidasi!');
            return redirect()->to(base_url('Bisyaroh/detailBisyaroh/' . $bulan_id));
        } else {
            session()->setFlashdata('errors', 'Tidak ada data yang perlu divalidasi untuk tahun ini.');
            return redirect()->to(base_url('Bisyaroh/detailBisyaroh/' . $bulan_id));
        }
    }
}
