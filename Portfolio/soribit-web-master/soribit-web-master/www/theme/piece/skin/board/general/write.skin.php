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
$check_board = checkBoard($bo_table);
?>

<div class="content write community">
    <div class="list_top not_desc">
        <h2 class="list_title">커뮤니티</h2>
    </div>
    <div class="write_contents">
        <div class="">
            <p class="write_contents-title">원하는 내용을<br/>작성해주세요</p>
            <span class="board"><?php echo $check_board;?> 게시판</span>
            <form class="form" name="fwrite" id="fwrite" action="<?php echo $action_url ?>"
                  onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
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
                <input type="hidden" name="wr_8" value="<?php echo $member['mb_1']?>">
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
                <label for="user-name" style="display: none">제목</label>
                <input type="text" id="user-name" class="input-text" placeholder="글의 제목을 입력하세요" name="wr_subject"
                       value="<?php echo $subject ?>">
                <div class="">
                    <textarea name="wr_content" id="wr_content" class="textarea-box" placeholder="원하는 내용을 작성해주세요"><?php echo $write['wr_content']?></textarea>
                    <div class="editor_file">
                        <div class="file_wrap product">
                            <?php for ($i = 0; $is_file && $i < 1; $i++) { ?>
                                <input type="file" id="file" class="input_file" name="bf_file[]" accept=".jpg, .jpeg, .png">
                                <div class="file_box">
                                    <?php if ($w == 'u' && $file[$i]['file']) { ?>
                                        <button type="button"
                                                class="delete_file on"
                                                onclick="location.href='<?php echo G5_BBS_URL.'/delete_board_file.php?bo_table='.$bo_table.'&wr_id='.$write['wr_id'].'&fname='.$file[0]['source']?>'"
                                        ><?php echo $file[$i]['source'] . '(' . $file[$i]['size'] . ')'; ?></button>
                                        <label for="file" class="btn_file">업로드</label>
                                        <p class="placeholder"></p>
                                        <input type="hidden" id="bf_file_del<?php echo $i ?>"
                                               name="bf_file_del[<?php echo $i; ?>]" value=""> <label style="display: none"
                                                                                                      for="bf_file_del<?php echo $i ?>"></label>
                                    <?php } else { ?>
                                        <button type="button" class="delete_file"></button>


                                        <label for="file" class="btn_file">업로드</label>
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
                        <?php if($w==='u'){ ?>
                        수정
                        <?php }else{ ?>
                        게시
                        <?php }?>
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
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

    function getList() {
        var ul_tag = $("#district");
        ul_tag.html(`<li><button type="button" class="item" name="all">전체</button></li>`);
        var text = $(this).text();
        var value = $(this).attr('name');
        var items = '';
        $.getJSON(g5_url + "/theme/piece/pub/component/region.json", function (data) {
            $.each(data, function (key, val) {
                if (key === value) {
                    $.each(val, function (key2, val2) {
                        items += (`<li><button type='button' class='item' name='${val2}'>${val2}</button></li>`);
                    })
                }

            });
            ul_tag.append(items);
            ul_tag.siblings('button').prop('disabled', false);
        });
        if ($(this).attr('name') === 'all') {
            ul_tag.siblings('button').prop('disabled', true);
            ul_tag.siblings('button').children('span').html(`구`);
            ul_tag.siblings('input[type=hidden]').val(`all`);
        }
    }
    function LoadList(){
        var value = $("input[name='wr_8']").val();
        var ul_tag = $("#district");
        var items = '';
        $.getJSON( g5_url+"/theme/piece/pub/component/region.json", function( data ) {
            $.each( data, function( key, val ) {
                if(key === value){
                    $.each(val, function(key2, val2){
                        items+=( `<li><button type='button' class='item' name='${val2}'>${val2}</button></li>` );
                    })
                }

            });
            ul_tag.append(items);
            ul_tag.siblings('button').prop('disabled', false);
        });
    }
    $(document).on('click', '.select_box .city', getList);
    $(document).on('ready', LoadList);
    $(document).on('ready', function (){
        $(".smarteditor2").siblings('iframe').attr('scrolling', 'yes').css('height', '95%');
        $(".se2_conversion_mode").css("display", "none !important");
    });
</script>
<?php
include_once(G5_THEME_PATH . '/pub/component/footer.navigation.php'); ?>
