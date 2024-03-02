<?php
//www/adm/bbs/_common.php 해당 파일에서 맞는 번호를 입력필요
$menu['menu400'] = array (
    array('400000', '게시판관리', ''.G5_ADMIN_URL.'/board_list.php', 'board'),
    array('400100', '게시판관리', ''.G5_ADMIN_URL.'/board_list.php', 'bbs_board'),
    array('400200', '게시판그룹관리', ''.G5_ADMIN_URL.'/boardgroup_list.php', 'bbs_group'),
    array('400250', '게시글관리', G5_ADMIN_URL.'/bbs/', 'adm_board'),
//    array('400300', '기본 리스트 게시판관리', G5_ADMIN_URL.'/bbs/board.php?gr_id=basic&bo_table=basic', 'basic'),
//    array('400400', '기본 갤러리 게시판', G5_ADMIN_URL.'/bbs/board.php?gr_id=gallery&bo_table=gallery', 'gallery'),
//    array('400500', '기본 달력 게시판', G5_ADMIN_URL.'/bbs/board.php?gr_id=schedule&bo_table=schedule', 'schedule'),
    array('400600', '배너&광고 게시판', G5_ADMIN_URL.'/bbs/board.php?bo_table=banner_ad_management', 'banner_ad_management'),
    array('400700', '등급 관리', G5_ADMIN_URL.'/member_grade_management.php', 'grade_management'),
    array('400800', '프로그램 게시판', G5_ADMIN_URL.'/bbs/board.php?gr_id=basic&bo_table=program', 'program'),
    array('400900', '콘텐츠 게시판', G5_ADMIN_URL.'/bbs/board.php?gr_id=basic&bo_table=content', 'content'),
    array('400910', '아이디어 게시판', G5_ADMIN_URL.'/bbs/board.php?gr_id=basic&bo_table=idea', 'idea'),
    array('400920', '제품·서비스 게시판', G5_ADMIN_URL.'/bbs/board.php?gr_id=basic&bo_table=item', 'item'),
    array('400930', '복지·혜택 게시판', G5_ADMIN_URL.'/bbs/board.php?gr_id=basic&bo_table=welfare', 'welfare'),
    array('400940', '일반 게시판', G5_ADMIN_URL.'/bbs/board.php?gr_id=basic&bo_table=general', 'general'),
//    array('300300', '인기검색어관리', ''.G5_ADMIN_URL.'/popular_list.php', 'bbs_poplist', 1),
//    array('300400', '인기검색어순위', ''.G5_ADMIN_URL.'/popular_rank.php', 'bbs_poprank', 1),
//    array('300500', '1:1문의설정', ''.G5_ADMIN_URL.'/qa_config.php', 'qa'),
//    array('300600', '내용관리', G5_ADMIN_URL.'/contentlist.php', 'scf_contents', 1),
//    array('300700', 'FAQ관리', G5_ADMIN_URL.'/faqmasterlist.php', 'scf_faq', 1),
//    array('300820', '글,댓글 현황', G5_ADMIN_URL.'/write_count.php', 'scf_write_count'),
);
?>
