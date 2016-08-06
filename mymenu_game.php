<?php
$sort	  = 'rjj.join_time';
$orderby  = $orderby ? $orderby : 'desc';
$recnum	  = $recnum && $recnum < 301 ? $recnum : 10;
//$addwhere = " rjm.mbr_id = '".$my['uid']."'";
$p        = ($p)?$p:1;
$start    = ($p-1)*$recnum;
$sql      = "select *,
				sgd.uid as ground_uid,
				rjj.uid as join_uid,
				rjm.owner_id as owner_id
			from s_ground_data as sgd
			inner join rb_join_join as rjj
			on sgd.uid = rjj.rounge_id
			and rjj.room_type in ('J','M')
			and rjj.confirm_type in ('W','R','C','E')
		
			inner join rb_join_member rjm
			on rjj.uid = rjm.join_id
			and join_state in ('Y')		
			and rjm.mbr_id = '".$my['uid']."'
			order by $sort $orderby
			limit $start,$recnum";
//echo $sql;
$RCD      = mysql_query($sql) or die(mysql_error());
$NUM      = getDbRows("s_ground_data as sgd
						
						inner join rb_join_join as rjj
						on sgd.uid = rjj.rounge_id
						and rjj.room_type in ('J','M')
						and rjj.confirm_type in ('W','R','C','E')
					
						inner join rb_join_member rjm
						on rjj.uid = rjm.join_id
						and join_state in ('Y')
						and rjm.mbr_id = '".$my['uid']."'",$addwhere);
$lastpage = ceil($NUM / $recnum);
$roomTypeArr = array("J"=>"조인", "M"=>"매칭");
?>
<section class="section-body fix">
    <div id="content" class="fix">
        <div class="normal-background dim-gray-bg"  id="gameList">
             <div class="matching-game-list">
                 <div class="list-row">
	              	 <?php while($R=mysql_fetch_assoc($RCD)):?> 
					 <?php 
					 	$team = mysql_fetch_assoc(mysql_query("select count(*) as cnt from rb_join_member where join_id='".$R['join_id']."' and join_state='Y' "));
						if($my['uid']) $goHref = "goHref('/?mod=mymenu&submode=game&detailmode=view');";
						else {
						   $farow = array();
						   $goHref = "getLogin()";
						}
					    $R['img'] = ($R['img'])?$R['img']:'/images/grn.png';
					 ?>
	                <div class="list-row-3d">
	                    <div class="game-box" id="my-game-list" join_id="<?=$R['join_id']?>" room_type="<?=$R['room_type']?>" confirm_type="<?=$R['confirm_type']?>">
	                        <div class="game-box-image">
	                        	<?php if($R['confirm_type']=='E'):?>
	                            <div class="game-box-overlay">
	                                종료된 <br/>
	                                경기입니다. <br/>
	                                (결과 : <span class="hit-count blue-ft"><?php echo $R['handy']?></span>타)
	                            </div>
	                        	<?php elseif($R['confirm_type']=='C'):?>
	                            <div class="game-box-overlay">
	                                진행중인 <br/>
	                                경기입니다. <br/>
	                                <!-- (결과 : <span class="hit-count blue-ft"><?php echo $R['handy']?></span>타) -->
	                            </div>
	                            
	                        	<?php elseif(($R['confirm_type']=='W' || $R['confirm_type']=='R') && $R['owner_id'] != $my['uid']):?>
	                            <div class="game-box-overlay">
	                                회원님이 참여 대기중인 <?=$roomTypeArr[$R['room_type']]?>경기입니다. <br/>
	                                (현재 참여인원: <?=$team['cnt']?>명) <br/>
	                                <!-- (결과 : <span class="hit-count blue-ft"><?php echo $R['handy']?></span>타) -->
	                            </div>
	                            
	                        	<?php elseif( ($R['confirm_type']=='W' || $R['confirm_type']=='R') && $R['owner_id'] == $my['uid'] ):?>
	                            <div class="game-box-overlay">
	                                회원님이 개설 대기중인 <?=$roomTypeArr[$R['room_type']]?>경기입니다. <br/>
	                                (현재 참여인원: <?=$team['cnt']?>명) <br/>
	                                <!-- (결과 : <span class="hit-count blue-ft"><?php echo $R['handy']?></span>타) -->
	                            </div>
	                            <?php endif?>
	                            <img alt="resort-image" src="<?php echo $R['img']?>" />
	                        </div>
	                        <h3>[서울] <?=$R['name']?></h3>
	                        <h4><?=ddate('Md일(D)  , H시', strtotime($R['join_time']))?></h4>
	                    </div>
	                </div>
		            <?php endwhile?>
                </div>
            </div>            
        </div>
    </div>
</section>
<script>
var room_type_obj = {"J":"rounge", "M":"matching"};
var page          = <?=$p?>;
var lastpage      = <?=$lastpage?>; 
$(document).on("click", "div#my-game-list.game-box", function() {
	var sel          = $(this);
	var join_id      = sel.attr("join_id");
	var room_type    = sel.attr("room_type");
	var confirm_type = sel.attr("confirm_type");
	console.log(room_type_obj[room_type]);
	if(confirm_type =="W" || confirm_type =="R") {
		location.href    = "/?mod="+room_type_obj[room_type]+"&submode=view&uid="+join_id;
	}else{
		location.href    = "/?mod=mymenu&submode=game&detailmode=view&join_id="+join_id;
	}
});
$(window).scroll(function() {
	//console.log([$(window).scrollTop()]);
	if($(window).scrollTop() + $(window).height() == $(document).height()) {
		addFriendList();
	}
});
function addFriendList() {
	page++;
	console.log([page, lastpage]);
	if(lastpage < page) return false;
	$.post(rooturl+'/?r='+raccount+'&m=mymenu&a=add_game_list&p='+page,{
	},function(response){
		var result=$.parseJSON(response);
		console.log(result.sql);
		console.log(result.content);
		console.log(result.cnt);
	    $('#gameList .list-row').append(result.content);
	});
}
</script>
