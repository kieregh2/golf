    <section class="section-body fix">
        <div id="content" class="fix">
            <div class="normal-background dim-gray-bg" id="savingList">

            </div>
        </div>
    </section>



<script>
var getSavingList = function() {
	$("#savingList").load('/proc/mymenu/saving.php?mod=<?=$mod?>&submode=saving');
}

getSavingList(); 
</script>




