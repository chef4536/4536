<?php /* Template Name: すべてのカテゴリ */
get_header(); ?>
<div id="contents-wrapper" class="w-100 max-w-100">
  <main id="main" class="w-100" role="main">
    <article id="all-categories" class="post">
      <header>
        <h1 id="h1" class="headline"><?php the_title(); ?></h1>
        <?php if (!get_post_meta($post->ID, 'none_post_thumbnail', true)) {
    the_post_thumbnail_4536();
} ?>
      </header>
      <div class="article-body">
        <?php
        $args = [
          'title_li' => null,
          'echo' => false,
          'show_count' => true,
        ];
        echo '<ul>' . wp_list_categories($args) . '</ul>';
        ?>
      </div>
    </article>
  </main>
</div>
<?php get_sidebar().get_footer();
