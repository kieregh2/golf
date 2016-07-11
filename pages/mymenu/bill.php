    <section class="section-body fix">
        <div id="content" class="fix">
            <div class="normal-background dim-gray-bg"  id="billList">

                
            </div>
        </div>
    </section>




<script>
var getBillList = function() {
	$("#billList").load('/proc/mymenu/bill.php?mod=<?=$mod?>&submode=bill');
}

getBillList(); 
</script>




