    <section class="section-body fix">
        <div id="content" class="fix">

        </div>
    </section>

<script>
var getReviewMyteamView = function() {
	$("#content").load('/proc/mymenu/review.myteam.view.php?mod=<?=$mod?>&submode=review&join_id=<?=$join_id?>');
}

getReviewMyteamView();
</script>
