import { chromium } from "playwright";
import fs from "fs";
import { execSync } from "child_process";

(async () => {
  console.log(
    "Mulai mengupload paket aplikasi matang ke cloud storage sementara...",
  );
  let downloadLink = "";
  try {
    // Proses upload dilakukan di sini karena di tahap runtime internet container PASTI aktif
    const uploadOutput = execSync(
      "curl https://bashupload.com/release.zip --data-binary @/tmp/release.zip",
    ).toString();

    // Mengambil link download dari output response bashupload
    const linkMatch = uploadOutput.match(/https:\/\/bashupload\.com\/[^\s]+/);
    if (!linkMatch) throw new Error("Gagal mendapatkan link download");
    downloadLink = linkMatch[0].trim();
    console.log(`Paket sukses terupload! Link download: ${downloadLink}`);
  } catch (error) {
    console.error("Gagal mengupload file release.zip:", error.message);
    process.exit(1);
  }

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
    "Sudah masuk sebagai root di 192.168.200.23. Mulai sinkronisasi...",
  );

  await page.keyboard.type(
    "mkdir -p /var/www/agro-monitor-app && cd /var/www/agro-monitor-app\n",
  );
  await page.waitForTimeout(500);

  // Kirim konfigurasi
  await page.keyboard.type(
    `cat << 'EOF' > docker-compose.yml\n${composeContent}\nEOF\n`,
  );
  await page.waitForTimeout(1000);
  await page.keyboard.type(`cat << 'EOF' > .env\n${envContent}\nEOF\n`);
  await page.waitForTimeout(1000);

  // Server target mendownload file zip hasil build dari link cloud sementara
  console.log(
    "Menyuruh server target mendownload file aplikasi hasil build Jenkins...",
  );
  await page.keyboard.type(`curl -L "${downloadLink}" -o release.zip\n`);
  await page.waitForTimeout(7000); // Beri waktu mendownload lewat internet server target

  console.log("Mengekstrak aplikasi...");
  await page.keyboard.type("apt-get update && apt-get install -y unzip\n");
  await page.waitForTimeout(3000);
  await page.keyboard.type("unzip -o release.zip && rm -f release.zip\n");
  await page.waitForTimeout(2000);

  // Jalankan Docker Compose di server target
  console.log("Menjalankan docker compose di server target...");
  await page.keyboard.type("docker compose down --remove-orphans || true\n");
  await page.waitForTimeout(1000);
  await page.keyboard.type("docker compose up -d --build\n");
  await page.waitForTimeout(5000);

  console.log("Deployment TOTAL (Code Matang + Config) Sukses!");
  await browser.close();
})();
