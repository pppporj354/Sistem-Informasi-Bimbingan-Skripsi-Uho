# --- Tahap 1: Composer Stage ---
# Menggunakan image resmi Composer untuk menginstal dependensi
FROM composer:2 as vendor

# Menetapkan direktori kerja
WORKDIR /app

# Salin hanya file composer untuk caching dependensi
COPY database/ database/
COPY composer.json composer.json
COPY composer.lock composer.lock

# Jalankan composer install untuk mengunduh semua paket ke direktori vendor
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist \
    --optimize-autoloader \
    --no-dev

# --- Tahap 2: Production Stage ---
# Menggunakan image PHP-FPM yang ringan sebagai basis
FROM php:8.2-fpm-alpine

# Menetapkan direktori kerja
WORKDIR /var/www

# Menginstal ekstensi PHP yang umum dibutuhkan oleh Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Salin direktori vendor yang sudah diinstal dari tahap sebelumnya
COPY --from=vendor /app/vendor/ /var/www/vendor/

# Salin sisa kode aplikasi
COPY . /var/www/

# Mengatur kepemilikan file agar Nginx/PHP bisa menulis ke direktori storage
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Expose port yang digunakan oleh PHP-FPM
EXPOSE 9000