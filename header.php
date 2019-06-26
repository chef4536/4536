<!DOCTYPE html>
<!--
Theme Name: 4536
Theme URI: https://4536.jp
-->
<?php
if (is_amp()) {
    get_template_part('template-parts/head-setting-amp');
} else {
    get_template_part('template-parts/head-setting');
}
?>
<body <?php body_class(); ?>>
  <div id="main-column" class="flex">

    <?php

    if (is_amp()) {
        if (!empty(amp_add_html_js_body())) {
            echo amp_add_html_js_body();
        }
        get_template_part('template-parts/google-analytics');
    }

    $header_class = (fixed_header() && !has_header_image()) ? ' fixed-header' : '';

    if (!none_header_footer()) { ?>

      <div id="site-top" class="gradation">
        <header id="header" class="header header-section<?php echo $header_class; ?>" itemscope itemtype="http://schema.org/WPHeader" role="banner">
          <?php get_template_part('template-parts/header-menu'); ?>
        </header>
        <?php

        //SVG
        wave_shape('header');

        ?>

      </div>

      <?php
      if (is_amp()) {
          dynamic_sidebar('amp-header');
          if (is_amp_header()) {
              echo amp_adsense_code('horizon');
          }
      } else {
          dynamic_sidebar('header-widget');
      }

      if ((is_home() || is_front_page()) && !is_paged() && is_home_description()) { //ディスクリプション?>
        <!-- <div id="top-description">
          <div class="w-100 ma-auto py-0 px-3">
            <p><?php bloginfo('description'); ?></p>
          </div>
        </div> -->
      <?php }

    }

    if (is_singular()) {
        get_template_part('template-parts/post-title');
    } else {
      media_section_4536('music');
    }

    ?>

    <div id="main-container" class="container w-100 ma-auto d-f f-w-w body-bg-color post-color">
