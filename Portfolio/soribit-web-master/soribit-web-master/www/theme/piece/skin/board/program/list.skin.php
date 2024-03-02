<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 2;

if ($is_checkbox) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
$get_all_list = getAllList();
$get_city_list = getCityList();
$get_type_explode = getExplode($board['bo_1'], '|');
$_GET['city'] === 'all' ? $city_text = "전체" : $city_text = $_GET['city'];
$_GET['district'] === 'all' ? $district_text = "전체" : $district_text = $_GET['district'];
$_GET['type'] === 'all' ? $type_text = "전체" : $type_text = $_GET['type'] ;
$isWrite = isWriteUser($member['mb_1'],$bo_table,$is_member);
if(isset($_GET['filter_search'])){$add = '&filter_search=filter_search&city='.$_GET['city'].'&district='.$_GET['district'].'&type='.$_GET['type'];}
include_once(G5_THEME_PATH . '/pub/component/index.navigation.php');
?>
<div class="content list program">
    <div class="list_top">
        <h2 class="list_title">프로그램</h2>
        <p class="list_desc">장애인들을 위한 복지 혜택을 알려드려요</p>
    </div>
    <div class="list_search">
        <p class="list_search-title">검색하기</p>
        <form action="<?php echo G5_BBS_URL; ?>/board.php" method="GET" class="select_group">
            <input type="hidden" name="bo_table" value="program">
            <input type="hidden" name="filter_search" value="filter_search">
            <div class="select_box">
                <input type="hidden" name="city" value="<?php if(isset($_GET['city'])) { echo $_GET['city'];} else {echo "all";} ?>">
                <button type="button" class="select_btn">
                    <span class="current"><?php if(!$city_text) {echo "전체";} else {echo $city_text;} ?></span>
                </button>
                <ul class="list">
                    <li>
                        <button type="button" class="item city" name="all">전체</button>
                    </li>
                    <?php foreach( $get_city_list as $iValue){?>
                    <li>
                        <button type="button" class="item city" name="<?php echo $iValue?>"><?php echo $iValue?></button>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="select_box">
                <input type="hidden" name="district" value="<?php if(isset($_GET['district'])) { echo $_GET['district'];} else {echo "all";} ?>">
                <button type="button" class="select_btn" <?php if(isset($_GET['city']) === '전체' || !$_GET['city']) { echo "disabled";} ?>>
                    <span class="current"><?php if (!$district_text) {
                            echo "전체";
                        } else {
                            echo $district_text;
                        }?></span>
                </button>
                <ul id="district" class="list">
                    <li>
                        <button type="button" class="item" name="all">전체</button>
                    </li>
                </ul>
            </div>
            <div class="select_box handicap">
                <input type="hidden" name="type" value="<?php if(isset($_GET['type'])) { echo $_GET['type'];} else {echo "all";} ?>">
                <button type="button" class="select_btn">
                    <span class="current"><?php if (!$type_text) {
                            echo "전체";
                        } else {
                            echo $type_text;
                        } ?></span>
                </button>
                <ul class="list">
                    <li>
                        <button type="button" class="item" name="all">전체</button>
                    </li>
                    <?php foreach( $get_type_explode as $iValue){?>
                    <li>
                        <button type="button" class="item" name="<?php echo $iValue?>"><?php echo $iValue?></button>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <button type="submit" class="btn_search">검색</button>
        </form>
    </div>
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
                    <?php $print_date = printDate($list[$i]['wr_11'], $list[$i]['wr_1'], $list[$i]['wr_2']); ?>
                    <li>
                        <a href="<?php echo $list[$i]['href'] ?>">
                            <div class="badge">
                                <span class="type organization"><?php echo $list[$i]['wr_12'] ?></span>
                                <span class="address"><?php echo $list[$i]['wr_8'].'&nbsp;'.$list[$i]['wr_9']?></span>
                                <?php if($list[$i]['wr_10']) {?>
                                <span class="hashtag"><?php echo '#'.$list[$i]['wr_10'] ?></span>
                                <?php } ?>
                            </div>
                            <p class="list_contents-title"><?php echo $list[$i]['subject'] ?></p>
                            <span class="period <?php echo $print_date['class']?>"><?php echo $print_date['date']?></span>
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
        <?php if($isWrite[0] != 'none'){?>
        <a href="<?php echo $isWrite[0] ?>" class="btn_write welfare">
            <p>글쓰기</p>
        </a>
        <?php }?>
    </div>
    <?php echo newGetPaging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, get_pretty_url($bo_table, '', $qstr.'&amp;page='), 'program', $add);?>
</div>
<script>
    function getList(){
        var ul_tag = $("#district");
        ul_tag.html(`<li><button type="button" class="item" name="all">전체</button></li>`);
        var text = $(this).text();
        var value = $(this).attr('name');
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
        if($(this).attr('name') === 'all'){
            ul_tag.siblings('button').prop('disabled', true);
            ul_tag.siblings('button').children('span').html(`구`);
            ul_tag.siblings('input[type=hidden]').val(`all`);
        }
    }
    function LoadList(){
        var value = $("input[name='city']").val();
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
    $(document).on('click', '.select_box .city' ,getList);
    $(document).on('ready', LoadList);


</script>
<?php
include_once(G5_THEME_PATH . '/pub/component/footer.navigation.php'); ?>
