<?php get_header(); ?>
    <div id="contents-wrapper">
        <div id="contents-inner">
            <main id="main" role="main">
                <?php get_template_part('page-templates/music'); ?>
                <div id="new-post" class="flexbox-row-wrap clearfix padding-wrap-main-4536">
                    <?php post_list_template_4536('new-post'); ?>
                </div>
                <?php
                pagination($wp_query->max_num_pages);
                get_template_part('page-templates/movie');
                get_template_part('page-templates/pickup');
                ?>
            </main>
        </div>
    </div>
<?php
get_sidebar();
get_footer();