<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main-content">メインコンテンツへスキップ</a>

<header id="site-header" role="banner">
    <div class="header-inner">
        <div class="site-branding">
            <div class="site-logo" aria-hidden="true">北</div>
            <div>
                <div class="site-title">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                </div>
                <div class="site-subtitle">スポーツ障害専門｜JR南小倉駅 徒歩1分</div>
            </div>
        </div>

        <nav id="site-nav" role="navigation" aria-label="メインナビゲーション">
            <?php
            wp_nav_menu( [
                'theme_location' => 'primary',
                'menu_class'     => 'nav-menu',
                'container'      => false,
                'fallback_cb'    => 'kitaspo_home_fallback_menu',
            ] );
            ?>
        </nav>

        <div class="header-cta">
            <div class="header-tel">
                <div class="tel-number">📞 <?php echo esc_html( kitaspo_home_info( 'tel' ) ); ?></div>
                <div class="tel-note">予約優先制・<?php echo esc_html( kitaspo_home_info( 'closed' ) ); ?>休</div>
            </div>
            <a class="btn-line-s" href="<?php echo esc_url( kitaspo_home_info( 'line_url' ) ); ?>" target="_blank" rel="noopener">LINE予約</a>
        </div>
    </div>
</header>

<?php
function kitaspo_home_fallback_menu() {
    $items = [
        '#symptoms' => '対応症状',
        '#reasons'  => '選ばれる理由',
        '#menu'     => 'メニュー・料金',
        '#access'   => 'アクセス',
    ];
    echo '<ul class="nav-menu">';
    foreach ( $items as $anchor => $label ) {
        echo '<li><a href="' . esc_url( home_url( '/' ) . $anchor ) . '">' . esc_html( $label ) . '</a></li>';
    }
    echo '</ul>';
}
?>
