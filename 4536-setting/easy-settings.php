<?php

/**
 *
 */
class EasySettings_4536 {

  function __construct() {

    add_action( 'admin_init', function() {
      // $array_master = [];
      // foreach( $array_master as $key => $value ) {
      //   register_setting( 'easy_settings_group', $key );
      // }
      register_setting( 'easy_settings_group', 'theme_color_4536' );
    });

    add_action( 'admin_menu', function() {
      add_submenu_page( '4536-setting', 'かんたん設定', 'かんたん設定', 'manage_options', 'easy-settings', [$this, 'form'] );
    });

    if( isset($_POST['theme_color_submit_4536']) ) {
      update_option_4536( 'theme_color_4536' );
      switch( get_option('theme_color_4536') ) {
        case 'dark':
          $this->theme_color_change( '#1a263d', '333333', '#ffffff' );
          break;
        default:
          $this->theme_color_change( '#ffffff', 'e6ecf0', '#333333' );
          break;
      }
      add_action( 'admin_notices', function() {
        echo '<div class="updated"><p>変更を保存しました。</p></div>';
      });
    }

  }

  function theme_color_change( $key_color, $bgc_color, $font_color, $sub_color = null ) {
    // if( $sub_color === null ) $sub_color = $key_color;
    set_theme_mod( 'background_color', $bgc_color );
    set_theme_mod( 'header_background_color', $key_color );
    set_theme_mod( 'header_color', $font_color );
    set_theme_mod( 'post_background_color', $key_color );
    set_theme_mod( 'post_color', $font_color );
  }

  function form() { ?>

    <div class="wrap">

      <h2>かんたん設定</h2>

      <form method="post" action="">

        <?php settings_fields( 'easy_settings_group' ); do_settings_sections( 'easy_settings_group' ); ?>

        <!-- テーマカラー  -->
        <div class="metabox-holder">
          <div class="postbox" >
            <h3 class="hndle">テーマカラー</h3>
            <div class="inside">
              <?php
              $theme_color = [
                'default' => 'デフォルト',
                'dark' => 'ダークモード',
              ];
              foreach( $theme_color as $key => $value ) { ?>
                <p><label><input type="radio" name="theme_color_4536" value="<?php echo $key; ?>" <?php checked(get_option('theme_color_4536'), $key);?> /><?php echo $value; ?></label></p>
              <?php } ?>
            </div>
          </div>
        </div>

        <p><?php submit_button( '変更を保存する', 'primary large', 'theme_color_submit_4536', $wrap, $other_attributes ); ?></p>

      </form>

      <style>
        .far,.fas {
            margin-right: 5px;
        }
      </style>

    </div>

  <?php }

}
new EasySettings_4536();
