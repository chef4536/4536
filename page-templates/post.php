<?php

if(is_singular('post')) {
    $is_profile = is_profile_4536('profile_single');
    $is_sns_top = is_sns_top_4536('is_sns_top_single');
    $is_sns_bottom = is_sns_bottom_4536('is_sns_bottom_single');
} elseif(is_page()) {
    $is_profile = is_profile_4536('profile_page');
    $is_sns_top = is_sns_top_4536('is_sns_top_page');
    $is_sns_bottom = is_sns_bottom_4536('is_sns_bottom_page');
} elseif(is_singular(['music', 'movie'])) {
    $is_profile = is_profile_4536('profile_media');
    $is_sns_top = is_sns_top_4536('is_sns_top_media');
    $is_sns_bottom = is_sns_bottom_4536('is_sns_bottom_media');
} else {
    $is_profile = '';
    $is_sns_top = '';
    $is_sns_bottom = '';
}

//get_template_part('page-templates/pickup-post-top');

if( have_posts() ) : while ( have_posts() ) : the_post();

echo '<article class="post">';

$ptime = (posted_date_datetime()==='date') ? get_the_date() : get_the_date().get_the_time();
$mtime = get_mtime();
if(!post_datetime() || !$mtime) {
    $posted_datetime = '<time datetime="'.get_the_time('c').'">'.$ptime.'</time>';
    $modified_datetime = $mtime;
} else {
    $posted_datetime = $ptime;
    $modified_datetime = '<time datetime="'.get_the_modified_time('c').'">'.$mtime.'</time>';
}
$ptime = ($ptime) ? '<span class="posted-date"><i class="far fa-calendar-check"></i>'.$posted_datetime.'</span>' : '' ;
$mtime = ($mtime) ? '<span class="modified-date"><i class="fas fa-redo"></i>'.$modified_datetime.'</span>' : '' ;
$post_date = '<div class="post-date">'.$ptime.$mtime.'</div>';
if(is_page() && !is_page_time_mtime()) $post_date = '';
$title = '<h1 id="post-h1">'.get_the_title().'</h1>';

echo '<header>';
    echo (!post_title_date()) ? $post_date.$title : $title.$post_date;

    if(is_amp() && is_amp_post_top()) echo '<div class="amp-adsense-header margin-1em-auto">'.amp_adsense_code_top().'</div>';

    if(is_amp()) {
        dynamic_sidebar('amp-post-top');
    } else {
        dynamic_sidebar('post-top-widget');
    }

    the_post_thumbnail_4536(); //アイキャッチ

    if($is_sns_top) sns_button_4536('post_top');
echo '</header>';

echo '<div class="article-body">';
$content = apply_filters( 'the_content', get_the_content() );
$content = str_replace( ']]>', ']]&gt;', $content );
if(is_amp() && empty($content)) {
    echo '<p>'.auto_description_4536().'</p>'.
        '<div class="to-mobile-page button-4536 background-color-orange">'.
        '<a class="color-white-4536" href="'.get_the_permalink().'">続きを読む</a></div>';
} else {
    the_content();
    wp_link_pages();
}

echo '</div>';

echo '<footer>';

    if(is_amp() && is_amp_post_bottom() ) echo amp_adsense_code();

    //記事下広告枠
    $ad = '';
    if(is_amp()) {
        if(is_active_sidebar('amp-post-ad')) $ad = 'amp-post-ad';
    } else {
        if(is_active_sidebar('ad')) $ad = 'ad';
    }
    if(!empty($ad)) dynamic_sidebar($ad);

//    get_template_part('page-templates/pickup-post-bottom');

    if(is_singular(['music','movie'])) {
        $post_type = get_post_type();
        $post_type_object = get_post_type_object($post_type);
        $cat_name = $post_type_object->label;
        $cat_link = get_post_type_archive_link($post_type);
        $custom_post_link = '<a href="'.$cat_link.'" rel="category tag">'.$cat_name.'</a>';
    }
    if( (is_singular('post') && has_category()) || $custom_post_link ) {
    ?>
    <div class="category-tag flexbox-row-wrap align-items-center margin-1_5em-auto padding-10px">
        <span class="category-title">カテゴリー</span>
        <?php
            if(is_singular('post')) {
                $categories = get_the_category();
                $output = '';
                if($categories) {
                    foreach( $categories as $category ) {
                        $output .= '<span class="post-category"><a href="' . get_category_link( $category->term_id ) . '" rel="category tag">' . $category->cat_name . '</a></span>';
                    }
                    echo '<div id="post-categories">' . trim( $output ) . '</div>';
                }
            } elseif(is_singular(['music','movie'])) {
                echo '<div id="post-categories"><span>'.$custom_post_link.'</span></div>';
            }
        ?>
    </div>
    <?php }

    if($is_sns_bottom) sns_button_4536('post_bottom');
    if($is_profile) get_template_part('page-templates/profile');

echo '</footer>';

echo '</article>';

endwhile; else:

echo '<p>記事がありません</p>';

endif;

wp_reset_postdata();