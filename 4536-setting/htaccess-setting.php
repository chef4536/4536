<?php

/**
 *
 */
class HtaccessUpdate_4536 {

  public $array = [
    'is_enable_protect_wp_config' => [
      'search_pattern' => '/#4536ProtectWpConfigBegin.+?#4536ProtectWpConfigEnd/s',
      'location' => 'before'
    ],
    'is_enable_redirect_to_https' => [
      'search_pattern' => '/#4536RedirectToHttpsBegin.+?#4536RedirectToHttpsEnd/s',
      'location' => 'before'
    ],
    'is_enable_browser_cache' => [
      'search_pattern' => '/#4536BrowserCacheBegin.+?#4536BrowserCacheEnd/s',
      'location' => 'after'
    ],
    'is_enable_gzip' => [
      'search_pattern' => '/#4536GzipBegin.+?#4536GzipEnd/s',
      'location' => 'after'
    ],
  ];

  function __construct() {

    // var_dump( get_option('redirect_my_test') ); //test
    // var_dump( $this->redirect_count() ); //test

    add_action( 'admin_init', function() {
      if( get_option( 'redirect_my_test' ) === false ) update_option( 'redirect_my_test', [] );
      foreach( $this->array as $key => $value ) {
        register_setting( 'htaccess_group', $key );
      }
      register_setting( 'htaccess_group', 'redirect_my_test' );
    });

    add_action( 'admin_menu', function() {
      add_submenu_page( '4536-setting', 'htaccess', 'htaccess', 'manage_options', 'htaccess', [$this, 'form'] );
    });

    if ( isset( $_POST['admin_speeding_up_setting_submit_4536'] ) ) {

      $array = [];

      $array['cat_id'] = ( !empty( $_POST['cat_id'] ) ) ? $_POST['cat_id'] : [];
      $array['cat_id'] = array_values( $array['cat_id'] );

      $array['redirect_url'] = ( !empty( $_POST['redirect_url'] ) ) ? $_POST['redirect_url'] : '';
      $array['redirect_url'] = array_values( $array['redirect_url'] );

      update_option( 'redirect_my_test', $array );

      var_dump(get_option('redirect_my_test')); //test
      // require_once( __DIR__.'/../htaccess-text/redirect-post-in-category.php' ); //test

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
      'browser-cache.conf',
      'gzip.conf',
      'protect-wp-config.conf',
      'redirect-to-https.conf',
      'redirect-post-in-category.php',
    ];
    ob_start();
    foreach ( $text_file_list as $filename ) {
      require_once( __DIR__.'/../htaccess-text/'.$filename );
    }
    $data = ob_get_clean();

    $htaccess_txt = $this->get_htaccess_text();

    foreach( $this->array as $key => $val ) {
      $search = $val['search_pattern'];
      $location = $val['location'];
      preg_match($search, $htaccess_txt, $htaccess_match);
      preg_match($search, $data, $data_match);
      if ( get_option($key)==='1' ) {
        if( $htaccess_match === $data_match ) continue;
        if( !empty($htaccess_match) ) {
          $htaccess_txt = preg_replace($search, $data_match[0], $htaccess_txt);
        } else {
          if( $location === 'before' ) {
            $data_merge_before .= $data_match[0].PHP_EOL;
          } elseif( $location === 'after' ) {
            $data_merge_after .= $data_match[0].PHP_EOL;
          }
        }
      } else {
        if( !empty($htaccess_match) ) $htaccess_txt = preg_replace($search, '', $htaccess_txt);
      }
    }

    $htaccess_txt = PHP_EOL.trim( $htaccess_txt ).PHP_EOL;
    if( isset($data_merge_before) && !empty($data_merge_before) ) $htaccess_txt = PHP_EOL.$data_merge_before.$htaccess_txt;
    if( isset($data_merge_after) && !empty($data_merge_after) ) $htaccess_txt = $htaccess_txt.PHP_EOL.$data_merge_after;

    file_put_contents($htaccess_file, $htaccess_txt);

    add_action( 'admin_notices', function() {
      echo '<div class="updated"><p>変更を保存しました。</p></div>';
    });

  }

  function update_option( $option ) {
    $val = ( isset($_POST[$option]) ) ? $_POST[$option] : '' ;
    update_option( $option, $val );
  }

  function redirect_count() {
    // return 3;
    $array = get_option( 'redirect_my_test' );
    $count = ( !empty($array['cat_id']) ) ? count( $array['cat_id'] ) : 1 ;
    return $count;
  }

  function form() { ?>

    <div class="wrap">
        <h2>htaccess設定</h2>
        <p><i class="far fa-arrow-alt-circle-right"></i><a href="https://4536.jp/speeding-up" target="_blank" >高速化について</a></p>
        <form method="post" action="">
        <?php

        settings_fields( 'htaccess_group' ); do_settings_sections( 'htaccess_group' );

        $array = [
          '高速化' => [
            'is_enable_browser_cache' => 'ブラウザキャッシュ',
            'is_enable_gzip' => 'Gzip圧縮',
          ],
          'セキュリティ' => [
            'is_enable_protect_wp_config' => 'wp-configファイルへのアクセス禁止',
          ],
          'リダイレクト（内部）' => [
            'is_enable_redirect_to_https' => 'httpへのアクセスをhttpsにリダイレクト（要：SSL化）',
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

        <?php for( $num=0; $num < $this->redirect_count(); $num++ ) { ?>
          <div id="redirect_post_in_category-<?php echo $num; ?>" class="metabox-holder redirect_post_in_category-section">
            <div class="postbox">
              <h3 class="hndle">リダイレクト（外部）</h3>
              <div class="inside scroll">
                <label style="font-size:small">スキーム＋ホスト（例：https://4536.jp）</label></br>
                <input type="url" name="redirect_url[<?php echo $num; ?>]" size="40" value="<?php echo get_option('redirect_my_test')['redirect_url'][$num]; ?>" required>
                <ul>
                  <?php
                  $walker = new Walker_Category_Checklist_Widget (
                    'cat_id['.$num.']',
                    'cat_id['.$num.']'
                  );
                  wp_category_checklist( 0, 0, get_option('redirect_my_test')['cat_id'][$num], false, $walker, false );
                  ?>
                </ul>
              </div>
              <div class="button-section">
                <input type="button" id="clone" class="clone button small-button" value="複製">
                <input type="button" id="delete" class="delete button small-button" value="削除">
              </div>
            </div>
          </div>
        <?php } ?>

        <div id="clone_point_redirect_content"></div>

        <script>
          $(function() {

            let count = <?php echo $this->redirect_count(); ?>;

            $('input.clone').on( 'click' , function() {
              let origin = $(this).closest('.redirect_post_in_category-section');
              let clone = origin.clone().html();
              clone = clone.replace( /name="cat_id\[\d\]/g, 'name="cat_id[' + count + ']' );
              clone = clone.replace( /name="redirect_url\[\d\]"/g, 'name="redirect_url[' + count + ']"' );
              const clone_point = $('#clone_point_redirect_content');
              clone_point.before( clone );
              $('html,body').animate({scrollTop:clone_point.offset().top - 400 });
              // let lastElm = Array.prototype.slice.call(document.getElementsByClassName('redirect_post_in_category-section')).slice(-1)[0];
              // lastElm.after( clone );
              // lastElm.insertAdjacentHTML( 'afterend', clone );
              count = count + 1;
              // console.log( clone );
            });

            $('input.delete').on( 'click' , function() {
              $(this).closest('.redirect_post_in_category-section').remove();
            });

          });
        </script>

        <?php submit_button($text, 'primary large', 'admin_speeding_up_setting_submit_4536', $wrap, $other_attributes); ?>

        </form>

        <div class="metabox-holder" style="margin-top:20px">
          <div class="postbox" >
            <h3 class="hndle">htaccessファイル（確認用）</h3>
            <div class="inside">
              <textarea readonly style="width:100%;min-height:300px;background-color:#fcfcfc;">
                <?php echo $this->get_htaccess_text(); ?>
              </textarea>
            </div>
          </div>
        </div>

        <style>
          .far {
            margin-right: 5px;
          }
          .button-section {
            margin: 12px;
          }
          .scroll {
            height: 200px;
            overflow-y: scroll;
          }
          .small-button {
            margin: 12px;
          }
        </style>

    </div>

  <?php }

}
new HtaccessUpdate_4536();
