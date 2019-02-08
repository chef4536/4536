<?php

function admin_database_setting_4536() { ?>

<div class="wrap">

    <h2>データベース操作</h2>

    <p>
      <small style="color:red;">
        <i class="fas fa-exclamation-circle"></i>この画面で操作する前に必ずバックアップをとってください。バックアップが簡単にできるプラグインは<a href="plugin-install.php?s=UpdraftPlus&tab=search&type=term">UpdraftPlus</a>です
      </small>
    </p>

    <!-- <p><i class="far fa-arrow-alt-circle-right"></i><a href="https://4536.jp/speeding-up" target="_blank" >高速化について</a></p> -->

    <form method="post" action="">

    <?php settings_fields( 'database_group' ); do_settings_sections( 'database_group' ); ?>

    <div class="metabox-holder">
    <div class="postbox" >
        <h3 class="hndle">埋め込みコンテンツのキャッシュ削除</h3>
        <div class="inside">
          <?php
          $list = [
            'all' => 'すべての埋め込みコンテンツ',
            'unknown' => 'カスタムされたブログカード',
            'ogp' => '外部URLのブログカード',
          ];
          foreach($list as $val => $description) { ?>
            <p>
                <input type="radio" name="embed_cache_delete" id="<?php echo $val.'_button'; ?>" value="<?php echo $val; ?>" <?php checked(get_option('embed_cache_delete'), $val);?> />
                <label for="<?php echo $val.'_button'; ?>"><?php echo $description; ?></label>
            </p>
          <?php } ?>
          <p>
            <?php submit_button('キャッシュを削除する', 'primary large', 'embed_cache_delete_submit_4536', $wrap, $other_attributes); ?>
          </p>
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

<?php
}

$list = [
    'embed_cache_delete',
];
foreach($list as $name) {
    $val = (isset($_POST[$name])) ? $_POST[$name] : '' ;
    if(isset($_POST['embed_cache_delete_submit_4536'])) {
      update_option($name, $val);
      add_action( 'admin_notices', function() {
          echo '<div class="updated"><p>キャッシュを削除しました。</p></div>';
      });
    }
}
