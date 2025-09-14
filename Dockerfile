
FROM php:8.2-fpm-alpine

# Install PHP extensions yang diperlukan oleh Laravel
# sqlite-dev adalah paket yang diperlukan untuk ekstensi pdo_sqlite
RUN apk add --no-cache \
    curl \
    sqlite-dev \
    libzip-dev \
    libpng-dev \
    oniguruma-dev \
    && docker-php-ext-install pdo_sqlite pdo_mysql gd mbstring zip ctype

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory di dalam container
WORKDIR /var/www/html

# Salin composer.json dan composer.lock untuk menginstal dependensi
COPY composer.json composer.lock ./

# Instal dependensi PHP
RUN composer install --no-dev --optimize-autoloader

# Salin semua kode aplikasi
COPY . .

# Buat direktori storage/framework jika belum ada dan berikan izin yang tepat
RUN mkdir -p storage storage/framework storage/framework/sessions storage/framework/views storage/framework/cache public/storage \
    && chown -R www-data:www-data storage bootstrap/cache

# Menjalankan artisan command untuk setup
# Karena ini portfolio, kita langsung migrasi dan seed
# Perintah ini akan dijalankan saat container dibuat pertama kali
CMD php artisan migrate --force && php artisan db:seed && php-fpm
