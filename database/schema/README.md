# Database Schema

## Tables Overview

### Core Tables
- `tb_users` - User management dengan role-based access
- `tb_level_user` - User roles dan permissions
- `tb_setting` - Konfigurasi aplikasi

### Academic Tables
- `tb_mahasiswa` - Data mahasiswa
- `tb_dosen` - Data dosen
- `tb_mata_kuliah` - Master mata kuliah
- `tb_jadwal_kuliah` - Jadwal perkuliahan

### Content Management
- `tb_artikel` - Artikel dan berita
- `tb_kategori_artikel` - Kategori artikel
- `tb_kegiatan` - Kegiatan dan pengumuman

### Financial Management
- `tb_keuangan_internal` - Kas internal kampus
- `tb_beasiswa` - Data beasiswa

### Asset Management
- `tb_inventaris` - Inventaris kampus

### Communication
- `tb_pengaduan` - Sistem pengaduan mahasiswa

## Setup Instructions

1. Buat database MySQL
2. Import file SQL atau jalankan migrations
3. Jalankan seeders untuk data sample
4. Update konfigurasi di .env

## Default Data

Seeder akan membuat:
- User admin dengan berbagai role
- Sample data untuk testing
- Konfigurasi dasar aplikasi