<?php get_header(); ?>
  <div id="contents-wrapper" class="w-100 max-w-100">
    <main id="main" class="w-100 post-bg-color post-color" role="main">
      <?php media_section_4536('music'); ?>
      <div id="new-post" class="d-f clearfix padding-wrap-main-4536">
        <?php post_list_template_4536('new-post'); ?>
      </div>
      <?php
      pagination($wp_query->max_num_pages);
      media_section_4536('movie');
      media_section_4536('pickup');
      ?>
    </main>
  </div>
<?php
get_sidebar();
get_footer();
