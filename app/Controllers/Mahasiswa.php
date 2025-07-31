<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMahasiswa;
use App\Models\ModelUser;

class Mahasiswa extends BaseController
{
    protected $ModelMahasiswa;
    protected $user;

    public function __construct()
    {
        $this->ModelMahasiswa = new ModelMahasiswa();
        helper(['form', 'url']);
        
        // Get user data from session
        $userModel = new \App\Models\ModelUser();
        $this->user = $userModel->find(session()->get('user_id'));
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
            'prodi_id' => [
                'label' => 'Program Studi',
                'rules' => 'required|integer',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'integer' => '{field} harus berupa angka',
                ]
            ],
        ])) {
            $data = [
                'nim'            => esc($this->request->getPost('nim')),
                'nama'           => esc($this->request->getPost('nama')),
                'email'          => esc($this->request->getPost('email')),
                'prodi_id'       => esc($this->request->getPost('prodi_id')),
                'semester'       => esc($this->request->getPost('semester')),
                'tahun_angkatan' => esc($this->request->getPost('tahun_angkatan')),
                'status'         => esc($this->request->getPost('status')),
            ];
            $mahasiswaId = $this->ModelMahasiswa->InsertData($data);
            
            // Auto create user account
            $userModel = new ModelUser();
            $existingUser = $userModel->where('email', $data['email'])->first();
            
            if (!$existingUser) {
                $userData = [
                    'nama' => $data['nama'],
                    'email' => $data['email'],
                    'password' => password_hash('123456', PASSWORD_DEFAULT),
                    'jabatan' => 'Mahasiswa',
                    'profil' => 'avatar.png',
                    'level_id' => 4
                ];
                $userModel->InsertUser($userData);
            }
            
            session()->setFlashdata('info', 'Data mahasiswa berhasil ditambahkan dan akun user dibuat otomatis');
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
                'nim'            => esc($this->request->getPost('nim')),
                'nama'           => esc($this->request->getPost('nama')),
                'email'          => esc($this->request->getPost('email')),
                'prodi_id'       => esc($this->request->getPost('prodi_id')),
                'semester'       => esc($this->request->getPost('semester')),
                'tahun_angkatan' => esc($this->request->getPost('tahun_angkatan')),
                'status'         => esc($this->request->getPost('status')),
            ];
            $this->ModelMahasiswa->UpdateData($id_mahasiswa, $data);
            
            // Auto create user account if email changed
            $userModel = new ModelUser();
            $existingUser = $userModel->where('email', $data['email'])->first();
            
            if (!$existingUser) {
                $userData = [
                    'nama' => $data['nama'],
                    'email' => $data['email'],
                    'password' => password_hash('123456', PASSWORD_DEFAULT),
                    'jabatan' => 'Mahasiswa',
                    'profil' => 'avatar.png',
                    'level_id' => 4
                ];
                $userModel->InsertUser($userData);
            }
            
            session()->setFlashdata('info', 'Data mahasiswa berhasil diupdate dan akun user dibuat otomatis');
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

    public function Import()
    {
        $data = [
            'judul' => 'Import Data Mahasiswa',
            'menu' => 'mahasiswa',
            'submenu' => '',
            'page' => 'admin/mahasiswa/v_import_mahasiswa',
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function ProcessImport()
    {
        $file = $this->request->getFile('file_import');
        
        if (!$file->isValid()) {
            session()->setFlashdata('error', 'File tidak valid');
            return redirect()->to(base_url('Mahasiswa/Import'));
        }

        $extension = $file->getClientExtension();
        if (!in_array($extension, ['csv', 'xlsx', 'xls'])) {
            session()->setFlashdata('error', 'Format file harus CSV atau Excel');
            return redirect()->to(base_url('Mahasiswa/Import'));
        }

        $fileName = $file->getRandomName();
        $file->move('uploaded/import/', $fileName);
        $filePath = 'uploaded/import/' . $fileName;

        try {
            $data = [];
            
            if ($extension === 'csv') {
                $data = $this->readCSV($filePath);
            } else {
                $data = $this->readExcel($filePath);
            }

            $success = 0;
            $errors = [];
            
            foreach ($data as $index => $row) {
                if ($this->insertMahasiswaWithUser($row, $index + 2)) {
                    $success++;
                } else {
                    $errors[] = "Baris " . ($index + 2) . ": Data tidak valid";
                }
            }

            unlink($filePath);
            
            $message = "Berhasil import $success data mahasiswa";
            if (!empty($errors)) {
                $message .= ". Error: " . implode(', ', array_slice($errors, 0, 3));
                if (count($errors) > 3) $message .= " dan " . (count($errors) - 3) . " error lainnya";
            }
            
            session()->setFlashdata('info', $message);
            return redirect()->to(base_url('Mahasiswa'));
            
        } catch (\Exception $e) {
            if (file_exists($filePath)) unlink($filePath);
            session()->setFlashdata('error', 'Error: ' . $e->getMessage());
            return redirect()->to(base_url('Mahasiswa/Import'));
        }
    }

    private function readCSV($filePath)
    {
        $data = [];
        if (($handle = fopen($filePath, "r")) !== FALSE) {
            $header = fgetcsv($handle, 1000, ",");
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if (count($row) >= 6) {
                    $data[] = [
                        'nim' => trim($row[0]),
                        'nama' => trim($row[1]),
                        'email' => trim($row[2]),
                        'prodi_id' => trim($row[3]),
                        'tahun_angkatan' => trim($row[4]),
                        'semester' => trim($row[5])
                    ];
                }
            }
            fclose($handle);
        }
        return $data;
    }

    private function readExcel($filePath)
    {
        // Implementasi sederhana untuk Excel - dalam production gunakan PhpSpreadsheet
        throw new \Exception('Excel import belum diimplementasi. Gunakan format CSV.');
    }

    private function insertMahasiswaWithUser($row, $lineNumber)
    {
        if (empty($row['nim']) || empty($row['nama']) || empty($row['email'])) {
            return false;
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Cek apakah mahasiswa sudah ada
            $existingMahasiswa = $this->ModelMahasiswa->where('nim', $row['nim'])->first();
            if ($existingMahasiswa) {
                $db->transRollback();
                return false;
            }

            // Insert mahasiswa
            $mahasiswaData = [
                'nim' => $row['nim'],
                'nama' => $row['nama'],
                'email' => $row['email'],
                'prodi_id' => $row['prodi_id'] ?? 1,
                'tahun_angkatan' => $row['tahun_angkatan'] ?? date('Y'),
                'semester' => $row['semester'] ?? 1,
                'status' => 'Aktif'
            ];
            
            $mahasiswaId = $this->ModelMahasiswa->insert($mahasiswaData);
            
            // Auto create user account
            $userModel = new \App\Models\ModelUser();
            $existingUser = $userModel->where('email', $row['email'])->first();
            
            if (!$existingUser) {
                $userData = [
                    'nama' => $row['nama'],
                    'email' => $row['email'],
                    'password' => password_hash('123456', PASSWORD_DEFAULT),
                    'jabatan' => 'Mahasiswa',
                    'profil' => 'avatar.png',
                    'level_id' => 4
                ];
                $userModel->InsertUser($userData);
            }

            $db->transComplete();
            return $db->transStatus();
            
        } catch (\Exception $e) {
            $db->transRollback();
            return false;
        }
    }

    public function DownloadTemplate()
    {
        $filename = 'template_import_mahasiswa.csv';
        $header = ['NIM', 'Nama', 'Email', 'Prodi ID', 'Tahun Angkatan', 'Semester'];
        $sample = [
            ['2024001', 'John Doe', 'john@student.kampus.ac.id', '1', '2024', '1'],
            ['2024002', 'Jane Smith', 'jane@student.kampus.ac.id', '2', '2024', '1']
        ];
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, $header);
        foreach ($sample as $row) {
            fputcsv($output, $row);
        }
        fclose($output);
        exit;
    }
}