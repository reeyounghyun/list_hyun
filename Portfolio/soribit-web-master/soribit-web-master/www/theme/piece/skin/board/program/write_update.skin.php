<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

global $g5;
$board_table = $g5['board_file_table'];
$write_table = $g5['write_prefix'].$bo_table;
isset($_POST['wr_11']) ? $wr_11 = $_POST['wr_11'] : $wr_11 = '';
isset($_POST['wr_12']) ? $wr_12 = $_POST['wr_12'] : $wr_12 = '';
if (isset($_POST['wr_13'])) {
    $wr_13 = substr(trim($_POST['wr_13']),0,65536);
    $wr_13 = preg_replace("#[\\\]+$#", "", $wr_13);
    $wr_13 = xssClean($wr_13);
} else {
    $wr_13 = '';
}
sql_query("UPDATE {$write_table} SET wr_8 = '{$wr_8}', wr_9 = '{$wr_9}', wr_10 = '{$wr_10}', wr_11 = '{$wr_11}', wr_12 = '{$wr_12}', wr_13 = '{$wr_13}'  WHERE wr_id = '{$wr_id}'");

?>
