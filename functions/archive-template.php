<?php

function archive_template_4536($page_4536) { ?>
  <div id="contents-wrapper" class="w-100 max-w-100">
    <?php
    if ($page_4536==='new') {
        media_section_4536('music');
    } ?>
    <main id="main" class="w-100 post-bg-color post-color" role="main">
      <section id="archive-section">
          <?php
          if (is_category()||is_tag()||is_tax()) {
              $title = single_term_title("", false);
          }
          if (is_day()) {
              $title = get_the_time('Y年m月d日');
          }
          if (is_month()) {
              $title = get_the_time('Y年m月');
          }
          if (is_year()) {
              $title = get_the_time('Y年');
          }
          if (is_author()) {
              $title = esc_html(get_queried_object()->display_name);
          }
          if (isset($_GET['paged']) && !empty($_GET['paged'])) {
              $title = 'ブログアーカイブ';
          }
          $title = '「'.$title.'」の記事一覧';
          global $s;
          global $wp_query;
          if (is_search()) {
              $title = '「'.esc_html($s).'」の検索結果 '.$wp_query->found_posts.' 件';
          }
          if ($page_4536==='movie') {
              $title = '「'.esc_html(get_option('sub_media_name')).'」一覧';
          }
          if ($page_4536==='music') {
              $title = '「'.esc_html(get_option('main_media_name')).'」一覧';
          }
          if ($page_4536==='new') {
              echo '<h2 class="headline">最新記事</h2>';
          } else {
              echo '<h1 id="h1" class="headline">' . $title . '</h1>';
          }
          ?>
          <div class="archive-wrap d-f f-w-w j-c-c pl-3 pr-3">
              <?php post_list_template_4536($page_4536); ?>
          </div>
      </section>
      <?php
      pagination($wp_query->max_num_pages);
      echo breadcrumb('html');
      ?>
    </main>
    <?php
    if ($page_4536!=='music' && $page_4536!=='new') {
        media_section_4536('music');
    }
    if ($page_4536!=='movie') {
        media_section_4536('movie');
    }
    if (!is_tag('pickup')) {
        media_section_4536('pickup');
    }
    ?>
  </div>
<?php }

function post_list_template_4536($page_4536)
{
    $thumbnail_size = $page_4536;

    if ($page_4536 === 'new-post') {
        $post_list_style_mobile = new_post_list_style_mobile();
        $post_list_style_pc = new_post_list_style_pc();
        $thumbnail_size = new_post_list_style_pc();
        if (new_post_list_style_mobile() === 'big') {
            $thumbnail_size = 'big';
        }
    } else {
        $post_list_style_mobile = archive_post_list_style_mobile();
        $post_list_style_pc = archive_post_list_style_pc();
        $thumbnail_size = archive_post_list_style_pc();
        if (archive_post_list_style_mobile() === 'big') {
            $thumbnail_size = 'big';
        }
    }

    if (!empty($post_list_style_mobile)) {
        $post_list_style_mobile = ' list-'.$post_list_style_mobile;
    }
    if (!empty($post_list_style_pc)) {
        $post_list_style_pc = ' list-'.$post_list_style_pc;
    }
    $style = $post_list_style_mobile.$post_list_style_pc;

    $count = '';
    $rand = rand(4, 9);

    if (have_posts()) : while (have_posts()) : the_post(); $count++; ?>
        <article class="pa-3 md6 p-r pb-3 post-list<?php echo $style; ?>">
          <div class="card h-100 f-d-c d-f p-r">
            <?php echo thumbnail_4536($thumbnail_size)['thumbnail']; ?>
            <div class="card-content flex pl-3 pr-3 pt-4 pb-4">
              <div class="meta mb-3 t-a-c">
                <span><?php the_date() ?></span>
              </div>
              <h2 class="card-title title">
                <a class="post-color" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              </h2>
            </div>
            <div class="card-meta a-i-c d-f pa-3">
              <?php
              $cat = get_the_category();
              $cat_name = $cat[0]->name;
              $cat_slug = $cat[0]->slug;
              $cat_link = esc_url ( get_category_link($cat[0]->cat_ID) );
              if (is_home()) { ?>
                  <div class="flex">
                    <i class="fas fa-tag"></i>
                    <a class="post-color <?php echo $cat_slug; ?>" title="<?php echo $cat_name; ?>" href="<?php echo $cat_link; ?>">
                      <?php echo $cat_name; ?>
                    </a>
                  </div>
              <?php }
              ?>
              <a data-button="submit" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">もっと見る</a>
            </div>
          </div>
        </article>
        <?php
        if ($count===$rand && $page_4536==='new-post' && is_active_sidebar('sp-infeed-ad')) { //インフィード広告?>
            <div class="post-list clearfix infeed-ad d-b padding-bottom-1em <?php echo $style; ?>">
                <?php dynamic_sidebar('sp-infeed-ad'); ?>
            </div>
        <?php }
    endwhile; else:
        echo '<p class="padding-0-1em margin-1em-0">記事がありませんでした。</p>';
    endif;
    wp_reset_postdata();
}
