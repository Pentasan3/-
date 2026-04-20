/* 北九州スポーツ整骨院ブログ - main.js */
(function ($) {
    'use strict';

    /* ===== スクロールトップボタン ===== */
    var $scrollBtn = $('#scroll-top');

    $(window).on('scroll.kitaspo', function () {
        if ($(this).scrollTop() > 300) {
            $scrollBtn.addClass('visible');
        } else {
            $scrollBtn.removeClass('visible');
        }
    });

    $scrollBtn.on('click.kitaspo', function () {
        $('html, body').animate({ scrollTop: 0 }, 400);
    });

    /* ===== ハンバーガーメニュー ===== */
    var $toggle = $('.menu-toggle');
    var $menu   = $('#primary-menu');

    $toggle.on('click.kitaspo', function () {
        var expanded = $(this).attr('aria-expanded') === 'true';
        $(this).attr('aria-expanded', !expanded);
        $menu.toggleClass('active');
    });

    // メニュー外クリックで閉じる
    $(document).on('click.kitaspo', function (e) {
        if (!$(e.target).closest('#site-nav').length) {
            $menu.removeClass('active');
            $toggle.attr('aria-expanded', 'false');
        }
    });

    /* ===== 外部リンクに rel/target 自動付与 ===== */
    var siteHost = window.location.hostname;
    $('a[href^="http"]').each(function () {
        try {
            var linkHost = new URL($(this).attr('href')).hostname;
            if (linkHost !== siteHost) {
                $(this).attr({
                    target : '_blank',
                    rel    : 'nofollow noopener noreferrer'
                });
            }
        } catch (e) { /* 無効なURLはスキップ */ }
    });

    /* ===== アフィリエイトボタン クリックトラッキング（GA4対応） ===== */
    $(document).on('click.kitaspo', '.kitaspo-affiliate-btn, .btn-affiliate, .btn-buy', function () {
        var label = $(this).text().trim() || 'affiliate-click';
        var href  = $(this).attr('href') || '';

        if (typeof gtag === 'function') {
            gtag('event', 'affiliate_click', {
                event_category : 'Affiliate',
                event_label    : label,
                outbound_url   : href
            });
        }
    });

    /* ===== 遅延画像読み込み（ネイティブ未対応ブラウザ用フォールバック） ===== */
    if ('IntersectionObserver' in window) {
        var imgObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    var img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                    }
                    imgObserver.unobserve(img);
                }
            });
        }, { rootMargin: '200px' });

        $('img[data-src]').each(function () {
            imgObserver.observe(this);
        });
    }

    /* ===== スムーズスクロール（アンカーリンク） ===== */
    $(document).on('click.kitaspo', 'a[href^="#"]', function (e) {
        var target = $($(this).attr('href'));
        if (target.length) {
            e.preventDefault();
            var offset = $('#site-header').outerHeight() + 10;
            $('html, body').animate({ scrollTop: target.offset().top - offset }, 400);
        }
    });

    /* ===== テーブルレスポンシブラッパー ===== */
    $('.entry-content table').each(function () {
        if (!$(this).parent().hasClass('table-wrap')) {
            $(this).wrap('<div class="table-wrap" style="overflow-x:auto;margin:20px 0;"></div>');
        }
    });

}(jQuery));
