<?php
/**************************
@Filename: forwardNum_update.php
@Version : 1.0
@Author  : Freemaster
@Date  : 2016/05/27
@Content : PHP by Editplus
**************************/
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');

$count = count($_POST['chk_wr_id']);
//$valChk = count($_POST['insert_num']);

if(!$count)
    alert($_POST['btn_submit'].' 하실 항목을 하나 이상 선택하세요.');
//print_r2($_POST);
if($is_admin && $_POST['btn_submit'] == '선택수정') {
    //값을 넣었는지 체크
    $valCnt = 0;
    for ($i=0; $i<$count; $i++) {
        $k = $_POST['chk_wr_id'][$i];
        if($_POST['chk_wr_id'][$i] && $_POST['insert_num'][$k]) {
            $valCnt++;
        }
    }

    if($valCnt != $count) {
        $msg = "선택된 번호에 빈 정렬값이 있습니다.";
    } else {
        // 글순서 변경하기
        // https://sir.kr/g4_tiptech/15990
        $write_table = $g5['write_prefix'].$_POST['bo_table'];

        for ($i=0; $i<$count; $i++) {
            // 실제 번호를 넘김
            $a = $_POST['chk_wr_id'][$i];
            $b = $_POST['insert_num'][$k];

            if($b > 0) {
                $b--;

                //입력한 게시물 번호의 정보
                $query = " SELECT wr_num FROM ".$write_table." WHERE wr_is_comment = 0 ORDER BY wr_num DESC LIMIT ".$b.", 1 ";
                $row = sql_fetch($query);
                $move_wr_num = $row['wr_num'];

                $query = " SELECT wr_num FROM ".$write_table." WHERE wr_id= '".$a."' ";
                $row = sql_fetch($query);
                $pre_wr_num = $row['wr_num'];

                if( $move_wr_num ) {
                    // 이동 대상될 게시글의 wr_num를 $ori_num 에 대입
                    $ori_wr_num = $move_wr_num;
                    // 지정번호 이후것들을 - 증가
                    $query = " UPDATE ".$write_table." SET wr_num = wr_num - 1 WHERE wr_num <= ".$move_wr_num." " ;
                    sql_query($query);
                } else {
                    $move_wr_num = get_next_num($write_table);
                }
                $ori_wr_num = $move_wr_num;

                if($move_wr_num > $pre_wr_num) $pre_wr_num--;
                $query = " UPDATE ".$write_table." SET wr_num = ".$move_wr_num." WHERE wr_num= '".$pre_wr_num."' ";
                sql_query($query);
                // 이동 대상 wr_num 교체
                $query = " UPDATE ".$write_table." SET wr_num = '".$ori_wr_num."' WHERE wr_id= ".$a." " ;
                sql_query($query);
            }
        }
        $msg = '해당 게시물을 선택한 순번 앞으로 이동하였습니다.';
    }
} else {
    $msg = '올바른 방법으로 이용해 주세요.';
}

$opener_href  = './board.php?bo_table='.$bo_table.'&amp;page='.$page.'&amp;'.$qstr;
$opener_href1 = str_replace('&amp;', '&', $opener_href);

echo <<<HEREDOC
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<script>
alert("$msg");
opener.document.location.href = "$opener_href1";
window.close();
</script>
<noscript>
<p>
    "$msg"
</p>
<a href="$opener_href">돌아가기</a>
</noscript>
HEREDOC;
?>
