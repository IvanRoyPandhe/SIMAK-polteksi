<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ModelUser;

class User extends BaseController
{
    protected $ModelUser;

    public function __construct()
    {
        $pager = \Config\Services::pager();
        $this->ModelUser = new ModelUser();
    }

    public function index()
    {
        $level = $this->request->getVar('level');
        $search = $this->request->getVar('search');
        $totalUsers = $this->ModelUser->countAll();
        $data = [
            'judul'         => 'User',
            'menu'          => 'user-setting',
            'submenu'       => '',
            'page'          => 'admin/user/v_user',
            'users'         => $this->ModelUser->getUserLevel($level, $search),
            'pager'         => $this->ModelUser->pager,
            'totalUsers'    => $totalUsers,
            'level'         => $level,
            'search'        => $search,
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function indexInsertUser()
    {
        $data = [
            'judul'         => 'Tambah User',
            'menu'          => 'user-setting',
            'submenu'       => '',
            'page'          => 'admin/user/v_add_user',
            'level_user'    => $this->ModelUser->AllDataLevelUser(),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function InsertUser()
    {
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
            'konfirmasi_password' => [
                'label' => 'Konfirmasi Password',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'matches' => 'Password dan konfirmasi password tidak cocok',
                ],
            ],
            'jabatan' => [
                'label' => 'Jabatan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ],
            ],
            'level_id' => [
                'label' => 'Roles',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
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
            $profil = $this->request->getFile('profil');
            if ($profil && $profil->isValid()) {
                $file_profil = $profil->getRandomName();
                $profil->move('uploaded/profil_user', $file_profil);
            } else {
                $file_profil = 'avatar.png';
            }
            $data = [
                'nama'      => esc($this->request->getPost('nama')),
                'email'     => esc($this->request->getPost('email')),
                'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'jabatan'   => esc($this->request->getPost('jabatan')),
                'profil'    => $file_profil,
                'level_id'  => esc($this->request->getPost('level_id')),
            ];
            $this->ModelUser->InsertUser($data);
            session()->setFlashdata('info', 'User berhasil dibuat');
            return redirect()->to(base_url('User'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('User/indexInsertUser'))->withInput();
        }
    }

    public function indexEditUser($id_user)
    {
        $user = $this->ModelUser->getUserById($id_user);
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("User dengan ID $id_user tidak ditemukan");
        }
        $data = [
            'judul'         => 'Edit User',
            'menu'          => 'user-setting',
            'submenu'       => '',
            'page'          => 'admin/user/v_edit_user',
            'users'         => $user,
            'level_user'    => $this->ModelUser->AllDataLevelUser(),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function EditUser()
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
            'password' => [
                'label' => 'Password',
                'rules' => 'permit_empty|min_length[6]|max_length[100]',
                'errors' => [
                    'min_length' => '{field} minimal 6 karakter',
                    'max_length' => '{field} maksimal 100 karakter',
                ],
            ],
            'konfirmasi_password' => [
                'label' => 'Konfirmasi Password',
                'rules' => 'matches[password]',
                'errors' => [
                    'matches' => 'Password dan {field} tidak cocok',
                ],
            ],
            'jabatan' => [
                'label' => 'Jabatan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ],
            ],
            'level_id' => [
                'label' => 'Roles',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
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
                'jabatan'       => esc($this->request->getPost('jabatan')),
                'level_id'      => $this->request->getPost('level_id'),
            ];
            if ($this->request->getPost('password')) {
                $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
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
            $current_user_id = session()->get('user_id');
            if ($current_user_id == $id_user) {
                $sesi_baru = [
                    'nama' => $data['nama'],
                    'email' => $data['email'],
                    'jabatan' => $data['jabatan'],
                    'level' => $data['level_id'],
                ];
                if (isset($data['profil'])) {
                    $sesi_baru['profil'] = $data['profil'];
                }
                session()->set($sesi_baru);
            }
            $this->ModelUser->EditUser($id_user, $data);
            session()->setFlashdata('info', 'User berhasil diperbarui');
            return redirect()->to(base_url('User'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('User/indexEditUser/' . $id_user))->withInput();
        }
    }

    public function DeleteUser($id_user)
    {
        try {
            $user = $this->ModelUser->find($id_user);
            if (!$user) {
                session()->setFlashdata('info', 'User tidak ditemukan.');
            } else {
                if ($user['profil'] && $user['profil'] !== 'avatar.png' && file_exists('uploaded/profil_user/' . $user['profil'])) {
                    unlink('uploaded/profil_user/' . $user['profil']);
                }
                $this->ModelUser->delete($id_user);
                session()->setFlashdata('info', 'User berhasil dihapus.');
            }
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            if ($e->getCode() == 1451) {
                session()->setFlashdata('errors', 'User tidak bisa dihapus karena masih berelasi dengan data lain.');
            } else {
                session()->setFlashdata('errors', 'Terjadi kesalahan saat mencoba menghapus user: ' . $e->getMessage());
            }
        }
        return redirect()->to(base_url('User'));
    }
}
