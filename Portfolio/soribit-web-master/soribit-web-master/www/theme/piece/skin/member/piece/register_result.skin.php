<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>
<div class="content login complete">
    <div class="login_wrap">
        <p class="logo"><img src="<?php echo G5_ACCESS_URL?>/images/logo_color.png" alt="piece"></p>
        <p class="list_title">회원가입이 완료되었습니다.</p>
        <form action="" class="form_login" >
            <button type="button" class="btn_login" onclick="location.href='<?php echo G5_URL?>'">메인으로 가기</button>
        </form>
    </div>
</div>

<div class="banner">
         
</div>
