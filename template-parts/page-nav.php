<?php
if(!post_prev_next_4536()) return;
$true = next_prev_in_same_term();
$prevpost = get_previous_post($true); //前の記事
$nextpost = get_next_post($true); //次の記事
if( $prevpost or $nextpost ) { //前の記事、次の記事いずれか存在しているとき

$flex_end = ($prevpost) ? '' : ' justify-content-flex-end' ;
echo '<div id="prev-next" class="clearfix flexbox-row-wrap'.$flex_end.'">';

if($prevpost) { //前の記事が存在しているとき
    echo '<a id="prev-post" class="clearfix flexbox-row-wrap" href="' . get_permalink($prevpost->ID) . '">'.
        '<div class="prev-post-arrow flexbox-row-wrap align-items-center"><i class="fas fa-angle-left"></i></div>';
    if(thumbnail_size()=='thumbnail-wide') {
        $thumb = (thumbnail_quality()==='high') ? [300,225] : [150,113];
        if(is_amp()) $thumb = [500,375];
    } elseif(thumbnail_size()==='thumbnail') {
        $thumb = (thumbnail_quality()=='high') ? [300,300] : [150,150];
        if(is_amp()) $thumb = [500,500];
    }
    if(has_post_thumbnail($prevpost->ID)) {
        if(thumbnail_display()==='image') {
            echo '<figure class="prev-next-thumbnail">'.get_the_post_thumbnail($prevpost->ID, $thumb).'</figure>';
        } else {
            $src = get_the_post_thumbnail_url($prevpost->ID);
            $class = get_thumbnail_class_4536($src);
            echo '<div class="'.thumbnail_size().'"><div class="prev-post-thumbnail '.$class.'"></div></div>';
        }
    }
    echo '<p class="prev-title">' . get_the_title($prevpost->ID) . '</p></a>';
}
if($nextpost) { //次の記事が存在しているとき
    echo '<a id="next-post" class="clearfix flexbox-row-wrap" href="' . get_permalink($nextpost->ID) . '">'.
        '<p class="next-title">'. get_the_title($nextpost->ID) . '</p>';
    if(has_post_thumbnail($nextpost->ID)) {
        if(thumbnail_display()==='image') {
            echo '<figure class="prev-next-thumbnail">'.get_the_post_thumbnail($nextpost->ID, $thumb).'</figure>';
        } else {
            $src = get_the_post_thumbnail_url($nextpost->ID);
            $class = get_thumbnail_class_4536($src);        
            echo '<div class="'.thumbnail_size().'"><div class="next-post-thumbnail '.$class.'"></div></div>';
        }
    }
    echo '<div class="next-post-arrow flexbox-row-wrap align-items-center"><i class="fas fa-angle-right"></i></div></a>';
}

echo '</div>';

}