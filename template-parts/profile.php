<div id="profile" class="clearfix">
    <h3 id="profile-title"><?php echo (is_singular(['music', 'movie'])) ? 'アーティスト情報' : 'この記事を書いた人' ; ?>：<?php the_author(); ?></h3>
    <div id="profile-thumbnail">
      <?php
        $avatar = get_avatar( get_the_author_meta( 'ID' ), 80 );
        if ( is_amp() ) {
            echo preg_replace('/<img/i', '<amp-img', $avatar );
        } else {
            echo $avatar;
        } ?>
    </div>
    <div id="profile-info" class="clearfix">
      <p><?php the_author_meta('user_description'); ?></p>
    </div>
    <div id="writter-follow" class="justify-content-flex-end display-flex">

    <?php if (get_the_author_meta('twitter')) : ?>
        <span class="follow-button">
            <a href="//twitter.com/<?php echo get_the_author_meta('twitter'); ?>" target="_blank" title="Twitterをフォロー" rel="nofollow"><i class="fab fa-twitter" aria-hidden="true"></i></a>
        </span>
    <?php endif; ?>

    <?php if (get_the_author_meta('facebook')) : ?>
        <span class="follow-button">
            <a href="//www.facebook.com/<?php echo get_the_author_meta('facebook'); ?>" target="_blank" title="Facebookをフォロー" rel="nofollow"><i class="fab fa-facebook" aria-hidden="true"></i></a>
        </span>
    <?php endif; ?>

    <?php if (get_the_author_meta('spotify')) : ?>
        <span class="follow-button">
            <a href="//open.spotify.com/user/<?php echo get_the_author_meta('spotify'); ?>" target="_blank" title="Spotifyをフォロー" rel="nofollow"><i class="fab fa-spotify" aria-hidden="true"></i></a>
        </span>
    <?php endif; ?>

    <?php if (get_the_author_meta('soundcloud')) : ?>
        <span class="follow-button">
            <a href="//soundcloud.com/<?php echo get_the_author_meta('soundcloud'); ?>" target="_blank" title="SoundCloudをフォロー" rel="nofollow"><i class="fab fa-soundcloud" aria-hidden="true"></i></a>
        </span>
    <?php endif; ?>

    <?php if (get_the_author_meta('googleplus')) : ?>
        <span class="follow-button">
            <a href="//plus.google.com/<?php echo get_the_author_meta('googleplus'); ?>" target="_blank" title="Google+をフォロー" rel="nofollow"><i class="fab fa-google-plus" aria-hidden="true"></i></a>
        </span>
    <?php endif; ?>

    <?php if (get_the_author_meta('instagram')) : ?>
        <span class="follow-button">
            <a href="//www.instagram.com/<?php echo get_the_author_meta('instagram'); ?>" target="_blank" title="Instagramをフォロー" rel="nofollow"><i class="fab fa-instagram" aria-hidden="true"></i></a>
        </span>
    <?php endif; ?>

    </div>
</div>