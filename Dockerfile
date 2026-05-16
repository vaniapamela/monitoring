FROM php:8.3-fpm-alpine

# Install system dependencies & Node.js 20
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    openssh-client \
    # Dependency untuk Playwright/Chromium Headless
    chromium \
    libnss3 \
    libatk-bridge2.0-0 \
    libx14-canvas-graphics \
    libgtk-3-0

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js 20.20.2 resmi via NodeSource
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

WORKDIR /app
COPY . .

# Jalankan instalasi backend & frontend sesuai instruksimu
RUN composer install --no-interaction --prefer-dist --optimize-autoloader
RUN npm install
RUN npm run build

# Beri tahu Playwright untuk menggunakan Chromium yang sudah terinstal di sistem
ENV PLAYWRIGHT_SKIP_BROWSER_DOWNLOAD=1
ENV PLAYWRIGHT_LAUNCH_OPTIONS_EXECUTABLE_PATH=/usr/bin/chromium

# Saat container jalan, dia langsung mengeksekusi robot deploy
CMD ["node", "deploy.js"]