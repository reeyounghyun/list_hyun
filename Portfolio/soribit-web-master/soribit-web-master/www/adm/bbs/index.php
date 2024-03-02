<?php
/**************************
@Filename: index.php
@Version : 1.0
@Author  : Freemaster
@Date  : 2016/05/27
@Edit Date  : 2018/07/27
@Content : PHP by Editplus
**************************/
include_once("./_common.php");

auth_check($auth[$sub_menu], 'r');

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';
$g5['title'] .= '게시글 관리';

$board['bo_subject_len'] = 70;// 제목 길이
include_once(G5_ADMIN_PATH.'/admin.head.php');
include_once(G5_ADMIN_BBS_PATH.'/board_head.php');

$sql = " SHOW VARIABLES LIKE '%VERSION%' ";
$row = sql_fetch($sql);
$mysql_version = $row['Value'];
$is_union = (intval(substr($mysql_version, 0, 1))<4) ? 0 : 1;

if ($sst)
	$sql_order = " ORDER BY ".$sst." ".$sod;
else
	$sql_order = " ORDER BY wr_num, wr_reply ";

$sql_search = "";
if ($view=="w")
	$sql_search .= " AND wr_is_comment='0' ";
else if ($view=="c")
	$sql_search .= " AND wr_is_comment='1' ";
else
    $sql_search .= " ";

if ($sca || $stx)
	$sql_search .= " AND " . get_sql_search($sca, $sfl, $stx, $sop);

$member_board = array();
if ($bo_table || $gr_id) {
	if ($bo_table)
		$member_board = get_member_board($member['mb_id'], "", $bo_table);
	else if ($gr_id)
		$member_board = get_member_board($member['mb_id'], trim($gr_id));
	else
		$member_board = get_member_board($member['mb_id']);

	if (empty($member_board))
		$str_result = "자료가 없습니다";
} else
	$str_result = "그룹 또는 게시판을 선택하세요.<br>그룹검색허용을 체크하면 여러 게시판을 검색할 수 있습니다.<br>(단, 데이터가 많을 경우 속도 저하가 발생합니다.)";

$total_count = 0;
$list = array();
list($sql_select, $sql_count) = get_sql_search_union2($member_board, $sql_search, $sst);
if ($sql_select) {
	$result = sql_query($sql_count);
	while($row2 = sql_fetch_array($result))
		$total_count += $row2['cnt'];

	$total_count = ($total_count < 0)?0:$total_count;
    $page_rows = $rows = $rows?$rows:$config['cf_page_rows'];
    if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
    $total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
    $from_record = ($page - 1) * $page_rows; // 시작 열을 구함
    $list_num = $total_count - ($page - 1) * $page_rows;

    $sql = $sql_select." ".$sql_order." LIMIT ".$from_record.", ".$page_rows;
	$result = sql_query($sql);
	for($i=0; $row = sql_fetch_array($result); $i++) {
		$board['bo_table']	 =	 trim($row['bo_table']);
		$list[$i] = get_list($row, $board, $g5['admin_path'], $board['bo_subject_len']);
		$list[$i]['cnt']	= $row[$sst];

        $list[$i]['num'] = $list_num - $k;
		$list[$i]['bo_subject'] = trim($row['bo_subject']);
		$list[$i]['gr_subject'] = trim($row['gr_subject']);
		$list[$i]['bo_table'] = trim($row['bo_table']);
		$k++;
	}

	@sql_free_result($result);
    if(empty($str_result))
    	$str_result = (empty($list))?"자료가 없습니다":"";
}

$width="100%";
$colspan = 11;
$list_count = count($list);
?>

<div class="local_ov01 local_ov">
    <?php echo $listall ?>
    <span class="btn_ov01"><span class="ov_txt"> 게시글 수 </span><span class="ov_num"><?php echo number_format($total_count) ?>건</span></span>
</div>

<div class="local_desc01 local_desc">
    <p>그룹선택, 게시판선택, 게시물의 원글, 코멘트 선택, 제목, 내용, 회원아이디, 글쓴이, 검색어 등록 등으로 검색을 할 수 가 있습니다
    <p><strong>그룹검색 허용을 선택하거나 검색어를 입력</strong>하여 <strong>여러 게시판을 동시에 검색</strong> 할 수 있습니다</p>
    <p><strong>그룹검색시 데이터가 많은 경우</strong> 느려질 수 있습니다</p>
    <?php if($mysql_version < 4.0) { ?>
    <p>현재 버젼에서는 사용할 수 없습니다. <strong>MySQL4.x 이상</strong>에서만 사용가능합니다.</p>
    <?php } ?>
</div>

<div class="fsearch">
<form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get" onsubmit="return fsearch_check(this)">
<input type="hidden" name="sca" value="<?=$sca?>" />
<input type="hidden" name="sod" value="<?=$sod?>" />
<input type="hidden" name="target" value="<?=$target?>" />
<span class="chkArea">
    <input type='checkbox' name="gsearch" id="gsearch" value="1" onclick="is_union(this)" <?=$gsearch?"checked":""?>>
    <label for="gsearch">그룹검색허용 </label>
</span>
<label for="gr_id" class="sound_only">그룹검색</label>
<?php echo(get_group_select2("gr_id", $gr_id, "onchange=\"changeGroup(this.form, this)\"")); ?>
<label for="bo_table" class="sound_only">게시판 검색</label>
<?php echo(get_board_select("bo_table", $bo_table, "onchange=\"changeBoard(this.form, this)\"", $gr_id));?>
<select id="view" name="view" onchange="changeBoard(this.form, this.form.bo_table);">
    <option value=''>전체게시물</option>
    <option value='w'>원글만</option>
    <option value='c'>코멘트만</option>
</select>
<select name="sfl" id="sfl">
    <option value=""> ::: 선택 ::: </option>
    <option value="wr_subject">제목</option>
    <option value="wr_content">내용</option>
    <option value="wr_subject||wr_content" selected>제목+내용</option>
    <option value="mb_id,1">회원아이디</option>
    <option value="mb_id,0">회원아이디(코)</option>
    <option value="wr_name,1">글쓴이</option>
    <option value="wr_name,0">글쓴이(코)</option>
</select>
<label for="stx" class="sound_only">검색어</label>
<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" class="frm_input">
<input type="submit" value="검색" class="btn_submit">
<span class="chkArea">
    <input type="radio" name="sop" value="and" id="sop_and"/><label for="sop_and">AND</label>
    <input type="radio" name="sop" value="or" id="sop_or"/><label for="sop_or">OR</label>
</span>
<span class="chkArea">
    <input type="checkbox" name="level2" id="level2" value="1" onclick="view_level(this, 2)">
    <label for="level2">필드 더보기</label>
</span>
<span class="chkArea">
    <input type="checkbox" name="level3" id="level3" value="1" onclick="view_level(this, 3)">
    <label for="level3">여분필드, 링크 보기</label>
</span>
<?php echo(get_rows_select("rows", $config['bo_page_rows'], $rows, "onchange=\"changeBoard(this.form, this.form.bo_table)\""))?>

<p class="newWrite">
    <select name="select1" id="select1">
        <option value=""> ::: 그룹 선택 ::: </option>
        <?php
        $sql = " SELECT gr_id, gr_subject FROM  ".$g5['group_table']." ";
        $result = sql_query($sql);
        for($i=0; $row = sql_fetch_array($result);$i++){
            echo("<option value='".$row['gr_id']."'>".$row['gr_subject']."</option>");
        }?>
    </select>
    <select name="select2" id="select2"><option value=""> ::: 게시판 선택 ::: </option></select>
    <a href="<?php echo G5_ADMIN_BBS_URL."/write.php";?>" id="board_write" class="ov_listall">글쓰기</a>
    <!-- <a href="<?php echo G5_ADMIN_BBS_URL."/write.php?bo_table=".$bo_table;?>" class="ov_listall"><?php echo $group['gr_subject'];?>그룹 > <?php echo $board['bo_subject'];?>게시판 > 글쓰기</a> -->
</p>
</form>
</div>
<script>
$(function()
{
	$("#select1").change(function() {
		var id=$(this).val();
		var dataString = 'id='+id;

		$.ajax({
			async: false,
			cache: false,
			type: "POST",
			url: "./group_select_ajax.php",
			data: dataString,
			cache: false,
			success: function(selectoption) {
                $("#select2").attr("css",{dispaly:"block"});
				$("#select2").html(selectoption);
			}
		});
	});

    $("#board_write").click(function() {
        board_write(this.href);
        return false;
    });
});
var board_write = function(href) {
    var $select1 = $("#select1 option:selected").val();
    var $select2 = $("#select2 option:selected").val();
    var $href = href+"?gr_id="+$select1+"&bo_table="+$select2;

    if($select1=="undefined" || $select1 == "") {
        alert("그룹을 선택하세요");
        return false;
    }
    if($select2=="undefined" || $select2 == "") {
        alert("게시판을 선택하세요");
        return false;
    }
    document.location.href = $href;
}
</script>
<form name="fgblist" id="fgblist" action="./gblist_list_update.php" onsubmit="return fgblist_submit(this);" method="post">
<input type="hidden" name="sst" value='<?=$sst?>'>
<input type="hidden" name="sod" value='<?=$sod?>'>
<input type="hidden" name="sop" value='<?=$sop?>'>
<input type="hidden" name="sfl" value='<?=$sfl?>'>
<input type="hidden" name="stx" value='<?=$stx?>'>
<input type="hidden" name="page" value='<?=$page?>'>
<input type="hidden" name="token" value='<?=$token?>'>
<input type="hidden" name="gr_id"	 value='<?=$gr_id?>'>
<input type="hidden" name="bo_table" value='<?=$bo_table?>'>
<input type="hidden" name="view" value='<?=$view?>'>
<input type="hidden" name="rows" value='<?=$rows?>'>
<input type="hidden" name="target" value="<?=$target?>">
<input type="hidden" name="gsearch" value="<?=$gsearch?>">

<div class="tbl_head01 tbl_wrap">
    <table>
        <caption><?php echo $g5['title']; ?> 목록</caption>
        <thead>
        <colgroup>
            <col width="3%">
            <col width="4%">
            <col width="10%">
            <col width="10%">
            <col width="*">
            <col width="6%">
            <col width="8%">
            <col width="5%">
            <col width="5%">
            <col width="5%">
            <col width="9%">
        </colgroup>
	<thead>
	<tr>
        <th class="nolne_left">
            <label for="chkall" class="sound_only">게시글 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th class="title">번호</th>
        <th class="title">그룹</th>
        <th class="title">게시판</th>
        <th class="title"><?php echo subject_sort_link('wr_subject',$qstr) ?>제목</a></th>
        <th class="title">작성자</th>
        <th class="title"><?php echo subject_sort_link('wr_datetime',$qstr) ?>등록일</a></th>
        <th class="title_num"><?php echo subject_sort_link('wr_hit',$qstr) ?>조회</a></th>
        <th class="title_num">추천</th>
        <th class="title_num">링크1</th>
        <th class="title_num">명령</th>
				<?php if($_GET['bo_table'] === 'free') {?>
					<th class="title">차단 여부</th>
				<?php } ?>
	</tr>
	<tr id="level2_title" style="display:<?php echo $level2_display?>">
		<!-- <th class="nolne_left"></th> -->
		<th class="title" colspan='4'>이메일/홈페이지</th>
		<th class="title">분류</th>
		<th class="title">아이피</th>
		<th class="title">수정일</th>
		<th class="title_num">비밀</th>
		<th class="title_num">비추</th>
		<th class="title_num">링크2</th>
		<th></th>
	</tr>
	<tr id="level3_title" style="display:<?php echo $level3_display?>">
		<!-- <th class="nolne_left"></th> -->
		<th class="title" colspan='4'>여분필드1~5</th>
		<th class="title">여분필드6~10</th>
		<th class="title" colspan='2'>링크주소1</th>
		<th class="title" colspan='3'>링크주소2</th>
		<th></th>
	</tr>
	</thead>
    <tbody>
<?php
for ($i=0; $i<$list_count; $i++) {
	$li = $list[$i];
    $bg = 'bg'.($i%2);
	$html	= strstr($li['wr_option'], "html1") ? "html1" : "";
	$html	= strstr($li['wr_option'], "html2") ? "html2" : $html;
	$secret= strstr($li['wr_option'], "secret") ? "secret" : "";
	$tsecret = $secret ? "checked" : "";
	$mail	= strstr($li['wr_option'], "mail") ? "mail" : "";

	$s_upd = "";
	$s_del = "";
	$s_view = "";
	$s_list = '<a href="./board.php?bo_table='.$li['bo_table'].'" title="목록" class="btn btn_03">목록</a>';

	if (empty($li['wr_is_comment'])) { // 원글이라면
        $li['wr_subject'] = conv_subject($li['wr_subject'], 200, '…');
		$wr_subject = "<input type='text' id='' name='wr_subject[]' class='tbl_input' value='".$li['wr_subject']."'>";

        $s_upd = '<a href="./write.php?bo_table='.$li['bo_table'].'&wr_id='.$li['wr_id'].'&w=u" title="수정" class="btn btn_03">수정</a>';
	    $s_view = '<a href="./board.php?bo_table='.$li['bo_table'].'&wr_id='.$li['wr_id'].'" title="보기" class="btn btn_02">보기</a>';
	} else { // 댓글이라면
		$wr_subject = 	get_text( $li['wr_content'] );
		$wr_subject = "&nbsp;└&nbsp;&nbsp;<input type='text' id='' name='wr_subject[]' class='bbsInput width95p' value='".$wr_subject."'>";
        $s_view = '<a href="./board.php?bo_table='.$li['bo_table'].'&wr_id='.$li['wr_parent'].'" title="보기" class="btn btn_02">보기</a>';
	}
?>
	<input type="hidden" name="wr_id[]" value="<?php echo($li['wr_id']);?>" />
	<input type="hidden" name="bo_table_list[]" value="<?php echo($li['bo_table']);?>" />
	<input type="hidden" name="mb_id[]" value="<?php echo($li['mb_id']);?>" />
    <tr id="line<?php echo($i);?>_1">
        <td class="ck_pointer">
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['bo_subject']) ?></label>
            <input type='checkbox' id="chk_<?php echo($i);?>" name="chk[]" class="ck_secret" value='<?php echo($i);?>' />
        </td>
        <td class="num"><?php echo($li['num']);?></td>
        <td  class='tleft pleft10'><input type="text" id="" name="gr_subject[]" class="tbl_input" value="<?php echo($li['gr_subject']);?>" readOnly title="그룹제목" /></td>
        <td class='tleft pleft10'><input type="text" id="" name="bo_subject[]" class="tbl_input" value="<?php echo($li['bo_subject']);?>" readOnly title="게시판제목" /></td>
        <td  class='tleft pleft10'><?php echo($wr_subject);?></td>
        <td  class='tleft pleft10'><input type="text" id="" name="wr_name[]" class="tbl_input" value="<?php echo($li['wr_name']);?>" title="글작성자" /></td>
        <td class='tleft pleft10'><input type="text" id="" name="wr_datetime[]" class="tbl_input"  value="<?php echo($li['wr_datetime']);?>" style="color:dimgray" title="등록일" /></td>
        <td class='tleft pleft10'><input type="text" id="" name="wr_hit[]" class="tbl_input" value="<?php echo($li['wr_hit']);?>"  title="조회수" /></td>
        <td class='tleft pleft10'><input type="text" id="" name="wr_good[]" class="tbl_input" value="<?php echo($li['wr_good']);?>" title="추천수" /></td>
        <td class='tleft pleft10'><input type="text" id="" name="wr_link1_hit[]" class="tbl_input" value="<?php echo($li['wr_link1_hit']);?>"  title="링크1조회수" /></td>
        <td class="td_mng td_mng_l"><?php echo $s_upd . $s_view . $s_list;?></td>
				<?php if($_GET['bo_table'] === 'free') {?><td class="tleft pleft10"><?php echo $li['wr_3'] == 1 ? 'O' : 'X';?></td><?php }?>
    </tr>
    <tr id="line<?php echo($i);?>_2" style="display:<?php echo($level2_display);?>">
        <td colspan='4' class='tleft pleft10'>
            <input type="text" name="wr_email[]" class="width45p bbsInput" value="<?php echo($li['wr_email']);?>" title="이메일" /> /
            <input type="text" name="wr_homepage[]" class="width45p bbsInput" value="<?php echo($li['wr_homepage']);?>"  title="홈페이지" />
        </td>
        <td class='tleft pleft10'>
            <input type="text" name="ca_name[]" class="tbl_input" value="<?php echo($li['ca_name']);?>" title="분류" />
        </td>
        <td class='tleft pleft10'><input type="text" name="wr_ip[]" class="tbl_input" value="<?php echo($li['wr_ip']);?>" title="아이피" /></td>
        <td class='tleft pleft10'><input type="text" name="wr_last[]" class="tbl_input" value="<?php echo($li['wr_last']);?>" title="수정일" /></td>
        <td class="ck_pointer">
            <input type="hidden" name="html[]" value="<?php echo($html);?>" />
            <input type="hidden" name="mail[]" value="<?php echo($mail);?>" />
            <input type="hidden" name="secret[]" value="<?php echo($secret);?>" />
            <input type="checkbox" name="tsecret[]" id="secret_<?php echo($i);?>" <?php echo($tsecret);?>  title="비밀글" class="checkbox" />
        </td>
        <td class='tleft pleft10'><input type="text" name="wr_nogood[]" class="tbl_input" value="<?php echo($li['wr_nogood']);?>" title="비추천수" /></td>
        <td class='tleft pleft10'><input type="text" name="wr_link2_hit[]" class="tbl_input" value="<?php echo($li['wr_link2_hit']);?>" title="링크2조회수" /></td>
        <td>&nbsp;</td>
    </tr>
    <tr id="line<?php echo($i);?>_3" style="display:<?php echo($level3_display);?>">
        <td colspan='4' class='td_numbig pleft10'>
            <?php for ($k=1; $k<=5; $k++) { ?>
            <p><?php echo $k;?>. <input type="text" name="wr_<?php echo $k?>[]" class="width95p bbsInput" value="<?php echo($li['wr_'.$k]);?>" title="여분필드<?php echo $k;?>" /></p>
            <?php } ?>
        </td>
        <td class='td_numbig pleft10'>
            <?php for ($k=6; $k<=10; $k++) { ?>
            <p><?php echo $k;?>. <input type="text" name="wr_<?php echo $k?>[]" class="width95p bbsInput" value="<?php echo($li['wr_'.$k]);?>" title="여분필드<?php echo $k;?>" /></p>
            <?php } ?>
        </td>
        <td colspan="3" class='tleft pleft10'>
            <input type="text" name="wr_link1[]" class="tbl_input" value="<?php echo($li['wr_link1']);?>" title="링크1 주소" />
        <td colspan='3' class='tleft pleft10'>
            <input type="text" name="wr_link2[]" class="tbl_input" value="<?php echo($li['wr_link2']);?>" title="링크2 주소" />
        </td>
    </tr>
    <?php
    }
    if ($i == 0)
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">'.$str_result.'</td></tr>';
    ?>
	</tbody>
    </table>
</div>

<!-- <div class="btn_fixed_top">
    <input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value" class="btn_02 btn">
    <?php if ($is_admin == 'super') { ?>
    <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="btn_02 btn">
    <?php } ?>
</div>-->
</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>
<script type="text/javascript">
// 기본설정코드
var list_count = <?=$list_count;?>;

function cmaObject(objectId) {
	// checkW3C DOM, then MSIE 4, then NN 4.
	if(document.getElementById && document.getElementById(objectId)) {
		return document.getElementById(objectId);
	} else if (document.all && document.all(objectId)) {
		return document.all(objectId);
	} else if (document.layers && document.layers[objectId]) {
		return document.layers[objectId];
	} else {
		return false;
	}
	// 사용법 : cmaObject('sendbn').value="";
}

cmaObject("sfl").value = "<?=$sfl?>"; // 검색
cmaObject("sst").value = "<?=$sst?>"; // 정렬
cmaObject("view").value = "<?=$view?>"; // 코멘트, 원글 여부
cmaObject("level2").checked = <?=($level2?'true':'false')?>;
cmaObject("level3").checked = <?=($level3?'true':'false')?>;
setCheckedValue(document.fsearch.sop, "<?=$sop?>");

// 게시판 클래스
function Board(gr_id, gr_subject, bo_table, bo_subject)
{
	this.bo_table = bo_table;
	this.bo_subject = bo_subject;
	this.gr_id = gr_id;
	this.gr_subject = gr_subject;
}

<?php
$sql = "SELECT * FROM ".$g5['board_table']." ORDER BY bo_table";
$result = sql_query($sql);
$javascriptBoard = "var board = new Array(); \n";
while($row = sql_fetch_array($result))
	$javascriptBoard .= "board.push(new Board('".$row['gr_id']."', '".$row['wr_id']."', '".$row['bo_table']."', '".$row['bo_subject']."'));";

echo($javascriptBoard);
?>

var f = document.fwritelist;
for (var i=0; i<f.length; i++) {
	if (f[i].getAttribute("type") == "text") {
		f[i].onclick = function() {
			//this.select();
		}

		f[i].onmouseover = function() {
			if (this.value)
				this.title = this.value;
		}

		f[i].onfocus = function() {
			this.select();
			this.style.color = "red";
		}

		f[i].onblur = function() {
			this.style.color = "black";
		}
	}
}

function fsearch_check(form)
{
	if (form.gsearch.checked) {
        if(form.gr_id.value == "") {
            alert("검색할 그룹을 선택하세요");
            form.gr_id.focus();
            return false;
        }
		return true;
	} else {
		if (form.bo_table.value == "") {
			alert("검색할 게시판을 선택하세요");
			form.bo_table.focus();
			return false;
		}
		return true;
	}
}

function changeGroup(form, obj)
{
	if (form.gsearch.checked) {
		form.bo_table.value = '';
		form.submit();
	} else {
		form.bo_table.innerHTML = '';
		form.bo_table.options.add(new Option("전체게시판", ""));
		for(var i=0; i<board.length; i++)
		{
			if (obj.value) {
				if (board[i].gr_id == obj.value)
					form.bo_table.options.add(new Option(" - " + board[i].bo_subject, board[i].bo_table));
			} else
				form.bo_table.options.add(new Option(" - " + board[i].bo_subject, board[i].bo_table));

		}
	}
}

function changeBoard(form, obj)
{
	if (form.gsearch.checked)
		form.submit();
	else
		if (obj.value != '') form.submit();
}

function is_union(obj)
{
	if (!<?=$is_union?>) {
		alert("MySQL4.x 이상의 버전에서만 사용할 수 있습니다.\n현재 MySQL버전: <?=$mysql_version?>");
		obj.checked = false;
		return;
	}

	if (obj.checked)
		set_cookie("gsearch", 1, 1);
	else
		set_cookie("gsearch", "", -1);
}

function view_level(obj, level)
{
	if (obj.checked) {
		display_value = "";
		set_cookie("write_list_level"+level, level, 1);
	}
	else {
		display_value = "none";
		set_cookie("write_list_level"+level, "", -1);
	}

	for(var i=0; i<list_count; i++) {
		cmaObject("line" + i + "_" + level).style.display = display_value;
	}
	cmaObject("level" + level + "_title").style.display = display_value;
}

/*=======================================
	setCheckedValue(radioObj, newValue)
========================================*/
function setCheckedValue(radioObj, newValue) {
	if(!radioObj)
		return;
	var radioLength = radioObj.length;
	if(radioLength == undefined) {
		radioObj.checked = (radioObj.value == newValue.toString());
		return;
	}
	for(var i = 0; i < radioLength; i++) {
		radioObj[i].checked = false;
		if(radioObj[i].value == newValue.toString()) {
			radioObj[i].checked = true;
		}
	}
}

/*=======================================
	getCheckedValue(radioObj)
========================================*/
function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}

// 수정 및 삭제
function fgblist_submit(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}
</script>
<?php
include_once(G5_ADMIN_BBS_PATH.'/board_tail.php');
include_once(G5_ADMIN_PATH.'/admin.tail.php');
?>