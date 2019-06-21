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
        //navigation
        $location = '';
        if (has_nav_menu('navbar')) {
            $location = 'navbar';
            $display = ' d-n-md';
        };
        if (has_nav_menu('below_header_nav_menu_common')) {
            $location = 'below_header_nav_menu_common';
            $display = '';
        }
        if (!empty($location)) {
            $defaults = [
            'theme_location'  => $location,
            'container' => false,
            'fallback_cb' => false,
            'echo' => true,
            'items_wrap' => '<ul class="scroll-content d-t w-100">%3$s</ul>'
          ];
            $button = (is_amp()) ? '' : '<div class="leftbutton d-n"><i class="fas fa-angle-left"></i></div><div class="rightbutton d-n"><i class="fas fa-angle-right"></i></div>'; ?>
          <nav id="below-header-nav-menu" class="nav-menu header-section icon t-a-c<?php echo $display; ?>" itemscope itemtype="http://schema.org/SiteNavigationElement" role="navigation">
            <div class="scroll-wrapper inner p-r w-100 ma-auto pa-3">
              <div class="scroll-left">
                <?php
                wp_nav_menu($defaults);
            echo $button; ?>
              </div>
            </div>
          </nav>
        <?php
        }

        //////////////////////////////////////////////
        ///////////////// SVG ///////////////////////
        //////////////////////////////////////////////

        $bg_color = ($bg_color = get_background_color()) ? '#' . get_background_color() : '#fcfcfc';
        $primary_color = '#4facfe';
        $secandary_color = '#00f2fe';
        ?>

        <svg class="d-b w-100 h-100 p-r l-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 200">
          <defs>
            <linearGradient id="g1" gradientUnits="userSpaceOnUse">
              <stop offset="0" stop-color="<?php echo $primary_color; ?>" stop-opacity=".1" />
              <stop offset=".8" stop-color="<?php echo $bg_color; ?>" stop-opacity=".3" />
              <stop offset="1" stop-color="<?php echo $secandary_color; ?>" stop-opacity=".5" />
            </linearGradient>
            <linearGradient id="g2" gradientUnits="userSpaceOnUse">
              <stop offset="0" stop-color="<?php echo $secandary_color; ?>" stop-opacity=".1" />
              <stop offset=".8" stop-color="<?php echo $bg_color; ?>" stop-opacity=".3" />
              <stop offset="1" stop-color="<?php echo $secandary_color; ?>" stop-opacity=".5" />
            </linearGradient>
          </defs>
          <path d="M0,200S300,0,720,100c380,80,480-50,480-50L0,0V0L1200,50V200Z" fill="url(#g1)" />
          <path d="M0,200C331.42,-10,530.66,59.45,654,108c10.65,4.19,205.3,81.3,342,54,73.39-14.66,132-52,132-52a370,370,0,0,0,72-60L0,0V0L1200,50V200Z" fill="url(#g2)" />
          <path d="M0,200C225.9,89.57,392.93,88.5,507,111c93.31,18.4,238.49,69.79,421,72,45,.54,118.86-1.6,189-48,41.63-27.54,67.77-61.39,83-85L0,0V0L1200,50V200Z" fill="<?php echo $bg_color; ?>" />
        </svg>

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
        <div id="top-description">
          <div class="w-100 ma-auto py-0 px-3">
            <p><?php bloginfo('description'); ?></p>
          </div>
        </div>
      <?php }

    }

    if (is_singular()) {
        get_template_part('template-parts/post-title');
    }

    ?>

    <div id="container" class="container w-100 ma-auto d-f f-w-w">
