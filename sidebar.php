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

if( is_amp() ) {
  ob_start();
  dynamic_sidebar( 'amp-sidebar' );
  $amp_sidebar = ob_get_clean();
} else {
  ob_start();
  dynamic_sidebar( 'sidebar' );
  $sidebar = ob_get_clean();
  ob_start();
  dynamic_sidebar( 'scroll-sidebar' );
  $scroll_sidebar = ob_get_clean();
}

if( $amp_sidebar || $sidebar || $scroll_sidebar ) { ?>
    <div id="sidebar">
        <?php if( !empty($amp_sidebar) || !empty($sidebar) ) { ?>
        <aside class="sidebar-inner" role="complementary">
            <?php
            if(is_amp() && !empty(is_amp_sidebar_top())) echo amp_adsense_code();
            if(!empty($amp_sidebar)) echo $amp_sidebar;
            if(!empty($sidebar)) echo $sidebar;
            ?>
        </aside>
        <?php }
        if(!empty($scroll_sidebar)) { ?>
        <aside id="scroll-sidebar" class="sidebar-inner" role="complementary">
            <?php echo $scroll_sidebar; ?>
        </aside>
        <?php } ?>
    </div>
<?php }
