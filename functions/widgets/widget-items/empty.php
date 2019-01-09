<?php

class EmptyWidgetItem extends WP_Widget {
    function __construct() {
		parent::__construct(
			'empty_item',
			__( '(4536)空のアイテム', '4536' ),
			[ 'description' => __( '入力されたものをそのまま出力します。', '4536' ), ]
		);
	}
    function widget($args, $instance) {
        extract( $args );
        $item_new = apply_filters( 'widget_item_new', $instance['item_new'] );
        echo $item_new;
    }
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['item_new'] = $new_instance['item_new'];
        return $instance;
    }
    function form($instance) {
        $item_new = esc_attr($instance['item_new']);
    ?>
        <p>
            <textarea class="widefat" rows="10" id="<?php echo $this->get_field_id('item_new'); ?>" name="<?php echo $this->get_field_name('item_new'); ?>"><?php echo esc_textarea( $instance['item_new'] ); ?></textarea>
        </p>
        <?php
    }
}
add_action( 'widgets_init', function() { register_widget( 'EmptyWidgetItem' ); });
