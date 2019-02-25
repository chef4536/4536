<?php

if(is_home()) {
    $start_tag = '<h1 id="sitename" itemscope itemtype="http://schema.org/Organization" itemprop="publisher">';
    $end_tag = "</h1>";
} else {
    $start_tag = '<p id="sitename" itemscope itemtype="http://schema.org/Organization" itemprop="publisher">';
    $end_tag = "</p>";
}

if(is_amp()) {
    $img_start_tag = '<amp-img layout="responsive" ';
    $img_end_tag = '</amp-img>';
} else {
    $img_start_tag = '<img ';
    $img_end_tag = '';
}

if(has_header_image()) {
    echo $start_tag; ?>
        <a href="<?php echo home_url(); ?>/">
            <?php echo $img_start_tag; ?>src="<?php header_image(); ?>" alt="<?php bloginfo('name');?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>"><?php echo $img_end_tag; ?>
        </a>
    <?php echo $end_tag;
} else {
    
    if(header_logo_url()) {
        $site_name = header_logo_4536();
    } elseif(site_title()) {
        $site_name = site_title();
    } else {
        $site_name = get_bloginfo('name');
    }
    
    ?>
    <div class="inner display-flex align-items-center padding-10px clearfix">
        <div class="header-contents header-title flex-1">
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
            <div class="display-none-mobile">
                <nav id="pc-nav-menu" class="nav-menu icon" itemscope itemtype="http://schema.org/SiteNavigationElement" role="navigation">
                    <?php wp_nav_menu($defaults); ?>
                </nav>
            </div>
        <?php }
        if( (!is_amp() && is_active_sidebar('slide-widget')) || (is_amp() && is_active_sidebar('amp-slide-menu')) ) { ?>
        <label id="header-slide-button" for="slide-toggle" class="header-contents slide-button display-none-pc">
            <i class="fas fa-bars" aria-hidden="true"></i>
        </label>
        <?php } ?>
    </div>
<?php }
