<?php	
function authentication() 
{
	Header("WWW-Authenticate: Basic realm=\"ADDFORM\"");
	Header("HTTP/1.0 401 Unauthorized");

	if($_GET[bbs_admin] == "on") $path = "";
	else $path = "../";

	die("
		<!DOCTYPE html PUBLIC '-//W3C//DTD HTML 4.01//EN'   'http://www.w3.org/TR/html4/strict.dtd'>
		<HTML>
		<HEAD>
		<meta http-equiv='content-type' content='text/html; charset=utf-8'>
		<title></title>
		</HEAD>
		<BODY style='background-color:#000;'>
			<TABLE style='border:0;width:100%;'>
			<TR>
				<TD style='text-align:center;'  valign='middle'>
					<img src='".$path."imgs/incorrect.jpg' alt='관리자 인증실패'>
				</TD>
			</TR>
			</TABLE>
		</BODY>
		</HTML>
	");
}

function CheckAdmin() 
{
	$id = $_SERVER['PHP_AUTH_USER'];
	$pwd = $_SERVER['PHP_AUTH_PW'];
	
	$result=@mysql_query("select * from ".db_tblname."_admine_table where user_id='$id' and password=MD5('$pwd')") or die(mysql_error());
	$check=mysql_num_rows($result);

	if (!$check) authentication();
}
//$PHP_AUTH_USER 가 없다면 authentication()실행하고, 있다면 CheckAdmin()으로 다시 인증
//PHP 4.2.0 이후로 register_globals 가 기본 off여서 전역변수등록이 안되므로, $_SERVER 슈퍼전역변수사용 
!isset($_SERVER['PHP_AUTH_USER']) ? authentication() : CheckAdmin();

//090327 추가
if($_SERVER['PHP_AUTH_USER'])
{
	$result_forAdminMember=@mysql_query("select * from ".db_tblname."_admine_table where user_id='".$_SERVER['PHP_AUTH_USER']."' and password='".MD5($_SERVER['PHP_AUTH_PW'])."'") or die(mysql_error());
	$row_forAdminMember =  mysql_fetch_array($result_forAdminMember);

	$af_adminMember["no"] = htmlspecialchars(stripslashes($row_forAdminMember["no"]));							//고유번호
	$af_adminMember["level"] = htmlspecialchars(stripslashes($row_forAdminMember["level"]));					//레벨
	$af_adminMember["user_id"] =  htmlspecialchars(stripslashes($row_forAdminMember["user_id"]));				//아이디
	$af_adminMember["password"] = htmlspecialchars(stripslashes($row_forAdminMember["password"]));				//비밀번호
	$af_adminMember["name"] = htmlspecialchars(stripslashes($row_forAdminMember["name"]));						//이름
	$af_adminMember["email_address"] = htmlspecialchars(stripslashes($row_forAdminMember["email_address"]));	//이메일
	$af_adminMember["tel"] = htmlspecialchars(stripslashes($row_forAdminMember["tel"]));						//전화번호
	$af_adminMember["hp"] = htmlspecialchars(stripslashes($row_forAdminMember["hp"]));							//
	$af_adminMember["fax"] = htmlspecialchars(stripslashes($row_forAdminMember["fax"]));						//
	$af_adminMember["supply_name"] = htmlspecialchars(stripslashes($row_forAdminMember["supply_name"]));		//폼추가시 자동입력 상호	
	$af_adminMember["supply_num"] = htmlspecialchars(stripslashes($row_forAdminMember["supply_num"]));			//폼추가시 자동입력 사업자번호	
	$af_adminMember["supply_man"] = htmlspecialchars(stripslashes($row_forAdminMember["supply_man"]));			//폼추가시 자동입력 대표	
	$af_adminMember["supply_address"] = htmlspecialchars(stripslashes($row_forAdminMember["supply_address"]));	//폼추가시 자동입력 주소
	$af_adminMember["supply_conditions"] = htmlspecialchars(stripslashes($row_forAdminMember["supply_conditions"]));//폼추가시 업태
	$af_adminMember["supply_item"] = htmlspecialchars(stripslashes($row_forAdminMember["supply_item"]));		//폼추가시 자동입력 종목
	$af_adminMember["sell_num"] = htmlspecialchars(stripslashes($row_forAdminMember["sell_num"]));				//통신판매번호
	$af_adminMember["banking"] = htmlspecialchars(stripslashes($row_forAdminMember["banking"]));				//폼추가시 자동입력 은행정보	
	$af_adminMember["join_date"] = htmlspecialchars(stripslashes($row_forAdminMember["join_date"]));			//가입시각	
	$af_adminMember["edit_date"] = htmlspecialchars(stripslashes($row_forAdminMember["edit_date"]));			//수정시각	
	$af_adminMember["dummy1"] = htmlspecialchars(stripslashes($row_forAdminMember["dummy1"]));					//부서명					
	$af_adminMember["dummy2"] = htmlspecialchars(stripslashes($row_forAdminMember["dummy2"]));					//직위					
	$af_adminMember["dummy3"] = htmlspecialchars(stripslashes($row_forAdminMember["dummy3"]));					//비고				 
	$af_adminMember["dummy4"] = htmlspecialchars(stripslashes($row_forAdminMember["dummy4"]));					
	$af_adminMember["dummy5"] = htmlspecialchars(stripslashes($row_forAdminMember["dummy5"]));					
	$af_adminMember["dummy6"] = htmlspecialchars(stripslashes($row_forAdminMember["dummy6"]));				
	$af_adminMember["dummy7"] = htmlspecialchars(stripslashes($row_forAdminMember["dummy7"]));				
	$af_adminMember["dummy8"] = htmlspecialchars(stripslashes($row_forAdminMember["dummy8"]));				
	$af_adminMember["dummy9"] = htmlspecialchars(stripslashes($row_forAdminMember["dummy9"]));				
	$af_adminMember["dummy10"] = htmlspecialchars(stripslashes($row_forAdminMember["dummy10"]));
	$af_adminMember["dummy11"] = htmlspecialchars(stripslashes($row_forAdminMember["dummy11"]));				 
	$af_adminMember["dummy12"] = htmlspecialchars(stripslashes($row_forAdminMember["dummy12"]));				
	$af_adminMember["dummy13"] = htmlspecialchars(stripslashes($row_forAdminMember["dummy13"]));				
	$af_adminMember["dummy14"] = htmlspecialchars(stripslashes($row_forAdminMember["dummy14"]));				 
	$af_adminMember["dummy15"] = htmlspecialchars(stripslashes($row_forAdminMember["dummy15"]));				
	$af_adminMember["dummy16"] = htmlspecialchars(stripslashes($row_forAdminMember["dummy16"]));				
	$af_adminMember["dummy17"] = htmlspecialchars(stripslashes($row_forAdminMember["dummy17"]));				
	$af_adminMember["dummy18"] = htmlspecialchars(stripslashes($row_forAdminMember["dummy18"]));				
	$af_adminMember["dummy19"] = htmlspecialchars(stripslashes($row_forAdminMember["dummy19"]));				
	$af_adminMember["dummy20"] = htmlspecialchars(stripslashes($row_forAdminMember["dummy20"]));	
	
}
define("login_level",$af_adminMember["level"]);
include_once("level_alert.php");

?>
