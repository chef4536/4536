<?php
//ページネーション追加
function pagination($pages = '', $range = 1) {
    $showitems = ($range * 2) + 1;
    global $paged;
    if(empty($paged)) $paged = 1;
    if($pages == '') {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if(!$pages) $pages = 1;
    }
    if($pages!==1) {
        echo '<div class="pagination clearfix padding-0-1em display-flex justify-content-center text-align-center">';
        if ($paged > 2 && $paged > $range+1 && $showitems < $pages) echo '<a href="'.get_pagenum_link (1).'">1</a>';
        if($paged > 1 && $showitems < $pages) echo '<a href="'.get_pagenum_link($paged - 1).'">&lt;</a>';
        for($i=1; $i <= $pages; $i++) {
            if($pages!==1 &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
                echo ($paged == $i) ? '<span class="current">'.$i.'</span>' : '<a href="'.get_pagenum_link ($i).'" class="inactive">'.$i.'</a>';
            }
        }
        if($paged < $pages && $showitems < $pages) echo '<a href="'.get_pagenum_link($paged + 1).'">&gt;</a>';
        if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo '<a href="'.get_pagenum_link($pages).'">'.$pages.'</a>';
        echo '</div>';
    }
}