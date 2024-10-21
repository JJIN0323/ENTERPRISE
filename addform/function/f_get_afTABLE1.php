<?
#########################################################################################
#####################		애드폼 관리자테이블에서 정보 가져옴			  ###############
#########################################################################################
function f_get_afTABLE1($fld,$kw)
{
global $DBconn;
$where="where $fld='$kw'";
$re=$DBconn->f_selectDB("*",TABLE1,$where);						
$result = $re[result];
$row =  mysql_fetch_array($result);
	$html = array();

		$html["no"] = htmlspecialchars(stripslashes($row["no"]));							//고유번호
		$html["level"] = htmlspecialchars(stripslashes($row["level"]));						//레벨
		$html["user_id"] =  htmlspecialchars(stripslashes($row["user_id"]));				//아이디
		$html["password"] = htmlspecialchars(stripslashes($row["password"]));				//비밀번호
		$html["name"] = htmlspecialchars(stripslashes($row["name"]));						//이름
		$html["email_address"] = htmlspecialchars(stripslashes($row["email_address"]));		//이메일
		$html["tel"] = htmlspecialchars(stripslashes($row["tel"]));							//전화번호
		$html["hp"] = htmlspecialchars(stripslashes($row["hp"]));							//
		$html["fax"] = htmlspecialchars(stripslashes($row["fax"]));							//
		$html["supply_name"] = htmlspecialchars(stripslashes($row["supply_name"]));			//폼추가시 자동입력 상호	
		$html["supply_num"] = htmlspecialchars(stripslashes($row["supply_num"]));			//폼추가시 자동입력 사업자번호	
		$html["supply_man"] = htmlspecialchars(stripslashes($row["supply_man"]));			//폼추가시 자동입력 대표	
		$html["supply_address"] = htmlspecialchars(stripslashes($row["supply_address"]));	//폼추가시 자동입력 주소
		$html["supply_conditions"] = htmlspecialchars(stripslashes($row["supply_conditions"]));	//폼추가시 업태
		$html["supply_item"] = htmlspecialchars(stripslashes($row["supply_item"]));			//폼추가시 자동입력 종목
		$html["sell_num"] = htmlspecialchars(stripslashes($row["sell_num"]));				//통신판매번호
		$html["banking"] = htmlspecialchars(stripslashes($row["banking"]));					//폼추가시 자동입력 은행정보	
		$html["join_date"] = htmlspecialchars(stripslashes($row["join_date"]));				//가입시각	
		$html["edit_date"] = htmlspecialchars(stripslashes($row["edit_date"]));				//수정시각	
		$html["dummy1"] = htmlspecialchars(stripslashes($row["dummy1"]));					
		$html["dummy2"] = htmlspecialchars(stripslashes($row["dummy2"]));					
		$html["dummy3"] = htmlspecialchars(stripslashes($row["dummy3"]));					 
		$html["dummy4"] = htmlspecialchars(stripslashes($row["dummy4"]));					
		$html["dummy5"] = htmlspecialchars(stripslashes($row["dummy5"]));					
		$html["dummy6"] = htmlspecialchars(stripslashes($row["dummy6"]));				
		$html["dummy7"] = htmlspecialchars(stripslashes($row["dummy7"]));				
		$html["dummy8"] = htmlspecialchars(stripslashes($row["dummy8"]));				
		$html["dummy9"] = htmlspecialchars(stripslashes($row["dummy9"]));				
		$html["dummy10"] = htmlspecialchars(stripslashes($row["dummy10"]));
		$html["dummy11"] = htmlspecialchars(stripslashes($row["dummy11"]));				 
		$html["dummy12"] = htmlspecialchars(stripslashes($row["dummy12"]));				
		$html["dummy13"] = htmlspecialchars(stripslashes($row["dummy13"]));				
		$html["dummy14"] = htmlspecialchars(stripslashes($row["dummy14"]));				 
		$html["dummy15"] = htmlspecialchars(stripslashes($row["dummy15"]));				
		$html["dummy16"] = htmlspecialchars(stripslashes($row["dummy16"]));				
		$html["dummy17"] = htmlspecialchars(stripslashes($row["dummy17"]));				
		$html["dummy18"] = htmlspecialchars(stripslashes($row["dummy18"]));				
		$html["dummy19"] = htmlspecialchars(stripslashes($row["dummy19"]));				
		$html["dummy20"] = htmlspecialchars(stripslashes($row["dummy20"]));	

return $html;
}
?>