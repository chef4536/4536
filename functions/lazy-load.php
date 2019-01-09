<?php
add_action('wp_footer', function() {
if(!is_lazy_load_4536()) return; ?>
<script>
/*! echo-js v1.7.3 | (c) 2016 @toddmotto | https://github.com/toddmotto/echo */
(function(d,c){if(typeof define==="function"&&define.amd){define(function(){return c(d)})}else{if(typeof exports==="object"){module.exports=c}else{d.echo=c(d)}}})(this,function(n){var t={};var l=function(){};var r,p,q,m,s;var v=function(a){return(a.offsetParent===null)};var o=function(a,b){if(v(a)){return false}var c=a.getBoundingClientRect();return(c.right>=b.l&&c.bottom>=b.t&&c.left<=b.r&&c.top<=b.b)};var u=function(){if(!m&&!!p){return}clearTimeout(p);p=setTimeout(function(){t.render();p=null},q)};t.init=function(c){c=c||{};var e=c.offset||0;var a=c.offsetVertical||e;var d=c.offsetHorizontal||e;var b=function(g,f){return parseInt(g||f,10)};r={t:b(c.offsetTop,a),b:b(c.offsetBottom,a),l:b(c.offsetLeft,d),r:b(c.offsetRight,d)};q=b(c.throttle,250);m=c.debounce!==false;s=!!c.unload;l=c.callback||l;t.render();if(document.addEventListener){n.addEventListener("scroll",u,false);n.addEventListener("load",u,false)}else{n.attachEvent("onscroll",u);n.attachEvent("onload",u)}};t.render=function(e){var f=(e||document).querySelectorAll("[data-echo], [data-placeholder], [data-srcset], [data-sizes]");var d=f.length;var g,b,h,c;var i={l:0-r.l,t:0-r.t,b:(n.innerHeight||document.documentElement.clientHeight)+r.b,r:(n.innerWidth||document.documentElement.clientWidth)+r.r};for(var a=0;a<d;a++){c=f[a];if(o(c,i)){if(c.getAttribute("data-echo")){c.src=c.getAttribute("data-echo")}if(c.getAttribute("data-srcset")){c.srcset=c.getAttribute("data-srcset")}if(c.getAttribute("data-sizes")){c.sizes=c.getAttribute("data-sizes")}if(!s){c.removeAttribute("data-echo");c.removeAttribute("data-srcset");c.removeAttribute("data-sizes");c.removeAttribute("data-placeholder")}l(c,"load")}}if(!d){t.detach()}};t.detach=function(){if(document.removeEventListener){n.removeEventListener("scroll",u)}else{n.detachEvent("onscroll",u)}clearTimeout(p)};return t});
echo.init({offsetVertical:500,offsetHorizontal:800,debounce:false,});
</script>
<?php });

add_filter('the_content', 'lazy_load_content_4536', 9999999999999);
add_filter('widget_text','lazy_load_content_4536', 9999999999999);
add_filter('widget_item_new','lazy_load_content_4536', 9999999999999);
function lazy_load_content_4536($html) {
    if(is_amp()) return $html;
    if(!is_lazy_load_4536()) return $html;
    $placeholder = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=';
    if(preg_match_all('/<img.+?src=".+?".*?>/i', $html, $images)) {
        foreach($images[0] as $image) {
            preg_match('/class="(.+?)"/i', $image, $class);
            if(strpos($class[1], 'lazy-load-4536') !== false) continue;
            preg_match('/(width|height)="1"/i', $image, $tag);
            if($tag) continue;
//            preg_match('/src="(.+?)"/i', $image, $src);
//            if(strpos($src[1], site_url()) === false) continue;
            $new_image = str_replace('src="', 'data-placeholder="spinner" src="'.$placeholder.'" data-echo="', $image);
            $new_image = str_replace('srcset="', 'data-srcset="', $new_image);
            $new_image = str_replace('sizes="', 'data-sizes="', $new_image);
            $new_image = preg_replace('/class="(.+?)"/i', 'class="lazy-load-4536 $1"', $new_image);
            $noscript = '<noscript>'.$image.'</noscript>';
            $new_image = $new_image.$noscript;
            $html = preg_replace('{'.preg_quote($image).'}', $new_image, $html);
        }
    }
    if(preg_match_all('/<iframe.+?src=".+?".*?><\/iframe>/i', $html, $iframes)) {
        foreach($iframes[0] as $iframe) {
            preg_match('/class="(.+?)".*?>/i', $iframe, $class);
            if(strpos($class[1], 'lazy-load-4536') !== false) continue;
            $new_iframe = str_replace('src="', 'data-placeholder="spinner" src="'.$placeholder.'" data-echo="', $iframe);
            $new_iframe = preg_replace('/class="(.+?)"/i', 'class="lazy-load-4536 $1"', $new_iframe);
            $noscript = '<noscript>'.$iframe.'</noscript>';
            $new_iframe = $new_iframe.$noscript;
            $html = preg_replace('{'.preg_quote($iframe).'}', $new_iframe, $html);
        }
    }
    return $html;
};

//get_avatar
add_filter('post_thumbnail_html', 'lazy_load_media_4536', 9999999999999);
function lazy_load_media_4536($image) {
    if(is_amp()) return $image;
    if(!is_lazy_load_4536()) return $image;
    preg_match('/class="(.+?)"/i', $image, $class);
    if(strpos($class[1], 'lazy-load-4536') !== false) return $image;
    if(strpos($class[1], 'attachment-post-thumbnail') !== false) return $image;
//    $new_image = str_replace('src="', 'src="'.get_template_directory_uri().'/img/now-loading.gif" data-echo="', $image);
    $placeholder = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=';
    $new_image = str_replace('src="', 'data-placeholder="spinner" src="'.$placeholder.'" data-echo="', $image);
    $new_image = str_replace('srcset="', 'data-srcset="', $new_image);
    $new_image = str_replace('sizes="', 'data-sizes="', $new_image);
    $new_image = preg_replace('/class="(.+?)"/i', 'class="lazy-load-4536 $1"', $new_image);
    $noscript = '<noscript class="lazy-load-noscript-4536">'.$image.'</noscript>';
    return $new_image.$noscript;
}
