<?php

if(empty(related_post_count())) return;

$display = 'display-none-mobile';
$post_list_style_mobile = (related_post_list_style_mobile()==='') ? '' : ' list-'.related_post_list_style_mobile();
$post_list_style_pc = '';
if( !empty( related_post_list_style_pc() ) ) {
  $post_list_style_pc = ' list-'.related_post_list_style_pc();
  $display = 'display-none';
}
$style = $post_list_style_mobile.$post_list_style_pc;

$thumbnail_size = related_post_list_style_pc();
if(related_post_list_style_mobile()==='big') $thumbnail_size = 'big';

$categories = get_the_category($post->ID);
$category_ID = [];
foreach($categories as $category) {
    $category_ID[] = $category->cat_ID;
}

if(line_clamp()=='2line') $line_clamp = ' line-clamp-2';
if(line_clamp()=='3line') $line_clamp = ' line-clamp-3';
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
  <h2 id="related-post-title" class="position-relative">関連記事</h2>
  <div class="related-post-wrap flexbox-row-wrap">
    <?php foreach( $related_posts as $post ) : setup_postdata( $post ) ; ?>
    <article class="position-relative z-index-1 clearfix padding-bottom-1em post-list<?php echo $style; ?>">
      <?php echo thumbnail_4536($thumbnail_size)['thumbnail']; ?>
      <div class="post-info">
        <h3 class="post-title<?php echo $line_clamp; ?>">
          <a class="post-color link-mask" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
          </a>
        </h3>
        <div class="post-meta position-relative z-index--1">
          <p class="excerpt <?php echo $display; ?>">
            <?php echo custom_excerpt_4536(get_the_content(), custom_excerpt_length()); ?>
          </p>
        </div>
      </div>
    </article>
    <?php endforeach ?>
  </div>
</aside>

<?php wp_reset_postdata();
