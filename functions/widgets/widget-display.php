<?php

class Widget_Display_4536 {
    
    public $list_default = [
        'widget_display_post_id' => '投稿記事',
        'widget_display_page_id' => '固定ページ',
        'widget_display_cat_id' => 'カテゴリー',
        'widget_display_all' => '全体',
    ];
    public $page_type_list = [
        'widget_display_home' => 'トップページ',
        'widget_display_pc' => 'PC（タブレット）ページ',
        'widget_display_mobile' => 'モバイル（スマホ）ページ',
        'widget_display_single' => '投稿記事',
        'widget_display_page' => '固定ページ',
        'widget_display_category' => 'カテゴリーページ',
        'widget_display_tag' => 'タグページ',
        'widget_display_search' => '検索結果ページ',
        'widget_display_404' => '404ページ',
        'widget_display_ios' => 'iOSデバイス',
        'widget_display_android' => 'Androidデバイス',
        'widget_display_mac' => 'Mac',
        'widget_display_windows' => 'Windows',
        'widget_display_windows_phone' => 'Windows Phone',
    ];
    public $widget_color_list = [
        'widget_background_color' => '背景色',
        'widget_font_color' => '文字の色',
    ];
    public $is_widget_color = [
        'is_widget_background_color' => '',
        'is_widget_font_color' => '',
    ];
    public $widget_display = [
        null => '条件を適用しない（本来の動作）',
        'show_widget' => '指定ページだけに表示する',
        'hide_widget' => '指定ページ以外で表示する',
    ];
    public $widget_style = [
        null => 'デフォルト',
        'widget-style-box-4536' => 'ボックス',
    ];
    
    function __construct() {
		if(is_admin()) {
			add_action( 'in_widget_form', [ $this, 'form' ], 10, 3 );
            add_filter( 'widget_update_callback', [ $this, 'save_settings' ], 20, 4 );
            add_filter( 'admin_head', [ $this, 'button' ] );
            add_filter( 'admin_head', [ $this, 'all_check' ] );
		} else {
            add_filter( 'widget_display_callback', [ $this, 'widget_display' ], 999, 3 );
            add_filter( 'dynamic_sidebar_params', [ $this, 'widget_custom' ] );
        }
	}

    function form( $widget, $return, $instance ) { ?>
        <div class="widget-display-setting-area-4536" style="display:none;">
            <div class="tabs">
                <span style="display:block">表示条件</span>
                <?php
                $list = $this->list_default;
                foreach($list as $type => $name) {
                    $check = ($type==='widget_display_post_id') ? 'checked' : '';
                    ?>
                    <input id="widget_display_setting-<?php echo $widget->get_field_id($type);?>" type="radio" name="tab_item" <?php echo $check; ?>>
                    <label class="tab-item" for="widget_display_setting-<?php echo $widget->get_field_id($type);?>"><?php echo $name; ?></label>
                <?php }
                $list_tab_content = [
                    'widget_display_post_id' => '投稿記事',
                    'widget_display_page_id' => '固定ページ',
                ];
                foreach($list_tab_content as $type => $name) { ?>
                <div class="tab_content" id="<?php echo $widget->get_field_id($type);?>-content">
                    <p>
                        <label for="<?php echo $widget->get_field_id($type); ?>"><?php _e($name.'のIDもしくはスラッグ'); ?></label>
                        <input type="text" class="widefat" id="<?php echo $widget->get_field_id($type); ?>" name="<?php echo $widget->get_field_name($type); ?>" value="<?php echo esc_attr($instance[$type]); ?>" placeholder="例：12,864,contact,profile" />
                    </p>
                </div>
                <?php } ?>
                <div class="tab_content" id="<?php echo $widget->get_field_id('widget_display_cat_id');?>-content">
                    <div class="category-all-check">
                        <input type="checkbox" class="widefat" id="<?php echo $widget->get_field_id('widget_display_category_all_check'); ?>" name="<?php echo $widget->get_field_name('widget_display_category_all_check'); ?>" <?php checked($instance['widget_display_category_all_check'], 1);?> value="1" />
                        <label class="button" for="<?php echo $widget->get_field_id('widget_display_category_all_check'); ?>">すべて選択</label>
                    </div>
                    <?php
                    $defaults = array( 'widget_display_cat_id' => array() );
                    $instance = wp_parse_args( (array) $instance, $defaults );    
                    $walker = new Walker_Category_Checklist_Widget (
                        $widget->get_field_name( 'widget_display_cat_id' ),
                        $widget->get_field_id( 'widget_display_cat_id' )
                    );
                    echo '<ul>';
                    wp_category_checklist( 0, 0, $instance['widget_display_cat_id'], FALSE, $walker, FALSE );
                    echo '</ul>';
                    ?>
                </div>
                <div class="tab_content" id="<?php echo $widget->get_field_id('widget_display_all');?>-content">
                    <div class="post-type-all-check">
                        <input type="checkbox" class="widefat" id="<?php echo $widget->get_field_id('widget_display_post_type_all_check'); ?>" name="<?php echo $widget->get_field_name('widget_display_post_type_all_check'); ?>" <?php checked($instance['widget_display_post_type_all_check'], 1);?> value="1" />
                        <label class="button" for="<?php echo $widget->get_field_id('widget_display_post_type_all_check'); ?>">すべて選択</label>
                    </div>
                    <ul>
                    <?php
                    $page_type_list = $this->page_type_list;
                    foreach($page_type_list as $type => $name) { ?>
                        <li>
                            <input type="checkbox" class="widefat" id="<?php echo $widget->get_field_id($type); ?>" name="<?php echo $widget->get_field_name($type); ?>" <?php checked($instance[$type], 1);?> value="1" />
                            <label for="<?php echo $widget->get_field_id($type); ?>"><?php echo $name; ?></label>
                        </li>
                    <?php } ?>
                    </ul>
                </div>                
            </div>
            <p>
                <label for="<?php echo $widget->get_field_id('widget_display'); ?>"><?php _e('表示設定'); ?></label>
                <select class='widefat' id="<?php echo $widget->get_field_id('widget_display'); ?>"
                    name="<?php echo $widget->get_field_name('widget_display'); ?>" type="text">
                    <?php
                    $widget_display = $this->widget_display;
                    foreach($widget_display as $display => $description) { ?>
                        <option value='<?php echo $display; ?>'<?php echo ($instance['widget_display']==$display)?'selected':''; ?>>
                            <?php echo $description; ?>
                        </option>
                    <?php } ?>
                </select>
            </p>
            <p>
                <label for="<?php echo $widget->get_field_id('widget_style'); ?>"><?php _e('ウィジェットのスタイル'); ?></label>
                <select class='widefat' id="<?php echo $widget->get_field_id('widget_style'); ?>"
                    name="<?php echo $widget->get_field_name('widget_style'); ?>" type="text">
                    <?php
                    $widget_style = $this->widget_style;
                    foreach($widget_style as $display => $description) { ?>
                        <option value='<?php echo $display; ?>'<?php echo ($instance['widget_style']==$display)?'selected':''; ?>>
                            <?php echo $description; ?>
                        </option>
                    <?php } ?>
                </select>
            </p>
            <?php // ウィジェットの色設定
            foreach($this->widget_color_list as $name => $description) { ?>
                <p>
                    <input type="checkbox" class="widefat" id="<?php echo $widget->get_field_id('is_'.$name); ?>" name="<?php echo $widget->get_field_name('is_'.$name); ?>" <?php checked($instance['is_'.$name], 1);?> value="1" />
                    <label for="<?php echo $widget->get_field_id('is_'.$name); ?>"><?php _e($description.'を指定する'); ?></label>
                    <input type="color" class="widefat" id="<?php echo $widget->get_field_id($name); ?>" name="<?php echo $widget->get_field_name($name); ?>" value="<?php echo $instance[$name]; ?>" />
                </p>
            <?php } ?>
        </div>
        <?php
        // 参考：https://wp-works.net/how-to-get-id-number-of-added-widget-in-javascript-with-php/
        if($widget->number=='__i__') {
            foreach( $widget->get_settings() as $index => $settings ) {
                $widget_number = intval($index);
            }
            $widget->number = intval($widget_number) + 1;
            $widget->id = str_replace('__i__', $widget->number, $widget->id);
        } ?>
        <style>
            <?php
            foreach($list as $type => $name) { ?>
                #widget_display_setting-<?php echo $widget->get_field_id($type);?>:checked ~ #<?php echo $widget->get_field_id($type);?>-content {
                    display: block;
                }
            <?php } ?>
        </style>
    <?php }

    function save_settings( $instance, $new_instance, $old_instance, $object ) {
        $list = $this->list_default;
        $list += $this->page_type_list;
        $list += $this->widget_color_list;
        $list += $this->is_widget_color;
        $list['widget_display_category_all_check'] = '';
        $list['widget_display_post_type_all_check'] = '';
        $list['widget_display'] = '';
        $list['widget_style'] = '';
        foreach($list as $type => $name) {
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

    function widget_display($instance, $widget, $args) {
        $post_id = $instance['widget_display_post_id'];
        $post_id = explode(',', $post_id);
        $page_id = $instance['widget_display_page_id'];
        $page_id = explode(',', $page_id);
        $cat_id = $instance['widget_display_cat_id'];
        $single = ($post_id) ? is_single($post_id) : '';
        $page = ($page_id) ? is_page($page_id) : '';
        $cat = ($cat_id) ? in_category($cat_id) : '';
        $cat_child = ($cat_id) ? post_is_in_descendant_category_4536($cat_id) : '';
        $home = ($instance['widget_display_home']) ? is_home() : '';
        $pc = ($instance['widget_display_pc']) ? !is_mobile() : '';
        $mobile = ($instance['widget_display_mobile']) ? is_mobile() : '';
        $is_single = ($instance['widget_display_single']) ? is_single() : '';
        $is_page = ($instance['widget_display_page']) ? is_page() : '';
        $is_cat = ($instance['widget_display_category']) ? is_category() : '';
        $is_tag = ($instance['widget_display_tag']) ? is_tag() : '';
        $is_search = ($instance['widget_display_search']) ? is_search() : '';
        $is_404 = ($instance['widget_display_404']) ? is_404() : '';
        $is_ios = ($instance['widget_display_ios']) ? is_ios_4536() : '';
        $is_android = ($instance['widget_display_android']) ? is_android_4536() : '';
        $is_mac = ($instance['widget_display_mac']) ? is_macintosh_4536() : '';
        $is_windows = ($instance['widget_display_windows']) ? is_windows_4536() : '';
        $is_windows_phone = ($instance['widget_display_windows_phone']) ? is_windows_phone_4536() : '';
        if($instance['widget_display']==='show_widget') {
            if(!$single
               && !$page
               && !$cat
               && !$cat_child
               && !$home
               && !$is_single
               && !$is_page
               && !$is_cat
               && !$is_tag
               && !$is_search
               && !$is_404
               ) $instance = false;
            if(!$pc
               && !$mobile
               && !$is_ios
               && !$is_android
               && !$is_mac
               && !$is_windows
               && !$is_windows_phone
              ) $instance = false;
            return $instance;
        }
        if($instance['widget_display']==='hide_widget') {
            if($single
               || $page
               || $cat
               || $cat_child
               || $home
               || $is_single
               || $is_page
               || $is_cat
               || $is_tag
               || $is_search
               || $is_404
               ) $instance = false;
            if($pc
               || $mobile
               || $is_ios
               || $is_android
               || $is_mac
               || $is_windows
               || $is_windows_phone
               ) $instance = false;
            return $instance;
        }
        return $instance;
    }

    function button() { ?>
        <script>
            $(function() {
                $('.widget-control-actions').each(function() {
                    var button = $( '<input>' );
                    button.addClass( 'widget-display-button-4536 button' )
                        .attr({
                            'type' : 'button',
                            'name' : 'widget_display_button_4536',
                            'value' : '設定'
                        })
                        .css({
                            'margin-right':'5px'
                        });
                    button.prependTo( $(this).find('.alignright') );
                    $(this).find('.spinner').css('float','left');
                });
            });
            $(function() {
                $(document).on( 'click', '.widget-display-button-4536', function() {
                    var setting_area = $(this).closest('.widget-inside').find('.widget-display-setting-area-4536');
                    if(setting_area.css('display')=='none') {
                        setting_area.fadeIn();
                    } else {
                        setting_area.hide();
                    }
                });
            });
        </script>
    <?php }
    
    function all_check() { ?>
        <script>
            $(function() {
                $(document).on('click', '.category-all-check input,.category-all-check label', function() {
                    var items = $(this).closest('.category-all-check').next().find('input');
                    if($(this).is(':checked')) {
                        $(items).prop('checked', true);
                    } else {
                        $(items).prop('checked', false);
                    }
                });
                $(document).on('click', '.post-type-all-check input,.post-type-all-check label', function() {
                    var items = $(this).closest('.post-type-all-check').next().find('input');
                    if($(this).is(':checked')) {
                        $(items).prop('checked', true);
                    } else {
                        $(items).prop('checked', false);
                    }
                });
            });
        </script>
        <style>
            .category-all-check input,.post-type-all-check input {
                display: none;
            }
            .category-all-check,.post-type-all-check {
                margin-top: 1em;
            }
        </style>
    <?php }
    
}
new Widget_Display_4536();

// 参考ページ：https://wordpress.stackexchange.com/questions/124772/using-wp-category-checklist-in-a-widget
require_once ABSPATH . 'wp-admin/includes/template.php';
class Walker_Category_Checklist_Widget extends Walker_Category_Checklist {

    private $name;
    private $id;

    function __construct( $name = '', $id = '' ) {
        $this->name = $name;
        $this->id = $id;
    }

    function start_el( &$output, $cat, $depth = 0, $args = array(), $id = 0 ) {
        extract( $args );
        if ( empty( $taxonomy ) ) $taxonomy = 'category';
        $class = ' class="category-list"';
        $id = $this->id . '-' . $cat->term_id;
        $checked = checked( in_array( $cat->term_id, $selected_cats ), true, false );
        $output .= "\n<li id='{$taxonomy}-{$cat->term_id}'$class>" 
            . '<label class="selectit"><input value="' 
            . $cat->term_id . '" type="checkbox" name="' . $this->name 
            . '[]" id="in-'. $id . '"' . $checked 
            . disabled( empty( $args['disabled'] ), false, false ) . ' /> ' 
            . esc_html( apply_filters( 'the_category', $cat->name ) ) 
            . '</label>';
      }
}