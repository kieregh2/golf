<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/proc/global/global.php';


$sql      = "select *
				from rb_join_friends
			where mbr_uid='".$my['uid']."'";

//echo $sql;

$RCD      = mysql_query($sql) or die(mysql_error());

?>

	<?php while($R=mysql_fetch_assoc($RCD)):?> 
	<?php 

	if($my['uid']) {
		$friend = mysql_fetch_assoc(mysql_query("select name from rb_s_mbrdata where memberuid='".$R['friend_uid']."'")); 
		$goHref = "goHref('/?mod=mymenu&submode=friends&amode=".$submode."&uid=".$R['join_uid']."');";
	} else {
		$farow = array();
		$goHref = "getLogin()";
	}
	
	$R['img'] = ($R['img'])?$R['img']:'/images/grn.png';

	?>

	<div class="normal-input">
		<div class="layout-left" style="width: 250px;">
			<span class="checkbox-wrapper margin-right <?=(!empty($_SESSION['bucket_list'][$R['friend_uid']]))? 'checked':'';?>" uid='<?=$R['friend_uid']?>'></span><span class="circle-shape normal-image"></span><span class="normal-text font14 bold"><?=$friend['name']?></span>
		</div>
		<div class="layout-right alignright ">
			<span class="wire-button-gray font18" onclick="javascript:delFriend(<?=$R['friend_uid']?>);">친구끊기</span>
		</div>							
	</div>

	<?php endwhile?>

                
	<div class="normal-spacer"></div>
	<div class="normal-button <?=count($_SESSION['bucket_list']) > 3? 'blue-bg':'gray-bg'?>">부킹하기</div>


<script>
$("span.checkbox-wrapper.margin-right").on("click", function() {
	var sel       = $(this);
	var friend_id = sel.attr("uid");
	
	if($(this).hasClass("checked")) {
	 console.log("className checked");
	 delBucket(friend_id, sel);

	}  
	else {
	 console.log("className unchecked");
	 addBucket(friend_id, sel);

	}

});

function delFriend(mbr_uid) {
	if(!myuid) {
		alert('먼저 로그인하세요');
		return;
	}

	$.ajax({
		url:'/proc/proc.map.php',
		data:'mode=delFriend&mbr_uid='+mbr_uid,
	    dataType:'json',
		type:'post',
		success:function(dt) {
			if(dt.result.message == 'del') {
				location.reload();
			} else {
				alert('잘못된 접근입니다');
			}
		}
	});

};

function addBucket(friend_uid, sel) {
	if(!myuid) {
		alert('먼저 로그인하세요');
		return;
	}

	$.ajax({
		url:'/proc/proc.map.php',
		data:'mode=addBucket&friend_uid='+friend_uid,
	    dataType:'json',
		type:'post',
		success:function(dt) {
			console.log(dt.result.message);
 			if(dt.result.message == 'add') {
				sel.addClass("checked");
				//location.reload();
				console.log(dt.result.count);
				if(dt.result.count > 3) {
					//location.reload();
					console.log('blue');
					$(".normal-button").removeClass("gray-bg").addClass("blue-bg");
				} else {
					console.log('gray');
					$(".normal-button").removeClass("blue-bg").addClass("gray-bg");

				}

			} else if(dt.result.message == 'manlimit') {
				alert('부킹리스트에 4명까지 넣을 수 있습니다.');
				sel.removeClass("checked");
			}

		}
	});

};

function delBucket(friend_uid, sel) {
	if(!myuid) {
		alert('먼저 로그인하세요');
		return;
	}

	$.ajax({
		url:'/proc/proc.map.php',
		data:'mode=delBucket&friend_uid='+friend_uid,
	    dataType:'json',
		type:'post',
		success:function(dt) {
			console.log(dt.result.message);
 			if(dt.result.message == 'delete') {
				sel.removeClass("checked");
				//location.reload();
				console.log(dt.result.count);
				if(dt.result.count < 4) {

					$(".normal-button").removeClass("blue-bg").addClass("gray-bg");
					console.log('gray');
				} else {
					console.log('blue');
					$(".normal-button").removeClass("gray-bg").addClass("blue-bg");

				}

			} else if(dt.result.message == 'noman') {
				sel.removeClass("checked");
				alert('선택된 친구가 없습니다.');
			}

		}
	});

};

	
</script>

	
		






