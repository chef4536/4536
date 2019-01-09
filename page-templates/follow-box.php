<?php
$facebook_id = get_the_author_meta('facebook', 1);
$twitter_id = get_the_author_meta('twitter', 1);
if(function_exists('scc_get_follow_feedly')) $feedly_count = (scc_get_follow_feedly()==0) ? '' : '&nbsp;'.scc_get_follow_feedly();
?>

<?php
if( is_likebox() || is_twitter_follow() || is_feedly_follow() ) {
    $class = get_the_post_thumbnail_4536()['class'];
    ?>
    <div id="follow-section">
        <div class="<?php if(!empty($class)) echo $class; ?> background-thumbnail-4536"></div>
        <div id="follow-section-cover"></div>
        <div id="follow-section-right">
            <p class="fb-like-text"><?php echo follow_section_title(); ?></p>
            <div id="follow-items">
                <?php
                if ( is_likebox() && $facebook_id ) { // いいねボタン
                    if(is_amp()) { ?>
                        <div class="fb-like follow-item">
                            <amp-facebook-like width="90" height="28" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false" data-href="https://www.facebook.com/<?php echo $facebook_id; ?>/"></amp-facebook-like>
                        </div>
                    <?php } else { ?>
                        <div class="fb-like follow-item" data-href="https://www.facebook.com/<?php echo $facebook_id; ?>/" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div>    
                    <?php }
                }

                if( is_twitter_follow() && $twitter_id ) { ?>
                    <div id="twitter-follow-section" class="follow-item">
                        <a class="twitter" href="//twitter.com/intent/follow?screen_name=<?php echo $twitter_id; ?>" target="_blank" title="Twitterをフォロー" rel="nofollow"><i class="fab fa-twitter" aria-hidden="true"></i>フォローする</a>
                    </div>
                <?php }

                if(is_feedly_follow()) { ?>
                    <div id="feedly-section" class="follow-item">
                        <?php echo '<a class="feedly" href="http://feedly.com/index.html#subscription%2Ffeed%2F'.home_url().'%2Ffeed"><i class="fas fa-rss-square"></i>購読する'.$feedly_count.'</a>'; ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php }