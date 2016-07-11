    <section class="section-body fix">
        <div id="content" class="fix">
            <div class="normal-background dim-gray-bg"  id="gameList">

                
            </div>
        </div>
    </section>




<script>
var getGameList = function() {

	$("#gameList").load('/proc/mymenu/game.php?mod=<?=$mod?>&submode=game');
}

getGameList(); 
</script>




