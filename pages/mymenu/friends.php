    <section class="section-body fix">
        <div id="content" class="fix">
            <div class="normal-background dim-gray-bg"  id="friendList">

                
            </div>
        </div>
    </section>




<script>
var getFriendList = function() {
	$("#friendList").load('/proc/mymenu/friends.php?mod=<?=$mod?>&submode=friends');
}

getFriendList(); 
</script>




