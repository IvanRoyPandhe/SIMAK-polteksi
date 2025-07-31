#!/bin/bash

echo "=== Database Migration Script ==="
echo "⚠️  WARNING: This will REPLACE your current database!"
echo "Current data will be backed up but the database will be reset."
echo ""
read -p "Are you sure you want to continue? (yes/no): " confirm

if [ "$confirm" != "yes" ]; then
    echo "Migration cancelled."
    exit 1
fi

echo "Proceeding with migration..."

# Database configuration
DB_HOST="mysql"
DB_NAME="ci4"
DB_USER="root"
DB_PASS="root"
BACKUP_FILE="ci4_backup_$(date +%Y%m%d_%H%M%S).sql"

# Backup current database
echo "Creating backup of current database..."
if docker exec simas_mysql mysqldump -u${DB_USER} -p${DB_PASS} ${DB_NAME} > ${BACKUP_FILE}; then
    echo "✅ Backup created: ${BACKUP_FILE}"
else
    echo "❌ Backup failed! Aborting migration."
    exit 1
fi

# Drop and recreate database
echo "Dropping current database..."
if docker exec simas_mysql mysql -u${DB_USER} -p${DB_PASS} -e "DROP DATABASE IF EXISTS ${DB_NAME};"; then
    echo "✅ Old database dropped"
else
    echo "❌ Failed to drop database"
    exit 1
fi

echo "Creating new database..."
if docker exec simas_mysql mysql -u${DB_USER} -p${DB_PASS} -e "CREATE DATABASE ${DB_NAME} CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;"; then
    echo "✅ New database created"
else
    echo "❌ Failed to create database"
    exit 1
fi

# Import optimized schema
echo "Importing optimized database schema..."
if docker exec -i simas_mysql mysql -u${DB_USER} -p${DB_PASS} ${DB_NAME} < ci4_optimized.sql; then
    echo "✅ Schema imported successfully"
else
    echo "❌ Failed to import schema"
    echo "Restoring from backup..."
    docker exec -i simas_mysql mysql -u${DB_USER} -p${DB_PASS} -e "CREATE DATABASE ${DB_NAME};"
    docker exec -i simas_mysql mysql -u${DB_USER} -p${DB_PASS} ${DB_NAME} < ${BACKUP_FILE}
    echo "Database restored from backup"
    exit 1
fi

echo ""
echo "🎉 Database migration completed successfully!"
echo "📁 Backup saved as: ${BACKUP_FILE}"
echo "🔑 Default login: admin@kampus.ac.id / password"