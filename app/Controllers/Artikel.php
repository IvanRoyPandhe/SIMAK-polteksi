<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ModelArtikel;

class Artikel extends BaseController
{
    protected $ModelArtikel;

    public function __construct()
    {
        $this->ModelArtikel = new ModelArtikel();
    }

    public function index()
    {
        $data = [
            'judul'     => 'Artikel',
            'menu'      => 'artikel',
            'submenu'   => 'artikel-sub',
            'page'      => 'admin/artikel/v_artikel',
            'artikel'   => $this->ModelArtikel->AllDataArtikel(),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function indexInsertArtikel()
    {
        $data = [
            'judul'         => 'Tambah Artikel',
            'menu'          => 'artikel',
            'submenu'       => 'artikel-sub',
            'page'          => 'admin/artikel/v_insert_artikel',
            'kat_artikel'   => $this->ModelArtikel->AllDataKategori(),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function InsertArtikel()
    {
        $validation = \Config\Services::validation();
        $isi = $this->request->getPost('isi');
        $isi_trimmed = trim($isi);
        $isi_plain = strip_tags($isi_trimmed);
        if ($this->validate([
            'penulis' => [
                'label' => 'Penulis',
                'rules' => 'required|max_length[50]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 50 karakter',
                ]
            ],
            'judul' => [
                'label' => 'Judul',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 100 karakter',
                ]
            ],
            'slug' => [
                'label' => 'Slug',
                'rules' => 'required|is_unique[tb_artikel.slug]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'is_unique' => 'Slug sudah digunakan, silakan edit slug atau judul',
                ]
            ],
            'thumbnail' => [
                'label' => 'Gambar Thumbnail',
                'rules' => 'uploaded[thumbnail]|max_size[thumbnail,10000]|mime_in[thumbnail,image/png,image/jpg,image/jpeg]',
                'errors' => [
                    'uploaded' => '{field} tidak boleh kosong, silakan pilih file gambar.',
                    'max_size' => '{field} ukuran maksimal 10MB',
                    'mime_in' => '{field} hanya bisa mengirim format gambar',
                ],
            ],
            'isi' => [
                'label' => 'Isi Konten',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'kategori' => [
                'label' => 'Kategori',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'status' => [
                'label' => 'Status',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
        ])) {
            $thumbnail = $this->request->getFile('thumbnail');
            $file_thumbnail = $thumbnail->getRandomName();
            $thumbnail->move('uploaded/thumbnail_artikel', $file_thumbnail);
            $data = [
                'penulis'           => esc($this->request->getPost('penulis')),
                'judul'             => esc($this->request->getPost('judul')),
                'slug'              => esc($this->request->getPost('slug')),
                'thumbnail'         => $file_thumbnail,
                'isi'               => $this->request->getPost('isi'),
                'kat_artikel_id'    => esc($this->request->getPost('kategori')),
                'status'            => esc($this->request->getPost('status')),
                'user_id'           => session()->get('user_id'),
            ];
            $this->ModelArtikel->InsertArtikel($data);
            session()->setFlashdata('info', 'Data artikel berhasil ditambahkan!');
            return redirect()->to(base_url('Artikel'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Artikel/indexInsertArtikel'))->withInput();
        }
    }

    public function indexEditArtikel($id_artikel)
    {
        $artikel = $this->ModelArtikel->getArtikelById($id_artikel);
        if (!$artikel) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Artikel dengan ID $id_artikel tidak ditemukan");
        }
        $data = [
            'judul'         => 'Edit Artikel',
            'menu'          => 'artikel',
            'submenu'       => 'artikel-sub',
            'page'          => 'admin/artikel/v_edit_artikel',
            'artikel'       => $artikel,
            'kat_artikel'   => $this->ModelArtikel->AllDataKategori(),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function EditArtikel()
    {
        $id_artikel = $this->request->getPost('id_artikel');
        $validation = \Config\Services::validation();
        $isi = $this->request->getPost('isi');
        $isi_trimmed = trim($isi);
        $isi_plain = strip_tags($isi_trimmed);
        if (empty($isi_plain)) {
            $validation->setError('isi', 'Isi konten tidak boleh kosong');
        }
        if ($this->validate([
            'penulis' => [
                'label' => 'Penulis',
                'rules' => 'required|max_length[50]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 50 karakter',
                ]
            ],
            'judul' => [
                'label' => 'Judul',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 100 karakter',
                ]
            ],
            'slug' => [
                'label' => 'Slug',
                'rules' => 'required|is_unique[tb_artikel.slug,id_artikel,' . $id_artikel . ']',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'is_unique' => '{field} sudah digunakan, silakan edit slug atau judul',
                ]
            ],
            'thumbnail' => [
                'label' => 'Gambar Thumbnail',
                'rules' => 'max_size[thumbnail,10000]|mime_in[thumbnail,image/png,image/jpg,image/jpeg]',
                'errors' => [
                    'max_size' => '{field} ukuran maksimal 10MB',
                    'mime_in' => '{field} hanya bisa mengirim format gambar',
                ],
            ],
            'isi' => [
                'label' => 'Isi Konten',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'kategori' => [
                'label' => 'Kategori',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'status' => [
                'label' => 'Status',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
        ])) {
            $data = [
                'id_artikel'        => $id_artikel,
                'penulis'           => esc($this->request->getPost('penulis')),
                'judul'             => esc($this->request->getPost('judul')),
                'slug'              => esc($this->request->getPost('slug')),
                'isi'               => $isi,
                'kat_artikel_id'    => esc($this->request->getPost('kategori')),
                'status'            => esc($this->request->getPost('status')),
                'user_id'           => session()->get('user_id'),
            ];
            $thumbnail = $this->request->getFile('thumbnail');
            if ($thumbnail && $thumbnail->isValid()) {
                $artikel = $this->ModelArtikel->find($id_artikel);
                $old_thumbnail = $artikel['thumbnail'];
                if ($old_thumbnail && $old_thumbnail !== 'avatar.png' && file_exists('uploaded/thumbnail_artikel/' . $old_thumbnail)) {
                    unlink('uploaded/thumbnail_artikel/' . $old_thumbnail);
                }
                $file_thumbnail = $thumbnail->getRandomName();
                $thumbnail->move('uploaded/thumbnail_artikel', $file_thumbnail);
                $data['thumbnail'] = $file_thumbnail;
            }
            $this->ModelArtikel->EditArtikel($id_artikel, $data);
            session()->setFlashdata('info', 'Data artikel berhasil diperbarui');
            return redirect()->to(base_url('Artikel'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Artikel/indexEditArtikel/' . $id_artikel))->withInput();
        }
    }

    public function DeleteArtikel($id_artikel)
    {
        $artikel = $this->ModelArtikel->find($id_artikel);
        unlink('uploaded/thumbnail_artikel/' . $artikel['thumbnail']);
        $this->ModelArtikel->delete($id_artikel);
        session()->setFlashdata('info', 'User berhasil dihapus.');
        return redirect()->to(base_url('Artikel'));
    }

    public function uploadGambar()
    {
        if ($this->request->getFile('file')) {
            $dataFile = $this->request->getFile('file');
            $fileName = $dataFile->getRandomName();
            $dataFile->move("uploaded/summernote/", $fileName);
            echo base_url("uploaded/summernote/$fileName");
        }
    }

    public function deleteGambar()
    {
        $src = $this->request->getVar('src');
        if ($src) {
            $file_name = str_replace(base_url(), "", $src);
            if (unlink($file_name)) {
                echo "Delete file berhasil";
            }
        }
    }

    function listGambar()
    {
        $files = array_filter(glob('uploaded/summernote/*'), 'is_file');
        $response = [];
        foreach ($files as $file) {
            if (strpos($file, "index.html")) {
                continue;
            }
            $response[] = basename($file);
        }
        header("Content-Type:application/json");
        echo json_encode($response);
        die();
    }

    public function Kategori()
    {
        $data = [
            'judul'         => 'Kategori Artikel',
            'menu'          => 'artikel',
            'submenu'       => 'kategori-artikel',
            'page'          => 'admin/artikel/v_kategori_artikel',
            'kat_artikel'   => $this->ModelArtikel->AllDataKategori(),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function InsertKategori()
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'nama' => [
                'label' => 'Nama',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 100 karakter',
                ]
            ],
        ])) {
            $data = [
                'nama' => esc($this->request->getPost('nama')),
            ];
            $this->ModelArtikel->InsertKategori($data);
            session()->setFlashdata('info', 'Data kategori artikel berhasil ditambahkan!');
            return redirect()->to(base_url('Artikel/Kategori'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Artikel/Kategori'));
        }
    }

    public function EditKategori($id_kat_artikel)
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'nama' => [
                'label' => 'Nama',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 100 karakter',
                ]
            ],
        ])) {
            $data = [
                'id_kat_artikel' => $id_kat_artikel,
                'nama' => esc($this->request->getPost('nama')),
            ];
            $this->ModelArtikel->EditKategori($data);
            session()->setFlashdata('info', 'Data kategori artikel berhasil diubah!');
            return redirect()->to(base_url('Artikel/Kategori'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Artikel/Kategori'))->withInput();
        }
    }

    public function DeleteKategori($id_kat_artikel)
    {
        try {
            $data = [
                'id_kat_artikel' => $id_kat_artikel,
            ];
            $this->ModelArtikel->DeleteKategori($data);
            session()->setFlashdata('info', 'Data kategori artikel berhasil dihapus!');
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            if ($e->getCode() == 1451) {
                session()->setFlashdata('errors_relation', 'Data kategori artikel tidak bisa dihapus karena masih berelasi dengan data artikel');
            } else {
                session()->setFlashdata('errors_relation', 'Terjadi kesalahan saat mencoba menghapus data: ' . $e->getMessage());
            }
        }
        return redirect()->to(base_url('Artikel/Kategori'));
    }
}
