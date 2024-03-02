<?php
include_once('./_common.php');
include_once('./_head.php');
if(!$is_member){
  goto_url(G5_URL);
}

echo '<script src="'.G5_JS_URL.'/jquery-1.8.3.min.js"></script>';
echo '<script src="'.G5_THEME_URL.'/pub/assets/js/lib/slick.js"></script>';
echo '<script src="'.G5_THEME_URL.'/pub/assets/js/common.js"></script>';

include_once(G5_THEME_PATH . '/pub/component/view.navigation.php');
include_once($member_skin_path.'/mygood.php');
?>
