    <section class="section-body fix">
        <div id="content" class="fix">
            <div class="normal-background dim-gray-bg"  id="reviewList">

                
            </div>
        </div>
    </section>


<script>
var getReviewList = function() {
	$("#reviewList").load('/proc/mymenu/review.php?mod=<?=$mod?>&submode=review');
}

getReviewList(); 
</script>
