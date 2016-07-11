<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/proc/global/global.php';


?>
			<div class="matching-info">				
				<table>
					<colgroup>
						<col width="15%" />
						<col width="65%" />
						<col width="20%" />
					</colgroup>
					<tr>
						<td>
							<div id="myimg_background" class="my-image">
								
							</div>
						</td>
						<td>
							<span class="name">&nbsp;<?=$my['name']?></span><span class="justLabel">&nbsp;매니저님</span>
						</td>
						<td>
						</td>
					</tr>
				</table>
			</div>
			
            <div class="normal-background dim-gray-bg">
                <div class="normal-button blue-bg bigger">
                    <span onclick="getMymenuList('manager.schedule.rounge')">스케쥴표</span>
                </div>
                <div class="normal-button blue-bg bigger">
                    <a href="/?mod=mymenu&submode=manager.request">요청목록</a>
                </div>
                <div class="normal-button blue-bg bigger">
                    <a href="/?mod=mymenu&submode=manager.confirm">완료목록</a>
                </div>
                <div class="normal-button blue-bg bigger">
                    <a href="/?mod=mymenu&submode=manager.cancel">취소목록</a>
                </div>
            </div>


<script>
$("#myimg_background").css({"background":"url('<?=getMyPicture($my)?>')",
	 "background-repeat":"no-repeat",
	 "background-position":"center center",
	 "background-size":"100%"});
</script>

	
		






