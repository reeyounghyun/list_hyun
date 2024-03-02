<?php

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
include_once('../common.php');

if (!$is_member)
alert('회원만 접근할 수 있습니다.', G5_BBS_URL.'/login.php');
$_GET['mypage'] = 1;
if (!$_GET['mypage'])
alert('정상적으로 접근하십시오.', G5_BBS_URL.'/login.php');
?>
<style>
    .parsonal{
        padding-top: 100px;
        width: calc(100% - 6%);
        border: 2px solid #ccc;
        border-radius: 8px;
        background: #f8f8f8;
        margin: 2rem auto 0;
        padding: 2rem 3%;
        margin-top: 100px;
    }
    .parsonal p{
        word-break: keep-all;
        font-size: 1.15rem;
        white-space: pre-line;
    }
</style>
<link rel="stylesheet" href="<?php echo G5_ACCESS_URL?>/css/sub.css">
<div class="parsonal">
<?php echo $config['cf_1']?>
</p>
</div>
