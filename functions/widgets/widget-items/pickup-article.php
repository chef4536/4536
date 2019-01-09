<?php

class PickupPostWidgetItem extends WP_Widget {
    function __construct() {
		parent::__construct(
			'pickup_post', // Base ID
			__( '(4536)ピックアップ記事', '4536' ), // Name
			array( 'description' => __( '「pickup-widget」のタグがある記事をサムネイルありで表示します', '4536' ), ) // Args
		);
	}
    function widget($args, $instance) {
        extract( $args );
        $title_new = apply_filters( 'widget_title', empty($instance['title_new']) ? 'ピックアップ記事' : $instance['title_new'] );
        $pickup_count = apply_filters( 'widget_pickup_count', $instance['pickup_count'] );
        global $post;
        $g_pickup_count = 5;//表示数が設定されていない時は5にする
        if ($pickup_count) { //表示数が設定されているときは表示数をグローバル変数に代入
            $g_pickup_count = $pickup_count;
        }
        $default = [
            'posts_per_page' => $g_pickup_count,
            'orderby' => 'relevance',
            'post__not_in' => [$post->ID],
            'tag' => [
                'pickup-sidebar',
                'pickup-widget',
            ]
        ];
        $line_clamp = null;
        if(line_clamp()=='2line') $line_clamp = 'line-clamp-2';
        if(line_clamp()=='3line') $line_clamp = 'line-clamp-3';
        $pickupPosts = get_posts($default);
        if(!$pickupPosts) return;
        echo $args['before_widget'];
        if($title_new) echo $args['before_title'].$title_new.$args['after_title'];
        echo '<ul>';
        foreach($pickupPosts as $post) : setup_postdata( $post ); ?>
            <li class="post-list">
                <a class="clearfix" href="<?php the_permalink(); ?>">
                    <?php echo thumbnail_4536('widget')['thumbnail']; ?>
                    <div class="post-info">
                        <p class="post-title <?php echo $line_clamp; ?>"><?php the_title(); ?></p>
                    </div>
                </a>
            </li>
        <?php
        endforeach;
        wp_reset_postdata();
        echo '</ul>';
        echo $args['after_widget'];
    }
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title_new'] = strip_tags($new_instance['title_new']);
        $str = mb_convert_kana(strip_tags($new_instance['pickup_count']), 'n');
        $instance['pickup_count'] = $str;
        return $instance;
    }
    function form($instance) {
        $title_new = esc_attr($instance['title_new']);
        $pickup_count = esc_attr($instance['pickup_count']);
        ?>
        <p>
          <label for="<?php echo $this->get_field_id('title_new'); ?>">
          <?php _e('ピックアップ記事のタイトル'); ?>
          </label>
          <input class="widefat" id="<?php echo $this->get_field_id('title_new'); ?>" name="<?php echo $this->get_field_name('title_new'); ?>" type="text" value="<?php echo $title_new; ?>" />
        </p>
        <?php //表示数入力フォーム ?>
        <p>
          <label for="<?php echo $this->get_field_id('pickup_count'); ?>">
          <?php _e('表示数'); ?>
          </label>
          <input class="widefat" id="<?php echo $this->get_field_id('pickup_count'); ?>" name="<?php echo $this->get_field_name('pickup_count'); ?>" type="text" value="<?php echo $pickup_count; ?>" />
        </p>
        <?php
    }
}
add_action( 'widgets_init', function() { register_widget( 'PickupPostWidgetItem' ); });
