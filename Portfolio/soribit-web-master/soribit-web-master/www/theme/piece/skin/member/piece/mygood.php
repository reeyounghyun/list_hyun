<?php
$list = getPostGood($member['mb_id']);
?>

<div class="content list program">
    <div class="list_top not_desc">
        <h2 class="list_title">좋아요</h2>
        <p class="list_desc"></p>
    </div>
    <div class="list_contents">
        <div>
            <!-- 게시판 목록 시작 -->
            <?php if (count($list) > 0) {?>
            <ul>
                <?php for ($i = 0; $i < count($list); $i++) { ?>
                    <li>
                        <a href="<?php echo $list[$i]['href'] ?>">
                            <div class="badge">
                                <span class="type organization"><?php echo checkMemberLevel($member['mb_id'])['person'] ?></span>
                                <span class="like"><?php echo $list[$i]['wr_good'] ?></span>
                            </div>
                            <p class="list_contents-title"><?php echo $list[$i]['subject'] ?></p>
                            <span class="period"><?php echo $list[$i]['wr_datetime']?></span>
                        </a>
                    </li>
                <?php } ?>
                <?php } else if (count($list) === 0) { ?>
                    <div class="list_none">
                        <p>좋아요한 게시물이 없습니다</p>
                    </div>
                <?php } ?>
            </ul>
      </div>
    </div>
</div>
