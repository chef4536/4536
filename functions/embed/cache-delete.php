<?php

if(!is_admin()) return;
if($pagenow !== 'admin.php') return;
if(empty(get_option('embed_cache_delete'))) return;

if(get_option('embed_cache_delete') === 'all') {
  $data = $wpdb->prepare("
    DELETE FROM $wpdb->postmeta
    WHERE meta_key LIKE %s
  ", '_oembed_%' );
} elseif(get_option('embed_cache_delete') === 'unknown') {
  $data = $wpdb->prepare("
    DELETE FROM $wpdb->postmeta
    WHERE meta_key LIKE %s
    AND meta_value = %s
  ", '_oembed_%', '{{unknown}}' );
}

//埋め込みコンテンツのキャッシュ削除
if(isset($_POST['admin_database_setting_submit_4536'])) $wpdb->query($data);
