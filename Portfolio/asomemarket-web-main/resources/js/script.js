$(function () {
	//공통 html 문서로드
	$('.header').load('header.html', function () {});
	$('.footer').load('footer.html', function () {});

	// 스크롤 위치에 따라 Top 버튼
	window.addEventListener('scroll', function () {
		var topButton = document.getElementById('topButton');
	});

	//------헤더 최근검색어-----//
	document.addEventListener('click', function () {
		var formRecord = document.querySelector('.form-record');
		var closeButton = document.querySelector('.close-box button');

		// "search-wrap" 클래스 클릭 시 이벤트
		var searchWrap = document.querySelector('.search-wrap input');
		searchWrap.addEventListener('click', function () {
			formRecord.style.display = 'block';
		});

		// 닫기 버튼 클릭 시 이벤트
		closeButton.addEventListener('click', function () {
			formRecord.style.display = 'none';
		});
	});

	//------메인 스크립트------//
	var swiper = new Swiper('.bann-slide', {
		parallax: {
			// 파랄랙스 활성화
			enabled: true, // true로 설정하여 파랄랙스 활성화, false로 설정하여 비활성화
			speed: 2200, // 파랄랙스 속도 (선택적)
		},
		speed: 2500,
		slidesPerView: 1, // 한 슬라이드에 보여줄 갯수
		loop: true,
		loopAdditionalSlides: 1, // 슬라이드 반복 시 마지막 슬라이드에서 다음 슬라이드가 보여지지 않는 현상 수정
		autoplay: true,

		pagination: {
			el: '.swiper-pagination',
			type: 'fraction',
		},
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
		breakpoints: {
			990: {
				slidesPerView: 1,
			},
			768: {
				slidesPerView: 1,
				centeredSlides: true, // true시에 슬라이드가 가운데로 배치
				parallax: {
					enabled: false,
				},
			},
		},
	});

	//비쥬얼 슬라이드 컨트롤러 정지/재생버튼
	$('.play-btn').click(function () {
		var state = $(this).hasClass('stop');
		if (state) {
			visual_swiper.autoplay.start();
			$(this).removeClass('stop');
		} else if (!state) {
			visual_swiper.autoplay.stop();
			$(this).addClass('stop');
		}
	});
});
// 종료

// 지금 인기 검색어 tab
//초기 탭 숨기기:
document.addEventListener('DOMContentLoaded', function () {
	var tabs = document.getElementsByClassName('tab-content');
	for (var i = 1; i < tabs.length; i++) {
		tabs[i].style.display = 'none';
	}

	//초기 탭 버튼 스타일 설정
	var clickedButton = document.querySelector('#por2Tab');
	clickedButton.classList.add('on');
});

//탭 클릭 이벤트 처리
function openTab(tabName) {
	var tabs = document.getElementsByClassName('tab-content');
	for (var i = 0; i < tabs.length; i++) {
		tabs[i].style.display = 'none';
	}

	// 해당 메뉴를 클릭했을 때 block이 되도록
	var selectedTab = document.getElementById(tabName + 'Tab');
	if (selectedTab) {
		selectedTab.style.display = 'block';
	}

	// 탭 버튼에 on 클래스 추가/제거
	var buttons = document.querySelectorAll('.food');
	for (var i = 0; i < buttons.length; i++) {
		buttons[i].classList.remove('on');
	}

	// 현재 클릭된 버튼에 on 클래스 추가
	var clickedButton = document.querySelector('.food[data-tab="' + tabName + '"]');
	if (clickedButton) {
		clickedButton.classList.add('on');
	}

	//각 엘리먼트 자식에게 on
	event.target.parentElement.classList.add('on');
}

$(function () {
	//-------못난이 특가 기획전 stert------//
	var swiper = new Swiper('.discount', {
		speed: 2500,
		pagination: {
			el: '.swiper-pagination',
			type: 'fraction',
		},
		// navigation: {
		//   nextEl: ".swiper-button-next",
		//   prevEl: ".swiper-button-prev",
		// },
	});

	// 로그인 상품 추천
	var swiper = new Swiper('.ser-slide', {
		slidesPerView: 5, // 한 슬라이드에 보여줄 갯수
		loop: true, //슬라이드 반복 여부
		// autoplay : {  // 자동 슬라이드 설정 , 비 활성화 시 false
		//   delay : 5000,   // 시간 설정
		//   disableOnInteraction : false,  // false로 설정하면 스와이프 후 자동 재생이 비활성화 되지 않음
		// },
		cssMode: true,
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
		pagination: {
			el: '.swiper-pagination',
		},
		mousewheel: true,
		keyboard: true,
		breakpoints: {
			640: {
				slidesPerView: 1,
			},
			831: {
				slidesPerView: 2,
			},
			1115: {
				slidesPerView: 3,
			},
			1920: {
				slidesPerView: 4,
			},
		},
	});
});

function bestTab(tabName, buttonIndex) {
	//-----베스트 상품 Teb 스크립트-------//
	// 모든 탭 내용 숨기기
	var tabs = document.getElementsByClassName('best-content');
	for (var i = 0; i < tabs.length; i++) {
		tabs[i].style.display = 'none';
	}

	// 클릭한 탭 내용 보이기
	document.getElementById(tabName).style.display = 'block';

	// 모든 탭 버튼에서 'active' 클래스 제거
	var buttons = document.getElementsByClassName('best-por');
	for (var i = 0; i < buttons.length; i++) {
		buttons[i].classList.remove('active');
	}

	// 클릭한 탭 버튼에 'active' 클래스 추가
	buttons[buttonIndex].classList.add('active');
}

// 상품정보&배송정보&추가혜택 (상품 상세페이지)
$(document).ready(function () {
	$('.inform-tit').click(function () {
		var targetId = $(this).data('target');
		$('#' + targetId)
			.stop()
			.slideToggle(300);
	});
});

//상세페이지 구매 후기
