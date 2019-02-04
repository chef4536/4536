<?php

//埋め込みコンテンツのキャッシュ削除
$data = $wpdb->prepare("
    DELETE FROM $wpdb->postmeta
    WHERE meta_key LIKE %s
    AND meta_value = %s
    AND post_id = %d
", '_oembed_%', '{{unknown}}', 11679);
$wpdb->query($data);

//埋め込みコンテンツのキャッシュ削除（コア実装済み）
// function delete_oembed_caches_4536( $post_ID ) {
// 	$post_metas = get_post_custom_keys( $post_ID );
// 	if( empty($post_metas) ) return;
//   var_dump($post_metas);
// 	foreach ( $post_metas as $post_meta_key ) {
// 		if ( '_oembed_' == substr( $post_meta_key, 0, 8 ) )
// 			delete_post_meta( $post_ID, $post_meta_key );
// 	}
// }

//執筆画面で適用
// add_filter( 'embed_html', function( $output, $post, $width, $height ) {
//   if(preg_match('/<blockquote class="wp-embedded-content"><a href="(.+?)"/', $output, $match) !== 1) return $output;
//   $url = $match[1];
//   $html = url_to_blogcard_4536($cache, $url);
//   return $html;
// }, 10, 4 );

//参考サイト：https://nelog.jp/wordpress-blog-card
//オリジナルのブログカード生成
add_filter( 'embed_oembed_html', 'url_to_blogcard_4536', 999999, 2 );
function url_to_blogcard_4536( $cache, $url ) {

  if(!custom_blogcard()) return $cache;

  if(strpos( $url, site_url() ) === false) {
    // $cache = preg_replace('/<iframe.+?<\/iframe>/i', '<div class="responsive-wrapper">${0}</div>', $cache);
    return $cache;
  }

  $id = url_to_postid($url);
  if(empty($id)) return $cache;
  $post = get_post($id);
  $title = $post->post_title;
  $content = $post->post_content;
  $excerpt = '<div class="blogcard-excerpt display-none-mobile">'.custom_excerpt_4536($content).'</div>';
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
      $thumbnail = get_the_post_thumbnail($id, $thumb, ['class' => 'blogcard-thumb-image'] );//サムネイルの取得
      if(empty($thumbnail) && function_exists('get_first_image_4536') && get_first_image_4536()) {
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
          $thumbnail = '<div class="post-list-thumbnail '.$image_size.'"><div class="background-thumbnail-4536 blogcard-thumbnail '.$class.'"></div></div>';
      } else {
          $thumbnail = null;
      }
  }
  if(line_clamp()=='2line') $line_clamp = ' line-clamp-2';
  if(line_clamp()=='3line') $line_clamp = ' line-clamp-3';

  $output = '<a class="blogcard margin-1_5em-auto post-list flexbox-row-wrap blogcard-link" href="'.$url.'">'.$thumbnail.'<div class="blogcard-info flex-1'.$line_clamp.'">'.
            '<span class="blogcard-related-font">関連</span>'.
            '<span class="blogcard-title">'.$title.'</span>'.
            $excerpt.
            '<div class="blogcard-more-wrap"><span class="blogcard-more">続きを読む</span><i class="fas fa-long-arrow-alt-right"></i></div>'.
          '</div></a>';

  // $html = $thumbnail.$excerpt;

  return $output;
}

add_action('init', function() {
  return;
    if(!custom_blogcard()) return;
    //oembed無効
    add_filter( 'embed_oembed_discover', '__return_false' );
    //Embeds
    remove_action( 'parse_query', 'wp_oembed_parse_query' );
    remove_action( 'wp_head', 'wp_oembed_remove_discovery_links' );
    remove_action( 'wp_head', 'wp_oembed_remove_host_js' );
    //Wordpress4.5.3でポスト時に再び表示されるようになってしまったので対処
    remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result');
});
