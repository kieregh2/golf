<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/proc/global/global.php';

$sort	  = 'rdate';
$orderby  = $orderby ? $orderby : 'desc';
$recnum	  = $recnum && $recnum < 301 ? $recnum : 10;
$addwhere = "to_mbr_uid='".$my['uid']."'";

$p        = ($p)?$p:1;
$start    = ($p-1)*$recnum;

$sql      = "select *
				from rb_join_push
			where ".$addwhere." 
			order by $sort $orderby 
			limit $start,$recnum";

$RCD      = mysql_query($sql) or die(mysql_error());

$NUM      = getDbRows('rb_join_push',$addwhere);
$TPG      = getTotalPage($NUM,$recnum);

?>
                <div class="timeline-history">

	<?php while($R=mysql_fetch_assoc($RCD)):?> 
	<?php 

	if($my['uid']) {
		$friend = mysql_fetch_assoc(mysql_query("select name from rb_s_mbrdata where memberuid='".$R['from_mbr_uid']."'")); 
		$goHref = "goHref('/?mod=mymenu&submode=friends&amode=".$submode."&uid=".$R['join_uid']."');";
	} else {
		$farow = array();
		$goHref = "getLogin()";
	}
	
	$R['img'] = ($R['img'])?$R['img']:'/images/grn.png';
	?>

                    <div class="timeline-item">
                        <span class="circle-shape normal-image x40 margin-right"></span>
                        <span class="timeline-type"></span>
                        <span class="normal-text"></span> 
                        <span class="normal-text blue-ft"></span>
                        <span class="normal-text"><?=$R['content']?></span>
                    </div>
                    <!--
                    <div class="timeline-item">
                        <span class="circle-shape normal-image x40 margin-right"></span>
                        <span class="normal-text">신청하신</span>
                        <span class="timeline-type">[부킹예약]</span>
                        <span class="normal-text">이</span>
                        <span class="normal-text blue-ft">취소</span>
                        <span class="normal-text">되었습니다.</span>
                    </div>
                    <div class="timeline-item">
                        <span class="circle-shape normal-image x40 margin-right"></span>
                        <span class="timeline-type">[홍길동님]</span><span class="normal-text">이 경기에</span>
                        <span class="normal-text blue-ft">조인</span>
                        <span class="normal-text">하고 싶어합니다.</span>
                    </div>
                    -->
	<?php endwhile?>

                </div>



<script>
$("span.checkbox-wrapper.margin-right").on("click", function() {
	var sel       = $(this);
	var friend_id = sel.attr("uid");
	

});

</script>

	
		






