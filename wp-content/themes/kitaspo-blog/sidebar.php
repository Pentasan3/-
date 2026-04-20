<aside class="sidebar" role="complementary" aria-label="サイドバー">

    <!-- クリニック情報 -->
    <div class="widget clinic-info-widget">
        <h3 class="widget-title">🏥 北九州スポーツ整骨院</h3>
        <div class="clinic-info-item">
            <span class="clinic-info-icon">📍</span>
            <span>福岡県北九州市<br>（詳細はお問い合わせください）</span>
        </div>
        <div class="clinic-info-item">
            <span class="clinic-info-icon">🕐</span>
            <span>平日 9:00〜20:00<br>土曜 9:00〜17:00<br>日祝 休診</span>
        </div>
        <div class="clinic-info-item">
            <span class="clinic-info-icon">🚗</span>
            <span>駐車場あり / バス停徒歩3分</span>
        </div>
        <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="clinic-cta">
            📞 無料相談・ご予約はこちら
        </a>
    </div>

    <!-- アフィリエイト：人気商品 -->
    <div class="widget affiliate-sidebar">
        <h3 class="widget-title">⭐ 今週の注目商品</h3>
        <div style="text-align:center;">
            <div style="font-size:3.5rem;margin:10px 0;">🩹</div>
            <p style="font-size:0.875rem;font-weight:700;color:var(--color-dark);margin-bottom:5px;">
                バンテリンコーワ<br>腰サポーター Lサイズ
            </p>
            <p style="font-size:0.8rem;color:var(--color-text-light);margin-bottom:8px;">
                整骨院スタッフ愛用 ★4.5
            </p>
            <div style="font-size:1.3rem;font-weight:700;color:var(--color-accent);margin-bottom:12px;">¥3,280</div>
            <a href="#" rel="nofollow noopener noreferrer" target="_blank"
               style="display:block;background:var(--color-gold);color:var(--color-dark);font-weight:700;padding:10px;border-radius:var(--radius);text-decoration:none;font-size:0.875rem;margin-bottom:8px;">
                🛒 Amazonで購入
            </a>
            <a href="#" rel="nofollow noopener noreferrer" target="_blank"
               style="display:block;background:#bf0000;color:var(--color-white);font-weight:700;padding:10px;border-radius:var(--radius);text-decoration:none;font-size:0.875rem;">
                🛍️ 楽天市場で購入
            </a>
            <p style="font-size:0.7rem;color:var(--color-text-light);margin-top:8px;">※ アフィリエイトリンクを含みます</p>
        </div>
    </div>

    <!-- 新着記事 -->
    <div class="widget">
        <h3 class="widget-title">📝 新着記事</h3>
        <ul>
            <?php
            $recent = get_posts( [ 'numberposts' => 5, 'post_status' => 'publish' ] );
            foreach ( $recent as $post ) :
                setup_postdata( $post );
            ?>
                <li>
                    <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
                        <span><?php echo esc_html( mb_strimwidth( get_the_title( $post->ID ), 0, 30, '…' ) ); ?></span>
                        <span style="font-size:0.75rem;color:var(--color-text-light);"><?php echo esc_html( get_the_date( 'n/j', $post->ID ) ); ?></span>
                    </a>
                </li>
            <?php
            endforeach;
            wp_reset_postdata();
            ?>
        </ul>
    </div>

    <!-- カテゴリー -->
    <div class="widget">
        <h3 class="widget-title">📂 カテゴリー</h3>
        <ul>
            <?php
            $cats = [
                [ 'slug' => 'sports-injury', 'name' => '🏃 スポーツ障害' ],
                [ 'slug' => 'back-pain',     'name' => '💪 腰痛・肩こり' ],
                [ 'slug' => 'treatment',     'name' => '🩺 施術・ケア方法' ],
                [ 'slug' => 'supplement',    'name' => '💊 サプリメント' ],
                [ 'slug' => 'sports-goods',  'name' => '🏋️ スポーツ用品' ],
                [ 'slug' => 'affiliate',     'name' => '⭐ おすすめ商品' ],
                [ 'slug' => 'column',        'name' => '📖 コラム' ],
            ];
            foreach ( $cats as $cat ) :
                $term = get_term_by( 'slug', $cat['slug'], 'category' );
                $count = $term ? $term->count : 0;
            ?>
                <li>
                    <a href="<?php echo esc_url( home_url( '/category/' . $cat['slug'] . '/' ) ); ?>">
                        <span><?php echo esc_html( $cat['name'] ); ?></span>
                        <span style="background:var(--color-light);border-radius:10px;padding:2px 8px;font-size:0.75rem;"><?php echo esc_html( $count ); ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- タグクラウド -->
    <div class="widget">
        <h3 class="widget-title">🏷️ タグ</h3>
        <?php
        $tags = get_tags( [ 'orderby' => 'count', 'order' => 'DESC', 'number' => 20 ] );
        if ( $tags ) {
            echo '<div style="display:flex;flex-wrap:wrap;gap:6px;">';
            foreach ( $tags as $tag ) {
                echo '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" style="display:inline-block;background:var(--color-light);color:var(--color-text);font-size:0.8rem;padding:4px 10px;border-radius:20px;text-decoration:none;">' . esc_html( '#' . $tag->name ) . '</a>';
            }
            echo '</div>';
        } else {
            echo '<p style="font-size:0.875rem;color:var(--color-text-light);">タグはまだありません</p>';
        }
        ?>
    </div>

    <!-- 検索 -->
    <div class="widget">
        <h3 class="widget-title">🔍 記事を検索</h3>
        <?php get_search_form(); ?>
    </div>

    <!-- アーカイブ -->
    <div class="widget">
        <h3 class="widget-title">📅 月別アーカイブ</h3>
        <ul>
            <?php wp_get_archives( [ 'type' => 'monthly', 'limit' => 12, 'format' => 'html' ] ); ?>
        </ul>
    </div>

    <!-- 広告スペース -->
    <div class="widget" style="background:#f9f9f9;text-align:center;padding:15px;">
        <h3 class="widget-title">📢 広告</h3>
        <div style="background:#e9ecef;border:2px dashed #ccc;padding:30px 15px;border-radius:var(--radius);color:var(--color-text-light);font-size:0.85rem;">
            300×250<br>広告スペース
        </div>
    </div>

    <?php dynamic_sidebar( 'sidebar-main' ); ?>

</aside>
