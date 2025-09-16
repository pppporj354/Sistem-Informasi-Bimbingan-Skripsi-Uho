

FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install library yang dibutuhkan sistem
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libonig-dev \
    libzip-dev

# Bersihkan cache apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install ekstensi PHP yang dibutuhkan Laravel
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# --- BAGIAN PERBAIKAN ---
# Install Composer menggunakan metode resmi
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"
# --- AKHIR BAGIAN PERBAIKAN ---

# Buat user untuk aplikasi Laravel
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Salin file composer terlebih dahulu untuk caching
COPY --chown=www:www composer.json composer.lock ./

# Install dependensi vendor (ini akan membuat folder /vendor)
# --no-interaction: jangan tanya apa-apa
# --optimize-autoloader: optimasi untuk production
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Salin sisa file aplikasi
COPY --chown=www:www . .

# Ubah user ke www
USER www

# Expose port dan jalankan php-fpm
EXPOSE 9000
CMD ["php-fpm"]
