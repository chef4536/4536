<?php

if( is_singular() ) {
  $layout = layout('layout_singular');
  $custom_layout = get_post_meta($post->ID,'singular_layout_select',true);
  if( !empty( $custom_layout ) ) $layout = $custom_layout;
} elseif( is_archive() ) {
  $layout = layout( 'layout_archive' );
} else {
  $layout = layout( 'layout_home' );
}

if( $layout === 'center-content' ) return;

$my_sidebar = my_sidebar();
$sidebar = $my_sidebar['sidebar'];
$scroll_sidebar = $my_sidebar['scroll_sidebar'];

if( empty($sidebar) && empty($scroll_sidebar) ) return;

if( !has_header_image() || ( fixed_footer()==='menu' && fixed_footer_menu_item( 'slide-menu' ) ) ) {
  $is_slide_menu = true;
} else {
  $is_slide_menu = false;
}

?>
<div id="sidebar">
  <?php if( $is_slide_menu ) { ?>
    <input id="slide-toggle" type="checkbox" class="display-none">
    <label id="slide-mask" for="slide-toggle" class="display-none mask"></label>
    <div id="slide-menu">
      <label for="slide-toggle" class="close-button display-none-pc slide-widget-close-button"><i class="fas fa-times"></i>CLOSE</label>
  <?php } ?>
    <?php if( !empty($amp_sidebar) || !empty($sidebar) ) { ?>
    <aside class="sidebar-inner" role="complementary">
      <?php
      if( is_amp() && !empty(is_amp_sidebar_top()) ) echo amp_adsense_code();
      if( !empty($amp_sidebar) ) echo $amp_sidebar;
      if( !empty($sidebar) ) echo $sidebar;
      ?>
    </aside>
    <?php }
    if( !empty($scroll_sidebar) ) { ?>
    <aside id="scroll-sidebar" class="sidebar-inner" role="complementary">
      <?php echo $scroll_sidebar; ?>
    </aside>
    <?php }
  if( $is_slide_menu ) echo '</div>';
  ?>
</div>
