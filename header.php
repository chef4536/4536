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
        } ?>


        <svg class="d-b w-100 h-100 p-r l-0" version="1.1" viewbox="0 0 1200 200" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <filter x="0" y="0" width="100%" height="100%" filterUnits="objectBoundingBox" id="header-outer-4536">
              <feOffset dx="0" dy="-6" in="SourceAlpha" result="shadowOffsetOuter" />
              <feGaussianBlur stdDeviation="0" in="shadowOffsetOuter" result="shadowBlurOuter" />
              <feColorMatrix values="0 0 0 0 0   0 0 0 0 0   0 0 0 0 0  0 0 0 0.056 0" in="shadowBlurOuter" type="matrix" result="shadowMatrixOuter" />
              <feMerge>
                <feMergeNode in="shadowMatrixOuter" />
                <feMergeNode in="SourceGraphic" />
              </feMerge>
            </filter>
          </defs>
          <?php
          $bg_color = ($bg_color = get_background_color()) ? '#' . get_background_color() : '#fcfcfc';
          ?>
          <path d="M0,200 C0,200 300,0 720,100 C1100,180 1200,50 1200,50 L0,0 L0,200 L0,0 L1200,50 L1200,200 L0,200 Z" fill="<?php echo $bg_color; ?>" filter="url(#header-outer-4536)" />
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
