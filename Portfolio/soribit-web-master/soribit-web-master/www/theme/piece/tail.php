<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/tail.php');
    return;
}
?>

<footer class="footer">
    <div class="footer-wrap">
        <div class="logo-footer">
            <a href="#">
                <img src="<?php echo G5_THEME_URL?>/pub/assets/images/logo_footer.png" alt="소리빛">
            </a>
        </div>
        <div class="sns-footer">
            <ul>
                <li>
                    <a href="#">
                    <img src="<?php echo G5_THEME_URL?>/pub/assets/images/sns-icon1.png" alt="네이버">
                    </a>
                </li>
                <li>
                    <a href="#">
                    <img src="<?php echo G5_THEME_URL?>/pub/assets/images/sns-icon2.png" alt="카카오톡">
                    </a>
                </li>
                <li>
                    <a href="#">
                    <img src="<?php echo G5_THEME_URL?>/pub/assets/images/sns-icon3.png" alt="인스타그램">
                    </a>
                </li>
            </ul>
        </div>
        <div class="main-footer">
            <ul>
                <li>상호명: 소리빛  </li>
                <li>대표: 이상미 이메일: soribit@gmail.com</li>
            </ul>
            <ul class="main-txt-2">
                <li>주소: 경기 성남시 수정구 청계산로 686 판교반도아이비밸리지식산업센터 3층 333, 334호</li>
            </ul>
            <ul>
                <li>상담문의 031 702 1016</li>
                <li>치료 및 상담시간 월-금 09:30 - 19:00</li>
            </ul>
        </div>
        <div class="link-footer">
            <ul>
                <li>
                    <a href="#">
                        <span>소리빛 소개</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span>이용약관</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span>개인정보처리방침</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span>오시는 길</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <p class="copyright-footer">COPYRIGHT 2024 SORIBIT ALL RIGHTS RESERVED.</p>
</footer>
<?php
include_once(G5_THEME_PATH."/tail.sub.php");
