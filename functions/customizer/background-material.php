<?php

/**
 *
 */
class BackgroundMaterial_4536 {

  function __construct() {
    add_action( 'customize_register', [$this, 'register'] );
    add_filter( 'admin_init', [$this, 'add_style'] );
  }

  function register( $wp_customize ) {
    $wp_customize->add_setting( 'background_material', [
      'default' => null,
    ]);
    $wp_customize->add_control( 'background_material', [
      'section' => 'background_image',
      'settings' => 'background_material',
      'label' => '背景素材',
      'type' => 'radio',
      'choices' => [
        null => '使用しない',
        'dot' => 'ドット',
        'wall' => 'ウォール',
        'polygon' => 'ポリゴン',
      ],
      'priority' => 0,
    ]);
  }

  function add_style( $css ) {
    $material = get_theme_mod( 'background_material', null );
    if( empty( $material ) || !empty( get_background_image() ) ) return $css;
    $img = get_parent_theme_file_uri( 'img/material/' . $material . '.png' );
    set_theme_mod( 'background_image', $img );
    // $css[] = 'body{background-image:url('.$img.')}';
    // return $css;
  }

}
new BackgroundMaterial_4536();
