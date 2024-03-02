<?php
/**************************
@Filename: group_select_ajax.php
@Version : 1.0
@Author  : Freemaster
@Date  : 2016/05/27
@Content : PHP by Editplus
**************************/
$sub_menu = "001600";
include_once("_common.php");

$gr_id = $_POST['id'];

if($gr_id) {
	$sql_common = "";
    $sql_common .= " AND gr_id = '".$gr_id."'";

	$query = " SELECT bo_table, bo_subject FROM ".$g5['board_table']." WHERE 1 ".$sql_common;
	$result = sql_query($query);
	while($row = sql_fetch_array($result))
		echo("<option value='".$row['bo_table']."'>".$row['bo_subject']."</option>").PHP_EOL;
}
?>