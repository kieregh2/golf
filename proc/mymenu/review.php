<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/proc/global/global.php';

$sort	  = 'rjm.rdate';
$orderby  = $orderby ? $orderby : 'desc';
$recnum	  = $recnum && $recnum < 301 ? $recnum : 9;


$p        = ($p)?$p:1;
$start    = ($p-1)*$recnum;

$sql      = "select *,
				sgd.uid as ground_uid,
				rjj.uid as join_uid
			from s_ground_data as sgd

			inner join rb_join_join as rjj
			on sgd.uid = rjj.rounge_id
			and rjj.room_type = 'J'
			and rjj.confirm_type in ('C','E')
		
			inner join rb_join_member rjm
			on rjj.uid = rjm.join_id
			and join_state in ('Y')		
			and rjm.mbr_id = '".$my['uid']."'

			order by $sort $orderby
			limit $start,$recnum";


$RCD      = mysql_query($sql) or die(mysql_error());

$NUM      = getDbRows("s_ground_data as sgd
						inner join rb_join_join as rjj
						on sgd.uid = rjj.rounge_id
						and rjj.room_type = 'J'
						and rjj.confirm_type in ('C','E')
					
						inner outer join rb_join_member rjm
						on rjj.uid = rjm.join_id
						and join_state in ('Y')
						and rjm.mbr_id = '".$my['uid']."'",$addwhere);
$TPG      = getTotalPage($NUM,$recnum);

?>

                <div class="btn-group btn-group-justified" role="group" aria-label="...">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn blue-bg bold font14" id="rounge_tab">골프장</button>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default bold font14" id="myteam_tab">우리팀</button>
                    </div>
                </div>
                <div class="tab-content-area">
                    <div class="matching-game-list">
                        <div class="list-row">
	<?php while($R=mysql_fetch_assoc($RCD)):?> 
	<?php 

	if($my['uid']) {
		//$friend = mysql_fetch_assoc(mysql_query("select name from rb_s_mbrdata where memberuid='".$R['friend_uid']."'")); 
		$goHref = "goHref('/?mod=mymenu&submode=friends&amode=".$submode."&uid=".$R['join_uid']."');";
	} else {
		$farow = array();
		$goHref = "getLogin()";
	}
	
	$R['img'] = ($R['img'])?$R['img']:'/images/grn.png';

	?>


                            <div class="list-row-3d">
                                <div  id="my-game-list" join_id="<?=$R['join_uid']?>" class="game-box">
                                    <div class="game-box-image">
                                        <div class="game-box-overlay" <?=$R['confirm_type'] =='E'? '':'style="display: none;"';?>>
                                            종료된 <br />
                                            경기입니다. <br />
                                            (결과 : <span class="hit-count blue-ft"><?=$R['handy']?></span>타)
                                        </div>
                                        <img alt="resort-image" src="img/banner.png" />
                                    </div>
	                                <h3>[서울] <?=$R['name']?></h3>
	                                <h4><?=ddate('Md일(D)  , H시', strtotime($R['join_time']))?></h4>
                                </div>
                            </div>


	<?php endwhile?>
                        </div>
                    </div>
                </div>



<script>
$("div#my-game-list.game-box").on("click", function() {
	var sel     = $(this);
	var join_id = sel.attr("join_id");

	var tab_name= $("#rounge_tab").hasClass("blue-bg")? "rounge.view":"myteam.view"; 

	location.href = "/?mod=mymenu&submode=review&detailmode="+tab_name+"&join_id="+join_id;

	//$("button.btn.btn-default.bold.font14")
	//$("button.btn.blue-bg.bold.font14")
});

$("#rounge_tab").on("click", function() {
	$(this).removeClass("btn-default").addClass("blue-bg");
	$("#myteam_tab").removeClass("blue-bg").addClass("btn-default");

});

$("#myteam_tab").on("click", function() {
	$(this).removeClass("btn-default").addClass("blue-bg");
	$("#rounge_tab").removeClass("blue-bg").addClass("btn-default");

});


</script>


	
		






