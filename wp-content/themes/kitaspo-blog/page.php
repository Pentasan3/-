<?php get_header(); ?>
<?php kitaspo_breadcrumb(); ?>

<main id="main-content">
    <div class="content-area">
        <div class="main-column">
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header style="background:var(--color-white);border-radius:var(--radius);padding:30px;box-shadow:var(--shadow);margin-bottom:25px;">
                        <h1 style="font-family:var(--font-heading);font-size:1.8rem;font-weight:900;color:var(--color-dark);">
                            <?php the_title(); ?>
                        </h1>
                    </header>

                    <?php if ( has_post_thumbnail() ) : ?>
                        <div style="margin-bottom:25px;border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow);">
                            <?php the_post_thumbnail( 'kitaspo-hero' ); ?>
                        </div>
                    <?php endif; ?>

                    <div class="entry-content" style="background:var(--color-white);border-radius:var(--radius);padding:35px;box-shadow:var(--shadow);">
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <?php get_sidebar(); ?>
    </div>
</main>

<?php get_footer(); ?>
