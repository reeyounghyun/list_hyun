
    // 인트로 컨트롤
    gsap.registerPlugin(ScrollTrigger);

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

    // 스킬
    gsap.registerPlugin(ScrollTrigger);
    
    window.addEventListener('load', () => {
      const skillImages = document.querySelectorAll('.skill-images > div');
      
      // 모든 이미지를 초기에 숨깁니다
      gsap.set(skillImages, { opacity: 0, y: 30 });
  
      // 섹션 제목 애니메이션
      gsap.from('.sec2Title', {
        opacity: 0,
        y: 30,
        duration: 1,
        scrollTrigger: {
          trigger: '.section2',
          start: "top 80%",
          toggleActions: "play none none reverse"
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
          start: "top 80%",
          toggleActions: "play none none reverse"
        }
      });
  
      // 이미지 순차 애니메이션
      ScrollTrigger.create({
        trigger: '.section2',
        start: "top 70%",
        onEnter: () => {
          gsap.to(skillImages, {
            opacity: 1,
            y: 0,
            duration: 1,
            stagger: 0.9, // 각 이미지 사이의 지연 시간
            ease: "power2.out"
          });
        },
        onLeaveBack: () => {
          gsap.to(skillImages, {
            opacity: 0,
            y: 30,
            duration: 0.5,
            stagger: 0.5,
            ease: "power2.in"
          });
        }
      });
    });

    // 컨텐츠 GSAP Start
    // 가로 스크롤 설정
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

    // 세로 스크롤 섹션 배경색 변경
    // const verticalSections = gsap.utils.toArray(".parallax__item:not(#horizontal .parallax__item)");
    // verticalSections.forEach((section) => {
    //     let color = section.getAttribute("data-bgcolor");
        
    //     ScrollTrigger.create({
    //         trigger: section,
    //         start: "top 50%",
    //         end: "bottom 50%",
    //         onEnter: () => gsap.to("body", { backgroundColor: color, duration: 1.4 }), //스크롤
    //         onEnterBack: () => gsap.to("body", { backgroundColor: color, duration: 1.4 }), //역 스크롤
    //         markers: true
    //     });
    // });


    // 세로 스크롤 섹션 배경색 변경 부분을 수정
    verticalSections.forEach((section, index) => {
      let startColor = gradients[index % gradients.length].start;
      let endColor = gradients[index % gradients.length].end;
      
      ScrollTrigger.create({
        trigger: section,
        start: "top 50%",
        end: "bottom 50%",
        onEnter: () => gsap.to("body", { 
          background: `linear-gradient(45deg, ${startColor}, ${endColor})`, 
          duration: 1.4 
        }),
        onEnterBack: () => gsap.to("body", { 
          background: `linear-gradient(45deg, ${startColor}, ${endColor})`, 
          duration: 1.4 
        }),
        markers: true
      });
    });


    // 가로 스크롤 섹션 배경색 변경
    const horizontalScrollTrigger = ScrollTrigger.create({
        trigger: horizontal,
        start: "top top",
        end: () => "+=" + (horizontal.offsetWidth - innerWidth), // '+='더하고 할단한다
        onUpdate: (self) => {
            const progress = self.progress; //self = this
            const index = Math.floor(progress * horizontalSections.length);
            const section = horizontalSections[index];
            if (section) {
                const color = section.getAttribute("data-bgcolor");
                gsap.to("body", { backgroundColor: color, duration: 0.5 });
            }
        },
        markers: true
    });

    // 섹션7의 고정 텍스트 제어
    const section7 = document.getElementById('section7');
    const reactText = document.getElementById('reactText');

    ScrollTrigger.create({
        trigger: section7,
        start: "top 80%", // 섹션7이 뷰포트의 80% 지점에 도달했을 때 시작
        end: "bottom 20%", // 섹션7의 하단이 뷰포트의 20% 지점에 도달했을 때 종료
        onEnter: () => {
            gsap.to(reactText, { opacity: 1, duration: 0.5, pointerEvents: 'auto' });
            console.log('Section 7 entered');
        },
        onLeave: () => {
            gsap.to(reactText, { opacity: 0, duration: 0.5, pointerEvents: 'none' });
            console.log('Section 7 left');
        },
        onEnterBack: () => {
            gsap.to(reactText, { opacity: 1, duration: 0.5, pointerEvents: 'auto' });
            console.log('Section 7 entered back');
        },
        onLeaveBack: () => {
            gsap.to(reactText, { opacity: 0, duration: 0.5, pointerEvents: 'none' });
            console.log('Section 7 left back');
        },
        markers: true // 디버깅을 위한 마커 추가
    });

    // 초기 상태 설정
    gsap.set(reactText, { opacity: 0, pointerEvents: 'none' });

    // 기존 코드 아래에 추가
    const gradients = [
      { start: "#1a2a6c", end: "#4a0e4e" },
      { start: "#59c173", end: "#5D26C1" },
      { start: "#ff6e7f", end: "#bfe9ff" },
      { start: "#2c3e50", end: "#bdc3c7" },
      { start: "#134E5E", end: "#71B280" }
    ];