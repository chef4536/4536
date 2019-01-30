<?php

class NewEntryWidgetItem extends WP_Widget {

    public $_title = 'new_title';
    public $_count = 'new_count';
    
    function __construct() {
		parent::__construct(
			'new_post',
			__( '(4536)新着記事', '4536' ),
			[ 'description' => __( 'サムネイルありの新着記事を表示します（トップページでは非表示）', '4536' ) ]
		);
	}
    
    function widget($args, $instance) {
        extract( $args );
        $title = apply_filters( 'widget_title', empty($instance[$this->_title]) ? '新着記事' : $instance[$this->_title] );
        $count = apply_filters( 'widget_entry_count', $instance[$this->_count] );
        if(empty($count)) $count = 5;
        $new_posts = get_posts('posts_per_page='.$count);
        $line_clamp = '';
        if(line_clamp()=='2line') $line_clamp = 'line-clamp-2';
        if(line_clamp()=='3line') $line_clamp = 'line-clamp-3';
        if(!$new_posts) return;
        global $post;
        echo $args['before_widget'];
        if($title) echo $args['before_title'].$title.$args['after_title'];
        ?>
        <ul>
            <?php foreach($new_posts as $post) : setup_postdata( $post ); ?>
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
        $instance[$this->_title] = strip_tags($new_instance[$this->_title]);
        $instance[$this->_count] = strip_tags($new_instance[$this->_count]);
        return $instance;
    }
    
    function form($instance) {
        $title = $this->_title;
        $count = $this->_count;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id($title); ?>"><?php _e('新着記事のタイトル'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id($title); ?>" name="<?php echo $this->get_field_name($title); ?>" type="text" value="<?php echo esc_attr($instance[$title]); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id($count); ?>"><?php _e('表示数'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id($count); ?>" name="<?php echo $this->get_field_name($count); ?>" type="number" value="<?php echo esc_attr($instance[$count]); ?>" />
        </p>
        <?php
    }
    
}
add_action( 'widgets_init', function() { register_widget( 'NewEntryWidgetItem' ); });

//参考：https://nelog.jp/theme-widget