    <section class="section-body fix">
        <div id="content" class="fix">
            <div class="normal-background dim-gray-bg"  id="timeLineList">

                
            </div>
        </div>
    </section>




<script>
var getTimeLineList = function() {
	$("#timeLineList").load('/proc/mymenu/timeline.php?mod=<?=$mod?>&submode=timeline');
}

getTimeLineList(); 
</script>




