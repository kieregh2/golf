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
			and join_state in ('Y')		
			and rjm.mbr_id = '".$my['uid']."'";

//echo $sql;

$RCD      = mysql_fetch_assoc(mysql_query($sql));

/*
if(!$RCD['join_uid']) {
	getLink('back','','잘못된 접근입니다','');
	
}
*/

?>

            <div class="top-banner">
                <div class="top-banner-image"> 
                    <img src="img/resort-bg.png" alt="banner-image"/>
                    <div class="top-banner-status table-prop">
                        <div class="layout-left" style="width: 300px;">
                            <h1 class="natual-element font18">[<?=$areaList[$RCD['area1']]['name']?>]<?=$RCD['name']?></h1>
                        </div>
                        <div class="layout-right alignright">
                            <span class="normal-text font18"><?=ddate('Md일(D)  ,H시', strtotime($RCD['join_time']))?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="normal-background dim-gray-bg">
                <div class="normal-input">
                    <div class="layout-left" style="width: 100px;">
                        <span class="normal-label gray-ft font14 bold">평점</span>
                    </div>
                    <div class="layout-right alignright">
                        <span  id="star_rating_1" rating="1" class="icon icon-star"></span>
                        <span id="star_rating_2" rating="2" class="icon icon-star noncheck"></span>
                        <span id="star_rating_3" rating="3" class="icon icon-star noncheck"></span>
                        <span id="star_rating_4" rating="4" class="icon icon-star active  noncheck margin-right"></span>
                    </div>
                </div>

                <h1 class="aligncenter font18 title-spacer">후기 등록</h1>

                <div class="review-input">
                    <textarea id="comment_input"></textarea>
                </div>
                <div class="normal-button smaller gray-bg">사진등록</div>
                <div class="normal-spacer"></div>
                <div class="normal-button blue-bg">등록하기</div>
            </div>




<script>
var join_id         = '<?=$join_id?>';
var ground_id       = '<?=$ground_uid?>';
var final_eval      = 1;
/*
$("div#my-game-list.game-box").on("click", function() {
	var sel     = $(this);
	var join_id = sel.attr("join_id");
	var tab_name= $("#rounge_tab").hasClass("blue-bg")? "rounge.view":"myteam.view";
	 
	location.href = "/?mod=mymenu&submode=review&detailmode="+tab_name+"&join_id="+join_id;

});
*/

$("div.normal-button.blue-bg").on("click", function() {

	$.ajax({url:'/proc/proc.map.php',
		data: { mode : "writeRoungeReview",
				join_id : join_id,
				ground_id : ground_id,
				eval : final_eval,
				comment: $("#comment_input").val()
			},
	    dataType:'json',
		type:'post',
		success:function(dt) {
	
			console.log(dt.result);

			if(dt.result.message == 'reviewWriteOk') {
				$("span.normal-text.font14.bold").text(dt.result.my_handy+"타");
				alert('리뷰를 저장했습니다.');
				location.href = "/?mod=rounge&submode=view&uid="+join_id;
					
			} else {
				alert(dt.result.message);
			}

		}
	});

});



$("div.layout-right.alignright span").each(function () {
	var $rating_obj  = $(this);

	$rating_obj.click(function() {
		var eval = $rating_obj.attr("rating");
		var star_rating = "#star_rating_";

		//console.log(["1", final_eval, eval]);
		
		if(final_eval <= eval) $rating_obj.removeClass("noncheck");
		if($rating_obj.hasClass("noncheck")) eval = eval -1;
		
		//console.log(["2",final_eval, eval]);

		for(i=1;i < 5;i++) {
			if(i <= eval) $(star_rating+i).removeClass("noncheck");
			else $(star_rating+i).addClass("noncheck");
		}
		
		//console.log(["3", final_eval, eval]);
		final_eval = eval;


		if(final_eval == 0) {
			$(star_rating+"1").removeClass("noncheck");
			final_eval = 1;
		}

		//console.log(final_eval);

	});
});

console.log(final_eval);
</script>


	
		






