<div class="main-header">
    <a href="<?php echo $_SERVER['HTTP_REFERER'];?>" class="location">
        <img src="<?php echo G5_THEME_URL?>/pub/assets/images/arrow_back.png" alt="뒤로가기" class="icon">
    </a>
    <a href="<?php echo G5_URL ?>" class="logo_wrap">
        <img src="<?php echo G5_THEME_URL?>/pub/assets/images/logo_color.png" alt="피스" class="logo_page">
    </a>
    <?php if($is_member) {?>
    <a class="notification mypage" href="<?php echo G5_BBS_URL.'/mypage.php'?>">
        <p>마이페이지</p>
    </a>
    <?php } else { ?>
        <a class="notification login" href="<?php echo G5_BBS_URL.'/login.php'?>">
            <p>로그인</p>
        </a>
    <?php } ?>
</div>

