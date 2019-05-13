<?php /* Template Name: すべてのカテゴリ */
get_header(); ?>
<div id="contents-wrapper">
  <div id="contents-inner">
    <main id="main" class="padding-wrap-main-4536 post-bg-color post-color" role="main">
      <article id="all-categories" class="post">
        <header>
          <h1 id="h1"><?php the_title(); ?></h1>
          <?php if( !get_post_meta( $post->ID, 'none_post_thumbnail', true ) ) the_post_thumbnail_4536(); ?>
        </header>
        <div class="article-body">
          <?php
          $args = [
            'title_li' => null,
            'echo' => false,
            'show_count' => true,
          ];
          echo '<ul>' . wp_list_categories( $args ) . '</ul>';
          ?>
        </div>
      </article>
    </main>
    <?php
    get_template_part( 'template-parts/music' );
    get_template_part( 'template-parts/movie' );
    get_template_part( 'template-parts/pickup' );
    ?>
  </div>
</div>
<?php get_sidebar().get_footer();
