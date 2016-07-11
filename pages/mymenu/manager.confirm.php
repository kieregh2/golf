    <section class="section-body fix">
        <div id="content" class="fix">
            <div class="favorite-list dim-gray-bg" id="managerConfirm">
            

            </div>
        </div>
    </section>

<script>
var getManagerConfirm = function() {
	$("#managerConfirm").load('/proc/mymenu/manager.confirm.php?mod=<?=$mod?>&submode=manager.confirm');
}

getManagerConfirm();
</script>




