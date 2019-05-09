<?php

if( layout_4536() === 'center-content' ) return;

$my_sidebar = my_sidebar();
$sidebar = $my_sidebar['sidebar'];
$scroll_sidebar = $my_sidebar['scroll_sidebar'];

if( empty($sidebar) && empty($scroll_sidebar) ) return;

if( !has_header_image() || ( fixed_footer()==='menu' && fixed_footer_menu_item( 'slide-menu' ) ) ) {
  $is_slide_menu = true;
  $class = '';
} else {
  $is_slide_menu = false;
  $class = ' margin-top-1_5em';
}

?>
<div id="sidebar" class="padding-0-10px<?php echo $class; ?>">
  <?php
  if( $is_slide_menu ) { ?>
    <input id="slide-toggle" type="checkbox" class="display-none">
    <label id="slide-mask" for="slide-toggle" class="display-none mask"></label>
    <div id="slide-menu">
      <label for="slide-toggle" class="close-button display-none-pc slide-widget-close-button"><i class="fas fa-times"></i>CLOSE</label>
  <?php }
  if( is_amp() && is_amp_sidebar_top() ) echo amp_adsense_code();
  if( !empty($sidebar) ) echo '<aside class="sidebar-inner" role="complementary">' . $sidebar . '</aside>';
  if( !empty($scroll_sidebar) ) echo '<aside id="scroll-sidebar" class="sidebar-inner" role="complementary">' . $scroll_sidebar . '</aside>';
  if( $is_slide_menu ) echo '</div>';
  ?>
</div>
