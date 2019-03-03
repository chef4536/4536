<?php

$cat_ids = get_option( 'redirect_cat_id' );
if ( empty( $cat_ids ) ) return;
$cat_id = implode( ',', $cat_ids );
$args = [
	'posts_per_page' => 5,
	'category' => $cat_id,
];
$posts_array = get_posts( $args );
foreach ( $posts_array as $post_info ) {
  $slug = $post_info->post_name;
  $site_url = esc_url('exsample.com');
  $site_url = rtrim( $site_url, '/' );
  $rewrite_rule[] = 'RewriteRule ^(.*)/'.$slug.' '.$site_url.'/$1/'.$slug.' [R=301,L]';
}
$rewrite_rule = implode( PHP_EOL, $rewrite_rule );

// var_dump($rewrite_rule);

$text = <<< EOM
#4536RedirectPostInCategoryBegin
<IfModule mod_rewrite.c>
RewriteEngine On
{$rewrite_rule}
</IfModule>
#4536RedirectPostInCategoryEnd
EOM;
