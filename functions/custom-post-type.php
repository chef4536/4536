<?php
add_action( 'init', function() {
  $main_post_type = esc_html( get_option('main_media_slug') );
  $admin_main_media = esc_html( get_option('admin_main_media') );
  $sub_post_type = esc_html( get_option('sub_media_slug') );
  $admin_sub_media = esc_html( get_option('admin_sub_media') );
  // ミュージック
  if( !empty( $admin_main_media ) ) {
    register_post_type( 'music' , [
      'labels' => [
        'name' => __( $admin_main_media ),
        'singular_name' => __( $admin_main_media ),
        'all_items' => __( $admin_main_media.' 一覧' )
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
  if($admin_sub_media) {
    register_post_type( 'movie', [
      'labels' => [
        'name' => __( $admin_sub_media ),
        'singular_name' => __( $admin_sub_media ),
        'all_items' => __( $admin_sub_media.' 一覧' )
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

function media_section_4536( $media, $args = [] ) {
  global $post;
  $args = [
    'post_type' => $media,
    'posts_per_page' => -1,
    'post__not_in' => [$post->ID],
  ];
  switch( $media ) {
    case 'music':
      $is_media = get_option( 'admin_main_media' );
      $section_title = get_option( 'main_media_name' );
      break;
    case 'movie':
      $is_media = get_option( 'admin_sub_media' );
      $section_title = get_option( 'sub_media_name' );
      break;
    case 'pickup':
      $args['post_type'] = 'post';
      $is_media = $section_title = $args['tag'] = 'Pickup';
      break;
  }
  if( empty( $is_media ) ) return;
  $customPosts = get_posts( $args );
  if( empty( $customPosts ) ) return;
  ?>
  <div id="<?php echo $media ?>" class="clearfix padding-wrap-main-4536 media-section">
    <p class="media-section-title"><?php echo esc_html( $section_title ); ?></p>
    <div class="scroll-wrapper">
      <div class="scroll-left">
        <div class="scroll-content d-t w-100">
          <?php foreach( $customPosts as $post ) : setup_postdata( $post ); ?>
            <div class="media-content clearfix <?php echo $media; ?>-content p-r">
              <?php echo thumbnail_4536( $media )['thumbnail']; ?>
              <div class="post-info">
                <a class="media-content-title link-mask" title="<?php the_title();?>" href="<?php the_permalink();?>">
                  <?php the_title(); ?>
                </a>
              </div>
            </div>
          <?php endforeach; ?>
          <?php wp_reset_postdata(); ?>
        </div>
      </div>
      <div class="leftbutton d-n"><i class="fas fa-angle-left"></i></div><div class="rightbutton d-n"><i class="fas fa-angle-right"></i></div>
    </div>
  </div>
<?php }
