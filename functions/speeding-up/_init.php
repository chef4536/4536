<?php

if(!is_admin()) return;
if($pagenow !== 'admin.php') return;
if(!isset($_POST['admin_speeding_up_setting_submit_4536'])) return;

$path = ABSPATH;
$htaccess_file = $path.'.htaccess';
if(!file_exists($htaccess_file)) {
    add_action( 'admin_notices', function() {
        echo '<div class="error"><p>htaccessファイルが存在しません。</p></div>';
    });
    return;
}
if(!is_writable($htaccess_file)) {
    add_action( 'admin_notices', function() {
        echo '<div class="error"><p>htaccessファイルへの書き込み権限がありません。</p></div>';
    });
    return;
}

$backup_dir = $path.'htaccess_backup_4536';
if(!file_exists($backup_dir)) mkdir($backup_dir);
$ver = theme_version_4536();
$backup_file = $backup_dir.'/.htaccess_backup_4536_'.$ver;
if(!file_exists($backup_file)) copy($htaccess_file, $backup_file);
chmod($backup_dir, 0705);
chmod($backup_file, 0644);

$file_list = [
    'browser-cache.conf',
    'gzip.conf',
];
ob_start();
foreach($file_list as $name) {
    require_once($name);
}
$data = ob_get_clean();

$htaccess_txt = @file_get_contents($htaccess_file);

$list = [
    '/#4536BrowserCacheBegin.+?#4536BrowserCacheEnd/s' => 'is_enable_browser_cache',
    '/#4536GzipBegin.+?#4536GzipEnd/s' => 'is_enable_gzip',
];
//$length = count($list);
//$num = 0;
$data_merge = null;
foreach($list as $search => $option) {
//    ++$num;
    preg_match($search, $htaccess_txt, $htaccess_match);
    preg_match($search, $data, $data_match);
    if(get_option($option)) {
        if($htaccess_match === $data_match) continue;
        if($htaccess_match) {
            $htaccess_txt = preg_replace($search, $data_match[0], $htaccess_txt);
        } else {
            $data_merge .= $data_match[0].PHP_EOL;
        }
    } else {
        if($htaccess_match) {
            $htaccess_txt = preg_replace($search, '', $htaccess_txt);
//            if($num === $length) file_put_contents($htaccess_file, $htaccess_txt);
        }
    }
}
$htaccess_txt = rtrim($htaccess_txt);
$htaccess_txt = $htaccess_txt.PHP_EOL;
if($data_merge) $htaccess_txt = $htaccess_txt.PHP_EOL.$data_merge;
file_put_contents($htaccess_file, $htaccess_txt);

add_action( 'admin_notices', function() {
    echo '<div class="updated"><p>変更を保存しました。</p></div>';
});

//if(get_option('is_enable_browser_cache')) {
//    preg_match($search, $data, $data_match);
//    if($htaccess_match === $data_match) return;
//    if($htaccess_match) {
//        $new_htaccess_file = preg_replace($search, $data_match[0], $htaccess_txt);
//    } else {
//        $new_htaccess_file = $htaccess_txt.$data;
//    }
//    file_put_contents($htaccess_file, $new_htaccess_file);
//} else {
//    if($htaccess_match) {
//        $new_htaccess_file = preg_replace($search, '', $htaccess_txt);
//        file_put_contents($htaccess_file, $new_htaccess_file);
//    }
//}





//$file_list = [
//    'browser-cache.conf',
//    'gzip.conf',
//];
//ob_start();
//foreach($file_list as $name) {
//    require_once($name);PHP_EOL;
//}
//$data = ob_get_clean();
//$data = PHP_EOL.$data;

//$browser_cache_data = '';
//$gzip_data = '';
//
//if(get_option('is_enable_browser_cache')) {
//    ob_start();
//    require_once('browser-cache.conf');
//    $browser_cache_data = ob_get_clean();
//}
//if(get_option('is_enable_gzip')) {
//    ob_start();
//    require_once('gzip.conf');
//    $gzip_data = ob_get_clean();
//}
//
//$htaccess_txt = @file_get_contents($htaccess_file);
//
//$list = [
//    '/#4536BrowserCacheBegin.+?#4536BrowserCacheEnd/s' => $browser_cache_data,
//    '/#4536GzipBegin.+?#4536GzipEnd/s' => $gzip_data,
//];
//foreach($list as $search => $data) {
//    preg_match($search, $htaccess_txt, $htaccess_match);
//    preg_match($search, $data, $data_match);
//    if($data) {
//        if($htaccess_match === $data_match) continue;
//        if($htaccess_match) {
//            $new_htaccess_file = preg_replace($search, $data_match[0], $htaccess_txt);
//        } else {
//            $data_merge .= $data_match[0].PHP_EOL;
//            $new_htaccess_file = $htaccess_txt.PHP_EOL.$data_merge;
//        }
//        file_put_contents($htaccess_file, $new_htaccess_file);
//    } else {
//        if($htaccess_match) {
//            $new_htaccess_file = preg_replace($search, '', $htaccess_txt);
//            file_put_contents($htaccess_file, $new_htaccess_file);
//        }
//    }
//}

//if(isset($_POST['is_enable_browser_cache'])) {
//    preg_match($search, $data, $data_match);
//    if($htaccess_match === $data_match) return;
//    if($htaccess_match) {
//        $new_htaccess_file = preg_replace($search, $data_match[0], $htaccess_txt);
//    } else {
//        $new_htaccess_file = $data.$htaccess_txt;
//    }
//    file_put_contents($htaccess_file, $new_htaccess_file);
//} else {
//    if($htaccess_match) {
//        $new_htaccess_file = preg_replace($search, '', $htaccess_txt);
//        file_put_contents($htaccess_file, $new_htaccess_file);
//    }
//}
//
//$val = (isset($_POST['is_enable_browser_cache'])) ? $_POST['is_enable_browser_cache'] : '' ;
//if(isset($_POST['submit'])) update_option('is_enable_browser_cache', $val);
