    <section class="section-body fix">
        <div id="content" class="fix">

        </div>
    </section>




<script>
var getSettingProfileList = function() {
	$("#content").load('/proc/mymenu/setting.profile.php?mod=<?=$mod?>&submode=setting&detailmode=profile');
}

getSettingProfileList(); 
</script>




