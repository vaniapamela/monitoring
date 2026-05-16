import { chromium } from "playwright";

(async () => {
  // --- INISIALISASI BROWSER DAN GERBANG TERMINAL SCHOLAIR ---
  const browser = await chromium.launch({
    headless: true,
    executablePath:
      process.env.PLAYWRIGHT_LAUNCH_OPTIONS_EXECUTABLE_PATH ||
      "/usr/bin/chromium-browser",
    args: ["--no-sandbox", "--disable-setuid-sandbox"],
  });

  const context = await browser.newContext({
    httpCredentials: { username: "sija", password: "sijagaot123" },
  });

  const page = await context.newPage();

  try {
    console.log("Menghubungi pintu gerbang terminal...");
    await page.goto("https://terminal.scholair.my.id/");
    await page.waitForLoadState("networkidle");

    console.log("Berhasil masuk ke terminal...");

    // 1. Melakukan SSH ke Server Target
    console.log("Melakukan SSH ke server target 192.168.200.23...");
    await page.keyboard.type("ssh root@192.168.200.23\n");
    await page.waitForTimeout(3000);
    await page.keyboard.type("admin123\n");
    await page.waitForTimeout(5000); // Beri waktu ekstra sampai prompt root@ourstudy muncul

    console.log("=== BERHASIL MASUK KE SERVER TARGET via SSH ===");

    // --- LANGKAH 2: MASUK FOLDER & GIT PULL ---
    console.log("2. Berpindah direktori dan melakukan Git Pull...");
    await page.keyboard.type("cd /var/www/agro-monitor-app\n");
    await page.waitForTimeout(1000);
    await page.keyboard.type("git pull origin main\n");
    await page.waitForTimeout(10000); // Tunggu proses tarik kode dari repo selesai

    // --- LANGKAH 3: NODE BUILD FRONTEND (npm install & run build) ---
    console.log("3. Menginstal dependency Node.js dan compile aset (Build)...");
    await page.keyboard.type("npm install\n");
    await page.waitForTimeout(20000); // Beri jeda waktu proses download node_modules
    await page.keyboard.type("npm run build\n");
    await page.waitForTimeout(15000); // Tunggu kompilasi Vite/Mix selesai

    // --- LANGKAH 4: MANAJEMEN CONFIG ENVIRONMENT (.env) ---
    console.log(
      "4. Menyalin konfigurasi .env.production menjadi .env aktif...",
    );
    await page.keyboard.type(
      "if [ -f .env.production ]; then cp .env.production .env; fi\n",
    );
    await page.waitForTimeout(1500);

    // --- LANGKAH 5: SETTING PERMISSION KETAT & AMAN ---
    console.log("5. Menerapkan hak akses file & folder (www-data:www-data)...");
    // Menyerahkan kepemilikan total ke Apache
    await page.keyboard.type(
      "chown -R www-data:www-data /var/www/agro-monitor-app\n",
    );
    await page.waitForTimeout(1500);
    // Folder diubah ke 755
    await page.keyboard.type(
      "find /var/www/agro-monitor-app -type d -exec chmod 755 {} \\;\n",
    );
    await page.waitForTimeout(2000);
    // File diubah ke 644 (Database aman dari write pihak luar)
    await page.keyboard.type(
      "find /var/www/agro-monitor-app -type f -exec chmod 644 {} \\;\n",
    );
    await page.waitForTimeout(2000);

    // --- LANGKAH 6: MEMBERSIHKAN CACHE SECARA AMAN ---
    console.log("6. Membuang cache usang secara fisik dan melalui Artisan...");
    // Buang file cache config/views secara paksa agar tidak bentrok
    await page.keyboard.type(
      "rm -f bootstrap/cache/config.php bootstrap/cache/services.php bootstrap/cache/packages.php\n",
    );
    await page.waitForTimeout(1000);
    await page.keyboard.type("rm -f storage/framework/views/*.php\n");
    await page.waitForTimeout(1000);
    // Jalankan optimize:clear menggunakan user www-data
    await page.keyboard.type("sudo -u www-data php artisan optimize:clear\n");
    await page.waitForTimeout(3000);

    // --- LANGKAH 7: EKSEKUSI MIGRASI DATABASE SQLITE ---
    console.log("7. Menjalankan migrasi database SQLite secara otomatis...");
    // Memakai --force agar tidak memicu konfirmasi manual (Y/n) di production
    await page.keyboard.type("sudo -u www-data php artisan migrate --force\n");
    await page.waitForTimeout(4000);

    // --- LANGKAH 8: PENGHAPUSAN SENSITIF FILE (SELF-DESTRUCT) ---
    console.log(
      "8. Menghapus jejak file deploy.js dari server target demi keamanan...",
    );
    await page.keyboard.type("rm -f /var/www/agro-monitor-app/deploy.js\n");
    await page.waitForTimeout(1500);

    // --- LANGKAH 9: CLOSE CONNECTION SSH ---
    console.log("9. Keluar dari sesi SSH server target...");
    await page.keyboard.type("exit\n");
    await page.waitForTimeout(1000);

    console.log(
      "=== 🎉 DEPLOYMENT SELESAI, DATABASE TER-MIGRASI & JEJAK AMAN ===",
    );
  } catch (error) {
    console.error(
      "❌ Proses deployment terhenti karena error: ",
      error.message,
    );
  } finally {
    // Memastikan browser ditutup agar RAM Jenkins tidak jebol
    await browser.close();
  }
})();
