<?php /* Template Name: シンプルなデザイン */
get_header(); ?>

<div id="contents-wrapper">
    <div id="contents-inner">
        <main id="main" class="padding-wrap-main-4536 post-bg-color post-color" role="main">
            <article class="post">
                <?php if( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <h1 id="post-h1"><?php the_title(); ?></h1>
                <?php the_post_thumbnail_4536(); //アイキャッチ ?>
                <div class="article-body" itemprop="articleBody">
                    <?php
                    the_content();
                    wp_link_pages();
                    ?>
                </div>
                <?php endwhile; endif; ?>
            </article>
        </main>

    </div>
</div>
<?php get_sidebar().get_footer();
