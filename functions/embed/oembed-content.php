<?php

if(empty(custom_blogcard())) return;

  // if(preg_match('/<blockquote class="wp-embedded-content".*?<\/blockquote>/i', $output, $match) !== 1) return $output;
  // $output = str_ireplace($match[0], '', $output);
  // $cite = str_ireplace('<blockquote', '<cite data-embed-content-4536="true"', $match[0]);
  // $cite = str_ireplace('</blockquote>', '</cite>', $cite);
  // $output = $output.$cite;
  // return $output;

/**
 * 正規表現参考：https://github.com/yhira/cocoon/blob/master/lib/blogcard-out.php
 */
class ConvertEmbedContentFrom_url_4536 {

  function __construct() {
    // add_filter('embed_html', [$this, 'create_embed_content_before']); //前
    // add_filter('embed_oembed_html', [$this, 'create_embed_content_before']); //後
    add_filter('oembed_dataparse', [$this, 'create_embed_content_before']); //内部用
    add_filter('the_content', [$this, 'create_embed_content_after']); //外部用
  }

  function create_embed_content_from_url($url) {

    $url = esc_url($url);

    if(strpos( $url, site_url() ) !== false) {
      $data = $this->get_data_from_internal_link($url);
      $thumbnail = $data['thumbnail'];
      $sitename = $data['sitename'];
      $icon = $data['icon'];
      $comment = (empty($data['comment'])) ? '' : '<span class="wp-embed-comments"><i class="dashicons dashicons-admin-comments"></i><span>'.$data['comment'].'</span></span>';
    } else {
      $data = $this->get_data_from_external_link($url);
      $thumbnail = ( !empty($data['src']) ) ? '<img width="150" height="150" src="'.$data['src'].'" class="external-thumbnail" />' : '';
      $sitename = $data['host'];
      $icon = '';
      $comment = '';
    }

    if(empty($icon)) $icon = '<img width="16" height="16" src="https://www.google.com/s2/favicons?domain='.$url.'" />';

    $title = $data['title'];
    $excerpt = $data['excerpt'];

    if ( empty($thumbnail) ) return '<a href="'.$url.'" target="_blank" rel="noreferrer noopener">'.$title.'</a>';

    $image_size = (thumbnail_size()=='thumbnail') ? ' thumbnail' : ' thumbnail-wide' ;

    if( blogcard_thumbnail_display()==='background-image' ) {
      $src = (has_post_thumbnail()) ? get_the_post_thumbnail_url($id) : get_some_image_url_4536($content);
      $class = get_thumbnail_class_4536($src);
      $thumbnail = '<span class="background-thumbnail-4536 blogcard-thumbnail '.$class.'"></span>';
    }

    $output = <<< EOM
    <a class="wp-embed" href="{$url}">
      <span class="wp-embed-heading">{$title}</span>
      <span class="blogcard-image-info-wrap">
        <span class="wp-embed-featured-image post-list-thumbnail'.$image_size.'">
          {$thumbnail}
        </span>
        <span class="blogcard-info">
          <span class="wp-embed-excerpt">{$excerpt}</span>
          <span class="blogcard-more-wrap"><span class="blogcard-more">続きを読む</span></span>
        </span>
      </span>
      <span class="wp-embed-footer">
        <span class="blogcard-siteinfo">
          <span class="site_icon">{$icon}</span>
          <span class="wp-embed-site-title">{$sitename}</span>
        </span>
        {$comment}
      </span>
    </a>
EOM;

    return $output;

  }

  function create_embed_content_before($output) {
    if(preg_match('/<blockquote class="wp-embedded-content".*?><a href="(.+?)"/i', $output, $match) !== 1) return $output;
    $html = $this->create_embed_content_from_url($match[1]);
    return $html;
  }

  function create_embed_content_after($content) {
    $res = preg_match_all('/^(<p>||<div class="wp-block-embed__wrapper">)?(<a[^>]+?>)?https?:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+(<\/a>)?(?!.*<br *\/?>).*?(<\/p>||<\/div>)?/im', $content, $matches);
    foreach ($matches[0] as $match) {
      $url = strip_tags($match);
      $content = preg_replace('{^'.preg_quote($match, '{}').'}im', $this->create_embed_content_from_url($url), $content, 1);
    }
    return $content;
  }

  function get_data_from_internal_link($url) {

    $id = url_to_postid($url);
    $data = get_post($id);
    $sitename = get_bloginfo('name');
    $title = $data->post_title;
    $content = $data->post_content;
    $comment = $data->comment_count;
    $icon = wp_get_attachment_image( get_option('site_icon'), [16,16] );
    $excerpt = custom_excerpt_4536($content, 60);
    if(thumbnail_size()==='thumbnail') {
        $thumb150 = [150,150];
        $thumb300 = [300,300];
    } else {
        $thumb150 = [150,113];
        $thumb300 = [300,225];
    }
    $thumb = (thumbnail_quality()==='high') ? $thumb300 : $thumb150;
    if(has_post_thumbnail($id)) {
      $thumbnail = get_the_post_thumbnail($id, $thumb, ['class' => 'blogcard-thumb-image'] );
    } else {
      $thumbnail = get_some_image_4536($content);
    }

    return compact(
      'title',
      'excerpt',
      'thumbnail',
      'sitename',
      'icon',
      'comment'
    );
  }

  function get_data_from_external_link($url) {

    $url = esc_url($url);

    $transient = 'ogp_cache_4536_'.md5($url);

    $data = $cache = get_transient($transient);

    if ($cache === false) {
      $data = [];
      $data = OpenGraph::fetch($url);
      set_transient(
        $transient,
        $data,
        WEEK_IN_SECONDS //1週間
      );
    }

    if(!empty($data)) $data = [
      'title' => $data->title,
      'excerpt' => $data->description,
      'src' => $data->image,
      'host' => parse_url(esc_url($url))['host'],
    ];
    return $data;
  }

}
new ConvertEmbedContentFrom_url_4536();

// add_filter( 'pre_oembed_result', function($html, $url, $args) {
//   //
// }, 10, 3);

add_filter('template_include', function( $template ) {
  //include_test
  // $template = __DIR__.'/template.php';
  return $template;
});

add_filter('embed_head', function() {
  wp_enqueue_style( 'wp-embed-4536', get_parent_theme_file_uri('css/oembed.min.css') );
});
// remove_action( 'embed_head', 'print_embed_styles' );
