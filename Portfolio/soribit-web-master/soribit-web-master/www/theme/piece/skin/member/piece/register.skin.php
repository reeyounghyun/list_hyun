<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
include_once(G5_THEME_PATH . '/pub/component/view.navigation.php');
?>

<!--  -->
<div class="register">
    <div class="content join">
        <h2 class="list_title">본인 및 보호자<br /> 회원가입</h2>
        <form name="fregister" class="form form_agree" id="fregister" action="<?php echo $register_action_url ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off">

        <div class="textarea">
            <p class="textarea-title">개인정보처리방침</p>
            <div class="textarea-box"><?php echo get_text($config['cf_privacy']) ?></div>
        </div>
        <div class="textarea">
            <p class="textarea-title">회원가입 약관</p>
            <div class="textarea-box"><?php echo get_text($config['cf_stipulation']) ?>
            </div>
        </div>

            <div class="checkbox-btn">
                <input type="checkbox" id="agree" />
                <label for="agree">모든 사항을 확인하였으며 내용에 동의합니다.</label>
            </div>
            </label>
            <button type="submit" class="button primary btn_next" >
                완료
            </button>
        </form>
    </div>
</div>


    <script>
    // 다음버튼 활성화
    var $agreeCheckbox = $('#agree');
    var $nextButton = $('.btn_next');
    function blankChecked() {
        if($agreeCheckbox.is(':checked')){
            $nextButton.attr('disabled', false);
        } else {
            $nextButton.attr('disabled', true);
        }
    }
    $agreeCheckbox.on('click', function() {
        setTimeout(blankChecked, 50);
    });
    $(document).ready(function(){
        blankChecked();
    });
    </script>

</div>
