<?php

class Widget_Style_Setting_4536 {

  public $widget_color_list = [
      'widget_background_color' => '背景色',
      'widget_font_color' => '文字の色',
  ];
  public $is_widget_color = [
      'is_widget_background_color' => '',
      'is_widget_font_color' => '',
  ];
  public $widget_style = [
      null => 'デフォルト',
      'widget-style-box-4536' => 'ボックス',
  ];

  function __construct() {
		add_filter( 'in_widget_form_4536', [ $this, 'form' ], 10, 4 );
    add_filter( 'widget_update_callback', [ $this, 'save_settings' ], 20, 4 );
    add_filter( 'dynamic_sidebar_params', [ $this, 'widget_custom' ] );
	}

  function form( $form, $widget, $return, $instance ) { ?>
    <p>
      <label for="<?php echo $widget->get_field_id('widget_style'); ?>"><?php _e('ウィジェットのスタイル'); ?></label>
      <select class='widefat' id="<?php echo $widget->get_field_id('widget_style'); ?>" name="<?php echo $widget->get_field_name('widget_style'); ?>" type="text">
        <?php
        $widget_style = $this->widget_style;
        foreach($widget_style as $display => $description) { ?>
          <option value='<?php echo $display; ?>'<?php echo ($instance['widget_style']==$display)?'selected':''; ?>>
            <?php echo $description; ?>
          </option>
        <?php } ?>
      </select>
    </p>
    <?php foreach( $this->widget_color_list as $name => $description ) { //ウィジェットの色設定 ?>
      <p>
        <input type="checkbox" class="widefat" id="<?php echo $widget->get_field_id('is_'.$name); ?>" name="<?php echo $widget->get_field_name('is_'.$name); ?>" <?php checked($instance['is_'.$name], 1);?> value="1" />
        <label for="<?php echo $widget->get_field_id('is_'.$name); ?>"><?php _e($description.'を指定する'); ?></label>
        <input type="color" class="widefat" id="<?php echo $widget->get_field_id($name); ?>" name="<?php echo $widget->get_field_name($name); ?>" value="<?php echo $instance[$name]; ?>" />
      </p>
    <?php }
  }

  function save_settings( $instance, $new_instance, $old_instance, $object ) {
    $list = $this->widget_color_list;
    $list += $this->is_widget_color;
    $list['widget_style'] = '';
    foreach( $list as $type => $name ) {
      $instance[$type] = !empty($new_instance[$type]) ? $new_instance[$type] : '';
    }
    return $instance;
  }

  //参考：https://gist.github.com/CEscorcio/5669905
  function widget_custom($params) {
    global $wp_registered_widgets;
    $widget_id = $params[0]['widget_id'];
    $widget_obj = $wp_registered_widgets[$widget_id];
    $widget_opt = get_option($widget_obj['callback'][0]->option_name);
    $widget_num = $widget_obj['params'][0]['number'];
    $widget_style = $widget_opt[$widget_num]['widget_style'];
    if($widget_style) $params[0]['before_widget'] = preg_replace( '/class="(.*?)"/', 'class="$1 '.$widget_style.'"', $params[0]['before_widget'], 1 );
    return $params;
  }

}
new Widget_Style_Setting_4536();
