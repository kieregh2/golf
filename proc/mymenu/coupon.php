<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/proc/global/global.php';

$addwhere = "memberuid='".$my['uid']."'
			and valid='Y'
			and expiredate >= '".date('Y-m-d', time())."'
			and rdate <= '".date('Y-m-d', time())."'";

$sql      = "select step, count(step) as cnt
				from s_payment_data
			where ".$addwhere."
			group by step";

$RCD      = mysql_query($sql) or die(mysql_error());
$coupon = array();


while($R = mysql_fetch_assoc($RCD)) {
	$coupon['sum'] += $R['cnt'];
	$coupon[$R['step']] = $R['cnt'];
}

?>


<?php 

if($my['uid']) {
	$goHref = "goHref('/?mod=mymenu&submode=friends&amode=".$submode."&uid=".$R['join_uid']."');";
} else {

	$goHref = "getLogin()";
}

$R['img'] = ($R['img'])?$R['img']:'/images/grn.png';

$bill_type_array = array(
		"1"=>"프리미엄",
		"2"=>"긴급",
);

?>

            <div class="normal-background dim-gray-bg">

                <div class="point-status">
                    <div class="aligncenter">
                        <span class="circle-shape normal-image x100"></span>
                    </div>
                    <h3 class="aligncenter">홍길동님의 적립현황</h3>
                    <div class="aligncenter">
                        <span class="icon icon-coupon-stub"></span><span class="normal-text bold font20"><?=$coupon['sum']?></span>
                    </div>
                </div>

                <div class="coupon-status">
                    <div class="no-coupon-notification">
                        <div class="aligncenter">
                            <span class="icon chaimage"></span>
                        </div>
                        <? if($coupon['sum'] > 0) {?>
                        	<h3 class="aligncenter font16 bold">프리미엄 : <?=$coupon[1]?> &nbsp;&nbsp;  | &nbsp;&nbsp; 긴급 : <?=$coupon[2]?></h3>
                        <?} else { ?>
                        	<h3 class="aligncenter font16 bold">보유 중인 쿠폰이 없습니다.</h3> 
                        <?}?>
                    </div>
                </div>

                <h3 class="aligncenter">쿠폰 구매하기</h3>
                <div class="coupon-item">
                    <div class="layout-left" style="width: 300px;">
                        <span class="golf-radio selected margin-right"></span><span class="icon icon-sound margin-right" "></span><span class="normal-text font16 bold">긴급모집 쿠폰</span>
                        <div class="coupon-separater"></div>
                    </div>
                    <div class="layout-right">
                        <h3 class="natual-element alignright font16 bold">50,000원</h3>
                    </div>
                </div>

                <div class="coupon-item">
                    <div class="layout-left" style="width: 300px;">
                        <span class="golf-radio selected margin-right"></span><span class="icon icon-coupon-register margin-right"></span><span class="normal-text font16 bold">상단 등록 쿠폰</span>
                        <div class="coupon-separater"></div>
                    </div>
                    <div class="layout-right">
                        <h3 class="natual-element alignright font16 bold">50,000원</h3>
                    </div>
                </div>

				<!-- dmjung : coupon-proc-unique 클래스 추가. 스타일 컨트롤 위함 -->
                <div class="normal-input coupon-proc-unique">
                    <div class="layout-left" style="width: 250px;">
                        <span class="normal-label bold font14 gray-ft">결제방법</span>
                    </div>
                    <div class="layout-right alignright">
                        <span class="golf-radio selected"></span><span class="normal-text bold font14">카드</span>
                        <span class="golf-radio"></span><span class="normal-text bold font14">휴대폰</span>
                    </div>
                </div>
            </div>
            <div class="normal-button blue-bg">결제하기</div>



<script>
$("span.checkbox-wrapper.margin-right").on("click", function() {
	var sel       = $(this);
	var friend_id = sel.attr("uid");


});

</script>

	
		






