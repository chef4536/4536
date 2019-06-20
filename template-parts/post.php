<?php

if( is_singular('post') ) {
  $is_profile = is_profile_4536('profile_single');
  $is_sns_top = is_sns_top_4536('is_sns_top_single');
  $is_sns_bottom = is_sns_bottom_4536('is_sns_bottom_single');
} elseif( is_page() ) {
  $is_profile = is_profile_4536('profile_page');
  $is_sns_top = is_sns_top_4536('is_sns_top_page');
  $is_sns_bottom = is_sns_bottom_4536('is_sns_bottom_page');
} elseif( is_singular(['music', 'movie']) ) {
  $is_profile = is_profile_4536('profile_media');
  $is_sns_top = is_sns_top_4536('is_sns_top_media');
  $is_sns_bottom = is_sns_bottom_4536('is_sns_bottom_media');
} else {
  $is_profile = false;
  $is_sns_top = false;
  $is_sns_bottom = false;
}

if( have_posts() ) : while ( have_posts() ) : the_post();

echo '<article class="post article-body">';

$content = apply_filters( 'the_content', get_the_content() );
$content = str_replace( ']]>', ']]&gt;', $content );
if(is_amp() && empty($content)) {
    echo '<p>'.auto_description_4536().'</p>'.
        '<div class="to-mobile-page button-4536 background-color-orange">'.
        '<a class="color-white-4536" href="'.get_the_permalink().'">続きを読む</a></div>';
} else {
    the_content();
    wp_link_pages();
}

echo '</article>';

if( is_amp() && is_amp_post_bottom() ) echo amp_adsense_code();

//記事下広告枠
if(is_amp()) {
  if(is_active_sidebar('amp-post-ad')) $ad = 'amp-post-ad';
} else {
  if(is_active_sidebar('ad')) $ad = 'ad';
}
if( isset( $ad ) && !empty( $ad ) ) dynamic_sidebar( $ad );

$term = [];
if( has_category() && is_single() ) {
  $categories = get_the_category();
  if( !empty($categories) ) {
    foreach( $categories as $category ) {
      $term[] = '<a class="post-category post-term" href="' . get_category_link( $category->term_id ) . '"><i class="far fa-folder"></i>' . $category->cat_name . '</a>';
    }
  }
}
if( has_tag() ) {
  $tags = get_the_tags();
  if( !empty($tags) ) {
    foreach( $tags as $tag ) {
      $term[] = '<a class="post-tag post-term" href="' . get_tag_link( $tag->term_id ) . '"><i class="fas fa-hashtag"></i>' . $tag->name . '</a>';
    }
  }
}

if( !empty($term) ) {
  $term = implode( '', $term );
  echo '<div id="post-term-section" class="margin-2em-auto">' . $term . '</div>';
}

if( $is_sns_bottom === true ) sns_button_4536('post_bottom');
if( $is_profile === true ) get_template_part('template-parts/profile');

endwhile; else:

echo '<p>記事がありません</p>';

endif;

wp_reset_postdata();
