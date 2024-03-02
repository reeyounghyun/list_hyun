<div class="content my_page">
    <div class="list_top not_desc">
        <h2 class="list_title">마이페이지</h2>
    </div>
    <ul class="my_page_contents">
        <li>
            <a href="<?php echo G5_BBS_URL.'/myuserinfo.php'?>" class="item info">
                <p>회원정보</p>
            </a>
        </li>
        <li>
            <a href="<?php echo G5_BBS_URL.'/mywrite.php'?>" class="item write">
                <p>작성한 글</p>
            </a>
        </li>
        <li>
            <a href="<?php echo G5_BBS_URL.'/mygood.php'?>" class="item like">
                <p>좋아요</p>
            </a>
        </li>
    </ul>
    <div class="my_page_list">
        <a href="<?php echo G5_BBS_URL.'/privacy_policy.php'?>">개인정보방침 및 약관</a>
        <button type="button" onclick="Piece.layerOpen('.layer_logout')">로그아웃</button>
        <button type="button" onclick="Piece.layerOpen('.layer_quit')">회원탈퇴</button>
    </div>
</div>
<div class="layer layer_logout is-hidden">
    <div class="inner">
        <div class="contents">
            <div class="desc">로그아웃 하시겠습니까?</div>
        </div>
        <div class="btn_group">
            <button type="button" class="button white" onclick="Piece.layerClose('.layer_logout')">아니요</button>
            <a href="<?php echo G5_BBS_URL.'/logout.php'?>" class="button color grey">네</a>
        </div>
    </div>
</div>
<div class="layer layer_quit is-hidden">
    <div class="inner">
        <div class="contents">
            <div class="desc">정말 탈퇴 하시겠습니까?</div>
        </div>
        <div class="btn_group">
            <button type="button" class="button white" onclick="Piece.layerClose('.layer_quit')">아니요</button>
            <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=member_leave.php" class="button color grey">네</a>
        </div>
    </div>
</div>
