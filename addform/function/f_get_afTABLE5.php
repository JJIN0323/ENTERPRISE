<?
#########################################################################################
#####################		애드폼 테이블에서 정보 가져옴				  ###############
#########################################################################################
function f_get_afTABLE5($fld,$kw)
{
global $DBconn;
$where="where $fld='$kw'";
$re=$DBconn->f_selectDB("*",TABLE5,$where);						
$result = $re[result];
$row =  mysql_fetch_array($result);
	$html = array();

		$html["no"] = htmlspecialchars(stripslashes($row["no"]));								//고유번호
		$html["no_group"] = htmlspecialchars(stripslashes($row["no_group"]));					//속할 그룹번호
		$html["form_type"] = htmlspecialchars(stripslashes($row["form_type"]));					//폼형식
		$html["input_date"] = htmlspecialchars(stripslashes($row["input_date"]));				//생성시각
		$html["edit_date"] = htmlspecialchars(stripslashes($row["edit_date"]));					//수정시각
		$html["name"] = htmlspecialchars(stripslashes($row["name"]));							//폼이름		
		$html["title_text"] = htmlspecialchars(stripslashes($row["title_text"]));				//제 목
		$html["msg_top"] = stripslashes($row['msg_top']);								//상단 메시지
		$html["msg_bottom"] = stripslashes($row['msg_bottom']);							//하단 메시지
		$html["top_img"] = htmlspecialchars(stripslashes($row['top_img']));					    //상단 배너 이미지
		$html["bottom_img"] = htmlspecialchars(stripslashes($row['bottom_img']));				//하단 배너 이미지
		$html["width"] = htmlspecialchars(stripslashes($row['width']));						    //너	비
		$html["coin_unit"] = htmlspecialchars(stripslashes($row["coin_unit"]));					//통화단위	
		$html["secret_price"] = htmlspecialchars(stripslashes($row["secret_price"]));			//산출금액 비밀 여부		
		$html["email_address"] = htmlspecialchars(stripslashes($row["email_address"]));			//관리자 이메일
		$html["tel"] = htmlspecialchars(stripslashes($row["tel"]));								//전화번호(공급자)
		$html["supply_name"] = htmlspecialchars(stripslashes($row["supply_name"]));				//사업자상호(공급자)
		$html["supply_num"] =htmlspecialchars(stripslashes( $row["supply_num"]));				//사업자등록번호(공급자)
		$html["supply_man"] = htmlspecialchars(stripslashes($row["supply_man"]));				//사업자대표(공급자)
		$html["supply_address"] = htmlspecialchars(stripslashes($row["supply_address"]));		//사업장주소(공급자)
		$html["supply_conditions"] = htmlspecialchars(stripslashes($row["supply_conditions"]));	//업태(공급자)
		$html["supply_item"] = htmlspecialchars(stripslashes($row["supply_item"]));				//종목(공급자)
		$html["sell_num"] = htmlspecialchars(stripslashes($row["sell_num"]));					//통신판매번호
		$html["skin_name"] = htmlspecialchars(stripslashes($row["skin_name"]));					//스킨이름		
		$html["use_report_email"] = htmlspecialchars(stripslashes($row["use_report_email"]));	//관리자에게 이메일 전송여부
		$html["banking"] = htmlspecialchars(stripslashes($row["banking"]));						//공급자 무통장입금 은행
		$html["count_field"] = htmlspecialchars(stripslashes($row["count_field"]));				//접속통계
		$html["etc"] = htmlspecialchars(stripslashes($row["etc"]));								//비    고	
		$html["max_file_size"] = htmlspecialchars(stripslashes($row["max_file_size"]));			//html 폼 첨부파일용량
		$html["attachFormat"] = htmlspecialchars(stripslashes($row["attachFormat"]));			//첨부파일 허용 확장자
		$html["client_items"] = htmlspecialchars(stripslashes($row["client_items"]));			//고객모듈 항목들
		$html["client_text_name"] = htmlspecialchars(stripslashes($row["client_text_name"]));
		$html["client_text_email"] = htmlspecialchars(stripslashes($row["client_text_email"]));
		$html["client_text_hp"] = htmlspecialchars(stripslashes($row["client_text_hp"]));
		$html["client_text_tel"] = htmlspecialchars(stripslashes($row["client_text_tel"]));
		$html["client_text_fax"] = htmlspecialchars(stripslashes($row["client_text_fax"]));
		$html["client_text_address"] = htmlspecialchars(stripslashes($row["client_text_address"]));
		$html["client_text_memo"] = htmlspecialchars(stripslashes($row["client_text_memo"]));	
		$html["sign_img"] = htmlspecialchars(stripslashes($row["sign_img"]));					//견적서 도장 이미지
		$html["font_family"] = htmlspecialchars(stripslashes($row["font_family"]));
		$html["font_size"] = htmlspecialchars(stripslashes($row["font_size"]));
		$html["font_color"] = htmlspecialchars(stripslashes($row["font_color"]));
		$html["layout"] =	htmlspecialchars(stripslashes($row["layout"]));
		$html["return_url"] =	htmlspecialchars(stripslashes($row["return_url"]));				//전송 후 리턴페이지
		$html["return_type"] =	htmlspecialchars(stripslashes($row["return_type"]));			//전송 후 리턴방법 auto,click
		$html["yesorno_pay"] =	htmlspecialchars(stripslashes($row["yesorno_pay"]));			//신용카드 결제여부
		$html["res_name"] =	htmlspecialchars(stripslashes($row["res_name"]));					//예약상품이름
		$html["res_mny"] =	htmlspecialchars(stripslashes($row["res_mny"]));					//예약비용
		$html["res_dummy1"] = htmlspecialchars(stripslashes($row["res_dummy1"]));				
		$html["res_dummy2"] = htmlspecialchars(stripslashes($row["res_dummy2"]));				
		$html["res_dummy3"] = htmlspecialchars(stripslashes($row["res_dummy3"]));
		$html["site_cd"] =	htmlspecialchars(stripslashes($row["site_cd"]));					//전자결제 사이트코드
		$html["site_key"] =	htmlspecialchars(stripslashes($row["site_key"]));					//전자결제사이트키
		$html["quotaopt"] =	htmlspecialchars(stripslashes($row["quotaopt"]));					//할부개월수 0~12
		$html["sms_msg"] =	htmlspecialchars(stripslashes($row["sms_msg"]));					//문자메시시 제목
		$html["dummy1"] =	htmlspecialchars(stripslashes($row["dummy1"]));					    //파일첨부기능 여부
		$html["dummy2"] =	htmlspecialchars(stripslashes($row["dummy2"]));					    //유효일
		$html["dummy3"] =	htmlspecialchars(stripslashes($row["dummy3"]));					    //주문/견적서항목 표시법
		$html["dummy4"] =	htmlspecialchars(stripslashes($row["dummy4"]));					    //견적서 합계표시방법
		$html["dummy5"] =	htmlspecialchars(stripslashes($row["dummy5"]));						//SMS
		$html["dummy6"] =	htmlspecialchars(stripslashes($row["dummy6"]));						//부가세 반영여부(아니오0,예1)		
		$html["dummy7"] =	htmlspecialchars(stripslashes($row["dummy7"]));						//첨부파일개수
		$html["dummy8"] =	htmlspecialchars(stripslashes($row["dummy8"]));						//폼메일 계산기능(아니오0,예1)
		$html["dummy9"] =	htmlspecialchars(stripslashes($row["dummy9"]));						//폼 구간카운터(ver 5.3)
		$html["dummy10"] =	stripslashes($row["dummy10"]);										//기본고객정보 타이틀(ver 5.4)
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