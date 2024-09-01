     // GSAP 및 ScrollTrigger 등록
     gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

     // 인트로 컨트롤
     window.addEventListener('load', () => {
         const tl = gsap.timeline({ defaults: { ease: "power3.out" } });

         tl.from(".mainTitle", { y: 50, opacity: 0, duration: 1 })
           .from(".title", { y: 30, opacity: 0, duration: 0.8 }, "-=0.5")
           .from(".mainSubTitle", { y: 30, opacity: 0, duration: 0.8 }, "-=0.5")
           .from(".image-mo", { scale: 0.8, opacity: 0, duration: 1 }, "-=0.3")
           .from(".tag span", { opacity: 0, y: 20, stagger: 0.2, duration: 0.5 }, "-=0.5");

           gsap.to(".content-wrapper", {
            scrollTrigger: {
                trigger: ".section1",
                start: "top top",
                end: "bottom top",
                scrub: true,
            },
            y: 100,
            opacity: 0.5
        });

        gsap.to(".image-mo", {
            scrollTrigger: {
                trigger: ".section1",
                start: "top top",
                end: "bottom center",
                scrub: true,
            },
            scale: 1.1,
            y: -30
        });
     });

    
/**---------------------------------------------------------------------------------**/
 // 스킬 애니메이션 stert
 gsap.registerPlugin(ScrollTrigger);

 // 페이지 로드 시 실행되는 부분을 제거하고, 스크롤 트리거로 모든 애니메이션을 제어합니다.
 const initSkillAnimations = () => {
   const skillImages = document.querySelectorAll('.skill-images > div');
   const titles = document.querySelectorAll('.sec2Title, .titleSm');
   
   // 모든 요소를 초기에 숨깁니다
   gsap.set(['.sec2Title', '.titleSm', skillImages], { opacity: 0, y: 30 });

   // 섹션 제목 애니메이션
   gsap.from('.sec2Title', {
     opacity: 0,
     y: 30,
     duration: 1,
     scrollTrigger: {
       trigger: '.section2',
       start: "top 80%",
       end: "center 50%",
       toggleActions: "play none none reverse",
       scrub: 1
     }
   });

   // 각 카테고리 제목 애니메이션
   gsap.from('.titleSm', {
     opacity: 0,
     x: -30,
     duration: 0.8,
     stagger: 0.2,
     scrollTrigger: {
       trigger: '.section2',
       start: "top 75%",
       end: "center 45%",
       toggleActions: "play none none reverse",
       scrub: 1
     }
   });

  // 이미지 순차 애니메이션
       ScrollTrigger.create({
         trigger: '.section2',
         start: "top 70%",
         end: "center 40%",
         onEnter: () => {
           gsap.to(skillImages, {
             opacity: 1,
             y: 0,
             duration: 1,
             stagger: 0.2,
             ease: "power2.out"
           });
         },
         onLeave: () => {
           gsap.to(skillImages, {
             opacity: 0,
             y: -30,
             duration: 0.5,
             stagger: 0.1,
             ease: "power2.in"
           });
         },
         onEnterBack: () => {
           gsap.to(skillImages, {
             opacity: 1,
             y: 0,
             duration: 1,
             stagger: 0.2,
             ease: "power2.out"
           });
         },
         onLeaveBack: () => {
           gsap.to(skillImages, {
             opacity: 0,
             y: 30,
             duration: 0.5,
             stagger: 0.1,
             ease: "power2.in"
           });
         },
         scrub: 1
       });
 };

 // 페이지 로드 후 애니메이션 초기화
 window.addEventListener('load', initSkillAnimations);


/**---------------------------------------------------------------------------------**/
// 세로 스크롤 섹션 배경색 변경
const verticalSections = gsap.utils.toArray(".parallax__item:not(#horizontal .parallax__item)");
verticalSections.forEach((section, index) => {
let startColor = gradients[index % gradients.length].start;
let endColor = gradients[index % gradients.length].end;

ScrollTrigger.create({
    trigger: section,
    start: "top 50%",
    end: "bottom 50%",
    onEnter: () => gsap.to("body", { 
    background: `linear-gradient(50deg, ${startColor}, ${endColor})`, 
    duration: 1.4 
    }),
    
    onEnterBack: () => gsap.to("body", { 
    background: `linear-gradient(45deg, ${startColor}, ${endColor})`, 
    duration: 1.4 
    })
});
});

/**---------------------------------------------------------------------------------**/
// 가로 스크롤 섹션 배경색 변경
ScrollTrigger.create({
trigger: horizontal,
start: "top top",
end: () => "+=" + (horizontal.offsetWidth - innerWidth),
onUpdate: (self) => {
    const progress = self.progress;
    const index = Math.floor(progress * horizontalSections.length);
    const section = horizontalSections[index];
    if (section) {
        const gradientIndex = index % gradients.length;
        const startColor = gradients[gradientIndex].start;
        const endColor = gradients[gradientIndex].end;
        gsap.to("body", { 
            background: `linear-gradient(45deg, ${startColor}, ${endColor})`, 
            duration: 0.5 
        });
    }
}
});

// 가로 스크롤 섹션 배경색 변경
    const horizontal = document.querySelector("#horizontal");
    const horizontalSections = gsap.utils.toArray("#horizontal > section");

    gsap.to(horizontalSections, {
        xPercent: -100 * (horizontalSections.length - 1),
        ease: "none",
        scrollTrigger: {
            trigger: horizontal,
            start: "top top",
            end: () => "+=" + (horizontal.offsetWidth - innerWidth),
            pin: true,
            scrub: 1,
            invalidateOnRefresh: true,
            anticipatePin: 1
        }
    });

    // 그라데이션 배경 정의
    const gradients = [
      { start: "#fff", end: "#000" },
      { start: "#2c3e50", end: "#bdc3c7" },
      { start: "#ff6e7f", end: "#bfe9ff" },
      { start: "#2c3e50", end: "#bdc3c7" },
      { start: "#134E5E", end: "#71B280" }
    ];


/**---------------------------------------------------------------------------------**/
// 섹션7의 고정 텍스트 제어
const section7 = document.getElementById('section7');
const reactText = document.getElementById('reactText');

ScrollTrigger.create({
    trigger: section7,
    start: "top 80%",
    end: "bottom 20%",
    onEnter: () => gsap.to(reactText, { opacity: 1, duration: 0.5, pointerEvents: 'auto' }),
    onLeave: () => gsap.to(reactText, { opacity: 0, duration: 0.5, pointerEvents: 'none' }),
    onEnterBack: () => gsap.to(reactText, { opacity: 1, duration: 0.5, pointerEvents: 'auto' }),
    onLeaveBack: () => gsap.to(reactText, { opacity: 0, duration: 0.5, pointerEvents: 'none' })
});

// 초기 상태 설정
gsap.set(reactText, { opacity: 0, pointerEvents: 'none' });