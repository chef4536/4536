<?php
if(!post_prev_next_4536()) return;
$true = next_prev_in_same_term();
$prevpost = get_previous_post($true);
$nextpost = get_next_post($true);
$flex_end = ($prevpost) ? '' : ' j-c-f-e';
if( empty($prevpost) && empty($nextpost) ) return;
?>

<div id="prev-next" class="d-f f-w-w<?php echo $flex_end; ?>">
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
    <div class="p-r xs12 sm12 md6">
      <?php
      prev_next_post_thumbnail( $post_id );
      echo '<a data-color="white" data-overflow="hidden" class="p-a t-0 b-0 l-0 r-0 pa-5 link-mask headline" href="' . get_permalink( $post_id ) . '" title="' . get_the_title( $post_id ) . '">' . get_the_title( $post_id ) . '</a>';
      ?>
      <div data-button="floating" data-bg-color="white" class="p-a b-0 l-0 ml-2 mb-2"><?php echo I_ARROW_LEFT_ALT; ?></div>
    </div>
  <?php }
  if( $nextpost ) {
    $post_id = $nextpost->ID;
    ?>
    <div class="p-r xs12 sm12 md6">
      <?php
      prev_next_post_thumbnail( $post_id );
      echo '<a data-color="white" data-overflow="hidden" class="p-a t-0 b-0 l-0 r-0 pa-5 link-mask headline" href="' . get_permalink( $post_id ) . '" title="' . get_the_title( $post_id ) . '">' . get_the_title( $post_id ) . '</a>';
      ?>
      <div data-button="floating" data-bg-color="white" class="p-a b-0 r-0 mr-2 mb-2"><?php echo I_ARROW_RIGHT_ALT; ?></div>
    </div>
  <?php } ?>
</div>
