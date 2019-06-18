<?php /* Template Name: 検索結果 */

get_header(); ?>

<div id="contents-wrapper" class="w-100 m-w-100">
    <div id="contents-inner">
        <main id="main" class="w-100 post-bg-color post-color" role="main">
            <h1 id="h1"><?php the_title(); ?></h1>
            <?php echo google_custom_search_result(); ?>
        </main>
        <?php
        media_section_4536( 'music' );
        media_section_4536( 'movie' );
        media_section_4536( 'pickup' );
        ?>
    </div>
</div>

<?php
get_sidebar();
get_footer();
