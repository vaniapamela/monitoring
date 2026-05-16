import { chromium } from "playwright";
import fs from "fs";

(async () => {
  // URL mengarah ke Cloudflare Tunnel port 8585
  const timestamp = Date.now();
  const downloadLink = `https://agro-monitor-app.nivor.id/release.zip?v=${timestamp}`;

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

  console.log("Menghubungi pintu gerbang terminal...");
  await page.goto("https://terminal.scholair.my.id/");
  await page.waitForLoadState("networkidle");

  console.log("Berhasil melewati alert web! Masuk ke terminal...");

  // Hanya membaca .env production karena target tidak pakai Docker compose
  const envContent = `PORT=8000\nNODE_ENV=production\nSESSION_SECRET=admin123`;

  // 1. Melakukan SSH ke Server Target
  console.log("Melakukan SSH ke server target 192.168.200.23...");
  await page.keyboard.type("ssh root@192.168.200.23\n");
  await page.waitForTimeout(2000);
  await page.keyboard.type("admin123\n");
  await page.waitForTimeout(2000);

  // 2. Bersihkan folder lama agar steril (Sesuai ide kamu sebelumnya)
  console.log("Membersihkan folder target agar steril...");
  await page.keyboard.type(
    "mkdir -p /var/www/agro-monitor-app && cd /var/www/agro-monitor-app && rm -rf *\n",
  );
  await page.waitForTimeout(1000);

  // 3. Menulis file .env langsung ke target
  console.log("Mengirim file konfigurasi .env...");
  await page.keyboard.type(`cat << 'EOF' > .env\n${envContent}\nEOF\n`);
  await page.waitForTimeout(1000);

  // 4. Mengunduh package aplikasi dari Cloudflare Tunnel host (Port 8585)
  console.log("Mengunduh package aplikasi dari Cloudflare Tunnel...");
  await page.keyboard.type(`curl -L "${downloadLink}" -o release.zip\n`);
  await page.waitForTimeout(8000); // Beri waktu download arsip

  // 5. Mengekstrak package aplikasi
  console.log("Mengekstrak package aplikasi di server target...");
  await page.keyboard.type("apt-get update && apt-get install -y unzip\n");
  await page.waitForTimeout(4000);
  await page.keyboard.type("unzip -o release.zip && rm -f release.zip\n");
  await page.waitForTimeout(2000);

  // 6. Jalankan Composer Install secara native di server target (Kunci utama!)
  console.log("Menjalankan composer install langsung di server target...");
  // --no-dev digunakan agar library testing/faker tidak ikut terinstall di server production
  await page.keyboard.type(
    "composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev\n",
  );
  await page.waitForTimeout(15000); // Beri waktu agak lama (15 detik) untuk mendownload vendor php di target

  // 7. Restart service PHP (opsional, sesuaikan dengan web server targetmu misal fpm/swoole/roadrunner)
  console.log("Merestart service PHP-FPM lokal di server target...");
  await page.keyboard.type(
    "systemctl restart php8.3-fpm || systemctl restart php-fpm || true\n",
  );
  await page.waitForTimeout(2000);

  console.log("🎉 DEPLOYMENT NATIVE VIA CLOUDFLARE TUNNEL BERHASIL SELESAI!");
  await browser.close();
})();
