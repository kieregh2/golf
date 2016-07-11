    <section class="section-body fix">
        <div id="content" class="fix">

        </div>
    </section>

<script>
var getReviewRoungeView = function() {
	$("#content").load('/proc/mymenu/review.rounge.view.php?mod=<?=$mod?>&submode=review&join_id=<?=$join_id?>');
}

getReviewRoungeView(); 
</script>
