<!DOCTYPE html>
<!--
Theme Name: 4536
Theme URI: https://4536.jp
-->
<?php
if(is_amp()) {
    get_template_part('lib/head-setting-amp');
} else {
    get_template_part('lib/head-setting');
}
?>
<body <?php body_class(); ?>>

    <?php

    if(is_amp()) {
        if(!empty(amp_add_html_js_body())) echo amp_add_html_js_body();
        get_template_part('lib/google-analytics');
    }

    if(fixed_header() && !has_header_image()) $header_class = ' fixed-header';

    if(has_header_image()) {
        $header_image_start_tag = '<div id="header-image">';
        $header_image_end_tag = '</div>';
    }
    if(!is_singular('lp')) { //ランディングページ以外
        echo '<header id="header" class="header'.$header_class.'" itemscope itemtype="http://schema.org/WPHeader" role="banner">'.$header_image_start_tag;
        get_template_part('page-templates/header-menu');
        echo $header_image_end_tag.'</header>';

        //navigation
        $display = '';
        $location = '';
        if(has_nav_menu('navbar')) {
          $location = 'navbar';
          $display = ' display-none-pc';
        };
        if(has_nav_menu('below_header_nav_menu_common')) $location = 'below_header_nav_menu_common';
        if(!empty($location)) {
            $defaults = [
                'theme_location'  => $location,
                'container' => false,
                'fallback_cb' => false,
                'echo' => true,
                'items_wrap' => '<ul class="scroll-content">%3$s</ul>'
            ];
            $button = (is_amp()) ? '' : '<div class="leftbutton display-none"><i class="fas fa-angle-left"></i></div><div class="rightbutton display-none"><i class="fas fa-angle-right"></i></div>';
            ?>
            <nav id="below-header-nav-menu" class="nav-menu icon text-align-center<?php echo $display; ?>" itemscope itemtype="http://schema.org/SiteNavigationElement" role="navigation">
                <div class="scroll-wrapper inner padding-0-10px">
                    <div class="scroll-left">
                        <?php
                        wp_nav_menu($defaults);
                        echo $button;
                        ?>
                    </div>
                </div>
            </nav>
        <?php }

        if(is_amp()) {
            dynamic_sidebar('amp-header');
            if(is_amp_header()) echo '<div class="amp-adsense-header padding-0-10px margin-1em-auto">'.amp_adsense_code_top().'</div>';
        } else {
            dynamic_sidebar('header-widget');
        }

        if ( (is_home() || is_front_page()) && !is_paged() && is_home_description() ) { //ディスクリプション ?>
            <div id="top-description">
                <div class="inner padding-0-10px">
                <p><?php bloginfo('description'); ?></p>
                </div>
            </div>
        <?php }

        breadcrumb();

    }
    ?>

    <div id="wrapper" class="wrapper">
