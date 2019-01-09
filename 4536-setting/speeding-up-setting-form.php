<?php

function admin_speeding_up_setting_4536() { ?>

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

<?php
}

$list = [
    'is_enable_browser_cache',
    'is_enable_gzip',
];
foreach($list as $name) {
    $val = (isset($_POST[$name])) ? $_POST[$name] : '' ;
    if(isset($_POST['admin_speeding_up_setting_submit_4536'])) update_option($name, $val);
}
