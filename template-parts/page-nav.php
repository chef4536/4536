<?php
if(!post_prev_next_4536()) return;
$true = next_prev_in_same_term();
$prevpost = get_previous_post($true);
$nextpost = get_next_post($true);
$flex_end = ($prevpost) ? '' : ' justify-content-flex-end';
if( empty($prevpost) && empty($nextpost) ) return;
?>

<div id="prev-next" class="clearfix margin-2em-auto flexbox-row-wrap<?php echo $flex_end; ?>">
  <?php
  switch( thumbnail_size() ) {
    case 'thumbnail-wide':
      $thumb = (thumbnail_quality()==='high') ? [300,225] : [150,113];
      if( is_amp() ) $thumb = [500,375];
      break;
    case 'thumbnail':
      $thumb = (thumbnail_quality()=='high') ? [300,300] : [150,150];
      if( is_amp() ) $thumb = [500,500];
      break;
  }
  if( $prevpost ) {
    $post_id = $prevpost->ID;
    ?>
    <div id="prev-post" class="clearfix position-relative flexbox-row-wrap">
      <div class="prev-post-arrow flexbox-row-wrap align-items-center"><i class="fas fa-angle-left"></i></div>
      <?php prev_next_post_thumbnail( $post_id );
      echo '<a class="prev-title post-color link-mask" href="' . get_permalink( $post_id ) . '" title="' . get_the_title( $post_id ) . '">' . get_the_title( $post_id ) . '</a>';
      ?>
    </div>
  <?php }
  if( $nextpost ) {
    $post_id = $nextpost->ID;
    ?>
    <div id="next-post" class="clearfix position-relative flexbox-row-wrap">
      <?php
      echo '<a class="next-title post-color link-mask" href="' . get_permalink( $post_id ) . '" title="' . get_the_title( $post_id ) . '">' . get_the_title( $post_id ) . '</a>';
      prev_next_post_thumbnail( $post_id );
      ?>
      <div class="next-post-arrow flexbox-row-wrap align-items-center"><i class="fas fa-angle-right"></i></div>
    </div>
  <?php } ?>
</div>
