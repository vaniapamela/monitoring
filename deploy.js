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

  const composeContent = fs.readFileSync("docker-compose.yml", "utf8");
  const envContent = `PORT=8000\nNODE_ENV=production\nSESSION_SECRET=admin123`;

  await page.keyboard.type("ssh root@192.168.200.23\n");
  await page.waitForTimeout(2000);
  await page.keyboard.type("admin123\n");
  await page.waitForTimeout(2000);

  console.log(
    "Sudah masuk sebagai root di 192.168.200.23. Mulai sinkronisasi via Git...",
  );

  // 1. Pastikan folder git sudah ada, jika belum lakukan clone pertama kali
  await page.keyboard.type(
    "git config --global --add safe.directory /var/www/agro-monitor-app\n",
  );
  await page.keyboard.type(
    'if [ ! -d "/var/www/agro-monitor-app/.git" ]; then git clone https://github.com/vaniapamela/monitoring.git /var/www/agro-monitor-app; fi\n',
  );
  await page.waitForTimeout(3000);

  // 2. Masuk ke folder dan tarik code terbaru
  await page.keyboard.type(
    "cd /var/www/agro-monitor-app && git fetch --all && git reset --hard origin/main\n",
  );
  await page.waitForTimeout(3000);

  console.log("Memperbarui file konfigurasi env & docker-compose...");
  // 3. Tulis ulang docker-compose dan .env terbaru dari Jenkins
  await page.keyboard.type(
    `cat << 'EOF' > docker-compose.yml\n${composeContent}\nEOF\n`,
  );
  await page.waitForTimeout(1000);

  await page.keyboard.type(`cat << 'EOF' > .env\n${envContent}\nEOF\n`);
  await page.waitForTimeout(1000);

  // 4. Jalankan aplikasi via Docker Compose di server target
  console.log("Menjalankan docker compose di server target...");
  await page.keyboard.type("docker compose down --remove-orphans || true\n");
  await page.waitForTimeout(1000);
  await page.keyboard.type("docker compose up -d --build\n");
  await page.waitForTimeout(5000);

  console.log("Deployment TOTAL via Git & Docker Sukses Tanpa Hambatan!");
  await browser.close();
})();
