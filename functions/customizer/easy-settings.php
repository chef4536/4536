<?php

/**
 *
 */
class EasySettings_4536 {

  public $design_theme_array = [
    '_default' => 'デフォルト',
    'white' => 'ホワイト',
    'dark-black' => 'ダークブラック',
    'sea-green' => 'シーグリーン',
    'cyan-blue' => 'シアンブルー',
    'deep-pink' => 'ディープピンク',
  ];

  function __construct() {
    add_action( 'customize_register', [ $this, 'register' ] );
    add_action( 'wp_loaded', [ $this, 'save' ] );
  }

  function register( $wp_customize ) {
    $wp_customize->add_section( 'design_theme', [
      'title' => 'デザインテーマ（かんたん設定）',
      'priority' => 0,
    ]);
    $wp_customize->add_setting( 'design_theme', [
      'default' => '_default',
    ]);
    $wp_customize->add_control( 'design_theme', [
      'section' => 'design_theme',
      'settings' => 'design_theme',
      // 'label' => 'デザインテーマ',
      'type' => 'radio',
      'choices' => $this->design_theme_array,
    ]);
  }

  function save() {
    // $old = get_option('theme_mods_' . wp_get_theme() )['design_theme'];
    $current = get_theme_mod( 'design_theme', '_default' );
    // if( $old === $this->current_design() ) return;
    $path = __DIR__ . '/design-theme/' . $current . '/setting.json';
    if( !file_exists($path) ) return;
    ob_start();
    require_once( $path );
    $json = ob_get_clean();
    $array = json_decode( $json );
    foreach( $array as $key => $value ) {
      set_theme_mod( $key, $value );
    }
    set_theme_mod( 'h1_style', null );
    set_theme_mod( 'h2_style', 'simple1' );
    set_theme_mod( 'h3_style', 'simple2' );
    set_theme_mod( 'h4_style', 'simple3' );
    set_theme_mod( 'related_post_title_style', 'simple1' );
    set_theme_mod( 'sidebar_widget_title_style', 'simple1' );
  }

}
new EasySettings_4536();
