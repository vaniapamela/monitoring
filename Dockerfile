FROM php:8.3-fpm-alpine

# Install system dependencies, Node.js, & Chromium menggunakan 'apk' bawaan Alpine
RUN apk update && apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    openssh-client \
    nodejs \
    npm \
    # Dependency & Browser Chromium Headless untuk Playwright
    chromium \
    nss \
    freetype \
    harfbuzz \
    ca-certificates \
    ttf-freefont

# Install PHP extensions bawaan docker-php
RUN docker-php-ext-install pdo_mysql bcmath gd

# Install Composer terbaru langsung
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# UBAH WORKDIR KE AGRO-MONITOR-APP
WORKDIR /var/www/agro-monitor-app
COPY . .

# Eksekusi instalasi dependency project & build frontend
RUN composer install --no-interaction --prefer-dist --optimize-autoloader
RUN npm install
RUN npm run build

# Beri tahu Playwright untuk menggunakan Chromium lokal bawaan Alpine
ENV PLAYWRIGHT_SKIP_BROWSER_DOWNLOAD=1
ENV PLAYWRIGHT_LAUNCH_OPTIONS_EXECUTABLE_PATH=/usr/bin/chromium-browser

# Jalankan robot deployment
CMD ["node", "deploy.js"]