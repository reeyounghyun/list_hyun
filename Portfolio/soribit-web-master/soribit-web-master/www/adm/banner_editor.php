<?php
$sub_menu = "100250";
//TODO 만약 푸터를 에디터로 한다면 db_config cf_1을 text로 변경
include_once('./_common.php');
include_once(G5_EDITOR_LIB);
auth_check_menu($auth, $sub_menu, 'r');

$sql_common = " from {$g5['board_table']} a ";
$sql_search = " where (1) ";
if ($is_admin != "super") {
    $sql_common .= " , {$g5['group_table']} b ";
    $sql_search .= " and (a.gr_id = b.gr_id and b.gr_admin = '{$member['mb_id']}') ";
}

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "bo_table" :
            $sql_search .= " ($sfl like '$stx%') ";
            break;
        case "a.gr_id" :
            $sql_search .= " ($sfl = '$stx') ";
            break;
        default :
            $sql_search .= " ($sfl like '%$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst = "a.gr_id, a.bo_table";
    $sod = "asc";
}
$sql_order = " order by $sst $sod ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) {
    $page = 1;
} // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$listall = '<a href="' . $_SERVER['SCRIPT_NAME'] . '" class="ov_listall">전체목록</a>';

$g5['title'] = '배너관리';
//$cf_1 = $config['cf_1'];
$content = get_text($config['cf_1'], 0);
include_once('./admin.head.php');
?>
    <style>
        .smarteditor2, .btn_cke_sc {
            display: none;
        }
    </style>
    <!--        </div>-->
    <div>
        <form name="fmember" id="fmember" method="post" enctype="multipart/form-data" style="width: 1200px !important;"
              action="./banner_editor_update.php">
            <textarea style="display: none" name="cf_1" id="cf_1" cols="30" rows="10"><?php echo $config['cf_1']; ?></textarea>
            <script type="text/javascript" src="<?php echo G5_URL ?>/plugin/mlkk/js/service/HuskyEZCreator.js"
                    charset="utf-8"></script>
            <script type="text/javascript">
                var oEditors = [];

                var sLang = "ko_KR";	// 언어 (ko_KR/ en_US/ ja_JP/ zh_CN/ zh_TW), default = ko_KR

                // 추가 글꼴 목록
                //var aAdditionalFontSet = [["MS UI Gothic", "MS UI Gothic"], ["Comic Sans MS", "Comic Sans MS"],["TEST","TEST"]];

                nhn.husky.EZCreator.createInIFrame({
                    oAppRef: oEditors,
                    elPlaceHolder: "cf_1",
                    sSkinURI: "<?php echo G5_URL ?>/plugin/mlkk/SmartEditor2Skin.html",
                    htParams: {
                        bUseToolbar: true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
                        bUseVerticalResizer: true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
                        bUseModeChanger: true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
                        //bSkipXssFilter : true,		// client-side xss filter 무시 여부 (true:사용하지 않음 / 그외:사용)
                        //aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
                        fOnBeforeUnload: function () {
                            //alert("완료!");
                        },
                        I18N_LOCALE: sLang
                    }, //boolean
                    fOnAppLoad: function () {
                        //예제 코드
                        //oEditors.getById["ir1"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
                    },
                    fCreator: "createSEditor2"
                });


                function showHTML() {
                    var sHTML = oEditors.getById["cf_1"].getIR();
                    alert(sHTML);
                }

                function submitContents(elClickedObj) {
                    oEditors.getById["cf_1"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.

                    // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.

                    try {
                        elClickedObj.form.submit();
                    } catch (e) {
                    }
                }
            </script>
            <script>
                function x_ok() {
                    var wr_content_editor_data = oEditors.getById['cf_1'].getIR();
                    oEditors.getById['cf_1'].exec('UPDATE_CONTENTS_FIELD', []);
                    if (jQuery.inArray(document.getElementById('cf_1').value.toLowerCase().replace(/^\s*|\s*$/g, ''), ['&nbsp;', '<p>&nbsp;</p>', '<p><br></p>', '<div><br></div>', '<p></p>', '<br>', '']) != -1) {
                        document.getElementById('cf_1').value = '';
                    }
                    if (!wr_content_editor_data || jQuery.inArray(wr_content_editor_data.toLowerCase(), ['&nbsp;', '<p>&nbsp;</p>', '<p><br></p>', '<p></p>', '<br>']) != -1) {
                        alert("정보를 입력해주세요.");
                        oEditors.getById['cf_1'].exec('FOCUS');
                        return false;
                    }
                    fmember.submit();
                }
            </script>
            <button class='editor_submit' type="button" onClick="x_ok()">수정하기</button>
        </form>
    </div>
<?php
include_once('./admin.tail.php');
