<?php
/**
 *
 */
class EasySettings_4536 {

  public $design_theme = [
    '_default' => 'デフォルト',
    'white' => 'ホワイト',
    'dark-black' => 'ダークブラック',
    'sea-green' => 'シーグリーン',
    'cyan-blue' => 'シアンブルー',
    'deep-pink' => 'ディープピンク',
  ];

  function __construct() {
    add_action( 'admin_init', function() {
      register_setting( 'design_theme_group', 'design_theme_4536' );
    });
    add_action( 'admin_menu', function() {
      add_submenu_page( '4536-setting', 'デザインテーマ', 'デザインテーマ', 'manage_options', 'design-theme', [$this, 'form'] );
    });
    if( isset( $_POST['design_theme_submit_4536'] ) ) {
      update_option_4536( 'design_theme_4536' );
      $name = get_option( 'design_theme_4536' );
      $path = TEMPLATEPATH . '/design-theme/' . $name . '.json';
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

      <h2>デザインテーマ</h2>

      <form method="post" action="">

        <?php settings_fields( 'design_theme_group' ); do_settings_sections( 'design_theme_group' ); ?>

        <!-- デザインテーマ  -->
        <div class="metabox-holder">
          <div class="postbox" >
            <h3 class="hndle">デザインテーマ一覧</h3>
            <div class="inside">
              <?php
              foreach( $this->design_theme as $key => $value ) { ?>
                <p><label><input type="radio" name="design_theme_4536" value="<?php echo $key; ?>" <?php checked(get_option('design_theme_4536'), $key);?> /><?php echo $value; ?></label></p>
              <?php } ?>
              <p><?php submit_button( 'デザインテーマを変更する', 'primary large', 'design_theme_submit_4536', $wrap, $other_attributes ); ?></p>
            </div>
          </div>
        </div>

        <p><small>※デザインテーマは随時追加していきます。ご要望などは<a href="https://4536.jp/forums" target="_blank">フォーラム</a>までどうぞ。</small></p>

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
