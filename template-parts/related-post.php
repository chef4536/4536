<?php

if(empty(related_post_count())) return;

// $post_list_style_mobile = (related_post_list_style_mobile()==='') ? '' : ' list-'.related_post_list_style_mobile();
// $post_list_style_pc = '';
// if( !empty( related_post_list_style_pc() ) ) {
//   $post_list_style_pc = ' list-'.related_post_list_style_pc();
// }
// $style = $post_list_style_mobile.$post_list_style_pc;
//
// $thumbnail_size = related_post_list_style_pc();
// if(related_post_list_style_mobile()==='big') $thumbnail_size = 'big';

$categories = get_the_category($post->ID);
$category_ID = [];
foreach($categories as $category) {
    $category_ID[] = $category->cat_ID;
}

$args = [
    'post__not_in' => [get_the_ID()],
    'posts_per_page'=> related_post_count(),
    'category__in' => $category_ID,
    'orderby' => 'relevance',
];
$related_posts = get_posts($args);

if(!$related_posts) return;

?>

<aside id="related-post">
  <h2 data-text-align="center" class="mb-3 headline">関連記事</h2>
  <div class="d-f f-w-w j-c-c">
    <?php
    foreach( $related_posts as $post ) : setup_postdata( $post );
    post_list_card_4536('h3');
    endforeach;
    wp_reset_postdata();
    ?>
  </div>
</aside>
