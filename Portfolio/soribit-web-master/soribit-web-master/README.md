## About PIECE Project

### 해당 소스는 기본 소스입니다. 개발을 위해 git remote 주소를 변경 후 사용해 주세요.

> 개발 서버 정보 입니다
> - PHP version: 7.2.4 
> - 그누보드 version:  5.4.5.5
> - MariaDB version: 
> - 개발자 : 서영윤, 석동근, 강하미
> - 시작 일자 : 2022.11.22
> - theme => piece
***
> Config
> - config.example.php를 복사해서 해당 프로젝트에 맞게 작업해 주세요.
> - dbconfig.example.php를 복사해서 해당 프로젝트에 맞게 작업해 주세요. 
***
## DATA FOLDER 기본
```
설정 : chmod -R 707 data/
아래 폴더 및 구조는 무조건 있어야 합니다.
data
    ┌── cache
    ├── session
    ├── file
    └── dbconfig.php
```
## SEO
```
### 게시판
1. 관리자 페이지
  -> 기본 환경 설정 -> 홈페이지 제목 -> 상태바에 표시될 제목
  -> 기본 환경 설정 -> 추가 메타태그 -> 해당 text에 사이트 설명 작성(description)
 -------------------------------------------------------------------------------------------
2. head.sub.php
 1) 상태바에 표시될 제목
  $g5_head_title = implode(' | ', array_filter(array($g5['title'], $config['cf_title'])));
  <title><?php echo $g5_head_title; ?></title>
  -> ex) 자유게시판 | 그누보드

 2) description -> from 관리자페이지 -> 추가 메타태그 -> $config['cf_add_meta]
  echo '<meta name="description" content="'.$config['cf_add_meta'].'">';
  
 3) keyword(우선 보류)(굳이 DB 안쓰고 강제 입력도 좋아 보임)
  echo '<meta name="keyword" content="">';
  
 4)전체 사이트 네임 from 관리자페이지 -> 홈페이지 제목 -> $config['cf_title]
  echo '<meta property="og:site_name" content="'.$config['cf_title'].'">';
  
 5)페이지 네임(상태바에 표시될 제목과 동일)
  echo '<meta property="og:title" content="'.$g5_head_title.'">';
  
 6) description -> from 관리자페이지 -> 추가 메타태그 -> $config['cf_add_meta]
  echo '<meta property="og:description" content="'.$config['cf_add_meta'].'">';
  
 7) ** 썸네일(임베드) 이미지
  echo '<meta property="og:image" content="https://ascp.limefriends.com/img/asan/common/link_thum.png">' . PHP_EOL;
  ** 이미지를 디자인팀에 따로 요청해서 작업 할 것. 해당 예시는 수연님이 작업하신 아사달인.

3. board.php
 Original : $g5['title'] = $g5['board_title'].' '.$page.' 페이지';
 Revision : $g5['title'] = $g5['board_title']
  -> list단에서 페이지 번호 제거
  
  
###정적 페이지
```

## 특징
> - 날짜 필터를 select - option 을 사용하지 않고 퍼블리싱에 맞춰 작업
> - 관리자 페이지와 유저 페이지 완전 분할
> - member skin까지 모두 theme 폴더 안에서 해결
> - publishing 과 php 코드를 최대한 나눔
>   - publishing 은 pub > assets의 작성
>   - php 코드는 common.lib.extend.php & 각 controller에 작성
> - 아이디를 이메일로 변경하여 작업


## 페이지 사용 설명


### 유저 페이지


### 회원 종류
```
    최고 관리자
        장애인 = 보호자 = 기업 = 기관 = 일반 <= level 2
    > 비회원 <=level 1
```
### 회원 종류 코드
```
1 : 장애인
2 : 보호자
3 : 기업
4 : 기관
```

### 권한
```
프로그램
    읽기 : 모두
    쓰기 : 기관(4)
복지·혜택
    읽기 : 모두
    쓰기 : 기관(4)
커뮤니티
    읽기 : 모두
    쓰기 : 회원 전부
    좋아요 : 회원 전부
콘텐츠
    읽기 : 모두
    쓰기 : 회원 전부
제품·서비스
    읽기 : 모두
    쓰기 : 기업/기관(3&4)
```

### SKIN 폴더 구조
```
skin
    board
        ┌── basic           // 그누보드 기본 list 게시판 - no touch
        ├── gallery         // 그누보드 기본 gallery 게시판 - no touch
        ├── schedule        // calender 게시판 - no touch
        ├── webapp_basic    // 테마 기본 webapp_basic 게시판 - no touch
        ├── program         // 프로그램
        ├── item            // 제품&서비스
        ├── general         // 일반 & 아이디어
        ├── welfare         // 복지&혜택
        └── content         // 콘텐츠
        └ 카테고리: 영상 & 콘텐츠 & 구인구직
        
pub
    component
        ┌── footer.navigation.php       // 공통 footer
        ├── index.navigation.php        // 그누보드 기본 gallery 게시판 - no touch
        ├── login.navivation.php        // 비회원 로그인 헤더
        ├── region.json                 // 필터에 쓰이는 날짜 리스트
        ├── tohome.navigation.php       // 메인 바로가기 헤더
        ├── tomypage.navigation.php     // 마이페이지 바로가기 헤더
        └── view.navigation.php         // 전페이지 이동 헤더
```

### Front
```
┌── pub        
    ├── assets          
        ├── css         // css
        ├── font        // font
        ├── image       // image
        ├── js          // js
        └── scss        // scss
    ├── community_list.html          // 커뮤니티 목록
    ├── community_view1.html         // 커뮤니티 상세 (좋아요, 신고)
    ├── community_view2.html         // 커뮤니티 상세 (삭제, 수정)
    ├── community_write.html         // 커뮤니티 글쓰기
    ├── contents_list.html           // 콘텐츠 목록
    ├── contents_view1.html          // 콘텐츠 상세 (신고)
    ├── contents_view2.html          // 콘텐츠 상세 (삭제, 수정)
    ├── contents_write.html          // 콘텐츠 글쓰기
    ├── index.html                   // 홈화면
    ├── join01.html                  // 본인 및 보호자 회원가입 (개인정보처리방침, 회원가입 약관)
    ├── join02.html                  // 회원정보 입력
    ├── join03.html                  // 회원가입 완료
    ├── join04.html                  // 비회원이 로그인이 필요한 페이지에 들어 갔을 때
    ├── login.html                   // 로그인
    ├── membership_info_modify.html  // 회원정보 수정
    ├── membership_info.html         // 회원정보
    ├── mypage.html                  // 마이페이지
    ├── privacy_policy.html          // 개인정보처리방침 및 약관
    ├── product_list.html            // 제품서비스 목록
    ├── product_view1.html           // 제품서비스 상세 (신고)
    ├── product_view2.html           // 제품서비스 상세 (삭제, 수정)
    ├── product_write.html           // 제품서비스 글쓰기
    ├── program_list.html            // 프로그램 목록
    ├── program_view.html            // 프로그램 상세
    ├── program_write.html           // 프로그램 글쓰기
    ├── welfare_list.html            // 복지혜택 목록
    ├── welfare_view.html            // 복지혜택 상세
    └── welfare_write.html           // 복지혜택 글쓰기

```

### DB
```
g5_write & g5_board
    ┌── program         // 프로그램
        └ bo_1 : 장애 타입
    ├── item            // 제품&서비스
        └ 카테고리1(sca) : 제품 & 서비스 & 용역
        └ 카테고리2(bo_1) : 2차 카테고리
    ├── general         // 커뮤니티 - 일반
    ├── idea            // 커뮤니티 - 아이디어
    ├── content         // 콘텐츠
        └ 카테고리(sca): 영상 & 콘텐츠 & 구인구직
    └── welfare         // 복지&혜택

```
#### Board
```
게시판 여유태그 정리
1. 유튜브 주소 - 1칸
2. 블라인드처리 - 3칸(회원 아이디, 이유, 상태)
   - 상태 : 1(블라인드)
3. 캘린더 - 2칸(시작일, 종료일)
4. 읽은 게시물 - 1칸

고정 값
 - wr_1 => 캘린더 시작일
 - wr_2 => 캘린더 종료일
 - wr_3 => 블라인드 처리 회원아이디
 - wr_4 => 블라인드 처리 이유
 - wr_5 => 블라인드 처리 상태
 - wr_6 => 유튜브 주소 
 - wr_7 => 읽은 게시물
 - wr_8 => 게시글 추천
 - wr_9 =>
 - wr_10 =>
 
 program & welfare
  - wr_8 => 시 
  - wr_9 => 구 
  - wr_10 => 장애유형 
  - wr_11 => 상시 & 기간 & 강제 종료 
  - wr_12 => 기관
  - wr_13 => 신청방법(text) 
  - wr_14 => 프로그램 추천 
 
 item
  - wr_8 => 소 카테고리
```
#### member
```
    mb_1 => 회원 등급
    mb_2 => 장애인등록증/사업자등록증 이미지
```
#### config
```
config 여유태그 정리
1. Footer - 1칸

 - cf_1 => Footer(varchar => textarea)
 - cf_2 =>
 - cf_3 =>
 - cf_4 =>
 - cf_5 =>
 - cf_6 =>
 - cf_7 =>
 - cf_8 =>
 - cf_9 =>
 - cf_10 =>
```
