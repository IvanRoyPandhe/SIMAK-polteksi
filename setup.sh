#!/bin/bash

echo "Setting up CodeIgniter 4 project..."

# Create writable directories
mkdir -p writable/cache writable/session writable/logs writable/uploads writable/debugbar

# Set permissions
chmod -R 777 writable/

# Copy environment file if not exists
if [ ! -f .env ]; then
    cp .env.example .env
    echo "Please configure your .env file"
fi

echo "Setup completed!"