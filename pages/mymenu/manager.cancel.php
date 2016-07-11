    <section class="section-body fix">
        <div id="content" class="fix">
            <div class="favorite-list dim-gray-bg" id="managerCancel">
            

            </div>
        </div>
    </section>

<script>
var getManagerCancel = function() {
	$("#managerCancel").load('/proc/mymenu/manager.cancel.php?mod=<?=$mod?>&submode=manager.cancel');
}

getManagerCancel();
</script>




