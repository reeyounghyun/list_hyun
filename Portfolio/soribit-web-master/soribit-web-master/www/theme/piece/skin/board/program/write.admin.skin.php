<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $board_skin_url . '/style.css">', 0);
$get_all_list = getAllList();
$get_city_list = getCityList();
$get_type_explode = getExplode($board['bo_1'], '|');
$region = file_get_contents(G5_THEME_URL."/pub/component/region.json");
$regionJson = json_decode($region, true);
?>

<section id="bo_w">

    <!-- 게시물 작성/수정 시작 { -->
    <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);"
          method="post" enctype="multipart/form-data" autocomplete="off" style="width:<?php echo $width; ?>">
        <input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
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
        <!--        --><?php
        //        $option = '';
        //        $option_hidden = '';
        //        if ($is_notice || $is_html || $is_secret || $is_mail) {
        //            $option = '';
        //            if ($is_notice) {
        //                $option .= PHP_EOL.'<li class="chk_box"><input type="checkbox" id="notice" name="notice"  class="selec_chk" value="1" '.$notice_checked.'>'.PHP_EOL.'<label for="notice"><span></span>공지</label></li>';
        //            }
        //            if ($is_html) {
        //                if ($is_dhtml_editor) {
        //                    $option_hidden .= '<input type="hidden" value="html1" name="html">';
        //                } else {
        //                    $option .= PHP_EOL.'<li class="chk_box"><input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" class="selec_chk" value="'.$html_value.'" '.$html_checked.'>'.PHP_EOL.'<label for="html"><span></span>html</label></li>';
        //                }
        //            }
        //            if ($is_secret) {
        //                if ($is_admin || $is_secret==1) {
        //                    $option .= PHP_EOL.'<li class="chk_box"><input type="checkbox" id="secret" name="secret"  class="selec_chk" value="secret" '.$secret_checked.'>'.PHP_EOL.'<label for="secret"><span></span>비밀글</label></li>';
        //                } else {
        //                    $option_hidden .= '<input type="hidden" name="secret" value="secret">';
        //                }
        //            }
        //            if ($is_mail) {
        //                $option .= PHP_EOL.'<li class="chk_box"><input type="checkbox" id="mail" name="mail"  class="selec_chk" value="mail" '.$recv_email_checked.'>'.PHP_EOL.'<label for="mail"><span></span>답변메일받기</label></li>';
        //            }a
        //        }
        //        echo $option_hidden;
        //        ?>

        <div class="select_box">
            <select name="wr_8" id="wr_8" required="">
                <?php foreach ($get_city_list as $iValue) { ?>
                    <option value="<?php echo $iValue ?>"><?php echo $iValue ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="select_box" id="district">
            <select name="wr_9" id="wr_9" required="">
                <?php foreach ($regionJson['서울시'] as $iValue) { ?>
                    <option value="<?php echo $iValue ?>"
                    <?php echo $iValue === $write['wr_9'] ? 'selected' : ''?>
                    ><?php echo $iValue ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="select_box">
            <select name="wr_10" id="wr_10" required="">
                <?php foreach ($get_type_explode as $iValue) { ?>
                    <option value="<?php echo $iValue ?>"
                    <?php echo $iValue === $write['wr_10'] ? 'selected' : ''?>
                    ><?php echo $iValue ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="period_group">
            <div class="radio-btn">
                <input type="radio" id="always" name="wr_11"
                       class="always" <?php if ($write['wr_11'] === '상시') { echo "checked"; }?> value="상시"/>
                <label for="always">상시</label>
                <input type="radio" id="period" name="wr_11"
                       class="period" <?php if ($write['wr_11'] === '기간') { echo "checked"; }?> value="기간"/>
                <label for="period">기간</label>
            </div>
            <div class="calendar <?php if ($write['wr_11'] === '기간') { echo "on"; }?>">
                <input type="date" id="" name="wr_1" value="<?php echo $wr_1 ?>">
                ~
                <input type="date" id="" name="wr_2" value="<?php echo $wr_2 ?>">
            </div>
        </div>

        <div class="bo_w_info write_div">
            <?php if ($is_name) { ?>
                <input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required
                       class="frm_input half_input required" placeholder="이름">
            <?php } ?>

            <?php if ($is_password) { ?>
                <input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?>
                       class="frm_input half_input <?php echo $password_required ?>" placeholder="비밀번호">
            <?php } ?>

            <?php if ($is_email) { ?>
                <input type="text" name="wr_email" value="<?php echo $email ?>" id="wr_email"
                       class="frm_input half_input email " placeholder="이메일">
            <?php } ?>

            <?php if ($is_homepage) { ?>
                <input type="text" name="wr_homepage" value="<?php echo $homepage ?>" id="wr_homepage"
                       class="frm_input half_input" size="50" placeholder="홈페이지">
            <?php } ?>
        </div>

        <?php if ($option) { ?>
            <div class="write_div">
                <ul class="bo_v_option">
                    <?php echo $option ?>
                </ul>
            </div>
        <?php } ?>

        <p class="board_title">제목</p>
        <div class="bo_w_tit write_div">

            <div id="autosave_wrapper" class="write_div">
                <input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required
                       class="frm_input full_input required" size="50" maxlength="255" placeholder="제목">
                <?php if ($is_member) { // 임시 저장된 글 기능 ?>
                    <script src="<?php echo G5_JS_URL; ?>/autosave.js"></script>
                <?php if ($editor_content_js) echo $editor_content_js; ?>
                    <button type="button" id="btn_autosave" class="btn_frmline">임시 저장된 글 (<span
                                id="autosave_count"><?php echo $autosave_count; ?></span>)
                    </button>
                    <div id="autosave_pop">
                        <strong>임시 저장된 글 목록</strong>
                        <ul></ul>
                        <div>
                            <button type="button" class="autosave_close">닫기</button>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <p class="board_title">내용</p>
        <div class="write_div">
            <div class="wr_content <?php echo $is_dhtml_editor ? $config['cf_editor'] : ''; ?>">
                <?php if ($write_min || $write_max) { ?>
                    <!-- 최소/최대 글자 수 사용 시 -->
                    <p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대
                        <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
                <?php } ?>
                <?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
                <?php if ($write_min || $write_max) { ?>
                    <!-- 최소/최대 글자 수 사용 시 -->
                    <div id="char_count_wrap"><span id="char_count"></span>글자</div>
                <?php } ?>
            </div>

        </div>

        <p class="board_title">링크</p>
        <?php for ($i = 1; $is_link && $i <= 1; $i++) { ?>
            <div class="bo_w_link write_div">
                <label for="wr_link<?php echo $i ?>"><i class="fa fa-link" aria-hidden="true"></i></label>
                <input type="text" name="wr_link<?php echo $i ?>" value="<?php if ($w == "u") {
                    echo $write['wr_link' . $i];
                } ?>" id="wr_link<?php echo $i ?>" class="frm_input full_input" size="50">
            </div>
        <?php } ?>

        <?php for ($i = 0; $is_file && $i < 1; $i++) { ?>
            <p class="board_title">첨부파일</p>
            <div class="bo_w_flie write_div">
                <div class="file_wr write_div">
                    <label for="bf_file_<?php echo $i + 1 ?>" class="lb_icon"><i class="fa fa-folder-open"
                                                                                 aria-hidden="true"></i></label>
                    <input type="file" name="bf_file[]" id="bf_file_<?php echo $i + 1 ?>"
                           title="파일첨부 <?php echo $i + 1 ?> : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능"
                           class="frm_file ">
                </div>
                <?php if ($is_file_content) { ?>
                    <input type="text" name="bf_content[]"
                           value="<?php echo ($w == 'u') ? $file[$i]['bf_content'] : ''; ?>" title="파일 설명을 입력해주세요."
                           class="full_input frm_input" size="50" placeholder="파일 설명을 입력해주세요.">
                <?php } ?>

                <?php if ($w == 'u' && $file[$i]['file']) { ?>
                    <span class="file_del">
            <input type="checkbox" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i; ?>]"
                   value="1"> <label
                                for="bf_file_del<?php echo $i ?>"><?php echo $file[$i]['source'] . '(' . $file[$i]['size'] . ')'; ?> 파일 삭제</label>
        </span>
                <?php } ?>

            </div>
        <?php } ?>

        <p class="board_title">신청방법</p>
        <textarea name="wr_13" id="wr_13" placeholder="신청방법을 작성해주세요"
                  class="textarea-box apply"><?php echo $write['wr_13'] ?></textarea>

        <?php if ($is_use_captcha) { //자동등록방지  ?>
            <div class="write_div">
                <?php echo $captcha_html ?>
            </div>
        <?php } ?>

        <div class="btn_confirm write_div">
            <a href="<?php echo get_pretty_url($bo_table); ?>" class="btn_cancel btn">취소</a>
            <button type="submit" id="btn_submit" accesskey="s" class="btn_submit btn">작성완료</button>
        </div>
    </form>
</section>
<!-- } 게시물 작성/수정 끝 -->
