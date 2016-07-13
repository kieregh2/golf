<?php
include_once $g['path_module'].$module.'/var/var.fixed.php';



$sort	= 'rdate';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 301 ? $recnum : 30;
$bbsque	= 'hide <1';

if($_area1) {
	$bbsque .= " and area1='".$_area1."'";
}

if($_area2) {
	
	switch($_area1) {
		case 'b':
		case 'c':
		case 'd':
		case 'e':
		case 'f':
		case 'g':
		case 'h':
			if($_area2!='a') {
				$bbsque .= " and area2='".$_area2."'";
			}
		break;
		default:
			$bbsque .= " and area2='".$_area2."'";
		break;
	}
}
if ($where && $keyw)
{
	if (strstr('[id]',$where)) $bbsque .= " and ".$where."='".$keyw."'";
	else $bbsque .= getSearchSql($where,$keyw,$ikeyword,'or');	
}
if($nogeo) {
	$bbsque .= " and ((lat='' or lat is null) or (lng='' or lng is null)) ";
}

$RCD = getDbArray('s_ground_data',$bbsque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows('s_ground_data',$bbsque);
$TPG = getTotalPage($NUM,$recnum);

$areaList = getArea();
?>
<style>
input {width:300px;}
#configbox .btnblue{width:100px;}
#configbox .btngray{width:100px;}

/* write */
#configbox {margin:auto;padding:0 0 30px 0;line-height:10px;}
#configbox .editbox {padding:15px 0 15px 0;}
#configbox .iconbox {border-left:#e0e0e0 solid 1px;border-top:#e0e0e0 solid 1px;border-right:#e0e0e0 solid 1px;background:#f9f9f9;padding:6px 0 8px 7px;}
#configbox .iconbox a {padding:0 3px 0 3px;font-size:11px;font-family:dotum;color:#333;}
#configbox .iconbox a:hover {color:#7899C7;}
#configbox .iconbox a img {position:relative;top:2px;left:-2px;margin-right:3px;}
#configbox .iconbox .split {padding:0 2px 0 2px;margin-bottom:-1px;}
#map  {border:solid 1px #dfdfdf;width:100%;height:300px;}

</style>




	<div id='ground_write' style="display:<?=($uid || $regist=='yes')?'block':'none'?>;">

<?php
	$R = getUidData('s_ground_data',$uid);

?>
<script>
var areaList = <?=json_encode($areaList)?>;

function updateArea(elv) {
	$container = $('#area2');
	$container.html('');
	$container.append('<option value="">상세지역선택</option>');
	
	if(elv) {
		$.each(areaList[elv].list,function(k,fn) {
			var $options = $('<option value="'+k+'">'+fn+'</option>');
			$container.append($options);
		})
	}

}

function updateArea2(elv) {
	$container = $('#_area2');
	$container.html('');
	$container.append('<option value="">상세지역선택</option>');
	
	if(elv) {
		$.each(areaList[elv].list,function(k,fn) {
			var $options = $('<option value="'+k+'">'+fn+'</option>');
			$container.append($options);
		})
	}

}
</script>
	<iframe  name="_action_frame_hidden" style='display:none;'></iframe>

	<form name="writeForm" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data" target="_action_frame_hidden" >
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $module?>" />
	<input type="hidden" name="a" value="ground_regis" />
	<input type="hidden" name="lat" id="lat" value="<?=$R['lat']?>" />
	<input type="hidden" name="uid"  value="<?=$R['uid']?>" />

	<input type="hidden" name="lng" id="lng" value="<?=$R['lng']?>" />

	<div class="title">
		골프장관리
	</div>

	<table  style='width:640px;'>
		<tr>
			<td class="td1">
				이름
			</td>
			<td class="td2">
				<input type='text' name='name' value='<?=$R['name']?>'>
			</td>
		</tr>
		<tr>
			<td class="td1" valign='top'>
				이미지
			</td>
			<td class="td2" valign='top'>
				<input type='file' name='img'>
				<? if($R['img']) { ?>
					<img src='<?=$R['img']?>' width=100/>
				<? } ?>
			</td>
		</tr>
		<tr>
			<td class="td1" valign='top'>
				이미지2
			</td>
			<td class="td2" valign='top'>
				<input type='file' name='img2'>
				<? if($R['img2']) { ?>
					<img src='<?=$R['img2']?>' width=100/>
				<? } ?>
			</td>
		</tr>
		<tr>
			<td class="td1" valign='top'>
				이미지3
			</td>
			<td class="td2" valign='top'>
				<input type='file' name='img3'>
				<? if($R['img3']) { ?>
					<img src='<?=$R['img3']?>' width=100/>
				<? } ?>
			</td>
		</tr>
		<tr>
			<td class="td1" valign='top'>
				이미지4
			</td>
			<td class="td2" valign='top'>
				<input type='file' name='img4'>
				<? if($R['img4']) { ?>
					<img src='<?=$R['img4']?>' width=100/>
				<? } ?>
			</td>
		</tr>
		<tr>
			<td class="td1" valign='top'>
				이미지5
			</td>
			<td class="td2" valign='top'>
				<input type='file' name='img5'>
				<? if($R['img5']) { ?>
					<img src='<?=$R['img5']?>' width=100/>
				<? } ?>
			</td>
		</tr>

		<tr>
			<td class="td1">
				연락처
			</td>
			<td class="td2">
				<input type='text' name='tel' value='<?=$R['tel']?>'>
			</td>
		</tr>
		<tr>
			<td class="td1">
				fax
			</td>
			<td class="td2">
				<input type='text' name='fax' value='<?=$R['fax']?>'>
			</td>
		</tr>
		<tr>
			<td class="td1">
				지역
			</td>
			<td class="td2">
				<select name='area1' id='area1' onchange="updateArea(this.value)">
					<option value="">지역선택</option>
					<? foreach($areaList as $key=>$dts) { ?>
						<option value="<?=$key?>" <?=($key==$R[area1])?'selected':''?>><?=$dts['name']?></option>
					<? }  ?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="td1">
				상세지역
			</td>
			<td class="td2">
				<select name='area2' id='area2'>
				<option value="">상세지역선택</option>
				<?  if($R['area1']) { ?>
				<? foreach($areaList[$R['area1']]['list'] as $key=>$name) { ?>
						<option value="<?=$key?>" <?=($key==$R[area2])?'selected':''?>><?=$name?></option>
				<? } }  ?>

				</select>
			</td>
		</tr>
		
		<tr>
			<td class="td1">
				주소
			</td>
			<td class="td2">
				<input type='text' name='address' id='address' value='<?=$R['address']?>'>
				<input type='button' value='좌표검색' onclick="getMapGeo()" class='btnblue' style='width:70px;'>
			</td>
		</tr>
		<tr>
			<td class="td1">
				좌표설정
			</td>
			<td class="td2">
				<div style='font-size:12px;color:red;padding-bottom:5px;'>지도위를 클릭하면 마커의 위치를 변경할수  있습니다</div>
				<div id='map'></div>
			</td>
		</tr>
		<tr>
			<td class="td1">홀</td>
			<td class="td2 shift">
				<input type='text' name='hall' value='<?=$R['hall']?>'> 홀
			</td>
		</tr>
		<tr>
			<td class="td1">그린피(평일)</td>
			<td class="td2 shift">
				<input type='text' name='weekday' value='<?=$R['weekday']?>'>원
			</td>
		</tr>
		<tr>
			<td class="td1">그린피(토요일)</td>
			<td class="td2 shift">
				<input type='text' name='saturday' value='<?=$R['saturday']?>'>원
			</td>
		</tr>
		<tr>
			<td class="td1">그린피(일요일)</td>
			<td class="td2 shift">
				<input type='text' name='sunday' value='<?=$R['sunday']?>'>원
			</td>
		</tr>
		<tr>
			<td class="td1">그린피(휴일)</td>
			<td class="td2 shift">
				<input type='text' name='holyday' value='<?=$R['holyday']?>'>원
			</td>
		</tr>
		<tr>
			<td class="td1">카트피</td>
			<td class="td2 shift">
				<input type='text' name='cartfee' value='<?=$R['cartfee']?>'>원
			</td>
		</tr>
		<tr>
			<td class="td1">캐디피</td>
			<td class="td2 shift">
				<input type='text' name='cadyfee' value='<?=$R['cadyfee']?>'>원
			</td>
		</tr>
		<tr>
			<td class="td1">오픈타임</td>
			<td class="td2 shift">
				<input type='text' name='opentime' value='<?=$R['opentime']?>'>
			</td>
		</tr>
		<!-- 
		<tr>
			<td class="td1">룰</td>
			<td class="td2 shift">
				<input type='textarea' name='rule' value='<?=$R['rule']?>'>
			</td>
		</tr>
 		-->

		<tr>
			<td class="td1" colspan=2>규정사항</td>
		</tr>
		<tr>
			<td class="td2" colspan=2>
				<div class="editbox">
		<div class="iconbox">
			<a href="#." onclick="OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&m=upload&mod=photo&gparam=upfilesValue|upfilesFrame|editFrame');" /><img src="<?php echo $g['img_core']?>/_public/ico_photo.gif" alt="" />사진</a>
			<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />
			<a href="#." onclick="OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&m=upload&mod=file&gparam=upfilesValue|upfilesFrame');" /><img src="<?php echo $g['img_core']?>/_public/ico_xfile.gif" alt="" />파일</a>
			<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />
			<a href="#." onclick="ToolCheck('layout');">레이아웃</a>
			<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />
			<a href="#." onclick="ToolCheck('table');">테이블</a>
			<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />
			<a href="#." onclick="ToolCheck('box');">박스</a>
			<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />
			<a href="#." onclick="ToolCheck('char');">특수문자</a>
			<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />
			<a href="#." onclick="ToolCheck('link');">링크</a>
			<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />

			<a href="#." onclick="ToolCheck('icon');">아이콘</a>
			<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />
			<a href="#." onclick="ToolCheck('flash');">플래쉬</a>
			<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />
			<a href="#." onclick="ToolCheck('movie');">동영상</a>
			<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />
			<a href="#." onclick="ToolCheck('html');">HTML</a>
			<img src="<?php echo $g['img_core']?>/_public/split_01.gif" alt="" class="split" />
			<a href="#." onclick="frames.editFrame.ToolboxShowHide(0);" /><img src="<?php echo $g['img_core']?>/_public/ico_edit.gif" alt="" />편집</a>
		</div>
	
		<div>
		<input type="hidden" name="html" id="editFrameHtml" value='HTML' />
		<input type="hidden" name="content" id="editFrameContent" value="<?php echo htmlspecialchars($R['content'])?>" />
		<iframe name="editFrame" id="editFrame" src="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=editor&amp;toolbox=Y" width="100%" height="400" frameborder="0" scrolling="no" allowTransparency="true"></iframe>
		</div>
		
		<div>
		<iframe name="upfilesFrame" id="upfilesFrame" src="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=upload&amp;mod=list&amp;gparam=upfilesValue|editFrame&amp;code=<?php echo $R['upload']?>" width="100%" height="0" frameborder="0" scrolling="no" allowTransparency="true"></iframe>
		</div>

	</div>

			</td>
		</tr>
		
	</table>





	<div class="submitbox" >
		<input type="button" class="btnblue" value=" 확인 " onclick="saveCheckThis(document.writeForm)" />
		<input type="button" value=" 취소 " class="btngray" style='margin-left:10px;' onclick="location.href='<?php echo $g['adm_href']?>'" />
	</div>

	</form>
<div style='height:60px;'></div>
</div>




<script type="text/javascript">
//<![CDATA[
var submitFlag = false;
function ToolCheck(compo)
{
	frames.editFrame.showCompo();
	frames.editFrame.EditBox(compo);
}

function saveCheckThis(f)  {
	if (f.name.value == '')
	{
		alert('이름을 입력해 주세요.       ');
		f.name.focus();
		return false;
	}

	if (f.tel.value == '')
	{
		alert('연락처를 입력해주세요.       ');
		f.tel.focus();
		return false;
	}
	
	if(!$('#area1').val()) {
		alert('지역을 선택해주세요.       ');
		f.area1.focus();
		return false;
	}

	if(!$('#area2').val())  {

		alert('상세지역을 선택해주세요. ');
		f.area2.focus();
		return false;
	}

	if (f.address.value == '')
	{
		alert('주소를 입력해주세요.       ');
		f.address.focus();
		return false;
	}
	if (f.lat.value == '')
	{
		alert('좌표검색을  해주세요.       ');
		return false;
	}
	frames.editFrame.getEditCode(f.content,f.html);
	if (f.content.value == '')
	{
		alert('내용을 입력해 주세요.       ');
		frames.editFrame.getEditFocus();
		return false;
	}

	if (getId('upfilesFrame'))
	{
		frames.upfilesFrame.dragFile();
	}

	if(confirm('정말로 실행하시겠습니까?         ')) {
		f.submit();	
	}
	
}
//]]>
</script>



<script type="text/javascript" src="//apis.daum.net/maps/maps3.js?apikey=<?=$d['team']['apikey']?>"></script>
<script>
function getMapGeo() {
	var addr = $('#address').val();
	if(!addr) {
		alert('주소를  입력하세요');
		return;
	}
	$.ajax({url:"https://apis.daum.net/local/geo/addr2coord",
			data:"apikey=<?=$d['team']['apikey']?>&output=json&q="+addr,
			jsonp : "callback",
			dataType:'jsonp',
		    success:function(dt) {
				if(dt.channel.result >0) {
					setMaps(dt.channel.item[0].point_y,dt.channel.item[0].point_x);		
				}
			}
	});
			
}
<?php if($R['lat'] &&  $R['lng']) { ?>
	setMaps("<?=$R['lat']?>","<?=$R['lng']?>");

<?php } ?>

function setMaps(lat,lng) {
	$('#lat').val(lat);
	$('#lng').val(lng);
	var mapContainer = document.getElementById('map'), // 지도를 표시할 div 
		mapOption = { 
			center: new daum.maps.LatLng(lat, lng), // 지도의 중심좌표
			level: 3 // 지도의 확대 레벨
		};

	var map = new daum.maps.Map(mapContainer, mapOption); // 지도를 생성합니다

	// 지도를 클릭한 위치에 표출할 마커입니다
	var marker = new daum.maps.Marker({ 
	 // 지도 중심좌표에 마커를 생성합니다 
		position: map.getCenter() 
	}); 
	// 지도에 마커를 표시합니다
	marker.setMap(map);

	// 지도에 클릭 이벤트를 등록합니다
	// 지도를 클릭하면 마지막 파라미터로 넘어온 함수를 호출합니다
	daum.maps.event.addListener(map, 'click', function(mouseEvent) {        
   	// 클릭한 위도, 경도 정보를 가져옵니다 
		var latlng = mouseEvent.latLng; 
    
		// 마커 위치를 클릭한 위치로 옮깁니다
		marker.setPosition(latlng);
    
		$('#lat').val(latlng.getLat());
		$('#lng').val(latlng.getLng());
    
	});
}
</script>



<div id="configbox">



	<div class="sbox">
		<form name="procForm" action="<?php echo $g['s']?>/" method="get">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="<?php echo $m?>" />
		<input type="hidden" name="module" value="<?php echo $module?>" />
		<input type="hidden" name="front" value="<?php echo $front?>" />

		<div style='margin-bottom:10px;'>
				지역
				<select name='_area1' id='_area1' onchange="updateArea2(this.value)">
					<option value="">지역선택</option>
					<? foreach($areaList as $key=>$dts) { ?>
						<option value="<?=$key?>" <?=($key==$_GET['_area1'])?'selected':''?>><?=$dts['name']?></option>
					<? }  ?>
				</select>
				
				상세지역
				<select name='_area2' id='_area2'>
				<option value="">상세지역선택</option>
				<?  if($_GET['_area1']) { ?>
				<? foreach($areaList[$_GET['_area1']]['list'] as $key=>$name) { ?>
						<option value="<?=$key?>" <?=($key==$_GET['_area2'])?'selected':''?>><?=$name?></option>
				<? } }  ?>

				</select>
				<input type='checkbox' name='nogeo' <?=($nogeo=='yes')?'checked':''?> style='width:12px;height:12px;margin:0 5px 0 5px;' value='yes'/>좌표미설정 골프장
		</div>

		<div>
		<select name="sort" onchange="this.form.submit();">
		<option value="gid"<?php if($sort=='gid'):?> selected="selected"<?php endif?>>지정순서</option>
		<option value="uid"<?php if($sort=='uid'):?> selected="selected"<?php endif?>>개설일</option>
		</select>
		<select name="orderby" onchange="this.form.submit();">
		<option value="desc"<?php if($orderby=='desc'):?> selected="selected"<?php endif?>>역순</option>
		<option value="asc"<?php if($orderby=='asc'):?> selected="selected"<?php endif?>>정순</option>
		</select>

		<select name="recnum" onchange="this.form.submit();">
		<?php for($i=30;$i<=300;$i=$i+30):?>
		<option value="<?php echo $i?>"<?php if($i==$recnum):?> selected="selected"<?php endif?>><?php echo $i?>개</option>
		<?php endfor?>
		</select>
		<select name="where">
		<option value="name"<?php if($where=='name'):?> selected="selected"<?php endif?>>골프장명</option>
		</select>

		<input type="text" name="keyw" value="<?php echo stripslashes($keyw)?>" class="input" />

		<input type="submit" value="검색" class="btnblue" />
		<input type="button" value="리셋" class="btngray" onclick="location.href='<?php echo $g['adm_href']?>';" />

		<input type="button" value="골프장추가" class="btngray" style='margin-left:150px;' onclick="location.href='<?php echo $g['adm_href']?>&regist=yes'" />

		</div>

		</form>
	</div>


	<table><tr><td></td></tr></table>
	<div class="bbsbody">
		
		<table>
		<colgroup> 
		<col width="40"></col> 
		<col width="90"></col>
		<col width="150"></col> 
		<col width="160"></col> 
		<col width="100"></col> 
		<col width="100"></col> 
		<col width="100"></col> 
		<col width="180"></col> 
		<col width="100"></col> 
		<col width="60"></col> 
		<col></col> 
		</colgroup> 
		<thead>
		<tr height="40">
		<th scope="col" class="side1">번호</th>
		<th scope="col">이미지</th>
		<th scope="col">골프장이름</th>
		<th scope="col">연락처<br>(fax)</th>
		<th scope="col">필드타입</th>
		<th scope="col">매니저</th>
		<th scope="col">홀</th>
		<th scope="col">그린피</th>
		<th scope="col">오픈타임<br>(등록일)</th>
		<th scope="col">관리</th>
		<th scope="col" class="side2"></th>
		</tr>
		</thead>
		<tbody>
		<?php 
		
		$fieldTypeArr = array("Y"=>"필드", "S"=>"스크린");
		
		while($R=db_fetch_array($RCD)):
		$sql = "select * from rb_s_mbrdata where memberuid = '".$R['manager_uid']."'";
		$query = mysql_query($sql);
		$manager = mysql_fetch_assoc($query);
		
		?>
		<tr height=60>
		<td><?php echo $NUM-((($p-1)*$recnum)+$_rec++)?></td>
		<td>
			<? if($R['img']) { ?>
					<img src='<?=$R['img']?>' width=70/>
				<? } ?>
		</td>
		<td><?php echo "<b>".$R['name']."</b>"."<br><br>".$areaList[$R['area1']]['name']."<br><br>".$areaList[$R['area1']]['list'][$R['area2']]."<br><br>".$R['address']?></td>
		<td><?php echo $R['tel']."<br>(".$R['fax'].")"?></td>
		<td><?php echo $fieldTypeArr[$R['yard_type']]?></td>
		<td><?php echo "<a href=\"javascript:OpenWindow('/?r=home&iframe=Y&m=member&front=manager&page=info&mbruid=".$R['manager_uid']."');\" title=\"회원정보\">".$manager['nic']."</a><br><br>".$manager['tel2']?></td>
		<td><?php echo $R['hall']?></td>
		<td><?php echo "<b>평일:".$R['weekday']
						."<br><br><b>주말:".$R['saturday']
						."<br><br><b>일요일:".$R['sunday']
						."<br><br><b>휴일:".$R['holyday']
						."<br><br><b>카트피:".$R['cartfee']
						."<br><br><b>캐디피:".$R['cadyfee'];
			?>
		</td>
		<td><?php echo $R['opentime']."<br><br>".$R['rdate']?></td>

		<td class="mng">
			<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=event_delete&amp;uid=<?php echo $R['uid']?>" onclick="return hrefCheck(this,true,'삭제하시겠습니까?');" class="del">삭제</a>
			<a href="<?php echo $g['adm_href']?>&uid=<?=$R['uid']?>&p=<?=$p?>&_area1=<?=$_area1?>&_area2=<?=$_area2?>&where=<?=$where?>&keyw=<?=$keyw?>">수정</a>		
		</td>
		<td></td>
		</tr>
		<?php endwhile?>
		</tbody>
		</table>

		<div class="pagebox01">
		<script type="text/javascript">getPageLink(10,<?php echo $p?>,<?php echo $TPG?>,'<?php echo $g['img_core']?>/page/default');</script>
		</div>	

		
	</div>

	<div style='height:40px;'></div>


</div>


