<?php

/**
 *
 */
class AdminSeoSetting_4536 {

  function __construct() {

    add_action( 'admin_menu', function() {
      add_submenu_page( '4536-setting', 'SEO', 'SEO', 'manage_options', 'seo', [$this, 'form'] );
    });

  }

  function form() { ?>

    <div class="wrap">

        <h2>SEO設定</h2>

        <p><small>SEOプラグインで管理する場合は入力する必要はありません。</small></p>

        <form method="post" action="options.php">

        <?php settings_fields( 'seo_group' ); do_settings_sections( 'seo_group' ); ?>

        <!-- GoogleAnalytics -->
        <div class="metabox-holder">
        <div class="postbox" >
            <h3 class="hndle">Googleアナリティクス設定</h3>
            <div class="inside">
                <h4 class="google_analytics_tracking_id">トラッキングID（UA-◯◯）</h4>
                <input type="text" id="google_analytics_tracking_id" name="google_analytics_tracking_id" value="<?php echo get_option('google_analytics_tracking_id'); ?>" />
                <!--プレビューで読み込み-->
                <p>
                    <input type="checkbox" id="google_analytics_preview_count" name="google_analytics_preview_count" value="1" <?php checked(get_option('google_analytics_preview_count'), 1);?> />
                    <label for="google_analytics_preview_count">カスタマイズやプレビュー画面もカウント対象にする</label>
                </p>
                <!--ログインユーザーのカウント-->
                <p>
                    <input type="checkbox" id="google_analytics_logged_in_user_count" name="google_analytics_logged_in_user_count" value="1" <?php checked(get_option('google_analytics_logged_in_user_count'), 1);?> />
                    <label for="google_analytics_logged_in_user_count">管理画面にログインしているユーザーもカウント対象にする</label>
                </p>
            </div>
        </div>
        </div>

        <!-- home seo -->
        <div class="metabox-holder">
        <div class="postbox" >
            <h3 class="hndle">トップページのSEO対策</h3>
            <div class="inside">
                <!--記事毎のSEO対策-->
                <p>
                    <input type="checkbox" id="admin_seo_home" name="admin_seo_home" value="1" <?php checked(get_option('admin_seo_home'), 1);?> />
                    <label for="admin_seo_home">有効にする</label>
                </p>
                <!--keyword-->
                <h4>メタキーワード</h4>
                <p><small>サイトのキーワードをカンマ区切り（例：〇〇,〇〇,〇〇）で入力してください。SEO効果はほぼないので空欄のままでもOK。サイトの見た目には影響しない項目です。</small></p>
                <input type="text" id="admin_home_keyword" name="admin_home_keyword" size="80" value="<?php echo get_option('admin_home_keyword'); ?>" />
                <!--description-->
                <h4>メタディスクリプション</h4>
                <p><small>入力しない場合は、一般→「キャッチフレーズ」で入力したテキストが使われます。</small></p>
                <textarea name="admin_home_description" rows="5" cols="80" id="admin_home_description"><?php echo get_option('admin_home_description'); ?></textarea>
            </div>
        </div>
        </div>

        <!-- 各種設定 -->
        <div class="metabox-holder">
        <div class="postbox" >
            <h3 class="hndle">各種設定</h3>
            <div class="inside">
                <!--記事毎のSEO対策-->
                <?php
                $list = [
                    'admin_seo_post' => '記事毎のSEO対策を有効にする',
                    'admin_seo_archive' => 'アーカイブページにディスクリプション（説明文）を生成する',
                    'admin_ogp' => 'ソーシャルメディアのSEO対策を有効にする',
                    'admin_canonical' => 'canonicalを追加する',
                    'admin_next_prev' => 'next,prevを追加する',
                ];
                foreach($list as $name => $description) { ?>
                    <p>
                        <input type="checkbox" id="<?php echo $name; ?>" name="<?php echo $name; ?>" value="1" <?php checked(get_option($name), 1);?> />
                        <label for="<?php echo $name; ?>"><?php echo $description; ?></label>
                    </p>
                <?php } ?>
            </div>
        </div>
        </div>

        <!-- noindexの記事 -->
        <div class="metabox-holder">
        <div class="postbox" >
            <h3 class="hndle">noindexしている記事ID一覧</h3>
            <div class="inside">
                <p style="word-break:break-all;">
                <?php
                $args = [
                    'post_type' => 'any',
                    'posts_per_page' => -1,
                    'meta_key' => 'noindex',
                    'meta_value' => 1,
                ];
                $postslist = get_posts($args);
                if($postslist) {
                    foreach ($postslist as $post) {
                        echo $post->ID;
                        if(next($postslist)) echo ',';
                    }
                } else {
                    echo 'noindexしている記事はありません';
                }
                ?>
                </p>
            </div>
        </div>
        </div>

        <?php submit_button(); ?>

        </form>

    </div>

  <?php }

}
new AdminSeoSetting_4536();
