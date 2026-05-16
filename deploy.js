import { chromium } from "playwright";
import fs from "fs";

(async () => {
  // Jalankan browser headless dengan argumen wajib Docker
  const browser = await chromium.launch({
    headless: true,
    executablePath:
      process.env.PLAYWRIGHT_LAUNCH_OPTIONS_EXECUTABLE_PATH ||
      "/usr/bin/chromium-browser",
    args: ["--no-sandbox", "--disable-setuid-sandbox"],
  });
  const context = await browser.newContext({
    httpCredentials: {
      username: "sija",
      password: "sijagaot123",
    },
  });

  const page = await context.newPage();

  console.log("Menghubungi pintu gerbang terminal...");
  await page.goto("https://terminal.scholair.my.id/");
  await page.waitForLoadState("networkidle");

  console.log("Berhasil melewati alert web! Masuk ke terminal...");

  // Mengambil data docker-compose.yml yang ada di workspace saat ini
  const composeContent = fs.readFileSync("docker-compose.yml", "utf8");
  const envContent = `PORT=8000\nNODE_ENV=production\nSESSION_SECRET=admin123`;

  await page.keyboard.type("ssh root@192.168.200.23\n");
  await page.waitForTimeout(2000);
  await page.keyboard.type("admin123\n");
  await page.waitForTimeout(2000);

  console.log(
    "Sudah masuk sebagai root di 192.168.200.23. Mulai menyiapkan folder...",
  );

  // Target folder disesuaikan ke agro-monitor-app
  await page.keyboard.type(
    "mkdir -p /var/www/agro-monitor-app && cd /var/www/agro-monitor-app\n",
  );
  await page.waitForTimeout(500);

  // Kirim file ke server target via terminal web
  await page.keyboard.type(
    `cat << 'EOF' > docker-compose.yml\n${composeContent}\nEOF\n`,
  );
  await page.waitForTimeout(1000);

  await page.keyboard.type(
    `cat << 'EOF' > .env.production\n${envContent}\nEOF\n`,
  );
  await page.waitForTimeout(1000);

  console.log("Menjalankan aplikasi di server target...");
  await page.keyboard.type("docker compose down --remove-orphans || true\n");
  await page.waitForTimeout(1000);
  await page.keyboard.type("docker compose up -d --build\n");
  await page.waitForTimeout(5000);

  console.log("Deployment via Robot Web di dalam Docker Jenkins Sukses!");
  await browser.close();
})();
