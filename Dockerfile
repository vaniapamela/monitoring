FROM alpine:3.19

# Hanya instal Node.js, Chromium, dan font untuk kebutuhan Playwright Robot
RUN apk add --no-cache \
    nodejs \
    npm \
    chromium \
    nss \
    freetype \
    harfbuzz \
    ca-certificates \
    ttf-freefont

WORKDIR /app

# Set variabel agar Playwright membaca Chromium lokal Alpine (Biar gak download ulang)
ENV PLAYWRIGHT_SKIP_BROWSER_DOWNLOAD=1
ENV PLAYWRIGHT_LAUNCH_OPTIONS_EXECUTABLE_PATH=/usr/bin/chromium-browser

# Instal Playwright langsung di dalam container robot
RUN npm install playwright

# Copy file robot deploy.js ke dalam container
COPY deploy.js .

# Biarkan container standby atau langsung trigger script
CMD ["node", "deploy.js"]