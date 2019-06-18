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
  <div class="inner p-r w-100 ma-auto d-f a-i-c pa-3">
    <div class="header-contents header-title f-1">
      <?php echo $start_tag.'<a href="'.home_url().'">'.$site_name.'</a>'.$end_tag; ?>
    </div>
    <?php
    if(has_nav_menu('navbar_pc')) {
      $defaults = [
        'theme_location'  => 'navbar_pc',
        'container' => false,
        'fallback_cb' => false,
        'echo' => true,
        'items_wrap' => '<ul>%3$s</ul>'
      ];
      ?>
      <div class="d-n-mobile">
        <nav id="pc-nav-menu" class="nav-menu icon" itemscope itemtype="http://schema.org/SiteNavigationElement" role="navigation">
          <?php wp_nav_menu($defaults); ?>
        </nav>
      </div>
    <?php }
    if( is_slide_menu() ) { ?>
      <label id="header-slide-button" for="slide-toggle" class="f-button header-contents slide-button d-n-pc t-a-c">
        <i class="fas fa-ellipsis-h"></i>
      </label>
    <?php } ?>
  </div>
<?php }
