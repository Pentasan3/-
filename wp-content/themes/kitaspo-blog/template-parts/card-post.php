<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
    <!-- サムネイル -->
    <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
        <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail( 'kitaspo-card', [ 'class' => 'post-card-thumbnail', 'loading' => 'lazy' ] ); ?>
        <?php else : ?>
            <div class="post-card-thumbnail" style="background:linear-gradient(135deg,var(--color-primary),var(--color-secondary));height:200px;display:flex;align-items:center;justify-content:center;font-size:4rem;">
                <?php
                $cats = get_the_category();
                $emoji_map = [
                    'sports-injury' => '🏃',
                    'back-pain'     => '💪',
                    'treatment'     => '🩺',
                    'supplement'    => '💊',
                    'sports-goods'  => '🏋️',
                    'affiliate'     => '⭐',
                    'column'        => '📖',
                ];
                $emoji = '📝';
                if ( $cats ) {
                    foreach ( $emoji_map as $slug => $e ) {
                        if ( $cats[0]->slug === $slug ) {
                            $emoji = $e;
                            break;
                        }
                    }
                }
                echo esc_html( $emoji );
                ?>
            </div>
        <?php endif; ?>
    </a>

    <div class="post-card-body">
        <!-- カテゴリー -->
        <?php
        $cats = get_the_category();
        if ( $cats ) :
            $cat = $cats[0];
            $cat_class_map = [
                'affiliate'     => 'cat-affiliate',
                'treatment'     => 'cat-treatment',
                'sports-injury' => 'cat-sports',
                'sports-goods'  => 'cat-sports',
            ];
            $extra = $cat_class_map[ $cat->slug ] ?? '';
        ?>
            <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"
               class="post-card-category <?php echo esc_attr( $extra ); ?>">
                <?php echo esc_html( $cat->name ); ?>
            </a>
        <?php endif; ?>

        <!-- タイトル -->
        <h2 class="post-card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>

        <!-- 抜粋 -->
        <p class="post-card-excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>

        <!-- メタ情報 -->
        <div class="post-card-meta">
            <span><span class="icon">📅</span><?php echo esc_html( get_the_date( 'Y.n.j' ) ); ?></span>
            <span><span class="icon">✍️</span><?php the_author(); ?></span>
        </div>
    </div>
</article>
