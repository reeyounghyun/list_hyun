$(document).ready(function () {
	common_load(); // 문서로드
});

// 헤더&푸터 로드
function common_load() {
	$('.header').load('header.html .header .home_nav', function () {});
	$('.Home_wrap_img').load('index.html .Home_wrap_img', function () {});
	$('.footer').load('footer.html .footer .footer_wrap', function () {});
}
