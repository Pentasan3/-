<?php get_header(); ?>

<?php if ( ! is_front_page() ) : ?>
    <?php kitaspo_breadcrumb(); ?>
<?php endif; ?>

<main id="main-content">
    <div class="content-area">
        <!-- ===== メインカラム ===== -->
        <section class="main-column">
            <?php if ( is_home() && ! is_front_page() ) : ?>
                <h1 class="section-title">ブログ記事一覧</h1>
            <?php elseif ( is_category() ) : ?>
                <h1 class="section-title"><?php single_cat_title(); ?></h1>
                <?php if ( category_description() ) : ?>
                    <p style="margin-bottom:25px;color:var(--color-text-light);"><?php echo wp_kses_post( category_description() ); ?></p>
                <?php endif; ?>
            <?php elseif ( is_search() ) : ?>
                <h1 class="section-title">「<?php echo esc_html( get_search_query() ); ?>」の検索結果</h1>
            <?php elseif ( is_archive() ) : ?>
                <h1 class="section-title"><?php the_archive_title(); ?></h1>
            <?php else : ?>
                <h2 class="section-title">新着記事</h2>
            <?php endif; ?>

            <?php if ( have_posts() ) : ?>
                <div class="posts-grid">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part( 'template-parts/card', 'post' ); ?>
                    <?php endwhile; ?>
                </div>

                <!-- ページネーション -->
                <nav class="pagination" aria-label="ページナビゲーション">
                    <?php
                    echo wp_kses_post( paginate_links( [
                        'prev_text' => '« 前へ',
                        'next_text' => '次へ »',
                        'type'      => 'list',
                    ] ) );
                    ?>
                </nav>

            <?php else : ?>
                <div style="text-align:center;padding:60px 20px;background:var(--color-white);border-radius:var(--radius);box-shadow:var(--shadow);">
                    <div style="font-size:4rem;margin-bottom:15px;">📝</div>
                    <h2 style="color:var(--color-dark);margin-bottom:10px;">記事が見つかりませんでした</h2>
                    <p style="color:var(--color-text-light);">検索条件を変えてお試しください。</p>
                    <?php get_search_form(); ?>
                </div>
            <?php endif; ?>
        </section>

        <!-- ===== サイドバー ===== -->
        <?php get_sidebar(); ?>
    </div>
</main>

<?php get_footer(); ?>
