<?php get_header(); ?>
<?php kitaspo_breadcrumb(); ?>

<main id="main-content">
    <div class="content-area">
        <section class="main-column">
            <h1 class="section-title">
                🔍 「<?php echo esc_html( get_search_query() ); ?>」の検索結果
                <span style="font-size:0.8rem;font-weight:normal;color:var(--color-text-light);">
                    (<?php echo esc_html( $wp_query->found_posts ); ?>件)
                </span>
            </h1>

            <?php if ( have_posts() ) : ?>
                <div class="posts-grid">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part( 'template-parts/card', 'post' ); ?>
                    <?php endwhile; ?>
                </div>
                <nav class="pagination">
                    <?php echo wp_kses_post( paginate_links( [ 'prev_text' => '«', 'next_text' => '»' ] ) ); ?>
                </nav>
            <?php else : ?>
                <div style="background:var(--color-white);border-radius:var(--radius);padding:50px;text-align:center;box-shadow:var(--shadow);">
                    <div style="font-size:3rem;margin-bottom:15px;">🔍</div>
                    <h2 style="color:var(--color-dark);margin-bottom:10px;">該当する記事が見つかりませんでした</h2>
                    <p style="color:var(--color-text-light);margin-bottom:20px;">別のキーワードでお試しください。</p>
                    <?php get_search_form(); ?>
                </div>
            <?php endif; ?>
        </section>

        <?php get_sidebar(); ?>
    </div>
</main>

<?php get_footer(); ?>
