<?php
// カスタム投稿タイプ追加
function create_post_type() {
    $main_post_type = esc_html(get_option('main_media_slug'));
    $admin_main_media = esc_html(get_option('admin_main_media'));
    $sub_post_type = esc_html(get_option('sub_media_slug'));
    $admin_sub_media = esc_html(get_option('admin_sub_media'));
    // ミュージック
    if($admin_main_media) {
    register_post_type( 'music' , [
        'labels' => [
            'name' => __( $admin_main_media ),
            'singular_name' => __( $admin_main_media ),
            'all_items' => __( $admin_main_media.' 一覧' )
        ],
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => $main_post_type],
        'menu_position' => 5,
        'supports' => ['title','editor','thumbnail','revisions','comments'],
    ]);
    }
    // ムービー
    if($admin_sub_media) {
    register_post_type( 'movie',[
        'labels' => [
            'name' => __( $admin_sub_media ),
            'singular_name' => __( $admin_sub_media ),
            'all_items' => __( $admin_sub_media.' 一覧' )
        ],
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => $sub_post_type],
        'menu_position' => 5,
        'supports' => ['title','editor','thumbnail','revisions','comments'],
    ]);
    }
    // LP
    register_post_type( 'LP',[
        'labels' => [
            'name' => __( 'LP' ),
            'singular_name' => __( 'ランディングページ' ),
            'all_items' => __( 'ランディングページ 一覧' )
        ],
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => false,
        'menu_position' => 5,
        'supports' => ['title','editor','thumbnail','revisions','comments'],
    ]);
}
add_action( 'init', 'create_post_type' );
