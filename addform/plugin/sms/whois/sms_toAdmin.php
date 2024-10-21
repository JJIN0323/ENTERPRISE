<?php
	include_once("xmlrpc.inc.php");
	include_once("class.EmmaSMS.php");

	
		$sms_msg = $sms_adminMsg;
		$sms_to = $af_sms_toDB;				//수신휴대폰
		$sms_from = $af_sms_toDB;//2015.11.03 고객휴대폰 없을때는 관리자의 번호로
		
		$sms_date = "";						//예약일시
		
		$sms = new EmmaSMS();
		$sms->login($af_sms_id, $af_sms_pw);// $sms->login( [고객 ID], [고객 패스워드]);
		$ret = $sms->send($sms_to, $sms_from, $sms_msg, $sms_date);
		
		if(!$ret) echo $sms->errMsg;		//정상결과가 없다면 에러코드 출력

?>
