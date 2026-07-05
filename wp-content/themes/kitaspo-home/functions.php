<?php
/**
 * 北九州スポーツ整骨院 公式ホームページ - functions.php
 */

define( 'KITASPO_HOME_VERSION', '1.0.0' );

/* ===== テーマセットアップ ===== */
function kitaspo_home_setup() {
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );
    add_theme_support( 'responsive-embeds' );

    register_nav_menus( [
        'primary' => __( 'メインナビゲーション', 'kitaspo-home' ),
        'footer'  => __( 'フッターナビゲーション', 'kitaspo-home' ),
    ] );
}
add_action( 'after_setup_theme', 'kitaspo_home_setup' );

/* ===== スタイル・スクリプト ===== */
function kitaspo_home_enqueue() {
    wp_enqueue_style(
        'kitaspo-home-fonts',
        'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;600;700;800;900&display=swap',
        [],
        null
    );
    wp_enqueue_style( 'kitaspo-home-style', get_stylesheet_uri(), [ 'kitaspo-home-fonts' ], KITASPO_HOME_VERSION );
    wp_enqueue_script( 'kitaspo-home-main', get_template_directory_uri() . '/js/main.js', [], KITASPO_HOME_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'kitaspo_home_enqueue' );

/* ===== 院情報（カスタマイザーで編集可能） ===== */

/**
 * 院情報のデフォルト値。
 * 管理画面「外観」>「カスタマイズ」>「院情報」で変更できます。
 */
function kitaspo_home_defaults() {
    return [
        'tel'        => '093-967-9009',
        'address'    => '〒803-0856 福岡県北九州市小倉北区弁天町5-8',
        'access'     => 'JR南小倉駅から徒歩1分',
        'line_url'   => 'https://page.line.me/yai3061q',
        'insta_url'  => 'https://www.instagram.com/kitaspo_kokura/',
        'blog_url'   => 'https://ameblo.jp/kitaspo/',
        'map_url'    => 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( '北九州スポーツ整骨院 北九州市小倉北区弁天町5-8' ),
        'hours_note' => '※ 予約優先制です。お電話またはLINEでご希望の日時をお知らせください。',
        'closed'     => '日曜・祝日',
    ];
}

function kitaspo_home_info( $key ) {
    $defaults = kitaspo_home_defaults();
    return get_theme_mod( 'kitaspo_' . $key, $defaults[ $key ] ?? '' );
}

function kitaspo_home_customize( $wp_customize ) {
    $wp_customize->add_section( 'kitaspo_info', [
        'title'    => '院情報',
        'priority' => 25,
    ] );

    $fields = [
        'tel'        => '電話番号',
        'address'    => '住所',
        'access'     => 'アクセス',
        'line_url'   => 'LINE公式アカウントURL',
        'insta_url'  => 'Instagram URL',
        'blog_url'   => 'ブログURL',
        'map_url'    => 'GoogleマップURL',
        'hours_note' => '営業時間の補足',
        'closed'     => '定休日',
    ];

    foreach ( $fields as $key => $label ) {
        $wp_customize->add_setting( 'kitaspo_' . $key, [
            'default'           => kitaspo_home_defaults()[ $key ],
            'sanitize_callback' => str_ends_with( $key, '_url' ) ? 'esc_url_raw' : 'sanitize_text_field',
        ] );
        $wp_customize->add_control( 'kitaspo_' . $key, [
            'label'   => $label,
            'section' => 'kitaspo_info',
            'type'    => 'text',
        ] );
    }
}
add_action( 'customize_register', 'kitaspo_home_customize' );

/* ===== CTAボタン（電話＋LINE）共通パーツ ===== */
function kitaspo_home_cta_buttons() {
    $tel  = kitaspo_home_info( 'tel' );
    $line = kitaspo_home_info( 'line_url' );
    ?>
    <div class="hero-cta">
        <a class="btn-cta tel" href="tel:<?php echo esc_attr( str_replace( '-', '', $tel ) ); ?>">
            <span class="small">お電話でのご予約はこちら</span>
            <span class="big">📞 <?php echo esc_html( $tel ); ?></span>
        </a>
        <a class="btn-cta line" href="<?php echo esc_url( $line ); ?>" target="_blank" rel="noopener">
            <span class="small">24時間受付・友だち追加で簡単</span>
            <span class="big">💬 LINEで予約する</span>
        </a>
    </div>
    <?php
}

/* ===== OGP ===== */
function kitaspo_home_meta_tags() {
    $site_name = get_bloginfo( 'name' );
    $desc      = get_bloginfo( 'description' );

    if ( is_singular() ) {
        $title = get_the_title();
        $url   = get_permalink();
        $text  = has_excerpt() ? wp_strip_all_tags( get_the_excerpt() ) : $desc;
    } else {
        $title = $site_name;
        $url   = home_url( '/' );
        $text  = $desc;
    }

    $tags = [
        'og:title'       => $title,
        'og:description' => $text,
        'og:url'         => $url,
        'og:type'        => is_singular() ? 'article' : 'website',
        'og:site_name'   => $site_name,
        'og:locale'      => 'ja_JP',
    ];
    printf( '<meta name="description" content="%s">' . "\n", esc_attr( $text ) );
    foreach ( $tags as $name => $content ) {
        printf( '<meta property="%s" content="%s">' . "\n", esc_attr( $name ), esc_attr( $content ) );
    }
}
add_action( 'wp_head', 'kitaspo_home_meta_tags' );

/* ===== 構造化データ（ローカルビジネス） ===== */
function kitaspo_home_json_ld() {
    if ( ! is_front_page() ) {
        return;
    }
    $schema = [
        '@context'  => 'https://schema.org',
        '@type'     => 'MedicalBusiness',
        'name'      => get_bloginfo( 'name' ),
        'telephone' => kitaspo_home_info( 'tel' ),
        'address'   => kitaspo_home_info( 'address' ),
        'url'       => home_url( '/' ),
    ];
    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
add_action( 'wp_head', 'kitaspo_home_json_ld' );

/* ===== 表示調整 ===== */
add_filter( 'excerpt_length', function () { return 60; } );
add_filter( 'excerpt_more', function () { return '…'; } );
add_filter( 'show_admin_bar', '__return_false' );

/* ===== セキュリティ ===== */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
