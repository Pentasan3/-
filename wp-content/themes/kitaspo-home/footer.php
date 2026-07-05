<footer id="site-footer" role="contentinfo">
    <div class="footer-inner">
        <div class="footer-brand">
            <div class="name"><?php bloginfo( 'name' ); ?></div>
            <div><?php echo esc_html( kitaspo_home_info( 'address' ) ); ?></div>
            <div><?php echo esc_html( kitaspo_home_info( 'access' ) ); ?>｜TEL: <?php echo esc_html( kitaspo_home_info( 'tel' ) ); ?></div>
            <div class="footer-sns">
                <a href="<?php echo esc_url( kitaspo_home_info( 'line_url' ) ); ?>" target="_blank" rel="noopener">LINE</a>
                <a href="<?php echo esc_url( kitaspo_home_info( 'insta_url' ) ); ?>" target="_blank" rel="noopener">Instagram</a>
                <a href="<?php echo esc_url( kitaspo_home_info( 'youtube_url' ) ); ?>" target="_blank" rel="noopener">YouTube</a>
                <a href="<?php echo esc_url( kitaspo_home_info( 'blog_url' ) ); ?>" target="_blank" rel="noopener">ブログ</a>
            </div>
        </div>
        <nav class="footer-nav" aria-label="フッターナビゲーション">
            <?php
            wp_nav_menu( [
                'theme_location' => 'footer',
                'container'      => false,
                'fallback_cb'    => 'kitaspo_home_fallback_menu',
            ] );
            ?>
        </nav>
    </div>
    <div class="copyright">
        &copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?> All Rights Reserved.
    </div>
</footer>

<!-- モバイル固定CTA -->
<div class="mobile-cta">
    <a class="tel" href="tel:<?php echo esc_attr( str_replace( '-', '', kitaspo_home_info( 'tel' ) ) ); ?>">
        📞 電話で予約<span><?php echo esc_html( kitaspo_home_info( 'tel' ) ); ?></span>
    </a>
    <a class="line" href="<?php echo esc_url( kitaspo_home_info( 'line_url' ) ); ?>" target="_blank" rel="noopener">
        💬 LINEで予約<span>24時間受付</span>
    </a>
</div>

<?php wp_footer(); ?>
</body>
</html>
