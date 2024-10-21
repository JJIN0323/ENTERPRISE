<?php
include_once("../lib/lib.php");
include_once("../lib/C_CONNECT.php");
include_once("../lib/define_table.php");
include_once("../lib/authentication.php");

/* ----------------------------------------------------------------------------------- */
/*	프로그램명 : 애드폼(영문 addform												   */									
/*	프로그램용도: 견적서 주문서 폼메일 제작											   */
/*	제작자: 박성규																	   */
/*	공식배포처: http://www.addform.net												   */
/*  프로그램 편집시 위 제작자 정보를 편집하거나 삭제해서는 안됩니다.				   */
/* ----------------------------------------------------------------------------------- */

#########################################################################################
##################################  모드가 수정일 때  ###################################
#########################################################################################
if($_POST['mode']=="modify_ok")
{
$level_memos = "";
for($i=0;$i<count($_POST['page_id']);$i++)
	{
		$level_memos  .= $_POST['page_id'][$i]."=".$_POST['exp'][$i]."®".$_POST['level'][$i]."®".$_POST['msg'][$i]."®".$_POST['important'][$i]."\n";
	}
$connect_file = @fopen("../lib/level.ini", "w") or die("파일읽기에 실패하였습니다. <br><strong>애드폼설치폴더/lib/</strong><strong style='color:blue'>level.ini</strong> 파일의 퍼미션을 707 로 설정하여 주세요.");
fwrite($connect_file, $level_memos);
fclose($connect_file);

//DB 입력 후 문서 고침
 die("<script type='text/javascript'>alert('수정되었습니다.');</script><meta http-equiv=refresh content='0;url=".URL."'>");
		
}
?>

<?php
function f_get_levelini()
{
global $arr_levelini;
$page_id = array();										
$arr_page_val = array();
while(list($key,$val)=each($arr_levelini))			//연관배열에서 키와값 분리
	{			
	$page_id[] = $key;				
	$arr_page_val[] = explode("®",$val);
	}

for($i=0;$i<count($page_id);$i++)
	{
	if($arr_page_val[$i][1] == 1) $icon = "<img src='img/key_level1.gif' style='vertical-align:middle;'>";
	else						  $icon = "<img src='img/key_level10.gif' style='vertical-align:middle;'>";
	if($arr_page_val[$i][3] == 1) $bg = "background:url(img/important.gif) no-repeat right center;";
	else						  $bg = "";

		echo ("<tr>
					<td style='width:300px;height:3em;color:#004a84;text-align:left;font-weight:bold;".$bg."'>
						 ".$icon." ".$arr_page_val[$i][0]."
						<input type='hidden' name='exp[]' value='".$arr_page_val[$i][0]."'>
						<input type='hidden' name='page_id[]' value='".$page_id[$i]."'>
					</td>
					<td style='width:80px;'>
						<select name='level[]'>");
						for($z=1;$z<11;$z++)
						{
							$selected = "";
							if($z == $arr_page_val[$i][1]) $selected = "selected";
							echo "<option value='".$z."' $selected>".$z." 등급이상</option>";							
						}
		echo ("			</select>
					</td>
					<td>						
						<input type='text' name='msg[]' value='".$arr_page_val[$i][2]."' onblur='quot_Del(this);' style='width:90%;ime-mode:active;'>
						<input type='hidden' name='important[]' value='".$arr_page_val[$i][3]."'>
					</td>
			  </tr>
			  ");
	}
}
?>

<!--##################################################################################-->
<!--################################  HTML start  ####################################-->
<!--##################################################################################-->
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>

<HEAD>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<meta name='robots' content='none,noindex,nofollow'>
<TITLE>등급별 관리권한 설정</TITLE>
<META NAME="author" CONTENT="애드폼">
<LINK REL="stylesheet" HREF="global.css" TYPE="text/css">

<script type="text/javascript" src='js/check_input.js'></script>
<script type="text/javascript" src='js/chk_null.js'></script>
<script type="text/javascript" src='js/only_en.js'></script>

</HEAD>

<!--//////////////////////////////////////////////////////////////////////////////////-->
<!--################################  BODY start  ####################################-->
<!--//////////////////////////////////////////////////////////////////////////////////-->
<BODY>

<DIV> 
	<FORM NAME="form1" id="form1" method="post" action='<?php echo $_SERVER['PHP_SELF'];?>'>
	<input type="hidden" name="mode" value="modify_ok">
		<!--##############################	 head	##################################-->
		<div>
			<h1 style="background-color:white;text-align:left;padding:20px;font-size:1.5em;font-weight:bold;">사원등급별 관리권한 설정</h1>			
			<HR>		
		</div>
		<!--##############################	 main	##################################-->
		<div>
			<div style="text-align:left;margin-bottom:10px;color:gray;">
				* 1등급이 가장 높은 최고관리자이고, 최고관리자는 모든 메뉴와 기능을 사용할 수 있습니다.<br>
				* 10등급이 가장낮은 관리사원이고, 10등급이상으로 설정된 권한이 없을경우,10급사원은 어떤 메뉴나 기능도 사용할 수 없습니다.<br>	
				* 만일, 해당권한의 이용가등급을 5등급이상이라고 설정하면, 1~5등급의 관리사원만 해당기능을 사용할 수 있습니다.<br>
				* 느낌표가 표시된 항목은, 중요한 권한이므로 되도록 고등관리자에게 권한을 부여하는것이 좋습니다.<br>
				* <span style='color:red;'>출력될 에러메시지 입력란에는, 기호/특수문자 (,){}[]/#| 등을 사용해서는 안되며, 문자만 입력해야 프로그램 오류가 나지 않습니다.</span>
			</div>
			<table>
				<tr>
					<th class="order" scope="col">권한종류</th>
					<th class="order" scope="col">이용가등급</th>
					<th class="order" scope="col">등급미달 사원접속시 출력될 에러메시지</th>
				</tr>
			<?php
				f_get_levelini();
			?>
				
			</table>
		</div>
		<!--##############################	 foot	##################################-->
		<div style="text-align:center;margin-top:30px;">				
			<input type='submit' value='수정하기' id="modifyBtn" class="btn_set">		
		</div>					
	</FORM>	
</DIV>
</BODY>

</HTML>
