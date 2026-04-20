<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main-content">メインコンテンツへスキップ</a>

<!-- ===== お知らせバー ===== -->
<div style="background:var(--color-accent);color:#fff;text-align:center;padding:8px 15px;font-size:0.85rem;font-weight:600;">
    📢 当ブログは北九州スポーツ整骨院が提供する健康・スポーツ情報サイトです。アフィリエイト広告を含む場合があります。
</div>

<!-- ===== ヘッダー ===== -->
<header id="site-header" role="banner">
    <div class="header-inner">
        <div class="site-branding">
            <div class="site-logo" aria-hidden="true">北</div>
            <div>
                <div class="site-title">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                </div>
                <div class="site-subtitle"><?php bloginfo( 'description' ); ?></div>
            </div>
        </div>

        <nav id="site-nav" role="navigation" aria-label="メインナビゲーション">
            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="メニューを開く">
                &#9776;
            </button>
            <?php
            wp_nav_menu( [
                'theme_location' => 'primary',
                'menu_id'        => 'primary-menu',
                'menu_class'     => 'nav-menu',
                'container'      => false,
                'fallback_cb'    => 'kitaspo_fallback_menu',
            ] );
            ?>
        </nav>
    </div>
</header>

<?php
function kitaspo_fallback_menu() {
    echo '<ul class="nav-menu">';
    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">ホーム</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/category/sports-injury/' ) ) . '">スポーツ障害</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/category/treatment/' ) ) . '">施術メニュー</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/category/affiliate/' ) ) . '">おすすめ商品</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/about/' ) ) . '">院について</a></li>';
    echo '</ul>';
}
?>
