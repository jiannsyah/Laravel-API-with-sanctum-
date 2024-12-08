FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy seluruh aplikasi Laravel ke dalam container
COPY . .

# Install dependencies Laravel dalam mode produksi
RUN composer install --optimize-autoloader --no-dev

# Optimize Laravel
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Set permission untuk folder storage dan cache
RUN chmod -R 775 storage bootstrap/cache

# Expose port aplikasi
EXPOSE 8000

# Jalankan Laravel
CMD ["php-fpm"]