<?php /* Template Name: すべてのカテゴリ */
get_header(); ?>
<div id="contents-wrapper" class="w-100 max-w-100 pa-4">
  <main id="main" class="w-100" role="main">
    <article id="all-categories" class="post">
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
