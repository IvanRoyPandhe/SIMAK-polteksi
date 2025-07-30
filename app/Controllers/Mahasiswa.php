<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMahasiswa;

class Mahasiswa extends BaseController
{
    protected $ModelMahasiswa;

    public function __construct()
    {
        $this->ModelMahasiswa = new ModelMahasiswa();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'judul'     => 'Data Mahasiswa',
            'menu'      => 'mahasiswa',
            'submenu'   => '',
            'page'      => 'admin/mahasiswa/v_mahasiswa',
            'mahasiswa' => $this->ModelMahasiswa->AllData(),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function Insert()
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'nim' => [
                'label' => 'NIM',
                'rules' => 'required|is_unique[tb_mahasiswa.nim]|max_length[20]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'is_unique' => '{field} sudah terdaftar',
                    'max_length' => '{field} maksimal 20 karakter',
                ]
            ],
            'nama' => [
                'label' => 'Nama',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} maksimal 100 karakter',
                ]
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|is_unique[tb_mahasiswa.email]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'valid_email' => '{field} tidak valid',
                    'is_unique' => '{field} sudah terdaftar',
                ]
            ],
            'jurusan' => [
                'label' => 'Jurusan',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} maksimal 100 karakter',
                ]
            ],
        ])) {
            $data = [
                'nim'       => esc($this->request->getPost('nim')),
                'nama'      => esc($this->request->getPost('nama')),
                'email'     => esc($this->request->getPost('email')),
                'jurusan'   => esc($this->request->getPost('jurusan')),
                'semester'  => esc($this->request->getPost('semester')),
                'angkatan'  => esc($this->request->getPost('angkatan')),
                'status'    => esc($this->request->getPost('status')),
            ];
            $this->ModelMahasiswa->InsertData($data);
            session()->setFlashdata('info', 'Data mahasiswa berhasil ditambahkan');
            return redirect()->to(base_url('Mahasiswa'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Mahasiswa'))->withInput();
        }
    }

    public function Update($id_mahasiswa)
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'nim' => [
                'label' => 'NIM',
                'rules' => 'required|max_length[20]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} maksimal 20 karakter',
                ]
            ],
            'nama' => [
                'label' => 'Nama',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} maksimal 100 karakter',
                ]
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'valid_email' => '{field} tidak valid',
                ]
            ],
        ])) {
            $data = [
                'nim'       => esc($this->request->getPost('nim')),
                'nama'      => esc($this->request->getPost('nama')),
                'email'     => esc($this->request->getPost('email')),
                'jurusan'   => esc($this->request->getPost('jurusan')),
                'semester'  => esc($this->request->getPost('semester')),
                'angkatan'  => esc($this->request->getPost('angkatan')),
                'status'    => esc($this->request->getPost('status')),
            ];
            $this->ModelMahasiswa->UpdateData($id_mahasiswa, $data);
            session()->setFlashdata('info', 'Data mahasiswa berhasil diupdate');
            return redirect()->to(base_url('Mahasiswa'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Mahasiswa'))->withInput();
        }
    }

    public function Delete($id_mahasiswa)
    {
        $this->ModelMahasiswa->DeleteData($id_mahasiswa);
        session()->setFlashdata('info', 'Data mahasiswa berhasil dihapus');
        return redirect()->to(base_url('Mahasiswa'));
    }

    public function Biodata($id_mahasiswa)
    {
        $mahasiswa = $this->ModelMahasiswa->getBiodataWithAkademik($id_mahasiswa);
        if (!$mahasiswa) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Mahasiswa tidak ditemukan');
        }
        
        $data = [
            'judul'     => 'Biodata Mahasiswa',
            'menu'      => 'mahasiswa',
            'submenu'   => '',
            'page'      => 'admin/mahasiswa/v_biodata_mahasiswa',
            'mahasiswa' => $mahasiswa,
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function UpdateBiodata($id_mahasiswa)
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
            'semester_aktif' => 'permit_empty|integer|greater_than[0]|less_than[9]',
            'status_akademik' => 'permit_empty|in_list[Aktif,Cuti,Non-Aktif,Lulus,DO]',
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
                'semester_aktif' => $this->request->getPost('semester_aktif'),
                'status_akademik' => $this->request->getPost('status_akademik'),
            ];
            
            $this->ModelMahasiswa->updateBiodata($id_mahasiswa, $data);
            session()->setFlashdata('info', 'Biodata mahasiswa berhasil diupdate!');
            return redirect()->to(base_url('Mahasiswa/Biodata/' . $id_mahasiswa));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Mahasiswa/Biodata/' . $id_mahasiswa))->withInput();
        }
    }
}