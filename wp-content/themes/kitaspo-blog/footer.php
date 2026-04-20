<!-- ===== フッター ===== -->
<footer id="site-footer" role="contentinfo">
    <div class="footer-grid">
        <!-- ブランド -->
        <div class="footer-brand">
            <div class="footer-logo">🏥 北九州スポーツ整骨院ブログ</div>
            <p>
                北九州市でスポーツ障害・腰痛・肩こり・交通事故後遺症など<br>
                あらゆる身体の不調に対応する整骨院の公式ブログです。<br>
                専門家が厳選したおすすめ商品・セルフケア情報を発信しています。
            </p>
            <div class="footer-social">
                <a href="#" aria-label="LINE">LINE</a>
                <a href="#" aria-label="Instagram">IG</a>
                <a href="#" aria-label="Twitter/X">X</a>
                <a href="#" aria-label="YouTube">YT</a>
            </div>
        </div>

        <!-- カテゴリー -->
        <div>
            <h4 class="footer-heading">カテゴリー</h4>
            <ul class="footer-links">
                <li><a href="<?php echo esc_url( home_url( '/category/sports-injury/' ) ); ?>">🏃 スポーツ障害</a></li>
                <li><a href="<?php echo esc_url( home_url( '/category/back-pain/' ) ); ?>">💪 腰痛・肩こり</a></li>
                <li><a href="<?php echo esc_url( home_url( '/category/treatment/' ) ); ?>">🩺 施術・ケア方法</a></li>
                <li><a href="<?php echo esc_url( home_url( '/category/supplement/' ) ); ?>">💊 サプリメント</a></li>
                <li><a href="<?php echo esc_url( home_url( '/category/sports-goods/' ) ); ?>">🏋️ スポーツ用品</a></li>
                <li><a href="<?php echo esc_url( home_url( '/category/affiliate/' ) ); ?>">⭐ おすすめ商品</a></li>
            </ul>
        </div>

        <!-- クリニック情報 -->
        <div>
            <h4 class="footer-heading">整骨院情報</h4>
            <ul class="footer-links" style="font-size:0.85rem;line-height:1.8;">
                <li>📍 福岡県北九州市</li>
                <li>📞 受付時間内でご相談ください</li>
                <li>🕐 平日 9:00〜20:00</li>
                <li>🕐 土曜 9:00〜17:00</li>
                <li>🚫 日曜・祝日 休診</li>
            </ul>
        </div>

        <!-- サイトマップ -->
        <div>
            <h4 class="footer-heading">サイトマップ</h4>
            <ul class="footer-links">
                <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">ホーム</a></li>
                <li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">院について</a></li>
                <li><a href="<?php echo esc_url( home_url( '/menu/' ) ); ?>">施術メニュー</a></li>
                <li><a href="<?php echo esc_url( home_url( '/ranking/' ) ); ?>">おすすめランキング</a></li>
                <li><a href="<?php echo esc_url( home_url( '/access/' ) ); ?>">アクセス</a></li>
                <li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">プライバシーポリシー</a></li>
                <li><a href="<?php echo esc_url( home_url( '/disclaimer/' ) ); ?>">免責事項</a></li>
                <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">お問い合わせ</a></li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?> All Rights Reserved.</p>
        <p class="footer-disclaimer">
            当ブログで紹介している商品・サービスにはアフィリエイト広告（Amazon アソシエイト・楽天アフィリエイト等）が含まれます。
            掲載情報は執筆時点のものです。効果・効能を保証するものではありません。
            身体の異常は必ず専門の医師・柔道整復師にご相談ください。
        </p>
    </div>
</footer>

<!-- スクロールトップボタン -->
<button id="scroll-top" aria-label="ページトップへ戻る">▲</button>

<?php wp_footer(); ?>
</body>
</html>
