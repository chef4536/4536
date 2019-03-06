<?php

$redirect_settings = redirect_post_in_category_settings();
$rewrite_array = [];

for ($i=0; $i < redirect_count(); $i++) {
	$rewrite_cond = [];
	$site_url = $redirect_settings['redirect_url'][$i];
	if( empty($site_url) ) $site_url = false;
	$cat_id_array = $redirect_settings['cat_id'][$i];
	$cat_id = ( is_array($cat_id_array) ) ? implode( ',', $cat_id_array ) : false;
	if ( $site_url===false || $cat_id===false ) continue;
	$args = [
		'posts_per_page' => -1,
		'category' => $cat_id,
	];
	$posts_array = get_posts( $args );
	foreach ( $posts_array as $post_info ) {
	  $slug = $post_info->post_name;
	  $rewrite_cond[] = 'RewriteCond %{REQUEST_URI} ./'.$slug.'/?$ [OR]';
	}
	$rewrite_cond = implode( PHP_EOL, $rewrite_cond );
	$rewrite_cond = rtrim( $rewrite_cond, ' [OR]' );
	$rewrite_cond = $rewrite_cond.PHP_EOL.'RewriteCond %{REQUEST_URI} !(/category/.)';
	$rewrite_cond = $rewrite_cond.PHP_EOL.'RewriteCond %{REQUEST_URI} !(/tag/.)';
	$site_url = rtrim( $site_url, '/' ) . '/';
	$rewrite = $rewrite_cond.PHP_EOL.'RewriteRule ([^/]+?)/?$ '.$site_url.'\$1 [R=302,L]';
	$rewrite = '#setting_no_'.$i.'_begin'.PHP_EOL.$rewrite.PHP_EOL.'#setting_no_'.$i.'_end';
	$rewrite_array[] = $rewrite;
}

if ( empty($rewrite_array) ) {
	return;
} else {
	update_option( 'is_enable_redirect_post_in_category', '1' );
}

$rewrite = implode( PHP_EOL, $rewrite_array );

// var_dump($rewrite);

$text = <<< EOM
#4536RedirectPostInCategoryBegin
<IfModule mod_rewrite.c>
RewriteEngine On
{$rewrite}
</IfModule>
#4536RedirectPostInCategoryEnd
EOM;

echo $text;
