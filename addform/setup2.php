<!DOCTYPE html PUBLIC '-//W3C//DTD HTML 4.01//EN'   'http://www.w3.org/TR/html4/strict.dtd'>
<HTML>
<HEAD>

<title>애드폼 설치</title>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<meta name='robots' content='none,noindex,nofollow'>
<LINK REL="stylesheet" HREF="style_setup.css" TYPE="text/css">
<script type="text/javascript">	
<!--
 function chk_null() {												//필수입력필드 검사 함수
	
		var field=document.getElementsByTagName('*');				//input 태그 갯수 검사(080325일에*로 수정)
		for (var i=0; i < field.length;i++){						//input 태그 갯수만큼 루프
			if(field[i].className=='ess'){							//클래스명이 ess인 필드가 있을때
				var essent = field[i].value;						//필수 입력필드의 값
				if(essent == ""){									//입력값이 없을 때
				alert("필수입력항목을 입력하여 주십시오\n\n Please enter the essential items");			//메시지	
				field[i].focus();									//필수 공란 포커스	
				return false;										//실행 중지
				}													//if 문 끝			
			}														//if 문 끝
		}															//for문 끝
		
	only_en();														//테이블이름 검사
	
}


function only_en()
{
	var fval = document.setup.db_tblname.value;
    var pattern = /(^[a-zA-Z0-9\-_]+$)/;
    if(!pattern.test(fval) || fval.length > 10 || fval.length < 1)
	{
        alert('테이블이름은 10자 이하의  영문과 숫자의 조합으로만 입력하여 주십시오. \n\n Please enter the English and only a combination of numbers.');
		document.setup.db_tblname.focus();
		document.setup.db_tblname.value=""; 
		return false;        
    }
	else
	{
        document.setup.submit();
    }
}
-->
</script>


</HEAD>


<BODY style='background: url(imgs/box_s.jpg);background-repeat:no-repeat;background-position:top right;' onload="document.setup.db_hostname.focus();">
<img src="imgs/setup3.gif" alt="설치진행이미지3">
<h1>데이타베이스 설정 <span style='color:#999;font-size:15px'>STEP 3/5</span></h1>

<DIV>

<form name="setup" action="setup3.php"  method="post" id="setup" onsubmit="return false;">
	
		<fieldset>
			
			<legend>DATABASE</legend>
			<p style="line-height:1.2em;">사용하고 있는 MySql 데이타베이스에 접근할 수 있는 DB 정보를 입력하십시오.</br>
			잘 모르실 경우, 웹호스팅을 신청한 사이트에 문의하거나 로그인하여 참고하십시오.</br>
			<span style="color:red;">* 아래 항목중 하나가 틀릴 경우, 다음과정에서 <b>데이타베이스 연결에 실패</b> 에러가 출력됩니다.</br>
			* 웹호스팅사이트에서 별도로 설명된 host name 이 없다면, HOST NAME은 <span style="color:blue;font-weight:bold;">localhost</span> 입니다.</span>					
			</p>
			<table class="db">				
				<tr>
					<td class="item">HOST NAME</td>
					<td class="val"><input type="text" name="db_hostname" id="db_hostname" value=""  class="ess" style="ime-mode:disabled"/ onclick="alert('일반적으로 localhost 를 입력하면 되지만, 어떤 호스팅업체를 이용할 경우, localhost 가 아닐 수도 있습니다.');">
					← 일반적으로 localhost 입니다.
					</td>
				</tr>
				<tr>
					<td class="item">DB NAME</td>
					<td class="val"><input type="text" name="dbname" id="dbname" class="ess" style="ime-mode:disabled" />
					← 웹호스팅업체 사이트에서 본인계정 참조
					</td>
				</tr>
				<tr>
					<td class="item">DB ID</td>
					<td class="val"><input type="text" name="db_username" id="db_username" class="ess" style="ime-mode:disabled" />
					← 웹호스팅업체 사이트에서 본인계정 참조
					</td>
				</tr>
				<tr>
					<td class="item">DB PassWord</td>
					<td class="val"><input type="text" name="db_password" id="db_password" class="ess" style="ime-mode:disabled" />
					← 웹호스팅업체 사이트에서 본인계정 참조
					</td>
				</tr>				
				
			</table>

		</fieldset>
		<div>&nbsp;</div>
		<fieldset>			
			<legend>TABLE NAME</legend>
			<p>
			위 4개의 DB정보는, 웹호스팅사에서 제공되지만, 아래 TABLE NAME은 임의로 지정할 수 있습니다.</br>
			위의 DB 에, 아래에 입력한 테이블이름으로 데이타베이스가 구축됩니다.(임의설정가능-중복불가)</br>
			이미 애드폼이 설치되어 있을 경우, 설치시 사용하지 않았던, 중복되지 않는 임의의 테이블이름
			</p>
			<table class="db">
				<tr>
					<td class="item">TABLE NAME</td>
					<td class="val">
						<input type="text" name="db_tblname" id="db_tblname" value="addform72" class="ess" style="ime-mode:disabled" />						
					</td>
				</tr>						
			</table>

		</fieldset><br /><br />

		<fieldset>
			
			<legend>LANGUAGE</legend>
			<p>
				설치된 애드폼의 메뉴들이 표시될 언어를 선택합니다.(기본 한글)<br /><br />
				* 사용언어는 설치후 언제든지 변경할 수 있습니다.						
			</p>
			
			<table class="db">
				<tr>
					<td class="item">언어 선택</td>
					<td class="val">
					<!--##################################################################################-->
					<!--#############################  언어설정 가져오기 start  ##########################-->
					<!--##################################################################################-->
					<?php
					//언어 스킨폴더 이름가져오기
					function f_skin($directory){
					 global $lang;							//설정된 언어 $lang 외부변수 

					 $dir=$directory;						//디렉토리 경로
					 $handle=opendir($dir);
					 while ($dirs = readdir($handle))
					 {
					  if(!eregi("\.",$dirs))				//파일이 아닌 디렉토리인 경우
					  {										//폴더 이름과 같을 경우
					   if($dirs==$lang)
						   $select="selected";				//선택되게...
					   else $select="";
					   echo"<option value='$dirs' $select>$dirs</option>"."\n";
					  }
					 }
					 closedir($handle);
					}
					?>
							
						<select name='comboLang' id='comboLang' onchange='document.setup.lang.value=options[options.selectedIndex].value'>
						<option value="">----- select -----</option>
						<?php echo f_skin("lib/lang");?>					
						</select>
						<input type='hidden' name='lang' value="korean">
					</td>				
				</tr>				
			</table>

		</fieldset>	<br />	<br />

		<input type="button" value="SETUP" style='width:100px;height:30px;' onclick="chk_null();" />


</form>

</DIV>

</body>
</html>