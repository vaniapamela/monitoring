import playwright from "playwright";

(async () => {
  // 1. Inisialisasi browser headless
  const browser = await playwright.chromium.launch({
    executablePath: "/usr/bin/chromium-browser",
    args: ["--no-sandbox", "--disable-setuid-sandbox"],
  });
  const page = await browser.newPage();

  // URL Web SSH / Terminal Server kamu (Sesuaikan jika ada token/port khusus)
  await page.goto("http://192.168.200.23");
  await page.waitForTimeout(3000); // Tunggu terminal siap

  console.log("=== MEMULAI OTOMATISASI DEPLOYMENT DI SERVER TARGET ===");

  // --- LANGKAH 1: PREPARASI FOLDER & GIT PULL ---
  console.log("1. Memeriksa direktori dan melakukan Git Pull...");
  const repoUrl = "https://github.com/vaniapamela/monitoring.git"; // <-- SESUAIKAN URL REPO KAMU

  // Membuat folder jika belum ada, init git jika kosong, lalu lakukan pull
  await page.keyboard.type(
    `mkdir -p /var/www/agro-monitor-app && cd /var/www/agro-monitor-app && [ ! -d .git ] && git init && git remote add origin ${repoUrl} || true\n`,
  );
  await page.waitForTimeout(2000);
  await page.keyboard.type("git pull origin main || git pull origin master\n");
  await page.waitForTimeout(8000); // Jeda waktu tarik data dari internet

  // --- LANGKAH 2: MANAJEMEN ENVIRONMENT FILE (.env) ---
  console.log("2. Menyetel file environment (.env.production -> .env)...");
  // Cari .env.production, jika ada salin menjadi .env. Jika tidak ada, buat dari .env.example
  await page.keyboard.type(
    "if [ -f .env.production ]; then cp .env.production .env; elif [ -f .env.example ]; then cp .env.example .env; fi\n",
  );
  await page.waitForTimeout(1500);

  // --- LANGKAH 3: SETTING PERMISSION AMAN & PRESISI (STANDAR PRODUCTION) ---
  console.log("3. Menerapkan hak akses ketat (chown & chmod 755/644)...");
  // Setel owner utama seluruh project ke www-data (Apache)
  await page.keyboard.type(
    "chown -R www-data:www-data /var/www/agro-monitor-app\n",
  );
  await page.waitForTimeout(1000);
  // Folder hanya bisa ditulis oleh Owner (755)
  await page.keyboard.type(
    "find /var/www/agro-monitor-app -type d -exec chmod 755 {} \\;\n",
  );
  await page.waitForTimeout(1500);
  // File hanya bisa ditulis oleh Owner (644)
  await page.keyboard.type(
    "find /var/www/agro-monitor-app -type f -exec chmod 644 {} \\;\n",
  );
  await page.waitForTimeout(1500);

  // --- LANGKAH 4: EKSEKUSI LARAVEL ARTISAN SEBAGAI WWW-DATA ---
  console.log("4. Menjalankan optimasi dan migrasi database Laravel...");
  // Bersihkan cache lama secara paksa terlebih dahulu
  await page.keyboard.type(
    "rm -f bootstrap/cache/config.php bootstrap/cache/services.php bootstrap/cache/packages.php\n",
  );
  await page.waitForTimeout(1000);

  // Jalankan optimize:clear menyamar sebagai www-data agar file cache baru tidak dimiliki oleh root
  await page.keyboard.type("sudo -u www-data php artisan optimize:clear\n");
  await page.waitForTimeout(2000);

  // Jalankan migrasi database sebagai www-data (Menghindari isu readonly pada SQLite)
  await page.keyboard.type("sudo -u www-data php artisan migrate --force\n");
  await page.waitForTimeout(3000);

  // --- LANGKAH 5: PENGHAPUSAN JEJAK SENSITIF (SELF-DESTRUCT) ---
  console.log(
    "5. Menghapus file deploy.js dari server target demi keamanan...",
  );
  // Menghapus file deploy.js jika entah bagaimana dia ter-copy atau berada di root project server target
  await page.keyboard.type("rm -f /var/www/agro-monitor-app/deploy.js\n");
  await page.waitForTimeout(1000);

  console.log("=== 🎉 DEPLOYMENT SELESAI & JEJAK BERHASIL DIHAUS ===");

  await browser.close();
})();
