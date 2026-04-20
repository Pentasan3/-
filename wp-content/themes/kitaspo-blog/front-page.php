<?php get_header(); ?>

<main id="main-content">
    <!-- ===== ヒーローセクション ===== -->
    <section class="hero-section">
        <div class="hero-content">
            <div class="hero-badge">北九州市No.1 スポーツ整骨院</div>
            <h1 class="hero-title">
                スポーツの痛みも、<span>日常の不調</span>も。<br>
                北九州スポーツ整骨院が<br>
                徹底サポートします
            </h1>
            <p class="hero-desc">
                柔道整復師が厳選したセルフケア情報・おすすめ商品を毎週更新中。<br>
                腰痛・肩こり・スポーツ障害・交通事故後遺症でお悩みの方へ
            </p>
            <div style="display:flex;gap:15px;justify-content:center;flex-wrap:wrap;">
                <a href="<?php echo esc_url( home_url( '/category/sports-injury/' ) ); ?>" style="display:inline-block;background:var(--color-gold);color:var(--color-dark);font-weight:700;padding:14px 28px;border-radius:30px;text-decoration:none;font-size:1rem;">
                    スポーツ障害を読む →
                </a>
                <a href="<?php echo esc_url( home_url( '/ranking/' ) ); ?>" style="display:inline-block;background:transparent;color:var(--color-white);border:2px solid rgba(255,255,255,0.7);font-weight:700;padding:14px 28px;border-radius:30px;text-decoration:none;font-size:1rem;">
                    ⭐ おすすめランキング
                </a>
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <div class="hero-stat-number">15<span style="font-size:1.5rem;">年+</span></div>
                    <div class="hero-stat-label">整骨院運営実績</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-number">5,000<span style="font-size:1.5rem;">名+</span></div>
                    <div class="hero-stat-label">施術実績</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-number">100<span style="font-size:1.5rem;">+</span></div>
                    <div class="hero-stat-label">ブログ記事数</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-number">4.8</div>
                    <div class="hero-stat-label">Google評価 ★★★★★</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== お知らせバー ===== -->
    <div style="background:var(--color-primary);color:var(--color-white);padding:12px 20px;text-align:center;font-size:0.875rem;">
        📢 <strong>新着情報:</strong> 「プロテインおすすめランキング2024年版」公開しました！
        <a href="<?php echo esc_url( home_url( '/ranking/protein-ranking/' ) ); ?>" style="color:var(--color-gold);font-weight:700;margin-left:10px;">詳しく見る →</a>
    </div>

    <div class="container" style="padding-top:50px;padding-bottom:50px;">

        <!-- ===== アフィリエイトバナー（人気No.1商品） ===== -->
        <div class="affiliate-banner" style="margin-bottom:50px;">
            <h3>🏆 整骨院スタッフ愛用！おすすめサポーター No.1</h3>
            <p>腰痛・膝痛・肟関節痛に。医療用グレードの高品質サポーターを毎日使用しています。<br>
            プロスポーツ選手も愛用する信頼のブランド。</p>
            <a href="#" rel="nofollow noopener noreferrer" target="_blank" class="btn-affiliate">
                🛒 Amazonで価格を確認する
            </a>
        </div>

        <!-- ===== カテゴリー別ナビ ===== -->
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:15px;margin-bottom:50px;">
            <?php
            $categories = [
                [ 'slug' => 'sports-injury', 'emoji' => '🏃', 'name' => 'スポーツ障害', 'color' => '#8e44ad' ],
                [ 'slug' => 'back-pain',     'emoji' => '💪', 'name' => '腰痛・肩こり', 'color' => '#e74c3c' ],
                [ 'slug' => 'treatment',     'emoji' => '🩺', 'name' => '施術・ケア',   'color' => '#27ae60' ],
                [ 'slug' => 'supplement',    'emoji' => '💊', 'name' => 'サプリメント', 'color' => '#2980b9' ],
                [ 'slug' => 'sports-goods',  'emoji' => '🏋️', 'name' => 'スポーツ用品', 'color' => '#e67e22' ],
                [ 'slug' => 'affiliate',     'emoji' => '⭐', 'name' => 'おすすめ商品', 'color' => '#f39c12' ],
            ];
            foreach ( $categories as $cat ) :
            ?>
                <a href="<?php echo esc_url( home_url( '/category/' . $cat['slug'] . '/' ) ); ?>"
                   style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:20px;background:var(--color-white);border-radius:var(--radius);box-shadow:var(--shadow);text-decoration:none;border-top:4px solid <?php echo esc_attr( $cat['color'] ); ?>;transition:transform 0.2s,box-shadow 0.2s;"
                   onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 25px rgba(0,0,0,0.12)'"
                   onmouseout="this.style.transform='';this.style.boxShadow='0 2px 15px rgba(0,0,0,0.08)'">
                    <span style="font-size:2.2rem;margin-bottom:8px;"><?php echo esc_html( $cat['emoji'] ); ?></span>
                    <span style="font-size:0.85rem;font-weight:700;color:var(--color-dark);text-align:center;"><?php echo esc_html( $cat['name'] ); ?></span>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- ===== 新着記事 ===== -->
        <div style="display:grid;grid-template-columns:1fr 320px;gap:40px;align-items:start;">
            <div>
                <h2 class="section-title">最新記事</h2>
                <div class="posts-grid">
                    <?php
                    $recent_posts = new WP_Query( [
                        'posts_per_page' => 6,
                        'post_status'    => 'publish',
                    ] );
                    if ( $recent_posts->have_posts() ) :
                        while ( $recent_posts->have_posts() ) : $recent_posts->the_post();
                            get_template_part( 'template-parts/card', 'post' );
                        endwhile;
                        wp_reset_postdata();
                    else :
                        echo '<p>記事を準備中です。</p>';
                    endif;
                    ?>
                </div>
                <div style="text-align:center;margin-top:20px;">
                    <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" style="display:inline-block;background:var(--color-secondary);color:var(--color-white);font-weight:700;padding:13px 30px;border-radius:30px;text-decoration:none;">
                        すべての記事を見る →
                    </a>
                </div>
            </div>

            <!-- サイドバー -->
            <div>
                <?php get_sidebar(); ?>
            </div>
        </div>

        <!-- ===== ランキングセクション ===== -->
        <section style="margin-top:60px;">
            <h2 class="section-title">⭐ 人気商品ランキング TOP5</h2>
            <div class="ranking-box">
                <?php
                $ranking = [
                    [ 'rank' => 1, 'emoji' => '🩹', 'name' => 'バンテリンコーワサポーター（腰用）',    'price' => '¥3,280', 'desc' => '整骨院でも推奨。腰への負担を軽減し、日常動作をサポート。' ],
                    [ 'rank' => 2, 'emoji' => '💊', 'name' => 'ザバス ホエイプロテイン100（バニラ）',  'price' => '¥4,980', 'desc' => '国産プロテインの定番。吸収が速く筋肉修復をサポートします。' ],
                    [ 'rank' => 3, 'emoji' => '🔵', 'name' => 'トリガーポイント フォームローラー',     'price' => '¥5,980', 'desc' => '筋膜リリースに最適。施術後のセルフケアにも活躍します。' ],
                    [ 'rank' => 4, 'emoji' => '⚡', 'name' => 'ハイパーアイスヴァイパー（筋膜銃）',   'price' => '¥18,800', 'desc' => 'プロ仕様の振動マッサージガン。疲労回復スピードが違います。' ],
                    [ 'rank' => 5, 'emoji' => '🌡️', 'name' => 'ホットアンドクールパック（温冷両用）', 'price' => '¥1,980', 'desc' => '急性期は冷却、慢性期は温熱で対応。繰り返し使えるコスパ抜群。' ],
                ];
                foreach ( $ranking as $item ) :
                    $rank_class = $item['rank'] <= 3 ? 'rank-' . $item['rank'] : 'rank-other';
                ?>
                    <div class="ranking-item">
                        <div class="ranking-number <?php echo esc_attr( $rank_class ); ?>"><?php echo esc_html( $item['rank'] ); ?></div>
                        <div style="font-size:2rem;"><?php echo esc_html( $item['emoji'] ); ?></div>
                        <div style="flex:1;">
                            <div style="font-weight:700;color:var(--color-dark);margin-bottom:4px;"><?php echo esc_html( $item['name'] ); ?></div>
                            <div style="font-size:0.85rem;color:var(--color-text-light);margin-bottom:6px;"><?php echo esc_html( $item['desc'] ); ?></div>
                            <div style="font-size:1.1rem;font-weight:700;color:var(--color-accent);"><?php echo esc_html( $item['price'] ); ?></div>
                        </div>
                        <a href="#" rel="nofollow noopener noreferrer" target="_blank" class="btn-buy">Amazonで見る →</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- ===== 院の特徴 ===== -->
        <section style="margin-top:60px;background:var(--color-white);border-radius:var(--radius);padding:40px;box-shadow:var(--shadow);">
            <h2 class="section-title">北九州スポーツ整骨院の特徴</h2>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:25px;margin-top:30px;">
                <?php
                $features = [
                    [ 'icon' => '🏅', 'title' => 'スポーツ外傷専門', 'desc' => '捻挫・打撲・骨折など、スポーツ中のケガに特化した施術を行います。競技への早期復帰をサポート。' ],
                    [ 'icon' => '💆', 'title' => '根本改善アプローチ', 'desc' => '痛みの原因を深部まで分析。表面的な症状だけでなく、再発しない身体づくりを目指します。' ],
                    [ 'icon' => '🏃', 'title' => '各競技に対応', 'desc' => '野球・サッカー・バスケ・テニス・ランニングなど、あらゆるスポーツの選手をサポートします。' ],
                    [ 'icon' => '📋', 'title' => '丁寧なカウンセリング', 'desc' => '初回は時間をかけて問診・検査を実施。お一人おひとりに合った施術計画を作成します。' ],
                ];
                foreach ( $features as $f ) :
                ?>
                    <div style="text-align:center;padding:25px 15px;">
                        <div style="font-size:3rem;margin-bottom:12px;"><?php echo esc_html( $f['icon'] ); ?></div>
                        <h3 style="font-family:var(--font-heading);font-size:1rem;font-weight:700;color:var(--color-dark);margin-bottom:10px;"><?php echo esc_html( $f['title'] ); ?></h3>
                        <p style="font-size:0.875rem;color:var(--color-text-light);line-height:1.7;"><?php echo esc_html( $f['desc'] ); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- ===== CTA セクション ===== -->
        <section style="margin-top:60px;background:linear-gradient(135deg,var(--color-primary),var(--color-secondary));border-radius:var(--radius);padding:50px;text-align:center;color:var(--color-white);">
            <h2 style="font-family:var(--font-heading);font-size:1.8rem;font-weight:900;margin-bottom:15px;">
                身体の不調、一人で悩まないでください
            </h2>
            <p style="font-size:1rem;color:rgba(255,255,255,0.85);margin-bottom:30px;line-height:1.8;">
                北九州スポーツ整骨院では無料相談を随時受け付けています。<br>
                ブログを読んでいただいた方は「ブログを見た」とお伝えください。
            </p>
            <div style="display:flex;gap:15px;justify-content:center;flex-wrap:wrap;">
                <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" style="display:inline-block;background:var(--color-gold);color:var(--color-dark);font-weight:700;padding:15px 35px;border-radius:30px;text-decoration:none;font-size:1rem;">
                    📞 無料相談はこちら
                </a>
                <a href="<?php echo esc_url( home_url( '/access/' ) ); ?>" style="display:inline-block;background:transparent;color:var(--color-white);border:2px solid rgba(255,255,255,0.7);font-weight:700;padding:15px 35px;border-radius:30px;text-decoration:none;font-size:1rem;">
                    📍 アクセスを確認する
                </a>
            </div>
        </section>

    </div><!-- .container -->
</main>

<?php get_footer(); ?>
