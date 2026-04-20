<?php get_header(); ?>

<main id="main-content">
    <div class="container" style="text-align:center;padding:80px 20px;">
        <div style="font-size:5rem;margin-bottom:20px;">😔</div>
        <h1 style="font-family:var(--font-heading);font-size:2rem;color:var(--color-dark);margin-bottom:15px;">404 - ページが見つかりません</h1>
        <p style="color:var(--color-text-light);font-size:1rem;margin-bottom:30px;line-height:1.8;">
            お探しのページは移動・削除された可能性があります。<br>
            下記リンクからお探しください。
        </p>
        <div style="display:flex;gap:15px;justify-content:center;flex-wrap:wrap;margin-bottom:40px;">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="background:var(--color-secondary);color:#fff;padding:12px 25px;border-radius:30px;text-decoration:none;font-weight:700;">
                🏠 トップページへ
            </a>
        </div>
        <?php get_search_form(); ?>
    </div>
</main>

<?php get_footer(); ?>
