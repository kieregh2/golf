    <section class="section-body fix">
        <div id="content" class="fix">

        </div>
    </section>




<script>
var getGameList = function() {
	$("#content").load('/proc/mymenu/game.view.php?mod=<?=$mod?>&submode=game&detailmode=view&join_id=<?=$join_id?>');
}

getGameList(); 
</script>




