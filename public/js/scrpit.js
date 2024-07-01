/**
document.addEventListener("DOMContentLoaded", function() {
  const line = document.querySelector(".line");
  const dots = document.querySelectorAll(".dot");
  const sections = document.querySelectorAll(".content .filler");

  window.addEventListener("scroll", function() {
    const scrollY = window.scrollY;

    // 스크롤에 따라 line의 높이를 증가시킵니다.
    line.style.height = `${40 + scrollY / 5}px`;

    // 스크롤에 따라 dots의 배경색을 변경합니다.
    dots.forEach((dot, index) => {
      const sectionOffset = sections[index].offsetTop;
      if (scrollY >= sectionOffset - window.innerHeight / 2 && scrollY < sectionOffset + sections[index].offsetHeight) {
        dot.style.backgroundColor = "plum";
        dot.style.transform = `translateY(${scrollY / 10}px)`;
      } else {
        dot.style.backgroundColor = "white";
        dot.style.transform = "translateY(0)";
      }
    });
  });
});

  // dark-mode stert
    function initTheme() {
      const savedTheme = localStorage.getItem("theme");
      const isDark = savedTheme
        ? savedTheme == "dark"
        : window.matchMedia("(prefers-color-scheme: dark)").matches;
      setTheme(isDark);
    }
    function setTheme(isDark) {
      localStorage.setItem("theme", isDark ? "dark" : "light");
      if (isDark) {
        document.body.classList.add("dark-mode");
      } else {
        document.body.classList.remove("dark-mode");
      }
    }
    function toggleTheme() {
      setTheme(localStorage.getItem("theme") !== "dark");
    }

    $(document).ready(function () {
      initTheme();
      $(".custom-select").click(function () {
        toggleTheme();
      });

      $('.custom-select__trigger').click(function () {
        $('.custom-select').toggleClass('open');
      });

      $('.custom-option').click(function () {
        var value = $(this).attr('data-value');
        $('#mySelect').val(value);
        $('.custom-select').removeClass('open');
        $('.custom-option').removeClass('selected');
        $(this).addClass('selected');
      });

      $(document).click(function (e) {
        if (!$(e.target).closest('.custom-select').length) {
          $('.custom-select').removeClass('open');
        }
      });
    });
 **/

//스크롤다운.JS
document.addEventListener("DOMContentLoaded", function() {
  function scrollDown() {
      let text = document.querySelector("h2");
      let textString = text.textContent;
      let split = textString.split("");
      text.textContent = "";
      for (let i = 0; i < split.length; i++) {
          let span = document.createElement("span");
          span.classList.add("spanText");
          span.textContent = split[i];
          text.appendChild(span);
      }
      
      gsap.registerPlugin(ScrollTrigger);
      
      let tl = gsap.timeline();
      tl.from(".spanText", {
          y: -500,
          opacity: 0,
          scrollTrigger: {
              pin: true,
              scrub: 1,
              trigger: "section",
              start: "top top",
              end: "bottom top"
          },
          stagger: {
              amount: 2
          }
      });
  }
  
  scrollDown();
});