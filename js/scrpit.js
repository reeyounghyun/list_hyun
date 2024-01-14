// jQuery를 사용하여 클릭 이벤트 핸들링
$('nav a').click(function (e) {
	e.preventDefault();
	const targetId = $(this).attr('href');
	const offsetTop = $(targetId).offset().top - $('header').outerHeight();

	// animate 함수로 부드러운 스크롤 효과 적용
	$('html, body').animate(
		{
			scrollTop: offsetTop,
		},
		1000
	); // 1000은 애니메이션의 지속시간을 밀리초(ms) 단위로 나타냅니다.

	// showTab 함수 호출 시 event 객체 전달
	showTab(e, 10000 /* tabIndex 값 넣기 */);
});

//포폴 탭
function showTab(tabIndex) {
	// 모든 탭 내용과 버튼에 대한 'active' 클래스 초기화
	document.querySelectorAll('.tab-content, .tab-btn').forEach(function (element) {
		element.classList.remove('active');
	});

	// 클릭한 탭에 해당하는 탭 내용 보이기
	var tabId = 'tab' + tabIndex;
	document.getElementById(tabId).classList.add('active');

	// 클릭한 탭에 'active' 클래스 추가
	event.currentTarget.classList.add('active');
}

//팝업
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

function closePopup(e) {
	var popups = document.querySelectorAll('.popup');
	var overlay = document.getElementById('overlay');
	popups.forEach(function (popup) {
		popup.style.display = 'none';
	});
	overlay.style.display = 'none';
}
