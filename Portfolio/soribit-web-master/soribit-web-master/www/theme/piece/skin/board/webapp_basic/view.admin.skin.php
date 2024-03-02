<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
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
<ul class="btn_bo_user bo_v_com">
				<li><a href="<?php echo $list_href ?>" class="btn_b01 btn" title="목록"><i class="fa fa-list" aria-hidden="true"></i></a></li>
	            <?php if ($reply_href) { ?><li><a href="<?php echo $reply_href ?>" class="btn_b01 btn" title="답변"><i class="fa fa-reply" aria-hidden="true"></i></a></li><?php } ?>
	            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b01 btn" title="글쓰기"><i class="fa fa-pencil" aria-hidden="true"></i></a></li><?php } ?>
                <?php if ($update_href) { ?><li><a href="<?php echo $update_href ?>">수정<i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></li><?php } ?>
                <?php if ($delete_href) { ?><li><a href="<?php echo $delete_href ?>" onclick="del(this.href); return false;">삭제<i class="fa fa-trash-o" aria-hidden="true"></i></a></li><?php } ?>
	        </ul>
<section class="content list">

    <button type="button" class="primary" id="report "onclick="modal('#report','open')" >신고하기</button>
    <a class="report_primary primary"href="<?php echo G5_THEME_URL.'/skin/board/webapp_basic/update_report.php?bo_table=free&postid='.$view['wr_id'].'&memberid='.$member['mb_id'].'&reason='.'불건전'?>">불건전</a>
    <a class="report_primary primary"href="<?php echo G5_THEME_URL.'/skin/board/webapp_basic/update_report.php?bo_table=free&postid='.$view['wr_id'].'&memberid='.$member['mb_id'].'&reason='.'홍보성'?>">홍보성</a>
    <a class="report_primary primary"href="<?php echo G5_THEME_URL.'/skin/board/webapp_basic/update_report.php?bo_table=free&postid='.$view['wr_id'].'&memberid='.$member['mb_id'].'&reason='.'기타'?>">기타</a>
    <div class="info_detail">
        <div class="info_detail-title">
        <p class="info_card-agency"><?php echo $view['wr_3'];  //분류 출력 끝 ?></p>
        <p class="info_card-title"><?php echo cut_str(get_text($view['wr_subject']), 70);  //글제목 출력 ?></p>
        <p class="info_card-date">공지기간 <?php echo $view['wr_1'] ?><?php echo $view['wr_1'] ?></p>
        <a href="<?php echo $scrap_href; ?>" class="btn_bookmark">북마크</a>
        <a href="<?php echo $scrap_href; ?>" target="_blank" class=" btn_bookmark" onclick="win_scrap(this.href); return false;" title="스크랩">북마크</a>
        </div>
        <div class="info_detail-content">
            <?php
            $v_img_count = count($view['file']);
            if($v_img_count) {
                echo "<div>\n";

                foreach ($view['file'] as $view_file) {
                    echo get_file_thumbnail($view_file);
                }
                echo "</div>\n";
            }
            ?>
            <p><?php echo get_view_thumbnail($view['content']); ?></p>
            <br/>
            <p class="info_card-title"><a href="<?php echo G5_BBS_URL."/board.php?bo_table=$bo_table"?>">목록으로</a></p>
            <p class="info_card-title"><?php if ($delete_href) { ?><a href="<?php echo $delete_href ?>" onclick="del(this.href); return false;">게시글 삭제<i class="fa fa-trash-o" aria-hidden="true"></i></a><?php } ?></p>
        </div>
    </div>
</section>
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

<ul class="btn_bo_user bo_v_com">
</ul>
    <?php if($cnt) { ?>
        <section id="bo_v_file">
            <h2>첨부파일</h2>
            <ul>
                <?php
                // 가변 파일
                for ($i=0; $i<count($view['file']); $i++) {
                    if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
                        ?>
                        <li>
                            <a href="<?php echo $view['file'][$i]['href'];  ?>" class="view_file_download">
                                <i class="fa fa-download" aria-hidden="true"></i>
                                <strong><?php echo $view['file'][$i]['source'] ?></strong>
                                <?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
                            </a>
                            <span class="bo_v_file_cnt"><?php echo $view['file'][$i]['download'] ?>회 다운로드</span> |
                            <span>DATE : <?php echo $view['file'][$i]['datetime'] ?></span>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </section>
    <?php } ?>

    <?php if(isset($view['link']) && array_filter($view['link'])) { ?>
        <!-- 관련링크 시작 { -->
        <section id="bo_v_link">
            <h2>관련링크</h2>
            <ul>
                <?php
                // 링크
                $cnt = 0;
                for ($i=1; $i<=count($view['link']); $i++) {
                    if ($view['link'][$i]) {
                        $cnt++;
                        $link = cut_str($view['link'][$i], 70);
                        ?>
                        <li>
                            <a href="<?php echo $view['link_href'][$i] ?>" target="_blank">
                                <i class="fa fa-link" aria-hidden="true"></i>
                                <strong><?php echo $link ?></strong>
                            </a>
                            <span class="bo_v_link_cnt"><?php echo $view['link_hit'][$i] ?>회 연결</span>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </section>
        <!-- } 관련링크 끝 -->
    <?php } ?>
</section>

    <?php
    // 코멘트 입출력
    include_once(G5_BBS_PATH.'/view_comment.php');
	?>

<script>
<?php if ($board['bo_download_point'] < 0) { ?>
$(function() {
    $("a.view_file_download").click(function() {
        if(!g5_is_member) {
            alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
            return false;
        }

        var msg = "파일을 다운로드 하시면 포인트가 차감(<?php echo number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";

        if(confirm(msg)) {
            var href = $(this).attr("href")+"&js=on";
            $(this).attr("href", href);

            return true;
        } else {
            return false;
        }
    });
});
<?php } ?>

function board_move(href)
{
    window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}
</script>

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
</script>
