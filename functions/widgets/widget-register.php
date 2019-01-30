<?php
register_sidebar([
    'name' => 'サイドバー',
    'id' => 'sidebar',
    'before_widget' => '<div class="widget-4536 %1$s %2$s sidebar-widget margin-bottom-1_5em">',
    'after_widget' => '</div>',
    'before_title' => '<h3 class="sidebar-title main-widget-title">',
    'after_title' => '</h3>',
]);
register_sidebar([
    'name' => 'スクロール',
    'id' => 'scroll-sidebar',
    'description' => 'PC表示時スクロール',
    'before_widget' => '<div class="widget-4536 %1$s %2$s sidebar-widget margin-bottom-1_5em">',
    'after_widget' => '</div>',
    'before_title' => '<h3 class="sidebar-title main-widget-title">',
    'after_title' => '</h3>',
]);
register_sidebar([
    'name' => 'スライドメニュー',
    'id' => 'slide-widget',
    'description' => 'Googleアドセンス禁止',
    'before_widget' => '<div class="widget-4536 %1$s %2$s slide-widget">',
    'after_widget' => '</div>',
    'before_title' => '<h3 class="slide-widget-title main-widget-title">',
    'after_title' => '</h3>',
]);
register_sidebar([
    'name' => 'ヘッダー下',
    'id' => 'header-widget',
    'description' => 'サイトタイトルやメニューの下部分に表示されます。',
    'before_widget' => '<div class="header-widget amp-header-widget margin-1em-auto padding-0-10px"><div class="widget-4536 %1$s %2$s inner">',
    'after_widget' => '</div></div>',
    'before_title' => '<p class="widget-title">',
    'after_title' => '</p>',
]);
register_sidebar([
    'name' => '記事上',
    'id' => 'post-top-widget',
    'description' => '本文上に表示されます。',
    'before_widget' => '<div class="widget-4536 %1$s %2$s post-top-widget margin-1em-auto">',
    'after_widget' => '</div>',
    'before_title' => '<p class="widget-title">',
    'after_title' => '</p>',
]);
register_sidebar([
    'name' => '記事中',
    'id' => 'sp-first-h2-ad',
    'description' => '本文中の最初のh2タグの手前に表示されます。広告掲載に最適な位置です。',
    'before_widget' => '<div class="widget-4536 %1$s %2$s ad text-align-center post-h2-widget margin-1_5em-auto clearfix">',
    'after_widget' => '</div>',
    'before_title' => '<p class="ad-title">',
    'after_title' => '</p>',
]);
register_sidebar([
    'name' => '記事下広告枠',
    'id' => 'ad',
    'description' => '本文の真下に表示されます。広告掲載に最適な位置です。',
    'before_widget' => '<div class="widget-4536 %1$s %2$s ad text-align-center post-bottom-ad-widget margin-1_5em-auto clearfix">',
    'after_widget' => '</div>',
    'before_title' => '<p class="ad-title">',
    'after_title' => '</p>',
]);
register_sidebar([
    'name' => '記事下',
    'id' => 'post-bottom',
    'description' => '本文下のカテゴリーの後ろに表示されます。CTAや関連コンテンツユニットの掲載におすすめです。',
    'before_widget' => '<div class="widget-4536 %1$s %2$s post-bottom-widget margin-1_5em-auto">',
    'after_widget' => '</div>',
    'before_title' => '<p class="widget-title">',
    'after_title' => '</p>',
]);
register_sidebar([
    'name' => 'フッター上',
    'id' => 'footer-top',
    'description' => 'サイト下部に表示されます。',
    'before_widget' => '<div class="widget-4536 %1$s %2$s footer-top-widget margin-1em-auto clearfix">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="footer-top-widget-title widget-title">',
    'after_title' => '</h4>',
]);
register_sidebar([
    'name' => 'フッター左',
    'id' => 'footer-left',
    'description' => 'サイト下部に表示されます。パソコン表示時は左に表示されます。',
    'before_widget' => '<div class="widget-4536 %1$s %2$s footer-widget margin-bottom-2em">',
    'after_widget' => '</div>',
    'before_title' => '<h4>',
    'after_title' => '</h4>',
]);
register_sidebar([
    'name' => 'フッター中央',
    'id' => 'footer-center',
    'description' => 'サイト下部に表示されます。フッター左がないと左にずれます。パソコン表示時は中央に表示されます。',
    'before_widget' => '<div class="widget-4536 %1$s %2$s footer-widget margin-bottom-2em">',
    'after_widget' => '</div>',
    'before_title' => '<h4>',
    'after_title' => '</h4>',
]);
register_sidebar([
    'name' => 'フッター右',
    'id' => 'footer-right',
    'description' => 'サイト下部に表示されます。フッター左・中央がないと左にずれます。パソコン表示時は右に表示されます。',
    'before_widget' => '<div class="widget-4536 %1$s %2$s footer-widget margin-bottom-2em">',
    'after_widget' => '</div>',
    'before_title' => '<h4>',
    'after_title' => '</h4>',
]);
register_sidebar([
    'name' => '固定フッター',
    'id' => 'fixed-footer',
    'description' => 'テーマカスタマイザー（外観→カスタマイズ）で固定フッターを「オーバーレイ広告」にすると表示されます。高さ50pxまで。「空のアイテム」を使ってください。',
    'before_widget' => '<div class="widget-4536 %1$s %2$s fixed-footer-widget">',
    'after_widget' => '</div>',
]);
register_sidebar([
    'name' => '一覧記事インフィード広告',
    'id' => 'sp-infeed-ad',
    'description' => '一覧記事中でランダムに表示されます。サイトのデザインに合わせた広告を掲載してください。',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<p class="ad-title">',
    'after_title' => '</p>',
]);
register_sidebar([
    'name' => 'AMPヘッダー',
    'id' => 'amp-header',
    'description' => '※アドセンスは外観→カスタマイズにて設定。AMPに対応してないタグを使うとエラーになります。',
    'before_widget' => '<div class="header-widget amp-header-widget margin-1em-auto padding-0-10px"><div class="widget-4536 %1$s %2$s inner">',
    'after_widget' => '</div></div>',
    'before_title' => '<p class="widget-title">',
    'after_title' => '</p>',
]);
register_sidebar([
    'name' => 'AMP記事上',
    'id' => 'amp-post-top',
    'description' => '※アドセンスは外観→カスタマイズにて設定。AMPに対応してないタグを使うとエラーになります。',
    'before_widget' => '<div class="widget-4536 %1$s %2$s post-top-widget margin-1em-auto">',
    'after_widget' => '</div>',
    'before_title' => '<p class="widget-title">',
    'after_title' => '</p>',
]);
register_sidebar([
    'name' => 'AMP記事中',
    'id' => 'amp-first-h2-ad',
    'description' => '投稿本文中の最初のH2タグの手前に表示されます。※アドセンスは外観→カスタマイズにて設定。AMPに対応してないタグを使うとエラーになります。',
    'before_widget' => '<div class="widget-4536 %1$s %2$s ad text-align-center post-h2-widget margin-1_5em-auto">',
    'after_widget' => '</div>',
    'before_title' => '<p class="ad-title">',
    'after_title' => '</p>',
]);
register_sidebar([
    'name' => 'AMP記事下広告枠',
    'id' => 'amp-post-ad',
    'description' => '※アドセンスは外観→カスタマイズにて設定。AMPに対応してないタグを使うとエラーになります。',
    'before_widget' => '<div class="widget-4536 %1$s %2$s ad text-align-center post-bottom-ad-widget margin-1_5em-auto">',
    'after_widget' => '</div>',
    'before_title' => '<p class="ad-title">',
    'after_title' => '</p>',
]);
register_sidebar([
    'name' => 'AMP記事下',
    'id' => 'amp-post-bottom',
    'description' => '※アドセンスは外観→カスタマイズにて設定。AMPに対応してないタグを使うとエラーになります。',
    'before_widget' => '<div class="widget-4536 %1$s %2$s post-bottom-widget margin-1_5em-auto">',
    'after_widget' => '</div>',
    'before_title' => '<p class="widget-title">',
    'after_title' => '</p>',
]);
register_sidebar([
    'name' => 'AMP新着記事上（PCサイドバー部分）',
    'id' => 'amp-sidebar',
    'description' => '投稿本文中の最初のH2タグの手前に表示されます。※アドセンスは外観→カスタマイズにて設定。AMPに対応してないタグを使うとエラーになります。',
    'before_widget' => '<div class="widget-4536 %1$s %2$s sidebar-widget margin-bottom-1_5em">',
    'after_widget' => '</div>',
    'before_title' => '<h3 class="sidebar-title main-widget-title">',
    'after_title' => '</h3>',
]);
register_sidebar([
    'name' => 'AMPスライドメニュー',
    'id' => 'amp-slide-menu',
    'description' => 'Googleアドセンス禁止',
    'before_widget' => '<div class="widget-4536 %1$s %2$s slide-widget">',
    'after_widget' => '</div>',
    'before_title' => '<h3 class="slide-widget-title main-widget-title">',
    'after_title' => '</h3>',
]);
register_sidebar([
    'name' => 'AMP固定フッター',
    'id' => 'amp-fixed-footer',
    'description' => '固定フッターを「オーバーレイ広告」にすると表示されます。高さ50pxまで。amp-adタグを「空のアイテム」に入力して使ってください。それ以外のタグはすべてエラーになります。',
    'before_widget' => '<div class="widget-4536 %1$s %2$s fixed-footer-widget">',
    'after_widget' => '</div>',
]);
