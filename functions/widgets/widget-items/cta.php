<?php

class CtaWidgetItem extends WP_Widget {
    function __construct() {
        add_action('admin_enqueue_scripts', [$this, 'scripts']);
		parent::__construct(
			'cta',
			__( '(4536)CTA', '4536' )
		);
	}
    function widget($args, $instance) {
        $title = apply_filters( 'cta_title', $instance['cta_title'] );
        $src = !empty($instance['cta_image_src']) ? $instance['cta_image_src'] : '';
        $image_style = !empty( $instance['cta_image_style'] ) ? $instance['cta_image_style'] : '';
        $description = apply_filters( 'cta_description', $instance['cta_description'] );
        $button_text = apply_filters( 'cta_button_text', $instance['cta_button_text'] );
        $button_url = apply_filters( 'cta_button_url', $instance['cta_button_url'] );
        $button_text_url = apply_filters( 'cta_button_text_url', $instance['cta_button_text_url'] );
        $button_color = !empty($instance['cta_button_color']) ? ' '.$instance['cta_button_color'] : '';
        $button_reflection = !empty($instance['cta_button_reflection']) ? ' '.$instance['cta_button_reflection'] : '';
        $button_bounce = !empty($instance['cta_button_bounce']) ? ' '.$instance['cta_button_bounce'] : '';
        $button_text_shadow = !empty($instance['cta_button_text_shadow']) ? ' '.$instance['cta_button_text_shadow'] : '';
        if(!$button_text && !$button_url && !$button_text_url) return;
        echo $args['before_widget'].'<div class="cta clearfix">';
        if($title) echo '<p class="cta-title">'.$title.'</p>';
        if($src) {
            $size = get_image_width_and_height_4536($src);
            if($size['width']) $width = 'width="'.$size['width'].'"';
            if($size['height']) $height = ' height="'.$size['width'].'"';
            $thumbnail = '<figure class="cta-thumbnail text-align-center '.$image_style.'"><img src="'.$src.'" '.$width.$height.' alt /></figure>';
            echo convert_content_to_amp($thumbnail);
        }
        if($description) echo '<p class="clearfix">'.$description.'</p>';
        $text_shadow_s_tag = ($button_text_shadow) ? '<span class="text-shadow-4536">' : '' ;
        $text_shadow_e_tag = ($button_text_shadow) ? '</span>' : '' ;
        if($button_text && $button_url) {
            $button = '<div class="button-4536'.$button_color.$button_reflection.$button_bounce.'">'.$text_shadow_s_tag.
            '<a href="'.$button_url.'" target="_blank" rel="noopener">'.$button_text.'</a>'.$text_shadow_e_tag.
            '</div>';
        }
        if($button_text_url) $button = '<div class="button-4536'.$button_color.$button_reflection.$button_bounce.'">'.$text_shadow_s_tag.$button_text_url.$text_shadow_e_tag.'</div>';
        if(is_amp()) $button = convert_content_to_amp($button);
        if($button) echo $button;
        echo $args['after_widget'].'</div>';
    }
    function update($new_instance, $old_instance) {
        $instance = array();
        $instance['cta_title'] = !empty($new_instance['cta_title']) ? strip_tags($new_instance['cta_title']) : '';
        $instance['cta_image_src'] = !empty($new_instance['cta_image_src']) ? $new_instance['cta_image_src'] : '';
        $instance['cta_image_style'] = !empty($new_instance['cta_image_style']) ? $new_instance['cta_image_style'] : '';
        $instance['cta_description'] = !empty($new_instance['cta_description']) ? strip_tags($new_instance['cta_description']) : '';
        $instance['cta_button_text'] = !empty($new_instance['cta_button_text']) ? strip_tags($new_instance['cta_button_text']) : '';
        $instance['cta_button_url'] = !empty($new_instance['cta_button_url']) ? $new_instance['cta_button_url'] : '';
        $instance['cta_button_text_url'] = !empty($new_instance['cta_button_text_url']) ? $new_instance['cta_button_text_url'] : '';
        $instance['cta_button_color'] = !empty($new_instance['cta_button_color']) ? $new_instance['cta_button_color'] : '';
        $instance['cta_button_reflection'] = !empty($new_instance['cta_button_reflection']) ? $new_instance['cta_button_reflection'] : '';
        $instance['cta_button_bounce'] = !empty($new_instance['cta_button_bounce']) ? $new_instance['cta_button_bounce'] : '';
        $instance['cta_button_text_shadow'] = !empty($new_instance['cta_button_text_shadow']) ? $new_instance['cta_button_text_shadow'] : '';
        return $instance;
    }
    function form($instance) {
        $title = !empty($instance['cta_title']) ? $instance['cta_title'] : '';
        $src = !empty($instance['cta_image_src']) ? $instance['cta_image_src'] : '';
        $image_style = !empty($instance['cta_image_style']) ? $instance['cta_image_style'] : '';
        $description = !empty($instance['cta_description']) ? $instance['cta_description'] : '';
        $button_text = !empty($instance['cta_button_text']) ? $instance['cta_button_text'] : '';
        $button_url = !empty($instance['cta_button_url']) ? $instance['cta_button_url'] : '';
        $button_text_url = !empty($instance['cta_button_text_url']) ? $instance['cta_button_text_url'] : '';
        $button_color = !empty($instance['cta_button_color']) ? $instance['cta_button_color'] : '';
        $button_reflection = !empty($instance['cta_button_reflection']) ? $instance['cta_button_reflection'] : '';
        $button_bounce = !empty($instance['cta_button_bounce']) ? $instance['cta_button_bounce'] : '';
        $button_text_shadow = !empty($instance['cta_button_text_shadow']) ? $instance['cta_button_text_shadow'] : '';
        ?>
        <p>
          <label for="<?php echo $this->get_field_id( 'cta_title' ); ?>"><?php _e( 'タイトル' ); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id( 'cta_title' ); ?>" name="<?php echo $this->get_field_name( 'cta_title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'cta_image_src' ); ?>"><?php _e( '画像' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'cta_image_src' ); ?>" name="<?php echo $this->get_field_name( 'cta_image_src' ); ?>" type="text" value="<?php echo esc_url( $src ); ?>" />
            <button class="upload-image-button button button-primary">選択</button>
            <button class="delete-image-button button">削除</button>
            <img class="widefat" src="<?php echo esc_url( $src ); ?>" style="margin:1em 0;display:block;">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'cta_image_style' ); ?>"><?php _e( '画像の表示位置（PC）' ); ?></label>
            <select class='widefat' id="<?php echo $this->get_field_id('cta_image_style'); ?>"
                name="<?php echo $this->get_field_name('cta_image_style'); ?>" type="text">
              <option value='cta-image-center'<?php echo ($image_style=='cta-image-center')?'selected':''; ?>>
                  中央
              </option>
              <option value='cta-image-left'<?php echo ($image_style=='cta-image-left')?'selected':''; ?>>
                  左寄せ
              </option> 
              <option value='cta-image-right'<?php echo ($image_style=='cta-image-right')?'selected':''; ?>>
                  右寄せ
              </option> 
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('cta_description'); ?>"><?php _e( '説明文' ); ?></label>
            <textarea class="widefat" rows="5" id="<?php echo $this->get_field_id('cta_description'); ?>" name="<?php echo $this->get_field_name('cta_description'); ?>"><?php echo esc_textarea( $instance['cta_description'] ); ?></textarea>
        </p>
        <p>
          <label for="<?php echo $this->get_field_id( 'cta_button_text' ); ?>"><?php _e( 'ボタンの文字' ); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id( 'cta_button_text' ); ?>" name="<?php echo $this->get_field_name( 'cta_button_text' ); ?>" type="text" value="<?php echo esc_attr( $button_text ); ?>">
        </p>
        <p>
          <label for="<?php echo $this->get_field_id( 'cta_button_url' ); ?>"><?php _e( 'URL（リンク）' ); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id( 'cta_button_url' ); ?>" name="<?php echo $this->get_field_name( 'cta_button_url' ); ?>" type="text" value="<?php echo esc_url( $button_url ); ?>" />
        </p>
        <p>
          <label for="<?php echo $this->get_field_id( 'cta_button_text_url' ); ?>"><?php _e( 'ボタンのテキストリンク（アフィリエイトコードなど）' ); ?></label>
            <textarea class="widefat" rows="5" id="<?php echo $this->get_field_id('cta_button_text_url'); ?>" name="<?php echo $this->get_field_name('cta_button_text_url'); ?>"><?php echo esc_textarea( $instance['cta_button_text_url'] ); ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'cta_button_color' ); ?>"><?php _e( 'ボタンの色' ); ?></label>
            <select class='widefat' id="<?php echo $this->get_field_id('cta_button_color'); ?>"
                name="<?php echo $this->get_field_name('cta_button_color'); ?>" type="text">
                <option value='background-color-orange'<?php echo ($button_color=='background-color-orange')?'selected':''; ?>>
                  オレンジ
                </option>
                <option value='background-color-green'<?php echo ($button_color=='background-color-green')?'selected':''; ?>>
                  緑
                </option>
                <option value='background-color-blue'<?php echo ($button_color=='background-color-blue')?'selected':''; ?>>
                  青
                </option>
                <option value='background-color-red'<?php echo ($button_color=='background-color-red')?'selected':''; ?>>
                  赤
                </option>
            </select>
        </p>
        <p>
            <input class='widefat' id="<?php echo $this->get_field_id('cta_button_reflection'); ?>"
                name="<?php echo $this->get_field_name('cta_button_reflection'); ?>" value="is-reflection" <?php checked($button_reflection, 'is-reflection');?> type="checkbox">
            <label for="<?php echo $this->get_field_id('cta_button_reflection'); ?>"><?php _e( 'ボタンを光らせる' ); ?></label>
        </p>
        <p>
            <input class='widefat' id="<?php echo $this->get_field_id('cta_button_bounce'); ?>"
                name="<?php echo $this->get_field_name('cta_button_bounce'); ?>" value="is-bounce" <?php checked($button_bounce, 'is-bounce');?> type="checkbox">
            <label for="<?php echo $this->get_field_id('cta_button_bounce'); ?>"><?php _e( 'ボタンをバウンドさせる' ); ?></label>
        </p>
        <p>
            <input class='widefat' id="<?php echo $this->get_field_id('cta_button_text_shadow'); ?>"
                name="<?php echo $this->get_field_name('cta_button_text_shadow'); ?>" value="text-shadow" <?php checked($button_text_shadow, 'text-shadow');?> type="checkbox">
            <label for="<?php echo $this->get_field_id('cta_button_text_shadow'); ?>"><?php _e( 'ボタンの文字に影をつける' ); ?></label>
        </p>
        <?php
    }
    function scripts() {
        wp_enqueue_script( 'media-upload' );
        wp_enqueue_media();
        wp_enqueue_script('media-uploader', get_template_directory_uri() . '/functions/widgets/media-uploader.js', array('jquery'));
    }
}
add_action( 'widgets_init', function() { register_widget( 'CtaWidgetItem' ); });
