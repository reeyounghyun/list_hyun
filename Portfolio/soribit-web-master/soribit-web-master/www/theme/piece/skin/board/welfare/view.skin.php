<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
include_once(G5_THEME_PATH . '/pub/component/view.navigation.php');
$print_date = printDate($view['wr_11'], $view['wr_1'], $view['wr_2']);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<script>
    jQuery(function($){
        // 게시판 보기 버튼 옵션
        $(".btn_more_opt.is_view_btn").on("click", function(e) {
            e.stopPropagation();
            $(".more_opt.is_view_btn").toggle();
        });
        // 게시글 공유
        $(".btn_share_opt").on("click", function(e) {
            e.stopPropagation();
            $("#bo_v_share").toggle();
        });
        $(document).on("click", function (e) {
            if(!$(e.target).closest('.is_view_btn').length) {
                $(".more_opt.is_view_btn").hide();
                $("#bo_v_share").hide();
            }
        });
    });
</script>
<div class="content view program">
    <div class="list_top not_desc">
        <h2 class="list_title">복지·혜택</h2>
    </div>
    <div class="view_top">
        <p class="address"><?php echo $view['wr_8'].'&nbsp;'.$view['wr_9']?></p>
        <p class="title"><?php echo cut_str(get_text($view['wr_subject']), 70);  //글제목 출력 ?></p>
        <p class="date">기간 <?php echo $print_date['date']?></p>
        <span class="type organization"><?php echo $view['wr_12']?></span>
    </div>
    <div class="view_contents">
        <div class="text">
            <?php
            // 파일 출력
            $v_img_count = count($view['file']);
            if($v_img_count) {
                echo "<div id=\"bo_v_img\">\n";

                foreach($view['file'] as $view_file) {
                    echo get_file_thumbnail($view_file);
                }

                echo "</div>\n";
            }
            ?>
            <?php echo get_view_thumbnail($view['content']); ?>
        </div>
    </div>
    <div class="btn_group">
        <?php if ($delete_href) { ?><button type="button" class="btn_delete" onclick="Piece.layerOpen('.layer_delete')">삭제</button><?php } ?>
        <?php if ($update_href) { ?><a href="<?php echo $update_href ?>"  class="btn_modify">수정</a><?php } ?>
        <a href="<?php echo $list_href ?>" class="btn_list">목록</a>
    </div>
<!--    <button type="button" class="primary" id="report "onclick="modal('#report','open')" >신고하기</button>-->
<!--    <a class="report_primary primary"href="--><?php //echo G5_THEME_URL.'/skin/board/webapp_basic/update_report.php?bo_table=free&postid='.$view['wr_id'].'&memberid='.$member['mb_id'].'&reason='.'불건전'?><!--">불건전</a>-->
<!--    <a class="report_primary primary"href="--><?php //echo G5_THEME_URL.'/skin/board/webapp_basic/update_report.php?bo_table=free&postid='.$view['wr_id'].'&memberid='.$member['mb_id'].'&reason='.'홍보성'?><!--">홍보성</a>-->
<!--    <a class="report_primary primary"href="--><?php //echo G5_THEME_URL.'/skin/board/webapp_basic/update_report.php?bo_table=free&postid='.$view['wr_id'].'&memberid='.$member['mb_id'].'&reason='.'기타'?><!--">기타</a>-->
</div>
<section>
    <?php
    $cnt = 0;
    if ($view['file']['count']) {
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
                $cnt++;
        }
    }
    ?>
    <div class="layer layer_delete is-hidden">
        <div class="inner">
            <div class="contents">
                <div class="desc">게시물을 삭제하시겠습니까?</div>
            </div>
            <div class="btn_group">
                <button type="button" class="button white" onclick="Piece.layerClose('.layer_delete')">취소</button>
                <button type="button" class="button color pink" onclick="delete_this('<?php echo $delete_href ?>'); return false;">삭제</button>
            </div>
        </div>
    </div>
<!-- 게시글 보기 끝 -->

<script>
$(function() {
    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 추천, 비추천
    $("#good_button, #nogood_button").click(function() {
        var $tx;
        if(this.id == "good_button")
            $tx = $("#bo_v_act_good");
        else
            $tx = $("#bo_v_act_nogood");

        excute_good(this.href, $(this), $tx);
        return false;
    });

    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});

function excute_good(href, $el, $tx)
{
    $.post(
        href,
        { js: "on" },
        function(data) {
            if(data.error) {
                alert(data.error);
                return false;
            }

            if(data.count) {
                $el.find("strong").text(number_format(String(data.count)));
                if($tx.attr("id").search("nogood") > -1) {
                    $tx.text("이 글을 비추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                } else {
                    $tx.text("이 글을 추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                }
            }
        }, "json"
    );
}
function delete_this(href){
    var iev = -1;
    if (navigator.appName == 'Microsoft Internet Explorer') {
        var ua = navigator.userAgent;
        var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
        if (re.exec(ua) != null)
            iev = parseFloat(RegExp.$1);
    }
    // IE6 이하에서 한글깨짐 방지
    if (iev != -1 && iev < 7) {
        document.location.href = encodeURI(href);
    } else {
        document.location.href = href;
    }
}
</script>
<?php
include_once(G5_THEME_PATH . '/pub/component/footer.navigation.php'); ?>
