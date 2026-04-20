<?php get_header(); ?>
<?php kitaspo_breadcrumb(); ?>

<main id="main-content">
    <div class="content-area">
        <!-- ===== 記事本文 ===== -->
        <article id="post-<?php the_ID(); ?>" <?php post_class( 'main-column' ); ?>>
            <?php while ( have_posts() ) : the_post(); ?>

                <!-- 記事ヘッダー -->
                <header class="entry-header" style="background:var(--color-white);border-radius:var(--radius);padding:30px;box-shadow:var(--shadow);margin-bottom:25px;">
                    <?php
                    $cats = get_the_category();
                    if ( $cats ) {
                        echo '<div style="margin-bottom:12px;">';
                        foreach ( $cats as $cat ) {
                            echo '<a href="' . esc_url( get_category_link( $cat->term_id ) ) . '" class="post-card-category">' . esc_html( $cat->name ) . '</a> ';
                        }
                        echo '</div>';
                    }
                    ?>
                    <h1 class="entry-title" style="font-family:var(--font-heading);font-size:1.7rem;font-weight:900;color:var(--color-dark);line-height:1.5;margin-bottom:15px;">
                        <?php the_title(); ?>
                    </h1>
                    <div style="display:flex;align-items:center;gap:20px;font-size:0.85rem;color:var(--color-text-light);flex-wrap:wrap;">
                        <span>📅 <?php echo esc_html( get_the_date( 'Y年n月j日' ) ); ?></span>
                        <?php if ( get_the_modified_date( 'Y-m-d' ) !== get_the_date( 'Y-m-d' ) ) : ?>
                            <span>🔄 更新: <?php echo esc_html( get_the_modified_date( 'Y年n月j日' ) ); ?></span>
                        <?php endif; ?>
                        <span>✍️ <?php the_author(); ?></span>
                        <?php
                        $reading_time = max( 1, (int) ( str_word_count( strip_tags( get_the_content() ) ) / 400 ) );
                        ?>
                        <span>⏱️ 約<?php echo esc_html( $reading_time ); ?>分で読めます</span>
                    </div>
                </header>

                <!-- アイキャッチ -->
                <?php if ( has_post_thumbnail() ) : ?>
                    <div style="margin-bottom:25px;border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow);">
                        <?php the_post_thumbnail( 'kitaspo-hero', [ 'style' => 'width:100%;height:auto;' ] ); ?>
                    </div>
                <?php endif; ?>

                <!-- 目次（プラグイン連携用プレースホルダー） -->
                <div id="toc" style="background:#f0f8ff;border:1px solid var(--color-secondary);border-radius:var(--radius);padding:20px 25px;margin-bottom:30px;">
                    <div style="font-weight:700;color:var(--color-primary);margin-bottom:10px;">📋 この記事の目次</div>
                    <p style="font-size:0.85rem;color:var(--color-text-light);">目次プラグイン（Table of Contents Plus 等）を導入すると自動生成されます。</p>
                </div>

                <!-- 記事本文 -->
                <div class="entry-content" style="background:var(--color-white);border-radius:var(--radius);padding:35px;box-shadow:var(--shadow);margin-bottom:25px;">
                    <?php the_content(); ?>
                    <?php
                    wp_link_pages( [
                        'before' => '<div class="page-links">ページ: ',
                        'after'  => '</div>',
                    ] );
                    ?>
                </div>

                <!-- タグ -->
                <?php
                $tags = get_the_tags();
                if ( $tags ) :
                ?>
                    <div style="background:var(--color-white);border-radius:var(--radius);padding:20px 25px;box-shadow:var(--shadow);margin-bottom:25px;">
                        <span style="font-weight:700;color:var(--color-dark);">🏷️ タグ: </span>
                        <?php
                        foreach ( $tags as $tag ) {
                            echo '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" style="display:inline-block;background:var(--color-light);color:var(--color-text);font-size:0.8rem;padding:4px 10px;border-radius:20px;margin:3px 3px 3px 0;text-decoration:none;">' . esc_html( '#' . $tag->name ) . '</a>';
                        }
                        ?>
                    </div>
                <?php endif; ?>

                <!-- 著者プロフィール -->
                <div style="background:var(--color-white);border-radius:var(--radius);padding:25px;box-shadow:var(--shadow);margin-bottom:25px;display:flex;gap:20px;align-items:flex-start;">
                    <div style="width:70px;height:70px;border-radius:50%;background:linear-gradient(135deg,var(--color-primary),var(--color-secondary));display:flex;align-items:center;justify-content:center;font-size:2rem;flex-shrink:0;">🩺</div>
                    <div>
                        <div style="font-weight:700;color:var(--color-dark);margin-bottom:4px;"><?php the_author(); ?></div>
                        <div style="font-size:0.8rem;color:var(--color-secondary);margin-bottom:8px;">北九州スポーツ整骨院 柔道整復師</div>
                        <p style="font-size:0.875rem;color:var(--color-text-light);line-height:1.7;"><?php the_author_meta( 'description' ); ?></p>
                    </div>
                </div>

            <?php endwhile; ?>

            <!-- 前後記事ナビ -->
            <nav class="post-navigation" style="display:grid;grid-template-columns:1fr 1fr;gap:15px;margin-bottom:25px;">
                <div style="background:var(--color-white);border-radius:var(--radius);padding:18px;box-shadow:var(--shadow);">
                    <?php previous_post_link( '← %link', '前の記事' ); ?>
                </div>
                <div style="background:var(--color-white);border-radius:var(--radius);padding:18px;box-shadow:var(--shadow);text-align:right;">
                    <?php next_post_link( '%link →', '次の記事' ); ?>
                </div>
            </nav>

            <!-- コメントセクション -->
            <?php if ( comments_open() || get_comments_number() ) : ?>
                <div style="background:var(--color-white);border-radius:var(--radius);padding:30px;box-shadow:var(--shadow);">
                    <?php comments_template(); ?>
                </div>
            <?php endif; ?>
        </article>

        <!-- ===== サイドバー ===== -->
        <?php get_sidebar(); ?>
    </div>
</main>

<?php get_footer(); ?>
