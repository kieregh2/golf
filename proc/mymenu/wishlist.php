<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/proc/global/global.php';

/*
$sql      = "select *,
				sgd.uid as ground_uid,
				rjj.uid as join_uid
			from s_ground_data as sgd
		
			inner join rb_join_join as rjj
				on sgd.uid = rjj.rounge_id
				and rjj.room_type in ('J','E','B','M')
				and rjj.confirm_type in ('W','R','C','E')

			inner join rb_s_wish as rsw
				on rjj.uid = rsw.wish_uid
				and rsw.mbr_uid = '".$my['uid']."'";

*/

$sql      = "select wish_uid,w_type from rb_s_wish where mbr_uid = '".$my['uid']."' and w_type !='F'";

$RCD      = mysql_query($sql) or die(mysql_error());

?>

	<?php while($R=mysql_fetch_assoc($RCD)):?> 
	<?php 

	if($my['uid']) {
		$review   = mysql_fetch_assoc(mysql_query("select avg(eval) as eval from rb_join_review where join_uid='".$R['wish_uid']."'"));
		

		// F가 친구이나 위시리스트에 프로파일페이지를 넣는게 좀 이상함.. 검토필요.
		$join   = mysql_fetch_assoc(mysql_query("select *,
														sgd.uid as ground_uid,
														rjj.uid as join_uid
													from s_ground_data as sgd
												
													inner join rb_join_join as rjj
														on sgd.uid = rjj.rounge_id
														and rjj.uid = '".$R['wish_uid']."'
														and rjj.confirm_type in ('W','R','C','E')"));


		
													/*where rjj.uid = '".$R['wish_uid']."'"));*/

		$goHref = "goHref('/?mod=mymenu&submode=friends&amode=".$submode."&uid=".$R['join_uid']."');";
	} else {
		$farow = array();
		$goHref = "getLogin()";
	}
	
	$R['img'] = ($R['img'])?$R['img']:'/images/grn.png';

	?>

	<div class="normal-input">
		<div class="layout-left" style="width: 300px;">
			<span class="favorite-place">[경기]</span><span class="favorite-resortname"  room_type="<?=$join['room_type']?>" wish_uid="<?=$R['wish_uid']?>"><?=$join['name']?></span>
		</div>
		<div class="layout-right">
			<div class="alignright">
			<?php
			for($i=0;$i < abs($review['eval']); $i++) {
			?>
			<span class="icon icon-star"></span>
			<?php 
			}
			?>
			<?php
			for($i=0;$i < 5-abs($review['eval']); $i++) {
			?>
			<span class="icon icon-star-notrated"></span>
			<?php 
			}
			?>
			</div>
			<div class="alignright">
			<h5 class="gray-ft font14 bold"><?=number_format($join['cash'])?></h5>
			</div>
		</div>
	</div>

	<?php endwhile?>

<script>
$("span.favorite-resortname").on("click", function() {
	var sel       = $(this);
	var room_type = sel.attr("room_type");
	var wish_uid  = sel.attr("wish_uid");

	switch(room_type) {

		case 'J':
			location.href = "/?mod=rounge&submode=view&uid="+wish_uid;
		break;
		 
		case 'E':
			location.href = "/?mod=event&submode=view&uid="+wish_uid;
		break;
		 
		case 'M':
			location.href = "/?mod=matching&submode=view&uid="+wish_uid;
		break;
		 
		case 'B':
			location.href = "/?mod=booking&submode=view&uid="+wish_uid;
		break;
		
		default:
		break;

	}
});	
</script>

	
		






