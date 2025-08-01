<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelInventaris extends Model
{
    public function AllDataMasuk()
    {
        return $this->db->table('tb_inventaris')
            ->where('status', 0)
            ->where('jumlah >', 0)
            ->orderBy('created_at DESC')
            ->get()->getResultArray();
    }

    public function AllDatakeluar()
    {
        return $this->db->table('tb_inventaris')
            ->where('status', 1)
            ->orderBy('created_at DESC')
            ->get()->getResultArray();
    }

    public function countByKategori($kategori)
    {
        return $this->db->table('tb_inventaris')
            ->where('kategori', $kategori)
            ->countAllResults();
    }

    public function InsertData($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->table('tb_inventaris')->insert($data);
    }

    public function EditData($data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->table('tb_inventaris')
            ->where('id_inventaris', $data['id_inventaris'])
            ->update($data);
    }

    public function DeleteData($data)
    {
        $this->db->table('tb_inventaris')
            ->where('id_inventaris', $data['id_inventaris'])
            ->delete($data);
    }

    public function getNamaBarangMasuk()
    {
        $result = $this->db->table('tb_inventaris')
            ->select('nama_barang')
            ->where('status', 0)
            ->where('jumlah >', 0)
            ->groupBy('nama_barang')
            ->get()->getResultArray();
        
        // Transform to expected format
        $transformed = [];
        foreach ($result as $row) {
            $transformed[] = ['nama' => $row['nama_barang']];
        }
        return $transformed;
    }

    public function getInventarisByNama($nama)
    {
        return $this->db->table('tb_inventaris')
            ->where('nama_barang', $nama)
            ->where('status', 0)
            ->where('jumlah >', 0)
            ->get()
            ->getRowArray();
    }

    public function insertDataKeluarTransaction($dataKeluar, $dataUpdate)
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $existingKeluar = $this->db->table('tb_inventaris')
                ->where('nama', $dataKeluar['nama'])
                ->where('harga', $dataKeluar['harga'])
                ->where('satuan', $dataKeluar['satuan'])
                ->where('kategori', $dataKeluar['kategori'])
                ->where('kondisi', $dataKeluar['kondisi'])
                ->where('keterangan', $dataKeluar['keterangan'])
                ->where('status', 1)
                ->get()
                ->getRowArray();
            if ($existingKeluar) {
                $updatedJumlah = $existingKeluar['jumlah'] + $dataKeluar['jumlah'];
                $this->db->table('tb_inventaris')
                    ->where('id_inventaris', $existingKeluar['id_inventaris'])
                    ->update([
                        'jumlah' => $updatedJumlah,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
            } else {
                $dataKeluar['created_at'] = date('Y-m-d H:i:s');
                $dataKeluar['updated_at'] = date('Y-m-d H:i:s');
                $this->db->table('tb_inventaris')->insert($dataKeluar);
            }
            if ($dataUpdate['jumlah'] <= 0) {
                $this->db->table('tb_inventaris')
                    ->where('id_inventaris', $dataUpdate['id_inventaris'])
                    ->delete();
            } else {
                $dataUpdate['updated_at'] = date('Y-m-d H:i:s');
                $this->db->table('tb_inventaris')
                    ->where('id_inventaris', $dataUpdate['id_inventaris'])
                    ->update($dataUpdate);
            }
            if ($db->transStatus() === false) {
                $db->transRollback();
                return false;
            }
            $db->transCommit();
            return true;
        } catch (\Exception $e) {
            $db->transRollback();
            return false;
        }
    }
}
