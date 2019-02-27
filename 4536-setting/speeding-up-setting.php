<?php

function admin_speeding_up_setting_form_4536() { ?>

<div class="wrap">

    <h2>高速化</h2>

    <p><i class="far fa-arrow-alt-circle-right"></i><a href="https://4536.jp/speeding-up" target="_blank" >高速化について</a></p>

    <form method="post" action="">

    <?php settings_fields( 'speeding_up_group' ); do_settings_sections( 'speeding_up_group' ); ?>

    <div class="metabox-holder">
    <div class="postbox" >
        <h3 class="hndle">ブラウザキャッシュ</h3>
        <div class="inside">
            <p>
                <input type="checkbox" id="is_enable_browser_cache" name="is_enable_browser_cache" value="1" <?php checked(get_option('is_enable_browser_cache'), 1);?> />
                <label for="is_enable_browser_cache">有効化</label>
            </p>
        </div>
    </div>
    </div>

    <div class="metabox-holder">
    <div class="postbox" >
        <h3 class="hndle">ファイルの圧縮</h3>
        <div class="inside">
            <?php
            $list = [
                'is_enable_gzip' => 'Gzip圧縮をする',
            ];
            foreach($list as $name => $desc) { ?>
            <p>
                <input type="checkbox" id="<?php echo $name; ?>" name="<?php echo $name; ?>" value="1" <?php checked(get_option($name), 1);?> />
                <label for="<?php echo $name; ?>"><?php echo $desc; ?></label>
            </p>
            <?php } ?>
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

/**
 *
 */
class AdminSpeedingUpSetting_4536 {

  public $array = [
    'is_enable_browser_cache' => [
      'text' => __DIR__.'/../htaccess-text/browser-cache.conf',
      'search_pattern' => '/#4536BrowserCacheBegin.+?#4536BrowserCacheEnd/s',
    ],
    'is_enable_gzip' => [
      'text' => __DIR__.'/../htaccess-text/gzip.conf',
      'search_pattern' => '/#4536GzipBegin.+?#4536GzipEnd/s',
    ],
  ];

  function __construct() {

    if ( isset( $_POST['admin_speeding_up_setting_submit_4536'] ) ) {
      foreach ( $this->array as $key => $val ) {
        $this->update_option( $key );
      }
      $this->write();
    }

  }

  function write() {
    $path = ABSPATH;
    $htaccess_file = $path.'.htaccess';

    if( !file_exists($htaccess_file) ) {
      add_action( 'admin_notices', function() {
        echo '<div class="error"><p>htaccessファイルが存在しません。</p></div>';
      });
      return;
    }

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

    ob_start();
    foreach ( $this->array as $key => $val ) {
      require_once( $val['text'] );
    }
    $data = ob_get_clean();

    $htaccess_txt = @file_get_contents($htaccess_file);

    foreach( $this->array as $key => $val ) {
      $search = $val['search_pattern'];
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

}
new AdminSpeedingUpSetting_4536();
