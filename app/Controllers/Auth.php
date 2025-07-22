<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ModelAuth;
use App\Models\ModelUser;
use App\Models\ModelAdmin;

class Auth extends BaseController
{
    protected $ModelAuth;
    protected $ModelUser;
    protected $ModelAdmin;

    public function __construct()
    {
        $this->ModelAuth = new ModelAuth();
        $this->ModelUser = new ModelUser();
        $this->ModelAdmin = new ModelAdmin();
    }

    public function index()
    {
        // 
    }

    public function Login()
    {
        $data = [
            'judul' => 'Login',
            'validation' => \Config\Services::validation(),
        ];
        return view('auth/v_login', $data);
    }

    public function CekUser()
    {
        $email = esc($this->request->getPost('email'));
        $password = esc($this->request->getPost('password'));
        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'email' => [
                'label' => 'Email',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} diisi terlebih dahulu',
                    'max_length' => '{field} tidak boleh lebih dari 100 karakter',
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} diisi terlebih dahulu',
                    'max_length' => '{field} tidak boleh lebih dari 100 karakter',
                ]
            ],
        ]);
        if (!$valid) {
            $sessError = [
                'errEmail' => $validation->getError('email'),
                'errPassword' => $validation->getError('password'),
            ];
            session()->setFlashdata($sessError);
            return redirect()->to(base_url('Auth/login'))->withInput();
        } else {
            $ModelAuth = new ModelAuth();
            $cekUserLogin = $ModelAuth->findUserByEmail($email);
            if ($cekUserLogin == null) {
                $sessError = [
                    'errEmail' => 'Email tidak terdaftar',
                ];
                session()->setFlashdata($sessError);
                return redirect()->to(base_url('Auth/Login'))->withInput();
            } else {
                $passwordUser = $cekUserLogin['password'];
                if (password_verify($password, $passwordUser)) {
                    $idlevel = $cekUserLogin['level_id'];
                    $simpan_session = [
                        'email'     => $email,
                        'user_id'   => $cekUserLogin['id_user'],
                        'nama'      => $cekUserLogin['nama'],
                        'jabatan'   => $cekUserLogin['jabatan'],
                        'profil'    => $cekUserLogin['profil'],
                        'level'     => $idlevel,
                    ];
                    session()->set($simpan_session);
                    if ($idlevel == 1 || $idlevel == 2) {
                        return redirect()->to(base_url('Admin'))->withInput();
                    } else if ($idlevel == 3) {
                        return redirect()->to(base_url())->withInput();
                    }
                } else {
                    $sessError = [
                        'errPassword' => 'Password yang dimasukkan salah',
                    ];
                    session()->setFlashdata($sessError);
                    return redirect()->to(base_url('Auth/Login'))->withInput();
                }
            }
        }
    }

    public function LogOut()
    {
        session()->remove('email');
        session()->remove('user_id');
        session()->remove('nama');
        session()->remove('jabatan');
        session()->remove('profil');
        session()->remove('level');
        session()->setFlashdata('info', 'Berhasil Logout dari akun');
        return redirect()->to(base_url('Auth/Login'));
    }


    public function Register()
    {
        $data = [
            'judul' => 'Register',
            'validation' => \Config\Services::validation(),
        ];
        return view('auth/v_register', $data);
    }

    public function InsertRegister()
    {
        $nama = esc($this->request->getPost('nama'));
        $email = esc($this->request->getPost('email'));
        $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'nama' => [
                'label' => 'Nama',
                'rules' => 'required|max_length[50]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} maksimal 50 karakter',
                ],
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|is_unique[tb_users.email]|valid_email|check_domain|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'is_unique' => '{field} sudah terpakai',
                    'valid_email' => '{field} tidak valid',
                    'check_domain' => 'Domain email tidak diizinkan',
                    'max_length' => '{field} maksimal 100 karakter',
                ],
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[6]|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'min_length' => '{field} minimal 6 karakter',
                    'max_length' => '{field} maksimal 100 karakter',
                ],
            ],
            'confirm_password' => [
                'label' => 'Konfirmasi Password',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'matches' => 'Password dan konfirmasi password tidak cocok',
                ],
            ],
        ]);
        if (!$valid) {
            $sessError = [
                'errNama' => $validation->getError('nama'),
                'errEmail' => $validation->getError('email'),
                'errPassword' => $validation->getError('password'),
                'errConfirmPassword' => $validation->getError('confirm_password'),
            ];
            session()->setFlashdata($sessError);
            return redirect()->to(base_url('Auth/Register'))->withInput();
        } else {
            $data = [
                'nama'      => $nama,
                'email'     => $email,
                'password'  => $password,
                'jabatan'   => 'Jemaah',
                'profil'    => 'avatar.png',
                'level_id'  => 3,
            ];
            $this->ModelUser->InsertUser($data);
            session()->setFlashdata('info', 'User berhasil dibuat, silahkan login');
            return redirect()->to(base_url('Auth/Login'));
        }
    }

    public function MyProfile($id_user)
    {
        $user = $this->ModelUser->getUserById($id_user);
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("User dengan ID $id_user tidak ditemukan");
        }
        $data = [
            'judul' => 'My Profile',
            'menu' => '',
            'submenu' => '',
            'page' => 'auth/v_myprofile',
            'setting'   => $this->ModelAdmin->ViewSetting(),
            'user' => $user,
        ];
        return view('auth/v_myprofile', $data);
    }

    public function EditProfile()
    {
        $id_user = $this->request->getPost('id_user');
        $validation = \Config\Services::validation();
        if ($this->validate([
            'nama' => [
                'label' => 'Nama',
                'rules' => 'required|max_length[50]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} maksimal 50 karakter',
                ],
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|check_domain|max_length[50]|is_unique[tb_users.email,id_user,' . $id_user . ']',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'valid_email' => '{field} tidak valid',
                    'check_domain' => 'Domain email tidak diizinkan',
                    'max_length' => '{field} maksimal 100 karakter',
                    'is_unique' => '{field} sudah terpakai',
                ],
            ],
            'password_baru' => [
                'label' => 'Password Baru',
                'rules' => 'permit_empty|min_length[6]|max_length[100]',
                'errors' => [
                    'min_length' => '{field} minimal 6 karakter',
                    'max_length' => '{field} maksimal 100 karakter',
                ],
            ],
            'profil' => [
                'label' => 'Foto Profil',
                'rules' => 'max_size[profil,2000]|mime_in[profil,image/png,image/jpg,image/jpeg]',
                'errors' => [
                    'max_size' => '{field} ukuran maksimal 2MB',
                    'mime_in' => '{field} hanya bisa mengirim format gambar',
                ],
            ],
        ])) {
            $data = [
                'id_user'       => $id_user,
                'nama'          => esc($this->request->getPost('nama')),
                'email'         => esc($this->request->getPost('email')),
            ];
            $password_baru = $this->request->getPost('password_baru');
            if (!empty($password_baru)) {
                $password_lama = $this->request->getPost('password');
                $user = $this->ModelUser->find($id_user);
                if (!password_verify($password_lama, $user['password'])) {
                    session()->setFlashdata('errors', ['Password lama salah']);
                    return redirect()->to(base_url('Auth/MyProfile/' . $id_user))->withInput();
                }
                $data['password'] = password_hash($password_baru, PASSWORD_DEFAULT);
            }
            $profil = $this->request->getFile('profil');
            if ($profil && $profil->isValid()) {
                $user = $this->ModelUser->find($id_user);
                $old_profil = $user['profil'];
                if ($old_profil && $old_profil !== 'avatar.png' && file_exists('uploaded/profil_user/' . $old_profil)) {
                    unlink('uploaded/profil_user/' . $old_profil);
                }
                $file_profil = $profil->getRandomName();
                $profil->move('uploaded/profil_user', $file_profil);
                $data['profil'] = $file_profil;
            }
            $sesi_baru = [
                'nama' => $data['nama'],
                'email' => $data['email'],
            ];
            if (isset($data['profil'])) {
                $sesi_baru['profil'] = $data['profil'];
            }
            session()->set($sesi_baru);
            $this->ModelAuth->EditProfile($id_user, $data);
            session()->setFlashdata('info', 'User berhasil diperbarui');
            return redirect()->to(base_url('Auth/MyProfile/' . $id_user));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Auth/MyProfile/' . $id_user))->withInput();
        }
    }
}
