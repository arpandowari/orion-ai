FROM php:8.2-cli

WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy composer files
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy application
COPY . .

# Set permissions
RUN mkdir -p storage/framework/{sessions,views,cache} \
    storage/logs \
    storage/app/public \
    bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Create entrypoint script
RUN echo '#!/bin/bash\n\
set -e\n\
\n\
# Set defaults\n\
export PORT=${PORT:-8080}\n\
export APP_ENV=${APP_ENV:-production}\n\
export APP_DEBUG=${APP_DEBUG:-false}\n\
\n\
# Parse DATABASE_URL\n\
if [ ! -z "$DATABASE_URL" ]; then\n\
    export DB_CONNECTION=mysql\n\
    export DB_HOST=$(echo $DATABASE_URL | sed "s/.*@\\([^:]*\\):.*/\\1/")\n\
    export DB_PORT=$(echo $DATABASE_URL | sed "s/.*:\\([0-9]*\\)\\/.*/\\1/")\n\
    export DB_DATABASE=$(echo $DATABASE_URL | sed "s/.*\\/\\(.*\\)/\\1/")\n\
    export DB_USERNAME=$(echo $DATABASE_URL | sed "s/.*:\\/\\/\\([^:]*\\):.*/\\1/")\n\
    export DB_PASSWORD=$(echo $DATABASE_URL | sed "s/.*:\\/\\/[^:]*:\\([^@]*\\)@.*/\\1/")\n\
fi\n\
\n\
# Clear caches\n\
php artisan config:clear || true\n\
php artisan cache:clear || true\n\
\n\
# Create storage link\n\
php artisan storage:link || true\n\
\n\
# Run migrations\n\
php artisan migrate --force || echo "Migration failed"\n\
\n\
# Start server\n\
php artisan serve --host=0.0.0.0 --port=$PORT\n\
' > /usr/local/bin/start.sh && chmod +x /usr/local/bin/start.sh

EXPOSE 8080

CMD ["/usr/local/bin/start.sh"]
