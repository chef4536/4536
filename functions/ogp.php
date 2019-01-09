<?php

// OGP設定
add_action('wp_head', 'ogp_setting_4536');
function ogp_setting_4536() {
    
    if(!is_ogp()) return;
    
    $fb_app_id = get_the_author_meta('fb_app_id',$user_ID);
    $twitter = get_the_author_meta('twitter',$user_ID);
    $no_img = get_template_directory_uri().'/img/4536_logo.png';
    global $post;
    $title = wp_get_document_title();
    if(is_singular() && get_post_meta($post->ID,'sns_title',true)) $title = get_post_meta($post->ID,'sns_title',true);

    if( has_post_thumbnail() ) {
        $thumbnail = wp_get_attachment_url( get_post_thumbnail_id() ); // サムネイル取得
    } elseif (function_exists('get_first_image_4536') && get_first_image_4536()) {
        $thumbnail = get_first_image_4536(); // 記事の1番上の画像取得
    } elseif ( get_site_icon_url() ) {
        $thumbnail = get_site_icon_url(); // サイトアイコン取得
    } else {
        $thumbnail = $no_img; // NOイメージ
    }

    //タイトル
    echo '<meta property="og:title" content="'.$title.'">'
        .'<meta name="twitter:title" content="'.$title.'">';

    //ディスクリプション
    if(description_4536()) {
        echo '<meta property="og:description" content="'.description_4536().'">'
            .'<meta name="twitter:description" content="'.description_4536().'">';
    }

    //デフォルト画像をアイコンにしておく
    $og_img = (get_site_icon_url()) ? '<meta property="og:image" content="'.get_site_icon_url().'">' : '<meta property="og:image" content="'.$no_img.'">' ;
    $twitter_img = (get_site_icon_url()) ? '<meta name="twitter:image" content="'.get_site_icon_url().'">' : '<meta name="twitter:image" content="'.$no_img.'">' ;

    //OGP
    echo '<meta property="og:site_name" content="'.get_bloginfo('name').'">'
        .'<meta property="og:locale" content="ja_JP">';
    $og_type = '<meta property="og:type" content="website">';
    if(!empty($fb_app_id)) echo '<meta property="fb:app_id" content="'.$fb_app_id.'">';
    echo '<meta name="twitter:card" content="'.twitter_card().'">';
    if(!empty($twitter)) echo '<meta name="twitter:site" content="@'.$twitter.'">';
    if(is_home()) { //トップページ
        $home_url = get_home_url();
        echo '<meta property="og:url" content="'.$home_url.'">';
        echo '<meta name="twitter:url" content="'.$home_url.'">';
    } elseif(is_singular() || is_front_page()) { //記事ページ
        echo '<meta property="og:url" content="'.get_the_permalink().'">';
        $og_type = '<meta property="og:type" content="artcle">';
        $og_img = '<meta property="og:image" content="'.$thumbnail.'">';
        echo '<meta name="twitter:url" content="'.get_the_permalink().'">';
        $twitter_img = '<meta name="twitter:image" content="'.$thumbnail.'">';
    } else { // その他
        $http = is_ssl() ? 'https://' : 'http://';
        $url = esc_url($http . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        echo '<meta property="og:url" content="'.$url.'">';
        echo '<meta name="twitter:url" content="'.$url.'">';
    }
    
    echo $og_type.$og_img.$twitter_img;

}