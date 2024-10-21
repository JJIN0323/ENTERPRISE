<?php
if(ver_tag != "pro")
{
################3  협의없이 삭제 및 편집을 하지 말아야 할 부분 시작  ####################
function Func_textlicense()
	{
	echo ("
	<div style='width:100%;margin:auto;text-align:center;'>
	<iframe src='http://www.addform.net/banner.html' name='addformbaner' style='width:600px;height:80px;margin:0;padding:0;' frameborder='no' scrolling='no'></iframe>
	</div>
	<DIV id='license' style='font-size:13px;margin:20px;text-align:center;'>
	<a href='http://www.addform.net' target='new'><span style='color:gray;font-size:11px;'><img src='http://www.addform.net/images/logo_s.gif' alt='애드폼' style='vertical-align:middle;border:0;'>폼메일,신청서,주문폼/견적서 제작 무료프로그램</span>
	</a>
	</DIV>
	");
	}
function Func_textlicense2()
	{
	echo ("
	<div style='width:100%;margin:auto;text-align:center;'>
	<iframe src='http://www.addform.net/banner.html' name='addformbaner' style='width:600px;height:80px;margin:0;padding:0;' frameborder='no' scrolling='no'></iframe>
	</div>
	<DIV id='license' style='font-size:13px;margin:20px;text-align:center;'>
	<a href='http://www.addform.net' target='new'><span style='color:gray;font-size:11px;'><img src='http://www.addform.net/images/logo_s.gif' alt='애드폼' style='vertical-align:middle;border:0;'>폼메일,신청서,주문폼/견적서 제작 무료프로그램</span>
	</a>
	</DIV>
	");
	}
}

if(ver_tag == "pro")
{
function Func_textlicense()
	{	
	}
function Func_textlicense2()
	{	
	}
################3  협의없이 삭제 및 편집을 하지 말아야 할 부분   끝  ####################
}
?>
