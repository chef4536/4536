<?php

class NewEntryWidgetItem extends WP_Widget {
    function __construct() {
		parent::__construct(
			'new_post', // Base ID
			__( '(4536)新着記事', '4536' ), // Name
			array( 'description' => __( 'サムネイルありの新着記事を表示します（トップページでは非表示）', '4536' ), ) // Args
		);
	}
    function widget($args, $instance) {
        extract( $args );
        $title_new = apply_filters( 'widget_title', empty($instance['title_new']) ? '新着記事' : $instance['title_new'] );
        $entry_count = apply_filters( 'widget_entry_count', $instance['entry_count'] );
        $g_entry_count = 5;//表示数が設定されていない時は5にする
        if ($entry_count) { //表示数が設定されているときは表示数をグローバル変数に代入
            $g_entry_count = $entry_count;
        }
        $newPosts = get_posts('posts_per_page='.$g_entry_count);
        $line_clamp = null;
        if(line_clamp()=='2line') $line_clamp = 'line-clamp-2';
        if(line_clamp()=='3line') $line_clamp = 'line-clamp-3';
        if(!$newPosts) return;
        global $post;
        echo $args['before_widget'];
        if($title_new) echo $args['before_title'].$title_new.$args['after_title'];
        ?>
        <ul>
            <?php foreach($newPosts as $post) : setup_postdata( $post ); ?>
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
            ?>
        </ul>
        <?php
        echo $args['after_widget'];
    }
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title_new'] = strip_tags($new_instance['title_new']);
        $str = mb_convert_kana(strip_tags($new_instance['entry_count']), 'n');
        $instance['entry_count'] = $str;
        return $instance;
    }
    function form($instance) {
        $title_new = esc_attr($instance['title_new']);
        $entry_count = esc_attr($instance['entry_count']);
        ?>
        <p>
          <label for="<?php echo $this->get_field_id('title_new'); ?>">
          <?php _e('新着記事のタイトル'); ?>
          </label>
          <input class="widefat" id="<?php echo $this->get_field_id('title_new'); ?>" name="<?php echo $this->get_field_name('title_new'); ?>" type="text" value="<?php echo $title_new; ?>" />
        </p>
        <?php //表示数入力フォーム ?>
        <p>
          <label for="<?php echo $this->get_field_id('entry_count'); ?>">
          <?php _e('表示数'); ?>
          </label>
          <input class="widefat" id="<?php echo $this->get_field_id('entry_count'); ?>" name="<?php echo $this->get_field_name('entry_count'); ?>" type="text" value="<?php echo $entry_count; ?>" />
        </p>
        <?php
    }
}
add_action( 'widgets_init', function() { register_widget( 'NewEntryWidgetItem' ); });

//参考：https://nelog.jp/theme-widget