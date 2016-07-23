<?php
//TIME얻기
function getNowTimes()
{
	$MicroTsmp = explode(' ',microtime());
	return $MicroTsmp[0]+$MicroTsmp[1];
}
function getMyPicture($my,$other="") {
	if($other) {
		$my = mysql_fetch_assoc(mysql_query("select job,photo from rb_s_mbrdata where memberuid='".$my."'"));
	}
	
	if($my['photo']) {
		return $my['photo'];
		
	} else {
		return '/images/mypicture.png';
	}
}
function getWeekName($date) {
	$yo = array("일요일","월요일","화요일","수요일","목요일","금요일","토요일");
	return $yo[date("w",strtotime($date))];
}
function getWeekNameShort($w) {
	$yo = array("일","월","화","수","목","금","토");
	return $yo[$w];
}
function getWeekMin($sel) {
	$data = array("H","M","T","W","TH","F","S");
	return $data[$sel];
}
function getJoinType($key=null) {
	$array = array(
			'CC' => '커플',
			'MW' => '혼성',
			'MM' => '남자',
			'WW' => '여자',
	);
	return (!empty($key))? $array[$key]:$array;
}
function getManLimit() {
	$array = array(
			'1' => '1명',
			'2' => '2명',
			'3' => '3명',
			'4' => '4명',
	);
	return $array;
}
function getHandy() {
	$array = array(
			'60' => '60',
			'70' => '70',
			'80' => '80',
			'90' => '90',
			'100' => '100',
			'110' => '110',
			'120' => '120',
	);
	return $array;
}
function ddate ($format,$timestamp) {
	$trans = array(
			'Monday'    => '월요일',
			'Tuesday'   => '화요일',
			'Wednesday' => '수요일',
			'Thursday'  => '목요일',
			'Friday'    => '금요일',
			'Saturday'  => '토요일',
			'Sunday'    => '일요일',
			'Mon'       => '월',
			'Tue'       => '화',
			'Wed'       => '수',
			'Thu'       => '목',
			'Fri'       => '금',
			'Sat'       => '토',
			'Sun'       => '일',
			'January'   => '1월',
			'February'  => '2월',
			'March'     => '3월',
			'April'     => '4월',
			'May'       => '5월',
			'June'      => '6월',
			'July'      => '7월',
			'October'   => '8월',
			'December'  => '9월',
			'Mar'       => '10월',
			'Oct'       => '11월',
			'Dec'       => '12월',
			'am'        => '오전',
			'pm'        => '오후',
			'AM'        => '오전',
			'PM'        => '오후',
			
	);
	return strtr(date($format,$timestamp),$trans);
}
function jobType($key) {
	$array = array('','검사','판사','변호사','자영업','IT');
	return $array[$key];
}
function yardType($key) {
	$array = array('S'=>'스크린','Y'=>'필드');
	return $array[$key];
}
function toAge($year) {
	$age = ((date('Y', time()) - $year) + 1);
	return $age;
}
function getOwner($my,$tuid="") {
	//if($my['admin'])return array('result'=>true);
	if($tuid) {
		$query= mysql_query("SELECT * FROM s_user_data  WHERE team='".$tuid."' AND mbruid='".$my[uid]."'") or die(mysql_error());
		$memberInfo = mysql_fetch_assoc($query);
		$paymentQuery = "SELECT * FROM s_payment_data WHERE tuid='".$tuid."' AND expiredate>=curdate() AND step=2 limit 1";
		$paymentRow = mysql_fetch_assoc(mysql_query($paymentQuery));
		if($paymentRow['uid']) {
			if($memberInfo['posiman']) {
				return array('result'=>true,'premium'=>true);
			} else return array('result'=>false);
	
		} else {
			if($memberInfo['posiman']=='pria' || $memberInfo['posiman']=='adm') { // 일반팀은 총무일때만 작업가능
				return array('result'=>true);
			} else return array('result'=>false);
		}
	} else {
		$AdminTeamList = array();
		$query= mysql_query("SELECT * FROM s_user_data  WHERE mbruid='".$my[uid]."'");
		while($memberInfo = mysql_fetch_assoc($query)) {
			
			if($memberInfo['posiman']!='') {
				$paymentQuery = "SELECT * FROM s_payment_data WHERE tuid='".$memberInfo['team']."' AND expiredate>=curdate() AND step=2 limit 1";
				$payRow = mysql_fetch_assoc(mysql_query($paymentQuery));
				$teamRow = mysql_fetch_assoc(mysql_query("select * from rb_team_list where uid='".$memberInfo['team']."'"));
				if($teamRow['hide']==1)continue;
				if($payRow['uid'] && ($memberInfo['posiman']=='pria' || $memberInfo['posiman']=='adm' || $memberInfo['posiman']=='suba')) {
					$AdminTeamList[$teamRow['uid']] = $teamRow['name'];
				} else {
					if($memberInfo['posiman']=='pria' || $memberInfo['posiman']=='adm') { // 일반팀은 총무일때만 작업가능
						$AdminTeamList[$teamRow['uid']] = $teamRow['name'];
					} 
				}
			}
		}
		if(count($AdminTeamList)>0) return array('result'=>true,'list'=>$AdminTeamList);
		else return array('result'=>false);
	}
}
//링크
function getLink($url,$target,$alert,$history)
{
	include_once $GLOBALS['g']['path_core'].'function/lib/getLink.lib.php';
}
//윈도우오픈
function getWindow($url,$alert,$option,$backurl,$target)
{
	include_once $GLOBALS['g']['path_core'].'function/lib/getWindow.lib.php';
}
//검색sql
function getSearchSql($w,$k,$ik,$h)
{
	include_once $GLOBALS['g']['path_core'].'function/lib/searchsql.lib.php';
	return LIB_getSearchSql($w,$k,$ik,$h);
}
//페이징
function getPageLink($lnum,$p,$tpage,$img)
{
	include_once $GLOBALS['g']['path_core'].'function/lib/page.lib.php';
	return LIB_getPageLink($lnum,$p,$tpage,$img);
}
//문자열끊기
function getStrCut($long_str,$cutting_len,$cutting_str)
{
	$rtn = array();$long_str = trim($long_str);
    return preg_match('/.{'.$cutting_len.'}/su', $long_str, $rtn) ? $rtn[0].$cutting_str : $long_str;
}
//링크필터링
function getLinkFilter($default,$arr)
{
	foreach($arr as $val) if ($GLOBALS[$val]) $default .= '&amp;'.$val.'='.urlencode($GLOBALS[$val]);
	return $default;
}
//총페이지수
function getTotalPage($num,$rec)
{
	return @intval(($num-1)/$rec)+1;
}
//날짜포맷
function getDateFormat($d,$f)
{
	return $d ? getDateCal($f,$d,0) : '';
}
//시간조정/포맷
function getDateCal($f,$d,$h)
{
	return date($f,mktime((int)substr($d,8,2)+$h,(int)substr($d,10,2),(int)substr($d,12,2),substr($d,4,2),substr($d,6,2),substr($d,0,4)));
}
//시간값
function getVDate($t)
{
	$date['PROC']	= $t ? getDateCal('YmdHisw',date('YmdHis'),$t) : date('YmdHisw');
	$date['totime'] = substr($date['PROC'],0,14);
	$date['year']	= substr($date['PROC'],0,4);
	$date['month']	= substr($date['PROC'],0,6);
	$date['today']  = substr($date['PROC'],0,8);
	$date['nhour']  = substr($date['PROC'],0,10);
	$date['tohour'] = substr($date['PROC'],8,6);
	$date['toweek'] = substr($date['PROC'],14,1);
	return $date;
}
//남은날짜
function getRemainDate($d)
{
	if(!$d) return 0;
	return ((substr($d,0,4)-date('Y')) * 365) + (date('z',mktime(0,0,0,substr($d,4,2),substr($d,6,2),substr($d,0,4)))-date('z'));
}
//지난시간
function getOverTime($d1,$d2)
{
	if (!$d2) return array(0);
	$d1 = date('U',mktime(substr($d1,8,2),substr($d1,10,2),substr($d1,12,2),substr($d1,4,2),substr($d1,6,2),substr($d1,0,4)));
	$d2 = date('U',mktime(substr($d2,8,2),substr($d2,10,2),substr($d2,12,2),substr($d2,4,2),substr($d2,6,2),substr($d2,0,4)));
	$tx = $d1-$d2;$ar = array(1,60,3600,86400,2592000,31104000);
	for ($i = 0; $i < 5; $i++) if ($tx < $ar[$i+1]) return array((int)($tx/$ar[$i]),$i);
	return array(substr($d1,0,4)-substr($d2,0,4),5);
}
//요일
function getWeekday($n)
{
	return $GLOBALS['lang']['sys']['week'][$n];
}
//시간비교
function getNew($time,$term)
{
	if(!$time) return false;
	$dtime = date('YmdHis',mktime(substr($time,8,2)+$term,substr($time,10,2),substr($time,12,2),substr($time,4,2),substr($time,6,2),substr($time,0,4)));
	if ($dtime > $GLOBALS['date']['totime']) return true;
	else return false;
}
//퍼센트
function getPercent($a,$b,$flag)
{
	return round($a / $b * 100 , $flag);
}
//지정문자열필터링
function filterstr($str)
{
	$str = str_replace(',','',$str);
	$str = str_replace('.','',$str);
	$str = str_replace('-','',$str);
	$str = str_replace(':','',$str);
	$str = str_replace(' ','',$str);
	return $str;
}
//문자열복사
function strCopy($str1,$str2)
{
	$badstrlen = getUTFtoUTF($str1) == $str1 ? strlen($str1) : intval(strlen($str1)/3);
	return str_pad('',($badstrlen?$badstrlen:1),$str2);
}
//아웃풋
function getContents($str,$html)
{
	include_once $GLOBALS['g']['path_core'].'function/lib/getContent.lib.php';
	return LIB_getContents($str,$html);
}
//쿠키배열
function getArrayCookie($ck,$split,$n)
{
	$arr = explode($split,$ck);
	return $arr[$n];
}
//대괄호배열
function getArrayString($str)
{
	$arr1 = array();
	$arr1['data'] = array();
	$arr2 = explode('[',$str);
	foreach($arr2 as $val)
	{
		if($val=='') continue;
		$arr1['data'][] = str_replace(']','',$val);
	}
	$arr1['count'] = count($arr1['data']);
	return $arr1;
}
//성별
function getSex($flag)
{
	return $GLOBALS['lang']['sys']['sex'][$flag-1];
}
//생일->나이
function getAge($birth)
{
	if (!$birth) return 0;
	return substr($GLOBALS['date']['today'],0,4) - substr($birth,0,4) + 1;
}
//나이->출생년도
function getAgeToYear($age)
{
	return substr($GLOBALS['date']['today'],0,4)-($age-1);
}
//사이즈포멧
function getSizeFormat($size,$flag)
{
	if ($size/(1024*1024*1024)>1) return round($size/(1024*1024*1024),$flag).'GB';
	if ($size/(1024*1024)>1) return round($size/(1024*1024),$flag).'MB';
	if ($size/1024>1) return round($size/1024,$flag).'KB';
	if ($size/1024<1) return $size.'B';
}
//파일타입
function getFileType($ext)
{
	if (strpos('_gif,jpg,jpeg,png,bmp,',strtolower($ext))) return 2;
	if (strpos('_swf,',strtolower($ext))) return 3;
	if (strpos('_mid,wav,mp3,',strtolower($ext))) return 4;
	if (strpos('_asf,asx,avi,mpg,mpeg,wmv,wma,mov,flv,',strtolower($ext))) return 5;
	if (strpos('_doc,xls,ppt,hwp',strtolower($ext))) return 6;
	if (strpos('_zip,tar,gz,tgz,alz,',strtolower($ext))) return 7;
	return 1;
}
//파일확장자
function getExt($name)
{
	$nx=explode('.',$name);
	return $nx[count($nx)-1];
}
//이미지추출
function getImgs($code,$type) 
{  
	$erg = '/src[ =]+[\'"]([^\'"]+\.(?:'.$type.'))[\'"]/i';  
	preg_match_all($erg, $code, $mtc, PREG_PATTERN_ORDER);
	return $mtc[1];
}
//이미지체크
function getThumbImg($img)
{
	$arr=array('.jpg','.gif','.png');
	foreach($arr as $val) if(is_file($img.$val)) return $GLOBALS['g']['s'].'/'.str_replace('./','',$img).$val;
}
function getUploadImage($upfiles,$d,$content,$ext)
{
	include_once $GLOBALS['g']['path_core'].'function/lib/getUploadImage.lib.php';
	return LIB_getUploadImage($upfiles,$d,$content,$ext);
}
//도메인
function getDomain($url)
{
	$urlexp = explode('/',$url);
	return $urlexp[2];
}
//키워드
function getKeyword($url)
{
	$urlexp = explode('?' , urldecode($url));
	if (!trim($urlexp[1])) return '';
	$queexp = explode('&' , $urlexp[1]);
	$quenum = count($queexp);
	for ($i = 0; $i < $quenum; $i++){$valexp = explode('=',trim($queexp[$i])); if (strstr(',query,q,p,',','.$valexp[0].',')&&!is_numeric($valexp[1])) return $valexp[1] == getUTFtoUTF($valexp[1]) ? $valexp[1] : getKRtoUTF($valexp[1]);}
	return '';
}
//검색엔진
function getSearchEngine($url)
{
	$set = array('naver','nate','daum','yahoo','google');
	foreach($set as $val) if (strpos($url,$val)) return $val;
	return 'etc';
}
//브라우져
function getBrowzer($agent)
{
	if(isMobileConnect($agent)) return 'Mobile';
	$set = array('MSIE 9','MSIE 8','MSIE 7','MSIE 6','Firefox','Opera','Chrome','Safari');
	foreach($set as $val) if (strpos('_'.$agent,$val)) return $val;
	return '';
}
//폴더네임얻기
function getFolderName($file)
{
	if(is_file($file.'/name.txt')) return implode('',file($file.'/name.txt'));
	return basename($file);
}
function getKRtoUTF($str)
{
	return iconv('euc-kr','utf-8',$str);
}
function getUTFtoKR($str)
{
	return iconv('utf-8','euc-kr',$str);
}
function getUTFtoUTF($str)
{
	return iconv('utf-8','utf-8',$str);
}
//관리자체크
function checkAdmin($n)
{
	if(!$GLOBALS['my']['admin']) getLink('','',$GLOBALS['lang']['sys']['need_admin'],$n?$n:'');
}
//모바일접속체크
function isMobileConnect($agent)
{
	if($_SESSION['pcmode']=='E') return 'RB-Emulator';
	$xagent = strtolower($agent);
	foreach($GLOBALS['d']['magent'] as $val)
	{
		$valexp = explode('=',trim($val));
		if(strpos($xagent,$valexp[0])) return $valexp[1];
	}
	return '';
}
//MOD_rewrite
function RW($rewrite)
{
	if ($GLOBALS['_HS']['rewrite'])
	{
		if(!$rewrite) return $GLOBALS['g']['r']?$GLOBALS['g']['r']:'/';
		$rewrite = str_replace('c=','c/',$rewrite);
		$rewrite = str_replace('mod=','p/',$rewrite);
		$rewrite = str_replace('m=admin','admin',$rewrite);
		$rewrite = str_replace('m=bbs','b',$rewrite);
		$rewrite = str_replace('&bid=','/',$rewrite);
		$rewrite = str_replace('&uid=','/',$rewrite);
		$rewrite = str_replace('&CMT=','/',$rewrite);
		$rewrite = str_replace('&s=','/s',$rewrite);
		return $GLOBALS['g']['r'].'/'.$rewrite;
	}
	else return $GLOBALS['_HS']['usescode']?('./?r='.$GLOBALS['_HS']['id'].($rewrite?'&amp;'.$rewrite:'')):'./'.($rewrite?'?'.$rewrite:'');;
}
//동기화URL
function getCyncUrl($cync)
{
	if (!$cync) return $GLOBALS['g']['r'];
	$_r = getArrayString($cync);
	$_r = $_r['data'][5];
	if ($GLOBALS['_HS']['rewrite']&&strpos('_'.$_r,'m:bbs,bid:'))
	{
		$_r = str_replace('m:bbs','b',$_r);
		$_r = str_replace(',bid:','/',$_r);
		$_r = str_replace(',uid:','/',$_r);
		$_r = str_replace(',CMT:','/',$_r);
		$_r = str_replace(',s:','/s',$_r);
		return $GLOBALS['g']['r'].'/'.$_r;
	}
	else return $GLOBALS['g']['s'].'/?'.($GLOBALS['_HS']['usescode']?'r='.$GLOBALS['_HS']['id'].'&amp;':'').str_replace(':','=',str_replace(',','&amp;',$_r));
}
//게시물링크
function getPostLink($arr)
{
	return RW('m=bbs&bid='.$arr['bbsid'].'&uid='.$arr['uid'].($GLOBALS['s']!=$arr['site']?'&s='.$arr['site']:''));
}
//위젯불러오기
function getWidget($widget,$wdgvar)
{
	global $DB_CONNECT,$table,$date,$my,$r,$s,$m,$g,$d,$c,$mod,$_HH,$_HD,$_HS,$_HM,$_HP,$_CA;
	static $wcsswjsc;
	if (!is_file($g['wdgcod']) && !strpos('_'.$wcsswjsc,'['.$widget.']'))
	{
		$wcss = $g['path_widget'].$widget.'/main.css';
		$wjsc = $g['path_widget'].$widget.'/main.js';
		if (is_file($wcss)) $g['widget_cssjs'] .= '<link type="text/css" rel="stylesheet" charset="utf-8" href="'.$g['s'].'/widgets/'.$widget.'/main.css" />'."\n";
		if (is_file($wjsc)) $g['widget_cssjs'] .= '<script type="text/javascript" charset="utf-8" src="'.$g['s'].'/widgets/'.$widget.'/main.js" /></script>'."\n";
		$wcsswjsc.='['.$widget.']';
	}
	$wdgvar['widget_id'] = $widget;
	include $g['path_widget'].$widget.'/main.php';
}
//문자열필터(@ 1.1.0)
function getStripTags($string)
{
	return str_replace('&nbsp;',' ',str_replace('&amp;nbsp;',' ',strip_tags($string)));
}
//스위치로드(@ 1.1.0)
function getSwitchInc($pos)
{
	$incs = array();
	foreach ($GLOBALS['d']['switch'][$pos] as $switch)
	{
		if(strpos($switch,'@')) continue;
		$incs[] = $GLOBALS['g']['path_switch'].$pos.'/'.$switch.'/main.php';
	} 
	return $incs;
}
function getSoccerPosition() {
	
	$positions['a'] = '공격수';
	$positions['b'] = '미드필더';
	$positions['c'] = '수비수';
	$positions['d'] = '골키퍼';
	$positions['e'] = '멀티플레이어';
	/*
	$positions['f'] = 'RWM';
	$positions['g'] = 'CDM';
	$positions['h'] = 'CAM';
	$positions['i'] = 'CB';
	$positions['j'] = 'LCB';
	$positions['k'] = 'RCB';
	$positions['l'] = 'LB';
	$positions['m'] = 'RB';
	$positions['n'] = 'GK';
	*/
	return $positions;
}
function getCareerList() {
	$careers[1] = '1년미만';
	$careers[2] = '1~5년';
	$careers[3] = '6~10년';
	$careers[4] = '11~15년';
	$careers[5] = '16~20년';
	$careers[6] = '21~25년';
	$careers[7] = '26~30년';
	$careers[8] = '30년이상';
	//$careers[9] = '36~40년';
	//$careers[10] = '41~45년';
	//$careers[11] = '46~50년';
	return $careers;
}
function getAgeList($cmd="") {
	
	//if($cmd == 'match') {
		$agesList['a'] = array('name'=>'성인',
							'list'=>array('2'=>'20대만',
										  '2a'=>'20대이상',
										  '3'=>'30대만',
										  '3a'=>'30대이상',		
										  '4'=>'40대만',
										  '4a'=>'40대이상',	
										  '5'=>'50대만',
										  '5a'=>'50대이상'));
	/*} else {
		$agesList['a'] = array('name'=>'성인',
							'list'=>array('2'=>'20대',
										  '3'=>'30대',
										  '4'=>'40대',
										  '5'=>'50대',
										  '6'=>'60대',
										  '7'=>'70대'));
	}
*/
	$agesList['b'] = array('name'=>'청소년',
							'list'=>array('a_3'=>'고등3학년','a_2'=>'고등2학년','a_1'=>'고등1학년',
										  'b_3'=>'증등3학년','b_2'=>'중등2학년','b_1'=>'중등1학년'));
	$agesList['c'] = array('name'=>'유소년',
							'list'=>array('c_6'=>'초등6학년','c_5'=>'초등5학년','c_4'=>'초등4학년','c_3'=>'초등3학년','c_2'=>'초등2학년','c_1'=>'초등1학년',
										  'd_7'=>'U-7세','d_6'=>'U-6세','d_5'=>'U-5세'));
	return $agesList;
}
function getFootList() {
	$foots = array('a'=>'왼발','b'=>'오른발','c'=>'양발');
	return $foots;
}
function getReverseArea($areaList) {
	$reverseAreaList = array();
	foreach($areaList as $key=>$val) {
		$reverseAreaList[$val['name']]['code'] = $key;
		foreach($val['list'] as $skey=>$sval) {
			$reverseAreaList[$val['name']]['list'][$sval] = $skey;
		}
	}
	return $reverseAreaList;
}
function getGender($sex) {
	$array = array("1" => "남자", "2"=> "여자");
	return $array[$sex];
}
/*
function getWeek() {
}
*/
function getTime() {
	$time['12:00:00'] = '오후 12:00';
	$time['12:30:00'] = '오후 12:30';
	$time['13:00:00']  = '오후 1:00';
	$time['13:30:00']  = '오후 1:30';
	$time['14:00:00']  = '오후 2:00';
	$time['14:30:00']  = '오후 2:30';
	$time['15:00:00']  = '오후 3:00';
	$time['15:30:00']  = '오후 3:30';
	$time['16:00:00']  = '오후 4:00';
	$time['16:30:00']  = '오후 4:30';
	$time['17:00:00']  = '오후 5:00';
	$time['17:30:00']  = '오후 5:30';
	$time['18:00:00']  = '오후 6:00';
	$time['18:30:00']  = '오후 6:30';
	$time['19:00:00']  = '오후 7:00';
	$time['19:30:00']  = '오후 7:30';
	$time['20:00:00']  = '오후 8:00';
	$time['20:30:00']  = '오후 8:30';
	$time['21:00:00']  = '오후 9:00';
	$time['21:30:00']  = '오후 9:30';
	$time['22:00:00'] = '오후 10:00';
	$time['22:30:00'] = '오후 10:30';
	$time['23:00:00'] = '오후 11:00';
	$time['23:30:00'] = '오후 11:30';
	return $time;
}
function getTimeTable($field_type='F') {
	if($field_type == 'S') {
		$time['24:00:00'] = '오전 00:00';
		$time['00:30:00'] = '오전 12:30';
		$time['01:00:00'] = '오전 1:00';
		$time['01:30:00'] = '오전 1:30';
		$time['02:00:00'] = '오전 2:00';
		$time['02:30:00'] = '오전 2:30';
		$time['03:00:00'] = '오전 3:00';
		$time['03:30:00'] = '오전 3:30';
		$time['04:00:00'] = '오전 4:00';
		$time['04:30:00'] = '오전 4:30';
		$time['05:00:00'] = '오전 5:00';
		$time['05:30:00'] = '오전 5:30';
		
	}
	$time['06:00:00'] = '오전 6:00';
	$time['06:30:00'] = '오전 6:30';
	$time['07:00:00'] = '오전 7:00';
	$time['07:30:00'] = '오전 7:30';
	$time['08:00:00'] = '오전 8:00';
	$time['08:30:00'] = '오전 8:30';
	$time['09:00:00'] = '오전 9:00';
	$time['09:30:00'] = '오전 9:30';
	$time['10:00:00'] = '오전 10:00';
	$time['10:30:00'] = '오전 10:30';
	$time['11:00:00'] = '오전 11:00';
	$time['11:30:00'] = '오전 11:30';	
	$time['12:00:00'] = '오후 12:00';
	$time['12:30:00'] = '오후 12:30';
	$time['13:00:00'] = '오후 1:00';
	$time['13:30:00'] = '오후 1:30';
	$time['14:00:00'] = '오후 2:00';
	$time['14:30:00'] = '오후 2:30';
	$time['15:00:00'] = '오후 3:00';
	$time['15:30:00'] = '오후 3:30';
	$time['16:00:00'] = '오후 4:00';
	$time['16:30:00'] = '오후 4:30';
	$time['17:00:00'] = '오후 5:00';
	$time['17:30:00'] = '오후 5:30';
	$time['18:00:00'] = '오후 6:00';
	
	if($field_type == 'S') {
		$time['18:30:00'] = '오후 6:30';
		$time['19:00:00'] = '오후 7:00';
		$time['19:30:00'] = '오후 7:30';
		$time['20:00:00'] = '오후 8:00';
		$time['20:30:00'] = '오후 8:30';
		$time['21:00:00'] = '오후 9:00';
		$time['21:30:00'] = '오후 9:30';
		$time['22:00:00'] = '오후 10:00';
		$time['22:30:00'] = '오후 10:30';
		$time['23:00:00'] = '오후 11:00';
		$time['23:30:00'] = '오후 11:30';
	}	
	
	return $time;
}
function getArea($sel=null) {
	$areaList['j']['name'] = '경기도';		  
	
		$areaList['j']['list']['a'] = '가평군';   		  
    	$areaList['j']['list']['b'] = '고양시';   		  
		$areaList['j']['list']['ac'] = '김포시';   		  
		$areaList['j']['list']['ad'] = '과천시';   		  
		$areaList['j']['list']['d'] = '광명시';   		  
    	$areaList['j']['list']['e'] = '광주시';   		  
    	$areaList['j']['list']['f'] = '구리시';   		  		  
		$areaList['j']['list']['g'] = '군포시';   		  		  
		$areaList['j']['list']['h'] = '남양주시';   		  	  
		$areaList['j']['list']['c'] = '동두천시';   		  	  
		//$areaList['j']['list']['i'] = '동두천시';   		  	  
		$areaList['j']['list']['j'] = '부천시';   		  
		$areaList['j']['list']['k'] = '성남시';   		  
		$areaList['j']['list']['l'] = '수원시';   		  
		$areaList['j']['list']['m'] = '시흥시';   		  
		$areaList['j']['list']['n'] = '안산시';   		  
		$areaList['j']['list']['ae'] = '안성시';   		  
		$areaList['j']['list']['af'] = '안양시';   		  
		$areaList['j']['list']['o'] = '양주시';   		  
		$areaList['j']['list']['p'] = '양평군';   		  
		$areaList['j']['list']['q'] = '여주시';   		  
		$areaList['j']['list']['r'] = '연천군';   		  
		$areaList['j']['list']['s'] = '오산시';   		  
		$areaList['j']['list']['t'] = '용인시';   		  
		$areaList['j']['list']['u'] = '의왕시';   		  
		$areaList['j']['list']['v'] = '의정부시';   		  	  
		$areaList['j']['list']['w'] = '이천시';   		  
		$areaList['j']['list']['x'] = '파주시';   																                          
		$areaList['j']['list']['y'] = '평택시';   							                                                              
    	$areaList['j']['list']['z'] = '포천시';   							                                                              
		$areaList['j']['list']['aa'] = '하남시';   							                                                              
		$areaList['j']['list']['ab'] = '화성시';   							                                                              
    
	
	$areaList['a']['name'] = '서울특별시';	
	$areaList['a']['list']['a'] = '강남구';								
	$areaList['a']['list']['b'] = '강동구';																
	$areaList['a']['list']['c'] = '강북구';																
	$areaList['a']['list']['d'] = '강서구';																
	$areaList['a']['list']['e'] = '관악구';																
	$areaList['a']['list']['f'] = '광진구';																
	$areaList['a']['list']['g'] = '구로구';																
	$areaList['a']['list']['h'] = '금천구';																
	$areaList['a']['list']['i'] = '노원구';																							
	$areaList['a']['list']['j'] = '도봉구';																							
	$areaList['a']['list']['k'] = '동대문구';																						
	$areaList['a']['list']['l'] = '동작구';																							
	$areaList['a']['list']['m'] = '마포구';																							
	$areaList['a']['list']['n'] = '서대문구';																						
	$areaList['a']['list']['o'] = '서초구';																
	$areaList['a']['list']['p'] = '성동구';																
	$areaList['a']['list']['q'] = '성북구';																
	$areaList['a']['list']['r'] = '송파구';																
	$areaList['a']['list']['s'] = '양천구';																							
	$areaList['a']['list']['t'] = '영등포구';																						
	$areaList['a']['list']['u'] = '용산구';																
	$areaList['a']['list']['v'] = '은평구';																
	$areaList['a']['list']['w'] = '종로구';																
	$areaList['a']['list']['x'] = '중구';															
	$areaList['a']['list']['y'] = '중랑구';																							
										
										
	$areaList['b']['name'] = '부산광역시';
	$areaList['b']['list']['a'] = '부산전체';
	
	$areaList['c']['name'] = '대구광역시';
	$areaList['c']['list']['a'] = '대구전체';
	$areaList['d']['name'] = '인천광역시';
	$areaList['d']['list']['a'] = '인천전체';
	$areaList['e']['name'] = '광주광역시';
	$areaList['e']['list']['a'] = '광주전체';
	$areaList['f']['name'] = '대전광역시';
	$areaList['f']['list']['a'] = '대전전체';
	$areaList['g']['name'] = '울산광역시';
	$areaList['g']['list']['a'] = '울산전체';
	$areaList['h']['name'] = '세종특별시';
	$areaList['h']['list']['a'] = '세종전체';
	$areaList['i']['name'] = '강원도';
	$areaList['i']['list']['a'] = '강릉시';
	$areaList['i']['list']['b'] = '고성군';
	$areaList['i']['list']['c'] = '동해시';
	$areaList['i']['list']['d'] = '삼척시';
	$areaList['i']['list']['e'] = '속초시';
	$areaList['i']['list']['f'] = '양구군';
	$areaList['i']['list']['g'] = '양양군';
	$areaList['i']['list']['h'] = '영월군';
	$areaList['i']['list']['i'] = '원주시';
	$areaList['i']['list']['j'] = '인제군';
	$areaList['i']['list']['k'] = '정선군';
	$areaList['i']['list']['l'] = '철원군';
	$areaList['i']['list']['m'] = '춘천시';
	$areaList['i']['list']['n'] = '태백시';
	$areaList['i']['list']['o'] = '평창군';
	$areaList['i']['list']['p'] = '홍천군';
	$areaList['i']['list']['q'] = '화천군';
	$areaList['i']['list']['r'] = '횡성군';
		
		
    	
	
	
	$areaList['k']['name'] = '경상남도';	
    $areaList['k']['list']['a'] = '거제시';		
	$areaList['k']['list']['b'] = '거창군';		
	$areaList['k']['list']['c'] = '고성군';		
    $areaList['k']['list']['d'] = '김해시';		
	$areaList['k']['list']['e'] = '남해군';		
	$areaList['k']['list']['f'] = '밀양시';		
    $areaList['k']['list']['g'] = '사천시';		
	$areaList['k']['list']['h'] = '산청군';		
	$areaList['k']['list']['i'] = '양산시';		
    $areaList['k']['list']['j'] = '의령군';		
    $areaList['k']['list']['k'] = '진주시';		
	$areaList['k']['list']['l'] = '창녕군';		
	$areaList['k']['list']['m'] = '창원시';		
	$areaList['k']['list']['n'] = '통영시';		
	$areaList['k']['list']['o'] = '하동군';		
	$areaList['k']['list']['p'] = '함안군';		
	$areaList['k']['list']['q'] = '함양군';		
	$areaList['k']['list']['r'] = '합천군';		
	
	$areaList['l']['name'] = '경상북도';	
	$areaList['l']['list']['a'] = '경산시';		
	$areaList['l']['list']['b'] = '경주시';		
	$areaList['l']['list']['c'] = '고령군';		
	$areaList['l']['list']['d'] = '구미시';		
    $areaList['l']['list']['e'] = '군위군';		
	$areaList['l']['list']['f'] = '김천시';		
	$areaList['l']['list']['g'] = '문경시';		
    $areaList['l']['list']['h'] = '봉화군';		
	$areaList['l']['list']['i'] = '상주시';		
	$areaList['l']['list']['j'] = '성주군';		
    $areaList['l']['list']['k'] = '안동시';		
	$areaList['l']['list']['l'] = '영덕군';		
	$areaList['l']['list']['m'] = '영양군';		
    $areaList['l']['list']['n'] = '영주시';		
	$areaList['l']['list']['o'] = '영천시';		
	$areaList['l']['list']['p'] = '예천군';		
    $areaList['l']['list']['q'] = '울릉군';		
	$areaList['l']['list']['w'] = '울진군';		
	$areaList['l']['list']['r'] = '의성군';		
	$areaList['l']['list']['s'] = '청도군';		
    $areaList['l']['list']['t'] = '청송군';		
    $areaList['l']['list']['u'] = '칠곡군';		
	$areaList['l']['list']['v'] = '포항시';		
	
	$areaList['m']['name'] = '전라남도';	                                                             
	$areaList['m']['list']['a'] = '강진군';		
	$areaList['m']['list']['b'] = '고흥군';		
	$areaList['m']['list']['c'] = '곡성군';		
    $areaList['m']['list']['d'] = '광양시';		
	$areaList['m']['list']['e'] = '구례군';		
	$areaList['m']['list']['f'] = '나주시';		
    $areaList['m']['list']['g'] = '담양군';		
	$areaList['m']['list']['h'] = '목포시';		
	$areaList['m']['list']['i'] = '무안군';		
    $areaList['m']['list']['j'] = '보성군';		
	$areaList['m']['list']['k'] = '순천시';		
	$areaList['m']['list']['l'] = '신안군';		
    $areaList['m']['list']['m'] = '여수시';		
	$areaList['m']['list']['n'] = '영광군';		
	$areaList['m']['list']['o'] = '영암군';		
    $areaList['m']['list']['p'] = '완도군';		
	$areaList['m']['list']['q'] = '장성군';		
	$areaList['m']['list']['r'] = '장흥군';											                
    $areaList['m']['list']['s'] = '진도군';											                
    $areaList['m']['list']['t'] = '함평군';											                
	$areaList['m']['list']['u'] = '해남군';											                
	$areaList['m']['list']['v'] = '화순군';											                
	
	
    
	
	
    $areaList['n']['name'] = '전라북도';	   
	$areaList['n']['list']['a'] = '고창군';		   
	$areaList['n']['list']['b'] = '군산시';		   
    $areaList['n']['list']['c'] = '김제시';		   
	$areaList['n']['list']['d'] = '남원시';		   
	$areaList['n']['list']['e'] = '무주군';		   
    $areaList['n']['list']['f'] = '부안군';		   
	$areaList['n']['list']['g'] = '순창군';		   
	$areaList['n']['list']['h'] = '완주군';		   
    $areaList['n']['list']['i'] = '익산시';		   
	$areaList['n']['list']['j'] = '임실군';		   
	$areaList['n']['list']['k'] = '장수군';		   
    $areaList['n']['list']['l'] = '전주시';		   
    $areaList['n']['list']['m'] = '정읍시';		   
	$areaList['n']['list']['n'] = '진안군';		   
	
	
	
	$areaList['p']['name'] = '충청남도';	
	$areaList['p']['list']['a'] = '계룡시';		
    $areaList['p']['list']['b'] = '공주시';		
	$areaList['p']['list']['c'] = '금산군';		
	$areaList['p']['list']['d'] = '논산시';		
    $areaList['p']['list']['e'] = '당진시';		
    $areaList['p']['list']['f'] = '보령시';		
	$areaList['p']['list']['g'] = '부여군';		
	$areaList['p']['list']['h'] = '서산시';		
	$areaList['p']['list']['i'] = '서천군';		
	$areaList['p']['list']['j'] = '아산시';		
	$areaList['p']['list']['k'] = '예산군';		
	$areaList['p']['list']['l'] = '천안시';		
	$areaList['p']['list']['m'] = '청양군';		
	$areaList['p']['list']['n'] = '태안군';		
	$areaList['p']['list']['o'] = '홍성군';		                         
	
	
	$areaList['q']['name'] = '충청북도';                 			   
	$areaList['q']['list']['a'] = '괴산군';                   			   
	$areaList['q']['list']['b'] = '단양군';                   			   
	$areaList['q']['list']['c'] = '보은군';                   			   
	$areaList['q']['list']['d'] = '영동군';                   			   
	$areaList['q']['list']['e'] = '옥천군';                   			   
	$areaList['q']['list']['f'] = '음성군';                   			   
	$areaList['q']['list']['g'] = '제천시';                   			   
	$areaList['q']['list']['h'] = '증평군';                   			   
	$areaList['q']['list']['i'] = '진천군';                   			   
	$areaList['q']['list']['j'] = '청주시';    
	$areaList['q']['list']['l'] = '청원군';    
	$areaList['q']['list']['k'] = '충주시';                   			   
	
	$areaList['o']['name'] = '제주도';		  									                              
    $areaList['o']['list']['a'] = '서귀포시';	  
	$areaList['o']['list']['b'] = '제주시';	  
	
	return ($sel)? $areaList[$sel] : $areaList;
}
function getJob($sel=null) {
	$jobList['a']['name'] = '법조인';
	$jobList['a']['list']['a'] = '판사';
	$jobList['a']['list']['b'] = '검사';
	$jobList['a']['list']['c'] = '변호사';
	$jobList['a']['level']['a'] = '1';
	$jobList['a']['level']['b'] = '1';
	$jobList['a']['level']['c'] = '2';
	$jobList['b']['name'] = '의료인';
	$jobList['b']['list']['a'] = '대학병원의사';
	$jobList['b']['list']['b'] = '의사';
	$jobList['b']['list']['c'] = '약사';
	$jobList['b']['level']['a'] = '1';
	$jobList['b']['level']['b'] = '2';
	$jobList['b']['level']['c'] = '3';
	$jobList['c']['name'] = '교직자';
	$jobList['c']['list']['a'] = '교수';
	$jobList['c']['list']['b'] = '중/고등학교교사';
	$jobList['c']['list']['c'] = '초등학교교사';
	$jobList['c']['level']['a'] = '2';
	$jobList['c']['level']['b'] = '3';
	$jobList['c']['level']['c'] = '3';
	$jobList['d']['name'] = '공무원';
	$jobList['d']['list']['a'] = '고위직공무원';
	$jobList['d']['list']['b'] = '검찰/국정원/국세청';
	$jobList['d']['list']['c'] = '군/경찰간부';
	$jobList['d']['list']['d'] = '공기업입사자';
	$jobList['d']['list']['e'] = '일반직 군/경/공무원';
	$jobList['d']['list']['f'] = '소방직공무원';
	$jobList['d']['level']['a'] = '1';
	$jobList['d']['level']['b'] = '1';
	$jobList['d']['level']['c'] = '2';
	$jobList['d']['level']['d'] = '3';
	$jobList['d']['level']['e'] = '3';
	$jobList['d']['level']['f'] = '4';
	$jobList['e']['name'] = '금융';
	$jobList['e']['list']['a'] = '외국계금융';
	$jobList['e']['list']['b'] = '은행원';
	$jobList['e']['list']['c'] = '증권계';
	$jobList['e']['list']['d'] = '보험업';
	$jobList['e']['level']['a'] = '3';
	$jobList['e']['level']['b'] = '4';
	$jobList['e']['level']['c'] = '4';
	$jobList['e']['level']['d'] = '5';
	$jobList['f']['name'] = '전문직';
	$jobList['f']['list']['a'] = 'ceo';
	$jobList['f']['list']['b'] = '중견기업(직원수 500명 이상)ceo';
	$jobList['f']['list']['c'] = '공인회계사';
	$jobList['f']['list']['d'] = '세무사';
	$jobList['f']['list']['e'] = '보험계리사';
	$jobList['f']['list']['f'] = '디자이너';
	$jobList['f']['level']['a'] = '3';
	$jobList['f']['level']['b'] = '2';
	$jobList['f']['level']['c'] = '2';
	$jobList['f']['level']['d'] = '3';
	$jobList['f']['level']['e'] = '4';
	$jobList['f']['level']['f'] = '3';
	$jobList['g']['name'] = '회사원';
	$jobList['g']['list']['a'] = '대기업재직';
	$jobList['g']['list']['b'] = '외국계기업재직';
	$jobList['g']['list']['c'] = '일반기업재직';
	$jobList['g']['list']['d'] = '중소기업재직';
	$jobList['g']['level']['a'] = '3';
	$jobList['g']['level']['b'] = '3';
	$jobList['g']['level']['c'] = '5';
	$jobList['g']['level']['d'] = '4';
	$jobList['h']['name'] = '방송인';
	$jobList['h']['list']['a'] = '기자';
	$jobList['h']['list']['b'] = '아나운서';
	$jobList['h']['list']['c'] = '연예인';
	$jobList['h']['list']['d'] = '스타급기자';
	$jobList['h']['list']['e'] = '스타급아나운서';
	$jobList['h']['list']['f'] = '스타급연예인';
	$jobList['h']['level']['a'] = '3';
	$jobList['h']['level']['b'] = '3';
	$jobList['h']['level']['c'] = '3';
	$jobList['h']['level']['d'] = '2';
	$jobList['h']['level']['e'] = '2';
	$jobList['h']['level']['f'] = '2';
	$jobList['i']['name'] = '기타';
	$jobList['i']['list']['a'] = '농.수.축산업';
	$jobList['i']['list']['b'] = '종교인';
	$jobList['i']['list']['c'] = '주부';
	$jobList['i']['list']['d'] = '무직';
	$jobList['i']['level']['a'] = '4';
	$jobList['i']['level']['b'] = '4';
	$jobList['i']['level']['c'] = '5';
	$jobList['i']['level']['d'] = '5'; 
	
	return ($sel)? $jobList[$sel] : $jobList;
}
function sendPush($params) {
	switch($params['type']) {
		case 'teamboard':
			//$params['title'] = '팀 새소식';
			//$params['msg'] = '팀게시판에 새로운글이 등록되었습니다';
			//$params['url']
		break;
	}
	$params['link'] = 'http://www.heat0.com'.$params['link'];		
	//$params['url'] = 'http://www.heat0.com'.$params['url'];		
	$addParams = array();
	$addParams['tuid'] = $params['tuid'];
	$addParams['ruid'] = $params['ruid'];
	if(substr(trim($params['platform']),0,3) == 'and') {
		$GCMPushMessage =  new GCMPushMessage($params['token']);
		//$result= $GCMPushMessage->send($params['title'],$params['msg'],$params['url'],$params['type'],$addParams);
		$result= $GCMPushMessage->send($params['title'],$params['msg'],$params['link']);
	
	} else if($params['token']) {
		//sendIosPush($params['token'],$params['title'],$params['msg'],$params['url'],$params['type'],$addParams);
		sendIosPush($params['token'],$params['title'],$params['msg'],$params['link']);
	}	
		return $result;
}
class GCMPushMessage {
 
    var $url = 'https://android.googleapis.com/gcm/send';
    var $serverApiKey = "AIzaSyDGKdxToO3Nw41a014NGmJ3h_jB8SUsNhY";
	var $devices = array();
 
    function GCMPushMessage($deviceIds){
        //$this->serverApiKey = $apiKeyIn;
		$this->setDevices($deviceIds);
	}
 
    function setDevices($deviceIds){
 
        if(is_array($deviceIds)){
            $this->devices = $deviceIds;
        } else {
            $this->devices = array($deviceIds);
        }
 
    }
 
    function send($title, $message, $link,$attend=null,$addParams=null) {
 
        if(!is_array($this->devices) || count($this->devices) == 0){
            $this->error("No devices set");
        }
 
        if(strlen($this->serverApiKey) < 8){
            $this->error("Server API Key not set");
        }
 
 		if($attend == 'attendDialog') {
			$fields = array(
			  'registration_ids'  => $this->devices,
			  'data'      => array( 'title' => $title, 'message' => $message, 'link' => $link,'type'=>'qna','tuid'=>$addParams['tuid'],'ruid'=>$addParams['ruid'])
			); 
		} else {
			$fields = array(
			  'registration_ids'  => $this->devices,
				'data'              => array( 'title' => $title, 'message' => $message, 'link' => $link ),
			); 
		} 
        //echo json_encode($fields);
        //exit;
 
 
        $headers = array( 
            'Authorization: key=' . $this->serverApiKey,
            'Content-Type: application/json'
        );
 
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt( $ch, CURLOPT_URL, $this->url );
 
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
 
        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
 
        // Execute post
        $result = curl_exec($ch);
 
        // Close connection
        curl_close($ch);
 
        return $result;
    }
 
    function error($msg){
        echo "Android send notification failed with error:";
        echo "\t" . $msg;
        exit(1);
    }
}
function sendIosPush($deviceToken,$title,$message,$url,$attend,$addParams) {
 
//$deviceToken = '67813b2...af1424b'; // 디바이스토큰ID
//$message = 'Message received from eye'; // 전송할 메시지
 
	// 개발용
	//$apnsHost = 'gateway.sandbox.push.apple.com';
	//$apnsCert = 'apns-dev.pem';
	openlog("push====", LOG_PID | LOG_PERROR, LOG_LOCAL0);
	syslog(LOG_WARNING,"DID: $deviceToken\n");
	// 실서비스용
	//$devmode = 0;
	$devmode = 1;
	// 개발용
	if( $devmode == 1)
	{
		$apnsHost = 'gateway.sandbox.push.apple.com';
		$apnsCert = $_SERVER['DOCUMENT_ROOT'].'/_lib/apns_dev_key.pem';
	}
	else {
		// 실서비스용
		$apnsHost = 'gateway.push.apple.com';
		$apnsCert = $_SERVER['DOCUMENT_ROOT'].'/_lib/apns_key.pem';
	}
 
	$apnsPort = 2195;
 
	if($attend == 'attendDialog') {
		$payload = array('aps' => array('alert' => $message, 'badge' => 0, 'sound' => 'default','link'=>$url,'title'=>$title,'type'=>'qna','tuid'=>$addParams['tuid'],'ruid'=>$addParams['ruid']));	
	} else {
		$payload = array('aps' => array('alert' => $message, 'badge' => 0, 'sound' => 'default','link'=>$url,'title'=>$title));
	}
	$payload = json_encode($payload);
 
	$streamContext = stream_context_create();
	stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
	stream_context_set_option($streamContext, 'ssl', 'passphrase',"soccercall");
 
	$apns = stream_socket_client('ssl://'.$apnsHost.':'.$apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);
	if($apns) {
		$apnsMessage = chr(0).chr(0).chr(32).pack('H*', str_replace(' ', '', $deviceToken)).chr(0).chr(strlen($payload)).$payload;
		fwrite($apns, $apnsMessage);
		fclose($apns);
	}
	
}
function myCallPush($agesend,$sendpart) {
	$LastRow = mysql_fetch_assoc(mysql_query("select max(uid) as maxuid from s_match_data"));
	$viewPart = array('list'=>'시합','outer'=>'용병','rent'=>'양도','away'=>'원정',);
	$query = mysql_query("select * from s_callset_data where ruse='yes'");
	while($myset = mysql_fetch_assoc($query)) {
	
		$addwhere = " where gdate>=curdate()";
		if($myset['age']) {
			$_ageinValue = explode(',',$myset['age']);
			$ageinValue = @implode("','",$_ageinValue);
			$addwhere.= " and age in ('".$ageinValue."')";
		}
		if($myset['type']) {
			$_typeinValue = explode(',',$myset['type']);
			$typeinValue = @implode("','",$_typeinValue);
			$addwhere.= " and part in ('".$typeinValue."')";
		}
		
		if($myset['area1']) {
			$_area1inValue = explode(',',$myset['area1']);
			$_area2inValue = explode(',',$myset['area2']);
	
			foreach($_area1inValue as $inkey=>$area1) {
				$_areawhere = "find_in_set(area1,'".$area1."')>0";
				if($_area2inValue[$inkey]) {
					$_areawhere.= " and find_in_set(area2,'".$_area2inValue[$inkey]."')>0";
				}
				$_areaAddwhere[] = $_areawhere;
			}
			$area1where = implode(" or ",$_areaAddwhere);
			$addwhere.= " and (".$area1where.")";
		}
		if($myset['week']) {
			$_weekinValue = explode(',',$myset['week']);
			$_weekwhere = array();
			foreach($_weekinValue as $week) {
				$_weekwhere[] = "DAYOFWEEK(gdate)='".$week."'";
			}
			$weekwhere = implode(" or ",$_weekwhere);
			$addwhere.= " and (".$weekwhere.")";
		}
		if($myset['time']) {
			$_timeinValue = explode(',',$myset['time']);
			foreach($_timeinValue as $time) {
				switch($time) {
					case '1':
						$_timewhere[] = "(gtime >= '300' and gtime <='600')";		
					break;
					case '2':
						$_timewhere[] = "(gtime >= '600' and gtime <='900')";		
					break;
					case '3':
						$_timewhere[] = "(gtime >= '600' and gtime <='900')";		
					break;
					case '4':
						$_timewhere[] = "(gtime >='900' and gtime<='1200')";		
					break;
					case '5':
						$_timewhere[] = "(gtime>='1200' and gtime<='1500')";		
					break;
					case '6':
						$_timewhere[] = "(gtime>='1500' and gtime<='1800')";		
					break;
					case '7':
						$_timewhere[] = "(gtime>='1800' and gtime<='2100')";		
					break;
					case '8':
						$_timewhere[] = "(gtime>='2100' and gtime<='2400')";		
					break;
					case '9':
						$_timewhere[] = "(gtime>='0' and gtime<='300')";		
					break;	
				}
		
			}
			$timewhere = implode(" or ",$_timewhere);
			$addwhere.= " and (".$timewhere.")";
		}
		
		$R = mysql_fetch_assoc(mysql_query("select * from s_match_data".$addwhere." and uid='".$LastRow['maxuid']."'"));
		if($R['uid']) {
			$payRow = mysql_fetch_assoc(mysql_query("SELECT * FROM s_payment_data WHERE tuid='".$R['tuid']."' AND expiredate>=curdate() AND step=2 limit 1"));
			if(!$payRow['uid']) {
				if($R['part']!='outer') {
					continue;
				}
			}
			
			$rows = mysql_fetch_assoc(mysql_query("select * from rb_s_mbrdata where memberuid ='".$myset['memberuid']."'"));
			if($rows['token'] && $rows['dev']  && $rows['deviceid']) { 
				$params['deviceid'] = $rows['deviceid'];
				$params['platform'] = $rows['dev'];
				$params['token'] = $rows['token'];
				$params['url'] = '/?mod=gamematch&submode=view&agecode='.$agesend.'&amode='.$sendpart.'&uid='.$LastRow['maxuid'].'&pushmemberuid='.$rows['memberuid'];
				$params['type'] = 'call';
				$params['title'] = '축구콜등록';
				$params['msg'] = '축구콜에 새소식이 등록되었습니다';
	
				sendPush($params);
			}
		}
	}
}
function getAtagUrl($string) {
	
	$strses = explode(' ',$string);
	if(is_array($strses)) {
		$patterns[] = '/http:\/\//i';
		$patterns[] = '/https:\/\//i';
		$patterns[] = '/.or.kr/i';
		$patterns[] = '/.co.kr/i';
		$patterns[] = '/.com/i';
		$patterns[] = '/.org/i';
		$patterns[] = '/.kr/i';
		$patterns[] = '/.net/i';
		foreach($strses as $str) {
			$matchFlag = false;
			foreach($patterns as $pattern) {
				if(!$matchFlag) {
					if(preg_match($pattern,$str,$matchstring)) {
							
						if(preg_match("/[가-힣]/",$str,$hstring)) {
							$str = preg_replace("/[가-힣]/","",$str);
						}
						$urlstr = str_replace("\r\n","",$str);
						$urlLink = 'http://'.str_replace('http//','',str_replace('https://','',str_replace('http://','',$urlstr)));
						$string = str_replace($str,"<a href='".$urlLink."' target='_blank' style='text-decoration:underline;'>".$str."</a>",$string);
						$matchFlag = true;
					}
				}
			}
		}
	}
	return nl2br($string);
			
}
// 회원 아바타 이미지 추출 함수 2016. 7. 8 by kiere  
function getMyPicSrc($memberuid){
    global $g,$table;
   
    $M=getDbData($table['s_mbrdata'],'memberuid='.$memberuid,'memberuid,photo');
    if($M['photo']) $avatar_src=$g['url_root'].'/_var/simbol/'.$M['photo'];
    else  $avatar_src=$g['url_root'].'/img/my.png';
   
    return $avatar_src; 
}
function getUserAgent(){
		$device = '';
		
		if( stristr($_SERVER['HTTP_USER_AGENT'],'ipad') ) {
			$device = "ipad";
		} else if( stristr($_SERVER['HTTP_USER_AGENT'],'iphone') || strstr($_SERVER['HTTP_USER_AGENT'],'iphone') ) {
			$device = "iphone";
		} else if( stristr($_SERVER['HTTP_USER_AGENT'],'blackberry') ) {
			$device = "blackberry";
		} else if( stristr($_SERVER['HTTP_USER_AGENT'],'android') ) {
			$device = "android";
		}
		
		if( $device ) {
			return $device; 
		} return false; {
			return false;
		}
	}
?>