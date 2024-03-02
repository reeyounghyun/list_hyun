<?php 
include_once('./_common.php');
if( !($_SERVER['HTTP_X-REQUESTED_WITH'] !== 'XMLHttpRequest') ) 
{ 
   echo "잘못된 접근입니다.";
   exit;
} 
if(isset($_POST['id'])){
  $result = changeState($_POST['id'],$_POST['botable'],$_POST['wr']);
}
echo $result;
?>