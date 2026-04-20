<?php
/**
 * Template Name: 免責事項・プライバシーポリシー
 */
get_header();
kitaspo_breadcrumb();
?>

<main id="main-content">
    <div class="container-narrow" style="padding-top:40px;padding-bottom:60px;">
        <?php while ( have_posts() ) : the_post(); ?>
            <article>
                <h1 style="font-family:var(--font-heading);font-size:1.8rem;color:var(--color-dark);margin-bottom:30px;padding-bottom:15px;border-bottom:3px solid var(--color-secondary);">
                    <?php the_title(); ?>
                </h1>
                <div class="entry-content" style="background:var(--color-white);padding:35px;border-radius:var(--radius);box-shadow:var(--shadow);">
                    <?php the_content(); ?>
                </div>
                <p style="text-align:right;font-size:0.85rem;color:var(--color-text-light);margin-top:20px;">
                    最終更新日：<?php echo esc_html( get_the_modified_date( 'Y年n月j日' ) ); ?>
                </p>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
