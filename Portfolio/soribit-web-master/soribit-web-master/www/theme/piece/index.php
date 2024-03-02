<?php
include_once("./_common.php");
$g5['title'] = $config['cf_title'];
$g5_head_title = $g5['title'];
if (preg_match('/https?:\/\/([^\/]+)\//i', $_SERVER['HTTP_REFERER'], $matches)) {
    $domain = $matches[1];
}

 require_once(G5_THEME_PATH.'/main.php');
/*if($is_member || (G5_DEV_DOMAIN === $domain)){
    if(defined('G5_THEME_PATH')) {
        require_once(G5_THEME_PATH.'/main.php');
        return;
    }
} else {
    goto_url(G5_BBS_URL.'/login.php');
}*/
