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
