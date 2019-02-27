<?php

function admin_amp_setting_form_4536() { ?>

<div class="wrap">

    <h2>AMP設定</h2>

    <p><i class="far fa-arrow-alt-circle-right"></i><a href="https://4536.jp/amp" target="_blank">AMPとは？</a></p>

    <p><small>プラグインで対応する場合はこの画面で設定する必要はありません。</small></p>

    <form method="post" action="options.php">

    <?php settings_fields( 'amp_group' ); do_settings_sections( 'amp_group' ); ?>

    <!-- AMP有効 -->
    <div class="metabox-holder">
    <div class="postbox" >
        <h3 class="hndle">AMP対応</h3>
        <div class="inside">
            <p><small>AMPページを生成します。記事毎にこの機能をオフにすることも可能です。</small></p>
            <!--記事ページ-->
            <p>
                <input type="checkbox" id="admin_amp" name="admin_amp" value="1" <?php checked(get_option('admin_amp'), 1);?> /><label for="admin_amp">記事ページ</label>
            </p>
            <!--固定ページ-->
            <p>
                <input type="checkbox" id="is_amp_page" name="is_amp_page" value="1" <?php checked(get_option('is_amp_page'), 1);?> /><label for="is_amp_page">固定ページ</label>
            </p>
            <!--メインメディア-->
            <p>
                <input type="checkbox" id="is_amp_media" name="is_amp_media" value="1" <?php checked(get_option('is_amp_media'), 1);?> /><label for="is_amp_media">メディアページ</label>
            </p>
            <!--メインメディア-->
            <p>
                <input type="checkbox" id="is_amp_lp" name="is_amp_lp" value="1" <?php checked(get_option('is_amp_lp'), 1);?> /><label for="is_amp_lp">ランディングページ</label>
            </p>
        </div>
    </div>
    </div>

    <!-- home seo -->
    <div class="metabox-holder">
    <div class="postbox" >
        <h3 class="hndle">Googleアドセンスの設定</h3>
        <div class="inside">
            <p><small>個別に管理する場合はウィジェットで設定してください。</small></p>
            <!--コード-->
            <h4>アドセンスのコード</h4>
            <p><small>「通常のアドセンスコード」を貼り付けてください。AMP用に自動変換されます。</small></p>
            <textarea name="admin_amp_adsense_code" rows="5" cols="80" id="admin_amp_adsense_code"><?php echo get_option('admin_amp_adsense_code'); ?></textarea>
            <!--タイトル-->
            <h4>アドセンス広告の上に表示するテキスト</h4>
            <p><small>タイトルを表示しない場合は空欄のままにしてください。</small></p>
            <input type="text" id="admin_amp_adsense_title" name="admin_amp_adsense_title" size="80" value="<?php echo get_option('admin_amp_adsense_title'); ?>" />
            <!--アドセンスの一括設定-->
            <h4>アドセンスを表示する部分にチェックを入れてください。</h4>
            <!--ヘッダー-->
            <p>
                <input type="checkbox" id="admin_amp_adsense_header" name="admin_amp_adsense_header" value="1" <?php checked(get_option('admin_amp_adsense_header'), 1);?> />
                <label for="admin_amp_adsense_header">ヘッダー</label>
            </p>
            <!--記事上-->
            <p>
                <input type="checkbox" id="admin_amp_adsense_post_top" name="admin_amp_adsense_post_top" value="1" <?php checked(get_option('admin_amp_adsense_post_top'), 1);?> />
                <label for="admin_amp_adsense_post_top">記事上</label>
            </p>
            <!--記事中-->
            <p>
                <input type="checkbox" id="admin_amp_adsense_h2" name="admin_amp_adsense_h2" value="1" <?php checked(get_option('admin_amp_adsense_h2'), 1);?> />
                <label for="admin_amp_adsense_h2">記事中（h2見出し前）</label>
            </p>
            <!--記事下広告枠-->
            <p>
                <input type="checkbox" id="admin_amp_adsense_post_bottom" name="admin_amp_adsense_post_bottom" value="1" <?php checked(get_option('admin_amp_adsense_post_bottom'), 1);?> />
                <label for="admin_amp_adsense_post_bottom">記事下広告枠</label>
            </p>
            <!--サイドバー-->
            <p>
                <input type="checkbox" id="admin_amp_adsense_sidebar" name="admin_amp_adsense_sidebar" value="1" <?php checked(get_option('admin_amp_adsense_sidebar'), 1);?> />
                <label for="admin_amp_adsense_sidebar">モバイル表示時のサイドバー上部</label>
            </p>
        </div>
    </div>
    </div>

    <!-- 各種設定 -->
    <div class="metabox-holder">
    <div class="postbox" >
        <h3 class="hndle">コードの追加</h3>
        <div class="inside">
            <p><small>AMPページ用のHTMLコード・JavaScriptコードを追加することができます。</small></p>
            <!--head内-->
            <h4>headタグ内</h4>
            <textarea name="admin_amp_add_html_js_head" rows="5" cols="80" id="admin_amp_add_html_js_head"><?php echo get_option('admin_amp_add_html_js_head'); ?></textarea>
            <!--bodyタグ直後-->
            <h4>bodyタグ直後</h4>
            <textarea name="admin_amp_add_html_js_body" rows="5" cols="80" id="admin_amp_add_html_js_body"><?php echo get_option('admin_amp_add_html_js_body'); ?></textarea>
        </div>
    </div>
    </div>

    <?php submit_button(); ?>

    </form>

    <style>
        .far {
            margin-right: 5px;
        }
    </style>

</div>

<?php
}
