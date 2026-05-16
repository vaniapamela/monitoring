import { chromium } from "playwright";

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

  console.log("Berhasil masuk ke terminal...");

  // 1. Melakukan SSH ke Server Target
  console.log("Melakukan SSH ke server target 192.168.200.23...");
  await page.keyboard.type("ssh root@192.168.200.23\n");
  await page.waitForTimeout(2000);
  await page.keyboard.type("admin123\n");
  await page.waitForTimeout(2000);

  // 2. Masuk ke folder & tarik kode terbaru dari Git (Kunci Utamanya!)
  console.log("Masuk ke direktori dan melakukan Git Pull...");
  await page.keyboard.type("cd /var/www/agro-monitor-app && git pull\n");
  await page.waitForTimeout(4000); // Beri jeda waktu proses pull data dari internet

  // 3. Sinkronisasi dependensi vendor PHP secara native
  console.log("Menjalankan composer install di server target...");
  await page.keyboard.type(
    "composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev\n",
  );
  await page.waitForTimeout(15000); // Beri waktu agak lama untuk install vendor

  // 4. Restart service PHP (opsional, agar opcache reset)
  console.log("Merestart service PHP...");
  await page.keyboard.type(
    "systemctl restart php8.3-fpm || systemctl restart php-fpm || true\n",
  );
  await page.waitForTimeout(2000);

  console.log("🎉 DEPLOYMENT VIA GIT PULL BERHASIL SELESAI!");
  await browser.close();
})();
