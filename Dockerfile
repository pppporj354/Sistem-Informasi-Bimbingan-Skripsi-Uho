
FROM php:8.3-fpm-alpine AS builder

# Menentukan direktori kerja di dalam kontainer
WORKDIR /app

# Instalasi ekstensi dan paket yang dibutuhkan oleh Laravel & Composer
RUN apk add --no-cache \
    curl \
    sqlite-dev \
    libzip-dev \
    libpng-dev \
    oniguruma-dev \
    freetype-dev \
    jpeg-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_sqlite pdo_mysql gd mbstring zip ctype

# Instal Composer secara global
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Salin semua file proyek ke direktori kerja
COPY . .

# Jalankan 'composer install' untuk mengunduh semua package dari vendor
# Tidak menggunakan flag --no-dev agar seeder bisa berjalan jika dibutuhkan
RUN composer install

# --- STAGE KEDUA: PRODUKSI ---
# Menggunakan image PHP yang bersih dan ringan untuk menjalankan aplikasi
FROM php:8.3-fpm-alpine

# Menentukan direktori kerja utama untuk aplikasi
WORKDIR /var/www/html

# Salin semua file yang sudah di-build dari stage 'builder'
COPY --from=builder /app /var/www/html


RUN mkdir -p database && \
    touch database/database.sqlite && \
    chown -R www-data:www-data storage bootstrap/cache database

# Perintah default untuk menjalankan container ini adalah memulai PHP-FPM
CMD ["php-fpm"]
