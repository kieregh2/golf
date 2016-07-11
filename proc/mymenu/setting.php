<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/proc/global/global.php';

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
            
            <div class="normal-background dim-gray-bg">
                <div class="normal-input">
                    <div class="layout-left">
                        <span class="normal-label gray-ft font14 bold">푸쉬받기</span>
                    </div>

                    <div class="layout-right alignright">
                        <div class="switch-button enable on">
                            <div class="switch-button-base on">            
                                <div class="icon icon-switchbutton absolute-element"></div>
                                <span class="on normal-text blue-ft">ON</span>
                                <span class="off normal-text gray-ft">OFF</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="normal-input">
                    <div class="layout-left">
                        <span class="normal-label gray-ft font14 bold"><a class="fill-up-space" href="javascript:getMymenuList('setting','profile');">계좌정보 수정</a></span>
                    </div>
                    <div class="layout-right alignright">
                        <span class="icon icon-arrow-right"></span>
                    </div>
                </div>
            </div>



<script src="/_core/js/hybrid.js"></script>
<script type="text/javascript">

var photo_path ='/_var/simbol/<?=$my['photo']?>';

$("#change_photo").css({"background":"url('"+photo_path+"')", "background-repeat":"no-repeat", "background-position":"center center"});

var photo = '<?=$my['photo']?>';

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


$("div.switch-button").on("click", function() {
	var sel       = $(this);

	if($("div.switch-button").hasClass("enable")) {

 		$("div.switch-button").removeClass("enable").removeClass("on").addClass("disable").addClass("off");
 		$("div.switch-button-base").removeClass("on").addClass("off");
 		
	}else{

 		$("div.switch-button").removeClass("disable").removeClass("off").addClass("enable").addClass("on");
 		$("div.switch-button-base").removeClass("off").addClass("on"); 		
	}
	
	
});


</script>

	
		






