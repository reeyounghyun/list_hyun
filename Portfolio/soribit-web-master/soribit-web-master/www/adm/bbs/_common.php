<?php
/**************************
@Filename: _common.php
@Version : 1.0
@Author  : Freemaster
@Date  : 2016/05/27
@Content : PHP by Editplus
**************************/
define('G5_IS_ADMIN', true);
$sub_menu = "400250";
include_once('../../common.php');
include_once(G5_ADMIN_PATH.'/admin.lib.php');
include_once(G5_ADMIN_PATH.'/bbs/adm.bbs.config.php');
//관리자 메뉴 active 설정
switch ($bo_table) {
    case 'basic':
        $sub_menu = '400300';
        break;
    case 'gallery':
        $sub_menu = '400400';
        break;
    case 'schedule':
        $sub_menu = '400500';
        break;
    case 'banner_ad_management':
        $sub_menu = '400600';
        break;
    case 'program':
        $sub_menu = '400800';
        break;
    case 'content':
        $sub_menu = '400900';
        break;
    case 'idea':
        $sub_menu = '400910';
        break;
    case 'item':
        $sub_menu = '400920';
        break;
    case 'welfare':
        $sub_menu = '400930';
        break;
    case 'general':
        $sub_menu = '400940';
        break;

//    case 'survey':
//        $sub_menu = '800300';
//        break;
//    case 'club_image':
//        $sub_menu = '800400';
//        break;
//    case 'health_news':
//        $sub_menu = '800500';
//        break;
//    case 'health_round':
//        $sub_menu = '800600';
//        break;
}
?>
