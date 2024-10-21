<?php
include_once("lib/lib.php");
include_once("lib/C_CONNECT.php");
include_once("lib/define_table.php");
include_once("function/f_af_attachFileUpload.php");
include_once("function/f_af_order_no_set.php");
include_once("function/f_get_afTABLE4.php");
include_once("function/f_get_afTABLE5.php");
include_once("function/f_get_afTABLE1.php");

/* ----------------------------------------------------------------------------------- */
/*	프로그램명 : 애드폼(영문 addform												   */									
/*	프로그램용도: 견적서 주문서 폼메일 제작											   */
/*	제작자: 박성규																	   */
/*	공식배포처: http://www.addform.net												   */
/*  프로그램 편집시 위 제작자 정보를 편집하거나 삭제해서는 안됩니다.				   */
/* ----------------------------------------------------------------------------------- */													  
$af_TABLE1 = f_get_afTABLE1("no","1");

//관리자 보기 일 때는 인증모듈 실행
if( $_GET['mode'] == "admine") {include_once("lib/authentication.php");}

if($_POST['mode'] == "post")
{
	//결제했을 때
	if($_POST["pay_order_no"])
	{
		$od_no = $_POST["pay_order_no"];							//결제했을때는 주문번호로 대체하고	
	}
	else
	{
		$f_af_order_no_set = f_af_order_no_set("formmail");			//결제안했을때는 접수번호 셋팅 함수 실행
		$od_no = $f_af_order_no_set["af_order_no"];	
	}
if($_POST["tno"]) $pay_cancle = "on";								//kcp 결제취소여부(on,off=취소)
}

//첨부파일있을 때 업로드 함수 실행
$f_af_attachFileUpload = f_af_attachFileUpload();

#########################################################################################
###########			관리자모드 아닐 때 접수내역 폼으로 부터 받아오기		 ############	
#########################################################################################
if($_POST['mode'] == "post")
{
$clean=array();
	
		$clean['client_name'] = $_POST['client_name'];						//폼으로 부터 받은 고객 이름
		$clean['client_tel'] = $_POST['client_tel'];						//폼으로 부터 받은 고객	전화번호	
		$clean['client_hp'] = $_POST['client_hp'];							//폼으로 부터 받은 고객	휴대폰
		$clean['client_fax'] = $_POST['client_fax'];						//폼으로 부터 받은 고객	fax
		$clean['client_email'] = $_POST['client_email'];					//폼으로 부터 받은 고객	이메일
		$clean['client_address'] = $_POST['client_address'];				//폼으로 부터 받은 고객 주소
		$clean['client_memo'] = $_POST['client_memo'];						//폼으로 부터 받은 고객 메모
		$clean['total_data'] = $_POST['total_data'];						//폼으로 부터 받은 데이타
		$clean['total_sum'] = $_POST['total_sum'];							//폼으로 부터 받은 합  계	
																			//폼으로 부터 받은 합  계에서 쉼표제거
		$clean['total_sum'] = str_replace(",","",$clean['total_sum']);						
		$clean['total_sum2'] = $_POST['total_sum2'];						//폼으로 부터 받은 한자,한글 합  계
		$clean['shipTo'] = $_POST["shipTo"];								//폼으로 부터 받은 수취인정보		
	

$arr_formdata = explode("|*|",$clean['total_data']);						//"|*|" 구분자로 1차 배열			
					$it_name = explode(";",$arr_formdata[0]);				//1.품목이름 2차배열
					$opt_text = explode(";",$arr_formdata[1]);				//2.옵션제목 2차배열 
					$opt_price = explode(";",$arr_formdata[2]);				//3.옵션가격 2차배열
					$it_unit = explode(";",$arr_formdata[3]);				//4.품목규격 2차배열
					$it_num = explode(";",$arr_formdata[4]);				//5.주문수량 2차배열
					$it_price = explode(";",$arr_formdata[5]);				//6.품목단가 2차배열
					$it_sumPrice = explode(";",$arr_formdata[6]);			//7.공급가액 2차배열
					$it_price_taxDB = explode(";",$arr_formdata[7]);		//8.세	  율 2차배열
				if(!$it_price_taxDB)$it_price_taxDB = 0;

$arr_formdata2 = explode("|",$clean['total_sum2']);							//"|" 구분자로 배열			
					$total_kr = $arr_formdata2[0];							//1. 한글 합계
					$total_china = $arr_formdata2[1];						//2. 한자 합계

$arr_shipTo = explode("|",$clean['shipTo']);					
					$shipTo_name = $arr_shipTo[0];							//첫번째 배열요소를 수취인이름으로...
					$shipTo_email = $arr_shipTo[1];
					$shipTo_hp = $arr_shipTo[2];
					$shipTo_tel = $arr_shipTo[3];
					$shipTo_fax = $arr_shipTo[4];
					$shipTo_address = $arr_shipTo[5];
}


#########################################################################################
############	관리자모드일 때 DB 접수내역 테이블에서 가져오기			   ##############	
#########################################################################################
if($_GET['mode'] == "admine")
{
$af_TABLE4 = f_get_afTABLE4("no",$_GET['order_no']);						//DB접수목록 테이블에서 가져오기

$arr_formdata = explode("|*|",$af_TABLE4["select_items"]);					//"|*|" 구분자로 1차 배열			
					$it_name = explode(";",$arr_formdata[0]);				//1.품목이름 2차배열
					$opt_text = explode(";",$arr_formdata[1]);				//2.옵션제목 2차배열 
					$opt_price = explode(";",$arr_formdata[2]);				//3.옵션가격 2차배열
					$it_unit = explode(";",$arr_formdata[3]);				//4.품목규격 2차배열
					$it_num = explode(";",$arr_formdata[4]);				//5.주문수량 2차배열
					$it_price = explode(";",$arr_formdata[5]);				//6.품목단가 2차배열
					$it_sumPrice = explode(";",$arr_formdata[6]);			//7.공급가액 2차배열
					$it_price_taxDB = explode(";",$arr_formdata[7]);		//8.세	  율 2차배열
				if(!$it_price_taxDB)$it_price_taxDB = 0;

$arr_formdata2 = explode("|",$af_TABLE4["dummy4"]);							//"|" 구분자로 배열			
					$total_kr = $arr_formdata2[0];							//1. 한글 합계
					$total_china = $arr_formdata2[1];						//2. 한자 합계

$arr_shipTo = explode("|",$af_TABLE4["dummy5"]);					
					$shipTo_name = $arr_shipTo[0];							//첫번째 배열요소를 수취인이름으로...
					$shipTo_email = $arr_shipTo[1];
					$shipTo_hp = $arr_shipTo[2];
					$shipTo_tel = $arr_shipTo[3];
					$shipTo_fax = $arr_shipTo[4];
					$shipTo_address = $arr_shipTo[5];

$arr_read['dummy6'] = "1";													//열람시 읽은횟수1...v7.1pro
$where = "where no=".$af_TABLE4['no'];										//조건절	
$DBconn->f_updateDB(TABLE4,&$arr_read,$where);							
}



######################	주문서와 견적서출력에 소숫점 반영 여부   ######################## 
##### 선택한 품목만 반영위해  폼테이블보다 위POST나 접수테이블에서 참고하는게 바람직 ####

	if (substr_count($arr_formdata[2],".") > 0){							//옵션값에서 소수출현회수
		$opt_price_dot = "yes";
	}
	else $opt_price_dot = "no";

	if (substr_count($arr_formdata[5],".") > 0){							//품목값에서 소수출현횟수
		$it_price_dot = "yes";
	}
	else $it_price_dot = "no";

	if ($opt_price_dot == "yes" || $it_price_dot == "yes"){					//둘 중 하나라도 소수가 있다면
		$number_formatN = "2";
	}
	else $number_formatN = "0";



$today = date("Y/m/d");														//현재시각
$input_date = date("Y/m/d",$af_TABLE4["input_date"]);						//등록시각

if($_POST['mode'] == "post"){
	$af_TABLE4["input_date"] = $today;
}
else{
	$af_TABLE4["input_date"] = $input_date;
}
				

#########################################################################################
#############		관리자 모드가 아닐 때 DB 폼테이블로 부터 가져오기	   ##############
#########################################################################################
if($_POST['mode'] == "post")
{
$af_TABLE5 = f_get_afTABLE5("no",$_POST['form_no']);
}


#########################################################################################
#############		관리자 모드일 때 DB 폼테이블로 부터 가져오기		   ##############
#########################################################################################
if($_GET['mode'] == "admine")
{
$af_TABLE5 = f_get_afTABLE5("name",$af_TABLE4["mom"]);
}

########################################################################################
$bankingArr = explode("|",$af_TABLE1["banking"]);							//banking 필드의 구분자로 부터 배열화
	$bank_name = $bankingArr[0];											//첫번째 배열요소를 은행이름으로...
	$bank_num = $bankingArr[1];												//두번째 배열요소를 계좌번호로...
	$bank_who = $bankingArr[2];												//세번째 배열요소를 예금주로..
			
		
$af_sectionArr = explode("|",$af_TABLE5["dummy3"]);							//dummy3 필드의 구분자로 부터 배열화	

$af_smsArr = explode("|",$af_TABLE5["dummy5"]);								//SMS
	$af_sms_yesorno = $af_smsArr[0];
	$af_sms_cp = $af_smsArr[1];						
	$af_sms_id = $af_smsArr[2];						
	$af_sms_pw = $af_smsArr[3];						
	$af_sms_toDB = $af_smsArr[4];

//$af_telArr = explode("|",$af_TABLE5["tel"]);						
	//$af_sup_tel = $af_telArr[0];											//첫번째 배열요소를 공급자전화번호로...
	//$af_sup_fax = $af_telArr[1];											//두번째 배열요소를 공급자팩스번호로...

if(!$af_TABLE5["client_text_name"]) $af_TABLE5["client_text_name"] = "".af_txt_form_add_47."";
if(!$af_TABLE5["client_text_email"]) $af_TABLE5["client_text_email"] = "".af_txt_form_add_48."";
if(!$af_TABLE5["client_text_hp"]) $af_TABLE5["client_text_hp"] = "".af_txt_form_add_49."";
if(!$af_TABLE5["client_text_tel"]) $af_TABLE5["client_text_tel"] = "".af_txt_form_add_50."";
if(!$af_TABLE5["client_text_fax"]) $af_TABLE5["client_text_fax"] = "".af_txt_form_add_51."";
if(!$af_TABLE5["client_text_address"]) $af_TABLE5["client_text_address"] = "".af_txt_form_add_52."";
if(!$af_TABLE5["client_text_memo"]) $af_TABLE5["client_text_memo"] = "".af_txt_form_add_53."";



#########################################################################################
########	  관리자모드가 아닐 때	DB 접수목록 테이블에 업데이트			   ##########
#########################################################################################
if($_POST['mode'] == "post")
{
	$array['af_order_no'] = $od_no;											//접수번호
	$array['mom'] = $af_TABLE5["name"];										//폼의 이름
	$array['client_name'] = $clean['client_name'];							//고객이름
	$array['client_tel'] =	$clean['client_tel'];							//폼으로 부터 받은 고객	전화번호	
	$array['client_hp'] = $clean['client_hp'];								//폼으로 부터 받은 고객	휴대폰
	$array['client_fax'] = $clean['client_fax'];							//폼으로 부터 받은 고객	fax
	$array['client_email'] = $clean['client_email'];						//폼으로 부터 받은 고객	이메일
	$array['client_address'] = $clean['client_address'];					//폼으로 부터 받은 고객 주소
	$array['client_memo'] = $clean['client_memo'];							//폼으로 부터 받은 고객 메모
	$array['hostinfo'] = $_SERVER['REMOTE_ADDR'];							//고객 아이피주소
	$array['input_date'] = time();											//접수시각
	$array['select_items'] = $clean['total_data'];							//폼으로 부터 받은 데이타
	$array['sum'] = $clean['total_sum'];									//폼으로 부터 받은 합  계	
		
	$array['dummy1'] = $af_TABLE5["title_text"];							//폼의 제목
	$array['dummy2'] = $af_TABLE5["form_type"];								//폼의 형식

	$array['dummy4'] = $clean['total_sum2'];								//한자,한글 합 계
	$array['dummy5'] = $clean['shipTo'];									//수취인정보배열

	if($f_af_attachFileUpload["upload_result"] == "true")
		{
		$array['dummy3'] = $f_af_attachFileUpload["fileName"];				//첨부된 파일이름
		}

	$array['tno'] = $_POST["tno"];												//kcp 거래 고유번호(취소/매입시 사용)
	$array['pay_cancel'] = $pay_cancle;											//kcp 결제취소(on,off=취소)		


//DB 입력f_InsertDB(테이블이름,&$array)
//&$array배열을 참조연산자&로 넘겨주어 보다 빠르게 처리
$DBconn->f_InsertDB(TABLE4,&$array);
}

?>
<!--##################################################################################-->
<!-- ####################	주문내역 출력 및 이메일로 보내기 start	################# -->
<!--##################################################################################-->
<?
ob_start();																	//출력을 내부버퍼에 저장 start												
		include "skins/".$af_TABLE5["skin_name"]."/sheet/order.html";				//출력될 문서가있는 스킨의 경로
		$af_contens = ob_get_contents();									//버퍼링된것을 문자열변수에 저장
		ob_end_flush();														//버퍼링된것을 출력
		ob_end_clean();														//버퍼를 비움 end
		


	//관리자모드가 아닐 때 메일 발송 및 sms 통보
	if($_POST['mode'] == "post")
	{	
		if($af_TABLE5["dummy11"] == "1")
		{
			//#########################	관리자에게 메일 발송	#########################//
			$arr = "";
			$arr = array();
			$arr[name] = $clean['client_name'];									//주문하는 고객 이름
			$arr[from] = $clean['client_email'];								//주문하는 고객 이메일
			$arr[to] = $af_TABLE5["email_address"];								//전송받을 관리자 이메일
			$arr[subject] = "[".$clean['client_name']."] ".$af_TABLE5["title_text"];//메일 제목
			$arr[body] = $af_contens;											//전송될 내용 또는 인클루드 문서
																				//메일 보내기 함수 호출
			F_MIME($arr,$f_af_attachFileUpload["upload_result"],"toAdmine");
		}
		
		if($af_TABLE5["dummy12"] == "1")
		{
			//#########################	고객 에게 메일 발송		#########################//
			$arr = "";
			$arr = array();
			$arr[name] = $af_TABLE1["supply_name"];								//공급자 상호 또는 이름
			$arr[from] = $af_TABLE5["email_address"];							//공급자 이메일
			$arr[to] = $clean['client_email'];									//전송받을 고객 이메일
			$arr[subject] = $clean['client_name']."님의 ".$af_TABLE5["title_text"]." - 주문이 완료되었습니다";//메일 제목
			$arr[body] = $af_contens;											//전송될 내용 또는 인클루드 문서
			
			if($clean['client_email'])
			{																	//메일 보내기 함수 호출
			F_MIME($arr,$f_af_attachFileUpload["upload_result"],"toClient");		
			}
		}
		
		//##################    SMS 문자메시지 알림			  #######################//
		if($af_sms_yesorno == "1")
		{
				$sms_adminMsg = "[".$clean["client_name"]."] ".$af_TABLE5["sms_msg"];
				include "plugin/sms/".$af_sms_cp."/sms_toAdmin.php";			//관리자에게 발송
			if($clean['client_hp'])
			{
				$sms_clientMsg = "[".$af_TABLE5["title_text"]."] ".$af_TABLE5["dummy19"];
				include "plugin/sms/".$af_sms_cp."/sms_toClient.php";			//고객에게 발송
			}
		}		
	}


?>
<!-- ####################	주문내역 출력 및 이메일로 보내기 end	################# -->
<!--##################################################################################-->


<!-- 관리자 모드가 아닐 때, 전송완료 메시지 띄움  -->
<?php if($_POST['mode'] == "post"){?>
<script type="text/javascript">
<!--
alert("<?php echo af_txt_order_3;?>");
-->
</script>
<?php }?>

<div class="print" style="text-align:center;">
<!-- 프린트 버튼 출력 -->
<?php echo F_print()?>
<!-- 관리자 모드가 아닐 때, return url 실행  -->
 <?php 
 if(!$af_TABLE5['return_url']) $af_TABLE5['return_url'] = "view_list.php?mode=nameMode&fname=".$af_TABLE5['name']."";
 if($_POST['mode'] == "post")
 {	
	if($af_TABLE5['return_type']=="auto")
	{
		if($af_TABLE5['dummy18']=="1")
		{
			 die("<script>top.location.href='".$af_TABLE5['return_url']."'</script>"); 
		}
		else die("<meta http-equiv=refresh content='0;url=".$af_TABLE5['return_url']."'>");
	}
	else
	{
		if($af_TABLE5['dummy18']=="1")
		{
			 die("<input type='button' value='Back' onclick=\"top.location.href='".$af_TABLE5['return_url']."'\" style='height:30px;width:100px;'>");
		}
		else die("<input type='button' value='Back' onclick=\"location.href='".$af_TABLE5['return_url']."'\" style='height:30px;width:100px;'>");
	}
 }
 ?>
 </div>


</body>
</html>