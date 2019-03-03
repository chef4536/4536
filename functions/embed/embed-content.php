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

    $data = $this->get_data_from_internal_link($url);

    if( $data !== false ) {
      $thumbnail = $data['thumbnail'];
      $sitename = $data['sitename'];
      $icon = $data['icon'];
      $comment = $data['comment'];
    } else {
      $data = $this->get_data_from_external_link($url);
      if( $data === false ) return '<p><del>'.$url.'</del></p>';
      $thumbnail = ( !empty($data['src']) ) ? '<img width="150" height="150" src="'.$data['src'].'" class="external-thumbnail" />' : '';
      $sitename = $data['host'];
    }

    $title = $data['title'];

    $excerpt = ( !empty($data['excerpt']) ) ? $data['excerpt'] : $title;

    $more_text = ( isset($data['more_text']) === true ) ? '<span class="blogcard-more-wrap"><span class="blogcard-more">'.$data['more_text'].'</span></span>' : '';

    $icon = ( isset($icon)===true && !empty($icon) ) ? $icon : '<img width="16" height="16" src="https://www.google.com/s2/favicons?domain='.$url.'" />';

    $comment = ( isset($comment) && !empty($comment) ) ? '<span class="wp-embed-comments"><i class="dashicons dashicons-admin-comments"></i><span>'.$comment.'</span></span>' : '';

    $title = ( !empty($title) ) ? '<span class="wp-embed-heading">'.$title.'</span>' : '';
    $excerpt = ( !empty($excerpt) ) ? '<span class="wp-embed-excerpt">'.$excerpt.'</span>' : '';

    $external_link = ' target="_blank" rel="noreferrer noopener"';

    if ( empty($thumbnail) ) return '<a data-embed-content="false" href="'.$url.'"'.$external_link.'>'.$data['title'].'</a>';

    $image_size = (thumbnail_size()=='thumbnail') ? ' thumbnail' : ' thumbnail-wide' ;

    if( blogcard_thumbnail_display()==='background-image' ) {
      $src = (has_post_thumbnail()) ? get_the_post_thumbnail_url($id) : get_some_image_url_4536($content);
      $class = get_thumbnail_class_4536($src);
      $thumbnail = '<span class="background-thumbnail-4536 blogcard-thumbnail '.$class.'"></span>';
    }

    if ( is_my_website( $url ) === true ) {
      $blockquote_begin = $blockquote_end = '';
      $external_link = '';
    } else {
      $blockquote_begin = '<blockquote class="external-website-embed-content" cite="'.$url.'"><p>';
      $blockquote_end = '</p></blockquote>';
    }

    $output = <<< EOM
    {$blockquote_begin}
    <a data-embed-content="true" class="wp-embed post-color" href="{$url}"{$external_link}>
      {$title}
      <span class="blogcard-image-info-wrap">
        <span class="wp-embed-featured-image post-list-thumbnail'.$image_size.'">
          {$thumbnail}
        </span>
        <span class="blogcard-info">
          {$excerpt}
          {$more_text}
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
    {$blockquote_end}
EOM;

    return $output;

  }

  function create_embed_content_before($output) {
    if ( preg_match('/<blockquote class="wp-embedded-content".*?><a href="(.+?)"/i', $output, $match) !== 1 ) return $output;
    $url = esc_url($match[1]);
    if ( is_my_website( $url ) === false ) return $url;
    $html = $this->create_embed_content_from_url($url);
    return $html;
  }

  function create_embed_content_after($content) {

    $res = preg_match_all('/^(<p>)?(<a[^>]+?>)?https?:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+(<\/a>)?(?!.*<br *\/?>).*?(<\/p>)?/im', $content, $matches);

    if ( empty($res) ) return $content;
    foreach ($matches[0] as $match) {
      $url = esc_url( strip_tags($match) );
      $content = preg_replace('{^'.preg_quote($match, '{}').'}im', $this->create_embed_content_from_url($url), $content, 1);
    }

    return $content;
  }

  function get_data_from_internal_link($url) {

    $id = url_to_postid($url);

    $sitename = ( !empty( site_title() ) ) ? site_title() : get_bloginfo('name');

    $icon = wp_get_attachment_image( get_option('site_icon'), [16,16] );

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

    if ( $id !== 0 ) {
      $data = get_post($id);
      $title = $data->post_title;
      $content = $data->post_content;
      $comment = $data->comment_count;
      $excerpt = custom_excerpt_4536($content, custom_excerpt_length());
      $more_text = '続きを見る';
    } else {
      if ( $url === site_url() ) {
        $title = $sitename;
        $content = (custom_home_description()) ? custom_home_description() : get_bloginfo('description');
        $excerpt = custom_excerpt_4536($content, custom_excerpt_length());
      } else {
        $path = str_replace( site_url().'/', '', $url );
        // $parse_url = parse_url( $url );
        $path = explode( '/', $path );
        if ( !is_array($path) ) return false;
        // $reverse_path = array_reverse($path);
        $type = $path[0];
        $slug = end( $path );
        if ( $type === 'category' ) {
          $cat = get_term_by( 'slug', $slug, 'category' );
          $title = $cat->name.'の記事一覧';
          $excerpt = ( !empty($cat->description) ) ? $cat->description : '';
        } elseif ( $type === 'tag' ) {
          $tag = get_term_by( 'slug', $slug, 'post_tag' );
          $title = $tag->name.'の記事一覧';
          $excerpt = ( !empty($tag->description) ) ? $tag->description : '';
        } elseif ( $type === 'author' ) {
          $excerpt = get_user_by( 'slug', $slug )->display_name.'の記事一覧';
        } else {
          return false;
        }
      }
    }

    // if ( $cat = get_category_by_path($url, false) ) {
    //   //https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/get_category_by_path
    // }

    return compact(
      'title',
      'excerpt',
      'thumbnail',
      'sitename',
      'icon',
      'comment',
      'more_text'
    );
  }

  function get_data_from_external_link($url) {

    $transient = 'ogp_cache_4536_'.md5($url);

    $data = $cache = get_transient($transient);

    if ($cache === false) {
      $data = [];
      $data = OpenGraph::fetch($url);
      if( !is_object($data) ) return false;
      set_transient(
        $transient,
        $data,
        WEEK_IN_SECONDS //1週間
      );
    }

    if(!empty($data)) $data = [
      'title' => $data->title,
      'excerpt' => custom_excerpt_4536( $data->description, custom_excerpt_length() ),
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

add_filter( 'embed_head', function() {
  wp_enqueue_style( 'wp-embed-4536', get_parent_theme_file_uri('css/oembed.min.css') );
});
// remove_action( 'embed_head', 'print_embed_styles' );

add_filter( 'the_excerpt_embed', function() {
  $excerpt = custom_excerpt_4536(get_the_content(), custom_excerpt_length());
  return $excerpt;
});