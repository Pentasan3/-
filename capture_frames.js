const puppeteer = require('puppeteer');
const path = require('path');
const fs = require('fs');

(async () => {
  const framesDir = path.join(__dirname, 'frames');
  if (!fs.existsSync(framesDir)) fs.mkdirSync(framesDir);

  const browser = await puppeteer.launch({
    headless: true,
    args: [
      '--no-sandbox',
      '--disable-setuid-sandbox',
      '--disable-dev-shm-usage',
      '--disable-gpu',
      '--window-size=1080,1920'
    ]
  });

  const page = await browser.newPage();
  await page.setViewport({ width: 1080, height: 1920, deviceScaleFactor: 1 });

  const htmlPath = path.join(__dirname, 'インスタリール動画　バスケ.html');
  await page.goto('file://' + htmlPath, { waitUntil: 'networkidle0' });

  // 15秒 × 30fps = 450フレーム
  const fps = 30;
  const duration = 15;
  const totalFrames = fps * duration;
  const frameInterval = 1000 / fps;

  console.log(`Capturing ${totalFrames} frames at ${fps}fps...`);

  for (let i = 0; i < totalFrames; i++) {
    await page.evaluate((ms) => {
      return new Promise(resolve => setTimeout(resolve, ms));
    }, frameInterval);

    const framePath = path.join(framesDir, `frame_${String(i).padStart(5, '0')}.png`);
    await page.screenshot({ path: framePath, type: 'png' });

    if (i % 30 === 0) {
      console.log(`  ${i}/${totalFrames} frames (${Math.round(i/totalFrames*100)}%)`);
    }
  }

  await browser.close();
  console.log('Frame capture complete!');
})();
