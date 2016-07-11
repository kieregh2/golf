<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/proc/global/global.php';
$getArea = getArea();

?>
 
	<?php 

	if($my['uid']) {
		$goHref = "goHref('/?mod=mymenu&submode=friends&amode=".$submode."&uid=".$R['join_uid']."');";
	} else {
		$farow = array();
		$goHref = "getLogin()";
	}
	
	$R['img'] = ($R['img'])?$R['img']:'/images/grn.png';

	?>

            <div class="configuration-user">
                <div class="configuration-user-wrapper">
                    <div class="layout-left" style="width: 120px;">
                        <span class="circle-shape normal-image x100">

                        </span>
                        <span id="change_photo" class="circle-shape normal-image x100 asoverlay">
                            사진 변경
                        </span>
                        <input type='hidden' name='photo' id='photo' value='<?=$my['photo']?>' data-role='none'/>
                    </div>
                    <div class="layout-right">
                        <div>
                            <span class="normal-text font16 bold"><?=$my['name']?></span><?if($my['vip']) {?><span class="icon icon-tag-vip"></span><?}?>
                            
                        </div>
                        <div>
                            <span class="normal-text font14"><?=$my['email']?></span>
                        </div>
                    </div>
                </div>
            </div>
           <form name="member_form" id="member_form">
           	<input type="hidden" name="mode" value="memberUpdate">
           	<input type="hidden" name="gender" id="gender" value="1">
            <div class="normal-background dim-gray-bg">
                <h3>신규 비밀번호</h3>
                <div class="normal-input">
                    <input type="password" name="mempass"  id="mempass" placeholder="신규 비밀번호" />
                </div>

                <h3>신규 비밀번호 재입력</h3>
                <div class="normal-input">
                    <input type="password" name="re_mempass" id="re_mempass" placeholder="신규 비밀번호 재입력" />
                </div>

                <h3>연락처</h3>
                <div class="normal-input">
                    <input type="number" name="phonenum" id="phonenum" placeholder="연락처" value="<?=$my['tel2']?>" />
                </div>

                <h1 class="title-spacer aligncenter">추가정보(선택)</h1>

                <h3>닉네임</h3>
                <div class="normal-input">
                    <input type="text" name="nic" id="nic" placeholder="닉네임을 입력하세요." value="<?=$my['nic']?>"  />
                </div>

                <h3>직업</h3>
                <div class="normal-input">
                    <input type="text" name="job" id="job" placeholder="직업을 입력하세요." value="<?=$my['job']?>"  />
                </div>

                <h3>연령</h3>
                <div class="normal-input">
                    <input type="text" name="age" id="age" placeholder="연령을 입력하세요." value="<?=$my['age']?>"  />
                </div>

                <h3>타수</h3>
                <div class="normal-input">
                    <input type="text" name="par" id="par" placeholder="타수를 입력하세요." value="<?=$my['par']?>"  />
                </div>

                <h3>성별</h3>
                <div class="normal-input">
                    <span id="man"   class="golf-radio margin-right <?=($my['sex'] ==1)? 'selected':''?> selected"></span><span class="normal-text bold font16 margin-right">남</span>
                    <span id="woman" class="golf-radio margin-right <?=($my['sex'] ==2)? 'selected':''?>"></span><span class="normal-text bold font16">여</span>
                </div>

                <h3>선호지역</h3>
                <div class="normal-input">
                	<!-- 
                    <div class="layout-left">
                        <span class="normal-label gray-ft font14 bold" id="area">서울특별시</span>
                    </div>                
                    -->
                    <div id="area" class="list-layout-left dropdown-content"> 
						<select name="favorite_area" id="favorite_area" size="1">
						<?foreach ($getArea as $kk => $vv) {?>
						<option value="<?=$kk?>" <?=($my['favorite_area'] == $kk)? 'selected':'';?>><?=$vv["name"]?></option>
						<?}?>
						</select> 

                    </div>

                    <div class="layout-right alignright">
                        <span class="icon"></span>
                    </div>

                </div>
			</form>
                <div class="normal-spacer"></div>
                <div class="normal-button blue-bg">저장하기</div>
            </div>

<script src="/_core/js/hybrid.js"></script>
<script type="text/javascript">

var photo = '<?=$my['photo']?>';
var photo_path ='<?=$g['path_var']?>simbol/<?=$my['photo']?>';

alert(photo_path);

$("#change_photo").css({"background":"url('"+photo_path+"')", "background-repeat":"no-repeat", "background-position":"center center"});

function openFileChooser(_succFn) {
	var param = {
		type : 'image/*',
		crop : false,
		succFn : _succFn
	};
	Hybrid.exe('HybridIf.openFileChooser', param);
}

function resultFileSuccess(dts) {
	var data = $.parseJSON(dts);
		
	$("#change_photo").css({"background":"url('"+data.name+"')", "background-repeat":"no-repeat", "background-position":"center center"});
	$("#photo").val(data.name);
}

$(document).on("click","#change_photo", function() {
	openFileChooser('resultFileSuccess');
});


function fileRemove(el) {
	$(el).remove();
				
}

$("#man").on("click", function() {
	$(this).addClass("selected");
	$("#woman").removeClass("selected");
	$("#gender").val(1);
});
$("#woman").on("click", function() {
	$(this).addClass("selected");
	$("#man").removeClass("selected");	
	$("#gender").val(2);
});

$("div.normal-button.blue-bg").on("click", function() {
	var sel       = $(this);

	//alert($("#mempass").val());

	if($("#mempass").val() == "") {
		alert("패스워드를 입력해 주세요.");
		return false;
	}
	if($("#mempass").val().length < 8) {
		alert("패스워드의 길이는 8자 이상입니다.");
		return false;
	}	
	
	if($("#re_mempass").val() == "") {
		alert("재입력 패스워드를 입력해 주세요.");
		return false;
	}
	
	if($("#mempass").val() != $("#re_mempass").val()) {
		alert("재입력 패스워드가 맞지 않습니다.");
		return false;
	}

	if($("#phonenum").val() == "") {
		alert("연락처를 입력해 주세요.");
		return false;
	}
	if($("#nic").val() == "") {
		alert("닉네임을 입력해 주세요.");
		return false;
	}
	if($("#job").val() == "") {
		alert("직업을 입력해 주세요.");
		return false;
	}
	if($("#age").val() == "") {
		alert("나이를 입력해 주세요.");
		return false;
	}
	if($("#par").val() == "") {
		alert("타수를 입력해 주세요.");
		return false;
	}


	var formData = $("#member_form").serialize();
	console.log(formData);
	/*
	$.ajax({
		type: 'post',
		url: '/proc/proc.map.php',
		data: formData,
		dataType: "json",
		contentType : "application/json",
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
	*/

	//# 친구 리뷰 저장

	$.ajax({url:'/proc/proc.map.php',
		data: formData,
	    dataType:'json',
		type:'post',
		success:function(dt) {
	
			console.log(dt.result);

			if(dt.result.message == 'memberUpdateOk') {
				alert('설정이 완료됐습니다.');
					
			} else {
				alert(dt.result.message);
			}

		}
	});

});



	
</script>

	
		






