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
    add_filter('embed_html', [$this, 'create_embed_content_before']); //前
    // add_filter('embed_oembed_html', [$this, 'create_embed_content']); //後
    add_filter('the_content', [$this, 'create_embed_content_after']); //前
  }

  function create_embed_content_from_url($url) {
    if(strpos( $url, site_url() ) !== false) {
      $data = $this->get_data_from_internal_link($url);
      $thumbnail = $data['thumbnail'];
    } else {
      $data = $this->get_data_from_external_link($url);
      $src = $data['src'];
      $thumbnail = $src; //処理
    }
    $title = $data['title'];
    $excerpt = $data['excerpt'];
    if(empty($thumbnail)) {
      //処理
    }

    // return $title.$description.$src;

    $image_size = (thumbnail_size()=='thumbnail') ? 'thumbnail' : 'thumbnail-wide' ;
    if(blogcard_thumbnail_display()==='image') {
      $thumbnail = (!empty($thumbnail)) ? '<div class="embed-image '.$image_size.'">'.$thumbnail.'</div>' : '';
    } else {
      $src = (has_post_thumbnail()) ? get_the_post_thumbnail_url($id) : get_some_image_url_4536($content);
      $class = get_thumbnail_class_4536($src);
      $thumbnail = '<div class="post-list-thumbnail '.$image_size.'"><div class="embed-image background-thumbnail-4536 blogcard-thumbnail '.$class.'"></div></div>';
    }

$output = <<< EOM
<a class="blogcard margin-1_5em-auto post-list blogcard-link" href="{$url}">
  <p class="blogcard-title">{$title}</p>
  {$thumbnail}
  <p class="blogcard-excerpt">{$excerpt}</p>
  <p class="blogcard-more-wrap"><span class="blogcard-more">続きを読む</span></p>
</a>
EOM;

    return $output;

  }

  function create_embed_content_after($content) {
    $res = preg_match_all('/^(<p>||<div class="wp-block-embed__wrapper">)?(<a[^>]+?>)?https?:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+(<\/a>)?(?!.*<br *\/?>).*?(<\/p>||<\/div>)?/im', $content, $matches);
    foreach ($matches[0] as $match) {
      $url = strip_tags($match);
      $content = str_replace($match, $this->create_embed_content_from_url($url), $content);
    }
    return $content;
  }

  function create_embed_content_before($output) {
    if(preg_match('/<blockquote class="wp-embedded-content".*?><a href="(.+?)"/i', $output, $match) !== 1) return $output;
    $html = $this->create_embed_content_from_url($match[1]);
    return $html;


    // $id = url_to_postid($url);
    // if(empty($id)) return $cache;
    // $post = get_post($id);
    // $title = $post->post_title;
    // $content = $post->post_content;
    // $excerpt = '<div class="blogcard-excerpt display-none-mobile">'.custom_excerpt_4536($content, custom_excerpt_length()).'</div>';
    // $image_size = (thumbnail_size()=='thumbnail') ? 'thumbnail' : 'thumbnail-wide' ;
    // $height = (thumbnail_size()=='thumbnail') ? '512' : '341' ;
    // if(blogcard_thumbnail_display()==='image') {
    //     if(thumbnail_size()=='thumbnail') {
    //         $thumb100 = [100,100];
    //         $thumb150 = [150,150];
    //         $thumb300 = [300,300];
    //     } else {
    //         $thumb100 = [100,75];
    //         $thumb150 = [150,113];
    //         $thumb300 = [300,225];
    //     }
    //     $thumb = (thumbnail_quality()==='high') ? $thumb300 : $thumb150;
    //     $thumbnail = get_the_post_thumbnail($id, $thumb, ['class' => 'blogcard-thumb-image'] );//サムネイルの取得
    //     if(empty($thumbnail) && function_exists('get_first_image_4536') && get_first_image_4536()) {
    //         preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $first_img);
    //         $src = ($first_img) ? $first_img[1] : '';
    //         $thumbnail = '<img src="'.$src.'" width="512" height="'.$height.'" />';
    //     }
    //     if($thumbnail) {
    //         $thumbnail = '<div class="'.$image_size.'">'.$thumbnail.'</div>';
    //     } else {
    //         $thumbnail = null;
    //     }
    // } else {
    //     $src = get_the_post_thumbnail_url($id);
    //     if(!$src && function_exists('get_first_image_4536') && get_first_image_4536()) {
    //         preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $first_img);
    //         $src = ($first_img[1]) ? $first_img[1] : '';
    //     }
    //     if($src) {
    //         $class = get_thumbnail_class_4536($src);
    //         $thumbnail = '<div class="post-list-thumbnail '.$image_size.'"><div class="background-thumbnail-4536 blogcard-thumbnail '.$class.'"></div></div>';
    //     } else {
    //         $thumbnail = null;
    //     }
    // }
    // if(line_clamp()=='2line') $line_clamp = ' line-clamp-2';
    // if(line_clamp()=='3line') $line_clamp = ' line-clamp-3';
    //
    // $output = '<a class="blogcard margin-1_5em-auto post-list flexbox-row-wrap blogcard-link" href="'.$url.'">'.$thumbnail.'<div class="blogcard-info flex-1'.$line_clamp.'">'.
    //           '<span class="blogcard-related-font">関連</span>'.
    //           '<span class="blogcard-title">'.$title.'</span>'.
    //           $excerpt.
    //           '<div class="blogcard-more-wrap"><span class="blogcard-more">続きを読む</span><i class="fas fa-long-arrow-alt-right"></i></div>'.
    //         '</div></a>';
    //
    // return $output;


  }

  function get_data_from_internal_link($url) {
    $id = url_to_postid($url);
    $data = get_post($id);
    $content = $data->post_content;
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
    return [
      'title' => $data->post_title,
      'excerpt' => custom_excerpt_4536($content, 60),
      'thumbnail' => $thumbnail,
      'comment' => $data->comment_count,
    ];
  }

  function get_data_from_external_link($url) {
    $data = [];
    $data = OpenGraph::fetch($url);
    if(!empty($data)) $data = [
      'title' => $data->title,
      'excerpt' => $data->description,
      'src' => $data->image,
    ];
    return $data;
  }

}
new ConvertEmbedContentFrom_url_4536();



// add_filter( 'pre_oembed_result', function($html, $url, $args) {
//   //
// }, 10, 3);
