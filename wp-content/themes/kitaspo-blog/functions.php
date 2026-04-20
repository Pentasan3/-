<?php
/**
 * 北九州スポーツ整骨院ブログ - functions.php
 */

define( 'KITASPO_VERSION', '1.0.0' );
define( 'KITASPO_DIR', get_template_directory() );
define( 'KITASPO_URI', get_template_directory_uri() );

/* ===== テーマセットアップ ===== */
function kitaspo_setup() {
    load_theme_textdomain( 'kitaspo-blog', KITASPO_DIR . '/languages' );

    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'responsive-embeds' );

    // カスタムアイキャッチサイズ
    add_image_size( 'kitaspo-card',  600, 400, true );
    add_image_size( 'kitaspo-hero', 1200, 600, true );
    add_image_size( 'kitaspo-thumb', 300, 200, true );

    // ナビゲーションメニュー
    register_nav_menus( [
        'primary'  => __( 'メインナビゲーション', 'kitaspo-blog' ),
        'footer'   => __( 'フッターナビゲーション', 'kitaspo-blog' ),
        'category' => __( 'カテゴリーメニュー', 'kitaspo-blog' ),
    ] );
}
add_action( 'after_setup_theme', 'kitaspo_setup' );

/* ===== スタイル・スクリプト読み込み ===== */
function kitaspo_enqueue_assets() {
    // Google Fonts（日本語対応）
    wp_enqueue_style(
        'kitaspo-fonts',
        'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&family=Noto+Serif+JP:wght@400;700;900&display=swap',
        [],
        null
    );

    // メインスタイルシート
    wp_enqueue_style(
        'kitaspo-style',
        get_stylesheet_uri(),
        [ 'kitaspo-fonts' ],
        KITASPO_VERSION
    );

    // Font Awesome (アイコン)
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
        [],
        '6.4.0'
    );

    // メインJS
    wp_enqueue_script(
        'kitaspo-main',
        KITASPO_URI . '/js/main.js',
        [ 'jquery' ],
        KITASPO_VERSION,
        true
    );

    wp_localize_script( 'kitaspo-main', 'kitaspoData', [
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'kitaspo_nonce' ),
    ] );

    if ( is_singular() && comments_open() ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'kitaspo_enqueue_assets' );

/* ===== ウィジェットエリア ===== */
function kitaspo_widgets_init() {
    $sidebars = [
        [
            'name'          => __( 'サイドバー（メイン）', 'kitaspo-blog' ),
            'id'            => 'sidebar-main',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ],
        [
            'name'          => __( 'フッターウィジェット 1', 'kitaspo-blog' ),
            'id'            => 'footer-1',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="footer-heading">',
            'after_title'   => '</h4>',
        ],
        [
            'name'          => __( 'フッターウィジェット 2', 'kitaspo-blog' ),
            'id'            => 'footer-2',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="footer-heading">',
            'after_title'   => '</h4>',
        ],
        [
            'name'          => __( 'フッターウィジェット 3', 'kitaspo-blog' ),
            'id'            => 'footer-3',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="footer-heading">',
            'after_title'   => '</h4>',
        ],
    ];

    foreach ( $sidebars as $sidebar ) {
        register_sidebar( $sidebar );
    }
}
add_action( 'widgets_init', 'kitaspo_widgets_init' );

/* ===== カスタム投稿タイプ（商品レビュー） ===== */
function kitaspo_register_post_types() {
    // 商品レビュー
    register_post_type( 'product_review', [
        'labels' => [
            'name'               => '商品レビュー',
            'singular_name'      => '商品レビュー',
            'add_new'            => '新規追加',
            'add_new_item'       => '商品レビューを追加',
            'edit_item'          => '商品レビューを編集',
            'view_item'          => '商品レビューを表示',
            'search_items'       => '商品レビューを検索',
        ],
        'public'            => true,
        'has_archive'       => true,
        'menu_icon'         => 'dashicons-star-filled',
        'supports'          => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
        'rewrite'           => [ 'slug' => 'reviews' ],
        'show_in_rest'      => true,
    ] );
}
add_action( 'init', 'kitaspo_register_post_types' );

/* ===== カスタムタクソノミー ===== */
function kitaspo_register_taxonomies() {
    // 症状カテゴリー
    register_taxonomy( 'symptom', [ 'post', 'product_review' ], [
        'labels' => [
            'name'          => '症状・部位',
            'singular_name' => '症状',
        ],
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite'      => [ 'slug' => 'symptom' ],
    ] );
}
add_action( 'init', 'kitaspo_register_taxonomies' );

/* ===== カスタムメタフィールド（商品情報） ===== */
function kitaspo_add_product_meta_boxes() {
    add_meta_box(
        'kitaspo_product_info',
        '商品・アフィリエイト情報',
        'kitaspo_render_product_meta',
        [ 'post', 'product_review' ],
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'kitaspo_add_product_meta_boxes' );

function kitaspo_render_product_meta( $post ) {
    wp_nonce_field( 'kitaspo_product_meta', 'kitaspo_product_nonce' );
    $fields = [
        'kitaspo_affiliate_url'   => 'アフィリエイトURL',
        'kitaspo_product_price'   => '商品価格（例: 3,980円）',
        'kitaspo_product_amazon'  => 'Amazon URL',
        'kitaspo_product_rakuten' => '楽天市場 URL',
        'kitaspo_review_score'    => '評価スコア（1〜5）',
        'kitaspo_product_pros'    => 'メリット（改行区切り）',
        'kitaspo_product_cons'    => 'デメリット（改行区切り）',
    ];
    echo '<table class="form-table">';
    foreach ( $fields as $key => $label ) {
        $val = get_post_meta( $post->ID, $key, true );
        $tag = in_array( $key, [ 'kitaspo_product_pros', 'kitaspo_product_cons' ], true ) ? 'textarea' : 'input';
        echo '<tr><th><label for="' . esc_attr( $key ) . '">' . esc_html( $label ) . '</label></th><td>';
        if ( $tag === 'textarea' ) {
            echo '<textarea id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" rows="4" style="width:100%">' . esc_textarea( $val ) . '</textarea>';
        } else {
            echo '<input type="text" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" style="width:100%">';
        }
        echo '</td></tr>';
    }
    echo '</table>';
}

function kitaspo_save_product_meta( $post_id ) {
    if ( ! isset( $_POST['kitaspo_product_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['kitaspo_product_nonce'] ) ), 'kitaspo_product_meta' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $text_fields = [ 'kitaspo_affiliate_url', 'kitaspo_product_price', 'kitaspo_product_amazon', 'kitaspo_product_rakuten', 'kitaspo_review_score', 'kitaspo_product_pros', 'kitaspo_product_cons' ];
    foreach ( $text_fields as $field ) {
        if ( isset( $_POST[ $field ] ) ) {
            update_post_meta( $post_id, $field, sanitize_textarea_field( wp_unslash( $_POST[ $field ] ) ) );
        }
    }
}
add_action( 'save_post', 'kitaspo_save_product_meta' );

/* ===== ショートコード ===== */

// アフィリエイトボタン: [kitaspo_btn url="..." text="..." color="red"]
function kitaspo_affiliate_btn_shortcode( $atts ) {
    $atts = shortcode_atts( [
        'url'   => '#',
        'text'  => '詳細を見る・購入はこちら',
        'color' => 'red',
        'icon'  => '🛒',
        'rel'   => 'nofollow noopener noreferrer',
    ], $atts, 'kitaspo_btn' );

    $color_map = [
        'red'    => '#e74c3c',
        'blue'   => '#2980b9',
        'green'  => '#27ae60',
        'orange' => '#e67e22',
        'gold'   => '#f39c12',
    ];
    $bg = $color_map[ $atts['color'] ] ?? $color_map['red'];

    return sprintf(
        '<div class="kitaspo-btn-wrap" style="text-align:center;margin:25px 0;">
            <a href="%s" target="_blank" rel="%s" class="kitaspo-affiliate-btn" style="display:inline-block;background:%s;color:#fff;font-weight:700;font-size:1rem;padding:15px 35px;border-radius:30px;text-decoration:none;box-shadow:0 4px 15px rgba(0,0,0,0.2);">%s %s</a>
            <p style="font-size:0.75rem;color:#999;margin-top:8px;">※ 外部サイトへ移動します</p>
        </div>',
        esc_url( $atts['url'] ),
        esc_attr( $atts['rel'] ),
        esc_attr( $bg ),
        esc_html( $atts['icon'] ),
        esc_html( $atts['text'] )
    );
}
add_shortcode( 'kitaspo_btn', 'kitaspo_affiliate_btn_shortcode' );

// 商品カード: [kitaspo_product name="..." price="..." url="..." emoji="🏋️"]
function kitaspo_product_card_shortcode( $atts ) {
    $atts = shortcode_atts( [
        'name'  => '',
        'price' => '',
        'url'   => '#',
        'emoji' => '📦',
        'desc'  => '',
        'score' => '5',
    ], $atts, 'kitaspo_product' );

    $stars = '';
    $score = min( 5, max( 1, (int) $atts['score'] ) );
    for ( $i = 1; $i <= 5; $i++ ) {
        $stars .= $i <= $score ? '★' : '☆';
    }

    return sprintf(
        '<div class="product-card">
            <div class="product-image" style="width:140px;min-height:140px;background:#ecf0f1;display:flex;align-items:center;justify-content:center;font-size:3rem;">%s</div>
            <div class="product-info" style="padding:18px;flex:1;">
                <div class="product-name" style="font-weight:700;font-size:1rem;margin-bottom:6px;">%s</div>
                <div style="color:#f39c12;font-size:1.1rem;margin-bottom:8px;">%s</div>
                <div class="product-desc" style="font-size:0.85rem;color:#7f8c8d;margin-bottom:10px;">%s</div>
                <div class="product-price" style="font-size:1.2rem;font-weight:700;color:#e74c3c;margin-bottom:12px;">%s</div>
                <a href="%s" target="_blank" rel="nofollow noopener noreferrer" class="btn-buy" style="display:inline-block;background:#f39c12;color:#2c3e50;font-weight:700;font-size:0.875rem;padding:8px 20px;border-radius:4px;text-decoration:none;">Amazonで購入 →</a>
            </div>
        </div>',
        esc_html( $atts['emoji'] ),
        esc_html( $atts['name'] ),
        esc_html( $stars ),
        esc_html( $atts['desc'] ),
        esc_html( $atts['price'] ),
        esc_url( $atts['url'] )
    );
}
add_shortcode( 'kitaspo_product', 'kitaspo_product_card_shortcode' );

// 注意書きボックス: [kitaspo_notice type="info"] ... [/kitaspo_notice]
function kitaspo_notice_shortcode( $atts, $content = '' ) {
    $atts = shortcode_atts( [ 'type' => 'info' ], $atts, 'kitaspo_notice' );
    $icons = [ 'info' => 'ℹ️', 'warning' => '⚠️', 'danger' => '🚨', 'success' => '✅' ];
    $icon  = $icons[ $atts['type'] ] ?? 'ℹ️';
    return sprintf(
        '<div class="notice-box %s"><span class="notice-icon">%s</span><div>%s</div></div>',
        esc_attr( $atts['type'] ),
        $icon,
        wp_kses_post( $content )
    );
}
add_shortcode( 'kitaspo_notice', 'kitaspo_notice_shortcode' );

// 評価ボックス: [kitaspo_review score="4.5" title="総合評価"]
function kitaspo_review_shortcode( $atts ) {
    $atts = shortcode_atts( [
        'score' => '5',
        'title' => '総合評価',
    ], $atts, 'kitaspo_review' );

    $score      = (float) $atts['score'];
    $full       = floor( $score );
    $half       = ( $score - $full ) >= 0.5 ? 1 : 0;
    $empty      = 5 - $full - $half;
    $stars_html = str_repeat( '<span style="color:#f39c12">★</span>', (int) $full );
    if ( $half ) {
        $stars_html .= '<span style="color:#f39c12">☆</span>';
    }
    $stars_html .= str_repeat( '<span style="color:#ddd">★</span>', (int) $empty );

    return sprintf(
        '<div style="background:#fff9e6;border:2px solid #f39c12;border-radius:8px;padding:20px;text-align:center;margin:20px 0;">
            <div style="font-weight:700;color:#2c3e50;margin-bottom:8px;">%s</div>
            <div style="font-size:2rem;">%s</div>
            <div style="font-size:2.5rem;font-weight:900;color:#f39c12;margin:5px 0;">%s</div>
            <div style="font-size:0.85rem;color:#999;">/ 5.0</div>
        </div>',
        esc_html( $atts['title'] ),
        $stars_html,
        esc_html( number_format( $score, 1 ) )
    );
}
add_shortcode( 'kitaspo_review', 'kitaspo_review_shortcode' );

/* ===== SEO・OGP タグ ===== */
function kitaspo_add_meta_tags() {
    global $post;

    $site_name = get_bloginfo( 'name' );
    $desc      = get_bloginfo( 'description' );

    if ( is_singular() && isset( $post ) ) {
        $title   = get_the_title( $post->ID );
        $excerpt = has_excerpt( $post->ID )
            ? wp_strip_all_tags( get_the_excerpt( $post->ID ) )
            : wp_trim_words( wp_strip_all_tags( get_the_content( null, false, $post->ID ) ), 60, '...' );
        $url     = get_permalink( $post->ID );
        $image   = has_post_thumbnail( $post->ID ) ? get_the_post_thumbnail_url( $post->ID, 'large' ) : KITASPO_URI . '/images/ogp-default.jpg';
    } else {
        $title   = $site_name . ' - ' . $desc;
        $excerpt = $desc;
        $url     = home_url( '/' );
        $image   = KITASPO_URI . '/images/ogp-default.jpg';
    }

    $tags = [
        'description'         => $excerpt,
        'og:title'            => $title,
        'og:description'      => $excerpt,
        'og:url'              => $url,
        'og:image'            => $image,
        'og:type'             => is_singular() ? 'article' : 'website',
        'og:site_name'        => $site_name,
        'og:locale'           => 'ja_JP',
        'twitter:card'        => 'summary_large_image',
        'twitter:title'       => $title,
        'twitter:description' => $excerpt,
        'twitter:image'       => $image,
    ];

    foreach ( $tags as $name => $content ) {
        if ( str_starts_with( $name, 'og:' ) ) {
            printf( '<meta property="%s" content="%s">' . "\n", esc_attr( $name ), esc_attr( $content ) );
        } else {
            printf( '<meta name="%s" content="%s">' . "\n", esc_attr( $name ), esc_attr( $content ) );
        }
    }
}
add_action( 'wp_head', 'kitaspo_add_meta_tags' );

/* ===== パンくずリスト ===== */
function kitaspo_breadcrumb() {
    echo '<nav class="breadcrumb" aria-label="パンくずリスト"><ol class="breadcrumb-list">';
    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">🏠 ホーム</a></li>';

    if ( is_category() || is_single() ) {
        $categories = get_the_category();
        if ( $categories ) {
            $cat = $categories[0];
            echo '<li><a href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . esc_html( $cat->name ) . '</a></li>';
        }
        if ( is_single() ) {
            echo '<li><span>' . esc_html( get_the_title() ) . '</span></li>';
        }
    } elseif ( is_page() ) {
        echo '<li><span>' . esc_html( get_the_title() ) . '</span></li>';
    } elseif ( is_search() ) {
        echo '<li><span>検索結果: ' . esc_html( get_search_query() ) . '</span></li>';
    } elseif ( is_archive() ) {
        echo '<li><span>' . esc_html( get_the_archive_title() ) . '</span></li>';
    }

    echo '</ol></nav>';
}

/* ===== 投稿件数をコンテンツ数に含める ===== */
function kitaspo_adjust_excerpt_length( $length ) {
    return is_admin() ? $length : 80;
}
add_filter( 'excerpt_length', 'kitaspo_adjust_excerpt_length' );

function kitaspo_excerpt_more( $more ) {
    return '…';
}
add_filter( 'excerpt_more', 'kitaspo_excerpt_more' );

/* ===== 管理バー非表示（フロントエンド） ===== */
add_filter( 'show_admin_bar', '__return_false' );

/* ===== セキュリティ設定 ===== */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
