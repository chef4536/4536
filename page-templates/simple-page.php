<?php /* Template Name: シンプルなデザイン */
get_header(); ?>
<div id="contents-wrapper" class="w-100 max-w-100">
  <main id="main" class="w-100" role="main">
    <article class="post">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <h1 id="h1" class="headline" class="post-title"><?php the_title(); ?></h1>
      <?php the_post_thumbnail_4536(); ?>
      <div class="article-body">
        <?php the_content(); ?>
      </div>
      <?php endwhile; endif; ?>
    </article>
  </main>
</div>
<?php get_sidebar().get_footer();
