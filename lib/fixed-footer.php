<?php
if(is_singular('lp')) return;
if(fixed_footer()==='menu') { ?>
    <div id="fixed-footer-menu" class="fixed-footer display-none-pc display-flex text-align-center">
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
                    if(is_home()) continue;
                    $start_tag = '<a href="'.home_url().'">';
                    $end_tag = '</a>';
                    $icon = 'home';
                    $title = 'ホーム';
                } elseif($name === 'search') {
                    if(is_amp() && !is_ssl()) continue;
                    $start_tag = '<label for="search-toggle">';
                    $end_tag = '</label>';
                    $icon = 'search';
                    $title = '検索';
                    $class = ' search-button';
                } elseif($name === 'share') {
                    $start_tag = '<label for="share-menu-toggle">';
                    $end_tag = '</label>';
                    $icon = 'share-alt';
                    $title = 'シェア';
                    $class = ' fixed-share-toggle-button';
                } elseif($name === 'slide-menu') {
                    $start_tag = '<label for="slide-toggle">';
                    $end_tag = '</label>';
                    $icon = 'bars';
                    $class = ' slide-button';
                    $title = 'メニュー';
                } elseif($name === 'top') {
                    $start_tag = '<a id="fixed-page-top-button" href="#header">';
                    $end_tag = '</a>';
                    $icon = 'angle-double-up';
                    $class = ' fixed-page-top';
                    $title = 'トップ';
                } elseif($name === 'prev') {
                    if( !get_previous_post($true) || !is_single() ) continue;
                    $start_tag = '<a href="'.get_permalink(get_previous_post($true)->ID).'">';
                    $end_tag = '</a>';
                    $icon = 'angle-double-left';
                    $title = '前の記事';
                } elseif($name === 'next') {
                    if( !get_next_post($true) || !is_single() ) continue;
                    $start_tag = '<a href="'.get_permalink(get_next_post($true)->ID).'">';
                    $end_tag = '</a>';
                    $icon = 'angle-double-right';
                    $title = '次の記事';
                } else {
                    continue;
                }
            } else {
              continue;
            } ?>
            <div class="fixed-footer-menu-item flex-1<?php echo $class; ?>">
                <?php echo $start_tag; ?>
                <i class="fas fa-<?php echo $icon; ?>" aria-hidden="true"></i>
                <span class="fixed-footer-menu-title"><?php echo $title; ?></span>
                <?php echo $end_tag; ?>
            </div>
        <?php } ?>
    </div>
<?php } elseif(fixed_footer()=='overlay' && is_active_sidebar('fixed-footer') && !is_amp()) { ?>
    <div id="fixed-footer-overlay" class="fixed-footer display-none text-align-center">
        <?php dynamic_sidebar('fixed-footer'); ?>
        <div class="close-button fixed-footer-close-button"><i class="fas fa-times"></i></div>
    </div>
<?php } elseif(fixed_footer()=='overlay' && is_active_sidebar('amp-fixed-footer') && is_amp()) { ?>
    <amp-sticky-ad layout="nodisplay">
        <?php dynamic_sidebar('amp-fixed-footer'); ?>
    </amp-sticky-ad>
<?php }
