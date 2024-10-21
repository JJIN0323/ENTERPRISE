<?
#########################################################################################
#####################		애드폼 테이블에서 정보 가져옴				  ###############
#########################################################################################
function f_get_afTABLE7($fld,$kw)
{
global $DBconn;
$where="where $fld='$kw'";
$re=$DBconn->f_selectDB("*",TABLE7,$where);						
$result = $re[result];
$row =  mysql_fetch_array($result);
	$html = array();

		$html["no"] = htmlspecialchars(stripslashes($row["no"]));								//고유번호
		$html["logo_link"] = htmlspecialchars(stripslashes($row["logo_link"]));					//로고클릭시 url
		$html["yn_topmenu"] = htmlspecialchars(stripslashes($row["yn_topmenu"]));				//상단메뉴 사용여부
		$html["yn_top_custom"] = htmlspecialchars(stripslashes($row["yn_top_custom"]));			//상단 사용자코딩 사용여부
		$html["topmenu_idx"] = stripslashes($row["topmenu_idx"]);				//상단메뉴코딩
		$html["top_custom"] = stripslashes($row["top_custom"]);					//상단 사용자코딩

		$html["left_width"] = htmlspecialchars(stripslashes($row["left_width"]));				//좌측너비
		$html["left_wUnit"] = htmlspecialchars(stripslashes($row["left_wUnit"]));				//좌측높이
		$html["yn_leftmenu"] = htmlspecialchars(stripslashes($row["yn_leftmenu"]));				//좌측메뉴사용여부
		$html["yn_thumblist"] = htmlspecialchars(stripslashes($row["yn_thumblist"]));			//썸네일리스트 사용여부
		$html["yn_lastest"] = htmlspecialchars(stripslashes($row["yn_lastest"]));				//최근폼 사용여부
		$html["yn_best"] = htmlspecialchars(stripslashes($row["yn_best"]));						//인기폼사용여부
		$html["yn_tel"] = htmlspecialchars(stripslashes($row["yn_tel"]));						//전화번호안내 사용여부
		$html["yn_bank"] = htmlspecialchars(stripslashes($row["yn_bank"]));						//은행정보 사용여부
		$html["yn_left_custom"] = htmlspecialchars(stripslashes($row["yn_left_custom"]));		//좌측사용자코딩 사용여부
		$html["leftmenu_idx"] = stripslashes($row["leftmenu_idx"]);				//좌측메뉴 코딩
		$html["thumb_width"] = htmlspecialchars(stripslashes($row["thumb_width"]));				//썸네일 너비
		$html["thumb_height"] = htmlspecialchars(stripslashes($row["thumb_height"]));			//썸네일 높이
		$html["lastestN"] = htmlspecialchars(stripslashes($row["lastestN"]));					//최근폼 개수
		$html["bestN"] = htmlspecialchars(stripslashes($row["bestN"]));							//인기폼개수
		$html["left_custom"] = stripslashes($row["left_custom"]);				//좌측사용자 코딩

		$html["right_width"] = htmlspecialchars(stripslashes($row["right_width"]));				//우측너비
		$html["right_wUnit"] = htmlspecialchars(stripslashes($row["right_wUnit"]));				//우측높이
		$html["yn_dokdo"] = htmlspecialchars(stripslashes($row["yn_dokdo"]));					//독도홍보 사용여부
		$html["yn_lastestR"] = htmlspecialchars(stripslashes($row["yn_lastestR"]));				//최근폼 사용여부(우)	
		$html["yn_bestR"] = htmlspecialchars(stripslashes($row["yn_bestR"]));					//인기폼 사용여부(우)
		$html["yn_right_custom"] = htmlspecialchars(stripslashes($row["yn_right_custom"]));		//우측 사용자코딩 사용여부
		$html["lastestRN"] = htmlspecialchars(stripslashes($row["lastestRN"]));					//최근폼 개수(우)
		$html["bestRN"] = htmlspecialchars(stripslashes($row["bestRN"]));						//인기폼 개수(우)
		$html["right_custom"] = stripslashes($row["right_custom"]);				//우측 사용자코딩

		$html["yn_companydata"] = htmlspecialchars(stripslashes($row["yn_companydata"]));		//하단 사업자정도 출력여부
		$html["yn_footer_custom"] = htmlspecialchars(stripslashes($row["yn_footer_custom"]));	//하단 사용자코딩 사용여부
		$html["footer_custom"] = stripslashes($row["footer_custom"]);			//하단 사용자코딩

		$html["dummy1"] =	htmlspecialchars(stripslashes($row["dummy1"]));				
		$html["dummy2"] =	htmlspecialchars(stripslashes($row["dummy2"]));					 
		$html["dummy3"] =	htmlspecialchars(stripslashes($row["dummy3"]));					 
		$html["dummy4"] =	htmlspecialchars(stripslashes($row["dummy4"]));					   
		$html["dummy5"] =	htmlspecialchars(stripslashes($row["dummy5"]));						
		$html["dummy6"] =	htmlspecialchars(stripslashes($row["dummy6"]));						
		$html["dummy7"] =	htmlspecialchars(stripslashes($row["dummy7"]));
		$html["dummy8"] =	htmlspecialchars(stripslashes($row["dummy8"]));
		$html["dummy9"] =	htmlspecialchars(stripslashes($row["dummy9"]));
		$html["dummy10"] =	htmlspecialchars(stripslashes($row["dummy10"]));
		$html["dummy11"] =	htmlspecialchars(stripslashes($row["dummy11"]));
		$html["dummy12"] =	htmlspecialchars(stripslashes($row["dummy12"]));
		$html["dummy13"] =	htmlspecialchars(stripslashes($row["dummy13"]));
		$html["dummy14"] =	htmlspecialchars(stripslashes($row["dummy14"]));
		$html["dummy15"] =	htmlspecialchars(stripslashes($row["dummy15"]));
		$html["dummy16"] =	htmlspecialchars(stripslashes($row["dummy16"]));
		$html["dummy17"] =	htmlspecialchars(stripslashes($row["dummy17"]));
		$html["dummy18"] =	htmlspecialchars(stripslashes($row["dummy18"]));
		$html["dummy19"] =	htmlspecialchars(stripslashes($row["dummy19"]));
		$html["dummy20"] =	htmlspecialchars(stripslashes($row["dummy20"]));

return $html;
}
?>