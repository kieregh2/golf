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
<style>
.overflow-auto {overflow:auto;height:98%;}
.overflow-hidden {overflow:hidden;}
#loginPanel {
    z-index: 21;
    -webkit-transition: all .25s;
    -o-transition: all .25s;
    transition: all .25s;
}
#loginPanel.active {
    z-index: 21;
    -webkit-transition: all .25s;
    -o-transition: all .25s;
    transition: all .25s;
}
#loginOverlay.active {z-index: 15 !important}
#loginViaSocial.active {z-index: 20 !important}
.affix {position: fixed;z-index: 10;width:100%;}
.affix-top, .affix-bottom {z-index: 10}
</style>
<!--메인 메뉴 padding-top 동적 세팅 --> 
<?php if($mod=='rounge'||!$mod):?>
<style>	
.affix {top:55px;}
#content .menu-strip.plainmode {padding-top:0px !important;margin-top: -1px !important;}
</style>
<?php else:?>
<style>	
.affix {top:43px;}
#content .menu-strip.plainmode {padding-top:12px !important;}
</style>
<?php endif?>	
<script type='text/javascript' src='/_core/js/jquery-ui/jquery-ui.min.js'></script>
<link type="text/css" rel="stylesheet" charset="utf-8" href="/_core/js/jquery-ui/jquery-ui.min.css"/>
<script type='text/javascript' src='/layouts/mobile/_rc/rc-min.js'></script>
<!--  script start -->
 
<script>
var areaList = <?=json_encode($areaList)?>;
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
function getMyMenuTitle(submode,detailmode) {
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
	else if(submode == 'premium') title="프리미엄 신청하기";
	else if(submode == 'vip') title="V.I.P 인증";
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
<iframe name='hiddemFramePaper' style='display:none;'></iframe>
<div id='_allLayoutBox_' style='background:#f3f3f3;'>
</div>
<!--  script end -->
	<div id="loginOverlay"></div>
	<div id="loginViaSocial" style="padding-top:70px;">
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
		<div id="loginHeader" style="position:fixed;width:92%;">
			<div id="loginInfomation">
				<img src="<?php echo getMyPicSrc($my['uid'])?>" id="loginThumbnail"/>
				<?if($my['uid']) :?>
				<h3>
					<?=$my['name']?><?=$my['vip']? '<span class="icon icon-tag-vip" data-role="mymenu-item" data-menu="vip"></span>':''?></span>
					<span class="margin-right" style="vertical-align:middle;">
						<img src="<?php echo $g['img_layout']?>/pre1.png" data-role="mymenu-item" data-menu="premium" style="height:20px;vertical-align:1px"/>
					</span>
				</h3>
				<h4><?=$my['id']?></h4>
				<!-- <h4><a href="/?r=home&a=logout">logout</a></h4>-->
				<? else :?>
				<h3>손님입니다.</span></h3>
				<h4>로그인/회원가입을 해주세요.</h4>
				<? endif?>
			</div>
		</div>
		<?if($my['uid']) :?>
		    <?php $ul_height=$my['sosok']==3?'1000':'950'?>
            <div id="loginBody" style="overflow-y:auto;position:fixed;top:300px;width:92%;height:700px;">
                <ul style="width:100%;height:<?php echo $ul_height?>px;">
                	<?php 
                	$myMenuListArray=array(
                		'game'=>array('나의 경기','golfer'),'friends'=>array('친구','friends'),
                	    'saving'=>array('적립현황','database'),'wishlist'=>array('찜 내역','heart-big'),
                	    'coupon'=>array('나의 쿠폰보기','coupon'),'review'=>array('리뷰쓰기','pen'),
                	    'bill'=>array('결제현황','wallet'),'timeline'=>array('타임라인','timeline'),
                	    'setting'=>array('설정하기','config')
                	);
                	?>
                	<?php foreach($myMenuListArray as $item => $name_icon):?>
                	<?php $name=$name_icon[0];$icon=$name_icon[1]?>
                    <li>
                    	<a class="fill-up-space" href="#" data-role="mymenu-item" data-menu="<?php echo $item?>">
                            <span class="loginicon icon-<?php echo $icon?>"></span><span class="normal-text"><?php echo $name?></span>
                        </a>                        
                    </li>
                    <?php endforeach?>
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
		<div id="loginFooter" style="position:fixed;top:300px;text-align:center;width:92%;height:700px">
			<span id="loginButton" style="width:78%;">
				로그인
			</span>
		</div>
		<? endif?>
	</div>
<?
$submode = (!empty($submode))? $submode:'list';
if(($submode == 'list' && $mod != 'mymenu' || $submode == 'search_list' || $submode == 'ranking_all') && $m!='member') { ?>	
	<header class="fix" style="position:fixed;top:0;width:100%;z-index:11;background:#fff;">
		<div id="">
			<span id="header-menu"></span>
			<span id="header-title"></span>
		</div>
	</header>
<? }?>	
<!-- ################ 상단 타이틀 바를 fixed 로 해서 content 영역의 margin-top 동적 적용 by 김영주 2016.7.16 ################################# -->
<?php
// mod & submode 기준 컨텐트 영역 margin-top 세팅 
$contentMarginTop='';
if($mod=='rounge'||!$mod){
   if($m=='member') $contentMarginTop=0;
   else{
   	  if($submode=='list') $contentMarginTop=37;
      else $contentMarginTop=0;
   } 	
}
else if($mod=='booking'|| $mod=='matching'||$mod=='event'){
   if($submode=='list' || $submode=='ranking_all') $contentMarginTop=43;
   else $contentMarginTop=0;	
}
else if($mod=='mymenu') $contentMarginTop=78;
?>
<div id="nonMymenu" style="margin-top:<?php echo $contentMarginTop?>px;"> 
    <?php require_once __KIMS_CONTENT__ ?>
</div>
<!-- ####################################################### 모달 모음 ################################################--> 
<!--mymenu 모달 -->
<div class="modal effect-scale" id="modal-mymenu">
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
<!--intro 모달 -->
<div class="modal effect-scale" id="modal-intro">
  <?php include $g['path_page'].'main_mobile.php';?>
</div>
<!-- intro_close 세션값 체크해서 인트로를 한 번만 보여주기 -->
<?php if(!$_SESSION['intro_close'] || $_SESSION['intro_close']!=session_id()):?>
<script type="text/javascript">
    $('#modal-intro').modals({
	  	history : false
	});
</script>
<?php endif?>
<script>  
// 인트로 모달 닫을 때 현재 세션아이디를 세션에 저장 
$('#modal-intro').on('hidden.rc.modal',function(){
	$.post(rooturl+'/?r='+raccount+'&m=golf&a=regiIntroCloseToSession',{
    },function(response){
	
	});      
});
// 소셜 로그인 실행  
$(document).on('click','[data-role="social-login"]',function(){
    var connectUrl=$(this).data('connect');
    //frames._action_frame_slogin.location.href = connectUrl;
    location.href = connectUrl;
});
var my_id = '<?=$my['uid']?>';
var BodyHeight = $("body").height();
var LoginHeaderHeight = $("#loginHeader").height();
var ButtonMargin = ((window.outerHeight - LoginHeaderHeight) / 2) - 100;
$("#loginPanel").css("height", BodyHeight);
//$("#loginFooter").css("height", BodyHeight - LoginHeaderHeight);
//$("#loginFooter").css("height", "615px");
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
// 공통으로 사용 : 모달 오픈시 & 좌측메뉴 열고 닫을 때 
var mymenu_modal=$('#modal-mymenu');
// 마이메뉴 모달 오픈 
$('[data-role="mymenu-item"]').on('click',function(e){
	e.preventDefault();
    var submode=$(this).data('menu');
    var detailmode='';
	var title=getMyMenuTitle(submode,detailmode);
    var url='/?mod=mymenu&submode='+submode;
    $(mymenu_modal).find('.content').load('/?mod=mymenu&submode='+submode+'&detailmode='+detailmode+'&load=Y');
    $(mymenu_modal).modals({
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
	$("#loginPanel").addClass("active").css("height", 992);
	// 백그라운드 content 의 scroll 환경 제거 
	$('body').removeClass('overflow-auto').addClass('overflow-hidden');
    $('#loginBody').scrollTop(0); 	
    $('#loginFooter').scrollTop(0);
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
	$("#loginOverlay").removeClass("active");
	// 백그라운드 content 의 scroll 환경 복구  
     $('body').removeClass('overflow-hidden').addClass('overflow-auto');
	//$('.section-body').scrollTop()=0; 
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
// 디바이스 정보 업데이트 
function updateDevice(datas){
    var dts = $.parseJSON(datas);
    var regid = dts.regid;
    var uuid  = dts.uuid;
    var dev   = dts.dev;
    var memberuid='<?php echo $my['uid']?>';
	localStorage.setItem("deviceid",uuid);
	localStorage.setItem("token",regid);
	localStorage.setItem("dev",dev);
    
    //alert([regid, uuid, dev]);
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
    //alert([dts.uuid,dts.regid]);
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
// 초기실행 내용  
$(document).ready(function(){
     // 메인 메뉴 affix 적용을 위한 wrapping 
    var menu=$('.menu-strip');
    $(menu).css({'background-color':'#fff','z-index':10});
    var affix='<div data-control="scroll" data-type="affix" data-offset="70" >';
    $(menu).wrap(affix);
});
$(window).on('load', function () {
   // swiper 실행 
    RC_initSwiper(); 
})
</script>
