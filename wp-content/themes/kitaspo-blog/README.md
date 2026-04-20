# 北九州スポーツ整骨院ブログ WordPress テーマ

## セットアップ手順

### 1. テーマのインストール

`wp-content/themes/kitaspo-blog/` フォルダをWordPressの `wp-content/themes/` にアップロードし、管理画面「外観」>「テーマ」から有効化してください。

### 2. サンプルコンテンツのインポート

`sample-content/sample-posts.xml` を「ツール」>「インポート」>「WordPress」から読み込むと、カテゴリー・サンプル記事が自動生成されます。

### 3. 必須プラグイン

| プラグイン | 用途 |
|-----------|------|
| Contact Form 7 | お問い合わせフォーム |
| WP Rocket / W3 Total Cache | キャッシュ・高速化 |
| Yoast SEO | SEO対策 |
| Table of Contents Plus | 目次自動生成 |
| Google Site Kit | GA4連携 |
| Classic Editor（任意） | エディター |

### 4. カスタマイズ

管理画面「外観」>「カスタマイズ」でサイト名・説明文を設定してください。

### 5. アフィリエイトURL設定

各記事内のショートコードの `url="#"` 部分を実際のアフィリエイトURLに書き換えてください。

```
[kitaspo_btn url="https://amzn.to/xxxxx" text="Amazonで見る" color="gold" icon="🛒"]
[kitaspo_product name="商品名" price="¥9,999" url="https://amzn.to/xxxxx" emoji="📦" desc="説明" score="5"]
```

### 6. 利用可能なショートコード

- `[kitaspo_btn]` — アフィリエイトボタン
- `[kitaspo_product]` — 商品カード
- `[kitaspo_notice type="info|warning|danger|success"]` — 注意書きボックス
- `[kitaspo_review score="4.5" title="評価タイトル"]` — 評価ボックス
