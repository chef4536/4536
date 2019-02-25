<?php /* Template Name: 検索結果 */

get_header(); ?>

<div id="contents-wrapper">
    <div id="contents-inner">
        <main id="main" class="padding-wrap-main-4536" role="main">
            <h1 id="post-h1"><?php the_title(); ?></h1>
            <?php echo google_custom_search_result(); ?>
        </main>
        <?php
        get_template_part('template-parts/music');
        get_template_part('template-parts/movie');
        get_template_part('template-parts/pickup');
        ?>
    </div>
</div>

<?php
get_sidebar();
get_footer();
