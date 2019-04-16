<?php /* Template Name: すべてのカテゴリ */
get_header(); ?>
<div id="contents-wrapper">
    <div id="contents-inner">
        <main id="main" class="padding-wrap-main-4536 post-bg-color post-color" role="main">
            <h1 id="post-h1"><?php the_title(); ?></h1>
            <div id="all-categories" class="post article-body">
                <?php
                $args = [
                    'title_li' => null,
                    'echo' => false,
                    'show_count' => true,
                ];
                echo '<ul>'.wp_list_categories($args).'</ul>';
                ?>
            </div>
        </main>
        <?php
        get_template_part('template-parts/music');
        get_template_part('template-parts/movie');
        get_template_part('template-parts/pickup');
        ?>
    </div>
</div>
<?php get_sidebar().get_footer();
