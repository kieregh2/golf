    <section class="section-body fix">
        <div id="content" class="fix">
            <div class="favorite-list dim-gray-bg" id="manager">
            

            </div>
        </div>
    </section>


    <div class="global-overlay fix" style="display:none;">
        <div class="global-popup-flexible">
            <h3>약관</h3>
            <div id="terms-rule-section">
                <p>
                    약관 내용이 나옵니다.
                </p>
            </div>
            <div id="agree-section">
                <span class="checkbox-wrapper checked margin-right"></span><span class="normal-text font16 bold gray-ft">약관에 동의합니다.</span>
            </div>
            <div class="normal-spacer"></div>
            <div class="list-row">
                <div class="list-row-2d">
                    <div class="util-button gray-bg">담기</div>
                </div>
                <div class="list-row-2d">
                    <div class="util-button blue-bg">확인</div>
                </div>
            </div>
        </div>
    </div>

<script>
var getManager = function() {
	$("#manager").load('/proc/mymenu/manager.php?mod=<?=$mod?>&submode=manager');
}

getManager();
</script>




