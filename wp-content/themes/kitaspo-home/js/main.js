/**
 * 北九州スポーツ整骨院 公式ホームページ - main.js
 */
(function () {
    'use strict';

    // スクロールで要素をフェードイン表示
    var targets = document.querySelectorAll('.fade-in');
    if ('IntersectionObserver' in window && targets.length) {
        var observer = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.15 }
        );
        targets.forEach(function (el) { observer.observe(el); });
    } else {
        targets.forEach(function (el) { el.classList.add('visible'); });
    }
})();
