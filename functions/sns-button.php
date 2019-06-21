<?php

function sns_button_4536($position)
{
    if (is_amp() || is_singular()) {
        $url = esc_url(get_permalink());
        $title = esc_html(get_the_title());
        $custom = get_post_custom();
        if (!empty($custom['sns_title'][0])) {
            $title = esc_html($custom['sns_title'][0]);
        }
    } else {
        $http = is_ssl() ? 'https://' : 'http://';
        $url = esc_url($http . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        $title = esc_html(wp_get_document_title());
    }

    $via = (twitter_via() && get_the_author_meta('twitter')) ? '&via='.get_the_author_meta('twitter') : '';

    if (function_exists('scc_get_share_twitter') && scc_get_share_twitter()!==0) {
        $twitter_count = '<span class="sns-count">'.scc_get_share_twitter().'</span>';
    }
    if (function_exists('scc_get_share_facebook') && scc_get_share_facebook()!==0) {
        $facebook_count = '<span class="sns-count">'.scc_get_share_facebook().'</span>';
    }
    if (function_exists('scc_get_share_hatebu') && scc_get_share_hatebu()!==0) {
        $hatebu_count = '<span class="sns-count">'.scc_get_share_hatebu().'</span>';
    }
    if (function_exists('scc_get_share_pocket') && scc_get_share_pocket()!==0) {
        $pocket_count = '<span class="sns-count">'.scc_get_share_pocket().'</span>';
    }

    $sns_class = 'default-sns-button colorful-sns-button flex';

    if ($position === 'fixed_footer_share_button') {
        $sns_class = 'simple-sns-button colorful-sns-button';
    }

    $target = (is_amp()) ? ' rel="nofollow"' : ' target="blank" rel="nofollow"';

    //url

    $arr['twitter']['url'] = 'http://twitter.com/share?text=' . $title . '&url=' . $url . $via . '&tw_p=tweetbutton&related=' . get_the_author_meta('twitter');

    $arr['facebook']['url'] = 'http://www.facebook.com/sharer.php?src=bm&u=' . $url . '&t=' . $title;

    $arr['hatebu']['url'] = 'http://b.hatena.ne.jp/add?mode=confirm&url=' . $url;

    // $arr['pocket']['url'] = 'http://getpocket.com/edit?url=' . $url . '&title=' . $title;

    $arr['line']['url'] = 'http://line.me/R/msg/text/?' . $title . '%0A' . $url;

    //text

    $arr['twitter']['text'] = '<svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 400 400"><circle class="st0" cx="200" cy="200" r="200" fill="#1DA1F2" /><path class="st1" d="M163.4,305.5c88.7,0,137.2-73.5,137.2-137.2c0-2.1,0-4.2-0.1-6.2c9.4-6.8,17.6-15.3,24.1-25 c-8.6,3.8-17.9,6.4-27.7,7.6c10-6,17.6-15.4,21.2-26.7c-9.3,5.5-19.6,9.5-30.6,11.7c-8.8-9.4-21.3-15.2-35.2-15.2 c-26.6,0-48.2,21.6-48.2,48.2c0,3.8,0.4,7.5,1.3,11c-40.1-2-75.6-21.2-99.4-50.4c-4.1,7.1-6.5,15.4-6.5,24.2 c0,16.7,8.5,31.5,21.5,40.1c-7.9-0.2-15.3-2.4-21.8-6c0,0.2,0,0.4,0,0.6c0,23.4,16.6,42.8,38.7,47.3c-4,1.1-8.3,1.7-12.7,1.7 c-3.1,0-6.1-0.3-9.1-0.9c6.1,19.2,23.9,33.1,45,33.5c-16.5,12.9-37.3,20.6-59.9,20.6c-3.9,0-7.7-0.2-11.5-0.7 C110.8,297.5,136.2,305.5,163.4,305.5" fill="#FFFFFF" /></svg>' . $twitter_count;

    $arr['facebook']['text'] = '<svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 1024 1024"><path d="M1024,512C1024,229.23,794.77,0,512,0S0,229.23,0,512c0,255.55,187.23,467.37,432,505.78V660H302V512H432V399.2C432,270.88,508.44,200,625.39,200c56,0,114.61,10,114.61,10V336H675.44c-63.6,0-83.44,39.47-83.44,80v96H734L711.3,660H592v357.78C836.77,979.37,1024,767.55,1024,512Z" fill="#1877f2" /><path d="M711.3,660,734,512H592V416c0-40.49,19.84-80,83.44-80H740V210s-58.59-10-114.61-10C508.44,200,432,270.88,432,399.2V512H302V660H432v357.78a517.58,517.58,0,0,0,160,0V660Z" fill="#fff" /></svg>' . $facebook_count;

    $arr['hatebu']['text'] = '<svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 500 500"><rect width="500" height="500" rx="101.9" ry="101.9" fill="#00a4de"/><g fill="#fff"><path d="M278.2,258.1q-13.6-15.2-37.8-17c14.4-3.9,24.8-9.6,31.4-17.3s9.8-17.8,9.8-30.7A55,55,0,0,0,275,166a48.8,48.8,0,0,0-19.2-18.6c-7.3-4-16-6.9-26.2-8.6s-28.1-2.4-53.7-2.4H113.6V363.6h64.2q38.7,0,55.8-2.6c11.4-1.8,20.9-4.8,28.6-8.9a52.5,52.5,0,0,0,21.9-21.4c5.1-9.2,7.7-19.9,7.7-32.1C291.8,281.7,287.3,268.2,278.2,258.1Zm-107-71.4h13.3q23.1,0,31,5.2c5.3,3.5,7.9,9.5,7.9,18s-2.9,14-8.5,17.4-16.1,5-31.4,5H171.2V186.7Zm52.8,130.3c-6.1,3.7-16.5,5.5-31.1,5.5H171.2V273h22.6c15,0,25.4,1.9,30.9,5.7s8.4,10.4,8.4,20S230.1,313.4,223.9,317.1Z"/><path d="M357.6,306.1a28.8,28.8,0,1,0,28.8,28.8A28.8,28.8,0,0,0,357.6,306.1Z"/><rect x="332.6" y="136.4" width="50" height="151.52"/></g></svg>' . $hatebu_count;

    // $arr['pocket']['text'] = '<i class="fab fa-get-pocket"></i>' . $pocket_count;

    $arr['line']['text'] = '<svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 120 120"><rect width="120" height="120" rx="26" fill="#00b900" /><path d="M103.5,54.72c0-19.55-19.6-35.45-43.7-35.45S16.11,35.17,16.11,54.72c0,17.53,15.55,32.21,36.54,35,1.43.31,3.36.94,3.85,2.16a8.93,8.93,0,0,1,.14,4L56,99.55c-.19,1.1-.88,4.32,3.78,2.35S85,87.09,94.13,76.54h0c6.33-7,9.37-14,9.37-21.82" fill="#fff" /><path d="M50.93,45.28H47.86a.85.85,0,0,0-.85.85v19a.85.85,0,0,0,.85.85h3.07a.85.85,0,0,0,.85-.85v-19a.85.85,0,0,0-.85-.85" fill="#00b900" /><path d="M72,45.28H69a.85.85,0,0,0-.85.85V57.44L59.38,45.65l-.06-.08h0l-.05-.05h0l0,0,0,0,0,0,0,0,0,0h0l-.05,0h0l-.05,0h-3.3a.85.85,0,0,0-.85.85v19a.85.85,0,0,0,.85.85h3.06a.86.86,0,0,0,.86-.85V53.86l8.73,11.79a.63.63,0,0,0,.22.21h0l.05,0h0l0,0,0,0h0l.06,0h0A.78.78,0,0,0,69,66H72a.85.85,0,0,0,.85-.85v-19a.85.85,0,0,0-.85-.85" fill="#00b900" /><path d="M43.54,61.25H35.21V46.13a.85.85,0,0,0-.85-.85H31.3a.85.85,0,0,0-.85.85v19h0a.87.87,0,0,0,.23.59h0v0a.87.87,0,0,0,.59.23H43.54a.85.85,0,0,0,.85-.85V62.1a.85.85,0,0,0-.85-.85" fill="#00b900" /><path d="M89,50a.85.85,0,0,0,.85-.85V46.13a.85.85,0,0,0-.85-.85H76.7a.85.85,0,0,0-.59.24h0v0a.83.83,0,0,0-.24.59h0v19h0a.83.83,0,0,0,.24.59h0a.85.85,0,0,0,.59.24H89a.85.85,0,0,0,.85-.85V62.1a.85.85,0,0,0-.85-.85H80.62V58H89a.85.85,0,0,0,.85-.85V54.11a.85.85,0,0,0-.85-.85H80.62V50Z" fill="#00b900" /></svg>';

    $display = (fixed_footer() === 'share') ? ' d-n-sm' : '';

    if ($position === 'post_top') {
        $padding = $margin = ' margin-2em-auto';
    }

    if ($position === 'fixed_footer_menu') {
        $padding = ' padding-0-10px margin-2em-auto';
    }

    if ($position === 'fixed_footer_share_button') {
        $padding = ' padding-10px';
        $flex_option = 'j-c-f-e f-d-r-r';
        $display = '';
    }

    $class = $style.$padding.$display; ?>

    <div class="share sns t-a-c<?php echo $class; ?>">
        <?php if ($position==='post_bottom' && sns_share_text()) {
        echo '<p class="sns-title">'.sns_share_text().'</p>';
    } ?>
        <div class="d-f j-c-c">
            <?php
            foreach ($arr as $key => $value) {
              echo '<span class="pa-2"><a class="d-b ' . $key . '" href="' . $value['url'] . '"' . $target . '>' . $value['text'] . '</a></span>';
            }
            echo $twitter.$facebook.$hatebu.$pocket.$line;
            ?>
        </div>
    </div>

<?php
} ?>
