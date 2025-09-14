# Gunakan image PHP resmi versi 8.3 sebagai base image
FROM php:8.3-fpm-alpine

# Install PHP extensions yang diperlukan oleh Laravel
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

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory di dalam container
WORKDIR /var/www/html

# Salin file-file yang dibutuhkan Composer sebelum menginstal dependensi
COPY composer.json composer.lock ./
COPY app/ app/
COPY bootstrap/ bootstrap/

# Instal dependensi PHP
RUN composer install --no-dev --optimize-autoloader

# Salin sisa semua kode aplikasi
COPY . .

# Buat direktori storage/framework jika belum ada dan berikan izin yang tepat
RUN mkdir -p storage storage/framework storage/framework/sessions storage/framework/views storage/framework/cache public/storage \
    && chown -R www-data:www-data storage bootstrap/cache

# Menjalankan artisan command untuk setup
CMD php artisan migrate --force && php artisan db:seed && php-fpm
