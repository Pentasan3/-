# 北九州スポーツ整骨院 インスタリール動画

Instagram リール用 MP4（**1080×1920 / 10 秒 / 30fps**）を HTML から自動生成するスクリプトです。

## 生成物

- `reel.mp4` — 書き出された動画（このまま Instagram にアップロード可）
- `reel.html` — 動画の元になる HTML（テキスト・色・アニメーションはここで調整）
- `record.js` — Playwright で HTML をフレームごとにキャプチャし ffmpeg で MP4 化するスクリプト

## 構成

- 上部バナー: 「北九州スポーツ整骨院」（0.2 秒でフェードイン）
- 中央見出し: 「**ケガ**からの 早期回復」（1.8 秒〜、「ケガ」は赤でポップ）
- 下部キャッチ: 「練習を休まず競技復帰！」（5.0 秒〜）
- 7 秒以降に赤のパルスリングがループ

## 実写写真に差し替える方法（推奨）

現状は背景が CSS グラデーション（暗い体育館色＋赤差し色）になっています。実際のバスケ選手の写真に差し替えると完成度が上がります。

### ■ GitHub の Web UI から差し替える場合（Git 不要）

1. GitHub で本リポジトリを開く
2. ブランチを `claude/convert-html-to-mp4-Zr66K` に切り替える
3. `reel-video/` フォルダに入り、右上の **Add file → Upload files** をクリック
4. 写真ファイルを **`basketball.jpg`** という名前にリネームしてからドラッグ&ドロップ
5. 下部の **Commit changes** を押す
6. こちら（Claude）に「写真を上げた」と伝えれば、同じスクリプトを再実行して `reel.mp4` を再生成します

### ■ ローカル（コマンド実行可能な場合）

```bash
# 1. basketball.jpg を reel-video/ に置く
# 2. 再生成
cd reel-video
node record.js
```

## 依存関係

- Node.js 18+（`playwright` をローカルインストール）
- Chromium（Playwright 付属）
- ffmpeg（`apt-get install ffmpeg`）

## 初回セットアップ

```bash
cd reel-video
npm install
npx playwright install chromium
node record.js
```

## 調整のコツ

- テキストを変える → `reel.html` の `.top-banner span` / `.line1` / `.line2` / `.bottom span`
- 色を変える → `#e2192a`（赤）や `rgba(10,10,10,0.88)`（バナー背景）
- タイミングを変える → `@keyframes fadeUp` / `animation: ... Xs forwards` の秒数
- 尺を変える → `record.js` の `DURATION_SEC`
