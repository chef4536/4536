<?php /* Template Name: すべてのカテゴリと記事（HTMLサイトマップ） */
get_header(); ?>
<div id="contents-wrapper">
  <div id="contents-inner">
    <main id="main" class="padding-wrap-main-4536 post-bg-color post-color" role="main">
      <article id="html-sitemap" class="post">
        <header>
          <h1 id="h1"><?php the_title(); ?></h1>
          <?php if( !get_post_meta( $post->ID, 'none_post_thumbnail', true ) ) the_post_thumbnail_4536(); ?>
        </header>
        <div class="article-body">
          <?php
          $is_thumbnail = get_post_meta( $post->ID, 'html_sitemap_thumbnail', true );
          $exclude_cat_id_arr = get_post_meta( $post->ID, 'html_sitemap_exclude_cat_id', true );
          if( !empty( $exclude_cat_id_arr ) ) {
            $exclude_categories_id = '&exclude_tree=' . implode( ',', $exclude_cat_id_arr );
          } else {
            $exclude_cat_id_arr = [];
            $exclude_categories_id = '';
          }
          $exclude_post_id = get_post_meta( $post->ID, 'html_sitemap_exclude_post_id', true );
          echo apply_filters( 'the_content', $post->post_content );
        	$categories = get_categories( 'parent=0' . $exclude_categories_id );
        	foreach( $categories as $category ) {
            echo '<section>';
            $cat_id = $category->cat_ID;
        		echo '<a href="' . get_category_link( $cat_id ) . '"><h2>' . $category->name . '</h2></a>';
            $thumbnail_arr = get_posts( 'post_type=post&posts_per_page=1&category=' . $cat_id );
            if( has_post_thumbnail( $post_id = $thumbnail_arr[0]->ID ) && $is_thumbnail === '1' ) {
              echo '<figure class="alignwide margin-bottom-1_5em text-align-center">' . get_the_post_thumbnail( $post_id, $thumbnail, [ 'class' => 'category_thumbnail' ] ) . '</figure>';
            }
            $child_cat_arr = get_terms([ 'taxonomy'=>'category', 'parent'=>$cat_id ]);
            $exclude_cat_id = '';
            foreach( $child_cat_arr as $child_cat ) {
              $exclude_cat_id .= ',-' . $child_cat->term_id;
            }
            $post_arr = get_posts([
              'post_type' => 'post',
              'posts_per_page' => -1,
              'category' => [ $cat_id . $exclude_cat_id ],
              'exclude' => [ $exclude_post_id ],
            ]);
            foreach( $post_arr as $post ) {
              echo '<article class="post-list line-height-1_4"><a class="display-block padding-bottom-1em" href="' . get_the_permalink( $post->ID ) . '"><i class="far fa-file-alt"></i>' . $post->post_title . '</a></article>';
            }
            the_child_sitemap_4536( $cat_id, 2, $exclude_cat_id_arr, $exclude_post_id );
            echo '</section>';
        	}

          function the_child_sitemap_4536( $cat_id, $i, $exclude_cat_id_arr = [], $exclude_post_id = null ) {
            $child_cat_arr = get_terms([ 'taxonomy'=>'category', 'parent'=>$cat_id ]);
            if( !empty( $child_cat_arr ) ) {
              $i++;
              if( $i > 6 ) $i = 6;
              foreach( $child_cat_arr as $child_cat ) {
                $child_cat_id = $child_cat->term_id;
                if( in_array( (string)$child_cat_id, $exclude_cat_id_arr, true ) ) continue;
                echo '<section class="children">';
                echo '<a href="' . get_category_link( $child_cat_id ) . '"><h' . $i . '>' . $child_cat->name . '</h' . $i . '></a>';
                $exclude_cat_id = '';
                $exclude_cat_arr = get_terms([ 'taxonomy'=>'category', 'parent'=>$child_cat_id ]);
                foreach( $exclude_cat_arr as $obj ) {
                  $exclude_cat_id .= ',-' . $obj->term_id;
                }
                $post_arr = get_posts([
                  'post_type' => 'post',
                  'posts_per_page' => -1,
                  'category' => [ $child_cat_id . $exclude_cat_id ],
                  'exclude' => [ $exclude_post_id ],
                ]);
                foreach( $post_arr as $post ) {
                  echo '<article class="post-list line-height-1_4"><a class="display-block padding-bottom-1em" href="' . get_the_permalink( $post->ID ) . '"><i class="far fa-file-alt"></i>' . $post->post_title . '</a></article>';
                }
                the_child_sitemap_4536( $child_cat_id, $i, $exclude_cat_id_arr, $exclude_post_id );
                echo '</section>';
              }
            }
          }

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
