// Records reel.html as a 10-second 1080x1920 video using Playwright's
// frame capture, then encodes to MP4 via ffmpeg.
//
// Usage:  node record.js

const { chromium } = require('playwright');
const { spawnSync } = require('child_process');
const path = require('path');
const fs = require('fs');

const WIDTH = 1080;
const HEIGHT = 1920;
const FPS = 30;
const DURATION_SEC = 10;
const TOTAL_FRAMES = FPS * DURATION_SEC;

const HTML_PATH = path.resolve(__dirname, 'reel.html');
const FRAMES_DIR = path.resolve(__dirname, 'frames');
const OUTPUT_MP4 = path.resolve(__dirname, 'reel.mp4');

async function main() {
  // Clean frames dir
  if (fs.existsSync(FRAMES_DIR)) fs.rmSync(FRAMES_DIR, { recursive: true });
  fs.mkdirSync(FRAMES_DIR, { recursive: true });

  const browser = await chromium.launch();
  const context = await browser.newContext({
    viewport: { width: WIDTH, height: HEIGHT },
    deviceScaleFactor: 1,
  });
  const page = await context.newPage();

  await page.goto('file://' + HTML_PATH, { waitUntil: 'networkidle' });

  // Wait for fonts
  await page.evaluate(() => document.fonts.ready);

  // Pause every CSS animation so we can step through deterministically
  await page.evaluate(() => {
    const style = document.createElement('style');
    style.textContent = `*, *::before, *::after { animation-play-state: paused !important; }`;
    document.head.appendChild(style);
  });

  // For each frame, set currentTime on every animation, then screenshot
  for (let i = 0; i < TOTAL_FRAMES; i++) {
    const t = (i / FPS) * 1000; // ms
    await page.evaluate((timeMs) => {
      document.getAnimations().forEach(a => { a.currentTime = timeMs; });
    }, t);
    const filename = path.join(FRAMES_DIR, `frame_${String(i).padStart(5, '0')}.png`);
    await page.screenshot({ path: filename, omitBackground: false });
    if (i % 30 === 0) {
      console.log(`  captured frame ${i}/${TOTAL_FRAMES}`);
    }
  }

  await browser.close();
  console.log('Frames captured. Encoding MP4...');

  // ffmpeg: mp4 H.264 yuv420p for Instagram compatibility
  const args = [
    '-y',
    '-framerate', String(FPS),
    '-i', path.join(FRAMES_DIR, 'frame_%05d.png'),
    '-c:v', 'libx264',
    '-pix_fmt', 'yuv420p',
    '-preset', 'slow',
    '-crf', '18',
    '-movflags', '+faststart',
    OUTPUT_MP4,
  ];
  const r = spawnSync('ffmpeg', args, { stdio: 'inherit' });
  if (r.status !== 0) {
    console.error('ffmpeg failed');
    process.exit(r.status || 1);
  }
  console.log(`Done: ${OUTPUT_MP4}`);
}

main().catch(e => { console.error(e); process.exit(1); });
