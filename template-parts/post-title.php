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

<div class="container mx-auto mb-4 d-f a-i-c f-w-w">
  <h1 id="h1" class="headline xs12 sm12 md6 pr-3 pl-3 mt-5"><?php the_title(); ?></h1>
  <div class="xs12 sm12 md6 pr-3 pl-3 mt-5 mb-5 p-r">
    <svg class="b-0 post-thumbnail-shape" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500.67 418.44">
      <path d="M258.19,191.19c28.37,22.36,60.25,39.57,76.71,67.14s17.52,65.54-2.66,89.67-61.58,34.49-101.87,47.23S150.85,423.16,115.54,417s-66.76-33.39-88.41-65.79-33.42-70-23.68-101.74,41.12-57.7,74.12-79.33,67.68-39.08,97.46-34S229.74,168.84,258.19,191.19Z" fill="#4facfe" />
      <path class="cls-1" d="M435.11.38C457.59,4.43,467.92,44,461.46,75.69s-29.54,55.15-18.14,95.66,57.17,97.88,57.35,143.17S455.23,393,418.1,375.42s-65.72-85.66-100.44-118-75.41-28.62-108-46.2S152.75,155,148,111.15,158,18.28,193.83,8.73s92.63,20.41,138.32,19.65S412.61-3.78,435.11.38Z" fill="#00f2fe" />
    </svg>
    <div class="p-a t-0 b-0 r-0 l-0 pa-3">
      <?php the_post_thumbnail_4536(); ?>
    </div>
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