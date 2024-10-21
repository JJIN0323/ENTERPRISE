<?php include_once("lib/lib.php");?>
<!DOCTYPE html PUBLIC '-//W3C//DTD HTML 4.01//EN'   'http://www.w3.org/TR/html4/strict.dtd'>
<HTML>
<HEAD>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<LINK REL='stylesheet' HREF='style_setup.css' TYPE='text/css'>
<title>애드폼 설치 완료</title>
<meta name='robots' content='none,noindex,nofollow'>
</HEAD>
<BODY>
<img src="imgs/setup5.gif" alt="설치완료이미지">
<h1>설/치/완/료/ <span style='color:#999;font-size:15px'>STEP 5/5</span></h1>
<p>축하드립니다. 애드폼 설치가 완료되었습니다.</p>
<p>관리자 모드에서, 폼메일과 주문폼을 만들고 관리할 수 있습니다.</p>
<p>보통, 보내는 메일서버와 받는메일서버의 환경요인으로, 접수내역의 이메일 송수신이 100% 보장되지 않으므로,<br>접수내역은, 반드시 애드폼 관리자모드에서 열람하고 관리하시길 바랍니다.</p>
	<DIV>
		
	
		<div id='main'>
			<h2>관리자모드 접속방법</h2>			
			<fieldset style="width:100%;">
				<legend>관리자 계정</legend>
				<p>보안성을 강화하기 위해, 아파치웹서버의 자체인증을 사용합니다.</p>
				<p>아파치인증은, 비밀번호 분실시 관리자도 확인할 수가 없으므로, 따로 메모하거나 보관해 두십시오.</p>
				<p>아파치인증은, 로그인/로그아웃이 화면에서 제공되지 않고, 브라우저를 닫으면 인증이 종료됩니다.</p>
				<ul>
					<li><h3>아이디: addform</h3></li>
					<li><h3>비밀번호: 1111</h3></li>
				</ul>				
				<p>관리자모드의 주소창을 확인한 후, 바탕화면에 바로가기나, 웹브라우저에 즐겨찾기 해 두십시오</p>
				<p style='text-align:center'>
				<input type='button' name='button1' value='관리자모드 접속' onclick="window.open('admine/index.html')" style="width:150px;height:30px;">
				</p>
			</fieldset>
			
		</div>
	</DIV>
</BODY>
</HTML>