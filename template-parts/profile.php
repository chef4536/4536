<section class="author-card pb-5" data-position="relative">
  <div class="body-bg-color author-avatar t-0" data-position="absolute">
    <?php
    $avatar = get_avatar(get_the_author_meta('ID'), 80);
    if (is_amp()) {
        $avatar = str_replace('<img', '<amp-img', $avatar);
    }
    echo $avatar;
    ?>
  </div>
  <div class="author-content gradation pa-4 l-h-140">
    <h3 data-text-align="center" class="mt-4 mb-3"><?php the_author(); ?></h3>
    <div class="user-description mb-3">
      <p><?php the_author_meta('user_description'); ?></p>
    </div>
    <div id="follow-me" data-display="flex" data-justify-content="center">
      <?php

      $list = [
        'twitter' => 'twitter.com',
        'facebook' => 'www.facebook.com',
        'spotify' => 'open.spotify.com/user',
        'soundcloud' => 'soundcloud.com',
        'instagram' => 'www.instagram.com',
      ];

      foreach ($list as $key => $link) {
          if (empty($meta = get_the_author_meta($key))) {
              continue;
          }
          $a_tag = '<a class="post-color" href="//'.$link.'/'.$meta.'" target="_blank" title="'.ucfirst($key).'をフォロー" rel="nofollow"><i class="fab fa-'.$key.'" aria-hidden="true"></i></a>';
          echo '<span class="follow-button">'.$a_tag.'</span>';
      }
      ?>
    </div>
  </div>
</section>
