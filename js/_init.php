<?php

//highlight.jsの条件分岐
function is_highlight_js_4536() {
    $highlight = false;
    if(is_code_highlight()=='all') $highlight = true;
    if(is_code_highlight()=='in_category' && in_category(code_highlight_category())) $highlight = true;
    if(is_archive()) $highlight = false;
    return $highlight;
}

//JS読み込み
add_action( 'wp_enqueue_scripts', function() {
  $ver = (function_exists('theme_version_4536')) ? theme_version_4536() : '';
  wp_enqueue_script( '4536-master', get_parent_theme_file_uri('dist/main_bundle.js'), [], $ver, false );
  wp_deregister_script('jquery');
  if(!get_option('is_jquery_lib')) {
    wp_enqueue_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', [], false, true);
  }
  if(is_highlight_js_4536()) {
    wp_enqueue_script( 'highlight-js', '//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js', [], false, true);
    wp_add_inline_script( 'highlight-js', 'hljs.initHighlightingOnLoad()', 'after' );
  }
});

//JavaScriptに非同期属性追加
if(!is_admin()) add_filter('script_loader_tag', function( $tag, $handle ) {
    if($handle==='4536-master') return str_replace( ' src', ' async src', $tag );
    if($handle==='jquery') return $tag;
    if($handle==='highlight-js') return $tag;
    if(javascript_load()==='defer') return str_replace( ' src', ' defer src', $tag );
    if(javascript_load()==='async') return str_replace( ' src', ' async src', $tag );
}, 10 ,2);

////////////////////////////////////
// タイトル文字数カウント
////////////////////////////////////
// 処理内容
function title_counter() { ?>
<script>

    TITLE_COUNTER_MAX_LENGTH = 28; //スタイルを変更する文字数（必要ない場合は0）

    function strLength(strSrc) {
        len = 0;
        strSrc = escape(strSrc);
        for(i = 0; i < strSrc.length; i++, len++) {
            if(strSrc.charAt(i) == "%") {
                if(strSrc.charAt(++i) == "u") {
                    i += 3;
                    len++;
                }
                i++;
            }
        }
        return len;
    }

    $( window ).load( function() {
        $('#titlewrap').before('<div id="title-counter" class="counter"></div>');
        $('#post-title-0').before('<div id="post-title-0-counter" class="counter" style="padding:1em 1em 0 1em;"></div>');
        var list = [
            '#title',
            '#post-title-0',
        ];
        $.each(list, function(index,value) {
            function counter() {
                var length = strLength($(value).val()).toString() / 2;
                if (TITLE_COUNTER_MAX_LENGTH != 0 && length > TITLE_COUNTER_MAX_LENGTH ) {
                    $(value + '-counter').html(length).addClass( 'title-counter-length-over' );
                } else {
                    $(value + '-counter').html(length).removeClass( 'title-counter-length-over' );
                }
            }
            counter();
            $(value).on('keydown keyup keypress change', counter);
        });
    });

</script>
<?php }
add_action( 'admin_head-post.php', 'title_counter' );
add_action( 'admin_head-post-new.php', 'title_counter' );
