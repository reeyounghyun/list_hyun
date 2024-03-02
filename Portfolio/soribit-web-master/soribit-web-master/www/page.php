<?php
include_once('./_common.php');

if(defined('G5_THEME_PATH')) {
    require_once(G5_THEME_PATH.'/sub/'.$id.'.php');
    return;
}
?>