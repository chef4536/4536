<?php

// var_dump(is_slide_menu());

if( layout_4536() === 'center-content' ) return;

$my_sidebar = my_sidebar();
$sidebar = $my_sidebar['sidebar'];
$scroll_sidebar = $my_sidebar['scroll_sidebar'];

if( empty($sidebar) && empty($scroll_sidebar) ) return;

$is_slide_menu = is_slide_menu();

?>
<div id="sidebar" class="pt-5 pb-5 pr-4 pl-4">
  <?php
  if( $is_slide_menu ) { ?>
    <input id="slide-toggle" type="checkbox" class="d-n">
    <label id="slide-mask" for="slide-toggle" class="d-n mask"></label>
    <div id="slide-menu">
      <label for="slide-toggle" class="close-button d-n-md slide-widget-close-button"><i class="fas fa-times"></i>CLOSE</label>
  <?php }
  if( is_amp() && is_amp_sidebar_top() ) echo amp_adsense_code();
  if( !empty($sidebar) ) echo '<aside class="sidebar-inner" role="complementary">' . $sidebar . '</aside>';
  if( !empty($scroll_sidebar) ) echo '<aside id="scroll-sidebar" class="sidebar-inner" role="complementary">' . $scroll_sidebar . '</aside>';
  if( $is_slide_menu ) echo '</div>';
  ?>
</div>
