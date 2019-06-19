<?php
function thumbnail_4536($thumbnail_style)
{
    $days = new_icon_date();
    $days = mb_convert_kana(strip_tags($days), 'n');
    $today = date_i18n('U');
    $entry = get_the_time('U');
    $elapsed = date('U', ($today - $entry)) / 86400;
    $new_icon = ($days > $elapsed) ? '<div class="icon-area"><span class="new-icon"></span></div>' : '';
    $thumbnail = '';
    $src = '';
    $class = '';
    $content = get_the_content();

    if (thumbnail_size()=='thumbnail-wide') {
        $thumb500 = [500,375];
        $thumb300 = [300,225];
        $thumb150 = [150,113];
        $thumb100 = [100,75];
    } elseif (thumbnail_size()=='thumbnail') {
        $thumb500 = [500,500];
        $thumb300 = [300,300];
        $thumb150 = [150,150];
        $thumb150 = [100,100];
    }

    $thumbnail_class = thumbnail_size();

    switch ($thumbnail_style) {
      case '2-5':
      case 'big':
        $size = $thumb500;
        break;
      case '3-3':
      case '4-2':
        $size = $thumb300;
        break;
      case 'pickup':
      case 'widget':
        $size = $thumb150;
        break;
      case 'music':
        $thumbnail_class = 'thumbnail-music-4536';
        $size = [150, 150];
        break;
      case 'movie':
        $thumbnail_class = 'thumbnail-movie-4536';
        $size = [196, 110];
        break;
      default:
        $thumbnail_class = $thumb150;
        break;
    }

    if (is_amp()) {
        $size = $thumb500;
    }

    $class = "post-thumbnail-image p-a t-0 r-0 b-0 l-0 w-100 max-w-100 min-w-100 h-100";

    $post_thumbnail = get_the_post_thumbnail($post->ID, $size, ['class' => $class]);

    //カテゴリー
    $cat = get_the_category();
    $cat_name = $cat[0]->name;
    $cat_slug = $cat[0]->slug;
    if (is_home()) {
        $category = '<span class="post-list-category '.$cat_slug.'">'.$cat_name.'</span>';
    }
    if ($thumbnail_style==='music' || $thumbnail_style==='movie') {
        $category = '';
    }

    //サムネイル
    $start_tag = '<figure class="p-r post-list-thumbnail w-100 '.$thumbnail_class.'">';
    $thumbnail = (has_post_thumbnail()) ? $post_thumbnail : get_some_image_4536($content);
    $end_tag = $new_icon.$category.'</figure>';
    $thumbnail = $start_tag.$thumbnail.$end_tag;
    $thumbnail = convert_content_to_amp($thumbnail);
    return [
        'thumbnail' => $thumbnail,
        'src' => $src,
        'class' => $class
    ];
}
