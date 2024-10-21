<?
#########################################################################################
#####################		애드폼 접수테이블에서 정보 가져옴			  ###############
#########################################################################################
function f_get_afTABLE4($fld,$kw)
{
global $DBconn;
$where="where $fld='$kw'";
$re=$DBconn->f_selectDB("*",TABLE4,$where);						
$result = $re[result];
$row =  mysql_fetch_array($result);
	$html = array();

		$html["no"] = htmlspecialchars(stripslashes($row["no"]));						 //고유번호
		$html["af_order_no"] = htmlspecialchars(stripslashes($row["af_order_no"]));		 //접수번호
		$html["mom"] =  htmlspecialchars(stripslashes($row["mom"]));					 //속한 주문폼 이름		
		$html["client_name"] = htmlspecialchars(stripslashes($row["client_name"]));		 //고객 이름
		$html["client_tel"] = htmlspecialchars(stripslashes($row["client_tel"]));		 //고객	전화번호	
		$html["client_hp"] = htmlspecialchars(stripslashes($row["client_hp"]));			 //고객	휴대폰
		$html["client_fax"] = htmlspecialchars(stripslashes($row["client_fax"]));		 //고객	fax
		$html["client_email"] = htmlspecialchars(stripslashes($row["client_email"]));	 //고객	이메일
		$html["client_address"] = htmlspecialchars(stripslashes($row["client_address"]));//고객 주소
		$html["client_memo"] = htmlspecialchars(stripslashes($row["client_memo"]));		 //고객 메모
		$html["supply_name"] = htmlspecialchars(stripslashes($row["supply_name"]));		 
		$html["supply_num"] = htmlspecialchars(stripslashes($row["supply_num"]));		
		$html["supply_man"] = htmlspecialchars(stripslashes($row["supply_man"]));			
		$html["supply_address"] = htmlspecialchars(stripslashes($row["supply_address"]));		
		$html["supply_conditions"] = htmlspecialchars(stripslashes($row["supply_conditions"]));	 
		$html["supply_item"] = htmlspecialchars(stripslashes($row["supply_item"]));
		$html["supply_memo"] = htmlspecialchars(stripslashes($row["supply_memo"]));		 //공급자 메모
		$html["hostinfo"] = htmlspecialchars(stripslashes($row["hostinfo"]));			 //아이피
		$html["input_date"] = htmlspecialchars(stripslashes($row["input_date"]));		 //접수시각
		$html["edit_date"] = htmlspecialchars(stripslashes($row["edit_date"]));			 //수정시각
		$html["select_items"] = htmlspecialchars(stripslashes($row["select_items"]));	 //데이타
		$html["sum"] = htmlspecialchars(stripslashes($row["sum"]));						 //합  계
		$html["situation"] = htmlspecialchars(stripslashes($row["situation"]));			 //상  황
		$html["tno"] =	htmlspecialchars(stripslashes($row["tno"]));					  //kcp 거래번호(취소/매입시 사용)
		$html["pay_cancel"] =	htmlspecialchars(stripslashes($row["pay_cancel"]));		  //kcp 결제취소여부(on,off)
		$html["dummy1"] = htmlspecialchars(stripslashes($row["dummy1"]));				 //폼의제목
		$html["dummy2"] = htmlspecialchars(stripslashes($row["dummy2"]));				 //폼의형식
		$html["dummy3"] = htmlspecialchars(stripslashes($row["dummy3"]));				 //첨부파일이름
		$html["dummy4"] = htmlspecialchars(stripslashes($row["dummy4"]));				 //한글|한자합계금액
		$html["dummy5"] = htmlspecialchars(stripslashes($row["dummy5"]));				 //수취인정보(이름|이메일|휴대폰|전화번호|팩스|주소)
		$html["dummy6"] = htmlspecialchars(stripslashes($row["dummy6"]));				 //keyword(처리결과확인시 인증암호)				
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