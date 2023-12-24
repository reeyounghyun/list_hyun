$(document).ready(function () {
	common_load(); // 문서로드
});

// 헤더로드
function common_load() {
	$('.header').load('header.html .header .home_nav', function () {});
}
