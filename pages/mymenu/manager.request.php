    <section class="section-body fix">
        <div id="content" class="fix">
            <div class="favorite-list dim-gray-bg" id="managerRequest">
            

            </div>
        </div>
    </section>

<script>
var getManagerRequest = function() {
	$("#managerRequest").load('/proc/mymenu/manager.request.php?mod=<?=$mod?>&submode=manager.request');
}

getManagerRequest();
</script>




