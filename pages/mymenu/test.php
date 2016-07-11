

<div id="content">
	<div class="wrap">
		
<div id="pages_join">


	<form name="procForm" action="/" method="get">
	<input type="hidden" name="r" value="home" />
	<input type="hidden" name="c" value="" />
	<input type="hidden" name="m" value="home" />
	<input type="hidden" name="front" value="join" />
	<input type="hidden" name="mod" value="join" />
	<input type="hidden" name="page" value="step2" />
	<input type="hidden" name="comp" value="0" />

	<h2>회원가입</h2>



	<div class="agreecheck">
		<input type="checkbox" name="agreecheckbox" />위의 <span class="b">'홈페이지 이용약관 및 개인정보 수집·이용'</span>에 동의 합니다.
	</div>

	<div class="submitbox">
		<input type="button" value="가입취소" class="btngray" onclick="goHref('./');" />
				<input type="button" value="다음단계로" class="btnblue" onclick="return nextStep(0);" />
		
	</div>

	</form>
</div>


<script type="text/javascript">
//<![CDATA[
function nextStep(n)
{
	var f = document.procForm;

	if (f.agreecheckbox.checked == false)
	{
		alert('회원으로 가입을 원하실 경우,\n\n[홈페이지 약관 및 개인정보 수집·이용]에 동의하셔야 합니다.');
		return false;
	}

	f.comp.value = n;
	f.submit();
}
function tabShow(n)
{
	var i;

	for (i = 1; i < 5; i++)
	{
		getId('tagree'+i).style.borderBottom = '#dfdfdf solid 1px';
		getId('tagree'+i).style.background = '#f9f9f9';
		getId('tagree'+i).style.color = '#666666';
		getId('bagree'+i).style.display = 'none';
	}
	getId('tagree'+n).style.borderBottom = '#ffffff solid 1px';
	getId('tagree'+n).style.background = '#ffffff';
	getId('tagree'+n).style.color = '#000000';
	getId('bagree'+n).style.display = 'block';
}
//]]>
</script>	</div>
</div>
<div id="_box_layer_"></div>
<div id="_action_layer_"></div>
<div id="_hidden_layer_"></div>
<div id="_overLayer_" class="hide"></div>
<iframe name="_action_frame_member" width="0" height="0" style='display:none;' frameborder="0" scrolling="no"></iframe>
<script type="text/javascript">
//<![CDATA[
//document.body.onclick = closeMemberLayer;
//document.onkeydown = closeImgLayer;
//]]>
</script>

<script type="text/javascript">
//<![CDATA[
var Popstring = '';
if(Popstring!='')
{
	frames._action_frame_member.location.href='/?r=home&system=popup.layer&iframe=Y&pop='+Popstring;
}
function hidePopupLayer(uid) 
{ 
	if (getId('popCheck_'+uid).checked == true)
	{
		var nowcookie = getCookie('popview');
		setCookie('popview', '['+uid+']' + nowcookie , 1);
	}    
	getId('poplayer'+uid).style.display = 'none';
}
//]]>
</script>

</body>
</html>

