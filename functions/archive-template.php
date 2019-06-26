<?php

function archive_template_4536($page_4536) { ?>
  <div id="contents-wrapper" class="w-100 max-w-100">
    <main id="main" class="w-100" role="main">
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
          if ($page_4536!=='new') {
              echo '<h1 id="h1" data-text-align="center" class="mb-4">' . $title . '</h1>';
          }
          ?>
          <div class="archive-wrap d-f f-w-w j-c-c">
              <?php post_list_template_4536($page_4536); ?>
          </div>
      </section>
      <?php
      pagination($wp_query->max_num_pages);
      // echo breadcrumb('html');
      ?>
    </main>
  </div>
<?php }

function post_list_template_4536($page_4536)
{
    // $thumbnail_size = $page_4536;
    //
    // if ($page_4536 === 'new-post') {
    //     $post_list_style_mobile = new_post_list_style_mobile();
    //     $post_list_style_pc = new_post_list_style_pc();
    //     $thumbnail_size = new_post_list_style_pc();
    //     if (new_post_list_style_mobile() === 'big') {
    //         $thumbnail_size = 'big';
    //     }
    // } else {
    //     $post_list_style_mobile = archive_post_list_style_mobile();
    //     $post_list_style_pc = archive_post_list_style_pc();
    //     $thumbnail_size = archive_post_list_style_pc();
    //     if (archive_post_list_style_mobile() === 'big') {
    //         $thumbnail_size = 'big';
    //     }
    // }

    // if (!empty($post_list_style_mobile)) {
    //     $post_list_style_mobile = ' list-'.$post_list_style_mobile;
    // }
    // if (!empty($post_list_style_pc)) {
    //     $post_list_style_pc = ' list-'.$post_list_style_pc;
    // }
    // $style = $post_list_style_mobile.$post_list_style_pc;

    $count = '';
    $rand = rand(4, 9);

    if (have_posts()) : while (have_posts()) : the_post(); $count++;
      post_list_card_4536(); //記事一覧
      if ($count===$rand && $page_4536==='new-post' && is_active_sidebar('sp-infeed-ad')) { //インフィード広告?>
          <div class="post-list clearfix infeed-ad d-b padding-bottom-1em <?php echo $style; ?>">
              <?php dynamic_sidebar('sp-infeed-ad'); ?>
          </div>
      <?php }
    endwhile; else:
      echo '<p>記事がありませんでした。</p>';
    endif;
    wp_reset_postdata();
}

function post_list_card_4536( $title_tag = 'h2' )
{ ?>
  <article class="xs12 sm12 md6 p-r pa-2 card-wrap">
    <div data-display="flex" data-position="relative" data-flex-direction="column" class="card h-100">
      <?php echo thumbnail_4536($thumbnail_size)['thumbnail']; ?>
      <div class="card-content flex pl-3 pr-3 pt-4 pb-4">
        <?php if (is_home()) {
    $cat = get_the_category();
    $cat_name = $cat[0]->name;
    $cat_slug = $cat[0]->slug;
    $cat_link = esc_url(get_category_link($cat[0]->cat_ID)); ?>
          <div class="z-index-1 d-f a-i-c meta mb-3 j-c-c">
            <a class="post-color <?php echo $cat_slug; ?>" title="<?php echo $cat_name; ?>" href="<?php echo $cat_link; ?>"><?php echo $cat_name; ?></a>
          </div>
        <?php }
        echo '<' . $title_tag . ' class="card-title title">'; ?>
          <a class="post-color link-mask" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        <?php echo '</' . $title_tag . ' >'; ?>
      </div>
      <div class="flex"></div>
      <div data-display="flex" data-align-items="center" class="card-meta pa-3">
        <div class="meta">
          <span><?php the_date() ?></span>
        </div>
        <div class="flex"></div>
        <a data-button="submit" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">もっと見る</a>
      </div>
    </div>
  </article>
<?php }
