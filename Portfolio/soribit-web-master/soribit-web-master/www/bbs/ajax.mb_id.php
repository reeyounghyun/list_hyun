<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/register.lib.php');

$mb_id = isset($_POST['reg_mb_id']) ? trim($_POST['reg_mb_id']) : '';
$isApi = isset($_POST['api']) ? trim($_POST['api']) : '';
set_session('ss_check_mb_id', '');
if($isApi == 'true'){
  $msg = apiMbId($mb_id);
  echo json_encode($msg,JSON_UNESCAPED_UNICODE );
}
else if ($msg = empty_mb_id($mb_id))     die($msg);
// if ($msg = valid_mb_id($mb_id))     die($msg);
// if ($msg = count_mb_id($mb_id))     die($msg);
else if ($msg = exist_mb_id($mb_id))     die($msg);
else if ($msg = reserve_mb_id($mb_id))   die($msg);

set_session('ss_check_mb_id', $mb_id);