<?php

//エディター拡張
add_action( 'init', function() {
    $path = get_parent_theme_file_uri() . '/functions/gutenberg/';
    //ブロック関係
    $script = [
        'balloon',
    ];
    foreach($script as $name) {
        wp_register_script( 'gutenberg-'.$name.'-4536', $path . 'blocks/' . $name . '/' . $name . '.js', [ 'wp-blocks', 'wp-components', 'wp-element', 'wp-i18n', 'wp-editor' ] );
        if(function_exists('register_block_type')) register_block_type( 'blocks/'.$name, [ 'editor_script' => 'gutenberg-'.$name.'-4536' ]);
    }
    //ツールバー
    $script = [
        'inline-code',
        'inline-font-color',
        'inline-font-size-large',
        'inline-font-size-small',
        'inline-font-underline',
    ];
    foreach($script as $name) {
        wp_register_script( 'gutenberg-'.$name.'-4536', $path . 'toolbar/' . $name . '/' . $name  . '.js', [ 'wp-blocks', 'wp-components', 'wp-element', 'wp-i18n', 'wp-editor' ] );
        if(function_exists('register_block_type')) register_block_type( 'toolbar/'.$name, [ 'editor_script' => 'gutenberg-'.$name.'-4536' ]);
    }
});

//ブロックカテゴリー追加
add_filter('block_categories', function($categories) {
    $categories[] = [
        'slug'  => 'custom-block-4536',
        'title' => __('4536オリジナル'),
    ];
    return $categories;
});

//エディタの見た目を実際のサイトに近づける
add_action( 'enqueue_block_editor_assets', function() {
    
    $path = get_parent_theme_file_uri() . '/functions/gutenberg/';
    
//    $path = get_parent_theme_file_uri() . '/functions/gutenberg/';
//    wp_enqueue_style( 'editor-style', $path . 'gutenberg-editor-style.min.css', [], theme_version_4536(), 'all' );
//    wp_enqueue_script( 'custom-block-4536', $path . 'custom-block.js', [ 'wp-blocks', 'wp-element' ] );
//    wp_localize_script( 'custom-block-4536' , 'gutenberg-path' , [ 'url' => $path ] );

    //エディター専用
    wp_enqueue_style( 'editor-style', $path . 'gutenberg-editor-style.min.css', [], theme_version_4536(), 'all' );

    $list = [
        'inline',
    ];
    foreach($list as $name) {
        wp_enqueue_style( $name, get_theme_file_uri( '/css/'.$name.'.min.css' ), false, theme_version_4536(), 'all' );
    }
    
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.min.css', [], theme_version_4536() );
    if(!empty(add_google_fonts())) wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Nunito'.add_google_fonts(), [], theme_version_4536() );

//    $mtime = date("ymdHis", filemtime( get_stylesheet_directory().'/style.css'));
//    if(is_child_theme()) wp_enqueue_style( 'child-style', get_stylesheet_directory_uri().'/style.css?'.$mtime, theme_version_4536() );

    ob_start();
    heading_style_change_4536().customizer_color().dynamic_css_head_4536();
    $admin_style_color = ob_get_clean();
    $css = $admin_style_color.wp_get_custom_css();
    $css = str_replace('#contents-inner', 'body', $css );
    $css = str_replace('.article-body', '', $css );
    wp_register_style( 'custom-inline-css', false );
	wp_enqueue_style( 'custom-inline-css' );
	wp_add_inline_style( 'custom-inline-css', $css );

    //吹き出し用カスタムデータ
    $user = wp_get_current_user();
    $avatar = get_avatar_url($user->ID);
    $avatar_name = $user->display_name;
    echo '<div id="gutenberg-balloon-avatar" data-balloon-avatar="'.$avatar.'" style="display:none;"></div>'.
    '<div id="gutenberg-balloon-avatar-name" data-balloon-avatar-name="'.$avatar_name.'" style="display:none;"></div>';

});

//Gutenbergのデフォルトスタイルシートを違う場所で読み込む
add_action('wp_enqueue_scripts', function() {
    wp_dequeue_style( 'wp-block-library' );
});

//Gutenbergのスタイルシートをリンクにする
function wp_block_lib_stylesheet_url() {
    return includes_url('css/dist/block-library/style.min.css?'.get_bloginfo('version'));
}

//画像の幅広
add_theme_support( 'align-wide' );

//エディター拡張
class GutenbergEditorJS4536 {
	function __construct() {
        $list = [
            'editor_custom',
        ];
        foreach($list as $name) {
            add_action( 'admin_head-post.php', [$this, $name] );
            add_action( 'admin_head-post-new.php', [$this, $name] );
        }
	}
    function editor_custom() { ?>
        <script>
            window.addEventListener('DOMContentLoaded', function(){ 
                [].forEach.call(document.querySelectorAll("div.edit-post-visual-editor"), e => e.classList.add('post', 'article-body', 'simple1', 'simple2', 'simple3', 'pop', 'cool', 'cool2', 'cool3'));
            });
        </script>
    <?php }
}
new GutenbergEditorJS4536();

