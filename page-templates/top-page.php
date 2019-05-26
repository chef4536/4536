<?php get_header(); ?>
    <div id="contents-wrapper">
        <div id="contents-inner">
            <main id="main" class="post-bg-color post-color" role="main">
                <?php media_section_4536( 'music' ); ?>
                <div id="new-post" class="flexbox-row-wrap clearfix padding-wrap-main-4536">
                    <?php post_list_template_4536('new-post'); ?>
                </div>
                <?php
                pagination($wp_query->max_num_pages);
                media_section_4536( 'movie' );
                media_section_4536( 'pickup' );
                ?>
            </main>
        </div>
    </div>
<?php
get_sidebar();
get_footer();
