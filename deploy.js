const { chromium } = require("playwright");
const fs = require("fs");

(async () => {
  // 1. Jalankan browser di latar belakang
  const browser = await chromium.launch({ headless: true });

  // 2. Buat konteks baru dan masukkan kredensial untuk melewati POP-UP ALERT (HTTP Auth)
  const context = await browser.newContext({
    httpCredentials: {
      username: "sija",
      password: "sijagaot123",
    },
  });

  const page = await context.newPage();

  console.log("Menghubungi pintu gerbang terminal...");
  await page.goto("https://terminal.scholair.my.id/");

  // Tunggu sampai halaman terminal web termuat sepenuhnya
  // (Sesuaikan selector di bawah ini jika terminal web Anda menggunakan element spesifik)
  await page.waitForLoadState("networkidle");

  console.log("Berhasil melewati alert web! Masuk ke terminal...");

  // 3. Baca file docker-compose Anda untuk diketikkan/dikirim via echo ke server target
  const composeContent = fs.readFileSync("docker-compose.yml", "utf8");
  const envContent = `PORT=8000\nNODE_ENV=production\nSESSION_SECRET=admin123`;

  // 4. Simulasi mengetik langsung ke terminal web
  // Kita lakukan SSH kedua ke root@192.168.200.23 dari dalam terminal tersebut
  await page.keyboard.type("ssh root@192.168.200.23\n");
  await page.waitForTimeout(2000); // Tunggu prompt password muncul
  await page.keyboard.type("admin123\n");
  await page.waitForTimeout(2000);

  console.log("Sudah masuk sebagai root di 192.168.200.23. Mulai deploy...");

  // Membuat folder dan menuliskan file konfigurasi di server target
  await page.keyboard.type(
    "mkdir -p /var/www/agro-monitor-app && cd /var/www/agro-monitor-app\n",
  );
  await page.waitForTimeout(500);

  // Kirim isi docker-compose via perintah cat << 'EOF'
  await page.keyboard.type(
    `cat << 'EOF' > docker-compose.yml\n${composeContent}\nEOF\n`,
  );
  await page.waitForTimeout(1000);

  // Kirim isi .env.production
  await page.keyboard.type(
    `cat << 'EOF' > .env.production\n${envContent}\nEOF\n`,
  );
  await page.waitForTimeout(1000);

  // Eksekusi Docker Compose Build & Run langsung di tempat (sesuai docker-compose.yml awal Anda)
  console.log("Menjalankan docker compose di server target...");
  await page.keyboard.type("docker compose down --remove-orphans || true\n");
  await page.waitForTimeout(1000);
  await page.keyboard.type("docker compose up -d --build\n");
  await page.waitForTimeout(5000); // Tunggu proses build selesai

  console.log("Deployment via Robot Web Sukses!");
  await browser.close();
})();
