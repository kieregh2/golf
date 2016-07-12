<?php
//echo $_SERVER["REQUEST_URI"];
/*
if($_SERVER["REQUEST_URI"] === "/") {
	header("Location: http://".$_SERVER["HTTP_HOST"]."/?mod=rounge");
	exit;
}
*/
header("Content-type:text/html;charset=utf-8");
define('__KIMS__',true);
error_reporting(E_ALL ^ E_NOTICE);

session_save_path('./_tmp/session');
session_start();

ini_set('error_reporting',E_ALL & ~E_NOTICE ); // E_ALL | E_STRICT 최고수준의 에러보고 
ini_set("display_errors", 1);


if(!get_magic_quotes_gpc())
{
	if (is_array($_GET))
		foreach($_GET as $_tmp['k'] => $_tmp['v'])
			if (is_array($_GET[$_tmp['k']]))
				foreach($_GET[$_tmp['k']] as $_tmp['k1'] => $_tmp['v1']) 
					$_GET[$_tmp['k']][$_tmp['k1']] = ${$_tmp['k']}[$_tmp['k1']] = addslashes($_tmp['v1']); 
			else $_GET[$_tmp['k']] = ${$_tmp['k']} = addslashes($_tmp['v']);
	if (is_array($_POST))
		foreach($_POST as $_tmp['k'] => $_tmp['v'])
			if (is_array($_POST[$_tmp['k']]))
				foreach($_POST[$_tmp['k']] as $_tmp['k1'] => $_tmp['v1']) 
					$_POST[$_tmp['k']][$_tmp['k1']] = ${$_tmp['k']}[$_tmp['k1']] = addslashes($_tmp['v1']);
			else $_POST[$_tmp['k']] = ${$_tmp['k']} = addslashes($_tmp['v']);
}
else {
	if (!ini_get('register_globals'))
	{
		extract($_GET);
		extract($_POST);
	}
}

$d = array();
$g = array(
	'path_root'   => './',
	'path_core'   => './_core/',
	'path_var'    => './_var/',
	'path_tmp'    => './_tmp/',
	'path_layout' => './layouts/',
	'path_module' => './modules/',
	'path_widget' => './widgets/',
	'path_switch' => './switchs/',
	'path_page'   => './pages/',
	'path_file'   => './files/',
	'sys_lang'    => 'korean'
);

$g['time_split'] = explode(' ',microtime());
$g['time_start'] = $g['time_split'][0]+$g['time_split'][1];

if (is_file($g['path_var'].'db.info.php'))
{
	require $g['path_module'].'admin/var/var.system.php';
	$g['url_file'] = str_replace('/index.php','',$_SERVER['SCRIPT_NAME']);
	$g['url_host'] = 'http'.($_SERVER['HTTPS']=='on'?'s':'').'://'.$_SERVER['HTTP_HOST'];
	$g['url_http'] = $g['url_host'].($d['admin']['http_port']!=80?':'.$d['admin']['http_port']:'');
	$g['url_sslp'] = 'https://'.$_SERVER['HTTP_HOST'].($_SERVER['HTTPS']!='on'&&$d['admin']['ssl_port']?':'.$d['admin']['ssl_port']:'');
	$g['url_root'] = $g['url_http'].$g['url_file'];
	$g['ssl_root'] = $g['url_sslp'].$g['url_file'];
	
	require $g['path_var'].'db.info.php';
	require $g['path_var'].'table.info.php';
	require $g['path_var'].'switch.var.php';
	require $g['path_core'].'function/db.mysql.func.php';
	require $g['path_core'].'function/sys.func.php';
	foreach(getSwitchInc('start') as $_switch) include $_switch;
	require $g['path_core'].'engine/main.engine.php';
}
else $m = 'admin';

if ($keyword)
{
	$keyword = trim($keyword);
	$_keyword= stripslashes(htmlspecialchars($keyword));
}
if (!$p) $p = 1;
if (!is_dir($g['path_module'].$m)) $m = $g['sys_module'];
if (!is_dir($g['path_module'].$m.'/lang.'.$_HS['lang'])) $_HS['lang']=$g['sys_lang'];
$g['dir_module'] = $g['path_module'].$m.'/';
$g['url_module'] = $g['s'].'/modules/'.$m;
$g['img_module'] = $g['url_module'].'/image';
$g['add_module'] = $g['dir_module'].'_main.php';

if (is_file($g['add_module'])) include $g['add_module'];
if ($a) require $g['path_core'].'engine/action.engine.php';
if ($_HS['open'] > 1) require $g['path_core'].'engine/siteopen.engine.php';
if (!$s && $m != 'admin') getLink($g['s'].'/?r='.$r.'&m=admin&module='.$g['sys_module'].'&nosite=Y','','','');

include $g['dir_module'].'main.php';

if ($m=='admin' || $iframe=='Y') $d['layout']['php'] = $_HM['layout'] = '_blank/main.php';
else {
	if (!$g['mobile']||$_SESSION['pcmode']=='Y') $d['layout']['php'] = $prelayout ? $prelayout.'.php' : ($_HM['layout'] ? $_HM['layout'] : $_HS['layout']);
	else $d['layout']['php'] = $prelayout ? $prelayout.'.php' : ($_HS['m_layout'] ? $_HS['m_layout'] : ($_HM['layout'] ? $_HM['layout'] : $_HS['layout']));
}

$d['layout']['dir'] = dirname($d['layout']['php']);
$d['layout']['str'] = str_replace('.php','',$d['layout']['php']);
$d['layout']['pwd'] = $g['path_layout'].$d['layout']['str'];
$d['layout']['var'] = $g['path_layout'].$d['layout']['dir'].'/_main.php';

$g['url_layout'] = $g['s'].'/layouts/'.$d['layout']['dir'];
$g['img_layout'] = $g['url_layout'].'/image';
if (is_file($d['layout']['var'])) include $d['layout']['var'];
define('__KIMS_CONTENT__',$g['path_core'].'engine/content.engine.php');
define('__KIMS_CONTAINER_HEAD__',$g['path_core'].'engine/container_head.engine.php');
define('__KIMS_CONTAINER_FOOT__',$g['path_core'].'engine/container_foot.engine.php');
foreach($g['switch_1'] as $_switch) include $_switch;
if ($m!='admin'){include $g['path_var'].'sitephp/'.$_HS['uid'].'.php';if($_HS['buffer']){$g['buffer']=true;ob_start('ob_gzhandler');}}

?>

	<!DOCTYPE html>
	<html lang="<?php echo $lang['sys']['lang']?>">
	<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<?php if($g['mobile']&&$_SESSION['pcmode']!='Y'&&$_HS['m_layout']):?>
	<!-- <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no, target-densitydpi=medium-dpi" />-->
	<!-- <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no" /> -->
	<meta name="viewport" content="width=device-width" />
	<meta name="apple-mobile-web-app-capable" content="no" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<?php endif?>
	<title>골프치러가자</title>

	<meta property="og:type" content="website">
	<meta property="og:url" content="http://<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>">
	<meta property="og:title" content="<?=($R['subject'])?$R['subject']:$R['name']?>">
	<meta property="og:description" content="<?=strip_tags($R['content'])?>">	
	<?php require $g['path_core'].'engine/cssjs.engine.php'?>
	</head>
	<body style='background:#f3f3f3;padding:0;margin:0;'>
	<?php if(!$d['admin']['hidepannel']&&$my['admin']&&!$iframe&&(!$g['mobile']||$_SESSION['pcmode']=='Y')):?>
	<?php include $g['path_var'].'language/'.$g['sys_selectlang'].'/_top.lang.php'?>
	<?php include $g['path_core'].'engine/adminbar.engine.php'?>
	<?php endif?>


  <?php include $g['path_layout'].$d['layout']['php']?>


	<?php if($g['mobile']&&$_SESSION['pcmode']=='Y'&&$iframe!='Y'):?>
	<div id="pctomobile"><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;a=mobilemode"><?php echo sprintf($lang['sys']['viewpcmode'],$m=='admin'?$lang['top']['adminmode']:$lang['top']['homepage'])?></a></div>
	<?php endif?>
	<div id="_box_layer_"></div>
	<div id="_action_layer_"></div>
	<div id="_hidden_layer_"></div>
	<div id="_overLayer_" class="hide"></div>
	<iframe name="_action_frame_<?php echo $m?>" width="0" height="0" style='display:none;' frameborder="0" scrolling="no"></iframe>
	<script type="text/javascript">
	//<![CDATA[
	//document.body.onclick = closeMemberLayer;
	//document.onkeydown = closeImgLayer;
	//]]>
	</script>
	<?php foreach($g['switch_3'] as $_switch) include $_switch?>
	<?php echo $_HS['footercode']?>
	<link type="text/css" rel="stylesheet" charset="utf-8" href="/layouts/mobile/_rc/rc.css"/>
	</body>
	</html>
	<?php foreach($g['switch_4'] as $_switch) include $_switch?>
	<?php if($g['widget_cssjs']) include $g['path_core'].'engine/widget.cssjs.php'?>
	<?php if($g['buffer']) ob_end_flush()?>


