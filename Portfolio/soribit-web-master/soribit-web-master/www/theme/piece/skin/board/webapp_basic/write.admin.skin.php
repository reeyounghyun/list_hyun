<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
?>
<?php
if($is_admin){
    echo '신고한 회원 아이디  : '.$write['wr_1'];
    echo '<br/>';
    echo '신고 사유 : '.$write['wr_2'];
    echo '<br/>';
    echo '<br/>';
    echo '신고 여부 : <input type="text" value="'.$write['wr_3'].'">';
    echo '<br/>';
}
?>


<section id='bo_w' class="content community-write">
        <form class="form" name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
            <input type="hidden" name="w" value="<?php echo $w ?>">
            <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
            <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
            <input type="hidden" name="sca" value="<?php echo $sca ?>">
            <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
            <input type="hidden" name="stx" value="<?php echo $stx ?>">
            <input type="hidden" name="spt" value="<?php echo $spt ?>">
            <input type="hidden" name="sst" value="<?php echo $sst ?>">
            <input type="hidden" name="sod" value="<?php echo $sod ?>">
            <input type="hidden" name="page" value="<?php echo $page ?>">
               <?php
    $option = '';
    $option_hidden = '';
    if ($is_notice || $is_html || $is_secret || $is_mail) {
        $option = '';
        if ($is_notice) {
            $option .= PHP_EOL.'<li class="chk_box"><input type="checkbox" id="notice" name="notice"  class="selec_chk" value="1" '.$notice_checked.'>'.PHP_EOL.'<label for="notice"><span></span>공지</label></li>';
        }
    }
    echo $option_hidden;
    ?>
    <?php if ($option) { ?>
    <div class="write_div">
        <ul class="bo_v_option">
        <?php echo $option ?>
        </ul>
    </div>
    <?php } ?>
        <div class="label-input input-required">
            <label for="user-name">제목</label>
            <div class="input-box">
                <input type="text" id="user-name" required placeholder="이름 입력" name="wr_subject" value="<?php echo $subject ?>">
            </div>
        </div>
        <div class="label-input">
            <label for="user-name">내용</label>
            <div class="input-box">
                <?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
            </div>

    <div class="bo_w_link write_div">
        <label for="wr_link1"></label>
        <input type="text" name="wr_link1" value="<?php if($w=="u"){ echo $write['wr_link'.$i]; } ?>" id="wr_link1" class="frm_input full_input" size="50">
    </div>
    <div class="bo_w_link write_div">
        <label for="wr_link2"></label>
        <input type="text" name="wr_link2" value="<?php if($w=="u"){ echo $write['wr_link'.$i]; } ?>" id="wr_link2" class="frm_input full_input" size="50">
    </div>
    <div class="bo_w_link write_div">
        <label for="wr_link3"></label>
        <input type="text" name="wr_link3" value="<?php if($w=="u"){ echo $write['wr_link'.$i]; } ?>" id="wr_link3" class="frm_input full_input" size="50" placeholder="유튜브 링크">
    </div>
            <?php for ($i=0; $is_file && $i<$file_count; $i++) { ?>
                <div class="bo_w_flie write_div">
                    <div class="file_wr write_div filebox">
                        <input type="text" class="fileName" readonly="readonly" placeholder="파일을 첨부하세요">
                        <label for="bf_file_<?php echo $i+1 ?>"><i class="fa fa-download lb_icon" aria-hidden="true"></i><span class="btn_file">파일첨부</span></label>
                        <input type="file" name="bf_file[]" id="bf_file_<?php echo $i+1 ?>" title="파일첨부 <?php echo $i+1 ?> : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file uploadBtn">
                    </div>
                    <?php if ($is_file_content) { ?>
                        <input type="text" name="bf_content[]" value="<?php echo ($w == 'u') ? $file[$i]['bf_content'] : ''; ?>" title="파일 설명을 입력해주세요." class="full_input frm_input" size="50" placeholder="파일 설명을 입력해주세요.">
                    <?php } ?>

                    <?php if($w == 'u' && $file[$i]['file']) { ?>
                        <span class="file_del">
                <input type="checkbox" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i;  ?>]" value="1"> <label for="bf_file_del<?php echo $i ?>"><?php echo $file[$i]['source'].'('.$file[$i]['size'].')';  ?> 파일 삭제</label>
            </span>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
            <!--TODO 파일 첨부 연결 안함 서영윤-->
<!--        <div class="input-box abandon-button">-->
<!--            <label for="upload-file01">-->
<!--                <div class="file-input">-->
<!--                    <div class="file-text js-file-name upload-file01">-->
<!--                        <img src="../assets/images/icon/file_upload2@3x.png" alt="파일 업로드" class="icon small">-->
<!--                        <span>파일을 선택해주세요</span>-->
<!--                    </div>-->
<!--                    <input type="file" id="upload-file01" accept="image/*" style="display: none" onchange="changeImage(event)">-->
<!--                </div>-->
<!--            </label>-->
<!---->
<!--            <label for="upload-file01" class="button dark small">-->
<!--                첨부파일-->
<!--            </label>-->
<!--        </div>-->
<!--        <div class="input-box abandon-button">-->
<!--            <label for="upload-file02">-->
<!--                <div class="file-input">-->
<!--                    <div class="file-text js-file-name upload-file02">-->
<!--                        <img src="../assets/images/icon/file_upload2@3x.png" alt="파일 업로드" class="icon small">-->
<!--                        <span>파일을 선택해주세요</span>-->
<!--                    </div>-->
<!--                    <input type="file" id="upload-file02" accept="image/*" style="display: none" onchange="changeImage(event)">-->
<!--                </div>-->
<!--            </label>-->
<!---->
<!--            <label for="upload-file02" class="button dark small">-->
<!--                첨부파일-->
<!--            </label>-->
<!--        </div>-->
        <button class="button primary">
            완료
        </button>

    </form>
</section>

<script>
<?php if($write_min || $write_max) { ?>
// 글자수 제한
var char_min = parseInt(<?php echo $write_min; ?>); // 최소
var char_max = parseInt(<?php echo $write_max; ?>); // 최대
check_byte("wr_content", "char_count");

$(function() {
    $("#wr_content").on("keyup", function() {
        check_byte("wr_content", "char_count");
    });
});

<?php } ?>
function html_auto_br(obj)
{
    if (obj.checked) {
        result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
        if (result)
            obj.value = "html2";
        else
            obj.value = "html1";
    }
    else
        obj.value = "";
}

function fwrite_submit(f)
{
    <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

    var subject = "";
    var content = "";
    $.ajax({
        url: g5_bbs_url+"/ajax.filter.php",
        type: "POST",
        data: {
            "subject": f.wr_subject.value,
            "content": f.wr_content.value
        },
        dataType: "json",
        async: false,
        cache: false,
        success: function(data, textStatus) {
            subject = data.subject;
            content = data.content;
        }
    });

    if (subject) {
        alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
        f.wr_subject.focus();
        return false;
    }

    if (content) {
        alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
        if (typeof(ed_wr_content) != "undefined")
            ed_wr_content.returnFalse();
        else
            f.wr_content.focus();
        return false;
    }

    if (document.getElementById("char_count")) {
        if (char_min > 0 || char_max > 0) {
            var cnt = parseInt(check_byte("wr_content", "char_count"));
            if (char_min > 0 && char_min > cnt) {
                alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
                return false;
            }
            else if (char_max > 0 && char_max < cnt) {
                alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
                return false;
            }
        }
    }

    <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

    document.getElementById("btn_submit").disabled = "disabled";

    return true;
}

var uploadFile = $('.filebox .uploadBtn');
uploadFile.on('change', function(){
	if(window.FileReader){
		var filename = $(this)[0].files[0].name;
	} else {
		var filename = $(this).val().split('/').pop().split('\\').pop();
	}
	$(this).siblings('.fileName').val(filename);
});
</script>
