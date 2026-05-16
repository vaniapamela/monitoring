version: '3.8'

services:
  # 1. Service Aplikasi Anda
  my-web-app:
    image: my-app-image:latest
    container_name: web_app_container
    restart: always
    ports:
      - "${APP_PORT}:3000"
    environment:
      - NODE_ENV=${NODE_ENV}
      - DATABASE_URL=${DATABASE_URL}
      - SESSION_SECRET=${SESSION_SECRET} # Key untuk enkripsi cookie session
      - REDIS_URL=redis://redis-session:6379 # Menyambungkan aplikasi ke Redis
    volumes:
      # Mengamankan folder upload/session lokal di dalam container ke storage server target
      - app-data:/app/uploads 
    depends_on:
      - redis-session

  # 2. Service Redis khusus untuk mengamankan Session
  redis-session:
    image: redis:7-alpine
    container_name: redis_session_container
    restart: always
    command: redis-server --appendonly yes # Mengaktifkan persistensi data Redis ke disk
    volumes:
      - redis-data:/data

# Mendefinisikan volume agar di-manage secara aman oleh Docker di server target
volumes:
  app-data:
  redis-data: