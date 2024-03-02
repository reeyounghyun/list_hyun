<?php
include_once('./_common.php');
$postid = $_GET['postid'];
$memberid = $_GET['memberid'];
$reason = $_GET['reason'];
reportPost($postid,$memberid,$reason);

$report_post = "UPDATE g5_write_general SET wr_1 = '{$memberid}', wr_2 = '{$reason}', wr_3 = '1' WHERE wr_id = '{$postid}'";
sql_query($report_post);
alert('신고가 정상적으로 이루어졌습니다.',G5_BBS_URL.'/board.php?bo_table=general');
?>