<?php
include_once "../lib/lib.php";
include_once "../lib/C_CONNECT.php";
include_once("../lib/define_table.php");
include_once("../lib/authentication.php");

$name =  $_GET['name'];						
$title_text =  $_GET['title_text'];			
?>
<!--##################################################################################-->
<!-- ############################	HTML START	##################################### -->
<!--##################################################################################-->
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<meta name='robots' content='none,noindex,nofollow'>
<TITLE></TITLE>
<META NAME="author" CONTENT="애드폼">
<LINK REL="stylesheet" HREF="global.css" TYPE="text/css">
<style type="text/css">
p{text-align:left;}
textarea{width:100%;border:2px solid #fff;padding:5px;background-color:#adbacd;color:green;}
</style>
<script type="text/javascript" src='js/check_input.js'></SCRIPT>
<script type="text/javascript" src='js/pop_center.js'></SCRIPT>
<script type="text/javascript">
<!--
function input_url()
{
	var domain = document.location.href;
	var arr_domain = domain.split("admine");
	var btn_path1 = "<input type='button' value='미리보기' onclick=\"window.open('"+arr_domain[0]+"view_addform.php?fname=<?php echo $name;?>')\">";
	var btn_path2 = "<input type='button' value='미리보기' onclick=\"window.open('"+arr_domain[0]+"view_list.php?fname=<?php echo $name;?>&mode=nameMode')\">";
	//일반적인 링크의 경우
	document.form1.path.value = arr_domain[0]+"view_addform.php?fname=<?php echo $name;?>";
	document.form1.path2.value = arr_domain[0]+"view_list.php?fname=<?php echo $name;?>&mode=nameMode";
	document.form1.path3.value = arr_domain[0]+"lastest_order.php?fname=<?php echo $name;?>";
	document.getElementById('case1_span').innerHTML+=document.form1.path.value;
	document.getElementById('case2_span').innerHTML+=document.form1.path.value;
	document.getElementById('case3_span').innerHTML+=document.form1.path.value;
	document.getElementById('case4_span').innerHTML+=document.form1.path.value;
	document.getElementById('case5_span').innerHTML+=document.form1.path.value;
	document.getElementById('case6_span').innerHTML+=document.form1.path3.value;
	document.getElementById('path1').innerHTML+=btn_path1;
	document.getElementById('path2').innerHTML+=btn_path2;
}
-->
</script>


</HEAD>


<BODY onload="input_url();">
<DIV>
	<form name="form1" action="">
	<TABLE class="noborder">
		<TR>
			<TD COLSPAN="2" style="background-color:white;text-align:left">
				<h2>폼 접속주소 복사</h2>
			</TD>
		</TR>
		<TR>
			<TD COLSPAN="2" style="background-color:white;text-align:left">
				<P><?php echo "".$name."(<span style='color:blue'>".$title_text."</span>)";?> 폼을 운영중인 홈페이지에 연결하는 방법을 알아봅니다.
				</P>
			</TD>
		</TR>
		<TR>
			<TD>
				<fieldset>
					<legend>링크 주소</legend>
					<p>
						아래는, 고객이 접수하는데 필요한, 접수초기화면  링크주소입니다.<span id="path1"></span>
					</p>
					<textarea name="path" rows="2"></textarea>	
					<p>
						아래는, 접수리스트 링크주소입니다.(접수화면으로 사용해도 무방)<span id="path2"></span>
					</p>
					<textarea name="path2" rows="2"></textarea>	
					<textarea name="path3" rows="2" style="display:none;"></textarea>
				</fieldset>				
			</TD>		
		</TR>

		<TR>
			<TD>
				<fieldset>
					<legend>일반적인 링크</legend>
					<p style="color:gray;">&lt;a&gt;태그를 이용한, 현재창 열림 하이퍼링크의 경우, 아래와 같이 활용합니다.</p>					
					<p>&lt;a href=&quot;<span id="case1_span" style="color:green;"></span>&quot;&gt;<span style="color:blue;"><?php echo $title_text;?></span>&lt;/a&gt;</p>
					<p style="color:gray;">&lt;a&gt;태그를 이용한, 새창 열림 하이퍼링크의 경우, 아래와 같이 활용합니다.</p>					
					<p>&lt;a href=&quot;<span id="case2_span" style="color:green;"></span>&quot; target=&quot;_blank&quot;&gt;<span style="color:blue;"><?php echo $title_text;?></span>&lt;/a&gt;</p>
				</fieldset>				
			</TD>		
		</TR>
		<TR>
			<TD>
				<fieldset>
					<legend>새창으로 열기</legend>
					<p style="color:gray;">상하좌우 레이아웃을 떼버리고, 실제 접수화면(예약달력과 폼입력양식)만, 원하는 크기의 새창으로 열고자 할 경우입니다.</p>	
					<p style="color:gray;">상하좌우 레이아웃을 떼버리기 위해서는, 해당 폼의 수정하기에서 레이아웃을 8번으로 선택하세요.</p>
					<p style="color:gray;">w=730 은 새창의 너비, h=600 은 새창의 높이이므로, 원하는 사이즈로 조절해서 띄우세요</p>
					<p style="font-weight:bold;">&lt;a&gt;태그로 원하는 사이즈의 새창열기</p>	
					<p>&lt;a href=&quot;#&quot; onclick=&quot;window.open('<span id="case3_span" style="color:green;"></span>&amp;w=730&amp;h=600','winname','scrollbars=yes,toolbar=no,location=no')&quot;&gt;<span style="color:blue;"><?php echo $title_text;?></span>&lt;/a&gt;</p>
					<p style="font-weight:bold;">버튼클릭으로 원하는 사이즈의 새창열기</p>	
					<p>&lt;input type=&quot;button&quot; value=&quot;<span style="color:blue;"><?php echo $title_text;?></span>&quot; onclick=&quot;window.open('<span id="case4_span" style="color:green;"></span>&amp;w=730&amp;h=600','winname','scrollbars=yes,toolbar=no,location=no')&quot;&gt;</p>					
				</fieldset>				
			</TD>		
		</TR>
		<TR>
			<TD>
				<fieldset>
					<legend>아이프레임으로 삽입할 경우</legend>
					<p style="color:gray;">상하좌우 레이아웃을 떼버리고, 실제 접수화면(폼입력양식)만, 아이프레임으로 삽입할 경우입니다.</p>					
					<p style="color:gray;">상하좌우 레이아웃을 떼버리기 위해서는, 해당폼의 수정하기에서 레이아웃을 8번으로 선택하세요.</p>					
					<p>&lt;iframe src=&quot;<span id="case5_span" style="color:green;"></span>&quot; width=&quot;730&quot; height=&quot;800&quot; frameborder=&quot;0&quot; scrolling=&quot;no&quot; style=&quot;background-color:transparent&quot;&gt;&lt;/iframe&gt;</p>							
				</fieldset>				
			</TD>		
		</TR>

		<TR>
			<TD>
				<fieldset>
					<legend>아이프레임으로 최근 접수현황 5개 목록 추출할 경우</legend>								
					<p>&lt;iframe src=&quot;<span id="case6_span" style="color:green;"></span>&quot; width=&quot;300&quot; height=&quot;160&quot; frameborder=&quot;0&quot; scrolling=&quot;no&quot; style=&quot;background-color:transparent&quot;&gt;&lt;/iframe&gt;</p>							
				</fieldset>				
			</TD>		
		</TR>

		<TR>
			<TD  COLSPAN="2" style="text-align:center">
				<HR>
				<input type='button' value='창닫기' onClick='window.close();' style="width:100px;height:35px;">
			</TD>
		</TR>
	</TABLE>
	</form>
</DIV>
</BODY>

</HTML>
