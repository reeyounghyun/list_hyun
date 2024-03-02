<?php
function rand_number(): int
{
    $result = rand(0, 1000);
    return $result;
}

//방문자 카운트
function getVisitCount()
{
    global $g5;
    $sql = sql_query("select vs_count as total from {$g5['visit_sum_table']} where vs_date = date_format(now(),  '%Y-%m-%d')");
    $row = sql_fetch_array($sql);
    return $row['total'];
}

//일일 회원 가입 수
function getJoinedCount()
{
    global $g5;
    $sql = sql_query("select count(mb_datetime) as total from {$g5['member_table']} where date_format(mb_datetime, '%Y-%m-%d') = date_format(now(),  '%Y-%m-%d')");
    $row = sql_fetch_array($sql);
    return $row['total'];
}
//최근 7일이내 회원 가입 수
function getWeekJoinedCount()
{
    global $g5;
    $sql = sql_query("select count(mb_datetime) as total from {$g5['member_table']} where date_format(mb_datetime, '%Y-%m-%d') > date_format(now()-INTERVAL 7 DAY,  '%Y-%m-%d')");
    $row = sql_fetch_array($sql);
    return $row['total'];
}

/**
 * 유튜브 정보 가져와서 id갑 추출
 * @author 서영윤
 * @param string $data DB 열
 * @return mixed|string
 */
/**
 * @param string $data
 * @return mixed|string
 */
function getYoutubeId(string $data)
{
    $return_id = '';
    $get_addr = explode('/', $data);
    if ($get_addr[2] === 'www.youtube.com') {
        $check_id = explode('v=', $get_addr[3]);
        $get_id = explode('&', $check_id[1]);
        $return_id = $get_id[0];
    } else if ($get_addr[2] === 'youtu.be') {
        $return_id = $get_addr[3];
    }
    return $return_id;

}
//XSS CHECK
// TODO textarea && editor 사용시 무조건 같이 쓸것. 예 write_update "if (isset($_POST['wr_content'])) {" <- 검색어
/**
 * XSS검사
 * @author 서영윤
 * @param string $data DB 열
 * @param $data
 * @return array|string|string[]|null
 */
function xssClean($data)
{
// Fix &entity\n;
    $data = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $data);
    $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
    $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
    $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

// Remove any attribute starting with "on" or xmlns
    $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

// Remove javascript: and vbscript: protocols
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

// Remove namespaced elements (we do not need them)
    $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

    do {
        // Remove really unwanted tags
        $old_data = $data;
        $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
    } while ($old_data !== $data);

// we are done...
    return $data;
}

/**
 * 기능 1) 테마를 사용한다면 실행되는 코드 추가
 * ex) css, 그누보드 상수
 *
 * @author 석동근
 * @param string $thema 적용할 테마
 * @param bool $status 사용 여부 상태
 * @return string style.css
 */
function isThema(string $thema,bool $status = false){
    if(!$status){
      return '사용 여부를 확인해주세요';
    }
    if(!$thema){
      return '테마를 찾을 수 없습니다';
    }
    // 원하는 파일 include
    // echo "<link rel='stylesheet' href='".G5_THEME_URL."/css/".$thema.".css?version=1'>";

    define('G5_ASSETS_DIR',     'pub/assets');
    define('G5_ACCESS_URL',     G5_THEME_URL.'/'.G5_ASSETS_DIR);

    if(defined('_INDEX_')) {
//      echo "<link rel='stylesheet' href='".G5_THEME_URL."/pub/assets/css/style.css?version=1'>";
//      echo "<link rel='stylesheet' href='".G5_THEME_URL."/pub/assets/css/style.css?version=1'>";
    }
    $rand = rand_number();
    echo "<link rel='stylesheet' href='".G5_THEME_URL."/pub/assets/css/style.css?version=".$rand."'>";
//    return "<link rel='stylesheet' href='".G5_THEME_URL."/pub/assets/css/sub.css?version=1'>";
  }

// 신고 글 등록
function reportPost($postId, $memberId, $reason)
{
    $report_post = "UPDATE g5_write_community SET wr_1 = '{$memberId}', wr_2 = '{$reason}', wr_3 = '1' WHERE wr_id = '{$postId}'";
    sql_query($report_post);
}
// 신고 글 제거
function reReportPost($postId)
{
    $report_post = "UPDATE g5_write_community SET wr_3 = '' WHERE wr_id = '{$postId}'";
    sql_query($report_post);
}


//프로그램 가져오기
/**
 * 게시판 리스트 가져오기
 * @author 서영윤
 * @param string $board 게시판 이름
 * @param string $order 정렬 열
 * @return array
 */
function getOrderedList(string $board, string $order): array
{
    global $g5;
    $table = $g5['write_prefix'] . $board;
    $sql = sql_query("SELECT * FROM $table ORDER BY $order DESC LIMIT 0, 4");
    $result = array();
    for ($i=0; $row = sql_fetch_array($sql); $i++) {
        $result[] = $row;
        $result[$i]['wr_1'] = substr($row['wr_1'], 2, 8);
        $result[$i]['wr_2'] = substr($row['wr_2'], 2, 8);
        $result[$i]['wr_datetime'] = substr($row['wr_datetime'], 0, 10);
    }
    return $result;
}

/**
 * 일반게시판, 아이디어 게시판 중 최신 5개글 추출
 * @author 서영윤
 * @return array
 */
function getCommunityList()
{
    global $g5;
    $general = $g5['write_prefix'] . 'general';
    $idea = $g5['write_prefix'] . 'idea';
    $sql = sql_query("SELECT wr_id, wr_subject, wr_datetime FROM $general order by wr_datetime desc limit 0, 5");
    $result = array();
    for ($i=0; $row = sql_fetch_array($sql); $i++) {
        $array[] = $row;
        $array[$i]['wr_datetime'] = $row['wr_datetime'];
//        $array[$i]['wr_datetime'] = substr($row['wr_datetime'], 0,10);
        $array[$i]['board'] = 'general';
    }
    $sql = sql_query("SELECT wr_id, wr_subject, wr_datetime FROM $idea order by wr_datetime desc limit 0, 5");
    count($array) > 0 ? $count = count($array) : $count = 0;
    for ($i=$count; $row = sql_fetch_array($sql); $i++) {
        $array[] = $row;
//        $array[$i]['wr_datetime'] = substr($row['wr_datetime'], 0,10);
        $array[$i]['wr_datetime'] = $row['wr_datetime'];
        $array[$i]['board'] = 'idea';
    }
    foreach ((array) $array as $key => $value) {
        $sort[$key] = $value['wr_datetime'];
    }
    @array_multisort($sort, SORT_DESC, $array);
    $i_max = count($array);
    if($i_max > 5){
        for ($i=0; $i< 5; $i++){
            $result[$i] = $array[$i];
        }
    } else {
        $result = $array;
    }
    return $result;
}

/**
 * 기간, 상시 등 상태값과 해당 상태값에 맞는 class 입력
 * @author 서영윤
 * @param string $wr_11
 * @param string $wr_1
 * @param string $wr_2
 * @return array
 */
function printDate(string $wr_11, string $wr_1, string $wr_2): array{
    $result = array();
    if($wr_11 === '기간'){
        if($wr_1 === $wr_2 ){
            $result['date'] = $wr_1;
        } else {
            $result['date'] = $wr_1 . '&nbsp;-&nbsp;'. $wr_2;
        }
        if(date('Y-m-d', strtotime($wr_2)) >= G5_TIME_YMD){
            $result['class'] = '';
        } else if(date('Y-m-d', strtotime($wr_2)) < G5_TIME_YMD){
            $result['class'] = 'passed';
        }
    } else if($wr_11 === '상시'){
        $result['date'] = '상시';
        $result['class'] = 'always';

    }
    return $result;
}

/**
 * 카테고리 가져오기
 * @param string $bo_table
 * @param $column
 * @return array
 * @author 서영윤
 */
function getCategoryList(string $bo_table, $column): array
{
    global $g5;
    $table = $g5['board_table'];
    $category = '';
    $sql = sql_query("SELECT $column FROM $table where bo_table = '{$bo_table}'");
    $category = sql_fetch_array($sql);
    return explode('|', trim($category[$column]));
}

function getRecommendList(string $bo_table): array
{
    global $g5;
    $table = $g5['write_prefix'] . $bo_table;
    $result = array();
    $sql = sql_query("SELECT * FROM $table where wr_14 = '1' ORDER BY wr_datetime DESC LIMIT 0, 4");
    for ($i=0; $row = sql_fetch_array($sql); $i++) {
        $result[] = $row;
        $result[$i]['wr_1'] = substr($row['wr_1'], 2, 8);
        $result[$i]['wr_2'] = substr($row['wr_2'], 2, 8);
        $result[$i]['wr_datetime'] = substr($row['wr_datetime'], 0, 10);
    }
    return $result;
}

/**
 * 썸네일을 위한 meta태그 정보 가져오기
 * @author 서영윤
 * @param $url
 * @return array
 */
function fetchOg($url): array
{
    $title = '';
    $og = array();
    if($url){
        $data = file_get_contents($url);
        $data = mb_convert_encoding($data, 'HTML-ENTITIES', "UTF-8");
        $dom = new DomDocument;
        @$dom->loadHTML($data);

        $xpath = new DOMXPath($dom);
        # query metatags dengan prefix og
        $metas = $xpath->query('//*/meta[starts-with(@property, \'og:\')]');

        $og = array();

        foreach($metas as $meta){
            $property = str_replace('og:', '', $meta->getAttribute('property'));
            $content = $meta->getAttribute('content');
            $og[$property] = $content;
        }

        if(!$og || !$og['title']){
            $data = file_get_contents($url);
            $og['title'] = preg_match('/<title[^>]*>(.*?)<\/title>/ims', $data, $matches) ? $matches[1] : null;
            $og['url'] = $url;
        }
    }
    return $og;
}


/**
 * file, boTable 두 테이블을 join한다
 * @author 석동근
 * @param string $category 카테고리
 * @param string $boTable 추출할 게시판
 * @return array 해당 게시판의 카테고리에 부합하는 이미지와 세부 데이터
 */
function getBannerOrAd(string $category = '광고', string $boTable = 'g5_write_banner_ad_management'): array{
    global $g5;
    $result = [];
    $sql = sql_query("SELECT origin.bf_source, origin.bf_file, origin.bo_table, jtable.ca_name, jtable.wr_subject, jtable.wr_link1, jtable.wr_subject FROM g5_board_file as origin LEFT JOIN $boTable AS jtable ON origin.wr_id = jtable.wr_id WHERE jtable.ca_name = '$category'");
    while($row = sql_fetch_array($sql)){
        $temp = [
            'src' => G5_DATA_URL.'/file/'.$row['bo_table'].'/'.$row['bf_file'],
            'alt' => $row['wr_subject'],
            'fileName' => $row['bf_file'],
            'caName' => $row['ca_name'],
            'gotoUrl' => $row['wr_link1'],
            'subject' => $row['wr_subject'],
        ];
        array_push($result,$temp);
    }
    return $result;
}

/**
 * 상태값을 컨트롤 하는 게시판 어디든 사용 가능하다
 * ex) 추천
 * @author 석동근
 * @param number $wrId 카테고리
 * @param string $boTable 추출할 게시판
 * @return bool
 */
function changeState($wrId, $boTable, $wr): bool{
    $sql = sql_query("SELECT $wr FROM $boTable WHERE wr_id = $wrId");
    $row = sql_fetch_array($sql);
    $existsByState = $row[$wr];
    if(!$existsByState){
        $chageSql = sql_query("UPDATE $boTable SET $wr = 1 WHERE wr_id = $wrId");
        sql_query($chageSql);
        return true;
    }
    if($existsByState){
        $reChageSql = sql_query("UPDATE $boTable SET $wr = '' WHERE wr_id = $wrId");
        sql_query($reChageSql);
        return true;
    }
}

/**
 * 회원 등급 숫자를 그에 해당하는 종류 텍스로 반환
 * @author 석동근
 * @param number @num mb_1 => 회원 등급
 * @return string
 */
function findGradeByNumber($num): string{
    switch($num){
        case 0 :
            return '일반';
        case 1 :
            return '장애인';
        case 2 :
            return '보호자';
        case 3 :
            return '기업';
        case 4 :
            return '기관';
        default :
            return '그외';
    }
}

/**
 * 구별 문자로 나뉜 텍스트 배열로 나누기
 * @author 서영윤
 * @param string $data
 * @param string $separator
 * @return array
 */
function getExplode(string $data, string $separator): array
{
    return explode($separator, trim($data));
}

/**
 * 행정구역이 들어 있는 json 불러오기
 * @author 서영윤
 * @return object
 */
function allCityList(): object
{
    $json = file_get_contents(G5_THEME_URL.'/pub/component/region.json');
    return json_decode($json);
}

/**
 * json 데이터 배열 처리 하여 값 넘기기
 * @author 서영윤
 * @return array
 */
function getAllList(): array
{
    $json_data = allCityList();
    $result = array();

    foreach( $json_data as $key => $iValue){
        $result[$key] = $iValue;
    }
    return $result;
}
function getCityList(): array
{
    $result = array();
    $list = array_keys((array)allCityList());
    foreach ($list as $key){
        $result[] = $key;
    }
    return $result;
}
/**
 * 추천되어있는 게시판을 가져오는 함수
 * @author 석동근
 * @param string $boTable g5_write_program 글쓰기 게시판 형식으로 넘겨줘야됩니다
 * @param string $order 정렬
 * @param number $limit 추출 제한 수
 * @return array
 */
function getBoardGood($boTable,$order='DESC',$limit=4){
    global $g5;
    $result = [];
    $board = explode('_',$boTable);
    $sql = sql_query("SELECT wr_id, wr_subject,wr_1,wr_2,wr_11 FROM $boTable WHERE wr_good != 0 ORDER BY wr_id $order LIMIT $limit");
    while($row = sql_fetch_array($sql)){
        $temp = [
            'subject' => $row['wr_subject'],
            'startDate' => $row['wr_1'],
            'lastDate' => $row['wr_2'],
            'type' => $row['wr_11'],
            'gotoUrl' => G5_BBS_URL.'/board.php?bo_table='.$board[2].'&wr_id='.$row['wr_id'],
        ];
        array_push($result,$temp);
    }
    return $result;
}

/**
 * 신고글에 대한 메세지 출력
 * @author 석동근
 * @param string $who 누가
 * @param string $why 왜
 * @param number @report 신고글인가(1이면 신고글)
 */
function getReportMessage($who, $why, $report){
    if($report == 1){
        return $who.'유저가 '.$why.'으로 신고했습니다';
    }
    if($report === ''){
        return '신고된 글이 아닙니다';
    }
}
// 한페이지에 보여줄 행, 현재페이지, 총페이지수, URL
/**
 * 기본 그누보드 get_pading + class 추가
 * @author 서영윤
 * @param $write_pages
 * @param $cur_page
 * @param $total_page
 * @param $url
 * @param $class 페이지 별 class
 * @param $add
 * @return string
 */
function newGetPaging($write_pages, $cur_page, $total_page, $url, $class, $add="")
{
    //$url = preg_replace('#&amp;page=[0-9]*(&amp;page=)$#', '$1', $url);
    $url = preg_replace('#(&amp;)?page=[0-9]*#', '', $url);
    $url .= substr($url, -1) === '?' ? 'page=' : '&amp;page=';

    $str = '';
    if ($cur_page > 1) {
        $str .= '<li class="button first"><a href="'.$url.'1'.$add.'">first</a></li>'.PHP_EOL;
    }

    $start_page = ( ( (int)( ($cur_page - 1 ) / $write_pages ) ) * $write_pages ) + 1;
    $end_page = $start_page + $write_pages - 1;

    if ($end_page >= $total_page) $end_page = $total_page;

    if ($start_page > 1) $str .= '<li class="button prev"><a href="'.$url.($start_page-1).$add.'">prev</a></li>'.PHP_EOL;

    if ($total_page > 1) {
        for ($k=$start_page;$k<=$end_page;$k++) {
            if ($cur_page !== $k) {
                $str .= '<li class="num"><a href="' . $url . $k . $add . '">' . $k . '</a></li>' . PHP_EOL;
            }
            else {
                $str .= '<li class="num is-current">'.$k.'</li>'.PHP_EOL;
            }
        }
    }

    if ($total_page > $end_page) $str .= '<li class="button next"><a href="'.$url.($end_page+1).$add.'">next</a></li>'.PHP_EOL;

    if ($cur_page < $total_page) {
        $str .= '<li class="button last"><a href="'.$url.$total_page.$add.'">last</a></li>'.PHP_EOL;
    }

    if ($str) {
        return "<div class=\"list_bottom\"> <ul class=\"pagination {$class}\">{$str}</ul></div>";
    }

    return "";
}

function checkBoard(string $bo_table) : string
{
    if($bo_table === 'general'){
        return '일반';
    }

    if($bo_table === 'idea'){
        return '아이디어';
    }
}

function checkMemberLevel(string $mb_1) : array
{
    $result = array();
    switch ($mb_1){
        case '1':
            $result['person'] = '장애인';
            $result['class'] = 'impaired';
            break;
        case '2':
            $result['person'] = '보호자';
            $result['class'] = 'protector';
            break;
        case '3':
            $result['person'] = '기업';
            $result['class'] = 'company';
            break;
        case '4':
            $result['person'] = '기관';
            $result['class'] = 'organization';
            break;
        default :
            $result['person'] = '일반';
            $result['class'] = 'common';
            break;
    }
    return $result;
}
// TODO Applications/XAMPP/xamppfiles/htdocs/piece-web/www/bbs/good.php 여기 함수 정리
function checkGiveHit($bo_table, $wr_id, $mb_id){
    global $g5;
    $result = '';
    $sql = " select bg_flag from {$g5['board_good_table']}
                    where bo_table = '{$bo_table}'
                    and wr_id = '{$wr_id}'
                    and mb_id = '{$mb_id}'
                    and bg_flag = 'good' ";
    $row = sql_fetch($sql);
    if ($row['bg_flag'])
    {
        if ($row['bg_flag'] == 'good')
            $status = '추천';
        $result = "heart";
    }
    return $result;
}
function getCategoryInItem($sca){
    $sql = "SELECT bo_1, bo_2, bo_3 from g5_board where bo_table = 'item'";
    $array = sql_fetch_array(sql_query($sql));
    $result = array();
    switch ($sca){
        case '제품':
            $result['category'] =  getExplode($array['bo_1'], '|');
            $result['bo'] = 'bo_1';
            break;
        case '서비스':
            $result['category'] =  getExplode($array['bo_2'], '|');
            $result['bo'] = 'bo_2';
            break;
        case '용역':
            $result['category'] =  getExplode($array['bo_3'], '|');
            $result['bo'] = 'bo_3';
            break;
    }
    return $result;
}

/**
 * 아이디 => 이메일 형식으로 회원가입 및 로그인으로 변경하기 위한 함수 / 추후 변경 예정
 * @param string $mb_id 회원아이디
 */
function getEmail($mb_id, $fields='*', $is_cache=false){
    global $g5;
    // $mb_id = preg_replace("/[^0-9a-z_]+/i", "", $mb_id);
    static $cache = array();
    $key = md5($fields);
    if( $is_cache && isset($cache[$mb_id]) && isset($cache[$mb_id][$key]) ){
        return $cache[$mb_id][$key];
    }
    $sql = " select $fields from {$g5['member_table']} where mb_id = TRIM('$mb_id') ";
    $cache[$mb_id][$key] = run_replace('get_member', sql_fetch($sql), $mb_id, $fields, $is_cache);
    return $cache[$mb_id][$key];
}

/**
 * 마이페이지 좋아요한 글
 */
function getPostGood($mb_id){
    $result = [];
    global $g5;
    $table_array = array(
        "general", "idea"
    );
    $count_table = count($table_array);
    for($i=0; $i<$count_table; $i++){
        $sql = sql_query("SELECT wr_id, wr_subject, wr_content, wr_datetime, wr_good FROM {$g5['write_prefix']}{$table_array[$i]} WHERE wr_id IN ( SELECT wr_id FROM g5_board_good WHERE mb_id = '$mb_id' AND bo_table = '{$table_array[$i]}')");
        while($row = sql_fetch_array($sql)){
            $temp = [
                'board' => $table_array[$i],
                'href' => trim(G5_URL."/bbs/board.php?bo_table=$table_array[$i]&wr_id=".$row['wr_id']),
                'subject' => $row['wr_subject'],
                'wr_content' => $row['wr_content'],
                'wr_datetime' => explode(' ',$row['wr_datetime'])[0],
                'wr_good' => $row['wr_good'],
            ];
            array_push($result,$temp);
        }
    }
    foreach ((array) $result as $key => $value) {
        $sort[$key] = $value['wr_datetime'];
    }
    @array_multisort($sort, SORT_DESC, $result);
    return $result;
}

/**
 * 내가 작성한 글
 */
function getPostWrite($mb_id){
    $result = [];
    $temp = [];
    global $g5;
    $table_array = array(
        "content", "general", "idea", "item", "program", "welfare"
    );
    $count_table = count($table_array);
    for($i=0; $i<$count_table; $i++){
        $sql = sql_query("SELECT * FROM {$g5['write_prefix']}{$table_array[$i]} WHERE mb_id = '$mb_id'");
        while($row = sql_fetch_array($sql)){
            $hashtag = '';
            switch($table_array[$i]){
                case "item":
                case  "content"
                    : $hashtag = $row['ca_name'];
                    break;
                case "idea":
                case  "general"
                    : $hashtag = $row['wr_good'];
                    break;
                case "welfare":
                case  "program"
                    : $hashtag = $row['wr_10'];
                    break;
                default : $hashtag = "";
            }
            $temp = [
                'board' => $table_array[$i],
                'href' => trim(G5_URL."/bbs/board.php?bo_table=$table_array[$i]&wr_id=".$row['wr_id']),
                'subject' => $row['wr_subject'],
                'wr_content' => $row['wr_content'],
                'wr_datetime' => explode(' ',$row['wr_datetime'])[0],
                'hashtag' => $hashtag
            ];
            array_push($result,$temp);
        }
    }
    foreach ((array) $result as $key => $value) {
        $sort[$key] = $value['wr_datetime'];
    }
    @array_multisort($sort, SORT_DESC, $result);
    return $result;
}

function getMemberUploadImg($mb_2){
    $result = G5_DATA_URL.'/member/'.$mb_2;
    return $result;
}
function getStringList($data) :string
{
    $result = '';
    $data = getExplode($data, '|');
    $count = count($data);
    foreach ($data as $i => $iValue) {
        if(($i+1) === $count){
            $result .= $iValue;
        } else {
            $result .= $iValue .',';
        }
    }
    return $result;
}
function memberFileDelete($mb_id): void{
    $deleteSql = "UPDATE g5_member SET mb_2 = '' WHERE mb_id = '{$mb_id}'";
    sql_query($deleteSql);
    alert('업로드한 이미지가 삭제되었습니다',G5_BBS_URL.'/register_form.php?w=u');
}
/**
 * 권한 별 글쓰기 버튼 상태 함수
 */
function isWriteUser($mb1, string $boTable, string $isMember)
{
    $result = [];
    $item = ['3','4'];
    $organization = ['4'];
    if($mb1 === '10'){
        array_push($result, G5_BBS_URL."/write.php?bo_table=$boTable");
        return $result;
    }
    if($boTable === 'item'){
        in_array($item,$mb1) ?
            array_push($result, G5_BBS_URL."/write.php?bo_table=$boTable")
            : array_push($result,'none');
        return $result;
    }
    if($boTable === 'program' || $boTable === 'welfare'){
        in_array($organization,$mb1) ?
            array_push($result, G5_BBS_URL."/write.php?bo_table=$boTable")
            : array_push($result,'none');
        return $result;
    }
    if($isMember){
        array_push($result, G5_BBS_URL."/write.php?bo_table=$boTable");
        return $result;
    } else {
        array_push($result, G5_BBS_URL."/login.php");
        return $result;
    }
}
function checkHttps($link): string
{
    if (preg_match('/https?:\/\/([^\/]+)\//i', $link, $matches)) {
        $domain = $matches[1];
    } else{
        $domain = $link;
    }

    return $domain;
}

function getDateDiff($date){

    $diff = time() - strtotime($date);

    $s = 60; //1분 = 60초
    $t = $s * 10;
    $f = $s * 40;
    $h = $s * 60; //1시간 = 60분
    $d = $h * 24; //1일 = 24시간
    $y = $d * 30; //1달 = 30일 기준
    $a = $y * 12; //1년

    if ($s > $diff) {
        $result = '방금';
    } elseif ($f >= $diff ) {
        $result = round($diff/$s) . '분전';
    } elseif ($d > $diff) {
        $result = round($diff/$h) . '시간전';
    } else {
        $result = substr($date, 0,10);
    }
    return $result;
}

/**
 * @param $wrId
 * @param $fname
 * @return void
 */
function boardFileDelete($wrId, $fname): void{
    $deleteSql = "DELETE FROM g5_board_file WHERE wr_id = '$wrId' AND bf_source = '$fname'";
    sql_query($deleteSql);
    alert('업로드한 이미지가 삭제되었습니다');
}
