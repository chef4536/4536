<?php

function sns_button_4536($position) {

    if(is_amp() || is_singular()) {
        $url = esc_url(get_permalink());
        $title = esc_html(get_the_title());
        $custom = get_post_custom();
        if(!empty($custom['sns_title'][0])) $title = esc_html($custom['sns_title'][0]);
    } else {
        $http = is_ssl() ? 'https://' : 'http://';
        $url = esc_url($http . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        $title = esc_html(wp_get_document_title());
    }

    $via = (twitter_via() && get_the_author_meta('twitter')) ? '&via='.get_the_author_meta('twitter') : '';

    if(function_exists('scc_get_share_twitter') && scc_get_share_twitter()!==0) {
        $twitter_count = '<span class="sns-count">'.scc_get_share_twitter().'</span>';
    }
    if(function_exists('scc_get_share_facebook') && scc_get_share_facebook()!==0) {
        $facebook_count = '<span class="sns-count">'.scc_get_share_facebook().'</span>';
    }
    if(function_exists('scc_get_share_hatebu') && scc_get_share_hatebu()!==0) {
        $hatebu_count = '<span class="sns-count">'.scc_get_share_hatebu().'</span>';
    }
    if(function_exists('scc_get_share_pocket') && scc_get_share_pocket()!==0) {
        $pocket_count = '<span class="sns-count">'.scc_get_share_pocket().'</span>';
    }

    if(!sns_style()) {
        $sns_class = 'default-sns-button colorful-sns-button f-1';
    } elseif(sns_style()==='simple1') {
        $sns_class = 'simple-sns-button colorful-sns-button';
    } elseif(sns_style()==='simple2') {
        $sns_class = 'simple-sns-button simple-sns-button-2';
    } elseif(sns_style()==='rich') {
        $sns_class = 'simple-sns-button colorful-sns-button rich-sns-button f-1';
    }

    if( $position === 'fixed_footer_share_button' ) $sns_class = 'simple-sns-button colorful-sns-button';

    if( !empty(sns_style()) || $position==='fixed_footer_share_button' ) {
        $twitter_count = '';
        $facebook_count = '';
        $hatebu_count = '';
        $pocket_count = '';
    }

    $target = (is_amp()) ? ' rel="nofollow"' : ' target="blank" rel="nofollow"';

    $twitter = '<a class="twitter '.$sns_class.'" href="http://twitter.com/share?text='.$title.'&url='.$url.$via.'&tw_p=tweetbutton&related='.get_the_author_meta('twitter').'"'.$target.'><i class="fab fa-twitter"></i>'.$twitter_count.'</a>';

    $facebook = '<a class="facebook '.$sns_class.'" href="http://www.facebook.com/sharer.php?src=bm&u='.$url.'&t='.$title.'"'.$target.'><i class="fab fa-facebook"></i>'.$facebook_count.'</a>';

    $hatebu = '<a class="hatebu '.$sns_class.'" href="http://b.hatena.ne.jp/add?mode=confirm&url='.$url.'"'.$target.'><i class="fab fa-hatena"></i>'.$hatebu_count.'</a>';

    $pocket = '<a class="pocket '.$sns_class.'" href="http://getpocket.com/edit?url='.$url.'&title='.$title.'"'.$target.'><i class="fab fa-get-pocket"></i>'.$pocket_count.'</a>';

    $line = '<a class="line '.$sns_class.'" href="http://line.me/R/msg/text/?'.$title.'%0A'.$url.'"'.$target.'><i class="fab fa-line"></i></a>';

    $style = (sns_style()) ? ' simple-sns' : '';
    $flex_option = 'j-c-c';
    $padding = ' padding-1_5em-0';
    $display = ( fixed_footer() === 'share' ) ? ' d-n-mobile' : '';

    if( $position === 'post_top' ) $padding = $margin = ' margin-2em-auto';

    if( $position === 'fixed_footer_menu' ) $padding = ' padding-0-10px margin-2em-auto';

    if( $position === 'fixed_footer_share_button' ) {
      $padding = ' padding-10px';
      $flex_option = 'j-c-f-e f-d-r-r';
      $display = '';
    }

    $class = $style.$padding.$display;

    ?>

    <div class="share sns t-a-c<?php echo $class; ?>">
        <?php if($position==='post_bottom' && sns_share_text()) echo '<p class="sns-title">'.sns_share_text().'</p>'; ?>
        <div class="d-f <?php echo $flex_option; ?>">
            <?php echo $twitter.$facebook.$hatebu.$pocket.$line; ?>
        </div>
    </div>

<?php } ?>
