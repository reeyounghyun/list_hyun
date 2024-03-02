<?php
include_once("./_common.php");
if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH . '/index.php');
    return;
}
include_once(G5_THEME_PATH . '/head.php');

?>
<section class="main-section">
    <div class="carousel-wrap swiper mySwiper">
        <div class="bannerSlide swiper-wrapper">
            <div class="item swiper-slide">
                <div class="item-txt">
                    <span>소리에 빛 비추다!</span>
                    <p>듣는 것과 말하는 것에 <br/>
                    어려움을 가진 아동과 <br/>
                    성인을 돕습니다.</p>
                </div>
            </div>
            <div class="item swiper-slide">
                <div class="item-txt">
                    <span>소리에 빛 비추다!</span>
                    <p>듣는 것과 말하는 것에 <br/>
                    어려움을 가진 아동과 <br/>
                    성인을 돕습니다.</p>
                </div>
            </div>
            <div class="item swiper-slide">
                <div class="item-txt">
                    <span>소리에 빛 비추다!</span>
                    <p>듣는 것과 말하는 것에 <br/>
                    어려움을 가진 아동과 <br/>
                    성인을 돕습니다.</p>
                </div>
            </div>
        </div>
        <div class="swiper-pagination slide-dots">
            <span></span>
            <span class="main-more"></span>
        </div>
    </div>
    <div class="main-contents">
        <div class="main-cont1 comm-width">
            <div class="cont1">
                <a href="#">
                    <div class="cont1-item">
                        <h2>Hear & Listening</h2>
                        <span>듣기</span>
                    </div>
                </a>
            </div>
            <div class="cont1 cont2">
                <a href="#">
                    <div class="cont1-item">
                        <h2>Speech</h2>
                        <span>말하기</span>
                    </div>
                </a>
            </div>
        </div>
        <div class="main-cont2 comm-width">
            <div class="title">
                <h3>나에게 필요한<br/>프로그램은?</strong></h3>
                <p>유소아, 학령기,청소년,성인에 각 시기에 맞는 프로그램 </p>
            </div>
            <ul>
                <li>
                    <a href="#">
                        <div class="cont2-item">
                            <span class="cont2-title">유소아-학령기</span>
                            <span class="cont2-txt">우리 아이가 <br/><strong>난청</strong>이에요</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="cont2-item">
                            <span class="cont2-title">유소아-학령기</span>
                            <span class="cont2-txt">우리 아이가 <strong>말하는데</strong><br/>어려움이 있어요</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="cont2-item">
                            <span class="cont2-title">청소년-성인</span>
                            <span class="cont2-txt">소리를 <strong> 듣고 말하는데 </strong><br/>어려움이 있어요</span>
                        </div>
                    </a>
                </li>
            </ul>
            <div class="mobile-cont2">
                <ul class="mbCont2">
                    <li>
                        <a href="#">
                            <div class="cont2-item">
                                <span class="cont2-title">유소아-학령기</span>
                                <span class="cont2-txt">우리 아이가 <br/><strong>난청</strong>이에요</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="cont2-item">
                                <span class="cont2-title">유소아-학령기</span>
                                <span class="cont2-txt">우리 아이가 <strong>말하는데</strong><br/>어려움이 있어요</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="cont2-item">
                                <span class="cont2-title">청소년-성인</span>
                                <span class="cont2-txt">소리를 <strong> 듣고 말하는데 </strong><br/>어려움이 있어요</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-cont3">
            <div class="title">
                <h4>소리빛 추천자의 <strong> <br/>추천 한마디!</strong></h4>
                <p>소리빛 프로그램 리뷰</p>
            </div>
            <ul>
                <li>
                    <span>우리 아이 음성 모니터링</span>
                    <p><strong>아이가 목소리 크기 조절을 잘 못하고 발음이 분명하지 못했는데 </br></strong> 소리빛 프로그램으로 좋아졌어요</p>
                    <div class="cont3-inform">
                        <div>
                            <span class="inform-naem">박**</span>
                            <span class="inform-day">2024.2.13</span>
                        </div>
                        <img src="<?php echo G5_THEME_URL?>/pub/assets/images/cont-icon.png" alt="쌍따음표">
                    </div>
                </li>
                <li>
                    <span>통합 발달 모니터링</span>
                    <p><strong> 통합발달 모니터링으로 발달 수준을 이해하고 초기에 발견하여</br></strong>적절한 프로그램을 진행할 수 있었어요! 감사합니다.</p>
                    <div class="cont3-inform">
                        <div>
                            <span class="inform-naem">박**</span>
                            <span class="inform-day">2024.2.13</span>
                        </div>
                    <img src="<?php echo G5_THEME_URL?>/pub/assets/images/cont-icon.png" alt="쌍따음표">
                    </div>
                </li>
                <li>
                    <span>영유아 난청 가이드</span>
                    <p><strong> 청각선별검사로 아이의 난청을 처음알게되었을때 어떻게 해야할지 막막했는데,</br></strong>영유아 난청 가이드로 많은 도움을 받았습니다.</p>
                    <div class="cont3-inform">
                        <div>
                            <span class="inform-naem">박**</span>
                            <span class="inform-day">2024.2.13</span>
                        </div>
                    <img src="<?php echo G5_THEME_URL?>/pub/assets/images/cont-icon.png" alt="쌍따음표">
                    </div>
                </li>
            </ul>
            <div class="mobile-cont3">
                <ul class="mbCont3">
                    <li>
                        <span>우리 아이 음성 모니터링</span>
                        <p><strong>아이가 목소리 크기 조절을 잘 못하고 발음이 분명하지 못했는데 </br></strong> 소리빛 프로그램으로 좋아졌어요</p>
                        <div class="cont3-inform">
                            <div>
                                <span class="inform-naem">박**</span>
                                <span class="inform-day">2024.2.13</span>
                            </div>
                            <img src="<?php echo G5_THEME_URL?>/pub/assets/images/cont-icon.png" alt="쌍따음표">
                        </div>
                    </li>
                    <li>
                        <span>통합 발달 모니터링</span>
                        <p><strong> 통합발달 모니터링으로 발달 수준을 이해하고 초기에 발견하여</br></strong>적절한 프로그램을 진행할 수 있었어요! 감사합니다.</p>
                        <div class="cont3-inform">
                            <div>
                                <span class="inform-naem">박**</span>
                                <span class="inform-day">2024.2.13</span>
                            </div>
                        <img src="<?php echo G5_THEME_URL?>/pub/assets/images/cont-icon.png" alt="쌍따음표">
                        </div>
                    </li>
                    <li>
                        <span>영유아 난청 가이드</span>
                        <p><strong> 청각선별검사로 아이의 난청을 처음알게되었을때 어떻게 해야할지 막막했는데,</br></strong>영유아 난청 가이드로 많은 도움을 받았습니다.</p>
                        <div class="cont3-inform">
                            <div>
                                <span class="inform-naem">박**</span>
                                <span class="inform-day">2024.2.13</span>
                            </div>
                        <img src="<?php echo G5_THEME_URL?>/pub/assets/images/cont-icon.png" alt="쌍따음표">
                        </div>
                    </li>
                    <li>
                        <span>우리 아이 음성 모니터링</span>
                        <p><strong>아이가 목소리 크기 조절을 잘 못하고 발음이 분명하지 못했는데 </br></strong> 소리빛 프로그램으로 좋아졌어요</p>
                        <div class="cont3-inform">
                            <div>
                                <span class="inform-naem">박**</span>
                                <span class="inform-day">2024.2.13</span>
                            </div>
                            <img src="<?php echo G5_THEME_URL?>/pub/assets/images/cont-icon.png" alt="쌍따음표">
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<script>
    //메인 페이지 슬라이드
    document.addEventListener('DOMContentLoaded', function () {
        var mySwiper = new Swiper('.carousel-wrap', {
            slidesPerView : '1',
            loop : true,
            autoplay: false,
            // 페이드 효과 설정
            effect: 'fade',
            speed: 800,
            fadeEffect: {
                crossFade: true
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
                type: "fraction",
            }
        });
        mySwiper.on('slideChange', function () {
            document.querySelector('.swiper-slide-active .item-txt').classList.add('text-visible');
        });
    });
    
    // 모바일 Cont2 슬라이드
    $('.mbCont2').slick({
        dots: false,
        speed: 2500,
        infinite: true, 
        autoplay:false,
        arrows: false,  
        slidesToShow: 1,
        slidesToScroll: 1,
        centerMode: true,
        variableWidth: true
    });

    //모바일 Cont3 슬라이드 
    $('.mbCont3').slick({
        dots: false,
        speed: 2500,
        infinite: true, 
        autoplay:false,
        arrows: false,  
        slidesToShow: 1,
        slidesToScroll: 1,
        centerMode: true,
        variableWidth: true
    });
</script>

<?php
include_once(G5_THEME_PATH . '/tail.php');
