<?php /* Template Name: すべてのカテゴリと記事（HTMLサイトマップ） */
get_header(); ?>
<div id="contents-wrapper">
  <div id="contents-inner">
    <main id="main" class="padding-wrap-main-4536 post-bg-color post-color" role="main">
      <h1 id="h1"><?php the_title(); ?></h1>
      <div id="html-sitemap" class="post article-body">
        <?php
      	$categories = get_categories( 'parent=0' );
        echo '<ul>';
      	foreach( $categories as $category ) {
          $cat_id = $category->cat_ID;
      		echo '<li>';
      		echo '<a href="' . get_category_link( $cat_id ) . '">' . $category->name . '</a>';
          the_child_sitemap_4536( $cat_id );
      		echo '</li>';
      	}
        echo '</ul>';

        function the_child_sitemap_4536( $cat_id ) {
          $child_cat_id_arr = get_terms([ 'taxonomy'=>'category', 'parent'=>$cat_id ]);
          if( !empty( $child_cat_id_arr ) ) {
            if( empty( get_ancestors( $cat_id, 'category' ) ) ) echo '<ul class="children">';
            foreach( $child_cat_id_arr as $child_cat ) {
              $child_cat_id = $child_cat->term_id;
              echo '<li>';
              echo '<a href="' . get_category_link( $child_cat_id ) . '">' . $child_cat->name . '</a>';
              $exclude_cat_id = '';
              $exclude_cat_id_arr = get_terms([ 'taxonomy'=>'category', 'parent'=>$child_cat_id ]);
              foreach( $exclude_cat_id_arr as $obj ) {
                $exclude_cat_id .= ',-' . $obj->term_id;
              }
              $post_arr = get_posts( 'post_type=post&posts_per_page=-1&cat=' . $child_cat_id . $exclude_cat_id );
              echo '<ul class="children">';
              foreach( $post_arr as $post ) {
                echo '<li><a href="' . get_the_permalink( $post->ID ) . '">' . $post->post_title . '</a></li>';
              }
              the_child_sitemap_4536( $child_cat_id );
              echo '</ul>';
              echo '</li>';
            }
            if( empty( get_ancestors( $cat_id, 'category' ) ) ) echo '</ul>';
          }
        }

        ?>
      </div>
    </main>
    <?php
    get_template_part( 'template-parts/music' );
    get_template_part( 'template-parts/movie' );
    get_template_part( 'template-parts/pickup' );
    ?>
  </div>
</div>
<?php get_sidebar().get_footer();
