<?php
include_once("../lib/lib.php");
include_once("../lib/C_CONNECT.php");
include_once("../lib/define_table.php");
include_once("../lib/authentication.php");
include_once("../function/f_af_upload_forms.php");

function f_formupoad($arr)
{
for($i=0;$i<count($arr);$i++)
	{
	mysql_query($arr[$i]) or die(mysql_error());	
	}
echo ("<script type='text/javascript'>alert(\"폼업로드가 완료되었습니다.\")</script>");	
}

//첨부파일있을 때 업로드 함수 실행
$f_af_upload_forms = f_af_upload_forms();
if($_POST[mode] == "del")
{
	@unlink("../upload/backup_forms.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<meta name='robots' content='none,noindex,nofollow'>
<LINK REL="stylesheet" HREF="global.css" TYPE="text/css">
<style type="text/css">
	div{width:90%;text-align:left;background-color:#fff;padding:10px;margin-top:10px;}
	fieldset{width:90%;}
	td{border-color:#000;}
</style>
<script type="text/javascript" src='js/pop_center.js'></script>
<script type="text/javascript">
<!--
function chk_file(frm)
{
 if(frm.upload_forms.value=="")
	{
	 alert("백업해 두었던 폼백업파일을 찾아올려주세요.");
	 return false;
	}
	frm.submit();
}

var tag = "false";
function chk_all(frm,th) 
{
	var field=document.getElementsByTagName('input');				
	if (tag == "false") 
		{
		for (i = 0; i < field.length;i++)
			{							
			if(field[i].className=='c')
				{							
				field[i].checked = true;
				field[i].nextSibling.value=1;		
				}
			}
			tag = "true";
			th.value="전체해제"; 
		}
	else 
		{
		for (i = 0; i < field.length;i++)
			{								
			if(field[i].className=='c')
				{							
				field[i].checked = false;
				field[i].nextSibling.value=0;
				}
			}
			tag = "false";
			th.value="전체선택"; 
		}
}

function f_upload(frm)
{
	var field=document.getElementsByTagName('input');
	var chkN = 0;
	
		for (i = 0; i < field.length;i++)
			{							
			if(field[i].className=='c')
				{							
				if(field[i].checked == true) chkN++;							
				}
			}
	if(chkN == 0) 
		{
			alert("업로드할 폼을 하나 이상 선택하세요");	
			return false;
		}	
	
	frm.submit();
}
-->
</script>
<TITLE>애드폼 폼 업로드</TITLE>
</head>
<body>
	<fieldset>
		<legend>폼 업로드</legend>
			<div style="background-color:#fff;">
				<p style="color:#004a84;">백업해 놓았던 폼 또는, 공유폼을 애드폼에 업로드합니다.</p>
				<hr>
				 - 백업해 둔 폼으로 복구할 수 있습니다.<br>
				 - 다른 애드폼사용자가 제작한 공유폼을 업로드할 수 있습니다.<br>
				 - 하위버전에서 만들고 백업해둔 폼을 업로드할 수 있습니다.	
			</div>					
	</fieldset>

	<fieldset id="fieldset_attach">
		<legend><span style="color:red;">1단계</span> 백업해 두었던 파일 찾아올리기</legend>
			<div style="text-align:center;background-color:#b0c8dd;">
				<p style="color:#004a84;">백업해 두었던 폼백업파일의 확장자는 .php 입니다.</p>
				<form name='attachForm' id='attachForm' method='post' action='' enctype='multipart/form-data' onsubmit="return false;">
					<input type="hidden" name="NAX_FILE_SIZE" value="20000000">
					<input type="hidden" name="mode" value="attach">
					<input type="file" name="upload_forms" size="30" style="height:20px;">
					<?php 
						if(file_exists("../upload/backup_forms.php"))
							{					
							echo "<br><span style='color:green;'>폼백업파일이 업로드 되어 있습니다.</span>";
							include_once("../upload/backup_forms.php");							
							/*---------------------------------------------------------*/
							/*                 모드가 폼선택후 업로드일때			   */
							/*---------------------------------------------------------*/
								if($_POST['mode'] == "upload")										
								{									
									f_formupoad($arr_formupload);
								}
							}
						else echo "<br><span style='color:red;'>폼백업파일이 업로드되어 있지 않습니다.</span>";					
					?>
					<hr>
					<input type="button" value="백업파일 올리기" style="width:139px;height:50px;" onclick="chk_file(this.form);">
					<?php 
						if(file_exists("../upload/backup_forms.php"))
							{					
							echo "<input type='button' value='백업파일 삭제' style='width:139px;height:50px;' onclick='this.form.mode.value=\"del\";this.form.submit();'>";								
							}
					?>
				</form>
			</div>					
	</fieldset>	

	<fieldset id="fieldset_select">
		<legend><span style="color:red;">2단계</span> 업로드할 폼 선택</legend>
			<?php 
			if(file_exists("../upload/backup_forms.php")){?>
			<div style="background-color:#fff;">
				<p style="color:#004a84;line-height:1em;">영문 폼이름은, 중복되어서는 안되므로, 현재 설치된 애드폼에 만들어져있는 폼의 폼이름과, 업로드 하려는 폼이름이 같을 경우, 빨간색으로 표시되고, 업로드 할 수 없습니다. 그럴경우</p>
				<hr>
				 - 현재설치된 애드폼에서 같은 폼이름을 가진 폼을 삭제하거나<br>
				 - 애드폼 개발자 홈(www.addform.net)에서 기술지원을 받습니다.<br>				
			</div>		
			<div style="text-align:center;background-color:#b0c8dd;">
				<form name='form1' method='post' action="" onsubmit='return false;'>
				<table style="width:100%;">
					<tr>
						<td colspan="3" style="border:0;text-align:left;padding-left:0;">
							<input type="button" name="chkbox_all" value="전체선택" onclick="chk_all(this.form,this);">
						</td>						
					</tr>
					<?php						
						function f_get_forms()
						{
						///////	DB에서 가져와서 $arr_dbformname 배열정의 ////////
						global $DBconn;								
						$where = "";
						$res=$DBconn->f_selectDB("*",TABLE5,$where);  //필드, 테이블, 조건절
						$rows=mysql_num_rows($res[result]);			  //리턴된 행의 개수
						if($rows)
							{
							$arr_dbformname = "";
							$arr_dbformname = array();
							while($row = mysql_fetch_array($res[result]))
								{										
								$name = htmlspecialchars(stripslashes($row["name"]));
								$arr_dbformname[] = $name;
								}
							}
						///////	업로드된 폼백업파일에서 가져오기 /////////////////
						global $arr_formname;
						global $arr_formtitle;								
						for($i = 0;$i < count($arr_formname); $i++)
							{
							$bak_name = $arr_formname[$i];                	
							$bak_title_text = $arr_formtitle[$i];
							$checkbox = "<input type='checkbox' name='chks' value='$bak_name' class='c' onclick='if(this.checked==true)document.getElementById(\"chk_formname$i\").value=1;if(this.checked==false)document.getElementById(\"chk_formname$i\").value=0;'>";
							$style = "";									

							for($ic = 0;$ic < count($arr_dbformname); $ic++)
								{
								if($arr_dbformname[$ic] == $bak_name )//현재설치된 애드폼에 중복된 폼네임이 있을 때 업로드 못하게...
									{
										$style = "color:red;";
										$checkbox = "";
										$ic = count($arr_dbformname); //중복이름이 있을 경우 for 문 종료되게...
									}											
								}
							//아래에서 $checkbox 와 다음객체에는 공백없게...(nextSibling 와 관련)
							echo ("
							<tr>
								<td style='width:30px;'>
									$checkbox<input type='hidden' name='chk_formname[]' id='chk_formname$i' value='0'>
								</td>
								<td style='width:100px;$style'>
									$bak_name
								</td>
								<td>
									$bak_title_text
								</td>
							</tr>
							");
							}							
							
						}								
						f_get_forms();							
					?>
				</table>
				<hr>				
					<input type="hidden" name="mode" value="upload">
					<input type='button' name='btn_submit' value='폼업로드' style="width:139px;height:50px;" onclick="f_upload(this.form);">
					<input type='button' name='btn_submit' value='창닫기' style="width:139px;height:50px;" onclick="window.close();">
				</form>
			</div>
			<?php } else echo "<div>선택할 업로드 데이타가 없습니다.<br>위 1단계에서 백업해 두었던 폼백업파일을 올려주세요.</div>";?>
	</fieldset>	

	

</body>
</html>





