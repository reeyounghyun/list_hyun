<?php 
include_once('./_common.php');
$wrId = $_GET['wr_id'];
$fname = $_GET['fname'];
boardFileDelete($wrId,$fname);

?>