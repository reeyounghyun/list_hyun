$(document).ready(function () {
	common_load(); // 문서로드
});

// 헤더&푸터 로드
function common_load() {
	$('.header').load('header.html .header .home_nav', function () {});
	$('.Home_wrap_img').load('index.html .Home_wrap_img', function () {});
	$('.footer').load('footer.html .footer .footer_wrap', function () {});
}

function togglePopup(popupId) {
	var popup = document.getElementById(popupId);
	var overlay = document.getElementById('overlay');
	if (popup.style.display === 'block') {
		popup.style.display = 'none';
		overlay.style.display = 'none';
	} else {
		popup.style.display = 'block';
		overlay.style.display = 'block';
	}
}

function closePopup() {
	var popups = document.querySelectorAll('.popup');
	var overlay = document.getElementById('overlay');
	popups.forEach(function (popup) {
		popup.style.display = 'none';
	});
	overlay.style.display = 'none';
}
