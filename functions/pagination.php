<?php
//ページネーション追加
function pagination($pages = '', $range = 1)
{
    $showitems = ($range * 2) + 1;
    global $paged;
    if (empty($paged)) {
        $paged = 1;
    }
    if ($pages == '') {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if (!$pages) {
            $pages = 1;
        }
    }
    if ($pages!==1) {
        echo '<div data-display="flex" data-justify-content="center" id="pagination" class="mt-3 mb-2">';
        if ($paged > 2 && $paged > $range+1 && $showitems < $pages) {
            echo '<a data-button="floating" class="mr-2" href="'.get_pagenum_link(1).'">1</a>';
        }
        if ($paged > 1 && $showitems < $pages) {
            echo '<a data-button="floating" class="mr-2" href="'.get_pagenum_link($paged - 1).'">&lt;</a>';
        }
        for ($i=1; $i <= $pages; $i++) {
            if ($pages!==1 &&(!($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems)) {
                if ($paged === $i) echo '<span data-button="floating" class="gradation current mr-2">'.$i.'</span>';
            }
        }
        if ($paged < $pages && $showitems < $pages) {
            echo '<a data-button="floating" href="'.get_pagenum_link($paged + 1).'" class="mr-2">&gt;</a>';
        }
        if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) {
            echo '<a data-button="floating" href="'.get_pagenum_link($pages).'">'.$pages.'</a>';
        }
        echo '</div>';
    }
}
