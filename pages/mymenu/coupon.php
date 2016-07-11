    <section class="section-body fix mycoupon">
        <div id="content" class="fix">

        </div>
    </section>




<script>
var getCouponList = function() {
	$("#content").load('/proc/mymenu/coupon.php?mod=<?=$mod?>&submode=coupon');
}

getCouponList(); 
</script>




