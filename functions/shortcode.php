<?php

//固定ページ一覧の出力
add_shortcode('page-list-4536', function($atts) {
    $atts['echo'] = 0;
    return wp_list_pages($atts);
});

//固定ページドロップダウンリスト
add_shortcode('dropdown-pages-4536', function($defaults) {
    $defaults = [
        'echo' => 0,
    ];
    $dropdown_pages = '<div class="dropdown-list">'.
    '<form action="'.get_bloginfo('url').'" method="get">'
        .wp_dropdown_pages($defaults).
    '<button type="submit" name="submit" class="submit-button"><i class="fab fa-mouse-pointer"></i></button>'.
    '</form>'.
    '</div>';
    return $dropdown_pages;
});

//前後の記事
add_shortcode('post-prev-next-4536', function() {
    ob_start();
    get_template_part('template-parts/page-nav');
    $page_nav = ob_get_clean();
    return $page_nav;
});

//--------------------消さない-----------------------//
add_filter( 'widget_text', 'shortcode_unautop' );
add_filter( 'widget_text', 'do_shortcode' );
//--------------------消さない-----------------------//

//ショートコード
$data = $wpdb->get_results( "SELECT * FROM " . SHORTCODE_TABLE, ARRAY_A );
if( !empty( $data ) ) {
  foreach( $data as $num => $arr ) {
    //処理
  }
}
