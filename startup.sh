#!/bin/bash
set -e

echo "Starting ORION AI..."

# Set default environment variables
export APP_ENV=${APP_ENV:-production}
export APP_DEBUG=${APP_DEBUG:-false}
export APP_KEY=${APP_KEY:-base64:PBwp3zlKEBHPv1/s+B9/DdEGmM1LVM09WdC8jFkQs6A=}

# Parse DATABASE_URL if it exists
if [ ! -z "$DATABASE_URL" ]; then
    echo "Configuring database from DATABASE_URL..."
    export DB_CONNECTION=mysql
    export DB_HOST=$(echo $DATABASE_URL | sed -e 's/.*@\(.*\):.*/\1/')
    export DB_PORT=$(echo $DATABASE_URL | sed -e 's/.*:\([0-9]*\)\/.*/\1/')
    export DB_DATABASE=$(echo $DATABASE_URL | sed -e 's/.*\/\(.*\)/\1/')
    export DB_USERNAME=$(echo $DATABASE_URL | sed -e 's/.*:\/\/\(.*\):.*/\1/')
    export DB_PASSWORD=$(echo $DATABASE_URL | sed -e 's/.*:\/\/.*:\(.*\)@.*/\1/')
fi

# Clear caches
echo "Clearing caches..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true

# Create storage link
echo "Creating storage link..."
php artisan storage:link || true

# Wait for database and run migrations
echo "Running migrations..."
php artisan migrate --force || echo "Migration failed, continuing..."

# Set proper permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

echo "Starting Apache..."
# Start Apache
apache2-foreground