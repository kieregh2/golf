    <section class="section-body fix">
        <div id="content" class="fix">
            <div class="schedule-list dim-gray-bg" id="managerScheduleRounge">
            

            </div>
        </div>
    </section>

<script>
var getManagerScheduleRounge = function() {
	$("#managerScheduleRounge").load('/proc/mymenu/manager.schedule.rounge.php?mod=<?=$mod?>&submode=manager.schedule.rounge');
}

getManagerScheduleRounge();
</script>




