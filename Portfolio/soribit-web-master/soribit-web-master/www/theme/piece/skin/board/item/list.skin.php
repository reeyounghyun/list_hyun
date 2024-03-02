<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH . '/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $board_skin_url . '/style.css">', 0);
$get_category_list = getCategoryList($bo_table, 'bo_category_list');
$get_second_category_list = getCategoryList($bo_table, 'bo_1');
$isWrite = isWriteUser($member['mb_1'],$bo_table,$is_member);
include_once(G5_THEME_PATH . '/pub/component/index.navigation.php');
?>

<!-- 게시판 목록 시작 { -->
<div class="content list product">
    <div class="list_top with_tab">
        <h2 class="list_title">제품&middot;서비스</h2>
        <p class="list_desc">장애인들을 위한 제품&middot;서비스를 확인해보세요.</p>
    </div>
    <ul class="list_tab">
        <!-- 탭 선택 .is-active -->
        <li class="<?php if(!$_GET['sca'] || $sca === 'all') {echo 'is-active' ; }?>">
            <a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=item">전체</a>
        </li>
        <?php foreach ($get_category_list as $iValue) { ?>
            <li class="<?php if($sca === $iValue) {echo 'is-active' ; }?>">
                <a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=item&sca=<?php echo $iValue ?>"><?php echo $iValue ?></a>
            </li>
        <?php } ?>
    </ul>
    <div class="list_contents">
        <?php $get_explode = getCategoryInItem($sca); ?>
        <?php if($sca === '제품' || $sca === '서비스' || $sca === '용역'){ ?>
        <form action="<?php echo G5_BBS_URL; ?>/board.php" method="GET">
            <input type="hidden" name="bo_table" value="item">
            <input type="hidden" name="sca" value="<?php echo $sca; ?>">
            <input type="hidden" name="filter_search" value="filter_search">
            <div class="search_wrap">
                <div class="select_box">
                    <input type="hidden" name="wr_8" value="">
                    <button type="button" class="select_btn">
                        <span class="current">카테고리</span>
                    </button>
                    <ul class="list">
                        <li>
                            <button type="button" class="item" name="all">전체</button>
                        </li>
                        <?php
                            foreach ($get_explode['category'] as $iValue){ ?>
                                <li>
                                    <button type="button" class="item" name="<?php echo $iValue; ?>"><?php echo $iValue; ?></button>
                                </li>
                            <?php } ?>
                    </ul>
                </div>
                <button type="submit" class="btn_search">검색</button>
            </div>
        </form>
        <?php } ?>
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

            <!-- 게시판 페이지 정보 및 버튼 시작 { -->
            <!-- } 게시판 페이지 정보 및 버튼 끝 -->
            <ul id="" class="product_list">
                <?php for ($i = 0; $i < count($list); $i++) {

                    $classes = array();

                    $classes[] = 'gall_li';
                    $classes[] = 'col-gn-' . $bo_gallery_cols;

                    if ($i && ($i % $bo_gallery_cols == 0)) {
                        $classes[] = 'box_clear';
                    }

                    if ($wr_id && $wr_id == $list[$i]['wr_id']) {
                        $classes[] = 'gall_now';
                    }

                    $line_height_style = ($board['bo_gallery_height'] > 0) ? 'line-height:' . $board['bo_gallery_height'] . 'px' : '';
                    ?>
                    <li>
                        <?php $thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height'], false, true);
                        if ($thumb['src']) {
                            $img_content = $thumb['src'];
                        } else {
                            $img_content = G5_THEME_URL.'/pub/assets/images/product_thumbnail.png';
                        }
                        ?>
                        <a class="image" href="<?php echo $list[$i]['href'] ?>"
                           style="background-image: url('<?php echo $img_content ?>');">
                        </a>
                        <div class="text">
                            <p class="name"><?php echo $list[$i]['wr_subject'] ?></p>
                            <p class="category"><?php echo $list[$i]['wr_8'] ?></p>
                            <span class="service"><?php echo $list[$i]['ca_name'] ?></span>
                        </div>

                    </li>
                <?php } ?>
                <?php if (count($list) == 0) { ?>
                <div class="list_none">
                    <p>게시글이 없습니다</p>
                </div>
                <?php } ?>
            </ul>
            <?php if($isWrite[0] != 'none'){?>
                <a href="<?php echo $isWrite[0] ?>" class="btn_write welfare">
                    <p>글쓰기</p>
                </a>
            <?php }?>
            </div>
        </form>
    </div>
    <?php echo newGetPaging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, get_pretty_url($bo_table, '', $qstr.'&amp;page='), 'product', $add);?>
        <!-- 게시판 검색 시작 { -->
        <div class="bo_sch_wrap">
            <fieldset class="bo_sch">
                <h3>검색</h3>
                <form name="fsearch" method="get">
                    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
                    <input type="hidden" name="sca" value="<?php echo $sca ?>">
                    <input type="hidden" name="sop" value="and">
                    <select name="sfl" id="sfl">
                        <?php echo get_board_sfl_select_options($sfl); ?>
                    </select>
                    <div class="sch_bar">
                        <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx"
                               class="sch_input" size="25" maxlength="20" placeholder="검색어를 입력해주세요">
                        <button type="submit" value="검색" class="sch_btn"><i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                    <button type="button" class="bo_sch_cls"><i class="fa fa-times" aria-hidden="true"></i></button>
                </form>
            </fieldset>
            <div class="bo_sch_bg"></div>
        </div>
        <script>
            // 게시판 검색
            $(".btn_bo_sch").on("click", function () {
                $(".bo_sch_wrap").toggle();
            })
            $('.bo_sch_bg, .bo_sch_cls').click(function () {
                $('.bo_sch_wrap').hide();
            });
        </script>
        <!-- } 게시판 검색 끝 -->

        <?php if ($is_checkbox) { ?>
            <noscript>
                <p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
            </noscript>
        <?php } ?>

        <?php if ($is_checkbox) { ?>
            <script>
                function all_checked(sw) {
                    var f = document.fboardlist;

                    for (var i = 0; i < f.length; i++) {
                        if (f.elements[i].name == "chk_wr_id[]")
                            f.elements[i].checked = sw;
                    }
                }

                function fboardlist_submit(f) {
                    var chk_count = 0;

                    for (var i = 0; i < f.length; i++) {
                        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
                            chk_count++;
                    }

                    if (!chk_count) {
                        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
                        return false;
                    }

                    if (document.pressed == "선택복사") {
                        select_copy("copy");
                        return;
                    }

                    if (document.pressed == "선택이동") {
                        select_copy("move");
                        return;
                    }

                    if (document.pressed == "선택삭제") {
                        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
                            return false;

                        f.removeAttribute("target");
                        f.action = g5_bbs_url + "/board_list_update.php";
                    }

                    return true;
                }

                // 선택한 게시물 복사 및 이동
                function select_copy(sw) {
                    var f = document.fboardlist;

                    if (sw == 'copy')
                        str = "복사";
                    else
                        str = "이동";

                    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

                    f.sw.value = sw;
                    f.target = "move";
                    f.action = g5_bbs_url + "/move.php";
                    f.submit();
                }

                // 게시판 리스트 관리자 옵션
                jQuery(function ($) {
                    $(".btn_more_opt.is_list_btn").on("click", function (e) {
                        e.stopPropagation();
                        $(".more_opt.is_list_btn").toggle();
                    });
                    $(document).on("click", function (e) {
                        if (!$(e.target).closest('.is_list_btn').length) {
                            $(".more_opt.is_list_btn").hide();
                        }
                    });
                });
            </script>
        <?php } ?>
        <!-- } 게시판 목록 끝 -->
