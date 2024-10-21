<?
#########################################################################################
#####################		애드폼 그룹테이블에서 정보 가져옴			  ###############
#########################################################################################
function f_get_afTABLE3($fld,$kw)
{
global $DBconn;
$where="where $fld='$kw'";
$re=$DBconn->f_selectDB("*",TABLE3,$where);						
$result = $re[result];
$row =  mysql_fetch_array($result);
	$html = array();

		$html["no"] = htmlspecialchars(stripslashes($row["no"]));							//고유번호
		$html["name"] = htmlspecialchars(stripslashes($row["name"]));						//그룹이름		
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