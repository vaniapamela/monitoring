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

  // Membaca link download pendek hasil build Docker Jenkins tadi
  const downloadLink = fs.readFileSync("/tmp/download_link.txt", "utf8").trim();
  console.log(`Link paket aplikasi terdeteksi: ${downloadLink}`);

  await page.keyboard.type("ssh root@192.168.200.23\n");
  await page.waitForTimeout(2000);
  await page.keyboard.type("admin123\n");
  await page.waitForTimeout(2000);

  console.log(
    "Sudah masuk sebagai root di 192.168.200.23. Mulai deploy aplikasi matang...",
  );

  await page.keyboard.type(
    "mkdir -p /var/www/agro-monitor-app && cd /var/www/agro-monitor-app\n",
  );
  await page.waitForTimeout(500);

  // Tulis file config
  await page.keyboard.type(
    `cat << 'EOF' > docker-compose.yml\n${composeContent}\nEOF\n`,
  );
  await page.waitForTimeout(1000);
  await page.keyboard.type(`cat << 'EOF' > .env\n${envContent}\nEOF\n`);
  await page.waitForTimeout(1000);

  // Suruh server target download file zip yang sudah matang dari Jenkins
  console.log(
    "Menyuruh server target mendownload file aplikasi hasil build Jenkins...",
  );
  await page.keyboard.type(`curl -L "${downloadLink}" -o release.zip\n`);
  await page.waitForTimeout(5000); // Beri waktu mendownload lewat internet server

  console.log("Mengekstrak aplikasi...");
  await page.keyboard.type("apt-get update && apt-get install -y unzip\n");
  await page.waitForTimeout(3000);
  await page.keyboard.type("unzip -o release.zip && rm -f release.zip\n");
  await page.waitForTimeout(2000);

  // Jalankan Docker Compose aplikasi di server target
  console.log("Menjalankan docker compose di server target...");
  await page.keyboard.type("docker compose down --remove-orphans || true\n");
  await page.waitForTimeout(1000);
  await page.keyboard.type("docker compose up -d --build\n");
  await page.waitForTimeout(5000);

  console.log(
    "Deployment SUKSES! Server target menerima aplikasi yang sudah matang dari Jenkins!",
  );
  await browser.close();
})();
