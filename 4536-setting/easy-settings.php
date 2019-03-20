<?php

/**
 *
 */
class EasySettings_4536 {

  public $design_theme = [
    '_default' => 'デフォルト',
    'white' => 'ホワイト',
    'darkblack' => 'ダークブラック',
    'seagreen' => 'シーグリーン',
    'cyan-blue' => 'シアンブルー',
    'shocking-pink' => 'ショッキングピンク',
  ];

  function __construct() {

    add_action( 'admin_init', function() {
      register_setting( 'easy_settings_group', 'theme_color_4536' );
    });

    add_action( 'admin_menu', function() {
      add_submenu_page( '4536-setting', 'かんたん設定', 'かんたん設定', 'manage_options', 'easy-settings', [$this, 'form'] );
    });

    if( isset($_POST['design_theme_submit_4536']) ) {
      update_option_4536( 'theme_color_4536' );
      $name = get_option('theme_color_4536');
      $path = __DIR__ . '/design-theme/' . $name . '.json';
      if( !file_exists($path) ) {
        add_action( 'admin_notices', function() {
          echo '<div class="error"><p>デザインテーマが見つかりませんでした。エラーを開発者に報告してください。</p></div>';
        });
        return;
      }
      ob_start();
      require_once( $path );
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
              foreach( $this->design_theme as $key => $value ) { ?>
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
