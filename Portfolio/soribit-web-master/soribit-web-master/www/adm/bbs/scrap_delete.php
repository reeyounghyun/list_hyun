<?php
/**************************
@Filename: scrap_delete.php
@Version : 1.0
@Author  : Freemaster
@Edit Date  : 2016/05/27
@Content : PHP by Editplus
**************************/
include_once('./_common.php');

auth_check($auth[$sub_menu], 'd');

if (!$is_member)
    alert('회원만 이용하실 수 있습니다.');

$sql = " delete from {$g5['scrap_table']} where mb_id = '{$member['mb_id']}' and ms_id = '$ms_id' ";
sql_query($sql);

goto_url('./scrap.php?page='.$page);
?>
