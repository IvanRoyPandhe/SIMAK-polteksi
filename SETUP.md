# Setup Instructions for PHP 8.3+ / 8.4

## Quick Fix for PHP Compatibility Error

### 1. Fix Permissions
```bash
chmod -R 777 writable/
```

### 2. Update CodeIgniter
```bash
composer update codeigniter4/framework
```

### 3. Alternative - Disable Cache Temporarily
Edit `app/Config/Cache.php`:
```php
public string $handler = 'dummy'; // Change from 'file' to 'dummy'
```

### 4. Run Application
```bash
php spark serve
```

## Docker Alternative (Recommended)
```bash
docker-compose up -d
# Access phpMyAdmin at http://localhost:8080
```

## Database Setup
1. Import `database/simak_kampus.sql` to MySQL
2. Update `.env` with database credentials
3. Run seeders if needed:
```bash
php spark db:seed DatabaseSeeder
```

## Default Login
- Admin: admin@kampus.ac.id / password
- Mahasiswa: mahasiswa@kampus.ac.id / password  
- Dosen: dosen@kampus.ac.id / password