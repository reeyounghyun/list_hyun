<?php
/**************************
@Filename: adm.bbs.config.php
@Version : 1.0
@Author  : Freemaster
@Date  : 2016/05/27
@Edit Date  : 2018/07/27
@Content : PHP by Editplus
**************************/
if (!defined('_GNUBOARD_')) exit;
if (!defined('G5_IS_ADMIN')) exit;

/*
** 경로 설정
*/
define('G5_ADMIN_BBS_DIR', G5_ADMIN_DIR.'/'.G5_BBS_DIR);
define('G5_ADMIN_BBS_URL', G5_URL.'/'.G5_ADMIN_BBS_DIR);
define('G5_ADMIN_BBS_PATH',  G5_PATH.'/'.G5_ADMIN_BBS_DIR);
define('G5_ADMIN_HTTP_BBS_URL',  https_url(G5_ADMIN_BBS_DIR, true));
define('G5_ADMIN_HTTPS_BBS_URL', https_url(G5_ADMIN_BBS_DIR, false));

/*
** query string
*/
$arr_query = array();
if($_REQUEST['sca']) $arr_query[] = 'sca='.$_REQUEST['sca'];
if($_REQUEST['sod'])  $arr_query[] = 'sod='.$_REQUEST['sod'];
if($_REQUEST['sst'])  $arr_query[] = 'sst='.$_REQUEST['sst'];
if($_REQUEST['sfl'])  $arr_query[] = 'sfl='.$_REQUEST['sfl'];
if($_REQUEST['stx'])  $arr_query[] = 'stx='.$_REQUEST['stx'];
if($_REQUEST['target']) $arr_query[] = 'target='.$_REQUEST['target'];
if($_REQUEST['view']) $arr_query[] = 'view='.$_REQUEST['view'];
if($_REQUEST['gr_id']) $arr_query[] = 'gr_id='.$_REQUEST['gr_id'];
if($_REQUEST['bo_table']) $arr_query[] = 'bo_table='.$_REQUEST['bo_table'];
if($_REQUEST['rows']) $arr_query[] = 'rows='.$_REQUEST['rows'];
if($_REQUEST['gsearch']) $arr_query[] = 'gsearch='.$_REQUEST['gsearch'];
if($_REQUEST['page']) $arr_query[] = 'page='.$_REQUEST['page'];
$qstr = "&amp;".implode("&amp;", $arr_query);

$sca = $_REQUEST['sca'];
$sod = $_REQUEST['sod'];
$sst = $_REQUEST['sst'];
$sfl = $_REQUEST['sfl'];
$stx = $_REQUEST['stx'];
$target = $_REQUEST['target'];
$view= $_REQUEST['view'];
$gr_id = $_REQUEST['gr_id'];
$bo_table = $_REQUEST['bo_table'];
$rows = $_REQUEST['rows'];
$gsearch = $_REQUEST['gsearch'];
$page = $_REQUEST['page'];

$level2 = ($_COOKIE["write_list_level2"]) ? 1 : 0;
$level3 = ($_COOKIE["write_list_level3"]) ? 1 : 0;
$gsearch = ($_COOKIE["gsearch"]) ? 1 : 0;
$level2_display= $level2?"":"none";
$level3_display= $level3?"":"none";
$rowspan = 1;
$rowspan = $level2_display?"1":$rowspan++;
$rowspan = $level3_display?"1":$rowspan++;

if( isset($token) ){
    $token = @htmlspecialchars(strip_tags($token), ENT_QUOTES);
}

/**********
** 관리자에서 다시한번 불러와야 정상 적으로 출력이 된다
**********/
/*
if(empty($bo_table)) {
    $bo_table = "notice";
    $write = array();
    $write_table = "";
    $sql = " SELECT * FROM ".$g5['board_table']." WHERE bo_table = '".$bo_table."' ";
    $board = sql_fetch($sql);
    if ($board['bo_table']) {
        set_cookie("ck_bo_table", $board['bo_table'], 86400 * 1);
        $gr_id = $board['gr_id'];
        $write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
        if (isset($wr_id) && $wr_id) {
            $sql = " SELECT * FROM ".$write_table." WHERE wr_id = '".$wr_id."' ";
            $write = sql_fetch($sql);
        }
    }
}
*/
$gr_id = $gr_id?$gr_id:$group['gr_id'];
if ($gr_id) {
    $sql = " SELECT * FROM ".$g5['group_table']." WHERE gr_id = '".$gr_id."' ";
    $group = sql_fetch($sql);
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_ADMIN_BBS_URL.'/adm.bbs.css">', 0);
/*
** 스킨경로
*/
if (G5_IS_MOBILE) {
    $board_skin_path    = get_skin_path('board', $board['bo_mobile_skin']);
    $board_skin_url     = get_skin_url('board', $board['bo_mobile_skin']);
    $member_skin_path   = get_skin_path('member', $config['cf_mobile_member_skin']);
    $member_skin_url    = get_skin_url('member', $config['cf_mobile_member_skin']);
    $new_skin_path      = get_skin_path('new', $config['cf_mobile_new_skin']);
    $new_skin_url       = get_skin_url('new', $config['cf_mobile_new_skin']);
    $search_skin_path   = get_skin_path('search', $config['cf_mobile_search_skin']);
    $search_skin_url    = get_skin_url('search', $config['cf_mobile_search_skin']);
    $connect_skin_path  = get_skin_path('connect', $config['cf_mobile_connect_skin']);
    $connect_skin_url   = get_skin_url('connect', $config['cf_mobile_connect_skin']);
    $faq_skin_path      = get_skin_path('faq', $config['cf_mobile_faq_skin']);
    $faq_skin_url       = get_skin_url('faq', $config['cf_mobile_faq_skin']);
} else {
    $board_skin_path    = get_skin_path('board', $board['bo_skin']);
    $board_skin_url     = get_skin_url('board', $board['bo_skin']);
    $member_skin_path   = get_skin_path('member', $config['cf_member_skin']);
    $member_skin_url    = get_skin_url('member', $config['cf_member_skin']);
    $new_skin_path      = get_skin_path('new', $config['cf_new_skin']);
    $new_skin_url       = get_skin_url('new', $config['cf_new_skin']);
    $search_skin_path   = get_skin_path('search', $config['cf_search_skin']);
    $search_skin_url    = get_skin_url('search', $config['cf_search_skin']);
    $connect_skin_path  = get_skin_path('connect', $config['cf_connect_skin']);
    $connect_skin_url   = get_skin_url('connect', $config['cf_connect_skin']);
    $faq_skin_path      = get_skin_path('faq', $config['cf_faq_skin']);
    $faq_skin_url       = get_skin_url('faq', $config['cf_faq_skin']);
}
/*
** 스킨경로
*/
/**********
** 관리자에서 다시한번 불러와야 정상 출력 가능
**********/

/*
** 게시글 보기 설정
** 게시물 정보($write_row)를 출력하기 위하여 $list로 가공된 정보를 복사 및 가공
*/
function get_list2($write_row, $board, $skin_url, $subject_len=40)
{
    global $g5, $config;
    global $qstr, $page;

    //$t = get_microtime();

    // 배열전체를 복사
    $list = $write_row;
    unset($write_row);

    $board_notice = array_map('trim', explode(',', $board['bo_notice']));
    $list['is_notice'] = in_array($list['wr_id'], $board_notice);

    if ($subject_len)
        $list['subject'] = conv_subject($list['wr_subject'], $subject_len, '…');
    else
        $list['subject'] = conv_subject($list['wr_subject'], $board['bo_subject_len'], '…');

    // 목록에서 내용 미리보기 사용한 게시판만 내용을 변환함 (속도 향상) : kkal3(커피)님께서 알려주셨습니다.
    if ($board['bo_use_list_content'])
	{
		$html = 0;
		if (strstr($list['wr_option'], 'html1'))
			$html = 1;
		else if (strstr($list['wr_option'], 'html2'))
			$html = 2;

        $list['content'] = conv_content($list['wr_content'], $html);
	}

    $list['comment_cnt'] = '';
    if ($list['wr_comment'])
        $list['comment_cnt'] = "<span class=\"cnt_cmt\">".$list['wr_comment']."</span>";

    // 당일인 경우 시간으로 표시함
    $list['datetime'] = substr($list['wr_datetime'],0,10);
    $list['datetime2'] = $list['wr_datetime'];
    if ($list['datetime'] == G5_TIME_YMD)
        $list['datetime2'] = substr($list['datetime2'],11,5);
    else
        $list['datetime2'] = substr($list['datetime2'],5,5);
    // 4.1
    $list['last'] = substr($list['wr_last'],0,10);
    $list['last2'] = $list['wr_last'];
    if ($list['last'] == G5_TIME_YMD)
        $list['last2'] = substr($list['last2'],11,5);
    else
        $list['last2'] = substr($list['last2'],5,5);

    $list['wr_homepage'] = get_text($list['wr_homepage']);

    $tmp_name = get_text(cut_str($list['wr_name'], $config['cf_cut_name'])); // 설정된 자리수 만큼만 이름 출력
    $tmp_name2 = cut_str($list['wr_name'], $config['cf_cut_name']); // 설정된 자리수 만큼만 이름 출력
    if ($board['bo_use_sideview'])
        $list['name'] = get_sideview($list['mb_id'], $tmp_name2, $list['wr_email'], $list['wr_homepage']);
    else
        $list['name'] = '<span class="'.($list['mb_id']?'sv_member':'sv_guest').'">'.$tmp_name.'</span>';

    $reply = $list['wr_reply'];

    $list['reply'] = strlen($reply)*10;

    $list['icon_reply'] = '';
    if ($list['reply'])
        $list['icon_reply'] = '<img src="'.$skin_url.'/img/icon_reply.gif" style="margin-left:'.$list['reply'].'px;" alt="답변글">';

    $list['icon_link'] = '';
    if ($list['wr_link1'] || $list['wr_link2'])
        $list['icon_link'] = '<img src="'.$skin_url.'/img/icon_link.gif" alt="관련링크">';

    // 분류명 링크
    $list['ca_name_href'] = G5_ADMIN_BBS_URL.'/board.php?bo_table='.$board['bo_table'].'&amp;sca='.urlencode($list['ca_name'])."&amp;".$qstr;

    $list['href'] = G5_ADMIN_BBS_URL.'/board.php?bo_table='.$board['bo_table'].'&amp;wr_id='.$list['wr_id']."&amp;".$qstr;
    $list['comment_href'] = $list['href'];

    $list['icon_new'] = '';
    if ($board['bo_new'] && $list['wr_datetime'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - ($board['bo_new'] * 3600)))
        $list['icon_new'] = '<img src="'.$skin_url.'/img/icon_new.gif" alt="새글">';

    $list['icon_hot'] = '';
    if ($board['bo_hot'] && $list['wr_hit'] >= $board['bo_hot'])
        $list['icon_hot'] = '<img src="'.$skin_url.'/img/icon_hot.gif" alt="인기글">';

    $list['icon_secret'] = '';
    if (strstr($list['wr_option'], 'secret'))
        $list['icon_secret'] = '<img src="'.$skin_url.'/img/icon_secret.gif" alt="비밀글">';

    // 링크
    for ($i=1; $i<=G5_LINK_COUNT; $i++) {
        $list['link'][$i] = set_http(get_text($list["wr_link{$i}"]));
        $list['link_href'][$i] = G5_ADMIN_BBS_URL.'/link.php?bo_table='.$board['bo_table'].'&amp;wr_id='.$list['wr_id'].'&amp;no='.$i.$qstr;
        $list['link_hit'][$i] = (int)$list["wr_link{$i}_hit"];
    }

    // 가변 파일
    if ($board['bo_use_list_file'] || ($list['wr_file'] && $subject_len == 255) /* view 인 경우 */) {
        $list['file'] = get_file2($board['bo_table'], $list['wr_id']);
    } else {
        $list['file']['count'] = $list['wr_file'];
    }

    if ($list['file']['count'])
        $list['icon_file'] = '<img src="'.$skin_url.'/img/icon_file.gif" alt="첨부파일">';

    return $list;
}

// get_list 의 alias
function get_view2($write_row, $board, $skin_url)
{
    return get_list2($write_row, $board, $skin_url, 255);
}

// 게시글에 첨부된 파일을 얻는다. (배열로 반환)
function get_file2($bo_table, $wr_id)
{
    global $g5, $qstr;

    $file['count'] = 0;
    $sql = " select * from {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '$wr_id' order by bf_no ";
    $result = sql_query($sql);
    while ($row = sql_fetch_array($result))
    {
        $no = $row['bf_no'];
        $file[$no]['href'] = G5_ADMIN_BBS_URL."/download.php?bo_table=$bo_table&amp;wr_id=$wr_id&amp;no=$no" . $qstr;
        $file[$no]['download'] = $row['bf_download'];
        // 4.00.11 - 파일 path 추가
        $file[$no]['path'] = G5_DATA_URL.'/file/'.$bo_table;
        $file[$no]['size'] = get_filesize($row['bf_filesize']);
        $file[$no]['datetime'] = $row['bf_datetime'];
        $file[$no]['source'] = addslashes($row['bf_source']);
        $file[$no]['bf_content'] = $row['bf_content'];
        $file[$no]['content'] = get_text($row['bf_content']);
        //$file[$no]['view'] = view_file_link($row['bf_file'], $file[$no]['content']);
        $file[$no]['view'] = view_file_link2($row['bf_file'], $row['bf_width'], $row['bf_height'], $file[$no]['content']);
        $file[$no]['file'] = $row['bf_file'];
        $file[$no]['image_width'] = $row['bf_width'] ? $row['bf_width'] : 640;
        $file[$no]['image_height'] = $row['bf_height'] ? $row['bf_height'] : 480;
        $file[$no]['image_type'] = $row['bf_type'];
        $file['count']++;
    }

    return $file;
}

// 파일을 보이게 하는 링크 (이미지, 플래쉬, 동영상)
function view_file_link2($file, $width, $height, $content='')
{
    global $config, $board;
    global $g5;
    static $ids;

    if (!$file) return;

    $ids++;

    // 파일의 폭이 게시판설정의 이미지폭 보다 크다면 게시판설정 폭으로 맞추고 비율에 따라 높이를 계산
    if ($width > $board['bo_image_width'] && $board['bo_image_width'])
    {
        $rate = $board['bo_image_width'] / $width;
        $width = $board['bo_image_width'];
        $height = (int)($height * $rate);
    }

    // 폭이 있는 경우 폭과 높이의 속성을 주고, 없으면 자동 계산되도록 코드를 만들지 않는다.
    if ($width)
        $attr = ' width="'.$width.'" height="'.$height.'" ';
    else
        $attr = '';

    if (preg_match("/\.({$config['cf_image_extension']})$/i", $file)) {
        $img = '<a href="'.G5_ADMIN_BBS_URL.'/view_image.php?bo_table='.$board['bo_table'].'&amp;fn='.urlencode($file).'" target="_blank" class="view_image">';
        $img .= '<img src="'.G5_DATA_URL.'/file/'.$board['bo_table'].'/'.urlencode($file).'" alt="'.$content.'" '.$attr.'>';
        $img .= '</a>';

        return $img;
    }
}

// 회원의 접근 가능한 게시판 목록을 배열로 반환
function get_member_board($mb_id="", $gr_id="", $bo_table=""){
	global $g5, $is_admin;

	$sql = "SELECT a.bo_table, a.gr_id, b.gr_subject, a.bo_subject, a.bo_list_level, b.gr_use_access FROM ".$g5['board_table']." a, ".$g5['group_table']." b WHERE a.gr_id=b.gr_id ";

	// 그룹이 있으면 해당 그룹 검색
	if ($gr_id)  $sql_search = " AND a.gr_id='".$gr_id."' ";
	else if ($bo_table) $sql_search = " AND a.bo_table='".$bo_table."' "; 	// 게시판이 있으면 그룹은 제거하고 게시판만 검색

	// 최고관리자가 아니면 검색허용 게시판만, 접근허용 게시판만
	if ($is_admin != "super") {
		$result = sql_query("SELECT gr_id FROM ".$g5['group_member_table']." WHERE mb_id='".$mb_id."' ");
		$group_member_board = array();
		while($row = sql_fetch_array($result))
			$group_member_board[] = "'" . $row[gr_id] . "'";

		if ($group_member_board)
			$sql_gr_use_access = " or b.gr_id in ( " . implode("," , $group_member_board) . ")";

		$sql_search .= " AND a.bo_use_search='1' AND	(	b.gr_use_access='0' ".$sql_gr_use_access." )";
	}

	$sql .= $sql_search;
	$result = sql_query($sql);

	$board_list = array();
	for($i=0; $board = sql_fetch_array($result); $i++)
			$board_list[] = $board; // 그룹접근 미사용인 경우

	return $board_list;
}

// 게시글 검색 쿼리 생성
function get_sql_search_union2($member_board, $sql_search, $sst="wr_comment"){
	global $g5;

    $sql = $sql_cnt = "";
	$sql_common = " , ca_name, wr_num, wr_reply, wr_parent, wr_datetime, wr_subject, wr_name, wr_comment, wr_is_comment, wr_content, wr_ip, wr_last
		                        , wr_email, wr_homepage, wr_option, wr_link1, wr_link2, wr_link1_hit, wr_link2_hit, wr_hit, wr_good, wr_nogood
		                        , wr_1, wr_2, wr_3, wr_4, wr_5, wr_6, wr_7, wr_8, wr_9, wr_10 ";

	// 댓글, 조회, 추천, 비추천, 링크1조회, 링크2조회 순일 때
	if ($sst != "bf_download" && $sst != "scrap") {
		$bo_count = count($member_board);
		$i=0;
		$sst = "";
		foreach ($member_board AS $board) {
			$write_table = $g5['write_prefix'].$board['bo_table'];

			$sql .= $op;
			$sql_cnt .= $op;

			$sql .= " SELECT '".$board['bo_table']."' AS bo_table, '".$board['bo_subject']."' AS bo_subject, '".$board['gr_subject']."' AS gr_subject, wr_id, mb_id ".$sst." ".$sql_common."
        				FROM ".$write_table."
        				WHERE (1) ".$sql_search;

			$sql_cnt .= "SELECT '".$board['bo_table']."' AS bo_table, COUNT(*) AS cnt
            				FROM ".$write_table."
            				WHERE (1) ".$sql_search;
			$op = " union ";
		}
	} else { // 다운로드순 또는 스크랩순일때
		if ($sst == "bf_download") {
			$joinTable = $g5['board_file_table'];
			$count_sst = " , SUM(bf_download) AS ".$sst;
		}else {
			$joinTable = $g5['scrap_table'];
			$count_sst = " , COUNT(ms_id) AS ".$sst;
			// $g5[scrap_table]과 $g5[write_table]의 mb_id 중복으로 where 절에서 발생하는 오류 방지
			$sql_search = preg_replace("/[[:space:]]+mb_id[[:space:]]+/", "a.mb_id", $sql_search);
		}

        $sql = " SELECT DISTINCT bo_table FROM ".$joinTable;
		$result = sql_query($sql);
		$joinTable_board = array();
		while ($row = sql_fetch_array($result))
			$joinTable_board[] = $row['bo_table'];

		foreach ($member_board as $key => $board) {
			if (!in_array($board['bo_table'], $joinTable_board))
				unset($member_board[$key]);
		}

		$bo_count = count($member_board);
		foreach ($member_board as $board) {
			$write_table = $g5['write_prefix'].$board['bo_table'];

			$sql .= $op;
			$sql_cnt .= $op;

			$sql .= "SELECT '".$board['bo_table']."' AS bo_table, '".$board['bo_subject']."' AS bo_subject, '".$board['gr_subject']."' AS gr_subject,b.wr_id, a.mb_id $sql_common ".$count_sst."
				FROM ".$write_table." a, ".$joinTable." b
				WHERE (1) AND b.bo_table = '".$board['bo_table']."' AND a.wr_id = b.wr_id ".$sql_search."
				GROUP BY b.bo_table, b.wr_id";

			$sql_cnt .= "SELECT '".$board['bo_table']."' AS bo_table, b.wr_id, count(distinct b.wr_id) AS cnt
				FROM ".$write_table." a, ".$joinTable." b
				WHERE 1 AND b.bo_table = '".$board['bo_table']."' AND a.wr_id=b.wr_id ".$sql_search."
				GROUP BY b.bo_table, b.wr_id";

			$op = " union ";
		}
	}
	return array($sql, $sql_cnt);
}

// 게시판 그룹을 SELECT 형식으로 얻음
function get_group_select2($name, $selected='', $event='')
{
	global $g5, $is_admin, $member;

	$sql = " SELECT gr_id, gr_subject FROM ".$g5['group_table']." a ";
	if ($is_admin == "group")
		$sql .= " LEFT JOIN ".$g5['member_table']." b ON (b.mb_id = a.gr_admin)  WHERE b.mb_id = '".$member['mb_id']."' ";
	$sql .= " ORDER BY a.gr_id ";
	$result = sql_query($sql);
	$str = "<select name='".$name."' id='".$name."' ".$event.">";
	$str .= "<option value=''> ::: 전체그룹 ::: </option>";
	for ($i=0; $row=sql_fetch_array($result); $i++)	{
		$str .= "<option value='".$row['gr_id']."'";
		if ($row['gr_id'] == $selected) $str .= " selected='selected' ";
		$str .= ">".$row['gr_subject']."</option>";
	}
	$str .= "</select>";
	return $str;
}

// 게시판을 SELECT 형식으로 얻음
function get_board_select($name, $selected='', $event='', $gr_id="")
{
    global $g5, $is_admin, $member;
	if ($gr_id) $gr_id=" AND gr_id='".$gr_id."' ";
    $sql = " SELECT bo_table, bo_subject from ".$g5['board_table']." WHERE 1 ".$gr_id." AND bo_table <> 'mailer' ";
    $sql .= " ORDER BY bo_table ";
    $result = sql_query($sql);
    $str = "<select name='".$name."' id='".$name."' ".$event.">";
	$str .= "<option value=''> ::: 전체게시판 ::: </option>";
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $str .= "<option value='".$row['bo_table']."'";
        if ($row['bo_table'] == $selected) $str .= " selected";
        $str .= ">".$row['bo_subject']."</option>";
    }
    $str .= "</select>";
    return $str;
}

// 한 화면에 보여질 목록 개수을 select 박스로 반환
function get_rows_select($name, $bo_page_rows, $selected=10, $event='')
{
	$arr_cnt = array(10, 15, 20, 30, 40, 50, 100);

	if ($bo_page_rows && !in_array($bo_page_rows, $arr_cnt)) {
		array_push($arr_cnt, $bo_page_rows);
		sort($arr_cnt);
	}

	$selectbox = "<select name='$name' id='".$name."' ".$event.">\n";
    $selectbox .= "<option value=''> ::: 페이지당 글수 ::: </option>";
	foreach ($arr_cnt as $cnt) {
		$selectbox .= "<option value='".$cnt."'";
		if ($cnt==$selected) $selectbox .= " selected";
		$selectbox .= ">".$cnt."개씩 보기</option>\n";
	}
	$selectbox .= "</select>\n";

	return $selectbox;
}
/*
** 게시글 보기 설정
*/
?>
