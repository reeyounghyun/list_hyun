<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 2;

if ($is_checkbox) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
include_once(G5_THEME_PATH . '/pub/component/index.navigation.php');
$isWrite = isWriteUser($member['mb_1'],$bo_table,$is_member);
?>
<div class="content list community">
    <div class="list_top with_tab">
        <h2 class="list_title">커뮤니티</h2>
        <p class="list_desc">우리들의 일상을 공유해요</p>
    </div>
    <ul class="list_tab">
        <!-- 탭 선택 .is-active -->
        <li class="<?php if($bo_table === 'general') { echo 'is-active';}?>">
            <a href="<?php echo G5_BBS_URL.'/board.php?bo_table=general'?>" class="">일반게시판</a>
        </li>
        <li class="<?php if($bo_table === 'idea') { echo 'is-active';}?>">
            <a href="<?php echo G5_BBS_URL.'/board.php?bo_table=idea'?>" class="">아이디어 게시판</a>
        </li>
    </ul>
    <div class="list_contents">
        <form name="fboardlist" id="fboardlist" action="<?php echo G5_BBS_URL; ?>/board_list_update.php"
              onsubmit="return fboardlist_submit(this);" method="post">
            <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
            <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
            <input type="hidden" name="stx" value="<?php echo $stx ?>">
            <input type="hidden" name="spt" value="<?php echo $spt ?>">
            <input type="hidden" name="sst" value="<?php echo $sst ?>">
            <input type="hidden" name="sod" value="<?php echo $sod ?>">
            <input type="hidden" name="page" value="<?php echo $page ?>">
            <input type="hidden" name="sw" value="">
            <!-- 게시판 목록 시작 -->
            <?php if (count($list) > 0) {?>
            <ul>
                <?php for ($i = 0; $i < count($list); $i++) { ?>
                        <?php $check_member_level = checkMemberLevel($list[$i]['wr_8']);?>
                    <li>
                        <a href="<?php echo $list[$i]['href'] ?>">
                            <div class="badge">
                                <span class="type <?php echo $check_member_level['class'];?>"><?php echo $check_member_level['person'];?></span>
                                <span class="like"><?php echo $list[$i]['wr_good']?></span>
                            </div>
                            <p class="list_contents-title"><?php echo $list[$i]['wr_subject']?></p>
                            <span class="time"><?php echo getDateDiff($list[$i]['wr_datetime'])?></span>
                        </a>
                    </li>
                <?php } ?>
            <?php } else if (count($list) === 0) { ?>
                    <div class="list_none">
                        <p>게시글이 없습니다</p>
                    </div>
                <?php } ?>
            </ul>
        </form>
        <a href="<?php echo $isWrite[0] ?>" class="btn_write welfare">
            <p>글쓰기</p>
        </a>
    </div>
    <?php echo newGetPaging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, get_pretty_url($bo_table, '', $qstr.'&amp;page='), 'community', $add);?>
</div>
<script>


</script>
<?php
include_once(G5_THEME_PATH . '/pub/component/footer.navigation.php'); ?>
