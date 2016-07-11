    <section class="section-body fix">
        <div id="content" class="fix">
            <div class="favorite-list dim-gray-bg" id="managerScheduleTime">
            

            </div>
        </div>
    </section>


<script>
var getManagerScheduleTime = function() {
	$("#managerScheduleTime").load('/proc/mymenu/manager.schedule.time.php?mod=<?=$mod?>&submode=manager.schedule.time');
}

getManagerScheduleTime();
</script>




