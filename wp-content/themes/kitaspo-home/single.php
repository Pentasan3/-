<?php
/**
 * 投稿詳細（お知らせ）
 */
get_header();
?>

<main id="main-content">
    <?php while ( have_posts() ) : the_post(); ?>
        <div class="page-hero">
            <h1><?php the_title(); ?></h1>
        </div>
        <div class="content-area">
            <article <?php post_class( 'entry-card' ); ?>>
                <div class="entry-meta"><?php echo esc_html( get_the_date( 'Y年n月j日' ) ); ?></div>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        </div>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
