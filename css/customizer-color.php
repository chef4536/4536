<?php

add_theme_support('custom-background'); //カスタム背景

add_action('customize_register', function($wp_customize) {
    
    //色セクション
    $list = [
        'link_color' => [
            'label' => 'リンク',
            'color' => '#00a0e9',
        ],
        'header_background_color' => [
            'label' => 'ヘッダー背景',
            'color' => '#000000',
        ],
        'header_color' => [
            'label' => 'ヘッダー文字',
            'color' => '#ffffff',
        ],
        'description_color' => [
            'label' => 'トップページのサイト説明',
            'color' => '',
        ],
        'breadcrumb_color' => [
            'label' => 'パンくずリストの文字',
            'color' => '#666666',
        ],
        'post_background_color' => [
            'label' => '記事（一覧含む）背景',
            'color' => '#ffffff',
        ],
        'post_color' => [
            'label' => '記事（一覧含む）文字',
            'color' => '#333333',
        ],
        'table_background_color_2_line' => [
            'label' => 'テーブルの偶数番目の背景',
            'color' => '#f6f6f6',
        ],
        'media_section_background_color' => [
            'label' => 'メディアセクション（Music,Movie,Pickup）の背景',
            'color' => '#222222',
        ],
        'media_section_title_color' => [
            'label' => 'メディアセクション（Music,Movie,Pickup）の文字',
            'color' => '#ffffff',
        ],
        'footer_background_color' => [
            'label' => 'フッター背景',
            'color' => '#000000',
        ],
        'footer_color' => [
            'label' => 'フッター文字',
            'color' => '#ffffff',
        ],
    ];
    foreach($list as $name => $args) {
        $wp_customize->add_setting( $name, [ 'default' => $args['color'] ] );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $name, [
            'label' => $args['label'],
            'section' => 'colors',
            'settings' => $name,
        ]));        
    }

    //見出しセクション
    $list = [
        'h1' => [
            'label' => '見出し1（h1）',
            'priority' => 10,
        ],
        'h2' => [
            'label' => '見出し2（h2）',
            'priority' => 20,
        ],
        'h3' => [
            'label' => '見出し3（h3）',
            'priority' => 30,
        ],
        'h4' => [
            'label' => '見出し4（h4）',
            'priority' => 40,
        ],
        'related_post_title' => [
            'label' => '関連記事タイトル',
            'priority' => 50,
        ],
        'main_title' => [
            'label' => 'ウィジェット',
            'priority' => 60,
        ],
    ];
    foreach($list as $name => $args) {
        $key_color_name = $name.'_key_color';
        $wp_customize->add_setting( $key_color_name, ['default' => '#f2f2f2'] );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $key_color_name, [
            'label' => $args['label'].'のキーカラー',
            'section' => 'heading_style',
            'settings' => $key_color_name,
            'priority' => $args['priority'],
        ]));
        $color_name = $name.'_color';
        $wp_customize->add_setting( $color_name, ['default' => ''] );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $color_name, [
            'label' => $args['label'].'の文字色',
            'section' => 'heading_style',
            'settings' => $color_name,
            'priority' => $args['priority'],
        ]));
    }
    
    //SNSセクション
    $wp_customize->add_setting( 'fb_like_background_color', ['default' => '#2b2b2b'] );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'fb_like_background_color', [
        'label' => 'バイラル風いいねボックスの背景色',
        'section' => 'SNS',
        'settings' => 'fb_like_background_color',
        'priority' => 15,
    ]));

    $wp_customize->add_setting( 'fb_like_color', ['default' => '#ffffff'] );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'fb_like_color', [
        'label' => 'バイラル風いいねボックスの文字色',
        'section' => 'SNS',
        'settings' => 'fb_like_color',
        'priority' => 15,
    ]));

    //吹き出しセクション
    $list = [
        'balloon_right_background_color' => [
            'label' => '左吹き出しの背景色',
            'priority' => 10,
        ],
        'balloon_right_font_color' => [
            'label' => '左吹き出しの文字色',
            'priority' => 10,
        ],
        'balloon_left_background_color' => [
            'label' => '右吹き出しの背景色',
            'priority' => 50,
        ],
        'balloon_left_font_color' => [
            'label' => '右吹き出しの文字色',
            'priority' => 50,
        ],
    ];
    foreach($list as $name => $args) {
        $wp_customize->add_setting( $name, ['default' => ''] );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $name, [
            'label' => $args['label'],
            'section' => 'balloon',
            'settings' => $name,
            'priority' => $args['priority'],
        ]));
    }

});

function customizer_color() {
    
    //デフォルトカラー
    $link_color = get_theme_mod( 'link_color', '#00a0e9' );
    $header_background_color = get_theme_mod( 'header_background_color', '#000000');
    $header_color = get_theme_mod( 'header_color', '#ffffff');
    $description_color = get_theme_mod( 'description_color', '');
    $breadcrumb_color = get_theme_mod( 'breadcrumb_color', '#666666');
    $post_backround_color = get_theme_mod( 'post_background_color', '#ffffff');
    $post_color = get_theme_mod( 'post_color', '#333333');
    $h1_key_color = get_theme_mod( 'h1_key_color', '#f2f2f2');
    $h1_color = get_theme_mod( 'h1_font_color', '');
    $h2_key_color = get_theme_mod( 'h2_key_color', '#f2f2f2');
    $h2_color = get_theme_mod( 'h2_font_color', '');
    $h3_key_color = get_theme_mod( 'h3_key_color', '#f2f2f2');
    $h3_color = get_theme_mod( 'h3_font_color', '');
    $h4_key_color = get_theme_mod( 'h4_key_color', '#f2f2f2');
    $h4_color = get_theme_mod( 'h4_font_color', '');
    $table_background_color_2_line = get_theme_mod( 'table_background_color_2_line', '#f6f6f6');
    $fb_like_background_color = get_theme_mod( 'fb_like_background_color', '#2b2b2b');
    $fb_like_color = get_theme_mod( 'fb_like_color', '#ffffff');
    $related_post_title_key_color = get_theme_mod( 'related_post_title_key_color', '#f2f2f2');
    $related_post_title_color = get_theme_mod( 'related_post_title_color', '');
    $main_title_key_color = get_theme_mod( 'main_title_key_color', '#f2f2f2');
    $main_title_color = get_theme_mod( 'main_title_color', '');
    $media_section_background_color = get_theme_mod( 'media_section_background_color', '#222222');
    $media_section_title_color = get_theme_mod( 'media_section_title_color', '#ffffff');
    $footer_background_color = get_theme_mod( 'footer_background_color', '#000000');
    $footer_color = get_theme_mod( 'footer_color', '#ffffff');
    $balloon_left_background_color = get_theme_mod( 'balloon_left_background_color', '');
    $balloon_right_background_color = get_theme_mod( 'balloon_right_background_color', '');
    $balloon_left_font_color = get_theme_mod( 'balloon_left_font_color', '');
    $balloon_right_font_color = get_theme_mod( 'balloon_right_font_color', '');

    $css = [];
    
    if( !empty($link_color) ) { //リンクカラー
        $css[] = 'a{color:'.$link_color.'}';
    }

    if( !empty($header_background_color) ) { //ヘッダー背景色
        $css[] = '#header,.sub-menu,#mobile-nav-menu{background-color:'.$header_background_color.'}';
    }

    if( !empty($header_color) ) { //ヘッダー文字色
//        $css[] = '#header,#header button,.nav-menu,.nav-menu li a,#sitename a{color:'.$header_color.'}';
        $css[] = '#header,#header a,#mobile-nav-menu,#mobile-nav-menu a{color:'.$header_color.'}';
    }

    if( !empty($description_color) ) { //ディスクリプションの文字色
        $css[] = '#description{color:'.$description_color.'}';
    }

    if( !empty($breadcrumb_color) ) { //パンくずリストの文字色
        $css[] = '#breadcrumb,#breadcrumb a{color:'.$breadcrumb_color.'}';
    }

    global $pagenow;
    $option = (is_admin() && $pagenow===('post.php'||'post-new.php')) ? ' !important;' : ';' ;
    if( !empty($post_backround_color) ) { //記事背景色
        $css[] = '#main,#header.fixed-top,.fixed-top .nav-menu,.fixed-top .nav-menu a,.fixed-top .nav-menu .sub-menu{background-color:'.$post_backround_color.$option.'}';
        $css[] = '.pagination span, .pagination a, #prev-next a,.prev-post-arrow, .next-post-arrow{color:'.$post_backround_color.$option.'}';
    }
    if( !empty($post_color) ) { //記事文字色
        $css[] = '#main,#main .post-info,#all-categories a,#related-post a,#prev-next a,#header.fixed-top,.fixed-top .nav-menu,#header.fixed-top .nav-menu a,.fixed-top #sitename a, .follow-button a{color:'.$post_color.$option.'}';
        $css[] = '.pagination span, .pagination a, .prev-post-arrow, .next-post-arrow{background-color:'.$post_color.$option.'}';
    }

    if( !empty($fb_like_background_color) ) { //いいねボックス背景色
        $css[] = '#follow-section-cover{background-color:'.$fb_like_background_color.'}';
    }

    if( !empty($fb_like_color) ) { //いいねボックス文字色
        $css[] = '#follow-section-right{color:'.$fb_like_color.'}';
    }

    $list = [
        'h1_style' => $h1_key_color,
        'h2_style' => $h2_key_color,
        'h3_style' => $h3_key_color,
        'h4_style' => $h4_key_color,
        'related_post_title_style' => $related_post_title_key_color,
        'widget_title_style' => $main_title_key_color,
    ];
    foreach($list as $style => $key) {
        if(!empty($key)) {//キー色
            $wrap = '';
            if($style==='h2_style') $wrap = '.article-body ';
            if($style==='h3_style') $wrap = '.article-body ';
            if($style==='h4_style') $wrap = '.article-body ';
            $headline = str_replace('_style', '', $style);
            $headline = str_replace('h1', '#post-h1', $headline);
            $headline = str_replace('related_post_title', '#related-post-title', $headline);
            $headline = str_replace('widget_title', '.main-widget-title', $headline);
            if(is_admin()) $wrap = '';
            $headline = $wrap.$headline;
            if($style()=='simple1') {
                echo '.simple1 '.$headline.' { background-color: '.$key.'; }';
            } elseif($style()=='simple2') {
                echo '.simple2 '.$headline.' { border-color: '.$key.'; }';
            } elseif($style()=='simple3') {
                echo '.simple3 '.$headline.' { border-color: '.$key.'; }';
            } elseif($style()=='pop') {
                echo '.pop '.$headline.' { border-color: '.$key.'; }';
            } elseif($style()=='cool') {
                echo '.cool '.$headline.'::before,.cool '.$headline.'::after { background-color: '.$key.'; }';
            } elseif($style()=='cool2') {
                echo '.cool2 '.$headline.' {border-color: '.$key.';}.cool2 '.$headline.'::before,.cool2 '.$headline.'::after {background-color: '.$key.';}';
            } elseif($style()=='cool3') {
                echo '.cool3 '.$headline.'::before {background-color: '.$key.';}';
            }
        }
    }

    $list = [
        'h1' => $h1_color,
        'h2' => $h2_color,
        'h3' => $h3_color,
        'h4' => $h4_color,
        '#related-post-title' => $related_post_title_color,
        '.main-widget-title' => $main_title_color,
    ];
    foreach($list as $headline => $color) {
        if(!empty($color)) { //文字色
            $wrap = null;
            if($headline=='h2') $wrap = '.article-body ';
            if($headline=='h3') $wrap = '.article-body ';
            if($headline=='h4') $wrap = '.article-body ';
            if(is_admin()) $wrap = '.edit-post-visual-editor ';
            $headline = str_replace('h1', '#post-h1', $headline);
            $headline = $wrap.$headline;
            echo $headline; ?>{color:<?php echo $color; ?>;}
        <?php }
    }

    if( !empty($table_background_color_2_line) ) { //テーブル偶数番目背景色
        $css[] = '.post table tr:nth-child(even){background-color:'.$table_background_color_2_line.'}';
    }

    if( !empty($media_section_background_color) ) { //メディアセクション背景色
        $css[] = '.media-section{background-color:'.$media_section_background_color.'}';
    }

    if( !empty($media_section_title_color) ) { //メディアセクションタイトル色
        $css[] = '#main .media-section-title,#main .media-content .post-info,.media-section-title,.media-content .post-info{color:'.$media_section_title_color.'}';
    }

    if( !empty($footer_background_color) ) { //フッター背景色
        $css[] = '#footer,#fixed-footer-menu{background-color:'.$footer_background_color.'}';
    }

    if( !empty($footer_color) ) { //フッター文字色
        $css[] = '#footer,#footer a,.fixed-footer,.fixed-footer a{color:'.$footer_color.'}';
    }

    if( !empty($balloon_right_background_color) ) { //左吹き出し背景色
        $css[] = '.balloon .balloon-text-right,.think.balloon .balloon-text-right,.think.balloon .balloon-text-right::before,.think.balloon .balloon-text-right::after{background-color:'.$balloon_right_background_color.';border-color:'.$balloon_right_background_color.'}';
        $css[] = '.balloon .balloon-text-right::before,.balloon .balloon-text-right::after{border-right-color:'.$balloon_right_background_color.'}';
    }

    if( !empty($balloon_right_font_color) ) { //左吹き出し文字
        $css[] = '.balloon .balloon-text-right{color:'.$balloon_right_font_color.'}';
    }

    if( !empty($balloon_left_background_color) ) { //右吹き出し背景色
        $css[] = '.balloon .balloon-text-left,.think.balloon .balloon-text-left,.think.balloon .balloon-text-left::before,.think.balloon .balloon-text-left::after{background-color:'.$balloon_left_background_color.';border-color:'.$balloon_left_background_color.'}';
        $css[] = '.balloon .balloon-text-left::before,.balloon .balloon-text-left::after{border-left-color:'.$balloon_left_background_color.'}';
    }

    if( !empty($balloon_left_font_color) ) { //右吹き出し文字
        $css[] = '.balloon .balloon-text-left{color:'.$balloon_left_font_color.'}';
    }
    
    $css = implode('', $css);
    echo $css;
    
}