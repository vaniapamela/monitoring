# Gunakan PHP 8.3 FPM
FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js & NPM
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@10.8.2

# Set working directory
WORKDIR /var/www/mss-app

# Salin file project
COPY . .

# --- TAMBAHKAN INI AGAR JENKINS TIDAK ERROR ---
# Install PHP dependencies (Vendor)
RUN composer install --no-interaction --optimize-autoloader

# Install JS dependencies & Build (jika kamu pakai Vite/Tailwind)
# RUN npm install && npm run build
# ----------------------------------------------

# Berikan izin akses folder storage & cache
RUN chown -R www-data:www-data /var/www/agro-monitor-app/storage /var/www/agro-monitor-app/bootstrap/cache

# Port yang dibuka
EXPOSE 8000

# CMD hanya boleh SATU. Pilih artisan serve untuk staging.
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]