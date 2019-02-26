<?php get_header(); ?>
<div id="contents-wrapper">
    <div id="contents-inner">
        <main id="main" class="padding-wrap-main-4536 post-bg-color post-color" role="main">
            <?php get_template_part('template-parts/post'); ?>
            <aside role="complementary">
                <?php
                if(is_amp()) {
                    if(is_active_sidebar('amp-post-bottom')) dynamic_sidebar('amp-post-bottom');
                } else {
                    if(is_active_sidebar('post-bottom')) dynamic_sidebar('post-bottom');
                }
                if(is_singular('post')) {
                    get_template_part('template-parts/related-post');
                    if(is_comments('is_comments_single') && (comments_open() || get_comments_number())) comments_template();
                    get_template_part('template-parts/page-nav');
                } elseif(is_singular(['music', 'movie'])) {
                    if(is_comments('is_comments_media') && (comments_open() || get_comments_number())) comments_template();
                } elseif(is_page()) {
                    if(is_comments('is_comments_page') && (comments_open() || get_comments_number())) comments_template();
                }
                get_template_part('template-parts/follow-box');
                ?>
            </aside>
        </main>
        <?php
        if(is_singular('movie')) {
            get_template_part('template-parts/movie');
            get_template_part('template-parts/music');
        } else {
            get_template_part('template-parts/music');
            get_template_part('template-parts/movie');
        }
        get_template_part('template-parts/pickup');
        ?>
    </div>
</div>
<?php
get_sidebar();
get_footer();
