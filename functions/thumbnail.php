<?php
function thumbnail_4536($thumbnail_style) {
    $days = new_icon_date();
    $days = mb_convert_kana(strip_tags($days), 'n');
    $today = date_i18n('U');
    $entry = get_the_time('U');
    $elapsed = date('U',($today - $entry)) / 86400;
    $new_icon = ($days > $elapsed) ? '<div class="icon-area"><span class="new-icon"></span></div>' : '';
    $thumbnail = '';
    $src = '';
    $class = '';
    if(thumbnail_size()=='thumbnail-wide') {
        $thumb500 = [500,375];
        $thumb300 = [300,225];
        $thumb150 = [150,113];
        $thumb100 = [100,75];
    } elseif(thumbnail_size()=='thumbnail') {
        $thumb500 = [500,500];
        $thumb300 = [300,300];
        $thumb150 = [150,150];
        $thumb150 = [100,100];
    }
    
    $thumbnail_size = thumbnail_size();

    if($thumbnail_style=='2-5') {
        $post_thumbnail = get_the_post_thumbnail( $post->ID, $thumb500 );
        if(thumbnail_quality()==='high') $post_thumbnail = get_the_post_thumbnail();
    } elseif($thumbnail_style=='3-3'||$thumbnail_style=='4-2') {
        $post_thumbnail = get_the_post_thumbnail( $post->ID, $thumb300 );
        if(thumbnail_quality()==='high') $post_thumbnail = get_the_post_thumbnail( $post->ID, $thumb500 );
    } elseif($thumbnail_style=='big') {
        $post_thumbnail = get_the_post_thumbnail( $post->ID, $thumb500 );
        if(thumbnail_quality()==='high') $post_thumbnail = get_the_post_thumbnail();
    } elseif($thumbnail_style=='pickup') {
        $thumbnail_size .= ' thumbnail-pickup-4536';
        $post_thumbnail = get_the_post_thumbnail( $post->ID, $thumb150 );
        if(thumbnail_quality()==='high') $post_thumbnail = get_the_post_thumbnail( $post->ID, $thumb300 );
    } elseif($thumbnail_style=='widget') {
        $thumbnail_size .= ' thumbnail-widget-4536';
        $post_thumbnail = get_the_post_thumbnail( $post->ID, $thumb100 );
        if(thumbnail_quality()==='high') $post_thumbnail = get_the_post_thumbnail( $post->ID, $thumb300 );
    } elseif($thumbnail_style==='music') {
        $thumbnail_size = 'thumbnail-music-4536';
        $post_thumbnail = get_the_post_thumbnail( $post->ID, [150, 150] );
        if(thumbnail_quality()==='high') $post_thumbnail = get_the_post_thumbnail( $post->ID, [300, 300] );
    } elseif($thumbnail_style==='movie') {
        $thumbnail_size = 'thumbnail-movie-4536';
        $post_thumbnail = get_the_post_thumbnail( $post->ID, [196, 110] );
        if(thumbnail_quality()==='high') $post_thumbnail = get_the_post_thumbnail( $post->ID, [400, 231] );
    } else {
        $post_thumbnail = get_the_post_thumbnail( $post->ID, $thumb150 );
        if(thumbnail_quality()==='high') $post_thumbnail = get_the_post_thumbnail( $post->ID, $thumb300 );
    }
    if(is_amp()) $post_thumbnail = get_the_post_thumbnail( $post->ID, $thumb500 );

    $height = (thumbnail_size()=='thumbnail') ? '512' : '341' ;
    
    //カテゴリー
    $cat = get_the_category();
    $cat_name = $cat[0]->name;
    $cat_slug = $cat[0]->slug;
    if(is_home()) $category = '<span class="post-list-category '.$cat_slug.'">'.$cat_name.'</span>';
    if($thumbnail_style==='music' || $thumbnail_style==='movie') $category = '';

    //サムネイル
    if(thumbnail_display()==='image') {
        $start_tag = '<figure class="post-list-thumbnail '.$thumbnail_size.'">';
        $img_s_tag = (is_amp()) ? 'amp-img' : 'img';
        $img_e_tag = (is_amp()) ? '</amp-img>' : '';
        if ( has_post_thumbnail() ) {
            $thumbnail = $post_thumbnail;
        } elseif (function_exists('get_first_image_4536') && get_first_image_4536()) {
            $w_px = get_image_width_and_height_4536(get_first_image_4536())['width'];
            $h_px = get_image_width_and_height_4536(get_first_image_4536())['height'];
            $sizes = (is_amp()) ? ' sizes="(max-width:'.$w_px.'px) 100vw, '.$w_px.'px"' : '';
            $thumbnail = '<'.$img_s_tag.' src="'.get_first_image_4536().'" alt="'.get_the_title().'" width="'.$w_px.'" height="'.$h_px.'"'.$sizes.'>'.$img_e_tag;
        } else {
            $thumbnail = '<'.$img_s_tag.' src="'.get_template_directory_uri().'/img/no-image-512-'.$height.'.png" alt="no image" title="no image" width="512" height="'.$height.'" sizes="(max-width:512px) 100vw, 512px">'.$img_e_tag;
        }
        $end_tag = $new_icon.$category.'</figure>';
        $thumbnail = $start_tag.$thumbnail.$end_tag;
    } else {
        if(has_post_thumbnail()) {
            preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post_thumbnail, $m);
            $src = ($m) ? $m[1] : get_the_post_thumbnail_url();
            $class = get_thumbnail_class_4536($src);
        } elseif(function_exists('get_first_image_4536') && get_first_image_4536()) {
            $src = get_first_image_4536();
            $class = get_thumbnail_class_4536($src);
        } else {
            $src = get_template_directory_uri().'/img/no-image-512-'.$height.'.png';
            $class = 'thumbnail-no-img-512-'.$height;
        }
        //参考：https://teratail.com/questions/28223#reply-44119
        
        $thumbnail = '<div class="background-thumbnail-4536 '.$class.'"></div>';
        $thumbnail = '<div class="post-list-thumbnail '.$thumbnail_size.'">'.$thumbnail.$new_icon.$category.'</div>';
    }
    return [
        'thumbnail' => $thumbnail,
        'src' => $src,
        'class' => $class
    ];
}
