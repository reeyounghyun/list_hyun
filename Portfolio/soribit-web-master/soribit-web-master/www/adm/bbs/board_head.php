<?php
/**************************
@Filename: board_head.php
@Version : 1.0
@Author  : Freemaster
@Edit Date  : 2016/05/27
@Content : PHP by Editplus
**************************/
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
            <?php if((basename($_SERVER['PHP_SELF']) == "board.php" || basename($_SERVER['PHP_SELF']) == "write.php") && $bo_table) { ?>
            <section class="inner">
                <div class="local_desc03 local_desc">
                    <p>
<!--                        <a href="--><?php //echo G5_ADMIN_BBS_URL."/index.php?".$qstr;?><!--" class="ov_listall">전체글 관리</a>-->
                        <a href="<?php echo G5_ADMIN_BBS_URL."/board.php?bo_table=".$bo_table;?>" class="ov_listall2">게시글 목록</a>
                        <span class="board_user_page">
                            GROUP <?php echo(get_group_select2("gr_id", $board['gr_id'], 'disabled')); ?>
                            &nbsp;&nbsp;BOARD <?php echo(get_board_select("bo_table", $bo_table, 'disabled'));?>
                            &nbsp;&nbsp;<a href="<?php echo G5_BBS_URL."/board.php?bo_table=".$bo_table;?>" class="ov_listall">사용자페이지에서 보기</a>
                        </span>
                    </p>
                </div>
            <?php } ?>
<?php
// 게시판 관리의 상단 내용
if (G5_IS_MOBILE) {
    // 모바일의 경우 설정을 따르지 않는다.
    //include_once(G5_BBS_PATH.'/_head.php');
    echo stripslashes($board['bo_mobile_content_head']);
} else {
    if(is_include_path_check($board['bo_include_head'])) {  //파일경로 체크
        @include ($board['bo_include_head']);
    } else {    //파일경로가 올바르지 않으면 기본파일을 가져옴
        //include_once(G5_BBS_PATH.'/_head.php');
    }
    echo stripslashes($board['bo_content_head']);
}
?>
