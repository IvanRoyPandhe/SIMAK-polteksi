# 🎓 SIMAK - Sistem Informasi Manajemen Kampus

![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=flat&logo=php&logoColor=white)
![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4.x-EF4223?style=flat&logo=codeigniter&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=flat&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=flat&logo=bootstrap&logoColor=white)

## 📌 Tentang Proyek

**SIMAK (Sistem Informasi Manajemen Kampus)** adalah aplikasi web yang dikembangkan untuk membantu pengelolaan kegiatan akademik, administrasi, dan layanan mahasiswa di lingkungan kampus secara digital dan terstruktur.

## ✨ Fitur Utama

### 🔐 Multi-Role Authentication
- **Super Admin** - Akses penuh ke semua fitur
- **Admin** - Manajemen data dan laporan
- **Petugas** - Operasional harian kampus
- **Mahasiswa** - Portal layanan mahasiswa

### 📊 Dashboard Role-Based
- Dashboard khusus untuk setiap role
- Real-time statistics dan analytics
- Quick actions dan shortcuts

### 🎓 Manajemen Akademik
- Data mahasiswa dan dosen
- Program studi dan mata kuliah
- Jadwal kuliah dan kegiatan akademik

### 💰 Manajemen Keuangan
- Kas internal kampus
- Laporan keuangan
- Tracking dana masuk dan keluar

### 🏆 Sistem Beasiswa
- Manajemen beasiswa kampus
- Tracking aplikasi mahasiswa
- Status dan notifikasi

### 📰 Sistem Informasi
- Artikel dan berita kampus
- Pengumuman dan kegiatan
- Galeri dan dokumentasi

### 🛠️ Manajemen Inventaris
- Tracking aset kampus
- Kondisi dan status barang
- Laporan inventaris

### 💬 Sistem Pengaduan
- Pengaduan khusus mahasiswa
- Tracking status pengaduan
- Response dari admin

## ⚙️ Teknologi yang Digunakan

- **Backend**: PHP 8.1+ dengan CodeIgniter 4
- **Database**: MySQL 8.0+
- **Frontend**: HTML5, CSS3, JavaScript ES6+
- **UI Framework**: Bootstrap 5.3
- **Admin Template**: AdminLTE & Mazer
- **Icons**: Font Awesome 6
- **Charts**: Chart.js
- **Editor**: Summernote WYSIWYG
- **Notifications**: SweetAlert2

## 🚀 Instalasi

### Prerequisites
- PHP 8.1 atau lebih tinggi
- MySQL 8.0 atau lebih tinggi
- Composer
- Web server (Apache/Nginx)

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/username/simak-kampus.git
   cd simak-kampus
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Setup Environment**
   ```bash
   cp .env.example .env
   ```
   Edit file `.env` sesuai konfigurasi database Anda.

4. **Setup Database**
   - Buat database MySQL
   - Import file `database/simak_kampus.sql`
   - Atau jalankan seeder:
   ```bash
   php spark db:seed DatabaseSeeder
   ```

5. **Set Permissions**
   ```bash
   chmod -R 777 writable/
   chmod -R 755 public/uploaded/
   ```

6. **Run Application**
   ```bash
   php spark serve --port=8081
   ```

7. **Akses Aplikasi**
   - URL: `http://localhost:8081`
   - Login dengan akun default (lihat seeder)

## 👤 Default Login

| Role | Email | Password |
|------|-------|----------|
| Super Admin | admin@kampus.ac.id | password |
| Admin | admin2@kampus.ac.id | password |
| Petugas | petugas@kampus.ac.id | password |
| Mahasiswa | mahasiswa@kampus.ac.id | password |

## 📁 Struktur Project

```
simak-kampus/
├── app/
│   ├── Controllers/     # Controllers untuk setiap modul
│   ├── Models/         # Models untuk database
│   ├── Views/          # Views dan templates
│   ├── Filters/        # Authentication filters
│   └── Config/         # Konfigurasi aplikasi
├── public/
│   ├── layouting/      # CSS, JS, dan assets
│   ├── pictures/       # Gambar dan media
│   └── uploaded/       # File upload
├── database/
│   ├── migrations/     # Database migrations
│   └── seeds/          # Database seeders
└── writable/           # Cache, logs, sessions
```

## 🔧 Konfigurasi

### Database
Edit file `.env`:
```env
database.default.hostname = localhost
database.default.database = simak_kampus
database.default.username = your_username
database.default.password = your_password
database.default.port = 3306
```

### Base URL
```env
app.baseURL = 'http://localhost:8081/'
```

## 🎨 Customization

### Tema Warna
Project menggunakan tema merah modern. Untuk mengubah warna:
1. Edit file `public/layouting/home-style.css`
2. Ganti variabel warna di dashboard views
3. Update gradient di template files

### Logo dan Branding
1. Ganti logo di `public/pictures/logos/`
2. Update favicon di `public/`
3. Edit branding text di views

## 📱 Responsive Design

Aplikasi fully responsive dan mobile-friendly:
- Bootstrap 5 grid system
- Mobile-first approach
- Touch-friendly interface
- Optimized untuk tablet dan smartphone

## 🔒 Security Features

- CSRF Protection
- XSS Prevention
- SQL Injection Protection
- Role-based Access Control
- Session Management
- Password Hashing (bcrypt)

## 🚀 Deployment

### Production Setup
1. Set environment ke production di `.env`
2. Disable debug mode
3. Setup proper web server configuration
4. Enable HTTPS
5. Setup backup database
6. Configure cron jobs untuk maintenance

### Docker (Optional)
```bash
docker-compose up -d
```

## 🤝 Contributing

1. Fork repository
2. Buat feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📝 Changelog

### Version 2.0.0
- ✅ Migrasi dari sistem masjid ke sistem kampus
- ✅ Role-based dashboard
- ✅ Tema merah modern
- ✅ Responsive design improvements
- ✅ Enhanced security

### Version 1.0.0
- ✅ Basic CRUD operations
- ✅ Authentication system
- ✅ Admin panel

## 📄 License

Project ini menggunakan [MIT License](LICENSE).

## 👥 Team

- **Developer**: [Your Name]
- **Contributor**: [Contributor Name]

## 📞 Support

Jika ada pertanyaan atau issue:
- Buat issue di GitHub
- Email: support@kampus.ac.id
- Documentation: [Wiki](https://github.com/username/simak-kampus/wiki)

---

**Made with ❤️ for Indonesian Higher Education**