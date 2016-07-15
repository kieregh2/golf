<?php
// 디바이스 정보 업데이트 
//include_once $g['path_layout'].$d['layout']['dir'].'/_lib/app_setting.php';
$areaList = getArea(); 
$reverseAreaList = getReverseArea($areaList);
// 소셜로그인 추가 
$g['mdl_slogin'] = 'sociallogin';
$g['use_social'] = is_file($g['path_module'].$g['mdl_slogin'].'/var/var.php');
if ($g['use_social'])
{
	//$_isModal = true;
	include $g['path_module'].$g['mdl_slogin'].'/lang.korean/action/a.slogin.check.php';
}
?>


<script type='text/javascript' src='/_core/js/jquery-ui/jquery-ui.min.js'></script>
<link type="text/css" rel="stylesheet" charset="utf-8" href="/_core/js/jquery-ui/jquery-ui.min.css"/>
<!--  script start -->
 
<script>
var deviceId = localStorage.getItem("deviceid");
var token	 = localStorage.getItem("token");
var dev		 = localStorage.getItem("dev");
/*
var marea1code = localStorage.getItem("marea1code");
var marea1name = localStorage.getItem("marea1name");
var marea2code = localStorage.getItem("marea2code");
var marea2name = localStorage.getItem("marea2name");
if(marea1code == null)marea1code = '';
if(marea1name == null)marea1name = '';
if(marea2code == null)marea2code = '';
if(marea2name == null)marea2name = '';
*/
var areaList = <?=json_encode($areaList)?>;
	
<?php if(!$my['uid']):?>
if(deviceId) {
	$.post("/proc/proc.ajax.php", { "mode": "login","deviceid": deviceId},  
		function (ret) {
			if(ret=='succ')document.location.reload();  
	
	});  
}
<?php endif?>
function getPageMove(url) {
	
 	location.href = url;
 }	
 	
</script>
<!-- <div id="screenLayer" style="width:100%;background:black;filter:alpha(opacity=75); opacity:0.75; z-index:11111111;display:none;position:absolute;"></div> -->
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/modules/team/var/var.fixed.php';?>
<script>
function goLogin() {
	getPageMove('/?mod=login');
}
</script>
<script type="text/javascript">
//<![CDATA[
function showLogCheck(f) {
	if (f.id.value == '')
	{
		alert('아이디를 입력해 주세요.');
		f.id.focus();
		return false;
	}
	if (f.pw.value == '')
	{
		alert('비밀번호를 입력해 주세요.');
		f.pw.focus();
		return false;
	}
	f.referer.value = '<?php echo urldecode($referer)?>';
	f.submit();
}
function getLogin() {
	screen_show('loginMessageLayer');
	//loginViaSocial();
	//social_login();
}
function goHistoryBack() {
	<?php if($_GET['mod']=='payment'):?>
	
		history.go(-1);
	<?php elseif($_GET['mod']!='team' && !$_GET['uid'] && !$_GET['amode']):?>
		location.href='/';
	
	
	<?php elseif($_GET['mod'] && $_GET['submode'] == 'write' && $_GET['amode']):?>
		location.href='/?mod=<?php echo $_GET["mod"]?>&submode=<?php echo $_GET["amode"]?>&agecode=<?php echo $_GET["agecode"]?>';
	
	<?php elseif($_GET['mod']=='team' && $_GET['tid'] && $_GET['amode']):?>
		location.href='/?mod=teamlist&submode=<?php echo $_GET["amode"]?>';
	
	<?php elseif($_GET['mod']=='team' && $_GET['tid'] && !$_GET['amode']):?>
		location.href='/?mod=teamlist';
	
	<?php elseif($_GET['mod'] && $_GET['uid'] && $_GET['amode']):?>
		location.href='/?mod=<?php echo $_GET["mod"]?>&submode=<?php echo $_GET["amode"]?>&agecode=<?php echo $_GET["agecode"]?>';
	<?php else:?>
		history.go(-1);
	<?php endif?>
}
</script>
<iframe name='hiddemFramePaper' style='display:none;'></iframe>
<div id='_allLayoutBox_' style='background:#f3f3f3;'>
</div>
<!--  script end -->
	<div id="loginOverlay"></div>
	<div id="loginViaSocial">
		<span id="loginOverlayClose" class="icon icon-whitex"></span>
        <?php foreach($g['snskor'] as $key => $val):?>
		<?php if(!$d[$g['mdl_slogin']]['use_'.$key])continue?>
		<div id="<?php echo $val[1]?>Login" class="socialLoginButton" data-role="social-login" data-connect="<?php echo $slogin[$val[1]]['callapi']?>">
		</div>
		<?php endforeach?>
		
		<h3>이메일 로그인</h3>
		<form id="LayoutLogForm" name="LayoutLogForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="a" value="login" />
		
		<div id="emailBox" class="loginInput">
			<input id="email" name="id" type="text"  value="<?php echo getArrayCookie($_COOKIE['svshop'],'|',0)?>" title="아이디" placeholder="이메일" />
		</div>
		<div id="passwordBox" class="loginInput">
			<input id="password" name="pw" type="password" value="<?php echo getArrayCookie($_COOKIE['svshop'],'|',1)?>" title="패스워드" placeholder="비밀번호" />
		</div>
		<div id="findPasswordBox">
			<a href="<?php echo $g['s']?>/?m=member&amp;front=login&amp;page=idpwsearch"><span id="findPassword">비밀번호 찾기</span></a>
		</div>
		
		<div id="login" class="socialLoginButton">로그인</div>
		
		</form>
		
		<!-- 화면 크기에 따른 여백 조정 jQuery or javascript -->
		<div id="flexibleSpacer"></div>
		
		<div id="splitterLine" class="socialLoginButton">
			<span class="monoLine"></span>
			<span id="monoText">또는</span>
			<span class="monoLine"></span>
		</div>
		
		<a href="<?php echo RW('mod=join')?>" id="signin" class="socialLoginButton" style="color:#fff !important;">회원 가입하기</a>
		
		<div id="maybeNexttimeBox">
			<span id="maybeNexttime">다음에 할께요</span>
		</div>
	</div>
	<div id="loginPanel" >
		<div id="loginHeader">
			<div id="loginInfomation">
				<img src="<?php echo getMyPicSrc($my['uid'])?>" id="loginThumbnail"/>
				<?if($my['uid']) :?>
				<h3><?=$my['name']?><?=$my['vip']? '<span class="icon icon-tag-vip">':''?></span></h3>
				<h4><?=$my['id']?></h4>
				<!-- <h4><a href="/?r=home&a=logout">logout</a></h4>-->
				<? else :?>
				<h3>손님입니다.</span></h3>
				<h4>로그인/회원가입을 해주세요.</h4>
				<? endif?>
			</div>
		</div>
		<?if($my['uid']) :?>
            <div id="loginBody">
                <ul>
                    <li>
                        <a class="fill-up-space" href="#" data-role="mymenu-item" data-menu="game">
                            <span class="loginicon icon-golfer"></span><span class="normal-text">나의 경기</span>
                        </a>                        
                    </li>
                    <li>
                        <a class="fill-up-space" href="#" data-role="mymenu-item" data-menu="friends">
                            <span class="loginicon icon-friends"></span><span class="normal-text">친구</span>
                        </a>
                    </li>
                    <li>
                        <a class="fill-up-space" href="#" data-role="mymenu-item" data-menu="saving">
                            <span class="loginicon icon-database"></span><span class="normal-text">적립현황</span>
                        </a>
                    </li>
                    <li>
                        <a class="fill-up-space" href="#" data-role="mymenu-item" data-menu="wishlist">
                            <span class="loginicon icon-heart-big"></span><span class="normal-text">찜 내역</span>
                        </a>
                    </li>
                    <li>
                        <a class="fill-up-space" href="#" data-role="mymenu-item" data-menu="coupon">
                            <span class="loginicon icon-coupon"></span><span class="normal-text">나의 쿠폰보기</span>
                        </a>
                    </li>
                    <li>
                        <a class="fill-up-space" href="#" data-role="mymenu-item" data-menu="review">
                            <span class="loginicon icon-pen"></span><span class="normal-text">리뷰쓰기</span>
                        </a>
                    </li>
                    <li>
                        <a class="fill-up-space" href="#" data-role="mymenu-item" data-menu="bill">
                            <span class="loginicon icon-wallet"></span><span class="normal-text">결제현황</span>
                        </a>
                    </li>
                    <li>
                        <a class="fill-up-space" href="#" data-role="mymenu-item" data-menu="timeline">
                        <!-- <a class="fill-up-space" href="/?mod=mymenu&submode=timeline"> -->
                            <span id="mymenuTimelineList" class="loginicon icon-timeline"></span><span class="normal-text">타임라인</span>
                        </a>
                    </li>
                    <li>
                        <a class="fill-up-space" href="#" data-role="mymenu-item" data-menu="setting">
                            <span class="loginicon icon-config"></span><span class="normal-text">설정하기</span>
                        </a>
                    </li>
                    <?php if($my['sosok']==3):?>
                    <li>
                        <a class="fill-up-space" href="#" data-role="mymenu-item" data-menu="manager">
                            <span class="loginicon icon-config"></span><span class="normal-text">매니져</span>
                        </a>
                    </li>
                   <?php endif?>
                </ul>
            </div>
		<? else :?>		
		<div id="loginFooter">
			<span id="loginButton">
				로그인
			</span>
		</div>
		<? endif?>
	</div>
<?
$submode = (!empty($submode))? $submode:'list';
if(($submode == 'list' && $mod != 'mymenu' || $submode == 'search_list' || $submode == 'ranking_all') && $m!='member') { ?>	
	<header class="fix">
		<div id="">
			<span id="header-menu"></span>
			<span id="header-title"></span>
		</div>
	</header>
<? }?>	
<div id="nonMymenu">
<?php require_once __KIMS_CONTENT__ ?>
</div>
<!--vip 모달 -->
<div class="modal" id="modal-vip">
	<div class="normal-background dim-gray-bg">

    </div>
</div>
<!--mymenu 모달 -->
<div class="modal" id="modal-mymenu">
    <header class="fix">
         <div id="header-colored">
             <div id="header-left">
	                <a href="#" data-dismiss="modals"><span class="icon icon-backward"></span></a>
            </div>
            <div id="header-center" data-role="title"></div>
        </div>
    </header>
    <div class="content" data-role="content"><!-- mymenu 내용 --> </div>
</div>

<script type="text/javascript">
// 소셜 로그인 함수 추가 
$(document).on('click','[data-role="social-login"]',function(){
    var connectUrl=$(this).data('connect');
    //frames._action_frame_slogin.location.href = connectUrl;
    location.href = connectUrl;
    
    //$('#modal-slogin').addClass('active');
    //$('#modal-slogin').css('top',"101px");
    //$('#modal-slogin').show();
});
var my_id = '<?=$my['uid']?>';
var BodyHeight = $("body").height();
var LoginHeaderHeight = $("#loginHeader").height();
var ButtonMargin = ((window.outerHeight - LoginHeaderHeight) / 2) - 100;
$("#loginPanel").css("height", BodyHeight);
//$("#loginFooter").css("height", BodyHeight - LoginHeaderHeight);
$("#loginFooter").css("height", "615px");
if(ButtonMargin > 0) {
	$("#loginButton").css("margin-top", ButtonMargin);
} else {
	$("#loginButton").css("margin-top", 0);
}
//# 헤더메뉴 오픈
$("#header-menu").on("click", function() {
	header_menu()
});
function header_menu () {
	if(my_id !='') {
		$("#loginBody").css("display",'');
		$("#loginFooter").css("display",'none');
	}
	$("#nonMymenu").hide();
	open_menu();	
}
$("#loginOverlayClose, #maybeNexttime").on("click", function() {
	close_social_login();
	close_menu();
	$("#goLoginOverlay").removeClass("active");
	$("#nonMymenu").show();	
});
$("#loginOverlay").on("click", function() {
	close_menu();
	$("#nonMymenu").show();
});
$("#loginButton").on("click", function() {
	social_login();
});
$("#login").on("click", function() {
	$("#LayoutLogForm").submit();
});
$(window).resize(function() {
	//alert(1);
    $('#myMenuOverlay').height($(window).height());
    //$(document.body).height("100");
});
/*mymenu list */
var getMymenuList = function(submode, detailmode) {
	close_menu();
	//alert(1);
	submode    = submode    || '';
	detailmode = detailmode || '';
	//console.log([submode,detailmode]);
	
	if($("#myMenuOverlay").length <= 0) { 
		//alert(2);
		$(document.body).append('<div id="myMenuOverlay"></div>');
	}
	$("#myMenuOverlay").load('/?mod=mymenu&submode='+submode+'&detailmode='+detailmode+'&load=Y');
	setMymenuTitle(submode,detailmode);
	$(window).resize();
	window.scrollTo(0, 0);
}

// 마이메뉴 모달 오픈 
$('[data-role="mymenu-item"]').on('click',function(e){
	e.preventDefault();
	var modal=$('#modal-mymenu');
    var submode=$(this).data('menu');
    var detailmode='';
	var title=getMyMenuTitle(submode,detailmode);
    var url='/?mod=mymenu&submode='+submode;
    $(modal).find('.content').load('/?mod=mymenu&submode='+submode+'&detailmode='+detailmode+'&load=Y');
    $('#modal-mymenu').modals({
       title : title,
       url : url
    }); 
})

var close_menu_body = function() {
	$("#myMenuOverlay").remove();
	$("#myMenuOverlay").remove();
}
/*mymenu end */
var open_menu = function() {
	$("#loginOverlay").addClass("active").css("height", 994);
	console.log($("#loginOverlay").height());
	$("#loginPanel").addClass("active").css("height", 992);
};
var scroll_stop = function() {
	$(window).scroll(function() {
		console.log([$(window).scrollTop(), $(window).height(), $(document).height(), BodyHeight]);
		if($(window).scrollTop() + $(window).height() >= BodyHeight) {
			//$("body").scrollTop(230);
		}
	});
};
var close_menu = function() {
	close_panel();
	$("#loginOverlay").css("height", 0);
	//console.log(1);
	$("#loginOverlay").removeClass("active");
};
var close_panel = function() {
	if($("#loginPanel").hasClass("active")) {
		$("#loginPanel").removeClass("active");
	}
};
var social_login = function(sel) {
	close_panel();
	$("#loginOverlay").addClass("active").css("height", 994);
	$("#loginViaSocial").addClass("active");
};
var close_social_login = function(sel) {
	open_menu();
	$("#loginViaSocial").removeClass("active");
};
var test1 = function() {
	alert(1);
}
/*
$(window).scroll(function() {
   //if($(window).scrollTop() + $(window).height() == $(document).height()) {
   console.log([$(window).scrollTop(), $(window).height(), $(document).height(), BodyHeight]);
   if($(window).scrollTop() + $(window).height() == $(document).height()) {
       alert("bottom!");
       // getData();
   }
});	
function getData() {
    $.getJSON('Get/GetData?no=1', function (responseText) {
        //Load some data from the server
    })
};
*/
// 디바이스 정보 업데이트 
function updateDevice(datas){
    var dts = $.parseJSON(datas);
    var regid = dts.regid;
    var uuid  = dts.uuid;
    var dev   = dts.dev;
    var memberuid='<?php echo $my['uid']?>';
    $.post(rooturl+'/?r='+raccount+'&m=golf&a=setMemberDeviceid',{
        memberuid : memberuid,
        token : regid,
        deviceid : uuid,
        dev : dev
	},function(response){
	
	}); 
    
}
// 디바이스 체크 함수  
function checkDevice(datas){
    var dts = $.parseJSON(datas);
    var now_device_id  = dts.uuid;
    var my_device_id='<?php echo $my['deviceid']?>';
    
    if(my_device_id=='') getUuid("updateDevice"); // deviceid 가 없는 경우 
    else {
        if(my_device_id!=now_device_id) getUuid("updateDevice"); // 기존 diviceid 값과 다른 경우 
    } 
}
function resultFail(){
   alert('fail');
}
function getUuid(_succFn){
   var param = {
      succFn : _succFn // Succ Fn name
   };
   Hybrid.exe('HybridIf.getUuid', param);
}
// 디바이스 세팅 함수 
function setUuid(_succFn){
   var param = {
      succFn : _succFn // Succ Fn name
   };
   Hybrid.exe('HybridIf.getUuid', param);
}
<?php if($my['uid']):?>
setUuid("checkDevice"); // 디바이스 체크함수를 호출
<?php endif?>
</script>

<!-- 마이메뉴 load 할때 타이틀 세팅 스크립트 추가 -->
<script>
var getMyMenuTitle=function(submode,detailmode) {
    var title;

	if(submode == 'friends') title="친구";
	else if(submode == 'game') title="나의경기";
	else if(submode == 'game.view') title="나의경기";
	else if(submode == 'saving') title="적립현황";
	else if(submode == 'wishlist') title="찜내역";
	else if(submode == 'coupon') title="나의 쿠폰보기";
	else if(submode == 'review' || submode == 'review.rounge.view' || submode == 'review.myteam.view') title="리뷰쓰기";
	else if(submode == 'bill') title="결제현황";
	else if(submode == 'timeline') title="타임라인";
	else if(submode == 'setting') title="설정하기";
	else if(submode == 'setting.profile') title="설정하기";
	else if(submode == 'manager' 
		|| 	submode == 'manager.schedule.rounge'
		|| 	submode == 'manager.schedule.time'
		|| 	submode == 'manager.request'
		||  submode == 'manager.confirm'
		||  submode == 'manager.cancel') {
		title="매니져";
	}

	return title;	

}
</script>

