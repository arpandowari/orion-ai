#!/bin/bash

# Parse DATABASE_URL if it exists (Railway format)
if [ ! -z "$DATABASE_URL" ]; then
    # Extract database credentials from DATABASE_URL
    # Format: mysql://user:password@host:port/database
    
    export DB_CONNECTION=mysql
    export DB_HOST=$(echo $DATABASE_URL | sed -e 's/.*@\(.*\):.*/\1/')
    export DB_PORT=$(echo $DATABASE_URL | sed -e 's/.*:\([0-9]*\)\/.*/\1/')
    export DB_DATABASE=$(echo $DATABASE_URL | sed -e 's/.*\/\(.*\)/\1/')
    export DB_USERNAME=$(echo $DATABASE_URL | sed -e 's/.*:\/\/\(.*\):.*/\1/')
    export DB_PASSWORD=$(echo $DATABASE_URL | sed -e 's/.*:\/\/.*:\(.*\)@.*/\1/')
fi

# Clear caches
php artisan config:clear
php artisan cache:clear

# Create storage link (ignore if exists)
php artisan storage:link || true

# Ensure logo directory exists
mkdir -p storage/app/public/logo

# Set proper permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Run migrations
php artisan migrate --force

# Start server
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
