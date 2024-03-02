<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
include_once(G5_THEME_PATH . '/pub/component/toregister.navigation.php');
?>

<!-- 회원정보 입력/수정 시작 { -->

<div class="register">
<script src="<?php echo G5_JS_URL ?>/jquery.register_form.js"></script>
<?php if($config['cf_cert_use'] && ($config['cf_cert_ipin'] || $config['cf_cert_hp'])) { ?>
<script src="<?php echo G5_JS_URL ?>/certify.js?v=<?php echo G5_JS_VER; ?>"></script>
<?php } ?>

	<form id="fregisterform" name="fregisterform" action="<?php echo $register_action_url ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" class="form_join">
	<input type="hidden" name="w" value="<?php echo $w ?>">
	<input type="hidden" name="url" value="<?php echo $urlencode ?>">
	<input type="hidden" name="agree" value="<?php echo $agree ?>">
	<input type="hidden" name="agree2" value="<?php echo $agree2 ?>">
	<input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
	<input type="hidden" name="cert_no" value="">
	<?php if (isset($member['mb_sex'])) {  ?><input type="hidden" name="mb_sex" value="<?php echo $member['mb_sex'] ?>"><?php }  ?>
	<?php if (isset($member['mb_nick_date']) && $member['mb_nick_date'] > date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400))) { // 닉네임수정일이 지나지 않았다면  ?>
	<input type="hidden" name="mb_nick_default" value="<?php echo get_text($member['mb_nick']) ?>">
	<input type="hidden" name="mb_nick" value="<?php echo get_text($member['mb_nick']) ?>">
	<?php }  ?>

	<div id="register_form" class="content join">
	    <div class="register_form_inner">
            <h2 class="list_title join">회원정보 입력</h2>
            <div class="id_wrap">
                <div class="input-box id">
                    <input type="text" class="input-text is-checked" id="reg_mb_id" name="mb_id" value="<?php echo $member['mb_id'] ?>" <?php echo $required ?> <?php echo $readonly ?> id="reg_mb_id" placeholder="아이디(이메일) 입력">
                    <input type="hidden" name="mb_email" value="" id="reg_mb_email" required class="frm_input email full_input required" size="70" maxlength="100">
                </div>
                <button type="button" class="btn_checkid btn_join">중복확인</button>
                <div class="notice_wrap">
                    <p class="notice"></p>
                    <p class="guide">비밀번호찾기 시 등록하신 이메일로 발송됩니다.</p>
                </div>
            </div>
            <div class="password_wrap1">
                <input type="password" class="input-text is-checked" name="mb_password" id="reg_mb_password" <?php echo $required ?> placeholder="비밀번호" maxlength="15">
                <p class="guide">8~20자 이상 입력해주세요.</p>
                <p class="notice"></p>
            </div>
            <div class="password_wrap2">
                <input type="password" class="input-text is-checked" name="mb_password_re" id="reg_mb_password_re" <?php echo $required ?> placeholder="비밀번호 확인" maxlength="15">
                <p class="notice"></p>
            </div>
            <input type="text" id="reg_mb_name" name="mb_name" value="<?php echo get_text($member['mb_name']) ?>" <?php echo $required ?> <?php echo $readonly; ?> class="frm_input full_input input-text input_name is-checked <?php echo $required ?> <?php echo $readonly ?>" size="10" placeholder="이름" maxlength="10">
            <input type="hidden" name="mb_nick" value="" id="reg_mb_nick" required class="frm_input required nospace full_input">
            <div class="number_wrap">
                <input type="text" name="mb_tel" value="<?php echo get_text($member['mb_tel']) ?>" id="reg_mb_tel" class="frm_input full_input input-text is-checked <?php echo $config['cf_req_tel']?"required":""; ?>" maxlength="20" placeholder="연락처" maxlength="15">
                <p class="number_notice">이메일 분실 또는 등록증 잘못 첨부할 경우<br />연락처를 통해 확인 해드리고 있습니다.</p>
            </div>
            <div class="file_wrap">
            <p>장애인등록증/사업자등록증 인증</p>
            <p class="file_notice">※ 장애인이나 기관으로 활동희망 하시는 경우에 업로드 해주세요.<br />파일은 신분 확인 용도로만 이용됩니다.</p>
            <input type="file" class="input_file" value="<?php echo $member['mb_2']?>" name="mb_2" id="mb_2" accept=".pdf, .jpg, .jpeg, .png">
                <div class="file_box">
                    <button type="button" class="delete_file"></button>
                    <label for="mb_2" class="btn_file">파일찾기</label>
                </div>
            </div>
            <div class="file_guide">
                <p>(.png, .jpeg, .jpg, .pdf 형식 지원)</p>
                <p>파일은 5mb 까지 업로드 가능합니다.</p>
                <p class="notice"></p>
            </div>
        </div>
    </div>

	    <div class="tbl_frm01 tbl_wrap register_form_inner">
	        <ul>

	            <?php if ($config['cf_use_homepage']) {  ?>
	            <li>
	                <label for="reg_mb_homepage">홈페이지<?php if ($config['cf_req_homepage']){ ?><strong class="sound_only">필수</strong><?php } ?></label>
	                <input type="text" name="mb_homepage" value="<?php echo get_text($member['mb_homepage']) ?>" id="reg_mb_homepage" <?php echo $config['cf_req_homepage']?"required":""; ?> class="frm_input full_input <?php echo $config['cf_req_homepage']?"required":""; ?>" size="70" maxlength="255" placeholder="홈페이지">
	            </li>
	            <?php }  ?>

	            <li>
	            <?php if ($config['cf_use_tel']) {  ?>

	                <label for="reg_mb_tel">전화번호<?php if ($config['cf_req_tel']) { ?><strong class="sound_only">필수</strong><?php } ?></label>
	                <input type="text" name="mb_tel" value="<?php echo get_text($member['mb_tel']) ?>" id="reg_mb_tel" <?php echo $config['cf_req_tel']?"required":""; ?> class="frm_input full_input <?php echo $config['cf_req_tel']?"required":""; ?>" maxlength="20" placeholder="전화번호">
	            <?php }  ?>
				</li>
				<li>
	            <?php if ($config['cf_use_hp'] || $config['cf_cert_hp']) {  ?>
	                <label for="reg_mb_hp">휴대폰번호<?php if ($config['cf_req_hp']) { ?><strong class="sound_only">필수</strong><?php } ?></label>

	                <input type="text" name="mb_hp" value="<?php echo get_text($member['mb_hp']) ?>" id="reg_mb_hp" <?php echo ($config['cf_req_hp'])?"required":""; ?> class="frm_input full_input <?php echo ($config['cf_req_hp'])?"required":""; ?>" maxlength="20" placeholder="휴대폰번호">
	                <?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
	                <input type="hidden" name="old_mb_hp" value="<?php echo get_text($member['mb_hp']) ?>">
	                <?php } ?>
	            <?php }  ?>
	            </li>

	            <?php if ($config['cf_use_addr']) { ?>
	            <li>
	            	<label>주소</label>
					<?php if ($config['cf_req_addr']) { ?><strong class="sound_only">필수</strong><?php }  ?>
	                <label for="reg_mb_zip" class="sound_only">우편번호<?php echo $config['cf_req_addr']?'<strong class="sound_only"> 필수</strong>':''; ?></label>
	                <input type="text" name="mb_zip" value="<?php echo $member['mb_zip1'].$member['mb_zip2']; ?>" id="reg_mb_zip" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input twopart_input <?php echo $config['cf_req_addr']?"required":""; ?>" size="5" maxlength="6"  placeholder="우편번호">
	                <button type="button" class="btn_frmline" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">주소 검색</button><br>
	                <input type="text" name="mb_addr1" value="<?php echo get_text($member['mb_addr1']) ?>" id="reg_mb_addr1" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input frm_address full_input <?php echo $config['cf_req_addr']?"required":""; ?>" size="50"  placeholder="기본주소">
	                <label for="reg_mb_addr1" class="sound_only">기본주소<?php echo $config['cf_req_addr']?'<strong> 필수</strong>':''; ?></label><br>
	                <input type="text" name="mb_addr2" value="<?php echo get_text($member['mb_addr2']) ?>" id="reg_mb_addr2" class="frm_input frm_address full_input" size="50" placeholder="상세주소">
	                <label for="reg_mb_addr2" class="sound_only">상세주소</label>
	                <br>
	                <input type="text" name="mb_addr3" value="<?php echo get_text($member['mb_addr3']) ?>" id="reg_mb_addr3" class="frm_input frm_address full_input" size="50" readonly="readonly" placeholder="참고항목">
	                <label for="reg_mb_addr3" class="sound_only">참고항목</label>
	                <input type="hidden" name="mb_addr_jibeon" value="<?php echo get_text($member['mb_addr_jibeon']); ?>">
	            </li>
	            <?php }  ?>
	        </ul>
	    </div>

	    <div class="tbl_frm01 tbl_wrap register_form_inner">
	        <!-- <h2>기타 개인설정</h2> -->
	        <ul>
	            <?php if ($config['cf_use_signature']) {  ?>
	            <li>
	                <label for="reg_mb_signature">서명<?php if ($config['cf_req_signature']){ ?><strong class="sound_only">필수</strong><?php } ?></label>
	                <textarea name="mb_signature" id="reg_mb_signature" <?php echo $config['cf_req_signature']?"required":""; ?> class="<?php echo $config['cf_req_signature']?"required":""; ?>"   placeholder="서명"><?php echo $member['mb_signature'] ?></textarea>
	            </li>
	            <?php }  ?>

	            <?php if ($config['cf_use_profile']) {  ?>
	            <li>
	                <label for="reg_mb_profile">자기소개</label>
	                <textarea name="mb_profile" id="reg_mb_profile" <?php echo $config['cf_req_profile']?"required":""; ?> class="<?php echo $config['cf_req_profile']?"required":""; ?>" placeholder="자기소개"><?php echo $member['mb_profile'] ?></textarea>
	            </li>
	            <?php }  ?>

	            <?php if ($config['cf_use_member_icon'] && $member['mb_level'] >= $config['cf_icon_level']) {  ?>
	            <li>
	                <label for="reg_mb_icon" class="frm_label">
	                	회원아이콘
	                	<button type="button" class="tooltip_icon"><i class="fa fa-question-circle-o" aria-hidden="true"></i><span class="sound_only">설명보기</span></button>
	                	<span class="tooltip">이미지 크기는 가로 <?php echo $config['cf_member_icon_width'] ?>픽셀, 세로 <?php echo $config['cf_member_icon_height'] ?>픽셀 이하로 해주세요.<br>
gif, jpg, png파일만 가능하며 용량 <?php echo number_format($config['cf_member_icon_size']) ?>바이트 이하만 등록됩니다.</span>
	                </label>
	                <input type="file" name="mb_icon" id="reg_mb_icon">

	                <?php if ($w == 'u' && file_exists($mb_icon_path)) {  ?>
	                <img src="<?php echo $mb_icon_url ?>" alt="회원아이콘">
	                <input type="checkbox" name="del_mb_icon" value="1" id="del_mb_icon">
	                <label for="del_mb_icon" class="inline">삭제</label>
	                <?php }  ?>

	            </li>
	            <?php }  ?>

	            <?php if ($member['mb_level'] >= $config['cf_icon_level'] && $config['cf_member_img_size'] && $config['cf_member_img_width'] && $config['cf_member_img_height']) {  ?>
	            <li class="reg_mb_img_file">
	                <label for="reg_mb_img" class="frm_label">
	                	회원이미지
	                	<button type="button" class="tooltip_icon"><i class="fa fa-question-circle-o" aria-hidden="true"></i><span class="sound_only">설명보기</span></button>
	                	<span class="tooltip">이미지 크기는 가로 <?php echo $config['cf_member_img_width'] ?>픽셀, 세로 <?php echo $config['cf_member_img_height'] ?>픽셀 이하로 해주세요.<br>
	                    gif, jpg, png파일만 가능하며 용량 <?php echo number_format($config['cf_member_img_size']) ?>바이트 이하만 등록됩니다.</span>
	                </label>
	                <input type="file" name="mb_img" id="reg_mb_img">

	                <?php if ($w == 'u' && file_exists($mb_img_path)) {  ?>
	                <img src="<?php echo $mb_img_url ?>" alt="회원이미지">
	                <input type="checkbox" name="del_mb_img" value="1" id="del_mb_img">
	                <label for="del_mb_img" class="inline">삭제</label>
	                <?php }  ?>

	            </li>
	            <?php } ?>

	            <!-- <li class="chk_box">
		        	<input type="checkbox" name="mb_mailling" value="1" id="reg_mb_mailling" <?php echo ($w=='' || $member['mb_mailling'])?'checked':''; ?> class="selec_chk">
		            <label for="reg_mb_mailling">
		            	<span></span>
		            	<b class="sound_only">메일링서비스</b>
		            </label>
		            <span class="chk_li">정보 메일을 받겠습니다.</span>
		        </li> -->

				<?php if ($config['cf_use_hp']) { ?>
		        <li class="chk_box">
		            <input type="checkbox" name="mb_sms" value="1" id="reg_mb_sms" <?php echo ($w=='' || $member['mb_sms'])?'checked':''; ?> class="selec_chk">
		        	<label for="reg_mb_sms">
		            	<span></span>
		            	<b class="sound_only">SMS 수신여부</b>
		            </label>
		            <span class="chk_li">휴대폰 문자메세지를 받겠습니다.</span>
		        </li>
		        <?php } ?>

		        <!-- <?php if (isset($member['mb_open_date']) && $member['mb_open_date'] <= date("Y-m-d", G5_SERVER_TIME - ($config['cf_open_modify'] * 86400)) || empty($member['mb_open_date'])) { // 정보공개 수정일이 지났다면 수정가능 ?>
		        <li class="chk_box">
		            <input type="checkbox" name="mb_open" value="1" id="reg_mb_open" <?php echo ($w=='' || $member['mb_open'])?'checked':''; ?> class="selec_chk">
		      		<label for="reg_mb_open">
		      			<span></span>
		      			<b class="sound_only">정보공개</b>
		      		</label>
		            <span class="chk_li">다른분들이 나의 정보를 볼 수 있도록 합니다.</span>
		            <button type="button" class="tooltip_icon"><i class="fa fa-question-circle-o" aria-hidden="true"></i><span class="sound_only">설명보기</span></button>
		            <span class="tooltip">
		                정보공개를 바꾸시면 앞으로 <?php echo (int)$config['cf_open_modify'] ?>일 이내에는 변경이 안됩니다.
		            </span>
		            <input type="hidden" name="mb_open_default" value="<?php echo $member['mb_open'] ?>">
		        </li>
		        <?php } else { ?>
	            <li>
	                정보공개
	                <input type="hidden" name="mb_open" value="<?php echo $member['mb_open'] ?>">
	                <button type="button" class="tooltip_icon"><i class="fa fa-question-circle-o" aria-hidden="true"></i><span class="sound_only">설명보기</span></button>
	                <span class="tooltip">
	                    정보공개는 수정후 <?php echo (int)$config['cf_open_modify'] ?>일 이내, <?php echo date("Y년 m월 j일", isset($member['mb_open_date']) ? strtotime("{$member['mb_open_date']} 00:00:00")+$config['cf_open_modify']*86400:G5_SERVER_TIME+$config['cf_open_modify']*86400); ?> 까지는 변경이 안됩니다.<br>
	                    이렇게 하는 이유는 잦은 정보공개 수정으로 인하여 쪽지를 보낸 후 받지 않는 경우를 막기 위해서 입니다.
	                </span>

	            </li>
	            <?php }  ?> -->

	            <?php
	            //회원정보 수정인 경우 소셜 계정 출력
	            if( $w == 'u' && function_exists('social_member_provider_manage') ){
	                social_member_provider_manage();
	            }
	            ?>

	            <?php if ($w == "" && $config['cf_use_recommend']) {  ?>
	            <li>
	                <label for="reg_mb_recommend" class="sound_only">추천인아이디</label>
	                <input type="text" name="mb_recommend" id="reg_mb_recommend" class="frm_input" placeholder="추천인아이디">
	            </li>
	            <?php }  ?>

	            <!-- <li class="is_captcha_use">
	                자동등록방지
	                <?//php echo captcha_html(); ?>
	            </li> -->
	        </ul>
	    </div>
	</div>
	<div class="">
	    <!-- <a href="<?//php echo G5_URL ?>" class="btn_close">취소</a> -->
        <!-- disabled  -->
	    <button type="submit" id="btn_submit" class="btn_submit btn_next" accesskey="s" disabled><?php echo $w==''?'완료':'정보수정'; ?></button>
	</div>
	</form>
</div>
<script>
$(function() {

    $("#reg_mb_id").change(function(){
        $("#reg_mb_email").val($(this).val());
    });

    $("#reg_mb_name").change(function(){
        $("#reg_mb_name").val($(this).val().split(' ').join(''));
        $("#reg_mb_nick").val($(this).val().split(' ').join(''));
    });

    $("#reg_zip_find").css("display", "inline-block");

    <?php if($config['cf_cert_use'] && $config['cf_cert_ipin']) { ?>
    // 아이핀인증
    $("#win_ipin_cert").click(function() {
        if(!cert_confirm())
            return false;

        var url = "<?php echo G5_OKNAME_URL; ?>/ipin1.php";
        certify_win_open('kcb-ipin', url);
        return;
    });

    <?php } ?>
    <?php if($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
    // 휴대폰인증
    $("#win_hp_cert").click(function() {
        if(!cert_confirm())
            return false;

        <?php
        switch($config['cf_cert_hp']) {
            case 'kcb':
                $cert_url = G5_OKNAME_URL.'/hpcert1.php';
                $cert_type = 'kcb-hp';
                break;
            case 'kcp':
                $cert_url = G5_KCPCERT_URL.'/kcpcert_form.php';
                $cert_type = 'kcp-hp';
                break;
            case 'lg':
                $cert_url = G5_LGXPAY_URL.'/AuthOnlyReq.php';
                $cert_type = 'lg-hp';
                break;
            default:
                echo 'alert("기본환경설정에서 휴대폰 본인확인 설정을 해주십시오");';
                echo 'return false;';
                break;
        }
        ?>

        certify_win_open("<?php echo $cert_type; ?>", "<?php echo $cert_url; ?>");
        return;
    });
    <?php } ?>
});

// submit 최종 폼체크
function fregisterform_submit(f)
{



    // 회원아이디 검사
    if (f.w.value == "") {
        var msg = reg_mb_id_check();
        if (msg) {
            alert(msg);
            f.mb_id.select();
            return false;
        }
    }

    if (f.w.value == "") {
        if (f.mb_password.value.length < 8) {
            alert("비밀번호를 8글자 이상 입력하십시오.");
            f.mb_password.focus();
            return false;
        }
        if (f.mb_password.value.length > 15) {
            alert("비밀번호를 15글자 이하로 입력하십시오.");
            f.mb_password.focus();
            return false;
        }
    }

    if (f.mb_password.value != f.mb_password_re.value) {
        alert("비밀번호가 같지 않습니다.");
        f.mb_password_re.focus();
        return false;
    }

    if (f.mb_password.value.length > 0) {
        if (f.mb_password_re.value.length < 8) {
            alert("비밀번호를 8글자 이상 입력하십시오.");
            f.mb_password_re.focus();
            return false;
        }
        if (f.mb_password_re.value.length > 15) {
            alert("비밀번호를 15글자 이하로 입력하십시오.");
            f.mb_password_re.focus();
            return false;
        }
    }

    // 이름 검사
    if (f.w.value=="") {
        if (f.mb_name.value.length < 1) {
            alert("이름을 입력하십시오.");
            f.mb_name.focus();
            return false;
        }

        /*
        var pattern = /([^가-힣\x20])/i;
        if (pattern.test(f.mb_name.value)) {
            alert("이름은 한글로 입력하십시오.");
            f.mb_name.select();
            return false;
        }
        */
    }

    <?php if($w == '' && $config['cf_cert_use'] && $config['cf_cert_req']) { ?>
    // 본인확인 체크
    if(f.cert_no.value=="") {
        alert("회원가입을 위해서는 본인확인을 해주셔야 합니다.");
        return false;
    }
    <?php } ?>

    // 닉네임 검사
    if ((f.w.value == "") || (f.w.value == "u" && f.mb_nick.defaultValue != f.mb_nick.value)) {
        var msg = reg_mb_nick_check();
        if (msg) {
            alert(msg);
            f.reg_mb_nick.select();
            return false;
        }
    }

    // E-mail 검사
    if ((f.w.value == "") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
        var msg = reg_mb_email_check();
        if (msg) {
            alert(msg);
            f.reg_mb_email.select();
            return false;
        }
    }

    <?php if (($config['cf_use_hp'] || $config['cf_cert_hp']) && $config['cf_req_hp']) {  ?>
    // 휴대폰번호 체크
    var msg = reg_mb_hp_check();
    if (msg) {
        alert(msg);
        f.reg_mb_hp.select();
        return false;
    }
    <?php } ?>

    if (typeof f.mb_icon != "undefined") {
        if (f.mb_icon.value) {
            if (!f.mb_icon.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
                alert("회원아이콘이 이미지 파일이 아닙니다.");
                f.mb_icon.focus();
                return false;
            }
        }
    }

    if (typeof f.mb_img != "undefined") {
        if (f.mb_img.value) {
            if (!f.mb_img.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
                alert("회원이미지가 이미지 파일이 아닙니다.");
                f.mb_img.focus();
                return false;
            }
        }
    }

    if (typeof(f.mb_recommend) != "undefined" && f.mb_recommend.value) {
        if (f.mb_id.value == f.mb_recommend.value) {
            alert("본인을 추천할 수 없습니다.");
            f.mb_recommend.focus();
            return false;
        }

        var msg = reg_mb_recommend_check();
        if (msg) {
            alert(msg);
            f.mb_recommend.select();
            return false;
        }
    }

    <?php echo chk_captcha_js();  ?>

    document.getElementById("btn_submit").disabled = "disabled";

    return true;
}

jQuery(function($){
	//tooltip
    $(document).on("click", ".tooltip_icon", function(e){
        $(this).next(".tooltip").fadeIn(400).css("display","inline-block");
    }).on("mouseout", ".tooltip_icon", function(e){
        $(this).next(".tooltip").fadeOut();
    });
});

</script>
<script>
    var $idCheckButton = $('.btn_checkid');
    var $nextButton = $('.btn_next');
    var $idInput = $('#reg_mb_id');
    var $passwordInput = $('#reg_mb_password');
    var $passwordCheckInput = $('#reg_mb_password_re');
    var $nameInput = $('#reg_mb_name');
    var $numberInput = $('#reg_mb_tel');
    var $input = $('.join .is-checked');

    function checkId() {
        var id = $idInput.val();
        var formData = new FormData();
        formData.append("reg_mb_id",id);
        formData.append("api", "true")
        $.ajax({
            url: `${g5_bbs_url}/ajax.mb_id.php`,
            type:'post',
            data: formData,
            dataType:'json',
            contentType: false,
            processData: false,
            success:function(result){
                if(result.data.code === 4){
                    $('.id_wrap .notice').text(result.data.msg).removeClass('incorrect').addClass('correct');
                    $idInput.data('confirm',true)
                } else {
                    $('.id_wrap .notice').text(result.data.msg).removeClass('correct').addClass('incorrect');
                    $idInput.focus();
                    $idInput.data('confirm',false)
                }
            },
            error:function(error){
                alert(error);
                window.location.reload;
            },
            complete:function(){
                formActive();
            }
        })
    }
    function formId() {
        var userIdValue = $idInput.val();
        if(!validation.id.test(userIdValue)){
            $('.id_wrap .notice').text('올바르지 않은 아이디(이메일)양식입니다.').removeClass('correct').addClass('incorrect')
            // $idCheckButton.attr('disabled', true);
        } else {
            $('.id_wrap .notice').text('')
            // $idCheckButton.attr('disabled', false);
        }
        if(userIdValue === ''){
            $('.id_wrap .notice').text('')
        }
    }
    function formPassword() {
        var passwordValue = $passwordInput.val();
        if(!validation.password.test(passwordValue)){
            $('.password_wrap1 .notice').text('올바르지 않은 비밀번호입니다.').removeClass('correct').addClass('incorrect');
        } else {
            $('.password_wrap1 .notice').text('올바른 비밀번호입니다.').removeClass('incorrect').addClass('correct');
        }
        if(passwordValue === ''){
            $('.password_wrap1 .notice').text('')
        }
    }
    function PasswordCorrect() {
        var passwordValue = $passwordInput.val();
        var passwordChkValue = $('#reg_mb_password_re').val();
        if ( passwordValue !== passwordChkValue ){
            $('.password_wrap2 .notice').text('비밀번호가 일치하지 않습니다.').removeClass('correct').addClass('incorrect');
        } else {
            $('.password_wrap2 .notice').text('비밀번호가 일치합니다.').removeClass('incorrect').addClass('correct');
        }
        if(passwordChkValue === ''){
            $('.password_wrap2 .notice').text('');
        }
    }
    function formNumber(){
        var numberValue = $numberInput.val();
        if(!validation.number.test(numberValue)){
            $('.number_wrap .notice').text('틀렸음').removeClass('correct').addClass('incorrect');
        } else {
            $('.number_wrap .notice').text('맞았음').removeClass('incorrect').addClass('correct');
        }
    }
    function formActive(){
        var userIdValue = $idInput.val();
        var passwordValue = $passwordInput.val();
        var passwordChkValue = $passwordCheckInput.val();
        var numberValue = $numberInput.val();
        var nameValue = $nameInput.val();
        var correctCount = 0;

        if(validation.password.test(passwordValue)){
            correctCount++ ;
        }
        if(passwordValue === passwordChkValue){
            correctCount++ ;
        }
        if(nameValue !== ''){
            correctCount++ ;
        }
        if(validation.number.test(numberValue) || numberValue == ''){
            correctCount++ ;
        }
        if($idInput.data('confirm')){
            correctCount++ ;
        }

        if(correctCount === 5){
            $nextButton.attr('disabled', false);
        } else {
            $nextButton.attr('disabled', true);
        }
    }
    $passwordInput.focusout(function(){
        formPassword();
        PasswordCorrect();
    })
    $passwordCheckInput.focusout(function(){
        formPassword();
        PasswordCorrect();
    })
    $numberInput.focusout(function(){
        formNumber()
    })
    $input.on('focusout', function() {
        formActive();
    });
    $(document).on('change','#userId', function(){
        $idInput.data('confirm',false)
        formActive();
    })
    $(document).on('click','.btn_checkid', function(){
        checkId();
    })
</script>
<!-- } 회원정보 입력/수정 끝 -->
