<?php get_header(); ?>
<div id="contents-wrapper" class="w-100 max-w-100">
  <div id="contents-inner">
    <main id="main" class="w-100 post-bg-color post-color" role="main">
      <?php get_template_part('template-parts/post');
      if(is_amp()) {
        if(is_active_sidebar('amp-post-bottom')) dynamic_sidebar('amp-post-bottom');
      } else {
        if(is_active_sidebar('post-bottom')) dynamic_sidebar('post-bottom');
      }
      if(is_singular('post')) {
        get_template_part('template-parts/related-post');
        if(is_comments('is_comments_single') && (comments_open() || get_comments_number())) comments_template();
        get_template_part('template-parts/page-nav');
        echo breadcrumb( 'html' );
      } elseif(is_singular(['music', 'movie'])) {
          if(is_comments('is_comments_media') && (comments_open() || get_comments_number())) comments_template();
      } elseif(is_page()) {
          if(is_comments('is_comments_page') && (comments_open() || get_comments_number())) comments_template();
      }
      get_template_part('template-parts/follow-box');
      ?>
    </main>
    <?php
    if( is_singular( 'movie' ) ) {
      media_section_4536( 'movie' );
      media_section_4536( 'music' );
    } else {
      media_section_4536( 'music' );
      media_section_4536( 'movie' );
    }
    media_section_4536( 'pickup' );
    ?>
  </div>
</div>
<?php
get_sidebar();
get_footer();
