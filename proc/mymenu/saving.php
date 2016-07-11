<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/proc/global/global.php';
?>
<div class="point-status">
	<div class="aligncenter">
		<span class="circle-shape normal-image x100"></span>
	</div>
	<h3 class="aligncenter"><?=$my['name']?>님의 적립현황</h3>
	<div class="aligncenter">
		<span class="icon icon-star-big"></span><span class="normal-text bold font20"><?=$my['eval']?></span>
	</div>
</div>

<div class="point-star-rate">
	<div class="list-row">
                        
	<?php for($i=1;$i < 11; $i++) {?> 
	<?php 

	if($my['uid']) { 
		$goHref = "goHref('/?mod=mymenu&submode=saving&amode=".$submode."&uid=".$R['join_uid']."');";
	} else {
		$farow = array();
		$goHref = "getLogin()";
	}
	
	$R['img'] = ($R['img'])?$R['img']:'/images/grn.png';

	?>

		<div class="list-row-5d">
      		<span class="icon icon-star-emblem<?=($i <= $my['eval'])? '':'-disable'?>"></span>
		</div>

		<!-- 
			</div>
		<div class="list-row">
		-->
	<?}?>
	</div>

</div>

<div class="benefit-for-vip">
	<h1 class="aligncenter">V.I.P 가 되면?</h1>
	<div class="list-row">
		<div class="list-row-2d">
			<div class="aligncenter">
				<span class="vipimage-01"></span>
			</div>
		<h3 class="aligncenter gray-ft">모든 회원의 사진과 직업을 볼 수 있어요.</h3>
		</div>
		<div class="list-row-2d">
			<div class="aligncenter">
				<span class="vipimage-02"></span>
			</div>
		<h3 class="aligncenter gray-ft">모든 경기가 최우선 등록됩니다.</h3>
		</div>
	</div>
</div>


<script>
$("span.checkbox-wrapper.margin-right").on("click", function() {
	var sel       = $(this);
	var friend_id = sel.attr("uid");

});


	
</script>

	
		






