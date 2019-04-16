<?php get_header(); ?>
    <div id="contents-wrapper" class="flex-1">
        <div id="contents-inner">
            <main id="main" class="post-bg-color post-color" role="main">
                <?php get_template_part('template-parts/music'); ?>
                <div id="new-post" class="flexbox-row-wrap clearfix padding-wrap-main-4536">
                    <?php post_list_template_4536('new-post'); ?>
                </div>
                <?php
                pagination($wp_query->max_num_pages);
                get_template_part('template-parts/movie');
                get_template_part('template-parts/pickup');
                ?>
            </main>
        </div>
    </div>
<?php
get_sidebar();
get_footer();
