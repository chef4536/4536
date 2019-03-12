<?php

//bodyタグにクラス追加
add_filter( 'body_class', function($classes) {
    global $post;
    if(is_singular()) {
        $layout = layout('layout_singular');
        $custom_layout = get_post_meta($post->ID,'singular_layout_select',true);
        if($custom_layout) $layout = $custom_layout;
        $body_width = body_width('body_width_singular');
        $custom_body_width = get_post_meta($post->ID,'singular_body_width_select',true);
        if($custom_body_width) $body_width = $custom_body_width;
    } elseif(is_archive()||is_search()) {
        $layout = layout('layout_archive');
        $body_width = body_width('body_width_archive');
    } else {
        $layout = layout('layout_home');
        $body_width = body_width('body_width_home');
    }
    $list = [
        $layout,
        $body_width,
        'simple1',
        'simple2',
        'simple3',
        'pop',
        'cool',
        'cool2',
        'cool3',
        'font-size-16px',
        'display-flex',
        'flex-direction-column',
    ];
    foreach($list as $class) {
	   $classes[] = $class;
    }
	return $classes;
});

// 綺麗な抜粋を取得
function custom_excerpt_4536($content, $length) {
    $content = preg_replace('/<!--more-->.+/is', "", $content);
    $content = wp_strip_all_tags($content, true);
    // $content = strip_tags( $content );
    // $content = str_replace( array( '\r\n', '\n', '\r', '&nbsp;' ), '', $content );
    $length = mb_convert_kana(strip_tags($length), 'n') * 2;
    $content = mb_strimwidth( $content, 0, $length, '...' );
    // if(mb_strlen($content,'UTF-8') > $length) {
    //     $content = mb_substr( $content, 0, $length, 'UTF-8' );
    //     return $content.'...';
    // }
    return $content;
}

//自分のサイトかどうか調べる
function is_my_website( $url ) {
  $url = esc_url( $url );
  if ( strpos( $url, get_this_site_domain_4536() )  !== false ) return true;
  return false;
}

//サイトドメインを取得
function get_this_site_domain_4536() {
  if(preg_match( '/https?:\/\/(.+?)\//i', admin_url(), $match ) !== 1) return null;
  return $match[1];
}

// カスタムメニュー
register_nav_menus([
    'navbar' => 'ヘッダー下ナビ（モバイル）',
    'navbar_pc' => 'ヘッダーナビ（PC）',
    'below_header_nav_menu_common' => 'ヘッダー下ナビ（全デバイス共通）',
    'navbar_footer' => 'フッターナビ（全デバイス共通）',
]);

// ヘッダーの余計なタグ削除
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rel_canonical' );
// カテゴリー説明のPタグ削除
remove_filter( 'term_description','wpautop' );

// RSS
add_theme_support('automatic-feed-links');

// 絵文字無効
if(get_option('disenable_wp_emoji')) {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
}

//すべてのカテゴリーページのaタグにクラスを付与
add_filter( 'wp_list_categories', function( $list ) {
  return str_replace( '<a', '<a class="post-color"', $list );
});

//クエリバー追加
//add_filter('query_vars', function( $vars ) {
//    $vars[] = 'list_style';
//    return $vars;
//});

//add_action( 'admin_enqueue_scripts', function() {
//    wp_enqueue_style( 'my_admin_style', get_template_directory_uri().'/css/admin.min.css' );
//});

////////////////////////////////////
// moreリンク
////////////////////////////////////
add_filter( 'the_content_more_link', function($output) {
    $output = preg_replace('/#more-[\d]+/i', '', $output );
    return $output;
});

////////////////////////////////////
// セルフピンバック禁止
////////////////////////////////////
add_action( 'pre_ping', function(&$links) {
    $home = home_url();
    foreach ( $links as $l => $link )
        if ( 0 === strpos( $link, $home ) )
            unset($links[$l]);
});

////////////////////////////////////
// 更新日の追加
////////////////////////////////////
function get_mtime() {
    $mtime = get_the_modified_time('Ymd');
    $ptime = get_the_time('Ymd');
    if($ptime > $mtime) {
        return get_the_time();
    } elseif($ptime === $mtime || !modified_date_datetime()) {
        return null;
    } else {
        $m_time = (modified_date_datetime()==='date') ? get_the_modified_date() : get_the_modified_date().get_the_modified_time();
        return $m_time;
    }
}

///////////////////////////////////
// スマホ表示条件分岐
///////////////////////////////////
function is_mobile(){
    $useragents = array(
        'iPhone', // iPhone
        'iPod', // iPod touch
        'Android.*Mobile', // 1.5+ Android *** Only mobile
        'Windows.*Phone', // *** Windows Phone
        'dream', // Pre 1.5 Android
        'CUPCAKE', // 1.5+ Android
        'blackberry9500', // Storm
        'blackberry9530', // Storm
        'blackberry9520', // Storm v2
        'blackberry9550', // Storm v2
        'blackberry9800', // Torch
        'webOS', // Palm Pre Experimental
        'incognito', // Other iPhone browser
        'webmate' // Other iPhone browser

    );
    $pattern = '/'.implode('|', $useragents).'/i';
    return preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
}

///////////////////////////////////
// 投稿スラッグ自動生成
///////////////////////////////////
function auto_post_slug( $slug, $post_ID, $post_status, $post_type ) {
    if ( preg_match( '/(%[0-9a-f]{2})+/', $slug ) ) {
        $slug = utf8_uri_encode( $post_type ) . '-' . $post_ID;
    }
    return $slug;
}
add_filter( 'wp_unique_post_slug', 'auto_post_slug', 10, 4  );

///////////////////////////////////
// タイトルタグの追加
///////////////////////////////////
add_theme_support( 'title-tag' );

///////////////////////////////////
// コメント欄カスタマイズ
///////////////////////////////////
//ウェブサイトとメールアドレス
function my_comment_form_remove_4536($arg) {
if (!comments_email()) $arg['email'] = '';
if (!comments_website()) $arg['url'] = '';
if (!comments_cookies()) $arg['cookies'] = '';
return $arg;
}
add_filter( 'comment_form_default_fields', 'my_comment_form_remove_4536' );
// 「メールアドレスが公開されることはありません」を削除
function my_comment_form_before_4536($defaults){
if (!comments_mail_address_text()) $defaults['comment_notes_before'] = '';
return $defaults;
}
add_filter( 'comment_form_defaults', 'my_comment_form_before_4536' );

///////////////////////////////////
// ウィジェットのpタグ,brタグを除去
///////////////////////////////////
if(is_widget_wpautop()) remove_filter('widget_text_content', 'wpautop');

///////////////////////////////////
// in_categoryの判別に親子関係を持たせる
///////////////////////////////////
function post_is_in_descendant_category_4536( $cats, $_post = null ) {
    foreach ( (array) $cats as $cat ) {
        // get_term_children() は整数の ID しか受け付けない
        $descendants = get_term_children( (int) $cat, 'category' );
        if ( $descendants && in_category( $descendants, $_post ) && (is_singular() || is_category()) ) return true;
    }
    return false;
}

///////////////////////////////////
// WordPressの自動更新
///////////////////////////////////
//メジャー
if(wordpress_major_update_setting()) {
    add_filter( 'allow_major_auto_core_updates', '__return_true' );
} else {
    add_filter( 'allow_major_auto_core_updates', '__return_false' );
}
//マイナー
if(wordpress_minor_update_setting()) {
    add_filter( 'allow_minor_auto_core_updates', '__return_true' );
} else {
    add_filter( 'allow_minor_auto_core_updates', '__return_false' );
}
//開発版
if(wordpress_dev_update_setting()) {
    add_filter( 'allow_dev_auto_core_updates', '__return_true' );
} else {
    add_filter( 'allow_dev_auto_core_updates', '__return_false' );
}
//プラグイン
if(wordpress_plugin_update_setting()) {
    add_filter( 'auto_update_plugin', '__return_true' );
} else {
    add_filter( 'auto_update_plugin', '__return_false' );
}
//テーマ
if(wordpress_theme_update_setting()) {
    add_filter( 'auto_update_theme', '__return_true' );
} else {
    add_filter( 'auto_update_theme', '__return_false' );
}
//翻訳
if(wordpress_translation_update_setting()) {
    add_filter( 'auto_update_translation', '__return_true' );
} else {
    add_filter( 'auto_update_translation', '__return_false' );
}

///////////////////////////////////////////
// ページ分割
///////////////////////////////////////////
function custom_page_links_4536() {
    $args = [
        'before'           => '<div id="page-links">' . __( '<span class="page-links-title">ページ</span>' ),
        'after'            => '</div>',
        'link_before'      => '<span class="page-link">',
        'link_after'       => '</span>',
        'next_or_number'   => 'number',
        'separator'        => ' ',
        'nextpagelink'     => __( 'Next page' ),
        'previouspagelink' => __( 'Previous page' ),
        'pagelink'         => '%',
        'echo'             => 1
    ];
    return $args;
}
add_filter( 'wp_link_pages_args', 'custom_page_links_4536');

///////////////////////////////////////////
// 管理画面にオリジナルウィジェット表示
///////////////////////////////////////////
function informatiton_widget_4536() {
	echo '<iframe src="https://4536.jp/lp/notice" width="100%" height="300px"></iframe>';
}
function add_original_widget_4536() {
	wp_add_dashboard_widget( 'informatiton_widget', '4536からのお知らせ', 'informatiton_widget_4536' );
}
add_action( 'wp_dashboard_setup', 'add_original_widget_4536' );

///////////////////////////////////////////
// デバイス判別
// 参考：https://qiita.com/nowmura/items/0159233f672542619058
///////////////////////////////////////////
function device_check_4536($ua = null) {
    if ( is_null($ua) ) $ua = $_SERVER['HTTP_USER_AGENT'];
    if ( preg_match('/Windows Phone/ui', $ua) ) { //UAにAndroidも含まれるので注意
        $device = 'windowsphone';
    } elseif ( preg_match('/Windows/', $ua) ) {
        $device = 'windows';
    } elseif ( preg_match('/Macintosh/', $ua) ) {
        $device = 'mac';
    } elseif ( preg_match('/iPhone|iPod|iPad/ui', $ua) ) {
        $device = 'ios';
    } elseif ( preg_match('/Android/ui', $ua) ) {
        $device = 'android';
    }
    return $device;
}
//Windows Phone
function is_windows_phone_4536($ua = null) {
    if(is_null($ua)) $ua = $_SERVER['HTTP_USER_AGENT'];
    $device = (preg_match('/Windows Phone/ui', $ua)) ? true : false;
    return $device;
}
//Windows
function is_windows_4536($ua = null) {
    if(is_null($ua)) $ua = $_SERVER['HTTP_USER_AGENT'];
    $device = (preg_match('/Windows/', $ua)) ? true : false;
    return $device;
}
//Mac
function is_macintosh_4536($ua = null) {
    if(is_null($ua)) $ua = $_SERVER['HTTP_USER_AGENT'];
    $device = (preg_match('/Macintosh/', $ua)) ? true : false;
    return $device;
}

//iOS
function is_ios_4536($ua = null) {
    if(is_null($ua)) $ua = $_SERVER['HTTP_USER_AGENT'];
    $device = (preg_match('/iPhone|iPod|iPad/ui', $ua)) ? true : false;
    return $device;
}

//Android
function is_android_4536($ua = null) {
    if(is_null($ua)) $ua = $_SERVER['HTTP_USER_AGENT'];
    $device = (preg_match('/Android/ui', $ua)) ? true : false;
    return $device;
}
