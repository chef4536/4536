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
      <link rel="stylesheet" href="<?php echo wp_block_lib_stylesheet_url(); ?>" />
      <link rel="stylesheet" href="<?php echo get_template_directory_uri().'/style.min.css?'.$ver; ?>" />
  </noscript>
<?php });

//css読み込み用のフィルター作成
function add_inline_style_4536( $custom_css = true ) {
  $css = [];
  $css = apply_filters( 'inline_style_4536', $css );
  $css = array_unique($css);
  $css = array_values($css);
  $css = implode('', $css);
  if ( $custom_css === true ) $css .= wp_get_custom_css();
  return $css;
}

//head内にインラインCSSを出力
add_action( 'wp_head', function() { ?>
  <style>
  <?php
  echo add_inline_style_4536(false);
  require_once(get_template_directory() . '/css/inline.min.css');
  ?>
  </style>
<?php });

//AMP用のCSS生成
function amp_css() {
  ob_start();
  require_once(get_template_directory() . '/css/inline.min.css');
  require_once(get_template_directory() . '/style.min.css');
//    require_once(ABSPATH . '/wp-includes/css/dist/block-library/style.min.css');
  $styles = ob_get_clean();
  $custom_bgc = 'body.custom-background{background-color:#'.get_background_color().'}';
  $css = $styles.$custom_bgc.add_inline_style_4536();
  echo '<style amp-custom>';
  $css = str_replace('@charset "UTF-8";', '', $css);
  $css = str_replace('!important', '', $css);
  $css = str_replace('img', 'amp-img', $css);
  $css = str_replace('iframe', 'amp-iframe', $css);
  echo strip_tags($css);
  require_once(get_template_directory() . '/css/amp.min.css');
  echo '</style>';
}

//FontAwesomのリンク
function fontawesome_url() {
  return 'https://use.fontawesome.com/releases/v5.6.3/css/all.css';
}
//管理画面でFontAwesomeのリンクを読み込む
add_action('admin_enqueue_scripts', function() {
  wp_enqueue_style( 'admin-fontawesome', fontawesome_url(), [], theme_version_4536() );
});
