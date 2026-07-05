<?php
/**
 * フロントページ（要点をまとめたコンパクト構成）
 */
get_header();
?>

<main id="main-content">

    <!-- ===== ヒーロー ===== -->
    <section class="hero">
        <div class="hero-inner">
            <div class="hero-badge"><span>スポーツ障害専門 × 施術歴20年</span></div>
            <h1>
                スポーツのケガを、<br>
                <span class="accent">最短でプレー復帰</span>へ。
            </h1>
            <p class="hero-lead">
                北九州スポーツ整骨院は、部活動に励む学生からトップアスリート、日常の痛みに悩む方まで。
                施術からコンディショニング・ケガの予防までを一貫して行う、
                北九州で唯一の「ケアステーション（Care &amp; Conditioning）」です。
            </p>
            <ul class="hero-points">
                <li>✔ JR南小倉駅 徒歩1分</li>
                <li>✔ 夜9時まで営業（最終受付20:30）</li>
                <li>✔ 練習を休まず治せる</li>
                <li>✔ 酸素カプセルで疲労回復</li>
                <li>✔ 各種保険取扱</li>
            </ul>
            <?php kitaspo_home_cta_buttons(); ?>
        </div>
    </section>

    <!-- ===== 対応症状 ===== -->
    <section id="symptoms" class="section alt">
        <div class="container">
            <div class="section-head fade-in">
                <div class="section-label">Symptoms</div>
                <h2 class="section-title">こんな症状はお任せください</h2>
            </div>
            <div class="symptom-grid fade-in">
                <?php
                $symptoms = [
                    [ '🏃', '捻挫・肉離れ', '足首・太もも・ふくらはぎ' ],
                    [ '⚾', '野球肘・野球肩', '投球動作による痛み' ],
                    [ '🎾', 'テニス肘・ゴルフ肘', '肘の外側・内側の痛み' ],
                    [ '🦵', 'オスグッド', '成長期の膝の痛み' ],
                    [ '👟', 'シンスプリント', 'すねの内側の痛み' ],
                    [ '🏋️', '腰痛・ぎっくり腰', 'スポーツ・日常生活' ],
                    [ '🤕', '突き指・打撲', '球技・コンタクトスポーツ' ],
                    [ '💪', 'コンディショニング', '疲労回復・パフォーマンス向上' ],
                ];
                foreach ( $symptoms as $s ) :
                    ?>
                    <div class="symptom-card">
                        <div class="symptom-icon"><?php echo esc_html( $s[0] ); ?></div>
                        <div class="symptom-name"><?php echo esc_html( $s[1] ); ?></div>
                        <div class="symptom-desc"><?php echo esc_html( $s[2] ); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <p class="section-note">スポーツによるケガはもちろん、日常生活の痛みや高齢の方の施術にも対応しています。</p>
        </div>
    </section>

    <!-- ===== 選ばれる理由 ===== -->
    <section id="reasons" class="section">
        <div class="container">
            <div class="section-head fade-in">
                <div class="section-label">Reasons</div>
                <h2 class="section-title">当院が選ばれる4つの理由</h2>
            </div>
            <div class="reason-list">
                <?php
                $reasons = [
                    [ '痛みに対する「即効性」', '施術歴20年。その場で痛みの変化を実感していただくことにこだわった施術で、一日でも早い回復・復帰を目指します。' ],
                    [ '練習を休まず、練習しながら治す', '「治るまで運動は禁止」とは言いません。院内の動作チェックスペースで実際の動きを確認しながら、競技を続けたまま治すプランをご提案します。' ],
                    [ '夜9時まで営業。仕事帰り・部活帰りに', '平日は夜9時まで営業（最終受付20:30）。JR南小倉駅から徒歩1分なので、お仕事や部活の帰りにそのまま通えます。' ],
                    [ '施術後のコンディショニングまで一貫サポート', '酸素カプセル・スポーツストレッチ・体操セミナーまで。治して終わりではなく、ケガをしない身体づくりまで支える「ケアステーション」です。' ],
                ];
                foreach ( $reasons as $i => $r ) :
                    ?>
                    <div class="reason-card fade-in">
                        <div class="reason-num"><?php echo esc_html( $i + 1 ); ?></div>
                        <div>
                            <h3><?php echo esc_html( $r[0] ); ?></h3>
                            <p><?php echo esc_html( $r[1] ); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ===== メニュー・料金 ===== -->
    <section id="menu" class="section alt">
        <div class="container">
            <div class="section-head fade-in">
                <div class="section-label">Menu &amp; Price</div>
                <h2 class="section-title">メニュー・料金</h2>
            </div>
            <div class="menu-list">
                <div class="menu-card fade-in">
                    <div class="menu-card-head"><span class="icon">🏥</span>保険施術（ケガの施術）</div>
                    <div class="menu-card-body">
                        <p>捻挫・打撲・肉離れなどの急性のケガは各種健康保険が使えます。スポーツ中のケガはまずご相談ください。</p>
                        <div class="menu-price">各種保険取扱 <span class="unit">／ 窓口負担は保険割合によります</span></div>
                    </div>
                </div>
                <div class="menu-card fade-in">
                    <div class="menu-card-head"><span class="icon">🤸</span>スポーツストレッチ</div>
                    <div class="menu-card-body">
                        <p>肩甲骨と股関節に焦点を当てたマンツーマンのストレッチ。競技能力の向上とケガの予防に効果的です。</p>
                        <div class="menu-price">25分 5,500円<span class="unit">（税込）</span></div>
                    </div>
                </div>
                <div class="menu-card fade-in">
                    <div class="menu-card-head"><span class="icon">🛌</span>酸素カプセル</div>
                    <div class="menu-card-body">
                        <p>丁寧な問診でお一人おひとりに合った利用法をご提案。入る前の体操とカプセル内の呼吸体操で効果を最大限に引き出します。記録更新・睡眠の質改善・慢性疲労の解消に。</p>
                        <div class="menu-price">料金はお問い合わせください</div>
                    </div>
                </div>
                <div class="menu-card fade-in">
                    <div class="menu-card-head"><span class="icon">🚗</span>交通事故・むちうち施術</div>
                    <div class="menu-card-body">
                        <p>交通事故によるむちうち・腰痛などの施術に対応。自賠責保険適用の場合、窓口負担はありません。</p>
                        <div class="menu-price">自賠責保険適用 <span class="unit">／ 窓口負担0円</span></div>
                    </div>
                </div>
            </div>
            <p class="section-note">※ 症状により施術内容・料金が異なる場合があります。詳しくはお気軽にお問い合わせください。</p>
        </div>
    </section>

    <!-- ===== 患者様の声 ===== -->
    <section id="voices" class="section">
        <div class="container">
            <div class="section-head fade-in">
                <div class="section-label">Voices</div>
                <h2 class="section-title">患者様の声</h2>
            </div>
            <div class="voice-grid">
                <?php
                $voices = [
                    [ '学生アスリート', '繰り返していた痛みの原因を、実際の動きを見ながら丁寧に確認してもらい、安心して部活に復帰できました。復帰後のケアまで相談できるのが心強いです。' ],
                    [ 'ランナー', 'レース前後のコンディション調整に酸素カプセルを活用しています。疲労の抜け方が違い、記録更新にもつながりました。' ],
                    [ '会社員', '慢性的な全身の倦怠感に悩んでいましたが、通ううちに睡眠の質が良くなり、毎日の体調が安定してきました。' ],
                ];
                foreach ( $voices as $v ) :
                    ?>
                    <div class="voice-card fade-in">
                        <p class="voice-text"><?php echo esc_html( $v[1] ); ?></p>
                        <div class="voice-who"><span class="tag"><?php echo esc_html( $v[0] ); ?></span></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <p class="section-note">※ 患者様よりいただいた声を要約して掲載しています。効果には個人差があります。</p>
        </div>
    </section>

    <!-- ===== セミナー・体操教室 ===== -->
    <section id="seminar" class="section alt">
        <div class="container">
            <div class="seminar-box fade-in">
                <div class="seminar-icon" aria-hidden="true">🧘</div>
                <div class="seminar-body">
                    <h3>体操セミナー・教室を定期開催中</h3>
                    <p>
                        ケガの予防や日常生活動作・競技能力の向上を目指す体操セミナー・教室を院内で定期開催しています。
                        開催日程・お申し込みはLINE・ブログ・Instagramでお知らせしているほか、
                        自宅でできる体操・セルフケアの動画をYouTubeで公開中です。
                    </p>
                    <div class="seminar-btns">
                        <a class="btn-seminar" href="<?php echo esc_url( kitaspo_home_info( 'line_url' ) ); ?>" target="_blank" rel="noopener">LINEで日程を確認する</a>
                        <a class="btn-seminar yt" href="<?php echo esc_url( kitaspo_home_info( 'youtube_url' ) ); ?>" target="_blank" rel="noopener">▶ YouTubeで体操動画を見る</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== 院長あいさつ ===== -->
    <section id="director" class="section">
        <div class="container">
            <div class="section-head fade-in">
                <div class="section-label">Greeting</div>
                <h2 class="section-title">院長あいさつ</h2>
            </div>
            <div class="director-box fade-in">
                <div class="director-avatar" aria-hidden="true">🏀</div>
                <div class="director-body">
                    <h3>「ケガに悩む選手の力になりたい」その想いで20年。</h3>
                    <p>
                        私自身、学生時代からバスケットボールや格闘技に打ち込み、ケガをするたびに整骨院に助けられてきました。
                        その経験から「今度は自分が選手を支える側になりたい」と、この道を選びました。
                    </p>
                    <p>
                        スポーツをがんばる学生や社会人アスリートはもちろん、日常生活の痛みに悩む方、高齢の方まで、
                        お一人おひとりの生活と目標に寄り添った施術を心がけています。痛みや不安があれば、どうぞお気軽にご相談ください。
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== 営業時間・アクセス ===== -->
    <section id="access" class="section alt">
        <div class="container">
            <div class="section-head fade-in">
                <div class="section-label">Hours &amp; Access</div>
                <h2 class="section-title">営業時間・アクセス</h2>
            </div>
            <div class="access-grid">
                <div class="info-card fade-in">
                    <h3>営業時間</h3>
                    <table class="hours-table">
                        <tr><th>曜日</th><th>午前</th><th>午後</th></tr>
                        <tr><td>月・火・木・金</td><td>9:00〜12:30</td><td>15:30〜21:00<br><small>（最終受付 20:30）</small></td></tr>
                        <tr><td>水</td><td>9:00〜12:30</td><td>17:30〜20:00</td></tr>
                        <tr><td>土</td><td>9:00〜12:30</td><td>13:30〜18:00</td></tr>
                        <tr><td>日・祝</td><td colspan="2">定休日</td></tr>
                    </table>
                    <p class="hours-note"><?php echo esc_html( kitaspo_home_info( 'hours_note' ) ); ?></p>
                </div>
                <div class="info-card fade-in">
                    <h3>アクセス</h3>
                    <ul class="info-list">
                        <li><span class="label">院名</span><span><?php bloginfo( 'name' ); ?></span></li>
                        <li><span class="label">住所</span><span><?php echo esc_html( kitaspo_home_info( 'address' ) ); ?></span></li>
                        <li><span class="label">アクセス</span><span><?php echo esc_html( kitaspo_home_info( 'access' ) ); ?></span></li>
                        <li><span class="label">電話番号</span><span><?php echo esc_html( kitaspo_home_info( 'tel' ) ); ?></span></li>
                        <li><span class="label">定休日</span><span><?php echo esc_html( kitaspo_home_info( 'closed' ) ); ?></span></li>
                        <li><span class="label">地図</span><span><a href="<?php echo esc_url( kitaspo_home_info( 'map_url' ) ); ?>" target="_blank" rel="noopener">Googleマップで開く →</a></span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== お知らせ ===== -->
    <?php
    $news = new WP_Query( [
        'posts_per_page'      => 3,
        'ignore_sticky_posts' => true,
    ] );
    if ( $news->have_posts() ) :
        ?>
        <section id="news" class="section">
            <div class="container">
                <div class="section-head fade-in">
                    <div class="section-label">News</div>
                    <h2 class="section-title">お知らせ</h2>
                </div>
                <div class="info-card fade-in">
                    <ul class="news-list">
                        <?php while ( $news->have_posts() ) : $news->the_post(); ?>
                            <li>
                                <a href="<?php the_permalink(); ?>">
                                    <span class="news-date"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></span>
                                    <span class="news-title"><?php the_title(); ?></span>
                                </a>
                            </li>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </ul>
                </div>
                <div class="news-more">
                    <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/?post_type=post' ) ); ?>">お知らせ一覧を見る</a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- ===== CTAバンド ===== -->
    <section class="cta-band">
        <h2>その痛み、我慢せずにご相談ください。</h2>
        <p>ケガの直後こそ早めの施術が復帰への近道です。ご予約はお電話または LINE から。</p>
        <?php kitaspo_home_cta_buttons(); ?>
    </section>

</main>

<?php get_footer(); ?>
