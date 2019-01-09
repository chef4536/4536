<?php $args = array(
    'numberposts' => 3,
    'post_type' => 'post',
    'orderby' => 'rand',
    'tag' => 'pickup-post-bottom',
    'post__not_in' => [$post->ID]
);
$pickupPosts2 = get_posts($args);
if($pickupPosts2) : ?>

<div id="pickup-post-bottom">
<?php foreach($pickupPosts2 as $post) : setup_postdata( $post ); ?>
<p class="pickup-text-link">
<span><?php echo pickup_text_post_bottom(); ?></span>
<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
</p>
<?php endforeach; ?>
<?php wp_reset_postdata(); ?>
</div>

<?php endif; ?>