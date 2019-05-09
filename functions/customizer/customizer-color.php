<?php

/**
 *
 */
class CustomizerColorSettings_4536 {

  //色セクション
  public $main_array = [
    'link_color' => [
      'label' => 'リンク',
      'color' => '#1b95e0',
    ],
    'header_background_color' => [
      'label' => 'ヘッダー背景',
      'color' => '#000000',
    ],
    'header_color' => [
      'label' => 'ヘッダー文字',
      'color' => '#ffffff',
    ],
    'below_header_nav_menu_background_color' => [
      'label' => 'ヘッダー下ナビメニュー背景',
      'color' => '#000000',
    ],
    'below_header_nav_menu_color' => [
      'label' => 'ヘッダー下ナビメニュー文字',
      'color' => '#ffffff',
    ],
    'description_color' => [
      'label' => 'トップページのサイト説明',
      'color' => '',
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
      'color' => '',
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

  //見出しセクション
  public $heading_array = [
    'h1_key_color' => [
      'label' => '見出し1（h1）のキーカラー',
      'color' => '#f2f2f2',
      'priority' => 10,
    ],
    'h1_color' => [
      'label' => '見出し1（h1）の文字色',
      'color' => '',
      'priority' => 10,
    ],
    'h2_key_color' => [
      'label' => '見出し2（h2）のキーカラー',
      'color' => '#f2f2f2',
      'priority' => 20,
    ],
    'h2_color' => [
      'label' => '見出し2（h2）の文字色',
      'color' => '',
      'priority' => 20,
    ],
    'h3_key_color' => [
      'label' => '見出し3（h3）のキーカラー',
      'color' => '#f2f2f2',
      'priority' => 30,
    ],
    'h3_color' => [
      'label' => '見出し3（h3）の文字色',
      'color' => '',
      'priority' => 30,
    ],
    'h4_key_color' => [
      'label' => '見出し4（h4）のキーカラー',
      'color' => '#f2f2f2',
      'priority' => 40,
    ],
    'h4_color' => [
      'label' => '見出し4（h4）の文字色',
      'color' => '',
      'priority' => 40,
    ],
    'related_post_title_key_color' => [
      'label' => '関連記事タイトルのキーカラー',
      'color' => '#f2f2f2',
      'priority' => 50,
    ],
    'related_post_title_color' => [
      'label' => '関連記事タイトルの文字色',
      'color' => '',
      'priority' => 50,
    ],
    'sidebar_widget_title_key_color' => [
      'label' => 'ウィジェットのキーカラー',
      'color' => '#f2f2f2',
      'priority' => 60,
    ],
    'sidebar_widget_title_color' => [
      'label' => 'ウィジェットの文字色',
      'color' => '',
      'priority' => 60,
    ],
  ];

  public $sns_array = [
    'fb_like_background_color' => [
      'label' => 'バイラル風いいねボックスの背景色',
      'color' => '#2b2b2b',
    ],
    'fb_like_color' => [
      'label' => 'バイラル風いいねボックスの文字色',
      'color' => '#ffffff',
    ],
  ];

  public $balloon_array = [
    'balloon_right_background_color' => [
      'label' => '左吹き出しの背景色',
      'color' => '',
      'priority' => 10,
    ],
    'balloon_right_font_color' => [
      'label' => '左吹き出しの文字色',
      'color' => '',
      'priority' => 10,
    ],
    'balloon_left_background_color' => [
      'label' => '右吹き出しの背景色',
      'color' => '',
      'priority' => 50,
    ],
    'balloon_left_font_color' => [
      'label' => '右吹き出しの文字色',
      'color' => '',
      'priority' => 50,
    ],
  ];

  function __construct() {
    add_action( 'customize_register', [$this, 'init'] );
    add_filter( 'inline_style_4536', [$this, 'add_style'] );
  }

  function init( $wp_customize ) {

    //メイン
    foreach( $this->main_array as $key => $value ) {
      $wp_customize->add_setting( $key, [ 'default' => $value['color'] ] );
      $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $key, [
          'label' => $value['label'],
          'section' => 'colors',
          'settings' => $key,
      ]));
    }

    //見出し
    foreach( $this->heading_array as $key => $value ) {
      $wp_customize->add_setting( $key, [ 'default' => $value['color'] ] );
      $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $key, [
          'label' => $value['label'],
          'section' => 'heading_style',
          'settings' => $key,
          'priority' => $value['priority'],
      ]));
    }

    //SNS
    foreach( $this->sns_array as $key => $value ) {
      $wp_customize->add_setting( $key, ['default' => $value['color']] );
      $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $key, [
        'label' => $value['label'],
        'section' => 'SNS',
        'settings' => $key,
        'priority' => 15,
      ]));
    }

    //吹き出しセクション
    foreach( $this->balloon_array as $key => $value ) {
      $wp_customize->add_setting( $key, ['default' => $value['color']] );
      $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $key, [
          'label' => $value['label'],
          'section' => 'balloon',
          'settings' => $key,
          'priority' => $value['priority'],
      ]));
    }

  }

  function add_style( $css ) {

    $array = [];
    $color = [];
    $array += $this->main_array;
    $array += $this->heading_array;
    $array += $this->sns_array;
    $array += $this->balloon_array;

    foreach( $array as $key => $value ) {
      $color[$key] = get_theme_mod( $key, $value['color'] );
    }

    extract( $color );

    if( !empty( $link_color ) ) { //リンクカラー
      $css[] = 'a{color:' . $link_color . '}';
    }

    if( !empty( $header_background_color ) ) { //ヘッダー背景色
      $css[] = '.header,.sub-menu{background-color:' . $header_background_color . '}';
    }

    if( !empty( $header_color ) ) { //ヘッダー文字色
      $css[] = '.header,.header a{color:'.$header_color.'}';
      $css[ 'site_top_border_bottom' ] = '#site-top{border-bottom:1px solid rgba(' . hex_to_rgb( $header_color ) . ',.25)}';
    }

    if( !empty( $below_header_nav_menu_background_color ) ) { //ヘッダーナビ背景色
      $css[] = '#below-header-nav-menu{background-color:' . $below_header_nav_menu_background_color . '}';
    }

    if( !empty( $below_header_nav_menu_color ) ) { //ヘッダーナビ文字色
      $css[] = '#below-header-nav-menu a{color:' . $below_header_nav_menu_color . '}';
      $css[ 'site_top_border_bottom' ] = '#site-top{border-bottom:1px solid rgba(' . hex_to_rgb( $below_header_nav_menu_color ) . ',.25)}';
    }

    if( !empty( $description_color ) ) { //ディスクリプションの文字色
      $css[] = '#description{color:' . $description_color . '}';
    }

    global $pagenow;
    $option = ( is_admin() && ( $pagenow==='post.php' || $pagenow==='post-new.php' ) ) ? ' !important;' : ';' ;
    if( !empty($post_background_color) ) { //記事背景色
      $post_bgc_class = '.post-bg-color';
      $post_bgc_class .= ',.article-body blockquote:not(.external-website-embed-content)::before,.article-body blockquote:not(.external-website-embed-content)::after';
      if( fixed_header() === true ) $post_bgc_class .= ',.fixed-top .sub-menu';
      $css[] = $post_bgc_class.'{background-color:'.$post_background_color.$option.'}';
      $css[] = '.balloon-text-right:after{border-right-color:'.$post_background_color.'}';
      $css[] = '.balloon-text-left:after{border-left-color:'.$post_background_color.'}';
      $css[] = '.pagination span, .pagination a{color:'.$post_background_color.'}';
    }
    if( !empty($post_color) ) { //記事文字色
      $post_color_class = ( fixed_header() === true ) ? '.post-color,.fixed-top,.fixed-top a' : '.post-color';
      $css[] = $post_color_class.'{color:'.$post_color.$option.'}';
      $css[] = '.pagination span, .pagination a{background-color:'.$post_color.'}';
    }

    if( !empty($fb_like_background_color) ) { //いいねボックス背景色
      $css[] = '#follow-section-cover{background-color:'.$fb_like_background_color.'}';
    }

    if( !empty($fb_like_color) ) { //いいねボックス文字色
      $css[] = '#follow-section-right{color:'.$fb_like_color.'}';
    }

    $array = [
      'h1_style' => [
        'tag' => '#post-h1',
        'key_color' => $h1_key_color,
        'font_color' => $h1_color,
      ],
      'h2_style' => [
        'tag' => '.article-body h2',
        'key_color' => $h2_key_color,
        'font_color' => $h2_color,
      ],
      'h3_style' => [
        'tag' => '.article-body h3',
        'key_color' => $h3_key_color,
        'font_color' => $h3_color,
      ],
      'h4_style' => [
        'tag' => '.article-body h4',
        'key_color' => $h4_key_color,
        'font_color' => $h4_color,
      ],
      'related_post_title_style' => [
        'tag' => '#related-post-title',
        'key_color' => $related_post_title_key_color,
        'font_color' => $related_post_title_color,
      ],
      'sidebar_widget_title_style' => [
        'tag' => '.widget-title',
        'key_color' => $sidebar_widget_title_key_color,
        'font_color' => $sidebar_widget_title_color,
      ],
    ];

    //キーカラー
    foreach ( $array as $key => $val ) {

      $key_color = $val['key_color'];
      $font_color = $val['font_color'];
      $tag = $val['tag'];

      //キーカラーとスタイル
      switch ( $this->heading_style_4536($key) ) {
        case 'simple1':
          $key_color_css = ( !empty($key_color) ) ? 'background-color:'.$key_color : '';
          $css[] = '.simple1 '.$tag.'{border-radius:2px;padding:.8em;'.$key_color_css.'}';
          break;
        case 'simple2':
          $key_color_css = ( !empty($key_color) ) ? 'border-color:'.$key_color : '';
          $css[] = '.simple2 '.$tag.'{border-bottom:solid 3px;padding: 0 0 .4em .4em;'.$key_color_css.'}';
          break;
        case 'simple3':
          $key_color_css = ( !empty($key_color) ) ? 'border-color:'.$key_color : '';
          $css[] = '.simple3 '.$tag.'{border-left:5px solid;padding-left:.4em;'.$key_color_css.'}';
          break;
        case 'pop':
          $key_color_css = ( !empty($key_color) ) ? 'border-color:'.$key_color : '';
          $css[] = '.pop '.$tag.'{border-radius:2px;padding:.8em;border:dashed 2px;'.$key_color_css.'}';
          break;
        case 'cool':
          $key_color_css = ( !empty($key_color) ) ? 'border-color:'.$key_color : '';
          $css[] = '.cool '.$tag.'{padding:0 55px;text-align:center}.cool '.$tag.'::before{left:0}.cool '.$tag.'::after{right:0}';
          $css[] = '.cool '.$tag.'::before,.cool '.$tag.'::after{content:"";position:absolute;top:50%;display:inline-block;width:45px;border:.5px solid;'.$key_color_css.'}';
          break;
        case 'cool2':
          $key_color_css = ( !empty($key_color) ) ? 'border-color:'.$key_color : '';
          $css[] = '.cool2 '.$tag.'{padding:.8em 1em;border-top:solid 2px;border-bottom:solid 2px;'.$key_color_css.'}.cool2 '.$tag.'::before{left:7px}.cool2 '.$tag.'::after{right:7px}';
          $css[] = '.cool2 '.$tag.'::before,.cool2 '.$tag.'::after{content:"";position:absolute;top:-7px;border:1px solid;height:-webkit-calc(100% + 14px);height:calc(100% + 14px);'.$key_color_css.'}';
          break;
        case 'cool3':
          $key_color_css = ( !empty($key_color) ) ? 'border-color: '.$key_color : '';
          $css[] = '.cool3 '.$tag.'{text-align:center}.cool3 '.$tag.'::before{content:"";position:absolute;bottom:-10px;display:block;width:60px;border:1.5px solid;left:50%;-moz-transform:translateX(-50%);-webkit-transform:translateX(-50%);-ms-transform:translateX(-50%);transform:translateX(-50%);border-radius:2px;'.$key_color_css.'}';
          break;
      }

      //文字色
      if ( !empty( $font_color ) ) $css[] = $tag.'{color:'.$font_color.$option.'}';

    }

    $sidebar_widget_title_key_color = !empty( $sidebar_widget_title_key_color ) ? "background-color:$sidebar_widget_title_key_color;" : '';
    $sidebar_widget_title_color = !empty( $sidebar_widget_title_color ) ? "color:$sidebar_widget_title_color" : '';

    if( !empty( $sidebar_widget_title_key_color ) || !empty( $sidebar_widget_title_color ) ) { //スライドウィジェットのクローズボタン
      $css[] = '.slide-widget-close-button{' . $sidebar_widget_title_key_color . $sidebar_widget_title_color . '}';
    }

    if( !empty( $slide_widget_bgc_color = get_background_color() ) ) {
      $css[] = "#slide-menu{background-color:#$slide_widget_bgc_color}";
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

    if( !empty( $footer_background_color ) ) { //フッター背景色
      $css[] = '#footer,#fixed-footer-menu{background-color:'.$footer_background_color.'}';
    }

    if( !empty( $footer_color ) ) { //フッター文字色
      $css[] = '#footer,#footer a,.fixed-footer,.fixed-footer-menu-item{color:'.$footer_color.'}';
      $css[] = '#footer{border-top:1px solid rgba('.hex_to_rgb($footer_color).',.25)}';
      if( fixed_footer() === 'menu' ) $css[] = '#fixed-footer-menu{box-shadow:0 -1px 3px rgba('.hex_to_rgb($footer_color).',.25)}';
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

    return $css;

  }

  function heading_style_4536( $tag ) {
    switch ( $tag ) {
      case 'h1_style':
        $default = null;
        break;
      case 'h2_style':
        $default = 'simple1';
        break;
      case 'h3_style':
        $default = 'simple2';
        break;
      case 'h4_style':
        $default = 'simple3';
        break;
      case 'related_post_title_style':
        $default = 'simple1';
        break;
      case 'sidebar_widget_title_style':
        $default = 'simple1';
        break;
    }
    return get_theme_mod( $tag, $default );
  }

}
new CustomizerColorSettings_4536();
