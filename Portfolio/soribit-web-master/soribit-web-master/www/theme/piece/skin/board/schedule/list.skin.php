<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once("$board_skin_path/moonday.php"); // 석봉운님의 음력날짜 함수

$today = getdate();
$b_mon = $today['mon'];
$b_day = $today['mday'];
$b_year = $today['year'];
if ($year < 1) { // 오늘의 달력 일때
    $month = $b_mon;
    $mday = $b_day;
    $year = $b_year;
}

if(!$year) 	$year = date("Y");
$file_index = $board_skin_path."/day"; ### 기념일 폴더 위치 지정

### 양력 기념일 파일 지정 : 해당년도 파일이 없으면 기본파일(solar.txt)을 불러온다
$dayfile = file($file_index."/solar.txt");

$lastday=array(0,31,28,31,30,31,30,31,31,30,31,30,31);
if ($year%4 == 0) $lastday[2] = 29;
$dayoftheweek = date("w", mktime (0,0,0,$month,1,$year));

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<div style="position:relative;width:<?php echo $width; ?>">
    <div class="cal_title">
        <a href="<?php echo $_SERVER['PHP_SELF']."?bo_table=".$bo_table."&"; ?><?php if ($month == 1) { $year_pre=$year-1; $month_pre=$month; } else {$year_pre=$year-1; $month_pre=$month;} echo ("year=$year_pre&month=$month_pre");?>" title="<?php echo $year_pre ?>년" class="cal_arrow"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>
        <a href="<?php echo $_SERVER['PHP_SELF']."?bo_table=".$bo_table."&"; ?><?php if ($month == 1) { $year_pre=$year-1; $month_pre=12; } else {$year_pre=$year; $month_pre=$month-1;} echo ("year=$year_pre&month=$month_pre");?>" title="<?php echo $month_pre ?>월" class="cal_arrow"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
        <a href="<?php echo $_SERVER['PHP_SELF']."?bo_table=".$bo_table; ?>" title="오늘로" class="cal_today"><?php echo $year ?>년 <?php echo $month ?>월</a>
        <a href="<?php echo $_SERVER['PHP_SELF']."?bo_table=".$bo_table."&"; ?><?php if ($month == 12) { $year_pre=$year+1; $month_pre=1; } else {$year_pre=$year; $month_pre=$month+1;} echo ("year=$year_pre&month=$month_pre");?>" title="<?php echo $month_pre ?>월" class="cal_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
        <a href="<?php echo $_SERVER['PHP_SELF']."?bo_table=".$bo_table."&"; ?><?php if ($month == 12) { $year_pre=$year+1; $month_pre=$month; } else {$year_pre=$year+1; $month_pre=$month;} echo ("year=$year_pre&month=$month_pre");?>" title="<?php echo $year_pre ?>년" class="cal_arrow"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
    </div>
    <div style="position:absolute;top:0;right:0">
        <?php if ($write_href) { ?>
        <ul class="btn_bo_user">
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02 btn"><i class="fa fa-pencil" aria-hidden="true"></i> 일정추가</a></li><?php } ?>
        </ul>
        <?php } ?>
    </div>
</div>

<div class="cal_tbl" style="width:<?php echo $width;?>">
    <table>
    <thead>
    <tr>
        <th style="color:red">일</th>
        <th>월</th>
        <th>화</th>
        <th>수</th>
        <th>목</th>
        <th>금</th>
        <th style="color:blue">토</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $cday = 1;
    $sel_mon = sprintf("%02d",$month);
    $query = "SELECT * FROM $write_table WHERE left(wr_1,6) <= '$year$sel_mon' and left(wr_2,6) >= '$year$sel_mon' ORDER BY wr_id ASC";
    $result = sql_query($query);
    $j=0; // layer id
    // 내용을 보여주는 부분
    while ($row = sql_fetch_array($result)) { // 제목글 뽑아서 링크 문자열 만들기..

        if(substr($row['wr_1'],0,6) < $year.$sel_mon) {
            $start_day = 1;
            $start_day = (int)$start_day;
        } else {
            $start_day = substr($row['wr_1'],6,2);
            $start_day = (int)$start_day;
        }

        if(substr($row['wr_2'],0,6) > $year.$sel_mon) {
            $end_day = $lastday[$month];
            $end_day = (int)$end_day;
        } else {
            $end_day = substr($row['wr_2'],6,2);
            $end_day = (int)$end_day;
        }

        for ($i = $start_day; $i <= $end_day; $i++) {

            $j++; // layer ID

            $row['wr_subject'] = cut_str(get_text($row['wr_subject']),$board['bo_subject_len'],"…");
            $showLayer = "";
            if ($member['mb_level'] < $board['bo_read_level']) {
                $html_day[$i].= "<div class='list_day'><i class='fa fa-map-marker'></i>".$row['wr_subject']."</div>";
            } else {
                if(!is_mobile()){ $showLayer = "onmouseover=\"PopupShow('".$j."')\" onmouseout=\"PopupHide('".$j."')\""; }
                $html_day[$i].= "<div class='list_day'><i class='fa fa-map-marker'></i><a href='".G5_BBS_URL."/board.php?bo_table=$bo_table&year=$year&month=$month&wr_id=$row[wr_id]' id='subject_".$j."' ".$showLayer.">".$row['wr_subject']."</a></div>";
            }
    ?>
    <!-- 뷰 팝업레이어 -->
    <div id="popup_<?php echo $j ?>" class="popup_layer">
        <?php
        $viewlist = conv_content($row['wr_content'], 0);
        echo $viewlist;
        ?>
    </div>
    <?php
        }
    }

    // 달력의 틀을 보여주는 부분

    $temp = 7 - (($lastday[$month]+$dayoftheweek)%7);

    if ($temp == 7) $temp = 0;
    $lastcount = $lastday[$month] + $dayoftheweek + $temp;

    for ($iz = 1; $iz <= $lastcount; $iz++) { // 42번을 칠하게 된다.
        $bgcolor = "#ffffff"; // 쭉 흰색으로 칠하고
        if ($b_year == $year && $b_mon == $month && $b_day == $cday) $bgcolor = "#DEFADE"; // 오늘날짜 연두색으로 표기
        if (($iz%7) == 1) echo ("<tr>"); // 주당 7개씩 한쎌씩을 쌓는다.
        if ($dayoftheweek < $iz  &&  $iz <= $lastday[$month]+$dayoftheweek)	{
            // 전체 루프안에서 숫자가 들어가는 셀들만 해당됨
            // 즉 11월 달에서 1일부터 30 일까지만 해당
            $daytext = "$cday";   // $cday 는 숫자 예> 11월달은 1~ 30일 까지
            //$daytext 은 셀에 써질 날짜 숫자 넣을 공간
            $daycontcolor = "";
            $daycolor = "";
            if ($iz%7 == 1) $daycolor = "red"; // 일요일
            if ($iz%7 == 0) $daycolor = "blue"; // 토요일

            // 여기까지 숫자와 들어갈 내용에 대한 변수들의 세팅이 끝나고
            // 이제 여기 부터 직접 셀이 그려지면서 그 안에 내용이 들어 간다.
            echo ("<td width='14%' bgcolor='$bgcolor' valign='top'>");

            $f_date = $year.sprintf("%02d",$month).sprintf("%02d",$cday);

            // 기념일 파일 내용 비교위한 변수 선언, 월과 일을 두자리 포맷으로 고정
            if (strlen($month) == 1) {
                $monthp = "0".$month;
            } else {
                $monthp = $month;
            }
            if (strlen($cday) == 1) {
                $cdayp = "0".$cday;
            } else {
                $cdayp = $cday;
            }
            $memday = $year.$monthp.$cdayp;
            $daycont = "";

            // 기념일(양력) 표시
            for($i=0 ; $i < sizeof($dayfile) ; $i++) {  // 파일 첫 행부터 끝행까지 루프
                $arrDay = explode("|", $dayfile[$i]);
                if($memday == $year.$arrDay[0]) {
                    $daycont = $arrDay[1];
                    $daycontcolor = $arrDay[2];
                    if(substr($arrDay[2],0,3) == "red") $daycolor = "red"; // 공휴일은 날짜를 빨간색으로 표시
                }
            }

            // 석봉운님의 음력날짜 변수선언
            $myarray = soltolun($year,$month,$cday);
            if ($myarray['day']==1 || $myarray['day']==11 || $myarray['day']==21) {
                $moonday = "<span class='moonday'> (음)$myarray[month].$myarray[day]$myarray[leap]</spna>";
            } else {
                $moonday = "";
            }

//            include($file_index."/lunar.txt"); ### 음력 기념일 파일 지정

            if ($annivmoonday && $daycont) $blank="<br />"; // 음력절기와 양력기념일이 동시에 있으면 한칸 띔
            else $blank = "";

            if ($write_href) {
                // $write_href (글쓰기 권한)이 있으면
                // 날짜를 클릭하면 글씨쓰기가 가능한 링크를 넣어서 출력하기
                echo "<span class='annivmoonday'><a href='$write_href&f_date=$f_date'><font color='$daycolor' title='일정추가'>$daytext</font></a>$moonday <font color='$daycontcolor'>$daycont</font>$blank $annivmoonday</span>";
            } else { // 글쓰기 권한이 없으면 글쓰기 링크는 넣지 않고 그냥 숫자와 기념일 내용만 출력하기
                echo "<span class='annivmoonday'><font color='$daycolor'>$daytext</font>$moonday <font color='$daycontcolor'>$daycont</font>$blank $annivmoonday</span>";
            }
            echo $html_day[$cday];
            echo ("</td>");  // 한칸을 마무리
            $cday++; // 날짜를 카운팅
        } else { // 유효날짜가 아니면 그냥 회색을 칠한다.
            echo ("<td width='14%' bgcolor='#f9fafe' valign='top'>&nbsp;</td>");
        }
        if (($iz%7) == 0) echo ("</tr>");
    } // 반복구문이 끝남
    ?>
    </tbody>
    </table>
</div>
<?php
if ($member['mb_level'] >= $board['bo_read_level']) {
$today_w = date('Ymd', G5_SERVER_TIME); // 오늘일정
$nextday_w = date('Ymd', strtotime($today_w . ' +1 day')); // 내일일정
?>
<div class="day_list" style="width:<?php echo $width;?>">
    <table>
    <tr>
        <th>오늘 일정<br><?php echo date('m월 d일', strtotime($today_w)); ?></th>
        <td>
        <?php
        $sql = " select * from $write_table where wr_1 <= $today_w and wr_2 >= $today_w order by wr_num desc ";
        $result = sql_query($sql);
        for ($i=0; $row = sql_fetch_array($result); $i++) {
        ?>
        <div>
            <h3 class="day_subject"><?php echo get_text($row['wr_subject']); ?></h3>
            <p class="day_content"><?php echo conv_content($row['wr_content'], 0) ?></p>
        </div>
        <?php } ?>
        <?php if ($i == 0) { ?><p class="empty_day">오늘 일정이 없습니다.</p><?php } ?>
        </td>
    </tr>
    <tr>
        <th>내일 일정<br><?php echo date('m월 d일', strtotime($nextday_w)); ?></th>
        <td>
        <?php
        $sql = " select * from $write_table where wr_1 <= $nextday_w and wr_2 >= $nextday_w order by wr_num desc ";
        $result = sql_query($sql);
        for ($i=0; $row = sql_fetch_array($result); $i++) {
        ?>
        <div>
            <h3 class="day_subject"><?php echo get_text($row['wr_subject']); ?></h3>
            <p class="day_content"><?php echo conv_content($row['wr_content'], 0) ?></p>
        </div>
        <?php } ?>
        <?php if ($i == 0) { ?><p class="empty_day">내일 일정이 없습니다.</p><?php } ?>
        </td>
    </tr>
    </table>
</div>
<?php } ?>

<script>
// 미리보기 팝업 보이기
function PopupShow(n) {
	var position = $("#subject_"+n).position();
	$("#popup_"+n).animate({left:position.left-10+"px", top:position.top+20+"px"},0);
	$("#popup_"+n).show();
}

// 미리보기 팝업 숨기기
function PopupHide(n) {
	$("#popup_"+n).hide();
}
</script>
