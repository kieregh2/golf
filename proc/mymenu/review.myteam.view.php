<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/proc/global/global.php';
$areaList=getArea();
if(!$my['uid'] || !$join_id) {
	getLink('back','','잘못된 접근입니다','');
}


$sql      = "select *,
				sgd.uid as ground_uid,
				rjj.uid as join_uid
			from s_ground_data as sgd

			inner join rb_join_join as rjj
			on sgd.uid = rjj.rounge_id
			and rjj.uid = '".$join_id."'
			and rjj.room_type = 'J'
			and rjj.confirm_type in ('C','E')

			inner join rb_join_member rjm
			on rjj.uid = rjm.join_id
			and join_state in ('Y') ";


//echo $sql;

$RCD      = mysql_query($sql);

/*
if(!$RCD['join_uid']) {
	getLink('back','','잘못된 접근입니다','');
	
}
*/

?>

            <div class="normal-background dim-gray-bg">
                <div class="review-ratings">
	<?php while($R=mysql_fetch_assoc($RCD)):?> 
	<?php 

	if($my['uid']) {
		$friend = mysql_fetch_assoc(mysql_query("select name from rb_s_mbrdata   where memberuid='".$R['mbr_id']."'")); 
		$eval   = mysql_fetch_assoc(mysql_query("select eval
													from rb_join_review
													where join_uid='".$join_id."'
													and mbr_uid='".$my['uid']."'
													and team_mbr_uid='".$R['mbr_id']."'
													and r_type='T' "));
		//$goHref = "goHref('/?mod=mymenu&submode=friends&amode=".$submode."&uid=".$R['join_uid']."');";
	} else {
		$farow = array();
		$goHref = "getLogin()";
	}
	
	if($R['mbr_id'] == $my['uid']) continue;
	
	$R['img'] = ($R['img'])?$R['img']:'/images/grn.png';
	if(empty($eval['eval'])) $eval['eval'] = 1; 
	?>

                    <div class="review-rating-item">
                        <div class="layout-left" style="width: 140px;">
                            <span class="circle-shape normal-image x120"></span>
                        </div>
                        <div class="layout-right">
                            <h3 class="aligncenter natual-element font14 bold"><?=$friend['name']?></h3>
                            <div class="a-line"></div>
                            <div class="aligncenter" mbr_uid="<?=$R['mbr_id']?>">
                            	<?php for($i=1; $i < 6;$i++) {
                            	?>
                                <span id="star_rating_<?=$i?>" rating="<?=$i?>" class="icon icon-start-biggest <?=($i <= $eval['eval'])? '':'notrated';?>"></span>

                            	<?
								}
								?>
                            </div>

                            
                        </div>
                    </div>                 


                            
                           

	<?php endwhile?>
                </div>
            </div>

<script>
var join_uid         = '<?=$join_id?>';
var ground_uid       = '<?=$ground_uid?>';


$("div.aligncenter span").each(function () {
	var $rating_obj = $(this);
	var final_eval  = 0;
	var star_count  = 6;
	
	$rating_obj.click(function() {
		var eval 		    = $rating_obj.attr("rating");
		var star_rating     = "star_rating_";

		if(final_eval <= eval) $rating_obj.removeClass("notrated");
		if($rating_obj.hasClass("notrated")) eval = eval -1;
		
		//console.log(["2",final_eval, eval]);

		for(i=1;i < star_count+1 ;i++) {
			if(i <= eval) $rating_obj.parent().find("[id='star_rating_"+i+"']").removeClass("notrated");
			else $rating_obj.parent().find("[id='star_rating_"+i+"']").addClass("notrated");
		}

		
		//console.log(["3", final_eval, eval]);
		final_eval = eval;


		if(final_eval == 0) {
			$(star_rating+"1").removeClass("noncheck");
			final_eval = 1;
		}

		//# 친구 리뷰 저장
		$.ajax({url:'/proc/proc.map.php',
			data: { mode : "writeFriendReview",
					join_uid : join_uid,
					ground_uid : ground_uid,
					eval : final_eval,
					team_mbr_uid : $rating_obj.parent().attr("mbr_uid")
				},
		    dataType:'json',
			type:'post',
			success:function(dt) {
		
				console.log(dt.result);

				if(dt.result.message == 'reviewWriteOk') {
					alert('리뷰평가가 저장됐습니다.');
					//location.href = "/?mod=rounge&submode=view&uid="+join_id;
						
				} else {
					alert(dt.result.message);
				}

			}
		});

		//console.log(final_eval);

	});
});

 


</script>

	
		






