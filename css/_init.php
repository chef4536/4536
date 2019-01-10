<?php

require_once('dynamic-css.php'); //動的CSS
require_once('customizer-color.php'); //色関連のテーマカスタマイザー
require_once('preload-css.php'); //非同期読み込み

//スタイルシート読み込み
add_action( 'wp_footer', function() {
    $ver = (function_exists('theme_version_4536')) ? theme_version_4536() : ''; ?>
    <script>
        var loadDeferredStyles = function() {
            var addStylesNode = document.getElementById("deferred-styles-4536");
            var replacement = document.createElement("div");
            replacement.innerHTML = addStylesNode.textContent;
            document.body.appendChild(replacement)
            addStylesNode.parentElement.removeChild(addStylesNode);
        };
        var raf = window.requestAnimationFrame || window.mozRequestAnimationFrame ||
          window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
        if(raf) raf(function() { window.setTimeout(loadDeferredStyles, 0); });
        else window.addEventListener('load', loadDeferredStyles);
    </script>
    <noscript id="deferred-styles-4536">
        <link rel="stylesheet" href="<?php echo get_template_directory_uri().'/style.min.css?'.$ver; ?>" />
        <link rel="stylesheet" href="<?php echo wp_block_lib_stylesheet_url(); ?>" />
    </noscript>
<?php });

//head内にインラインCSSを出力
add_action( 'wp_head', function() { ?>
    <style>
    <?php
    require_once(get_template_directory() . '/css/inline.min.css');
    dynamic_css_head_4536().heading_style_change_4536().customizer_color().widget_color_4536(); ?>
    </style>
<?php });

//AMP用のCSS生成
function amp_css() {
    ob_start();
    require_once(get_template_directory() . '/css/inline.min.css');
    require_once(get_template_directory() . '/style.min.css');
//    require_once(ABSPATH . '/wp-includes/css/dist/block-library/style.min.css');
    heading_style_change_4536();
    customizer_color();
    dynamic_css_head_4536();
    widget_color_4536();
    $styles = ob_get_clean();
    $custom_bgc = 'body.custom-background{background-color:#'.get_background_color().'}';
    $css = $styles.$custom_bgc.wp_get_custom_css();
    if($css) {
        echo '<style amp-custom>';
        $css = str_replace('@charset "UTF-8";', '', $css);
        $css = str_replace('!important', '', $css);
        $css = str_replace('img', 'amp-img', $css);
        $css = str_replace('iframe', 'amp-iframe', $css);
        echo strip_tags($css);
        require_once(get_template_directory() . '/css/amp.min.css');
        echo '</style>';
    }
}

//FontAwesomのリンク
function fontawesome_url() {
    return 'https://use.fontawesome.com/releases/v5.6.3/css/all.css';
}
//管理画面でFontAwesomeのリンクを読み込む
add_action('init', function() {
    wp_enqueue_style( 'fontawesome', fontawesome_url(), [], theme_version_4536() );
});
