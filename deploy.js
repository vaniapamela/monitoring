import { chromium } from "playwright";
import fs from "fs";

(async () => {
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

  // 1. Siapkan data yang mau dikirim
  const composeContent = fs.readFileSync("docker-compose.yml", "utf8");
  const envContent = `PORT=8000\nNODE_ENV=production\nSESSION_SECRET=admin123`;

  // Membaca file zip hasil build dan mengubahnya ke teks Base64 agar bisa diketik robot
  const zipBase64 = fs.readFileSync("/tmp/release.zip").toString("base64");

  // 2. SSH masuk ke server target
  await page.keyboard.type("ssh root@192.168.200.23\n");
  await page.waitForTimeout(2000);
  await page.keyboard.type("admin123\n");
  await page.waitForTimeout(2000);

  console.log(
    "Sudah masuk sebagai root di 192.168.200.23. Mulai sinkronisasi file...",
  );

  // Masuk ke folder target
  await page.keyboard.type(
    "mkdir -p /var/www/agro-monitor-app && cd /var/www/agro-monitor-app\n",
  );
  await page.waitForTimeout(500);

  // Kirim file konfigurasi standar
  await page.keyboard.type(
    `cat << 'EOF' > docker-compose.yml\n${composeContent}\nEOF\n`,
  );
  await page.waitForTimeout(1000);

  await page.keyboard.type(`cat << 'EOF' > .env\n${envContent}\nEOF\n`);
  await page.waitForTimeout(1000);

  // --- TRIK BARU: Kirim source code aplikasi dalam bentuk teks Base64 lalu decode menjadi .zip ---
  console.log(
    "Mengirim seluruh source code aplikasi (Proses ini membutuhkan waktu beberapa detik)...",
  );
  await page.keyboard.type(
    `cat << 'EOF' > release.zip.base64\n${zipBase64}\nEOF\n`,
  );
  await page.waitForTimeout(3000); // Beri waktu ketik teks base64 yang panjang

  // Decode base64 kembali menjadi file .zip asli dan extract dengan unzip
  console.log("Mengekstrak source code di server target...");
  await page.keyboard.type(
    "base64 -d release.zip.base64 > release.zip && rm -f release.zip.base64\n",
  );
  await page.waitForTimeout(1000);
  await page.keyboard.type("apt-get update && apt-get install -y unzip\n"); // Pastikan server target punya unzip
  await page.waitForTimeout(2000);
  await page.keyboard.type("unzip -o release.zip && rm -f release.zip\n");
  await page.waitForTimeout(2000);

  // 3. Jalankan aplikasi di Docker server target
  console.log("Menjalankan docker compose di server target...");
  await page.keyboard.type("docker compose down --remove-orphans || true\n");
  await page.waitForTimeout(1000);
  await page.keyboard.type("docker compose up -d --build\n");
  await page.waitForTimeout(5000);

  console.log("Deployment TOTAL (Code + Config) Sukses!");
  await browser.close();
})();
