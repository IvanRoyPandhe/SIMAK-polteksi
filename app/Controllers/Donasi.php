<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ModelDonasi;
use App\Models\ModelKasInternal;

class Donasi extends BaseController
{
    protected $ModelDonasi;
    protected $ModelKasInternal;

    public function __construct()
    {
        $this->ModelDonasi = new ModelDonasi();
        $this->ModelKasInternal = new ModelKasInternal();
    }

    public function index()
    {
        // 
    }

    public function Rekening()
    {
        $data = [
            'judul'     => 'Rekening',
            'menu'      => 'donasi',
            'submenu'   => 'donasi-rekening',
            'page'      => 'admin/donasi/v_rekening',
            'rekening'  => $this->ModelDonasi->AllData(),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function InsertRekening()
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'nama_bank' => [
                'label' => 'Nama Bank',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 100 karakter',
                ]
            ],
            'no_rek' => [
                'label' => 'No. Rekening',
                'rules' => 'required|max_length[25]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 25 karakter',
                ]
            ],
            'nama_rek' => [
                'label' => 'Nama Rekening',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 100 karakter',
                ]
            ],
        ])) {
            $data = [
                'nama_bank' => esc($this->request->getPost('nama_bank')),
                'no_rek'    => esc($this->request->getPost('no_rek')),
                'nama_rek'  => esc($this->request->getPost('nama_rek')),
                'user_id'   => session()->get('user_id'),
            ];
            $this->ModelDonasi->InsertData($data);
            session()->setFlashdata('info', 'Data rekening berhasil ditambahkan!');
            return redirect()->to(base_url('Donasi/Rekening'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Donasi/Rekening'));
        }
    }

    public function EditRekening($id_rekening)
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'nama_bank' => [
                'label' => 'Nama Bank',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 100 karakter',
                ]
            ],
            'no_rek' => [
                'label' => 'No. Rekening',
                'rules' => 'required|max_length[25]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 25 karakter',
                ]
            ],
            'nama_rek' => [
                'label' => 'Nama Rekening',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 100 karakter',
                ]
            ],
        ])) {
            $data = [
                'id_rekening' => $id_rekening,
                'nama_bank' => esc($this->request->getPost('nama_bank')),
                'no_rek' => esc($this->request->getPost('no_rek')),
                'nama_rek' => esc($this->request->getPost('nama_rek')),
                'user_id' => session()->get('user_id'),
            ];
            $this->ModelDonasi->EditData($data);
            session()->setFlashdata('info', 'Data rekening berhasil diubah!');
            return redirect()->to(base_url('Donasi/Rekening'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('Donasi/Rekening'));
        }
    }

    public function DeleteRekening($id_rekening)
    {
        try {
            $data = [
                'id_rekening' => $id_rekening,
            ];
            $this->ModelDonasi->DeleteData($data);
            session()->setFlashdata('info', 'Data rekening berhasil dihapus!');
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            if ($e->getCode() == 1451) {
                session()->setFlashdata('errors_relation', 'Data rekening tidak bisa dihapus karena masih berelasi dengan data donasi');
            } else {
                session()->setFlashdata('errors_relation', 'Terjadi kesalahan saat mencoba menghapus data: ' . $e->getMessage());
            }
        }
        return redirect()->to(base_url('Donasi/Rekening'));
    }

    public function ValidasiDonasiMasuk($id_donasi)
    {
        $donasi = $this->ModelDonasi->DonasiMasukById($id_donasi);
        $data = [
            'tgl'           => date('Y-m-d'),
            'dana_masuk'    => $donasi['jumlah'],
            'dana_keluar'   => 0,
            'kategori'      => 'Donasi Masuk',
            'keterangan'    => 'Donasi dari ' . $donasi['nama_p'],
            'status'        => 'Masuk',
            'user_id'       => session()->get('user_id'),
        ];
        $this->ModelKasInternal->InsertData($data);
        $this->ModelDonasi->UpdateDonasiStatus($id_donasi, 'Validated');
        session()->setFlashdata('info', 'Donasi berhasil divalidasi dan ditambahkan ke kas!');
        return redirect()->to(base_url('Donasi/DonasiMasuk'));
    }

    public function DeleteDonasiMasuk($id_donasi)
    {
        $donasi = $this->ModelDonasi->DonasiMasukById($id_donasi);
        if ($donasi && isset($donasi['bukti_transfer'])) {
            $filePath = 'uploaded/bukti_transfer/' . $donasi['bukti_transfer'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $data = [
            'id_donasi' => $id_donasi,
        ];
        $this->ModelDonasi->DeleteDonasiMasuk($data);
        session()->setFlashdata('info', 'Data donasi dan bukti transfer berhasil dihapus!');
        return redirect()->to(base_url('Donasi/DonasiMasuk'));
    }

    public function DonasiMasuk()
    {
        $data = [
            'judul'         => 'Donasi Tunai',
            'menu'          => 'donasi',
            'submenu'       => 'donasi-masuk',
            'page'          => 'admin/donasi/v_donasi_masuk.php',
            'donasi'        => $this->ModelDonasi->AllDataDonasi(),
            'donasibarang'  => $this->ModelDonasi->AllDataDonasiBarang(),
        ];
        $data['user'] = $this->user;
        return view('v_template_admin', $data);
    }

    public function InsertDonasiBarang()
    {
        $validation = \Config\Services::validation();
        if ($this->validate([
            'nama_barang' => [
                'label' => 'Nama Barang',
                'rules' => 'required|max_length[150]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 50 karakter',
                ]
            ],
            'nama_p' => [
                'label' => 'Donatur',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 100 karakter',
                ]
            ],
            'penerima' => [
                'label' => 'Penerima',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 100 karakter',
                ]
            ],
            'bukti' => [
                'label' => 'Gambar Bukti',
                'rules' => 'uploaded[bukti]|max_size[bukti,10000]|mime_in[bukti,image/png,image/jpg,image/jpeg]',
                'errors' => [
                    'uploaded' => '{field} tidak boleh kosong, silakan pilih file gambar.',
                    'max_size' => '{field} ukuran maksimal 10MB',
                    'mime_in' => '{field} hanya bisa mengirim format gambar',
                ],
            ],
        ])) {
            $bukti = $this->request->getFile('bukti');
            $file_bukti = $bukti->getRandomName();
            $bukti->move('uploaded/bukti_transfer', $file_bukti);
            $data = [
                'nama_barang'       => esc($this->request->getPost('nama_barang')),
                'nama_p'            => esc($this->request->getPost('nama_p')),
                'penerima'          => esc($this->request->getPost('penerima')),
                'bukti_transfer'    => $file_bukti,
                'jenis'             => 'Barang',
            ];
            $this->ModelDonasi->InsertDonasiBarang($data);
            session()->setFlashdata('info_db', 'Data donasi barang berhasil ditambahkan!');
            return redirect()->to(base_url('Donasi/DonasiMasuk/' . '#donasibarang'));
        } else {
            session()->setFlashdata('errors_db', $validation->getErrors());
            return redirect()->to(base_url('Donasi/DonasiMasuk/' . '#donasibarang'))->withInput();
        }
    }

    public function EditDonasiBarang()
    {
        $id_donasi = $this->request->getPost('id_donasi');
        $validation = \Config\Services::validation();
        if ($this->validate([
            'nama_barang' => [
                'label' => 'Nama Barang',
                'rules' => 'required|max_length[150]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 50 karakter',
                ]
            ],
            'nama_p' => [
                'label' => 'Donatur',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 100 karakter',
                ]
            ],
            'penerima' => [
                'label' => 'Penerima',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'max_length' => '{field} tidak boleh lebih dari 100 karakter',
                ]
            ],
            'bukti' => [
                'label' => 'Gambar Bukti',
                'rules' => 'max_size[bukti,10000]|mime_in[bukti,image/png,image/jpg,image/jpeg]',
                'errors' => [
                    'max_size' => '{field} ukuran maksimal 10MB',
                    'mime_in' => '{field} hanya bisa mengirim format gambar',
                ],
            ],
        ])) {
            $data = [
                'id_donasi'     => $id_donasi,
                'nama_barang'   => esc($this->request->getPost('nama_barang')),
                'nama_p'        => esc($this->request->getPost('nama_p')),
                'penerima'      => esc($this->request->getPost('penerima')),
                'jenis'         => 'Barang',
            ];
            $bukti_transfer = $this->request->getFile('bukti');
            if ($bukti_transfer && $bukti_transfer->isValid()) {
                $bukti = $this->ModelDonasi->find($id_donasi);
                $old_bukti_transfer = $bukti['bukti_transfer'];
                if ($old_bukti_transfer && $old_bukti_transfer !== 'avatar.png' && file_exists('uploaded/bukti_transfer/' . $old_bukti_transfer)) {
                    unlink('uploaded/bukti_transfer/' . $old_bukti_transfer);
                }
                $file_bukti_transfer = $bukti_transfer->getRandomName();
                $bukti_transfer->move('uploaded/bukti_transfer', $file_bukti_transfer);
                $data['bukti_transfer'] = $file_bukti_transfer;
            }
            $this->ModelDonasi->EditDonasiBarang($id_donasi, $data);
            session()->setFlashdata('info_db', 'Data donasi barang berhasil diperbarui');
            return redirect()->to(base_url('Donasi/DonasiMasuk/' . '#donasibarang'));
        } else {
            session()->setFlashdata('errors_db', $validation->getErrors());
            return redirect()->to(base_url('Donasi/DonasiMasuk/' . '#donasibarang'))->withInput();
        }
    }

    public function DeleteDonasiMasukBarang($id_donasi)
    {
        $donasi = $this->ModelDonasi->DonasiMasukById($id_donasi);
        if ($donasi && isset($donasi['bukti_transfer'])) {
            $filePath = 'uploaded/bukti_transfer/' . $donasi['bukti_transfer'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $data = [
            'id_donasi' => $id_donasi,
        ];
        $this->ModelDonasi->DeleteDonasiMasukBarang($data);
        session()->setFlashdata('info_donasi_db', 'Data donasi barang dan bukti transfer berhasil dihapus!');
        return redirect()->to(base_url('Donasi/DonasiMasuk/' . '#donasibarang'));
    }
}
