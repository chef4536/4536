<?php

$redirect_settings = redirect_post_in_category_settings();
$rewrite_rule_array = [];

for ($i=0; $i < redirect_count(); $i++) {
	$rewrite_rule = [];
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
	  $site_url = rtrim( $site_url, '/' );
	  $rewrite_rule[] = 'RewriteRule ^(.*)/'.$slug.' '.$site_url.'/$1/'.$slug.' [R=301,L]';
	}
	$rewrite_rule = implode( PHP_EOL, $rewrite_rule );
	$rewrite_rule = '#setting_no_'.$i.'_begin'.PHP_EOL.$rewrite_rule.PHP_EOL.'#setting_no_'.$i.'_end';
	$rewrite_rule_array[] = $rewrite_rule;
}

if ( empty($rewrite_rule_array) ) {
	return;
} else {
	update_option( 'is_enable_redirect_post_in_category', '1' );
}

$rewrite_rule = implode( PHP_EOL, $rewrite_rule_array );

// var_dump($rewrite_rule);

$text = <<< EOM
#4536RedirectPostInCategoryBegin
<IfModule mod_rewrite.c>
RewriteEngine On
{$rewrite_rule}
</IfModule>
#4536RedirectPostInCategoryEnd
EOM;

echo $text;
