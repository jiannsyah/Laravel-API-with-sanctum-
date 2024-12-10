# Gunakan image FrankenPHP resmi
FROM dunglas/frankenphp

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install ekstensi PHP tambahan (sesuaikan dengan kebutuhan)
RUN install-php-extensions \
    pdo_mysql \
    pcntl \
    mbstring \
    bcmath \
    exif \
    gd

# Set working directory
WORKDIR /app

# Salin semua file aplikasi Laravel ke dalam container
COPY . /app

# Install dependencies Laravel menggunakan Composer
RUN composer install --optimize-autoloader --no-dev

# Optimisasi konfigurasi Laravel
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Jalankan Laravel Octane menggunakan FrankenPHP
ENTRYPOINT ["php", "artisan", "octane:frankenphp"]
