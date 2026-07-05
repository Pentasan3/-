<?php
/**
 * 固定ページ
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
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        </div>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
