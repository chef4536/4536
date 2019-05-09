<?php

class CustomizerLayoutSettings_4536 {

  function __construct() {
    add_action( 'customize_register', [$this, 'register'] );
  }

  function register( $wp_customize ) {
  	$wp_customize->add_section( 'design', [
      'title' => 'デザイン',
      'priority' => 20,
  	]);
    //レイアウトリスト
    $layout_list = [
        'left-content' => '2カラム（右サイドバー：デフォルト）',
        'right-content' => '2カラム（左サイドバー）',
        'center-content' => '1カラム（サイドバーなし）',
    ];
    //トップページレイアウト
    $wp_customize->add_setting( 'layout_home', [
        'default' => 'left-content',
    ]);
    $wp_customize->add_control( 'layout_home', [
        'section' => 'design',
        'settings' => 'layout_home',
        'label' =>'トップページのレイアウト（PC）',
        'type' => 'select',
        'choices'    => $layout_list,
    ]);
    //記事レイアウト
    $wp_customize->add_setting( 'layout_singular', [
        'default' => 'left-content',
    ]);
    $wp_customize->add_control( 'layout_singular', [
        'section' => 'design',
        'settings' => 'layout_singular',
        'label' =>'記事のレイアウト（PC）',
        'type' => 'select',
        'choices'    => $layout_list,
    ]);
    //アーカイブページレイアウト
    $wp_customize->add_setting( 'layout_archive', [
        'default' => 'left-content',
    ]);
    $wp_customize->add_control( 'layout_archive', [
        'section' => 'design',
        'settings' => 'layout_archive',
        'label' =>'アーカイブページのレイアウト（PC）',
        'type' => 'select',
        'choices'    => $layout_list,
    ]);
    $width_list = [
        'width-780' => '780px',
        'width-880' => '880px',
        'width-980' => '980px',
        'width-1080' => '1080px（デフォルト）',
        'width-1180' => '1180px',
        'width-1280' => '1280px',
        'width-1380' => '1380px',
        'width-1480' => '1480px',
    ];
    //トップ横幅
    $wp_customize->add_setting( 'body_width_home', array (
        'default' => 'width-1080',
    ));
    $wp_customize->add_control( 'body_width_home', array(
        'section' => 'design',
        'settings' => 'body_width_home',
        'label' =>'トップページの横幅（最大幅）',
        'type' => 'select',
        'choices'    => $width_list,
    ));
    //シングル横幅
    $wp_customize->add_setting( 'body_width_singular', array (
        'default' => 'width-1080',
    ));
    $wp_customize->add_control( 'body_width_singular', array(
        'section' => 'design',
        'settings' => 'body_width_singular',
        'label' =>'記事の横幅（最大幅）',
        'type' => 'select',
        'choices'    => $width_list,
    ));
    //アーカイブ横幅
    $wp_customize->add_setting( 'body_width_archive', array (
        'default' => 'width-1080',
    ));
    $wp_customize->add_control( 'body_width_archive', array(
        'section' => 'design',
        'settings' => 'body_width_archive',
        'label' =>'アーカイブページの横幅（最大幅）',
        'type' => 'select',
        'choices'    => $width_list,
    ));
    //記事一覧のデザインスマホ
    $post_style_list = [
        null => 'シンプル（デフォルト）',
        'big' => 'ビッグ（1列）',
    ];
    //トップページモバイル
    $wp_customize->add_setting( 'new_post_list_style_mobile', [
        'default' => null,
    ]);
    $wp_customize->add_control( 'new_post_list_style_mobile', [
        'section' => 'design',
        'settings' => 'new_post_list_style_mobile',
        'label' => '新着記事一覧デザイン（スマホ）',
        'type' => 'select',
        'choices' => $post_style_list,
    ]);
    //アーカイブページモバイル
    $wp_customize->add_setting( 'archive_post_list_style_mobile', [
        'default' => null,
    ]);
    $wp_customize->add_control( 'archive_post_list_style_mobile', [
        'section' => 'design',
        'settings' => 'archive_post_list_style_mobile',
        'label' => 'アーカイブ記事一覧デザイン（スマホ）',
        'type' => 'select',
        'choices' => $post_style_list,
    ]);
    //関連記事モバイル
    $wp_customize->add_setting( 'related_post_list_style_mobile', [
        'default' => null,
    ]);
    $wp_customize->add_control( 'related_post_list_style_mobile', [
        'section' => 'design',
        'settings' => 'related_post_list_style_mobile',
        'label' => '関連記事一覧デザイン（スマホ）',
        'type' => 'select',
        'choices' => $post_style_list,
    ]);
    //PC用
    $post_style_list += [
        '2-5' => '2列',
        '3-3' => '3列',
        '4-2' => '4列',
    ];
    unset($post_style_list['big']);
    //トップページPC
    $wp_customize->add_setting( 'new_post_list_style_pc', [
        'default' => null,
    ]);
    $wp_customize->add_control( 'new_post_list_style_pc', [
        'section' => 'design',
        'settings' => 'new_post_list_style_pc',
        'label' => '新着記事一覧デザイン（PC）',
        'type' => 'select',
        'choices' => $post_style_list,
    ]);
    //アーカイブページPC
    $wp_customize->add_setting( 'archive_post_list_style_pc', [
        'default' => null,
    ]);
    $wp_customize->add_control( 'archive_post_list_style_pc', [
        'section' => 'design',
        'settings' => 'archive_post_list_style_pc',
        'label' => 'アーカイブ記事一覧デザイン（PC）',
        'type' => 'select',
        'choices' => $post_style_list,
    ]);
    //関連記事PC
    $wp_customize->add_setting( 'related_post_list_style_pc', [
        'default' => null,
    ]);
    $wp_customize->add_control( 'related_post_list_style_pc', [
        'section' => 'design',
        'settings' => 'related_post_list_style_pc',
        'label' => '関連記事一覧デザイン（PC）',
        'type' => 'select',
        'choices' => $post_style_list,
    ]);
    //関連記事の表示数
    $wp_customize->add_setting( 'related_post_count', [
        'default' => 10,
    ]);
    $wp_customize->add_control( 'related_post_count', [
        'section' => 'design',
        'settings' => 'related_post_count',
        'label' => '関連記事の表示数',
        'description' => '数字のみ入力してください（例：10記事→10、6記事→6、非表示→0または空白）',
        'type' => 'number',
    ]);
    //抜粋の文字数
    $wp_customize->add_setting( 'custom_excerpt_length', [
        'default' => 80,
    ]);
    $wp_customize->add_control( 'custom_excerpt_length', [
        'section' => 'design',
        'settings' => 'custom_excerpt_length',
        'label' => '抜粋の長さ',
        'description' => '数字のみ入力してください（例：100文字→100、200文字→200）',
        'type' => 'number',
    ]);
    //文字を丸める
    $wp_customize->add_setting( 'line_clamp', [
        'default' => null,
    ]);
    $wp_customize->add_control( 'line_clamp', [
        'section' => 'design',
        'settings' => 'line_clamp',
        'label' => '記事一覧のタイトルが指定行より長い場合に文字を省略する',
        'type' => 'radio',
        'choices'    => [
            null => '文字を省略しない',
            '2line' => '2行で省略',
            '3line' => '3行で省略',
        ],
    ]);
    //固定ヘッダー
    $wp_customize->add_setting( 'fixed_header', array (
        'default' => false,
    ));
    $wp_customize->add_control( 'fixed_header', array(
        'section' => 'design',
        'settings' => 'fixed_header',
        'label' =>'固定ヘッダー',
        'type' => 'checkbox',
    ));
    //固定フッター
    $wp_customize->add_setting( 'fixed_footer', [
        'default' => null,
    ]);
    $wp_customize->add_control( 'fixed_footer', [
        'section' => 'design',
        'settings' => 'fixed_footer',
        'label' =>'固定フッター',
        'type' => 'radio',
        'choices' => [
          null => '非表示（デフォルト）',
          'menu' => 'メニューを表示',
  				'share' => 'シェアボタン',
          'overlay' => 'オーバーレイ広告',
        ],
    ]);
    //固定フッターメニューリスト
    $fixed_footer_menu_list = [
        'home' => 'ホームに戻る',
        'search' => '検索',
        'share' => 'シェア',
        'slide-menu' => 'スライドメニュー',
        'top' => 'トップに戻る',
        'prev' => '前の記事',
        'next' => '次の記事',
    ];
    foreach ($fixed_footer_menu_list as $default => $name) {
        $wp_customize->add_setting( 'fixed_footer_menu_'.$default, [
            'default' => true,
        ]);
        $wp_customize->add_control( 'fixed_footer_menu_'.$default, [
            'section' => 'design',
            'settings' => 'fixed_footer_menu_'.$default,
            'label' => $name,
            'type' => 'checkbox',
        ]);
    }
  }

}
new CustomizerLayoutSettings_4536();

function layout_4536() {
  global $post;
  if( is_singular() ) {
    $custom_layout = get_post_meta( $post->ID, 'singular_layout_select', true );
    return !empty( $custom_layout ) ? $custom_layout : get_theme_mod( 'layout_singular', 'left-content' );
  } elseif( is_archive() || is_search() ) {
    return get_theme_mod( 'layout_archive', 'left-content' );
  } else {
    return get_theme_mod( 'layout_home', 'left-content' );
  }
}

function body_width_4536() {
  global $post;
  if( is_singular() ) {
    $custom_body_width = get_post_meta( $post->ID, 'singular_body_width_select', true );
    return !empty( $custom_body_width ) ? $custom_body_width : get_theme_mod( 'body_width_singular', 'width-1080' );
  } elseif( is_archive() || is_search() ) {
    return get_theme_mod( 'body_width_archive', 'width-1080' );
  } else {
    return get_theme_mod( 'body_width_home', 'width-1080' );
  }
}
