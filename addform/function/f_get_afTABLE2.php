<?
#########################################################################################
#####################		애드폼 접수테이블에서 정보 가져옴			  ###############
#########################################################################################
function f_get_afTABLE2($fld,$kw)
{
global $DBconn;
$where="where $fld='$kw'";
$re=$DBconn->f_selectDB("*",TABLE2,$where);						
$result = $re[result];
$row =  mysql_fetch_array($result);
	$html = array();

		$html["no"] = htmlspecialchars(stripslashes($row["no"]));							 //고유번호
		$html["lang"] = htmlspecialchars(stripslashes($row["lang"]));						 //언어
		$html["od_unit"] =  htmlspecialchars(stripslashes($row["od_unit"]));				 //규격/단위
		$html["coin_unit"] = htmlspecialchars(stripslashes($row["coin_unit"]));				 //통화단위
		$html["upload_space"] = htmlspecialchars(stripslashes($row["upload_space"]));		 //업로드폴드용량설정	
		$html["upload_space_per"] = htmlspecialchars(stripslashes($row["upload_space_per"]));//경고시점 %
		$html["upload_use_alert"] = htmlspecialchars(stripslashes($row["upload_use_alert"]));//경고 사용여부 0,1
		$html["dummy1"] = htmlspecialchars(stripslashes($row["dummy1"]));					 //처리상황배열
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