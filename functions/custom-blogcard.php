<?php

//参考サイト：https://nelog.jp/wordpress-blog-card

//サイトドメインを取得
function get_this_site_domain_4536(){
  //ドメイン情報を$results[1]に取得する
  preg_match( '/https?:\/\/(.+?)\//i', admin_url(), $results );
  return $results[1];
}

//本文中のURLをブログカードタグに変更する
function url_to_blog_card_4536($the_content) {
    if(!is_singular()) return;
    //1行にURLのみが期待されている行（URL）を全て$mに取得
    $res = preg_match_all('/^(<p>)?(<a.+?>)?https?:\/\/'.preg_quote(get_this_site_domain_4536()).'\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+(<\/a>)?(<\/p>)?(<br ? \/>)?$/im', $the_content,$m);
    //マッチしたURL一つ一つをループしてカードを作成
    foreach ($m[0] as $match) {
        $url = strip_tags($match);//URL
        $id = url_to_postid( $url );//IDを取得（URLから投稿ID変換）
        if ( !$id ) continue;//IDを取得できない場合はループを飛ばす
        $post = get_post($id);//IDから投稿情報の取得
        $title = $post->post_title;//タイトルの取得
        $date = mysql2date('Y-m-d H:i', $post->post_date);//投稿日の取得
        $content = strip_shortcodes( $post->post_content );
        $excerpt = '<div class="blog-card-excerpt display-none-mobile">'.custom_excerpt_4536($content).'</div>';//抜粋の取得
        $image_size = (thumbnail_size()=='thumbnail') ? 'thumbnail' : 'thumbnail-wide' ;
        $height = (thumbnail_size()=='thumbnail') ? '512' : '341' ;
        if(blogcard_thumbnail_display()==='image') {
            if(thumbnail_size()=='thumbnail') {
                $thumb100 = [100,100];
                $thumb150 = [150,150];
                $thumb300 = [300,300];
            } else {
                $thumb100 = [100,75];
                $thumb150 = [150,113];
                $thumb300 = [300,225];
            }
            $thumb = (thumbnail_quality()==='high') ? $thumb300 : $thumb150;
            $thumbnail = get_the_post_thumbnail($id, $thumb, ['class' => 'blog-card-thumb-image'] );//サムネイルの取得
            if(!$thumbnail && function_exists('get_first_image_4536') && get_first_image_4536()) {
                preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $first_img);
                $src = ($first_img) ? $first_img[1] : '';
                $thumbnail = '<img src="'.$src.'" width="512" height="'.$height.'" />';
            }
            if($thumbnail) {
                $thumbnail = '<div class="'.$image_size.'">'.$thumbnail.'</div>';
            } else {
                $thumbnail = null;
            }
        } else {
            $src = get_the_post_thumbnail_url($id);
            if(!$src && function_exists('get_first_image_4536') && get_first_image_4536()) {
                preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $first_img);
                $src = ($first_img[1]) ? $first_img[1] : '';
            }
            if($src) {
                $class = get_thumbnail_class_4536($src);
                $thumbnail = '<div class="post-list-thumbnail '.$image_size.'"><div class="background-thumbnail-4536 blog-card-thumbnail '.$class.'"></div></div>';
            } else {
                $thumbnail = null;
            }
        }
        if(line_clamp()=='2line') $line_clamp = ' line-clamp-2';
        if(line_clamp()=='3line') $line_clamp = ' line-clamp-3';
        //取得した情報からブログカードのHTMLタグを作成
        $tag = '<a class="blog-card post-list flexbox-row-wrap clearfix blog-card-link clearfix" href="'.$url.'">'.$thumbnail.'<div class="blog-card-info"><div class="blog-card-title'.$line_clamp.'">'.$title.'</div>'.$excerpt.'</div></a>';
        //本文中のURLをブログカードタグで置換
        $the_content = preg_replace('{'.preg_quote($match).'}', $tag , $the_content, 1);
    }
    return $the_content;//置換後のコンテンツを返す
}

add_action('init', function() {
    if(!custom_blogcard()) return;
    add_filter( 'the_content', 'url_to_blog_card_4536' );
    //oembed無効
    add_filter( 'embed_oembed_discover', '__return_false' );
    //Embeds
    remove_action( 'parse_query', 'wp_oembed_parse_query' );
    remove_action( 'wp_head', 'wp_oembed_remove_discovery_links' );
    remove_action( 'wp_head', 'wp_oembed_remove_host_js' );
    //Wordpress4.5.3でポスト時に再び表示されるようになってしまったので対処
    remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result');
});
