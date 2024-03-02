<?php
// 이 파일은 새로운 파일 생성시 반드시 포함되어야 함
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$g5_debug['php']['begin_time'] = $begin_time = get_microtime();

if (!isset($g5['title'])) {
    $g5['title'] = $config['cf_title'];
    $g5_head_title = $g5['title'];
}
else {
    // 상태바에 표시될 제목
    $g5_head_title = implode(' | ', array_filter(array($g5['title'], $config['cf_title'])));
}

$g5['title'] = strip_tags($g5['title']);
$g5_head_title = strip_tags($g5_head_title);
// 현재 접속자
// 게시판 제목에 ' 포함되면 오류 발생
$g5['lo_location'] = addslashes($g5['title']);
if (!$g5['lo_location'])
    $g5['lo_location'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
$g5['lo_url'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
if (strstr($g5['lo_url'], '/'.G5_ADMIN_DIR.'/') || $is_admin == 'super') $g5['lo_url'] = '';

/*
// 만료된 페이지로 사용하시는 경우
header("Cache-Control: no-cache"); // HTTP/1.1
header("Expires: 0"); // rfc2616 - Section 14.21
header("Pragma: no-cache"); // HTTP/1.0
*/
?>
<!doctype html>
<html lang="ko">
<head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-JVNHM86B9M"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-JVNHM86B9M');
</script>
<meta charset="utf-8">
<?php
if (G5_IS_MOBILE) {
    echo '<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10,user-scalable=yes">'.PHP_EOL;
    echo '<meta name="HandheldFriendly" content="true">'.PHP_EOL;
    echo '<meta name="format-detection" content="telephone=no">'.PHP_EOL;
} else {
    echo '<meta http-equiv="imagetoolbar" content="no">'.PHP_EOL;
    echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">'.PHP_EOL;
}
echo '<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10,user-scalable=yes">'.PHP_EOL;
//description -> from 관리자페이지 -> 추가 메타태그 -> $config['cf_add_meta]
echo '<meta name="description" content="'.$config['cf_add_meta'].'">';

//TODO keyword
echo '<meta name="keyword" content="라임프렌즈, 그누보드, 개발 1팀">';

//전체 사이트 네임 from 관리자페이지 -> 홈페이지 제목 -> $config['cf_title]
echo '<meta property="og:site_name" content="'.$config['cf_title'].'">';

//페이지 네임(상태바에 표시될 제목과 동일)
echo '<meta property="og:title" content="'.$g5_head_title.'">';

//description -> from 관리자페이지 -> 추가 메타태그 -> $config['cf_add_meta]
echo '<meta property="og:description" content="'.$config['cf_add_meta'].'">';

//TODO 썸네일(임베드) 이미지
echo '<meta property="og:image" content="https://ascp.limefriends.com/img/asan/common/link_thum.png">' . PHP_EOL;
//if($config['cf_add_meta'])
//    echo $config['cf_add_meta'].PHP_EOL;
$rand_number = rand_number();
//?>
<!-- 상태바에 표시될 제목 -->
<title><?php echo $g5_head_title; ?></title>
<?php isThema($config['cf_theme'],true);?>
<!--<link rel="stylesheet" href="--><?php //echo run_replace('head_css_url', G5_THEME_CSS_URL.'/'.(G5_IS_MOBILE ? 'mobile' : 'default').'.css?ver='.G5_CSS_VER, G5_THEME_URL); ?><!--">-->
<!--[if lte IE 8]>
<script src="<?php echo G5_JS_URL ?>/html5.js"></script>
<![endif]-->
<script>
// 자바스크립트에서 사용하는 전역변수 선언
var g5_url       = "<?php echo G5_URL ?>";
var g5_bbs_url   = "<?php echo G5_BBS_URL ?>";
var g5_is_member = "<?php echo isset($is_member)?$is_member:''; ?>";
var g5_is_admin  = "<?php echo isset($is_admin)?$is_admin:''; ?>";
var g5_is_mobile = "<?php echo G5_IS_MOBILE ?>";
var g5_bo_table  = "<?php echo isset($bo_table)?$bo_table:''; ?>";
var g5_sca       = "<?php echo isset($sca)?$sca:''; ?>";
var g5_editor    = "<?php echo ($config['cf_editor'] && $board['bo_use_dhtml_editor'])?$config['cf_editor']:''; ?>";
var g5_cookie_domain = "<?php echo G5_COOKIE_DOMAIN ?>";
</script>
<?php

add_javascript('<script src="'.G5_JS_URL.'/jquery-1.8.3.min.js"></script>', 0);
add_javascript('<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>', 0);

add_stylesheet('<link rel="stylesheet" href="'.G5_JS_URL.'/font-awesome/css/font-awesome.min.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/css/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/css/responsive.css">', 0);

add_javascript('<script src="'.G5_JS_URL.'/common.js?ver='.G5_JS_VER.'"></script>', 0);
add_javascript('<script src="'.G5_JS_URL.'/wrest.js?ver='.G5_JS_VER.'"></script>', 0);
add_javascript('<script src="'.G5_JS_URL.'/placeholders.min.js"></script>', 0);
add_javascript('<script src="'.G5_THEME_URL.'/pub/assets/js/common.js?ver='.$rand_number.'"></script>', 0);

add_stylesheet('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">', 0);
add_javascript('<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>', 0);

add_stylesheet('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css">', 0);
add_javascript('<script src="'.G5_THEME_URL.'/pub/assets/js/lib/slick.js"></script>', 0);

if(G5_IS_MOBILE) {
    add_javascript('<script src="'.G5_JS_URL.'/modernizr.custom.70111.js"></script>', 1); // overflow scroll 감지
}
if(!defined('G5_IS_ADMIN'))
    echo $config['cf_add_script'];
?>
</head>
<body<?php echo isset($g5['body_script']) ? $g5['body_script'] : ''; ?>>
<header>
    <div class="header-wrap">
        <div class="header-logo">
            <img src="<?php echo G5_THEME_URL?>/pub/assets/images/header-logo.svg" alt="소리빛" class="logo-pc">
            <img src="<?php echo G5_THEME_URL?>/pub/assets/images/mobile/header-logo.svg" alt="소리빛" class="logo-mobile">
        </div>
        <div class="mobile-header">
            <img src="<?php echo G5_THEME_URL?>/pub/assets/images/mobile/menu-btn.png" alt="메뉴버튼">
        </div>
        <div class="mobil-nav">
            <div class="nav-head">
                <img src="<?php echo G5_THEME_URL?>/pub/assets/images/header-logo.svg" alt="소리빛" class="mbLogo-mobile">
                <img src="<?php echo G5_THEME_URL?>/pub/assets/images/mobile/Vector.png" alt="닫기버튼" class="cloes-btn">
            </div>
            <ul>
                <li>
                    <div class="menusub-title">
                        <span>소리빛</span>
                        <img src="<?php echo G5_THEME_URL?>/pub/assets/images/mobile/manu-icon.png" alt="소리빛">
                    </div>
                    <ul class="menuSub">
                        <li><a href="#"><span>소리빛 소개</span></a></li>
                        <li><a href="#"><span>소리빛 토탈솔루션</span></a></li>
                        <li><a href="#"><span>연구원 소개</span></a></li>
                        <li><a href="#"><span>소리빛 히스토리</span></a></li>
                        <li><a href="#"><span>오시는 길</span></a></li>
                    </ul>
                </li>
                <li>
                    <div class="menusub-title">
                        <span>Hear & Listening</span>
                        <img src="<?php echo G5_THEME_URL?>/pub/assets/images/mobile/manu-icon.png" alt="Hear & Listening">
                    </div>
                    <ul class="menuSub">
                        <li><a href="#"><span>소리빛 소개</span></a></li>
                        <li><a href="#"><span>소리빛 토탈솔루션</span></a></li>
                        <li><a href="#"><span>연구원 소개</span></a></li>
                        <li><a href="#"><span>소리빛 히스토리</span></a></li>
                        <li><a href="#"><span>오시는 길</span></a></li>
                    </ul>
                </li>
                <li>
                    <div class="menusub-title">
                        <span>Speech</span>
                        <img src="<?php echo G5_THEME_URL?>/pub/assets/images/mobile/manu-icon.png" alt="Speech">
                    </div>
                    <ul class="menuSub">
                        <li><a href="#"><span>소리빛 소개</span></a></li>
                        <li><a href="#"><span>소리빛 토탈솔루션</span></a></li>
                        <li><a href="#"><span>연구원 소개</span></a></li>
                        <li><a href="#"><span>소리빛 히스토리</span></a></li>
                        <li><a href="#"><span>오시는 길</span></a></li>
                    </ul>
                </li>
                <li>
                    <div class="menusub-title">
                        <span>통합발달 모니터링</span>
                        <img src="<?php echo G5_THEME_URL?>/pub/assets/images/mobile/manu-icon.png" alt="통합발달 모니터링">
                    </div>
                    <ul class="menuSub">
                        <li><a href="#"><span>소리빛 소개</span></a></li>
                        <li><a href="#"><span>소리빛 토탈솔루션</span></a></li>
                        <li><a href="#"><span>연구원 소개</span></a></li>
                        <li><a href="#"><span>소리빛 히스토리</span></a></li>
                        <li><a href="#"><span>오시는 길</span></a></li>
                    </ul>
                </li>
                <li>
                    <div class="menusub-title">
                        <span>사회성 캠프</span>
                        <img src="<?php echo G5_THEME_URL?>/pub/assets/images/mobile/manu-icon.png" alt="사회성 캠프">
                    </div>
                    <ul class="menuSub">
                        <li><a href="#"><span>소리빛 소개</span></a></li>
                        <li><a href="#"><span>소리빛 토탈솔루션</span></a></li>
                        <li><a href="#"><span>연구원 소개</span></a></li>
                        <li><a href="#"><span>소리빛 히스토리</span></a></li>
                        <li><a href="#"><span>오시는 길</span></a></li>
                    </ul>
                </li>
                <li>
                    <div class="menusub-title">
                        <span>커뮤니티</span>
                        <img src="<?php echo G5_THEME_URL?>/pub/assets/images/mobile/manu-icon.png" alt="커뮤니티">
                    </div>
                    <ul class="menuSub">
                        <li><a href="#"><span>소리빛 소개</span></a></li>
                        <li><a href="#"><span>소리빛 토탈솔루션</span></a></li>
                        <li><a href="#"><span>연구원 소개</span></a></li>
                        <li><a href="#"><span>소리빛 히스토리</span></a></li>
                        <li><a href="#"><span>오시는 길</span></a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <nav class="nev-wrap">
            <ul>
                <li><a href="#"><span>연구소 소개</span></a></li>
                <li><a href="#"><span>Hear & Listening</span></a></li>
                <li><a href="#"><span>Speech</span></a></li>
                <li><a href="#"><span>통합발달 모니터링</span></a></li>
                <li><a href="#"><span>사회성 통합 캠프</span></a></li>
                <li><a href="#"><span>커뮤니티</span></a></li>
            </ul>
        </nav>
        <div class="header-call">
            <div class="call-box">
                <img src="<?php echo G5_THEME_URL?>/pub/assets/images/main-icon.png" alt="상담예약 031-702-1016">
            </div>
            <div class="call-txtBox">
                <span class="call-txt">상담예약</span>
                <span class="call-number">031-702-1016</span>
            </div>
        </div>
    </div>
</header>

<script>
    //모바일 메뉴 클릭이벤트
    function mobileSeb() {
        $(".mobile-header, .cloes-btn").click(function () {
            $(".mobil-nav").toggleClass("on off");
        });
    }
    mobileSeb();


    //모바일 서브메뉴 클릭이벤트
    function mobileNav() {
    $(".menusub-title").click(function() {
        var clickedMenuSub = $(this).siblings('.menuSub');
        $(".menuSub").not(clickedMenuSub).slideUp("close");
        clickedMenuSub.slideToggle("open close");
        $(this).find('img').toggleClass("rotated");
        $(".menusub-title").not(this).find('img').removeClass("rotated");
    });
    }
    mobileNav();
</script>
<?php
//if ($is_member) { // 회원이라면 로그인 중이라는 메세지를 출력해준다.
//    $sr_admin_msg = '';
//    if ($is_admin == 'super') $sr_admin_msg = "최고관리자 ";
//    else if ($is_admin == 'group') $sr_admin_msg = "그룹관리자 ";
//    else if ($is_admin == 'board') $sr_admin_msg = "게시판관리자 ";
//
//    echo '<div id="hd_login_msg">'.$sr_admin_msg.get_text($member['mb_nick']).'님 로그인 중 ';
//    echo '<a href="'.G5_BBS_URL.'/logout.php">로그아웃</a></div>';
//}
