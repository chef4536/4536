<?php
$args = [
  'post_type' => 'post',
  'tag' => 'pickup',
  'posts_per_page'=> -1,
  'post__not_in' => [$post->ID],
];
$pickupPosts = get_posts( $args );
if( empty( $pickupPosts ) ) return;
$thumbnail_style = '';
?>

<section id="pickup" class="clearfix padding-wrap-main-4536 media-section">
    <h2 class="media-section-title">Pickup</h2>
    <div class="scroll-wrapper">
        <div class="scroll-left">
            <div class="scroll-content">
                <?php foreach($pickupPosts as $post) : setup_postdata( $post ); ?>
                <article class="media-content pickup-content">
                    <a class="clearfix" title="<?php the_title();?>" href="<?php the_permalink();?>">
                    <?php echo thumbnail_4536('pickup')['thumbnail']; ?>
                    <div class="post-info">
                    <h3 class="media-content-title"><?php the_title(); ?></h3>
                    </div>
                    </a>
                </article>
                <?php
                endforeach;
                wp_reset_postdata(); ?>
            </div>
        </div>
        <div class="leftbutton display-none"><i class="fas fa-angle-left"></i></div><div class="rightbutton display-none"><i class="fas fa-angle-right"></i></div>
    </div>
</section>
