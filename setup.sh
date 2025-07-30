#!/bin/bash

echo "🎓 Setting up SIMAK (Sistem Informasi Manajemen Kampus)"
echo "================================================="

# Start Docker services
echo "📦 Starting Docker services..."
docker compose up -d

# Wait for MySQL to be ready
echo "⏳ Waiting for MySQL to be ready..."
sleep 15

# Install PHP dependencies
echo "📚 Installing PHP dependencies..."
composer install

# Set permissions
echo "🔐 Setting permissions..."
chmod -R 777 writable/
chmod -R 755 public/uploaded/

# Create required directories
mkdir -p writable/cache writable/logs writable/session writable/uploads
mkdir -p public/uploaded/bukti_transfer
mkdir -p public/uploaded/profil_user
mkdir -p public/uploaded/lampiran_pengaduan
mkdir -p public/uploaded/summernote
mkdir -p public/uploaded/thumbnail_artikel

echo "✅ Setup completed!"
echo ""
echo "🚀 To start the application:"
echo "   php spark serve --port=8081"
echo "   or"
echo "   php spark serve --host=0.0.0.0 --port=8081"
echo ""
echo "🌐 Access points:"
echo "   Application: http://localhost:8081 (or any port you use)"
echo "   phpMyAdmin:  http://localhost:8080"
echo "   MySQL:       localhost:3307"
echo ""
echo "🔑 Database credentials:"
echo "   Username: root"
echo "   Password: root"
echo "   Database: ci4"
echo ""
echo "👤 Login credentials:"
echo "   Email: admin@kampus.ac.id"
echo "   Password: password"