# Docker Setup untuk SIMAK Kampus

## Prerequisites
- Docker
- Docker Compose

## Installation

### 1. Clone Repository
```bash
git clone <repository-url>
cd SIMAK-polteksi
```

### 2. Setup Environment
```bash
cp .env.docker .env
```

### 3. Run Containers
```bash
docker compose up -d
```

### 4. Wait for setup to complete (3-5 minutes)
Container akan otomatis install PHP extensions (mysqli, pdo_mysql, mbstring, zip, gd, intl) dan set permissions.

**PENTING**: Tunggu sampai proses selesai sebelum mengakses aplikasi!

### 5. Monitor Installation Progress
```bash
# Cek log untuk melihat progress
docker compose logs -f app

# Cek status container
docker ps

# Tunggu sampai melihat pesan "Apache/2.4.x configured -- resuming normal operations"
```

### 6. Verify Installation
```bash
# Test akses aplikasi
curl -I http://localhost:8081

# Atau buka di browser: http://localhost:8081
```

## Access Points

- **Aplikasi SIMAK**: http://localhost:8081
- **phpMyAdmin**: http://localhost:8080
- **MySQL**: localhost:3307

## Database Credentials

- **Host**: mysql (internal) / localhost:3307 (external)
- **Database**: ci4
- **Username**: simas
- **Password**: simas123
- **Root Password**: root

## Default Login

| Role | Email | Password |
|------|-------|----------|
| Super Admin | admin@kampus.ac.id | password |
| Admin | admin2@kampus.ac.id | password |
| Petugas | petugas@kampus.ac.id | password |
| Mahasiswa | mahasiswa@kampus.ac.id | password |
| Dosen | dosen@kampus.ac.id | password |

## Troubleshooting

### Jika container tidak bisa start:
```bash
docker compose down
docker compose up -d
```

### Jika ada error MySQLi constant:
```bash
# Restart container untuk install ulang extensions
docker compose down
docker compose up -d
# Tunggu 3-5 menit untuk proses selesai
```

### Jika ada error permission:
```bash
docker exec -it simas_app chmod -R 777 writable/
```

### Jika database kosong:
1. Import database melalui phpMyAdmin (http://localhost:8080)
2. Upload file `database/simak_kampus.sql`

### Stop containers:
```bash
docker compose down
```

### View logs:
```bash
docker compose logs -f app
```

## Development

Semua perubahan code akan langsung ter-reflect karena menggunakan volume mounting.

Untuk debugging, akses container:
```bash
docker exec -it simas_app bash
```