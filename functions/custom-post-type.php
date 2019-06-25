<?php
add_action('init', function () {
    $main_post_type = esc_html(get_option('main_media_slug'));
    $admin_main_media = esc_html(get_option('admin_main_media'));
    $sub_post_type = esc_html(get_option('sub_media_slug'));
    $admin_sub_media = esc_html(get_option('admin_sub_media'));
    // ミュージック
    if (!empty($admin_main_media)) {
        register_post_type('music', [
      'labels' => [
        'name' => __($admin_main_media),
        'singular_name' => __($admin_main_media),
        'all_items' => __($admin_main_media.' 一覧')
      ],
      'public' => true,
      'show_in_rest' => true,
      'has_archive' => true,
      'rewrite' => [
        'slug' => $main_post_type
      ],
      'menu_position' => 5,
      'supports' => [
        'title',
        'editor',
        'thumbnail',
        'revisions',
        'comments',
        'author',
      ],
    ]);
    }
    // ムービー
    if ($admin_sub_media) {
        register_post_type('movie', [
      'labels' => [
        'name' => __($admin_sub_media),
        'singular_name' => __($admin_sub_media),
        'all_items' => __($admin_sub_media.' 一覧')
      ],
      'public' => true,
      'show_in_rest' => true,
      'has_archive' => true,
      'rewrite' => [
        'slug' => $sub_post_type
      ],
      'menu_position' => 5,
      'supports' => [
        'title',
        'editor',
        'thumbnail',
        'revisions',
        'comments',
        'author',
      ],
    ]);
    }
});

function media_section_4536($media, $args = [])
{
    global $post;
    $args = [
    'post_type' => $media,
    'posts_per_page' => -1,
    'post__not_in' => [$post->ID],
  ];
    switch ($media) {
    case 'music':
      $is_media = get_option('admin_main_media');
      $section_title = get_option('main_media_name');
      break;
    case 'movie':
      $is_media = get_option('admin_sub_media');
      $section_title = get_option('sub_media_name');
      break;
    case 'pickup':
      $args['post_type'] = 'post';
      $is_media = $section_title = $args['tag'] = 'Pickup';
      break;
  }
  if (empty($is_media)) {
      return;
  }
  $customPosts = get_posts($args);
  if (empty($customPosts)) {
      return;
  }

  if( $media==='pickup' ) { ?>
    <div id="pickup" class="pt-5">
      <p data-text-align="center" class="headline mt-5 mb-3">Pickup</p>
      <div data-display="flex" data-flex-wrap="wrap">
        <?php
        foreach ($customPosts as $post) : setup_postdata($post);
        post_list_card_4536();
        endforeach;
        wp_reset_postdata();
        ?>
      </div>
    </div>
  <?php } else { ?>
    <div id="<?php echo $media ?>" class="gradation mt-5 mb-5">
      <?php wave_shape('media_top'); ?>
      <div class="pa-4">
        <p class="headline t-a-c mt-5 mb-3"><?php echo esc_html($section_title); ?></p>
        <div data-text-align="center" class="scroll-wrapper">
          <!-- <div class="scroll-left"> -->
            <div data-display="inline-block" class="scroll-content container">
              <?php foreach ($customPosts as $post) : setup_postdata($post); ?>
                <div data-display="inline-block" data-text-align="left" class="p-r music-content">
                  <?php echo thumbnail_4536($media)['thumbnail']; ?>
                  <span data-display="block" class="mt-2"></span>
                  <a class="link-mask mt-2" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </div>
              <?php endforeach; ?>
              <?php wp_reset_postdata(); ?>
            </div>
          <!-- </div> -->
          <div class="leftbutton d-n"><i class="fas fa-angle-left"></i></div><div class="rightbutton d-n"><i class="fas fa-angle-right"></i></div>
        </div>
      </div>
      <?php wave_shape('media_bottom'); ?>
    </div>
  <?php }

}
