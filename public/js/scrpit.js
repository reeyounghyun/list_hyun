// ScrollHandler.js
document.addEventListener("DOMContentLoaded", function() {
  const sections = document.querySelectorAll(".section");
  const menuLinks = document.querySelectorAll(".menu-link");

  window.addEventListener("scroll", () => {
    let current = "";

    sections.forEach(section => {
      const sectionTop = section.offsetTop;
      const sectionHeight = section.clientHeight;

      if (window.pageYOffset >= sectionTop - sectionHeight / 3) {
        current = section.getAttribute("id");
      }
    });

    menuLinks.forEach(link => {
      link.classList.remove("active");
      if (link.getAttribute("href") === `#${current}`) {
        link.classList.add("active");
      }
    });
  });

  menuLinks.forEach(link => {
    link.addEventListener("click", function(e) {
      e.preventDefault();
      const targetId = link.getAttribute("href").substring(1);
      const targetElement = document.getElementById(targetId);

      window.scrollTo({
        top: targetElement.offsetTop - 60, // 메뉴바 높이만큼 오프셋 조정
        behavior: "smooth"
      });
    });
  });
});

// AOSInit.js
document.addEventListener("DOMContentLoaded", function() {
  AOS.init({
    duration: 1300, // 애니메이션 지속 시간
  });
});

// ScrollToTop.js
document.addEventListener("DOMContentLoaded", function() {
  document.getElementById('scrollToTop').addEventListener('click', function(event) {
    event.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
});

// Tabs.js
function showTab(event, tabIndex) {
  // 모든 탭 콘텐츠를 숨김
  document.querySelectorAll('.tab-content').forEach(function(element) {
    element.classList.remove('active');
    element.style.display = 'none';
  });

  // 모든 탭 버튼에서 'active' 클래스 제거
  document.querySelectorAll('.tab-btn').forEach(function(element) {
    element.classList.remove('active');
    element.classList.remove('bg-blue-500');
    element.classList.add('bg-gray-200');
    element.classList.remove('text-white');
    element.classList.add('text-gray-700');
  });

  // 클릭한 탭에 해당하는 콘텐츠를 표시
  var tabId = 'tab' + tabIndex;
  var tabElement = document.getElementById(tabId);
  tabElement.style.display = 'flex';
  setTimeout(() => {
    tabElement.classList.add('active');
    tabElement.style.opacity = 1;
  }, 0);

  // 클릭한 버튼에 'active' 클래스 추가
  event.currentTarget.classList.add('active');
  event.currentTarget.classList.add('bg-blue-500');
  event.currentTarget.classList.remove('bg-gray-200');
  event.currentTarget.classList.add('text-white');
  event.currentTarget.classList.remove('text-gray-700');
}

// 초기화 함수로 첫 번째 탭을 활성화 상태로 설정
document.addEventListener("DOMContentLoaded", function() {
  showTab({ currentTarget: document.querySelector('.tab-buttons .tab-btn.active') }, 1);
});

// Popup.js
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
  var popup = document.getElementById('popup');
  if (popup) {
      popup.style.display = 'none';
  }
}