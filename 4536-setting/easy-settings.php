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

    if( isset($_POST['design_theme_submit_4536']) ) {
      update_option_4536( 'theme_color_4536' );
      switch( get_option('theme_color_4536') ) {
        case 'white':
          $name = 'white';
          break;
        case 'dark':
          $name = 'dark';
          break;
        default:
          $name = '_default';
          break;
      }
      ob_start();
      require_once( 'design-theme/' . $name . '.json' );
      $json = ob_get_clean();
      $array = json_decode( $json );
      foreach( $array as $key => $value ) {
        set_theme_mod( $key, $value );
      }
      set_theme_mod( 'h1_style', null );
      set_theme_mod( 'h2_style', 'simple1' );
      set_theme_mod( 'h3_style', 'simple2' );
      set_theme_mod( 'h4_style', 'simple3' );
      set_theme_mod( 'related_post_title_style', 'simple1' );
      set_theme_mod( 'sidebar_widget_title_style', 'simple1' );
      add_action( 'admin_notices', function() {
        echo '<div class="updated"><p>変更を保存しました。</p></div>';
      });
    }

  }

  function form() { ?>

    <div class="wrap">

      <h2>かんたん設定</h2>

      <form method="post" action="">

        <?php settings_fields( 'easy_settings_group' ); do_settings_sections( 'easy_settings_group' ); ?>

        <!-- デザインテーマ  -->
        <div class="metabox-holder">
          <div class="postbox" >
            <h3 class="hndle">デザインテーマ</h3>
            <div class="inside">
              <?php
              $theme_color = [
                'default' => 'デフォルト',
                'white' => 'ホワイト',
                'dark' => 'ダーク',
              ];
              foreach( $theme_color as $key => $value ) { ?>
                <p><label><input type="radio" name="theme_color_4536" value="<?php echo $key; ?>" <?php checked(get_option('theme_color_4536'), $key);?> /><?php echo $value; ?></label></p>
              <?php } ?>
              <p><?php submit_button( 'デザインテーマを変更する', 'primary large', 'design_theme_submit_4536', $wrap, $other_attributes ); ?></p>
            </div>
          </div>
        </div>

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
