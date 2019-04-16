<?php

class CtaWidgetItem extends WP_Widget {

  public $button_parts = [
    'title',
    'src',
    'background_image',
    'background_attachment',
    'image_style',
    'description',
    'button_text',
    'button_url',
    'button_text_url',
  ];

  public $button_args = [
    'button_color',
    'button_reflection',
    'button_bounce',
    'button_text_shadow',
  ];

  function __construct() {
    add_action( 'admin_enqueue_scripts', [$this, 'scripts'] );
    add_filter( 'inline_style_4536', [ $this, 'css' ] );
		parent::__construct(
			'cta',
			__( '(4536)CTA', '4536' )
		);
	}

  function widget( $args, $instance ) {
    foreach( $this->button_parts as $key ) {
      ${$key} = !empty( $instance[$key] ) ? $instance[$key] : '';
    }
    $title = apply_filters( 'widget_title', $title );
    $button_args = [];
    $button_args[] = 'button-4536';
    foreach( $this->button_args as $key ) {
      if( !empty( $instance[$key] ) ) $button_args[] = $instance[$key];
    }
    $button_args = implode( ' ', $button_args );
    if( empty($button_text) && empty($button_url) && empty($button_text_url) ) return;
    $wrap = preg_replace( '/class="/', 'class="cta clearfix display-flex ', $args['before_widget'], 1 );
    $wrap = str_replace( 'widget-4536', 'widget-4536 flex-1', $wrap );
    echo $wrap;
    if( !empty( $title ) ) echo '<p class="cta-title text-align-center margin-1_5em-auto bold-4536 font-size-24px line-height-1_6">'.$title.'</p>';
    if( !empty( $src ) ) {
      $image_margin = ( $image_style !== 'aligncenter' ) ? ' max-width-half-pc' : '';
      $size = get_image_width_and_height_4536( $src );
      if( !empty( $size['width'] ) ) $width = 'width="'.$size['width'].'"';
      if( !empty( $size['height'] ) ) $height = ' height="'.$size['width'].'"';
      $thumbnail = '<figure class="cta-image text-align-center '.$image_style.$image_margin. '"><img src="'.$src.'" '.$width.$height.' alt /></figure>';
      echo convert_content_to_amp( $thumbnail );
    }
    if( !empty( $description ) ) {
      $description_class = empty( $src ) ? ' text-align-center' : '';
      echo '<p class="clearfix margin-1_5em-auto line-height-1_4' . $description_class . '">' . $description . '</p>';
    }
    if( !empty( $button_text ) && !empty( $button_url ) ) {
      $button = '<div class="' . $button_args . '"><a href="'.$button_url.'" target="_blank" rel="noopener">'.$button_text.'</a></div>';
    }
    if( !empty( $button_text_url ) ) $button = '<div class="' . $button_args . '">' . $button_text_url . '</div>';
    if( !empty( $button ) ) echo convert_content_to_amp( $button );
    echo $args['after_widget'];
  }

  function update( $new_instance, $old_instance ) {
    foreach( $this->button_parts as $key ) {
      $instance[$key] = !empty( $new_instance[$key] ) ? $new_instance[$key] : '';
    }
    foreach( $this->button_args as $key ) {
      $instance[$key] = !empty( $new_instance[$key] ) ? $new_instance[$key] : '';
    }
    return $instance;
  }

  function form( $instance ) { ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'タイトル' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'src' ); ?>"><?php _e( '画像' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'src' ); ?>" name="<?php echo $this->get_field_name( 'src' ); ?>" type="text" value="<?php echo esc_url( $instance['src'] ); ?>" />
      <button class="upload-image-button button button-primary">選択</button>
      <button class="delete-image-button button">削除</button>
      <img class="widefat" src="<?php echo esc_url( $instance['src'] ); ?>" style="margin:1em 0;display:block;">
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'image_style' ); ?>"><?php _e( '画像の表示位置（PC）' ); ?></label>
      <select class="widefat" id="<?php echo $this->get_field_id('image_style'); ?>" name="<?php echo $this->get_field_name('image_style'); ?>" type="text">
        <?php
        $arr = [
          'aligncenter' => '中央',
          'alignleft' => '左寄せ',
          'alignright' => '右寄せ',
        ];
        foreach( $arr as $key => $value ) {
          $selected = $instance['image_style'] === $key ? ' selected' : '';
          echo '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
        } ?>
      </select>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('description'); ?>"><?php _e( '説明文' ); ?></label>
      <textarea class="widefat" rows="5" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>"><?php echo esc_textarea( $instance['description'] ); ?></textarea>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'background_image' ); ?>"><?php _e( '背景画像' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'background_image' ); ?>" name="<?php echo $this->get_field_name( 'background_image' ); ?>" type="text" value="<?php echo esc_url( $instance['background_image'] ); ?>" />
      <button class="upload-image-button button button-primary">選択</button>
      <button class="delete-image-button button">削除</button>
      <img class="widefat" src="<?php echo esc_url( $instance['background_image'] ); ?>" style="margin:1em 0;display:block">
    </p>
    <p><label><input class="widefat" name="<?php echo $this->get_field_name('background_attachment'); ?>" value="fixed" <?php checked($instance['background_attachment'], 'fixed');?> type="checkbox"><?php _e( '背景画像を固定する' ); ?></label></p>
    <p>
      <label for="<?php echo $this->get_field_id( 'button_text' ); ?>"><?php _e( 'ボタンの文字' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" type="text" value="<?php echo esc_attr( $instance['button_text'] ); ?>" placeholder="例：詳細はこちら" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'button_url' ); ?>"><?php _e( 'URL（リンク）' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'button_url' ); ?>" name="<?php echo $this->get_field_name( 'button_url' ); ?>" type="text" value="<?php echo esc_url( $instance['button_url'] ); ?>" placeholder="例：https://example.com" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'button_text_url' ); ?>"><?php _e( 'ボタンのテキストリンク' ); ?></label>
      <?php $placeholder = 'アフィリエイトのコードなどを貼り付けてください。ここに入力されたものがボタンとして優先的に使われます。'; ?>
      <textarea class="widefat" rows="5" id="<?php echo $this->get_field_id('button_text_url'); ?>" name="<?php echo $this->get_field_name('button_text_url'); ?>" placeholder="<?php echo $placeholder; ?>"><?php echo esc_textarea( $instance['button_text_url'] ); ?></textarea>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'button_color' ); ?>"><?php _e( 'ボタンの色' ); ?></label>
      <select class="widefat" id="<?php echo $this->get_field_id('button_color'); ?>" name="<?php echo $this->get_field_name('button_color'); ?>" type="text">
        <?php
        $arr = [
          'background-color-orange' => 'オレンジ',
          'background-color-green' => '緑',
          'background-color-blue' => '青',
          'background-color-red' => '赤',
          'background-color-black' => '黒',
        ];
        foreach( $arr as $key => $value ) {
          $selected = $instance['button_color'] === $key ? ' selected' : '';
          echo '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
        } ?>
      </select>
    </p>
    <p>
      <label><input class="widefat" name="<?php echo $this->get_field_name('button_reflection'); ?>" value="is-reflection" <?php checked($instance['button_reflection'], 'is-reflection');?> type="checkbox"><?php _e( 'ボタンを光らせる' ); ?></label>
    </p>
    <p>
      <label><input class="widefat" name="<?php echo $this->get_field_name('button_bounce'); ?>" value="is-bounce" <?php checked($instance['button_bounce'], 'is-bounce');?> type="checkbox"><?php _e( 'ボタンをバウンドさせる' ); ?></label>
    </p>
    <p>
      <label><input class="widefat" name="<?php echo $this->get_field_name('button_text_shadow'); ?>" value="text-shadow-4536" <?php checked($instance['button_text_shadow'], 'text-shadow-4536');?> type="checkbox"><?php _e( 'ボタンの文字に影をつける' ); ?></label>
    </p>
    <?php
  }

  function scripts() {
    wp_enqueue_script( 'media-upload' );
    wp_enqueue_media();
    wp_enqueue_script( 'media-uploader', get_template_directory_uri() . '/functions/widgets/media-uploader.js', ['jquery'] );
  }

  function css( $css ) {
    global $wp_registered_widgets;
    foreach( wp_get_sidebars_widgets() as $int => $ids ) {
      foreach( $ids as $int => $id ) {
        $widget_obj = $wp_registered_widgets[$id];
        $num = preg_replace( '/.*?-(\d)/', '$1', $id );
        $widget_opt = get_option($widget_obj['callback'][0]->option_name);
        $src = $widget_opt[$num]['background_image'];
        if( empty( $src ) ) continue;
        $background_image = 'background-image:url(' . $src . ')';
        $attachment = $widget_opt[$num]['background_attachment'];
        if( !empty( $attachment ) ) $background_image .= ';background-attachment:' . $attachment;
        $class = '.'.$id;
        $css[] = $class.'{' . $background_image . '}';
      }
    }
    return $css;
  }

}
add_action( 'widgets_init', function() { register_widget( 'CtaWidgetItem' ); });
