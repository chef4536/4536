<?php
$args = [
    'post_type' => 'movie',
    'posts_per_page'=> -1,
    'post__not_in' => [$post->ID]
];
$media_name = esc_html(get_option('sub_media_name'));
$is_media = esc_html(get_option('admin_sub_media'));
$customPosts = get_posts($args);
if(!$customPosts || !$is_media) return; ?>

<div id="movie" class="clearfix padding-wrap-main-4536 media-section">
    <p class="media-section-title"><?php echo $media_name; ?></p>
    <div class="scroll-wrapper">
        <div class="scroll-left">
            <div class="scroll-content">
                <?php foreach($customPosts as $post) : setup_postdata( $post ); ?>
                    <div class="media-content movie-content">
                        <a class="clearfix" title="<?php the_title();?>" href="<?php the_permalink();?>">
                        <?php echo thumbnail_4536('movie')['thumbnail']; ?>
                        <div class="post-info">
                        <p class="media-content-title"><?php the_title(); ?></p>
                        </div>
                        </a>
                    </div>
                <?php endforeach; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
        <div class="leftbutton display-none"><i class="fas fa-angle-left"></i></div><div class="rightbutton display-none"><i class="fas fa-angle-right"></i></div>
    </div>
</div>