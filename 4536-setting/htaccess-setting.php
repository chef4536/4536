<?php

/**
 *
 */
class HtaccessUpdate_4536 {

  public $array = [
    'is_enable_browser_cache' => '/#4536BrowserCacheBegin.+?#4536BrowserCacheEnd/s',
    'is_enable_gzip' => '/#4536GzipBegin.+?#4536GzipEnd/s',
  ];

  function __construct() {

    add_action( 'admin_init', function() {
      foreach( $this->array as $key => $value ) {
          register_setting( 'htaccess_group', $key );
      }
    });

    add_action( 'admin_menu', function() {
      $name = 'htaccess';
      add_submenu_page( '4536-setting', $name, $name, 'manage_options', $name, [$this, 'form'] );
    });

    if ( isset( $_POST['admin_speeding_up_setting_submit_4536'] ) ) {
      foreach ( $this->array as $key => $val ) {
        $this->update_option( $key );
      }
      $this->htaccess_update();
    }

  }

  function get_htaccess() {
    $file = ABSPATH.'.htaccess';
    if( !file_exists( $file ) ) {
      add_action( 'admin_notices', function() {
        echo '<div class="error"><p>htaccessファイルが存在しません。</p></div>';
      });
      $file = false;
    }
    return $file;
  }

  function get_htaccess_text() {
    return ( $this->get_htaccess()!==false ) ? @file_get_contents( $this->get_htaccess() ) : '';
  }

  function htaccess_update() {

    $htaccess_file = $this->get_htaccess();

    if( !is_writable($htaccess_file) ) {
      add_action( 'admin_notices', function() {
        echo '<div class="error"><p>htaccessファイルへの書き込み権限がありません。</p></div>';
      });
      return;
    }

    $backup_dir = $path.'htaccess_backup_4536';
    if( !file_exists($backup_dir) ) mkdir($backup_dir);
    $ver = theme_version_4536();
    $backup_file = $backup_dir.'/.htaccess_backup_4536_'.$ver;
    if( !file_exists($backup_file) ) copy($htaccess_file, $backup_file);
    chmod($backup_dir, 0705);
    chmod($backup_file, 0644);

    $text_file_list = [
      __DIR__.'/../htaccess-text/browser-cache.conf',
      __DIR__.'/../htaccess-text/gzip.conf',
    ];
    ob_start();
    foreach ( $text_file_list as $filename ) {
      require_once( $filename );
    }
    $data = ob_get_clean();

    $htaccess_txt = $this->get_htaccess_text();

    foreach( $this->array as $key => $search ) {
      preg_match($search, $htaccess_txt, $htaccess_match);
      preg_match($search, $data, $data_match);
      if ( get_option($key)==='1' ) {
        if( $htaccess_match === $data_match ) continue;
        if( !empty($htaccess_match) ) {
          $htaccess_txt = preg_replace($search, $data_match[0], $htaccess_txt);
        } else {
          $data_merge .= $data_match[0].PHP_EOL;
        }
      } else {
        if( !empty($htaccess_match) ) $htaccess_txt = preg_replace($search, '', $htaccess_txt);
      }
    }
    $htaccess_txt = rtrim($htaccess_txt);
    $htaccess_txt = $htaccess_txt.PHP_EOL;
    if( isset($data_merge) && !empty($data_merge) ) $htaccess_txt = $htaccess_txt.PHP_EOL.$data_merge;
    file_put_contents($htaccess_file, $htaccess_txt);

    add_action( 'admin_notices', function() {
      echo '<div class="updated"><p>変更を保存しました。</p></div>';
    });

  }

  function update_option( $option ) {
    $val = ( isset($_POST[$option]) ) ? $_POST[$option] : '' ;
    update_option( $option, $val );
  }

  function form() { ?>

    <div class="wrap">
        <h2>htaccessの編集</h2>
        <p><i class="far fa-arrow-alt-circle-right"></i><a href="https://4536.jp/speeding-up" target="_blank" >高速化について</a></p>
        <form method="post" action="">
        <?php

        settings_fields( 'htaccess_group' ); do_settings_sections( 'htaccess_group' );

        $array = [
          '高速化' => [
            'is_enable_browser_cache' => 'ブラウザキャッシュ',
            'is_enable_gzip' => 'Gzip圧縮',
          ],
        ];

        foreach( $array as $key => $values ) { ?>

          <div class="metabox-holder">
          <div class="postbox" >
              <h3 class="hndle"><?php echo $key; ?></h3>
              <div class="inside">
                  <?php foreach( $values as $name => $desc ) { ?>
                    <p>
                        <input type="checkbox" id="<?php echo $name; ?>" name="<?php echo $name; ?>" value="1" <?php checked(get_option($name), 1);?> />
                        <label for="<?php echo $name; ?>"><?php echo $desc; ?></label>
                    </p>
                  <?php } ?>
              </div>
          </div>
          </div>

        <?php } ?>

        <div class="metabox-holder">
          <div class="postbox" >
            <h3 class="hndle">htaccessファイル（確認用）</h3>
            <div class="inside">
              <textarea readonly style="width:100%;min-height:400px;background-color:#fcfcfc;">
                <?php echo $this->get_htaccess_text(); ?>
              </textarea>
            </div>
          </div>
        </div>

        <?php submit_button($text, 'primary large', 'admin_speeding_up_setting_submit_4536', $wrap, $other_attributes); ?>

        </form>

        <style>
            .far {
                margin-right: 5px;
            }
        </style>

    </div>

  <?php }

  function register_setting() {

  }

}
new HtaccessUpdate_4536();
