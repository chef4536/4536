<?php

if(empty(custom_blogcard())) return;

add_filter('embed_html', 'convert_embed_content_from_url_4536', 10, 4 ); //編集前
add_filter('embed_oembed_html', 'convert_embed_content_from_url_4536', 10, 4 ); //編集後
function convert_embed_content_from_url_4536( $output, $post, $width, $height ) {
  if(preg_match('/<blockquote class="wp-embedded-content".*?><a href="(.+?)"/i', $output, $match) !== 1) return $output;
  $url = $match[1];
  $data = OpenGraph::fetch($url);
  if(!empty($data)) {
    $title = $data->title;
    $url = $data->url;
    $description = $data->description;
    $src = $data->image;
  }
  return '<img src="'.$src.'">';

  // if(preg_match('/<blockquote class="wp-embedded-content".*?<\/blockquote>/i', $output, $match) !== 1) return $output;
  // $output = str_ireplace($match[0], '', $output);
  // $cite = str_ireplace('<blockquote', '<cite data-embed-content-4536="true"', $match[0]);
  // $cite = str_ireplace('</blockquote>', '</cite>', $cite);
  // $output = $output.$cite;
  // return $output;

}

// add_filter( 'pre_oembed_result', function($html, $url, $args) {
//   //
// }, 10, 3);
