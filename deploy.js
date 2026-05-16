import { chromium } from "playwright";
import fs from "fs";

(async () => {
  // Tembak langsung ke file server lokal kamu via Cloudflare Tunnel
  const downloadLink = "https://agro-monitor-app.nivor.id/release.zip";

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

  const composeContent = fs.readFileSync("docker-compose.yml", "utf8");
  const envContent = `PORT=8000\nNODE_ENV=production\nSESSION_SECRET=admin123`;

  // 1. Melakukan SSH ke Server Target
  console.log("Melakukan SSH ke server target 192.168.200.23...");
  await page.keyboard.type("ssh root@192.168.200.23\n");
  await page.waitForTimeout(2000);
  await page.keyboard.type("admin123\n");
  await page.waitForTimeout(2000);

  console.log("Sudah masuk sebagai root. Mulai sinkronisasi folder...");
  await page.keyboard.type(
    "mkdir -p /var/www/agro-monitor-app && cd /var/www/agro-monitor-app\n",
  );
  await page.waitForTimeout(500);

  // 2. Menulis file konfigurasi dasar
  console.log("Mengirim file konfigurasi dasar (docker-compose & .env)...");
  await page.keyboard.type(
    `cat << 'EOF' > docker-compose.yml\n${composeContent}\nEOF\n`,
  );
  await page.waitForTimeout(1000);
  await page.keyboard.type(`cat << 'EOF' > .env\n${envContent}\nEOF\n`);
  await page.waitForTimeout(1000);

  // 3. Mengunduh arsip aplikasi matang via Cloudflare Tunnel kamu
  console.log(
    "Menyuruh server target mengunduh package aplikasi dari Cloudflare Tunnel...",
  );
  await page.keyboard.type(`curl -L "${downloadLink}" -o release.zip\n`);
  await page.waitForTimeout(7000); // Beri waktu download sesuai kecepatan internet server target

  // 4. Mengekstrak package aplikasi
  console.log("Mengekstrak package aplikasi di server target...");
  await page.keyboard.type("apt-get update && apt-get install -y unzip\n");
  await page.waitForTimeout(3000);
  await page.keyboard.type("unzip -o release.zip && rm -f release.zip\n");
  await page.waitForTimeout(2000);

  // 5. Restart container aplikasi di server target
  console.log("Menjalankan ulang docker compose aplikasi di server target...");
  await page.keyboard.type("docker compose down --remove-orphans || true\n");
  await page.waitForTimeout(1000);
  await page.keyboard.type("docker compose up -d --build\n");
  await page.waitForTimeout(5000);

  console.log("🎉 DEPLOYMENT TOTAL VIA CLOUDFLARE TUNNEL BERHASIL SELESAI!");
  await browser.close();
})();
