<?php
/**
 * 404ページ
 */
get_header();
?>

<main id="main-content">
    <div class="page-hero">
        <h1>ページが見つかりません</h1>
    </div>
    <div class="content-area">
        <div class="entry-card" style="text-align:center;">
            <p>お探しのページは移動または削除された可能性があります。</p>
            <p><a href="<?php echo esc_url( home_url( '/' ) ); ?>">← トップページへ戻る</a></p>
        </div>
    </div>
</main>

<?php get_footer(); ?>
