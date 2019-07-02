<?php

/**
 *
 */
class CustomizerColorSettings_4536 {

  //色セクション
  public $main_array = [
    'primary_color' => [
      'label' => 'プライマリー（メイン）',
      'color' => PRIMARY_COLOR,
    ],
    'secandary_color' => [
      'label' => 'セカンダリー（サブ）',
      'color' => SECANDARY_COLOR,
    ],
    'link_color' => [
      'label' => 'リンク',
      'color' => '#1b95e0',
    ],
    'post_color' => [
      'label' => '文字',
      'color' => '#333333',
    ],
    'table_background_color_2_line' => [
      'label' => 'テーブルの偶数番目の背景',
      'color' => '',
    ],
  ];

  //見出しセクション
  // public $heading_array = [
  //   'h1_key_color' => [
  //     'label' => '見出し1（h1）のキーカラー',
  //     'color' => '#f2f2f2',
  //     'priority' => 10,
  //   ],
  //   'h1_color' => [
  //     'label' => '見出し1（h1）の文字色',
  //     'color' => '',
  //     'priority' => 10,
  //   ],
  //   'h2_key_color' => [
  //     'label' => '見出し2（h2）のキーカラー',
  //     'color' => '#f2f2f2',
  //     'priority' => 20,
  //   ],
  //   'h2_color' => [
  //     'label' => '見出し2（h2）の文字色',
  //     'color' => '',
  //     'priority' => 20,
  //   ],
  //   'h3_key_color' => [
  //     'label' => '見出し3（h3）のキーカラー',
  //     'color' => '#f2f2f2',
  //     'priority' => 30,
  //   ],
  //   'h3_color' => [
  //     'label' => '見出し3（h3）の文字色',
  //     'color' => '',
  //     'priority' => 30,
  //   ],
  //   'h4_key_color' => [
  //     'label' => '見出し4（h4）のキーカラー',
  //     'color' => '#f2f2f2',
  //     'priority' => 40,
  //   ],
  //   'h4_color' => [
  //     'label' => '見出し4（h4）の文字色',
  //     'color' => '',
  //     'priority' => 40,
  //   ],
  //   'related_post_title_key_color' => [
  //     'label' => '関連記事タイトルのキーカラー',
  //     'color' => '#f2f2f2',
  //     'priority' => 50,
  //   ],
  //   'related_post_title_color' => [
  //     'label' => '関連記事タイトルの文字色',
  //     'color' => '',
  //     'priority' => 50,
  //   ],
  //   'sidebar_widget_title_key_color' => [
  //     'label' => 'ウィジェットのキーカラー',
  //     'color' => '#f2f2f2',
  //     'priority' => 60,
  //   ],
  //   'sidebar_widget_title_color' => [
  //     'label' => 'ウィジェットの文字色',
  //     'color' => '',
  //     'priority' => 60,
  //   ],
  // ];

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
    // foreach( $this->heading_array as $key => $value ) {
    //   $wp_customize->add_setting( $key, [ 'default' => $value['color'] ] );
    //   $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $key, [
    //       'label' => $value['label'],
    //       'section' => 'heading_style',
    //       'settings' => $key,
    //       'priority' => $value['priority'],
    //   ]));
    // }

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
    // $array += $this->heading_array;
    $array += $this->balloon_array;

    foreach( $array as $key => $value ) {
      $color[$key] = get_theme_mod( $key, $value['color'] );
    }

    extract( $color );

    if( !empty( $link_color ) ) { //リンクカラー
      $css[] = 'a,.link-color{color:' . $link_color . '}';
    }

    //背景色
    global $pagenow;
    $option = ( is_admin() && ( $pagenow==='post.php' || $pagenow==='post-new.php' ) ) ? ' !important;' : ';' ;
    $post_bg_class = '.body-bg-color';
    $post_bg_color = get_bg_color_4536() . $option;
    if( fixed_header() === true ) $post_bgc_class .= ',.fixed-top .sub-menu';
    $css[] = "$post_bg_class{background-color:$post_bg_color$option}"; //背景色
    $css[] = ".balloon-text-right:after{border-right-color:$post_bg_color}";
    $css[] = ".balloon-text-left:after{border-left-color:$post_bg_color}";

    if( !empty($post_color) ) { //記事文字色
      $post_color_class = '.post-color,#main-container .archive-list';
      if( fixed_header() === true ) $post_color_class .= ',#header.fixed-top a';
      $css[] = "$post_color_class{color:$post_color$option}";
      $css[] = '#sidebar{border-color:rgba(' . hex_to_rgb($post_color) . ',0.25) !important}';
    }

    $array = [
      // 'h1_style' => [
      //   'tag' => '#post-h1',
      //   'key_color' => $h1_key_color,
      //   'font_color' => $h1_color,
      // ],
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
      // 'sidebar_widget_title_style' => [
      //   'tag' => '.widget-title',
      //   'key_color' => $sidebar_widget_title_key_color,
      //   'font_color' => $sidebar_widget_title_color,
      // ],
    ];

    $primary_color = primary_color();
    $gradation = gradation_color();
    if( empty( $post_color ) ) $post_color = '#333333';

    //キーカラー
    foreach ( $array as $key => $val ) {

      // $key_color = $val['key_color'];
      // $font_color = $val['font_color'];
      $tag = $val['tag'];

      //キーカラーとスタイル
      switch ( $this->heading_style_4536($key) ) {
        case 'simple1':
          $rgb = hex_to_rgb( $post_color );
          $css[] = ".simple1 $tag{border-radius:2px;padding:.8em;background:rgba($rgb,0.1)}";
          break;
        case 'simple2':
          $css[] = ".simple1 $tag{border-radius:2px;padding:.8em;$gradation}";
          break;
        case 'simple3':
          $css[] = ".simple2 $tag::after{margin-top:4px;content:\"\";display:block;height:4px;$gradation}";
          break;
        case 'simple4':
          $css[] = ".simple3 $tag{border-left:4px solid $primary_color;padding-left:.4em}";
          break;
        case 'simple3':
          $css[] = ".simple3 $tag{border-left:4px solid $primary_color;padding-left:.4em}";
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
      // if ( !empty( $font_color ) ) $css[] = $tag.'{color:'.$font_color.$option.'}';

    }

    if( !empty( $sidebar_widget_title_color ) ) { //スライドウィジェットのクローズボタン
      $css[] = '.slide-widget-close-button{color:' . $sidebar_widget_title_color . '}';
    }

    if( !empty( $slide_widget_bgc_color = get_bg_color_4536() ) ) {
      $css[] = "#slide-menu{background-color:$slide_widget_bgc_color}";
    }

    if( !empty($table_background_color_2_line) ) { //テーブル偶数番目背景色
      $css[] = '.post table tr:nth-child(even){background-color:'.$table_background_color_2_line.'}';
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
      case 'h2_style':
        $default = 'simple1';
        break;
      case 'h3_style':
        $default = 'simple2';
        break;
      case 'h4_style':
        $default = 'simple3';
        break;
    }
    return get_theme_mod( $tag, $default );
  }

}
new CustomizerColorSettings_4536();

function primary_color() {
  return get_theme_mod( 'primary_color', PRIMARY_COLOR );
}

function secandary_color() {
  return get_theme_mod( 'secandary_color', SECANDARY_COLOR );
}

function gradation_color() {
  $primary_color = primary_color();
  $secondary_color = secandary_color();
  return "background:-webkit-gradient(linear,left top, right top,from($primary_color),to($secondary_color));background:linear-gradient(to right,$primary_color,$secondary_color);color:#ffffff";
}
