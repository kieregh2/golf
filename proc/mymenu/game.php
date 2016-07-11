<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/proc/global/global.php';

$sort	  = 'rjm.rdate';
$orderby  = $orderby ? $orderby : 'desc';
$recnum	  = $recnum && $recnum < 301 ? $recnum : 9;
//$addwhere = " rjm.mbr_id = '".$my['uid']."'";

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

//echo $sql;

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
           <div class="matching-game-list">
                    <div class="list-row">
	<?php while($R=mysql_fetch_assoc($RCD)):?> 
	<?php 

	if($my['uid']) {
		$goHref = "goHref('/?mod=mymenu&submode=game&detailmode=view');";
	} else {
		$farow = array();
		$goHref = "getLogin()";
	}
	
	$R['img'] = ($R['img'])?$R['img']:'/images/grn.png';

	?>

                        <div class="list-row-3d">
                            <div class="game-box" id="my-game-list" join_id="<?=$R['join_id']?>">
                                <div class="game-box-image">
                                    <div class="game-box-overlay" style="display: none;">
                                        종료된 <br/>
                                        경기입니다. <br/>
                                        (결과 : <span class="hit-count blue-ft">50</span>타)
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


<script>
$("div#my-game-list.game-box").on("click", function() {
	var sel       = $(this);
	var join_id = sel.attr("join_id");

	location.href = "/?mod=mymenu&submode=game&detailmode=view&join_id="+join_id;

});

</script>

	
		






