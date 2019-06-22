<?php
if(is_amp()) {
    ob_start();
    dynamic_sidebar('amp-fixed-footer');
    $amp_fixed_footer = ob_get_clean();
} else {
    ob_start();
    dynamic_sidebar('fixed-footer');
    $fixed_footer = ob_get_clean();
}

if( fixed_footer()==='menu' ) { ?>
    <div id="fixed-footer-menu" class="fixed-footer d-n-md d-f t-a-c">
        <?php
        $list = [
            'home',
            'search',
            'share',
            'slide-menu',
            'top',
            'prev',
            'next',
        ];
        $true = next_prev_in_same_term();
        foreach ($list as $name) {
          $class = '';
          $title = '';
          if(fixed_footer_menu_item($name) === true) {
            if($name === 'home') {
                if( is_home() || is_front_page() ) continue;
                $start_tag = '<a class="fixed-footer-menu-item d-b" href="'.home_url().'">';
                $end_tag = '</a>';
                $icon = 'home';
                $title = 'ホーム';
            } elseif($name === 'search') {
                if(is_amp() && !is_ssl()) continue;
                $start_tag = '<label class="fixed-footer-menu-item d-b" for="search-toggle">';
                $end_tag = '</label>';
                $icon = 'search';
                $title = '検索';
                $class = ' search-button';
            } elseif($name === 'share') {
                $start_tag = '<label class="fixed-footer-menu-item d-b" for="share-menu-toggle">';
                $end_tag = '</label>';
                $icon = 'share-alt';
                $title = 'シェア';
                $class = ' fixed-share-toggle-button';
            } elseif( $name === 'slide-menu' && is_slide_menu() ) {
                $start_tag = '<label class="fixed-footer-menu-item d-b" for="slide-toggle">';
                $end_tag = '</label>';
                $icon = 'bars';
                $class = ' slide-button';
                $title = 'メニュー';
            } elseif($name === 'top') {
                $start_tag = '<a id="fixed-page-top-button" class="fixed-footer-menu-item d-b" href="#header">';
                $end_tag = '</a>';
                $icon = 'angle-double-up';
                $class = ' fixed-page-top';
                $title = 'トップ';
            } elseif($name === 'prev') {
                if( !get_previous_post($true) || !is_single() ) continue;
                $start_tag = '<a class="fixed-footer-menu-item d-b" href="'.get_permalink(get_previous_post($true)->ID).'">';
                $end_tag = '</a>';
                $icon = 'angle-double-left';
                $title = '前の記事';
            } elseif($name === 'next') {
                if( !get_next_post($true) || !is_single() ) continue;
                $start_tag = '<a class="fixed-footer-menu-item d-b" href="'.get_permalink(get_next_post($true)->ID).'">';
                $end_tag = '</a>';
                $icon = 'angle-double-right';
                $title = '次の記事';
            } else {
              continue;
            }
          } else {
            continue;
          } ?>
          <div class="flex<?php echo $class; ?>">
              <?php echo $start_tag; ?>
              <i class="fas fa-<?php echo $icon; ?> font-size-22px" aria-hidden="true"></i>
              <span class="d-b fixed-footer-menu-title font-size-10px"><?php echo $title; ?></span>
              <?php echo $end_tag; ?>
          </div>
        <?php } ?>
    </div>
<?php } elseif( fixed_footer()==='overlay' && !empty($fixed_footer) ) { ?>
    <div id="fixed-footer-overlay" class="fixed-footer d-n t-a-c">
        <?php echo $fixed_footer; ?>
        <div class="close-button fixed-footer-close-button"><i class="fas fa-times"></i></div>
    </div>
<?php } elseif( fixed_footer()==='overlay' && !empty($amp_fixed_footer) ) { ?>
    <amp-sticky-ad layout="nodisplay">
        <?php echo $amp_fixed_footer; ?>
    </amp-sticky-ad>
<?php }
