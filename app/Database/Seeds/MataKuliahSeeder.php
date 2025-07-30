<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MataKuliahSeeder extends Seeder
{
    public function run()
    {
        $mata_kuliah = [
            // SEMESTER 1 - 21 SKS
            ['kode_matkul' => 'MK101', 'nama_matkul' => 'Matematika Dasar I', 'sks' => 3, 'semester' => 1, 'prodi_id' => 1],
            ['kode_matkul' => 'MK102', 'nama_matkul' => 'Fisika Dasar I', 'sks' => 3, 'semester' => 1, 'prodi_id' => 1],
            ['kode_matkul' => 'MK103', 'nama_matkul' => 'Kimia Dasar', 'sks' => 3, 'semester' => 1, 'prodi_id' => 1],
            ['kode_matkul' => 'MK104', 'nama_matkul' => 'Bahasa Indonesia', 'sks' => 2, 'semester' => 1, 'prodi_id' => 1],
            ['kode_matkul' => 'MK105', 'nama_matkul' => 'Bahasa Inggris I', 'sks' => 2, 'semester' => 1, 'prodi_id' => 1],
            ['kode_matkul' => 'MK106', 'nama_matkul' => 'Pendidikan Pancasila', 'sks' => 2, 'semester' => 1, 'prodi_id' => 1],
            ['kode_matkul' => 'MK107', 'nama_matkul' => 'Gambar Teknik', 'sks' => 3, 'semester' => 1, 'prodi_id' => 1],
            ['kode_matkul' => 'MK108', 'nama_matkul' => 'Pengenalan Teknologi', 'sks' => 3, 'semester' => 1, 'prodi_id' => 1],

            // SEMESTER 2 - 21 SKS
            ['kode_matkul' => 'MK201', 'nama_matkul' => 'Matematika Dasar II', 'sks' => 3, 'semester' => 2, 'prodi_id' => 1],
            ['kode_matkul' => 'MK202', 'nama_matkul' => 'Fisika Dasar II', 'sks' => 3, 'semester' => 2, 'prodi_id' => 1],
            ['kode_matkul' => 'MK203', 'nama_matkul' => 'Mekanika Teknik I', 'sks' => 3, 'semester' => 2, 'prodi_id' => 1],
            ['kode_matkul' => 'MK204', 'nama_matkul' => 'Material Teknik', 'sks' => 3, 'semester' => 2, 'prodi_id' => 1],
            ['kode_matkul' => 'MK205', 'nama_matkul' => 'Bahasa Inggris II', 'sks' => 2, 'semester' => 2, 'prodi_id' => 1],
            ['kode_matkul' => 'MK206', 'nama_matkul' => 'Pendidikan Agama', 'sks' => 2, 'semester' => 2, 'prodi_id' => 1],
            ['kode_matkul' => 'MK207', 'nama_matkul' => 'Praktikum Fisika', 'sks' => 2, 'semester' => 2, 'prodi_id' => 1],
            ['kode_matkul' => 'MK208', 'nama_matkul' => 'Workshop Dasar', 'sks' => 3, 'semester' => 2, 'prodi_id' => 1],

            // SEMESTER 3 - 21 SKS
            ['kode_matkul' => 'MK301', 'nama_matkul' => 'Matematika Teknik', 'sks' => 3, 'semester' => 3, 'prodi_id' => 1],
            ['kode_matkul' => 'MK302', 'nama_matkul' => 'Mekanika Teknik II', 'sks' => 3, 'semester' => 3, 'prodi_id' => 1],
            ['kode_matkul' => 'MK303', 'nama_matkul' => 'Termodinamika I', 'sks' => 3, 'semester' => 3, 'prodi_id' => 1],
            ['kode_matkul' => 'MK304', 'nama_matkul' => 'Mekanika Fluida I', 'sks' => 3, 'semester' => 3, 'prodi_id' => 1],
            ['kode_matkul' => 'MK305', 'nama_matkul' => 'Elektronika Dasar', 'sks' => 3, 'semester' => 3, 'prodi_id' => 1],
            ['kode_matkul' => 'MK306', 'nama_matkul' => 'Statistik Teknik', 'sks' => 2, 'semester' => 3, 'prodi_id' => 1],
            ['kode_matkul' => 'MK307', 'nama_matkul' => 'Praktikum Material', 'sks' => 2, 'semester' => 3, 'prodi_id' => 1],
            ['kode_matkul' => 'MK308', 'nama_matkul' => 'CAD Dasar', 'sks' => 2, 'semester' => 3, 'prodi_id' => 1],

            // SEMESTER 4 - 21 SKS
            ['kode_matkul' => 'MK401', 'nama_matkul' => 'Mesin Konversi Energi', 'sks' => 3, 'semester' => 4, 'prodi_id' => 1],
            ['kode_matkul' => 'MK402', 'nama_matkul' => 'Perpindahan Panas', 'sks' => 3, 'semester' => 4, 'prodi_id' => 1],
            ['kode_matkul' => 'MK403', 'nama_matkul' => 'Mekanika Fluida II', 'sks' => 3, 'semester' => 4, 'prodi_id' => 1],
            ['kode_matkul' => 'MK404', 'nama_matkul' => 'Proses Manufaktur I', 'sks' => 3, 'semester' => 4, 'prodi_id' => 1],
            ['kode_matkul' => 'MK405', 'nama_matkul' => 'Sistem Kontrol', 'sks' => 3, 'semester' => 4, 'prodi_id' => 1],
            ['kode_matkul' => 'MK406', 'nama_matkul' => 'Ekonomi Teknik', 'sks' => 2, 'semester' => 4, 'prodi_id' => 1],
            ['kode_matkul' => 'MK407', 'nama_matkul' => 'Praktikum Termodinamika', 'sks' => 2, 'semester' => 4, 'prodi_id' => 1],
            ['kode_matkul' => 'MK408', 'nama_matkul' => 'CAD Lanjut', 'sks' => 2, 'semester' => 4, 'prodi_id' => 1],

            // SEMESTER 5 - 21 SKS
            ['kode_matkul' => 'MK501', 'nama_matkul' => 'Mesin-Mesin Listrik', 'sks' => 3, 'semester' => 5, 'prodi_id' => 1],
            ['kode_matkul' => 'MK502', 'nama_matkul' => 'Proses Manufaktur II', 'sks' => 3, 'semester' => 5, 'prodi_id' => 1],
            ['kode_matkul' => 'MK503', 'nama_matkul' => 'Getaran Mekanik', 'sks' => 3, 'semester' => 5, 'prodi_id' => 1],
            ['kode_matkul' => 'MK504', 'nama_matkul' => 'Elemen Mesin I', 'sks' => 3, 'semester' => 5, 'prodi_id' => 1],
            ['kode_matkul' => 'MK505', 'nama_matkul' => 'Sistem Pneumatik', 'sks' => 3, 'semester' => 5, 'prodi_id' => 1],
            ['kode_matkul' => 'MK506', 'nama_matkul' => 'Manajemen Industri', 'sks' => 2, 'semester' => 5, 'prodi_id' => 1],
            ['kode_matkul' => 'MK507', 'nama_matkul' => 'Praktikum Manufaktur', 'sks' => 2, 'semester' => 5, 'prodi_id' => 1],
            ['kode_matkul' => 'MK508', 'nama_matkul' => 'Metodologi Penelitian', 'sks' => 2, 'semester' => 5, 'prodi_id' => 1],

            // SEMESTER 6 - 21 SKS
            ['kode_matkul' => 'MK601', 'nama_matkul' => 'Elemen Mesin II', 'sks' => 3, 'semester' => 6, 'prodi_id' => 1],
            ['kode_matkul' => 'MK602', 'nama_matkul' => 'Sistem Hidrolik', 'sks' => 3, 'semester' => 6, 'prodi_id' => 1],
            ['kode_matkul' => 'MK603', 'nama_matkul' => 'Otomasi Industri', 'sks' => 3, 'semester' => 6, 'prodi_id' => 1],
            ['kode_matkul' => 'MK604', 'nama_matkul' => 'Perawatan Mesin', 'sks' => 3, 'semester' => 6, 'prodi_id' => 1],
            ['kode_matkul' => 'MK605', 'nama_matkul' => 'CNC Programming', 'sks' => 3, 'semester' => 6, 'prodi_id' => 1],
            ['kode_matkul' => 'MK606', 'nama_matkul' => 'K3 Industri', 'sks' => 2, 'semester' => 6, 'prodi_id' => 1],
            ['kode_matkul' => 'MK607', 'nama_matkul' => 'Praktikum Sistem Kontrol', 'sks' => 2, 'semester' => 6, 'prodi_id' => 1],
            ['kode_matkul' => 'MK608', 'nama_matkul' => 'Seminar Proposal', 'sks' => 2, 'semester' => 6, 'prodi_id' => 1],

            // SEMESTER 7 - 21 SKS
            ['kode_matkul' => 'MK701', 'nama_matkul' => 'Kerja Praktek', 'sks' => 4, 'semester' => 7, 'prodi_id' => 1],
            ['kode_matkul' => 'MK702', 'nama_matkul' => 'Robotika Industri', 'sks' => 3, 'semester' => 7, 'prodi_id' => 1],
            ['kode_matkul' => 'MK703', 'nama_matkul' => 'Sistem Produksi', 'sks' => 3, 'semester' => 7, 'prodi_id' => 1],
            ['kode_matkul' => 'MK704', 'nama_matkul' => 'Teknologi Ramah Lingkungan', 'sks' => 3, 'semester' => 7, 'prodi_id' => 1],
            ['kode_matkul' => 'MK705', 'nama_matkul' => 'Kewirausahaan', 'sks' => 2, 'semester' => 7, 'prodi_id' => 1],
            ['kode_matkul' => 'MK706', 'nama_matkul' => 'Mata Kuliah Pilihan I', 'sks' => 3, 'semester' => 7, 'prodi_id' => 1],
            ['kode_matkul' => 'MK707', 'nama_matkul' => 'Mata Kuliah Pilihan II', 'sks' => 3, 'semester' => 7, 'prodi_id' => 1],

            // SEMESTER 8 - 21 SKS
            ['kode_matkul' => 'MK801', 'nama_matkul' => 'Tugas Akhir', 'sks' => 6, 'semester' => 8, 'prodi_id' => 1],
            ['kode_matkul' => 'MK802', 'nama_matkul' => 'Manajemen Proyek', 'sks' => 3, 'semester' => 8, 'prodi_id' => 1],
            ['kode_matkul' => 'MK803', 'nama_matkul' => 'Audit Energi', 'sks' => 3, 'semester' => 8, 'prodi_id' => 1],
            ['kode_matkul' => 'MK804', 'nama_matkul' => 'Teknologi Terbaru', 'sks' => 3, 'semester' => 8, 'prodi_id' => 1],
            ['kode_matkul' => 'MK805', 'nama_matkul' => 'Etika Profesi', 'sks' => 2, 'semester' => 8, 'prodi_id' => 1],
            ['kode_matkul' => 'MK806', 'nama_matkul' => 'Mata Kuliah Pilihan III', 'sks' => 2, 'semester' => 8, 'prodi_id' => 1],
            ['kode_matkul' => 'MK807', 'nama_matkul' => 'Mata Kuliah Pilihan IV', 'sks' => 2, 'semester' => 8, 'prodi_id' => 1],

            // PRODI 2 - TEKNIK INFORMATIKA
            // SEMESTER 1 - 21 SKS
            ['kode_matkul' => 'TI101', 'nama_matkul' => 'Matematika Diskrit', 'sks' => 3, 'semester' => 1, 'prodi_id' => 2],
            ['kode_matkul' => 'TI102', 'nama_matkul' => 'Algoritma Pemrograman', 'sks' => 3, 'semester' => 1, 'prodi_id' => 2],
            ['kode_matkul' => 'TI103', 'nama_matkul' => 'Pengantar Teknologi Informasi', 'sks' => 3, 'semester' => 1, 'prodi_id' => 2],
            ['kode_matkul' => 'TI104', 'nama_matkul' => 'Bahasa Indonesia', 'sks' => 2, 'semester' => 1, 'prodi_id' => 2],
            ['kode_matkul' => 'TI105', 'nama_matkul' => 'Bahasa Inggris I', 'sks' => 2, 'semester' => 1, 'prodi_id' => 2],
            ['kode_matkul' => 'TI106', 'nama_matkul' => 'Pendidikan Pancasila', 'sks' => 2, 'semester' => 1, 'prodi_id' => 2],
            ['kode_matkul' => 'TI107', 'nama_matkul' => 'Logika Informatika', 'sks' => 3, 'semester' => 1, 'prodi_id' => 2],
            ['kode_matkul' => 'TI108', 'nama_matkul' => 'Praktikum Algoritma', 'sks' => 3, 'semester' => 1, 'prodi_id' => 2],

            // SEMESTER 2 - 21 SKS
            ['kode_matkul' => 'TI201', 'nama_matkul' => 'Struktur Data', 'sks' => 3, 'semester' => 2, 'prodi_id' => 2],
            ['kode_matkul' => 'TI202', 'nama_matkul' => 'Pemrograman Berorientasi Objek', 'sks' => 3, 'semester' => 2, 'prodi_id' => 2],
            ['kode_matkul' => 'TI203', 'nama_matkul' => 'Sistem Digital', 'sks' => 3, 'semester' => 2, 'prodi_id' => 2],
            ['kode_matkul' => 'TI204', 'nama_matkul' => 'Matematika Komputasi', 'sks' => 3, 'semester' => 2, 'prodi_id' => 2],
            ['kode_matkul' => 'TI205', 'nama_matkul' => 'Bahasa Inggris II', 'sks' => 2, 'semester' => 2, 'prodi_id' => 2],
            ['kode_matkul' => 'TI206', 'nama_matkul' => 'Pendidikan Agama', 'sks' => 2, 'semester' => 2, 'prodi_id' => 2],
            ['kode_matkul' => 'TI207', 'nama_matkul' => 'Praktikum Struktur Data', 'sks' => 2, 'semester' => 2, 'prodi_id' => 2],
            ['kode_matkul' => 'TI208', 'nama_matkul' => 'Praktikum OOP', 'sks' => 3, 'semester' => 2, 'prodi_id' => 2],

            // PRODI 3 - TEKNIK ELEKTRO (Sample beberapa semester)
            // SEMESTER 1 - 21 SKS
            ['kode_matkul' => 'TE101', 'nama_matkul' => 'Matematika Teknik I', 'sks' => 3, 'semester' => 1, 'prodi_id' => 3],
            ['kode_matkul' => 'TE102', 'nama_matkul' => 'Fisika Listrik', 'sks' => 3, 'semester' => 1, 'prodi_id' => 3],
            ['kode_matkul' => 'TE103', 'nama_matkul' => 'Rangkaian Listrik I', 'sks' => 3, 'semester' => 1, 'prodi_id' => 3],
            ['kode_matkul' => 'TE104', 'nama_matkul' => 'Bahasa Indonesia', 'sks' => 2, 'semester' => 1, 'prodi_id' => 3],
            ['kode_matkul' => 'TE105', 'nama_matkul' => 'Bahasa Inggris I', 'sks' => 2, 'semester' => 1, 'prodi_id' => 3],
            ['kode_matkul' => 'TE106', 'nama_matkul' => 'Pendidikan Pancasila', 'sks' => 2, 'semester' => 1, 'prodi_id' => 3],
            ['kode_matkul' => 'TE107', 'nama_matkul' => 'Gambar Teknik Listrik', 'sks' => 3, 'semester' => 1, 'prodi_id' => 3],
            ['kode_matkul' => 'TE108', 'nama_matkul' => 'Praktikum Rangkaian', 'sks' => 3, 'semester' => 1, 'prodi_id' => 3],

            // PRODI 4 - TEKNIK SIPIL (Sample beberapa semester)
            // SEMESTER 1 - 21 SKS
            ['kode_matkul' => 'TS101', 'nama_matkul' => 'Matematika Teknik I', 'sks' => 3, 'semester' => 1, 'prodi_id' => 4],
            ['kode_matkul' => 'TS102', 'nama_matkul' => 'Fisika Teknik', 'sks' => 3, 'semester' => 1, 'prodi_id' => 4],
            ['kode_matkul' => 'TS103', 'nama_matkul' => 'Kimia Teknik', 'sks' => 3, 'semester' => 1, 'prodi_id' => 4],
            ['kode_matkul' => 'TS104', 'nama_matkul' => 'Bahasa Indonesia', 'sks' => 2, 'semester' => 1, 'prodi_id' => 4],
            ['kode_matkul' => 'TS105', 'nama_matkul' => 'Bahasa Inggris I', 'sks' => 2, 'semester' => 1, 'prodi_id' => 4],
            ['kode_matkul' => 'TS106', 'nama_matkul' => 'Pendidikan Pancasila', 'sks' => 2, 'semester' => 1, 'prodi_id' => 4],
            ['kode_matkul' => 'TS107', 'nama_matkul' => 'Gambar Teknik Sipil', 'sks' => 3, 'semester' => 1, 'prodi_id' => 4],
            ['kode_matkul' => 'TS108', 'nama_matkul' => 'Pengenalan Konstruksi', 'sks' => 3, 'semester' => 1, 'prodi_id' => 4],
        ];

        $this->db->table('tb_mata_kuliah')->insertBatch($mata_kuliah);
    }
}