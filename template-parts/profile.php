<div id="profile" class="clearfix">
  <h3 id="profile-title">
    <?php echo (is_singular(['music', 'movie'])) ? 'アーティスト情報' : 'この記事を書いた人' ; ?>：<?php the_author(); ?>
  </h3>
  <div id="profile-thumbnail">
    <?php
    $avatar = get_avatar( get_the_author_meta( 'ID' ), 80 );
    if ( is_amp() ) $avatar = str_replace( '<img', '<amp-img', $avatar );
    echo $avatar;
    ?>
  </div>
  <div id="profile-info" class="clearfix">
    <p><?php the_author_meta('user_description'); ?></p>
  </div>
  <div id="writter-follow" class="justify-content-flex-end display-flex">
    <?php

    $list = [
      'twitter' => 'twitter.com',
      'facebook' => 'www.facebook.com',
      'spotify' => 'open.spotify.com/user',
      'soundcloud' => 'soundcloud.com',
      'instagram' => 'www.instagram.com',
    ];

    foreach ($list as $key => $link) {
      if ( empty( $meta = get_the_author_meta($key) ) ) continue;
      $a_tag = '<a class="post-color" href="//'.$link.'/'.$meta.'" target="_blank" title="'.ucfirst($key).'をフォロー" rel="nofollow"><i class="fab fa-'.$key.'" aria-hidden="true"></i></a>';
      echo '<span class="follow-button">'.$a_tag.'</span>';
    }

    ?>
  </div>
</div>
