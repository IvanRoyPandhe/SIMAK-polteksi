# 🚀 Setup Aplikasi SIMAK (Sistem Informasi Manajemen Kampus)

## Persyaratan
- Docker & Docker Compose
- PHP 8.1+
- Composer

## Cara Setup

### 1. Clone & Setup
```bash
# Masuk ke direktori proyek
cd ci4-sistem-manajemen-kampus

# Jalankan setup otomatis
./setup.sh
```

### 2. Manual Setup (Alternatif)
```bash
# Start database
docker-compose up -d

# Install dependencies
composer install

# Set permissions
chmod -R 755 writable/ public/uploaded/

# Start aplikasi
php spark serve
```

## Akses Aplikasi

- **Aplikasi**: http://localhost:8082 (atau port yang tersedia)
- **phpMyAdmin**: http://localhost:8080
- **Database**: 127.0.0.1:3306

## Database Credentials

- **Host**: localhost
- **Port**: 3306
- **Username**: root
- **Password**: root
- **Database**: ci4

## Troubleshooting

### Port sudah digunakan
```bash
# Ubah port di docker-compose.yml
# MySQL: "3307:3306"
# phpMyAdmin: "8081:80"
```

### Permission error
```bash
sudo chmod -R 755 writable/
sudo chmod -R 755 public/uploaded/
```

### Database tidak terbuat
```bash
# Import manual via phpMyAdmin atau:
mysql -h localhost -u root -proot < database/init.sql
```