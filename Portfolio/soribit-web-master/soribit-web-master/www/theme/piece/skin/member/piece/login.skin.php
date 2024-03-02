<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<div class="main-header">
    <a href="<?php echo G5_URL?>" class="btn_look">둘러보기</a>
</div>
<div class="content login login_first">
    <div class="login_wrap">
        <p class="logo"><img src="<?php echo G5_ACCESS_URL?>/images/logo_new.png" alt="장애를 위한 한 조각 piece"></p>
        <!-- <span class="logo_desc">장애를 위한 한 조각</span> -->
        <form name="flogin" class="form_login" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post" id="flogin">
        <input type="hidden" name="url" value="<?php echo $login_url ?>">
            <input type="text" name="mb_id" id="login_id" class="input-text" placeholder="이메일">
            <input type="password" name="mb_password" id="login_pw" class="input-text" placeholder="비밀번호">
            <button type="submit" class="btn_login">로그인</button>
        </form>
        <div class="login_btn_group">
            <a href="javascript:void(0)" class="seach" onclick="Piece.layerOpen('.layer_find_password')">비밀번호 찾기</a>
            <a href="./register.php" class="join">회원가입</a>
        </div>
    </div>
</div>
<div class="layer layer_find_password is-hidden">
    <div class="inner">
        <form name="fpasswordlost" action="<?php echo G5_HTTPS_BBS_URL."/password_lost2.php" ?>" onsubmit="return fpasswordlost_submit(this);" method="post" autocomplete="off">
        <div class="contents">
            <div class="title">비밀번호 찾기</div>
            <div class="desc">회원가입 시 등록하신 이메일 주소를 입력해 주세요.<br />해당 연락처로 아이디(이메일)와 비밀번호 정보를 보내드립니다.</div>
                <input type="text" name="mb_email" id="mb_email" required class="required frm_input full_input email input-text" size="30" placeholder="아이디(이메일)">
            </div>
            <div class="btn_group">
                <button type="submit" class="button color gradation">확인</button>
                <button type="button" class="button white" onclick="Piece.layerClose('.layer_find_password')">닫기</button>
            </div>
        </form>
    </div>
</div>

<script>
jQuery(function($){
    $("#login_auto_login").click(function(){
        if (this.checked) {
            this.checked = confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?");
        }
    });
});

function flogin_submit(f)
{
    if( $( document.body ).triggerHandler( 'login_sumit', [f, 'flogin'] ) !== false ){
        return true;
    }
    return false;
}
function fpasswordlost_submit(f)
{
    return true;
}
</script>
