$(document).ready(function () {
	common_load(); // 문서로드
	Swiper_event(); // 슬라이드 이벤트
	selectBox(); // 셀렉트 박스 이벤트
	// aside_event () // 사이드바 이벤트
	tab_event(); // 탭 메뉴 이벤트
	btnClick_event(); // 클릭 이벤트
});

// 헤더 푸터로드
function common_load() {
	$('.header').load('header.html .header .header_inner', function () {
		menu_hover_event(); // 메뉴 호버 이벤트
		banner_close_event(); // 상단 배너 닫기 이벤트
		allmenu(); // allmenu 이벤트

		// 전체메뉴 클릭 이벤트
		$('.mb_right_btn').click(function () {
			$('.quick_menu').toggleClass('acitve');
			$('body').css({
				overflow: 'hidden',
				position: 'fixed',
			});
		});

		// 모바일 메뉴 취소버튼
		$('.quick_menu .mobile_close').click(function () {
			if ($('.quick_menu').hasClass('acitve')) {
				$('.quick_menu').removeClass('acitve');
				$('this').removeClass('acitve');
			} else {
				$('.quick_menu').addClass('acitve');
				$(this).addClass('acitve');
			}
			$('body').css({
				overflow: 'visible',
				position: 'static',
			});
		});

		// 실시간 검색 순위
		var swiper = new Swiper('.rank_list', {
			direction: 'vertical',
			loop: true,
			spaceBetween: 30,
			centeredSlides: true,
			autoplay: {
				delay: 2500,
				disableOnInteraction: false,
			},
		});
	});
	$('.footer').load('footer.html .footer .footer_inner', function () {
		// 공지사항
		var swiper = new Swiper('.notice', {
			direction: 'vertical',
			loop: true,
			spaceBetween: 30,
			centeredSlides: true,
			autoplay: {
				delay: 2500,
				disableOnInteraction: false,
			},
		});

		// footer 슬라이드
		var swiper = new Swiper('.footer_swiper', {
			slidesPerView: 3,
			slidesPerGroup: 3,
			loop: true,
			navigation: {
				nextEl: '.next-footer',
				prevEl: '.prev-footer',
			},
		});
	});
}

// 슬라이드 이벤트
function Swiper_event() {
	// 비쥬얼 슬라이드
	var visual_swiper = new Swiper('.color_slide', {
		spaceBetween: 30,
		centeredSlides: true,
		loop: true,
		autoplay: {
			delay: 2500,
			disableOnInteraction: false,
		},
		pagination: {
			el: '.swiper-pagination',
			type: 'fraction',
		},
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
	});
	// 비쥬얼 슬라이드 배경
	visual_swiper.on('slideChange', function () {
		var current_slide = visual_swiper.activeIndex;
		if (current_slide == '1') {
			$('.wrapper').css('background-color', '#E2DAF2');
		} else if (current_slide == '2') {
			$('.wrapper').css('background-color', '#E4EFD0');
		} else if (current_slide == '3') {
			$('.wrapper').css('background-color', '#F1E6CC');
		} else if (current_slide == '4') {
			$('.wrapper').css('background-color', '#D5EAFD');
		} else if (current_slide == '5') {
			$('.wrapper').css('background-color', '#E2DAF2');
		} else if (current_slide == '6') {
			$('.wrapper').css('background-color', '#E4EFD0');
		} else {
			$('.wrapper').css('background-color', '#F1E6CC');
		}
	});

	// 비쥬얼 슬라이드 컨트롤러
	$('.btn_play').click(function () {
		var state = $(this).hasClass('stop');
		if (state) {
			visual_swiper.autoplay.start();
			$(this).removeClass('stop');
		} else if (!state) {
			visual_swiper.autoplay.stop();
			$(this).addClass('stop');
		}
	});

	// 공지사항
	var swiper = new Swiper('.notice', {
		direction: 'vertical',
		loop: true,
		spaceBetween: 30,
		centeredSlides: true,
		autoplay: {
			delay: 2500,
			disableOnInteraction: false,
		},
	});

	// footer 슬라이드
	var swiper = new Swiper('.footer_swiper', {
		slidesPerView: 3,
		slidesPerGroup: 3,
		loop: true,
		navigation: {
			nextEl: '.next-footer',
			prevEl: '.prev-footer',
		},
	});

	//travel_sug js
	var swiper = new Swiper('.tr_sug', {
		centeredSlides: true,
		slidesPerView: 1,
		pagination: {
			el: '.swiper-pagination',
			clickable: true,
		},
		breakpoints: {
			1920: {
				slidesPerView: 1,
				spaceBetween: 0,
			},
			1280: {
				slidesPerView: 1,
				spaceBetween: 0,
				centeredSlides: false,
			},
			768: {
				slidesPerView: 1,
				spaceBetween: 30,
				centeredSlides: false,
			},
		},
	});

	// 고객님만을 위한 추천여행js
	var swiper = new Swiper('.off_slide', {
		spaceBetween: 10,
		loop: true,
		slidesPerView: 4,
		navigation: {
			nextEl: '.offer-next',
			prevEl: '.offer-prev',
		},
		breakpoints: {
			1280: {
				slidesPerView: 4,
				spaceBetween: 15,
			},
			768: {
				slidesPerView: 1,
				spaceBetween: 20,
				centeredSlides: true,
			},
			375: {
				slidesPerView: 1,
				spaceBetween: 5,
				centeredSlides: true,
			},
		},
	});

	// 모바일 bann_slider
	var swiper = new Swiper('.bann_slider', {
		centeredSlides: true,
		loop: true,
		slidesPerView: 1,
		autoplay: {
			delay: 3000,
			disableOnInteraction: true,
		},
		pagination: {
			el: '.swiper-pagination',
			clickable: true,
		},
	});
}

// 셀렉트 박스 이벤트
function selectBox() {
	//인천/김포 출발 셀렉트 박스
	$('.bnt_le').click(function () {
		if ($('.btn_a').hasClass('active')) {
			$('.btn_a').removeClass('active');
			$('this').removeClass('active');
		} else {
			$('.btn_a').addClass('active');
			$(this).addClass('active');
		}
	});

	$('.bnt_le').click(function () {
		$('.bnt_le').css({ border: '1px solid #5e2bb8' });
	});
}

// 사이드바 이벤트
function aside_event() {
	// $(".aside>ul>li>a").click(function(){
	//     $(".aside ul li a .menu_sub").addClass('onfoo');
	//     $(this).addClass("onfoo");
	//     $(".")
	// });
}

// 상단 배너 닫기 이벤트
function banner_close_event() {
	// 상단 배너 닫기 이벤트
	$('.list_close').click(function () {
		$('.banner_wrap').slideUp();
	});
}

// 탭 메뉴 이벤트
function tab_event() {
	// 패키지 항공 호텔 탭 버튼
	$('.but_tit a').click(function () {
		var tab_id = $(this).attr('data-tab');
		$('.but_tit a').removeClass('acitve');
		$('.tab_content').removeClass('acitve');
		$(this).addClass('acitve');
		$('#' + tab_id).addClass('acitve');
	});

	// 왕복 편도 다구간 탭 버튼
	$('.but_tits span button').click(function () {
		var tab_id = $(this).attr('data-tab');
		$('.but_tits span button').removeClass('acitve');
		$('.tits_cons').removeClass('acitve');
		$(this).addClass('acitve');
		$('#' + tab_id).addClass('acitve');
	});

	// 마침내 특가
	$('.but_titsx span button').click(function () {
		var tab_id = $(this).attr('data-tab');
		$('.but_titsx span button').removeClass('play');
		$('.content_wrap').removeClass('play');
		$(this).addClass('play');
		$('#' + tab_id).addClass('play');
	});
}

// 클릭 이벤트
function btnClick_event() {
	//bnt_ri button
	$('.bnt_ri').click(function () {
		if ($(this).hasClass('on')) {
			$('.card_area').removeClass('on');
			$(this).removeClass('on');
		} else {
			$('.card_area').addClass('on');
			$(this).addClass('on');
		}

		if ($(this).hasClass('on')) {
			$('.card_area').removeClass('on');
		} else {
			$('.card_area').addClass('on');
		}
	});

	//닫기 버튼
	$('.btn_closed').click(function () {
		$('.card_area').removeClass('off');
		$(this).addClass('off');
		$('.card_area').removeClass('off');
	});

	//bnt_ri button
	$('.hotel').click(function () {
		if ($(this).hasClass('off')) {
			$('.card_area1').removeClass('off');
			$(this).removeClass('off');
		} else {
			$('.card_area1').addClass('off');
			$(this).addClass('off');
		}

		if ($(this).hasClass('off')) {
			$('.card_area1').removeClass('off');
		} else {
			$('.card_area1').addClass('off');
		}
	});

	//닫기 버튼
	$('.btn_closed').click(function () {
		$('.card_area1').removeClass('off');
		$(this).addClass('off');
		$('.card_area1').removeClass('off');
	});

	// footer 하나투어
	$('.hana_mb').click(function () {
		if ($('.fl .footer_licensee span').hasClass('on')) {
			$('.fl .footer_licensee span').removeClass('on');
			$('this').removeClass('on');
		} else {
			$('.fl .footer_licensee span').addClass('on');
			$(this).addClass('on');
		}
	});

	// 모바일 햄버거 메뉴
	$('.hea_wrap a.btn .ico').click(function () {
		if ($('.quick_menu').hasClass('off')) {
			$('.quick_menu').removeClass('off');
			$('this').removeClass('off');
		} else {
			$('.quick_menu').addClass('on');
			$(this).addClass('on');
		}
	});

	//서브페이지 메뉴 버튼
	$('.sub_menu').click(function () {
		if ($('.menu_list').hasClass('acitve')) {
			$('.menu_list').removeClass('acitve');
			$('this').removeClass('acitve');
		} else {
			$('.menu_list').addClass('acitve');
			$(this).addClass('acitve');
		}
	});

	//서브페이지 정렬 버튼
	$('.prd_add_btn').click(function () {
		$('prdItemList ul li').addClass('add');
		$(this).addClass('add');
		$('.prd_remove_btn').removeClass('add');
	});
	$('.prd_remove_btn').click(function () {
		$('prdItemList ul li').removeClass('add');
		$(this).addClass('add');
		$('.prd_add_btn').removeClass('add');
	});

	//메인 페이지 팝업
	$('.popup_title').click(function () {
		if ($('.popup_wrap').hasClass('active')) {
			$('.popup_wrap').removeClass('active');
			$(this).removeClass('active');
		} else {
			$('.popup_wrap').addClass('active');
			$(this).addClass('active');
		}
	});

	$(function () {
		$('.close_btn').click(function () {
			$('.popup_wrap').fadeToggle();
		});
	});

	// $(".popup_title").click(function(){
	//     $(".popup_wrap").removeClass('active');
	//     $(this).addClass("active");
	//     $(".popup_wrap").removeClass("active");
	// });

	//가상요소 스크립트
	// $(".sub_menu").click(function () {
	//     if ($(".menu_icon::after").hasClass("acitve")) {
	//         $(".menu_icon::after").removeClass("acitve");
	//         $("this").removeClass("acitve");
	//     } else {
	//         $(".menu_icon::after").addClass("acitve");
	//         $(this).addClass("acitve");
	//     }
	// })
}

// allmenu 이벤트
function allmenu() {
	$('.all_menu .btn_all_menu').click(function () {
		$(this).siblings('.all_sam').toggleClass('on');
	});
	$('.all_menu .all_sam .btn_close').click(function () {
		$(this).closest('.all_sam').removeClass('on');
	});
}

// 메뉴 호버 이벤트
function menu_hover_event() {
	$('.menu_wrap .left_bar>ul>li').on('mouseover', function () {
		$('.menu_wrap .left_bar>ul>li>.in_sub_m').removeClass('on'); //.in_sub_m on 클레스 제거
		$('.menu_wrap .left_bar>ul>li').removeClass('active'); //.left_bar ul li active 클래스 제거
		$(this).children('.in_sub_m').addClass('on'); //
		$('.menu_wrap .left_bar>ul>li').addClass('on');
	});
	$('.gnb_in_wrap , .all_menu , .menu_right').on('mouseover', function () {
		$('.menu_wrap .left_bar>ul>li>.in_sub_m').removeClass('on');
	});
	$('.menu_wrap .in_sub_m').on('mouseout', function () {
		$('.menu_wrap .left_bar>ul>li>.in_sub_m').removeClass('on');
	});
}
