<?php
/**
 * 投稿一覧（お知らせ一覧・アーカイブ共通）
 */
get_header();
?>

<main id="main-content">
    <div class="page-hero">
        <h1>
            <?php
            if ( is_home() ) {
                echo 'お知らせ';
            } elseif ( is_search() ) {
                printf( '検索結果: %s', esc_html( get_search_query() ) );
            } elseif ( is_archive() ) {
                the_archive_title();
            } else {
                echo 'お知らせ';
            }
            ?>
        </h1>
    </div>

    <div class="content-area">
        <?php if ( have_posts() ) : ?>
            <div class="archive-list">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article class="archive-item">
                        <div class="date"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></div>
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    </article>
                <?php endwhile; ?>
            </div>
            <div class="pagination">
                <?php the_posts_pagination( [ 'mid_size' => 2 ] ); ?>
            </div>
        <?php else : ?>
            <div class="entry-card">
                <p>記事が見つかりませんでした。</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
