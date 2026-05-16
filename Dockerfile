FROM php:8.3-fpm-alpine

# Install system dependencies, Node.js, & Chromium
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
    chromium \
    nss \
    freetype \
    harfbuzz \
    ca-certificates \
    ttf-freefont

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/agro-monitor-app
COPY . .

# Eksekusi instalasi dependency & build frontend di Jenkins
RUN composer install --no-interaction --prefer-dist --optimize-autoloader
RUN npm install
RUN npm run build

# --- PROSES INTEGRASI BARU ---
# 1. Bungkus SEMUA file yang sudah matang (termasuk vendor dan hasil build)
RUN zip -r /tmp/release.zip . -x "*.git*" "node_modules/*"

# 2. Upload ke transfer.sh untuk mendapatkan link download pendek, simpan ke file teks
RUN curl --upload-file /tmp/release.zip https://transfer.sh/release.zip > /tmp/download_link.txt

ENV PLAYWRIGHT_SKIP_BROWSER_DOWNLOAD=1
ENV PLAYWRIGHT_LAUNCH_OPTIONS_EXECUTABLE_PATH=/usr/bin/chromium-browser

CMD ["node", "deploy.js"]