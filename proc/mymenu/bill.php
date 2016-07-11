<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/proc/global/global.php';


$sort	  = 'rdate';
$orderby  = $orderby ? $orderby : 'desc';
$recnum	  = $recnum && $recnum < 301 ? $recnum : 10;
$addwhere = "memberuid='".$my['uid']."'";

$p        = ($p)?$p:1;
$start    = ($p-1)*$recnum;

$sql      = "select *
				from s_payment_data
			where ".$addwhere." 
			order by $sort $orderby 
			limit $start,$recnum";  
$RCD      = mysql_query($sql) or die(mysql_error());

$NUM      = getDbRows('rb_join_push',$addwhere);
$TPG      = getTotalPage($NUM,$recnum);


?>

                <div class="paid-status">
                    <div class="paid-sheet">
                        <table>
                            <thead>
                                <tr>
                                    <th>서비스명</th>
                                    <th>일시</th>
                                    <th>유효기간</th>
                                </tr>
                            </thead>
                            <tbody>
	<?php while($R=mysql_fetch_assoc($RCD)):?> 
	<?php 

	if($my['uid']) {

		$goHref = "goHref('/?mod=mymenu&submode=friends&amode=".$submode."&uid=".$R['join_uid']."');";
	} else {
		$farow = array();
		$goHref = "getLogin()";
	}
	
	$R['img'] = ($R['img'])?$R['img']:'/images/grn.png';
	$bill_type_array = array(
							"1"=>"프리미엄",
							"2"=>"긴급",
						);
	?>

                                <tr>
                                    <td><?=$bill_type_array[$R['step']]?></td>
                                    <td><?=date('Y.m.d', strtotime($R['rdate']))?></td>
                                    <td>~ <?=date('Y.m.d', strtotime($R['expiredate']))?></td>
                                </tr>



	<?php endwhile?>
                            </tbody>
                        </table>
                    </div>
                </div>

                



<script>
$("span.checkbox-wrapper.margin-right").on("click", function() {
	var sel       = $(this);
	var friend_id = sel.attr("uid");


});




	
</script>

	
		






