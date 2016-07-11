<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/proc/global/global.php';


$sql      = "select *,
				sgd.uid as ground_uid,
				rjj.uid as join_uid
			from s_ground_data as sgd

			inner join rb_join_join as rjj
			on sgd.uid = rjj.rounge_id
			and rjj.room_type = 'J'
			and rjj.uid = '".$join_id."'
			and rjj.confirm_type in ('C','E')
		
			inner join rb_join_member rjm
			on rjj.uid = rjm.join_id
			and join_state in ('Y')	";


$RCD      = mysql_query($sql) or die(mysql_error());

?>
            <div class="top-banner">
                <div class="top-banner-image">
                    <img src="img/resort-bg.png" alt="banner-image"/>
                    <div class="top-banner-status table-prop">
                        <div class="layout-left" style="width: 300px;">
                            <h1 class="natual-element font18">AA골프장</h1>
                            <h3 class="natual-element font16">16년 4월 5일(화) 19시</h3>
                        </div>
						<div class="layout-right alignright">
							<span class="wire-button font18">종료</span>
						</div>
                    </div>
                </div>
            </div>
            <div class="normal-background dim-gray-bg">

                <div class="normal-input">
                    <div class="layout-left" style="width: 100px;">
                        <span class="normal-label gray-ft font14 bold">경기결과</span>
                    </div>
                    <div class="layout-right alignright">
                        <span class="normal-text font14 bold">100타</span>
                    </div>
                </div>

                <h1 class="aligncenter font18 title-spacer" id="handy_input_title"></h1>

	<?php while($R=mysql_fetch_assoc($RCD)):?> 
	<?php 
	
	$MBR = mysql_fetch_assoc(mysql_query("select * from rb_s_mbrdata where memberuid='".$R['mbr_id']."'"));
	
	$office['name']       = $R['name'];
	$office['join_time']  = $R['join_time'];
	$office['ground_uid'] = $R['ground_uid'];
	$join['confirm_type'] = $R['confirm_type'];
	$join['man_limit']    = $R['man_limit'];
	$join['join_uid']     = $R['join_uid'];
	$join['owner_id']     = $R['owner_id'];
	
	if($my['uid'] == $R['mbr_id']) $join['my_handy'] = $R['handy'];
	
	
	if($my['uid']) {
		$goHref = "goHref('/?mod=mymenu&submode=friends&amode=".$submode."&uid=".$R['join_uid']."');";
	} else {
		$farow = array();
		$goHref = "getLogin()";
	}
	
	$R['img'] = ($R['img'])?$R['img']:'/images/grn.png';
	?>
	<?php if($my['uid'] == $R['owner_id']) :?>

                <div class="normal-input">
                    <div class="layout-left" style="width: 200px;">
                        <span class="circle-shape normal-image"></span>
                        <span class="normal-label gray-ft font14 bold"><?=$MBR['name']?></span>
                    </div>
                    <div class="layout-right alignright">
                        <input placeholder="핸디를 입력해주세요." value="<?=$R['handy']?>" mbr_uid="<?=$R['mbr_id']?>" name="input_handy" id="input_handy" type="number" min="1" max="3" />
                        <!-- <span class="normal-text font14 bold">100</span> -->
                    </div>
                </div>
	<?php endif?>
	<?php endwhile?>

                <div class="normal-spacer"></div>
                <div class="normal-spacer"></div>
	<?php if($my['uid'] == $join['owner_id']) :?>
                <div class="list-row">
                    <div class="list-row-2d">
                        <div class="normal-button light-gray-bg">목록</div>
                    </div>
                    <div class="list-row-2d">
                        <div class="normal-button blue-bg">수정</div>
                    </div>
                </div>
	<?php endif?>
            </div>

<script>

var confirm_type    = '<?=$join['confirm_type']?>';
var confirm_message = (confirm_type == 'E')? "종료" : "진행중";
var join_id         = '<?=$join_id?>';
var my_handy        = '<?=$join['my_handy']?>';

$("span.wire-button.font18").text(confirm_message);

/* 방장 start */
<?php
if($my['uid'] == $join['owner_id'])
{
?>

var end_game = '';
	end_game +='<div class="normal-input">';
	end_game +='	<div class="layout-left" style="width: 100px;">';
	end_game +='	    <span class="normal-label gray-ft font14 bold">경기종료</span>';
	end_game +='	</div>';
	end_game +='	<div class="layout-right alignright">';
	end_game +='	    <span class="checkbox-wrapper">';
	end_game +='	    </span>';
	end_game +='	</div>';
	end_game +='</div>';

$("div.normal-background.dim-gray-bg").prepend(end_game);
$("#handy_input_title").text("핸디를 입력해 주세요.");

if(confirm_type == "E") $("span.checkbox-wrapper").addClass("checked");
	
$("span.checkbox-wrapper").on("click", function() {
	$(this).toggleClass("checked");
});

$("div.normal-button.light-gray-bg").on("click", function() {
	location.href = "/?mod=mymenu&submode=game&join_id="+<?=$join_id?>;
});

$("div.normal-button.blue-bg").on("click", function() {
	var handy_obj = {};
	var game_end_check;

	game_end_check = $("span.checkbox-wrapper").hasClass("checked"); 

	$("input[type=number]").each(function(kk, vv) {
		handy_obj[$(this).attr("mbr_uid")] = $(this).val();
	});

	$.ajax({url:'/proc/proc.map.php',
		data: { mode : "mymenuGameEnd",
				join_id : join_id,
				handy_obj : handy_obj,
				game_end_check : $("span.checkbox-wrapper").hasClass("checked")
			},
	    dataType:'json',
		type:'post',
		success:function(dt) {
	
			console.log(dt.result);

			if(dt.result.message == 'handyUpdateOk') {
				$("span.normal-text.font14.bold").text(dt.result.my_handy+"타");
				alert('경기 결과를 저장했습니다.');
					
			} else {
				alert(dt.result.message);
			}

		}
	});

});

<?php
}
?>
/* 방장 end */


$("h1.natual-element.font18").text("<?php echo $office['name']?>");
$("h3.natual-element.font16").text("<?php echo ddate('m월  d일  (D)  h시', strtotime($office['join_time']))?>");
console.log(my_handy);
$("span.normal-text.font14.bold").text(my_handy+"타");


$("span.checkbox-wrapper.margin-right").on("click", function() {
	var sel       = $(this);
	var friend_id = sel.attr("uid");
	
});

</script>

	
		






