<?php

//定数関連
require_once('functions/_define.php');

//functionsフォルダのファイル読み込み
require_once('functions/_init.php');

//管理画面の設定ページ
require_once('4536-setting/_init.php');

//CSS関連
require_once('css/_init.php');

//JS関連
require_once('js/_init.php');

//テーマアップデート
require_once('plugin-update-checker/plugin-update-checker.php');
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://raw.githubusercontent.com/chef4536/4536/master/theme-update.json',
    __FILE__,
    '4536'
);

//テーマのバージョン
function theme_version_4536()
{
    return wp_get_theme(get_template())->Version;
}
