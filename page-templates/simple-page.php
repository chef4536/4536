<?php /* Template Name: シンプルなデザイン */
get_header(); ?>
<div id="contents-wrapper">
  <div id="contents-inner">
    <main id="main" class="padding-wrap-main-4536 post-bg-color post-color" role="main">
      <article class="post">
        <?php if( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <h1 class="post-title"><?php the_title(); ?></h1>
        <?php the_post_thumbnail_4536(); ?>
        <div class="article-body">
          <?php the_content(); ?>
        </div>
        <?php endwhile; endif; ?>
      </article>
    </main>
  </div>
</div>
<?php get_sidebar().get_footer();
