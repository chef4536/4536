<?php

if(!is_admin()) return;
if($pagenow !== 'admin.php') return;
if(empty(get_option('embed_cache_delete'))) return;

$all_cache = $wpdb->prepare("
  DELETE FROM $wpdb->postmeta
  WHERE meta_key LIKE %s
", '_oembed_%' );

$unknown_cache = $wpdb->prepare("
  DELETE FROM $wpdb->postmeta
  WHERE meta_key LIKE %s
  AND meta_value = %s
", '_oembed_%', '{{unknown}}' );

$ogp_cache = $wpdb->prepare("
  DELETE FROM $wpdb->options
  WHERE option_name LIKE %s
  OR option_value LIKE %s
", '_transient_ogp_cache_4536_%', '_transient_timeout_ogp_cache_4536_%' );

//埋め込みコンテンツのキャッシュ削除
if(isset($_POST['embed_cache_delete_submit_4536'])) {
  if( get_option('embed_cache_delete') === 'all' ) {
    $wpdb->query($all_cache);
    $wpdb->query($ogp_cache);
  } elseif( get_option('embed_cache_delete') === 'unknown' ) {
    $wpdb->query($unknown_cache);
  } elseif( get_option('embed_cache_delete') === 'ogp' ) {
    $wpdb->query($ogp_cache);
  }
}
