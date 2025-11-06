#!/bin/bash
set -e

echo "Starting ORION AI deployment..."

# Parse DATABASE_URL if it exists (Railway format)
if [ ! -z "$DATABASE_URL" ]; then
    echo "Parsing DATABASE_URL..."
    # Extract database credentials from DATABASE_URL
    # Format: mysql://user:password@host:port/database
    
    export DB_CONNECTION=mysql
    export DB_HOST=$(echo $DATABASE_URL | sed -e 's/.*@\(.*\):.*/\1/')
    export DB_PORT=$(echo $DATABASE_URL | sed -e 's/.*:\([0-9]*\)\/.*/\1/')
    export DB_DATABASE=$(echo $DATABASE_URL | sed -e 's/.*\/\(.*\)/\1/')
    export DB_USERNAME=$(echo $DATABASE_URL | sed -e 's/.*:\/\/\(.*\):.*/\1/')
    export DB_PASSWORD=$(echo $DATABASE_URL | sed -e 's/.*:\/\/.*:\(.*\)@.*/\1/')
    
    echo "Database configured: $DB_HOST:$DB_PORT/$DB_DATABASE"
fi

# Set required environment variables with defaults
export APP_ENV=${APP_ENV:-production}
export APP_DEBUG=${APP_DEBUG:-false}
export APP_KEY=${APP_KEY:-base64:PBwp3zlKEBHPv1/s+B9/DdEGmM1LVM09WdC8jFkQs6A=}

echo "Environment: $APP_ENV, Debug: $APP_DEBUG"

# Ensure directories exist and set permissions
echo "Setting up directories and permissions..."
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views  
mkdir -p storage/framework/cache
mkdir -p storage/logs
mkdir -p storage/app/public/logo
mkdir -p bootstrap/cache

chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Clear caches
echo "Clearing caches..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true
php artisan route:clear || true

# Create storage link (ignore if exists)
echo "Creating storage link..."
php artisan storage:link || true

# Wait for database to be ready
echo "Waiting for database connection..."
for i in {1..30}; do
    if php artisan migrate:status > /dev/null 2>&1; then
        echo "Database connection successful"
        break
    fi
    echo "Waiting for database... ($i/30)"
    sleep 2
done

# Run migrations
echo "Running migrations..."
php artisan migrate --force

echo "Starting server on port ${PORT:-8080}..."
# Start server
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
