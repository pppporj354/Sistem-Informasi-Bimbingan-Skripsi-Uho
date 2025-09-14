# -- STAGE PERTAMA: BUILDER --
# Gunakan image PHP versi 8.3 untuk menginstal dependensi
FROM php:8.3-fpm-alpine AS builder

# Set working directory
WORKDIR /app

# Instal dependensi PHP yang dibutuhkan
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

# Instal Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Salin semua file proyek untuk instalasi Composer
COPY . .

# Jalankan Composer install
RUN composer install --no-dev --optimize-autoloader

# -- STAGE KEDUA: PRODUKSI --
# Gunakan image PHP versi 8.3 yang bersih
FROM php:8.3-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# Salin semua file dan folder aplikasi dari stage 'builder'
COPY --from=builder /app /var/www/html

# Berikan izin yang benar untuk direktori storage dan cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Menjalankan artisan command untuk setup
CMD php artisan migrate --force && php artisan db:seed && php-fpm
