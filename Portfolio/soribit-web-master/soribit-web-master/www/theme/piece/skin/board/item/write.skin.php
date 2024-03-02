<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$isWrite = isWriteUser($member['mb_1'],$bo_table,$is_member);
if($isWrite[0] === 'none'){
    goto_url(G5_URL);
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
?>
<?php
//if ($is_admin) {
//    echo '신고한 회원 아이디  : ' . $write['wr_3'];
//    echo '<br/>';
//    echo '신고 사유 : ' . $write['wr_4'];
//    echo '<br/>';
//    echo '<br/>';
//    echo '신고 여부 : <input type="text" value="' . $write['wr_5'] . '">';
//    echo '<br/>';
//}
include_once(G5_THEME_PATH . '/pub/component/view.navigation.php');
$bo_category_list = getExplode($board['bo_category_list'], '|');
$bo_1_category_array = getExplode($board['bo_1'], '|');
$bo_2_category_array = getExplode($board['bo_2'], '|');
$bo_3_category_array = getExplode($board['bo_3'], '|');
$bo_1_category_list = getStringList($board['bo_1']);
$bo_2_category_list = getStringList($board['bo_2']);
$bo_3_category_list = getStringList($board['bo_3']);
?>

<div class="content write contents product">
    <div class="list_top not_desc">
        <h2 class="list_title">제품&middot;서비스</h2>
    </div>
    <div class="write_contents">
        <div class="">
            <p class="write_contents-title">원하는 내용을<br/>작성해주세요</p>
            <!--            <span class="board">--><?php //echo $check_board;?><!-- 게시판</span>-->
            <form class="form" name="fwrite" id="fwrite" action="<?php echo $action_url ?>"
                  onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" name="w" value="<?php echo $w ?>">
                <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
                <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
                <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
                <input type="hidden" name="stx" value="<?php echo $stx ?>">
                <input type="hidden" name="spt" value="<?php echo $spt ?>">
                <input type="hidden" name="sst" value="<?php echo $sst ?>">
                <input type="hidden" name="sod" value="<?php echo $sod ?>">
                <input type="hidden" name="page" value="<?php echo $page ?>">
                <input type="hidden" name="wr_8" value="<?php echo $member['mb_1'] ?>">
                <?php
                $option = '';
                $option_hidden = '';
                if ($is_html) {
                    if ($is_dhtml_editor) {
                        $option_hidden .= '<input type="hidden" value="html1" name="html">';
                    }
                }
                echo $option_hidden;
                ?>
                <div class="select_wrap">
                    <div class="select_box">
                        <input type="hidden" name="ca_name" value="<?php echo $write['ca_name'] ?>" id="ca_name">
                        <button type="button" class="select_btn">
                            <span class="current"><?php if (!$write) {
                                    echo "전체보기";
                                } else {
                                    echo $write['ca_name'];
                                } ?></span>
                        </button>
                        <ul class="list">
                            <?php foreach ($bo_category_list as $iValue) { ?>
                                <li>
                                    <button type="button" class="item"
                                            name="<?php echo $iValue ?>"><?php echo $iValue ?></button>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="select_box">
                        <input type="hidden" name="wr_8" value="<?php echo $write['wr_8'] ?>">
                        <button type="button" class="select_btn">
                            <span class="current"><?php if (!$write) {
                                    echo "전체보기";
                                } else {
                                    echo $write['wr_8'];
                                } ?></span>
                        </button>
                        <ul class="list wr_list">
                            <?php foreach ($bo_1_category_array as $iValue) { ?>
                                <li>
                                    <button type="button" class="item"
                                            name="<?php echo $iValue ?>"><?php echo $iValue ?></button>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <label for="user-title" style="display: none">제목</label>
                <input type="text" id="user-title" class="input-text" placeholder="글의 제목을 입력하세요" name="wr_subject"
                       value="<?php echo $subject ?>">
                <label for="user-link" style="display: none">링크</label>
                <div class="file_wrap product">
                    <?php for ($i = 0; $is_file && $i < 1; $i++) { ?>
                        <input type="file" id="file" class="input_file" name="bf_file[]" accept=".jpg, .jpeg, .png">
                        <div class="file_box">
                            <?php if ($w == 'u' && $file[0]['file']) { ?>
                                <button type="button"
                                        class="delete_file on"
                                        onclick="location.href='<?php echo G5_BBS_URL.'/delete_board_file.php?bo_table='.$bo_table.'&wr_id='.$write['wr_id'].'&fname='.$file[0]['source']?>'"
                                ><?php echo $file[0]['source']?></button>
                                <label for="file" class="btn_file">업로드</label>
                                <p class="placeholder"></p>
                                <input type="hidden" id="bf_file_del<?php echo $i ?>"
                                       name="bf_file_del[<?php echo 0; ?>]" value=""> <label style="display: none"
                                                                                               for="bf_file_del<?php echo 0 ?>"></label>
                            <?php } else { ?>
                                <button type="button" class="delete_file" ></button>
                                <label for="file" class="btn_file">업로드</label>
                                <p class="placeholder">썸네일을 업로드 하세요</p>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <input type="text" id="user-link" class="input-text" placeholder="콘텐츠 링크를 입력하세요" name="wr_link1"
                       value="<?php echo $write['wr_link1'] ?>">
                <div class="file_guide">
                    <p>썸네일은 4:3 비율 이미지를 권장합니다.</p>
                    <p>(.png, .jpeg, .svg 형식 지원)</p>
                    <p>이미지 파일은 5mb 까지 업로드 가능합니다.</p>
                    <p class="notice"></p>
                </div>

                <div class="">
                    <textarea name="wr_content" id="wr_content" class="textarea-box" placeholder="원하는 내용을 작성해주세요"><?php echo $write['wr_content']?></textarea>
                    <div class="editor_file">
                        <div class="file_wrap product">
                            <?php for ($i = 0; $is_file && $i < 1; $i++) { ?>
                                <input type="file" id="file02" class="input_file" name="bf_file[]" accept=".jpg, .jpeg, .png">
                                <div class="file_box">
                                    <?php if ($w == 'u' && $file[1]['file']) { ?>
                                        <button type="button"
                                                class="delete_file on"
                                                onclick="location.href='<?php echo G5_BBS_URL.'/delete_board_file.php?bo_table='.$bo_table.'&wr_id='.$write['wr_id'].'&fname='.$file[1]['source']?>'"
                                        ><?php echo $file[1]['source']?></button>
                                        <label for="file02" class="btn_file">업로드</label>
                                        <p class="placeholder"></p>
                                        <input type="hidden" id="bf_file_del<?php echo 1 ?>"
                                               name="bf_file_del[<?php echo 1; ?>]" value=""> <label style="display: none"
                                                                                                      for="bf_file_del<?php echo 1 ?>"></label>
                                    <?php } else { ?>
                                        <button type="button" class="delete_file"></button>
                                        <label for="file02" class="btn_file">업로드</label>
                                        <p class="placeholder">이미지 파일 업로드</p>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="file_guide">
                            <p>(.png, .jpeg, .jpg 형식 지원)</p>
                            <p>이미지 파일은 5mb 까지 업로드 가능합니다.</p>
                            <p class="notice"></p>
                        </div>
                    </div>
                </div>
                <button type="submit" id="btn_submit" accesskey="s" class="btn_post">
                    <span>
                        <?php if ($w === 'u') { ?>
                            수정
                        <?php } else { ?>
                            게시
                        <?php } ?>
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    $('.delete_file').on('click',function(){
        $(this).parent('.file_box').siblings('.input_file').val('');
        $(this).text('').removeClass('on');
        $(this).parents('.file_wrap').siblings('.file_guide').children('.notice').removeClass('possible').text('');
        $(this).siblings("input[name^='bf_file_del']").val(1);
    })
    let bo_1 = '<?php echo $bo_1_category_list; ?>';
    let bo_2 = '<?php echo $bo_2_category_list; ?>';
    let bo_3 = '<?php echo $bo_3_category_list; ?>';
    $("#ca_name").on('change', get_list);
    $(document).on('ready', get_list);
    function get_list() {
        let text = '';
        let array_length = [];
        let list = $(".wr_list")
        if ($(this).val().trim() === '제품') {
            array_length = bo_1.split(',');
            for (let i = 0; i < array_length.length; i++) {
                text += '<li><button type="button" class="item" name="' + array_length[i] + '">' + array_length[i] + '</button> </li>'
            }
            list.html(text);
            list.siblings('input[type="hidden"]').val('');
            list.siblings('button').children('span').html('전체보기');
        } else if ($(this).val().trim() === '서비스') {
            array_length = bo_2.split(',');
            for (let i = 0; i < array_length.length; i++) {
                text += '<li><button type="button" class="item" name="' + array_length[i] + '">' + array_length[i] + '</button> </li>'
            }
            list.html(text);
            list.siblings('input[type="hidden"]').val('');
            list.siblings('button').children('span').html('전체보기');
        } else if ($(this).val().trim() === '용역') {
            array_length = bo_3.split(',');
            for (let i = 0; i < array_length.length; i++) {
                text += '<li><button type="button" class="item" name="' + array_length[i] + '">' + array_length[i] + '</button> </li>'
            }
            list.html(text);
            list.siblings('input[type="hidden"]').val('');
            list.siblings('button').children('span').html('전체보기');
        }
    }
    <?php if($write_min || $write_max) { ?>
    // 글자수 제한
    var char_min = parseInt(<?php echo $write_min; ?>); // 최소
    var char_max = parseInt(<?php echo $write_max; ?>); // 최대
    check_byte("wr_content", "char_count");
    $(function () {
        $("#wr_content").on("keyup", function () {
            check_byte("wr_content", "char_count");
        });
    });


    <?php } ?>
    function html_auto_br(obj) {
        if (obj.checked) {
            result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
            if (result)
                obj.value = "html2";
            else
                obj.value = "html1";
        } else
            obj.value = "";
    }

    function fwrite_submit(f) {
        <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

        var subject = "";
        var content = "";
        $.ajax({
            url: g5_bbs_url + "/ajax.filter.php",
            type: "POST",
            data: {
                "subject": f.wr_subject.value,
                "content": f.wr_content.value
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function (data, textStatus) {
                subject = data.subject;
                content = data.content;
            }
        });

        if (subject) {
            alert("제목에 금지단어('" + subject + "')가 포함되어있습니다");
            f.wr_subject.focus();
            return false;
        }

        if (content) {
            alert("내용에 금지단어('" + content + "')가 포함되어있습니다");
            if (typeof (ed_wr_content) != "undefined")
                ed_wr_content.returnFalse();
            else
                f.wr_content.focus();
            return false;
        }

        if (document.getElementById("char_count")) {
            if (char_min > 0 || char_max > 0) {
                var cnt = parseInt(check_byte("wr_content", "char_count"));
                if (char_min > 0 && char_min > cnt) {
                    alert("내용은 " + char_min + "글자 이상 쓰셔야 합니다.");
                    return false;
                } else if (char_max > 0 && char_max < cnt) {
                    alert("내용은 " + char_max + "글자 이하로 쓰셔야 합니다.");
                    return false;
                }
            }
        }

        <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }

    var uploadFile = $('.filebox .uploadBtn');
    uploadFile.on('change', function () {
        if (window.FileReader) {
            var filename = $(this)[0].files[0].name;
        } else {
            var filename = $(this).val().split('/').pop().split('\\').pop();
        }
        $(this).siblings('.fileName').val(filename);
    });

</script>
<?php
include_once(G5_THEME_PATH . '/pub/component/footer.navigation.php');
?>

