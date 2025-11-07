FROM php:8.2-cli

WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy files
COPY . .

# Install PHP dependencies
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Set permissions
RUN chmod -R 775 storage bootstrap/cache

# Create start script with better error handling
RUN printf '#!/bin/bash\n\
set -e\n\
echo "Starting ORION AI..."\n\
\n\
# Set defaults\n\
export PORT=${PORT:-8080}\n\
export APP_ENV=${APP_ENV:-production}\n\
export APP_DEBUG=${APP_DEBUG:-false}\n\
\n\
# Parse DATABASE_URL if exists\n\
if [ -n "$DATABASE_URL" ]; then\n\
  echo "Parsing DATABASE_URL..."\n\
  export DB_CONNECTION=mysql\n\
  export DB_HOST=$(echo $DATABASE_URL | sed "s/mysql:\\/\\/.*@\\([^:]*\\):.*/\\1/")\n\
  export DB_PORT=$(echo $DATABASE_URL | sed "s/.*:\\([0-9]*\\)\\/.*/\\1/")\n\
  export DB_DATABASE=$(echo $DATABASE_URL | sed "s/.*\\/\\([^?]*\\).*/\\1/")\n\
  export DB_USERNAME=$(echo $DATABASE_URL | sed "s/mysql:\\/\\/\\([^:]*\\):.*/\\1/")\n\
  export DB_PASSWORD=$(echo $DATABASE_URL | sed "s/mysql:\\/\\/[^:]*:\\([^@]*\\)@.*/\\1/")\n\
  echo "Database: $DB_HOST:$DB_PORT/$DB_DATABASE"\n\
fi\n\
\n\
# Clear caches\n\
echo "Clearing caches..."\n\
php artisan config:clear || true\n\
php artisan cache:clear || true\n\
php artisan view:clear || true\n\
\n\
# Create storage link\n\
echo "Creating storage link..."\n\
php artisan storage:link || true\n\
\n\
# Run migrations\n\
echo "Running migrations..."\n\
php artisan migrate --force || echo "Migrations failed, continuing..."\n\
\n\
# Start server\n\
echo "Starting server on port $PORT..."\n\
php artisan serve --host=0.0.0.0 --port=$PORT\n\
' > /start.sh && chmod +x /start.sh

EXPOSE 8080

CMD ["/start.sh"]
