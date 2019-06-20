<?php

$ptime = get_the_date();
$mtime = get_mtime();
if ($mtime) {
    $posted_datetime = $ptime;
    $modified_datetime = '<time datetime="'.get_the_modified_time('c').'">'.$mtime.'</time>';
} else {
    $posted_datetime = '<time datetime="'.get_the_time('c').'">'.$ptime.'</time>';
    $modified_datetime = $mtime;
}
$ptime = '<span class="posted-date"><i class="far fa-calendar-check"></i>'.$posted_datetime.'</span>';
$date = ($mtime) ? '<span class="modified-date"><i class="fas fa-redo"></i>'.$modified_datetime.'</span>' : $ptime ;
$post_date = '<div class="post-date post-data">' . $mtime . '</div>';

?>

<div class="container mx-auto mb-5 d-f a-i-c f-w-w">
  <h1 id="h1" class="headline xs12 sm12 md6 pr-3 pl-3 mt-4 mb-4"><?php the_title(); ?></h1>
  <div class="xs12 sm12 md6 pr-3 pl-3 mt-4 mb-4">
    <?php
    if (!get_post_meta($post->ID, 'none_post_thumbnail', true)) {
        the_post_thumbnail_4536();
    }
    ?>
  </div>
</div>

<?php

if (is_amp() && is_amp_post_top()) {
    echo amp_adsense_code('horizon');
}

if (is_amp()) {
    dynamic_sidebar('amp-post-top');
} else {
    dynamic_sidebar('post-top-widget');
}

if ($is_sns_top === true) {
    sns_button_4536('post_top');
}
