    <section class="section-body fix">
        <div id="content" class="fix">
            <div class="normal-background dim-gray-bg"  id="setting">

                
            </div>

        </div>
    </section>

<script>
var getSetting = function() {
	$("#setting").load('/proc/mymenu/setting.php?mod=<?=$mod?>&submode=setting');
}

getSetting();

</script>




