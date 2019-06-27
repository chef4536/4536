<?php

$tag = ( is_home() ) ? 'h1' : 'p' ;
$start_tag = '<'.$tag.' id="sitename" class="title ma-0" itemscope itemtype="http://schema.org/Organization" itemprop="publisher">';
$end_tag = '</'.$tag.'>';

if( has_header_image() ) { ?>
  <div id="header-image" class="w-100 ma-auto">
    <?php echo $start_tag; ?>
      <a href="<?php echo home_url(); ?>/">
        <?php
        $img = '<img src="'.get_header_image().'" alt="'.get_bloginfo('name').'" width="'.get_custom_header()->width.'" height="'.get_custom_header()->height.'">';
        echo ( is_amp() ) ? convert_content_to_amp( $img ) : $img ;
        ?>
      </a>
    <?php echo $end_tag; ?>
  </div>
<?php } else {
  if(header_logo_url()) {
    $site_name = header_logo_4536();
  } elseif(site_title()) {
    $site_name = site_title();
  } else {
    $site_name = get_bloginfo('name');
  } ?>
  <div data-position="relative" data-display="flex" data-align-items="center" class="container w-100 ma-auto pa-3">
    <div class="title flex">
      <?php echo $start_tag.'<a href="'.home_url().'">'.$site_name.'</a>'.$end_tag; ?>
    </div>
    <div class="flex xs0"></div>
    <?php
    //slidemenu
    if( is_slide_menu() ) { ?>
      <label data-display="none-md" id="header-slide-button" for="slide-toggle">
        <svg id="header-slide-icon" class="header-slide-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="<?php echo get_theme_mod( 'post_color', '#333333' ); ?>"><path d="M0 0h24v24H0z" fill="none" /><path d="M6 10c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm12 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm-6 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
      </label>
    <?php }
    if(has_nav_menu('header_nav')) {
      $defaults = [
        'theme_location'  => 'header_nav',
        'container' => false,
        'fallback_cb' => false,
        'echo' => true,
        'items_wrap' => '<ul data-text-align="center" data-display="flex" data-flex-wrap="nowrap" class="scroll-content">%3$s</ul>'
      ];
      ?>
      <nav id="header-nav" class="scroll-container xs12 sm12 max-w-100" itemscope itemtype="http://schema.org/SiteNavigationElement" role="navigation">
        <?php wp_nav_menu($defaults); ?>
      </nav>
    <?php } ?>
  </div>
<?php }
