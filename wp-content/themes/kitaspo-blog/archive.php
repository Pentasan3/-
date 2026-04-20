<?php get_header(); ?>
<?php kitaspo_breadcrumb(); ?>

<main id="main-content">
    <div class="content-area">
        <section class="main-column">
            <header class="archive-header" style="margin-bottom:25px;">
                <h1 class="section-title">
                    <?php the_archive_title(); ?>
                </h1>
                <?php if ( get_the_archive_description() ) : ?>
                    <div style="color:var(--color-text-light);font-size:0.95rem;margin-top:-10px;margin-bottom:20px;">
                        <?php echo wp_kses_post( get_the_archive_description() ); ?>
                    </div>
                <?php endif; ?>
            </header>

            <?php if ( have_posts() ) : ?>
                <div class="posts-grid">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part( 'template-parts/card', 'post' ); ?>
                    <?php endwhile; ?>
                </div>
                <nav class="pagination" aria-label="ページナビゲーション">
                    <?php echo wp_kses_post( paginate_links( [ 'prev_text' => '«', 'next_text' => '»' ] ) ); ?>
                </nav>
            <?php else : ?>
                <p style="text-align:center;padding:40px;color:var(--color-text-light);">記事がありません。</p>
            <?php endif; ?>
        </section>

        <?php get_sidebar(); ?>
    </div>
</main>

<?php get_footer(); ?>
