<?php

if(empty(related_post_count())) return;

$post_list_style_mobile = (related_post_list_style_mobile()==='') ? '' : ' list-'.related_post_list_style_mobile();
$post_list_style_pc = (related_post_list_style_pc()==='') ? ' post-list-pc' : ' list-'.related_post_list_style_pc();
if($post_list_style_mobile===$post_list_style_pc) $post_list_style_pc = '';
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

<div id="related-post">
    <h3 id="related-post-title">関連記事</h3>
    <div class="related-post-wrap flexbox-row-wrap">
        <?php foreach($related_posts as $post) : setup_postdata( $post ) ; ?>
        <div class="post-list<?php echo $style; ?>">
            <a class="clearfix post-color" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
            <?php echo thumbnail_4536($thumbnail_size)['thumbnail']; ?>
                <div class="post-info">
                    <p class="post-title<?php echo $line_clamp; ?>"><?php the_title(); ?></p>
                    <div class="post-meta">
                        <p class="excerpt display-none">
                            <?php echo custom_excerpt_4536(get_the_content(), custom_excerpt_length()); ?>
                        </p>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach ?>
    </div>
</div>

<?php wp_reset_postdata();
