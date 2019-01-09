<?php /* Template Name: すべてのカテゴリ */
get_header(); ?>
<div id="contents-wrapper">
    <div id="contents-inner">
        <main id="main" class="padding-wrap-main-4536" role="main">
            <h1 id="post-h1"><?php the_title(); ?></h1>
            <div class="all-categories post article-body">
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
        get_template_part('page-templates/music');
        get_template_part('page-templates/movie');
        get_template_part('page-templates/pickup');
        ?>
    </div>
</div>
<?php get_sidebar().get_footer();