<?	
	### 폼환경설정가져오기 start
	include_once("../../../lib/db_ini.php");		  //DB 접속정보   
	include_once("../../../lib/db_tblname.php");     //생성한 테이블 이름
	include_once("../../../lib/dbconnect.php");      //DB 연결	
	define("TABLE5","".db_tblname."_table");	
	
	$where = "where name='$_GET[fname]'";
	$res_formenv = mysql_query("select * from ".TABLE5." $where limit 1");		 
	$row_formenv = mysql_fetch_array($res_formenv);				 

	if($row_formenv)																						//폼환경설정이 있을 때
		{
		$html["yesorno_pay"] =	htmlspecialchars(stripslashes($row_formenv["yesorno_pay"]));				//신용카드 결제여부
		$html["res_name"] =	htmlspecialchars(stripslashes(iconv("UTF-8","EUC-KR",$row_formenv[res_name]))); //상품이름		
		$html["res_dummy1"] = htmlspecialchars(stripslashes($row_formenv["res_dummy1"]));					//PG 이름				
		$html["res_dummy2"] = htmlspecialchars(stripslashes(iconv("UTF-8","EUC-KR",$row_formenv[res_dummy2])));	//ksnet에 사용될 상호			
		$html["res_dummy3"] = htmlspecialchars(stripslashes(iconv("UTF-8","EUC-KR",$row_formenv[res_dummy3])));	//ksnet에 사용될 도메인
		$html["site_cd"] =	htmlspecialchars(stripslashes($row_formenv["site_cd"]));						//전자결제 사이트코드
		$html["site_key"] =	htmlspecialchars(stripslashes($row_formenv["site_key"]));						//전자결제사이트키
		$html["quotaopt"] =	htmlspecialchars(stripslashes($row_formenv["quotaopt"]));						//할부개월수 0~12
		}
	### 폼환경설정가져오기 end	


	### 애드폼 주문서 접수번호 셋팅 start	
	define("TABLE4","".db_tblname."_order_table");	
	
	
	//function f_af_order_no_set()
	//{
	$headtoken = "m-";
	
	$res_forOrderNo = mysql_query("select * from ".TABLE4." order by no desc limit 1");		 //접수테이블에서 가장 최근행 뽑아옴
	$row_forOrderNo = mysql_fetch_array($res_forOrderNo);				 //위 결과를 배열

	if($row_forOrderNo)															 //접수내역이 있을 때
		{
		$last_af_order_no = explode("-",$row_forOrderNo[1]);					 //년월일 구분자로 부터 배열화

		if($last_af_order_no[1] != date("Ymd"))										 
			{
			$af_order_no_tail = "0001";											 //같은날 접수내역이 없을 때 후미 정의
			}
		else{																		 
			$af_order_no_tail = $last_af_order_no[2] + 1;	
			$mathN = 4;
			$cnt_af_order_no_tail = strlen($af_order_no_tail);
			$addZero = "0";
			for($i = $cnt_af_order_no_tail; $i < $mathN;$i++)
				{
				$af_order_no_tail = $addZero.$af_order_no_tail;					 //같은날 접수내역이 있을 때 후미정의
				}

			}
		 $af_order_no = $headtoken.date("Ymd")."-".$af_order_no_tail;			 //접수번호 셋팅
		}
	else $af_order_no = $headtoken.date("Ymd")."-0001";							 //접수내역이 하나도 없을 때 셋팅
	$af_order_no = str_replace("-","_",$af_order_no);							 //kspay 에서는 - 특수문자넣으면 안되어 치환(result.php 에서 다시치환)

	//$arr = array();
	//$arr["af_order_no"] = $af_order_no;
	//return $arr;
	//}
	### 애드폼 주문서 접수번호 셋팅 end
?>
<?/*------------------------------------------------------------------------------
 FILE NAME : AuthForm.php
 DATE : 2007-04-09
 이페이지는 kspay통합결재창으로 기본거래정보를 넘겨주는 역할을 하는 샘플페이지입니다.
------------------------------------------------------------------------------*/?>
<html>
	<head>
		<title>KSPay</title>
		<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
		<script language="javascript">
		<!--
			/*goOpen() - 함수설명 : 결재에 필요한 기본거래정보들을 세팅하고 kspay통합창을 띄웁니다.*/
			function goOpen() 
			{
				/*kspay통합창에 전달해줄 인자값들을 세팅합니다.*/
				document.authFrmFrame.sndOrdernumber.value     = document.KSPayWeb.sndOrdernumber.value;
				document.authFrmFrame.sndGoodname.value        = document.KSPayWeb.sndGoodname.value;
				document.authFrmFrame.sndInstallmenttype.value = document.KSPayWeb.sndInstallmenttype.value;
				document.authFrmFrame.sndAmount.value          = document.KSPayWeb.sndAmount.value;
				document.authFrmFrame.sndOrdername.value       = document.KSPayWeb.sndOrdername.value;
				document.authFrmFrame.sndAllregid.value        = document.KSPayWeb.sndAllregid.value;
				document.authFrmFrame.sndEmail.value           = document.KSPayWeb.sndEmail.value;
				document.authFrmFrame.sndMobile.value          = document.KSPayWeb.sndMobile.value;
				document.authFrmFrame.sndInteresttype.value    = document.KSPayWeb.sndInteresttype.value;
				document.authFrmFrame.sndCurrencytype.value    = document.KSPayWeb.sndCurrencytype.value;
				document.authFrmFrame.sndWptype.value          = document.KSPayWeb.sndWptype.value;
				document.authFrmFrame.sndAdulttype.value       = document.KSPayWeb.sndAdulttype.value;
				
				document.authFrmFrame.sndReply.value           = getLocalUrl("KSPayRcv.php") ;

				var height_ = 420;
				var width_ = 400;
				var left_ = screen.width;
				var top_ = screen.height;
				
				left_ = left_/2 - (width_/2);
				top_ = top_/2 - (height_/2);
				
				/*kspay통합창을 띄워줍니다.*/
				src = window.open('about:blank','AuthFrmUp',
						'height='+height_+',width='+width_+',status=yes,scrollbars=no,resizable=no,left='+left_+',top='+top_+'');
				document.authFrmFrame.target = 'AuthFrmUp';
				document.authFrmFrame.action ='https://kspay.ksnet.to/store/KSPayWebV1.3/KSPayWeb.jsp';
				document.authFrmFrame.submit();
			}

			function getLocalUrl(mypage) 
			{ 
				var myloc = location.href; 
				return myloc.substring(0, myloc.lastIndexOf('/')) + '/' + mypage;
			} 

			/*에스크로 약관에 대해 동의여부를 선택하도록 합니다. */
			function openKEscrowAgree()
			{
				var height_ = 700;
				var width_ = 650;
				var left_ = screen.width;
				var top_ = screen.height;
				
				left_ = left_/2 - (width_/2);
				top_ = top_/2 - (height_/2);
				
				/* 약관 동의 창을 호출 - KEscrowRcv.html(파일 확장자는 변경가능, 파일 명은 변경 불가능)*/
				var escrow_url = "https://kspay.ksnet.to/store/KSPayWebV1.3/vaccount/kscrow_agree.jsp?sndEscrowReply=" + getLocalUrl("KEscrowRcv.html");
				
				/*kspay통합창을 띄워줍니다.*/
				src = window.open(escrow_url,'AuthFrmUp',
						'height='+height_+',width='+width_+',status=yes,scrollbars=no,resizable=no,left='+left_+',top='+top_+'');
			}

			/* 에스크로 적용된 거래에 대해 선택시  */
			function setPayMethod(p_type)
			{
				if (p_type=='E')
				{
					document.authFrmFrame.sndPaymethod.value = "010000";
					
					var amt = parseInt(document.KSPayWeb.sndAmount.value);
					if (isNaN(amt) || amt < 100000)
					{
						alert("10만원이상을 결제하실 경우에 에스크로를 사용하실 수 있습니다.");
						document.KSPayWeb.pay_type[0].checked = true;
						return false
					}
					
					openKEscrowAgree();
				}else
				if (p_type=='1')
				{
					document.authFrmFrame.sndPaymethod.value = "100000";
				}else
				if (p_type=='2')
				{
					document.authFrmFrame.sndPaymethod.value = "010000";
				}else
				if (p_type=='3')
				{
					document.authFrmFrame.sndPaymethod.value = "001000";
				}else
				if (p_type=='M')
				{
					document.authFrmFrame.sndPaymethod.value = "000001";
				}	
			}
			
			/*goResult() - 함수설명 : 결재완료후 결과값을 지정된 결과페이지(result.php)로 전송합니다.*/
			function goResult(){
				document.KSPayWeb.target = "";
				document.KSPayWeb.submit();
			}
			
			/*paramSet() - 함수설명 : 결재완료후 (KSPayRcv.php로부터)결과값을 받아 지정된 결과페이지(result.php)로 전송될 form에 세팅합니다.*/
			function paramSet(authyn,trno,trdt,trtm,authno,ordno,msg1,msg2,amt,temp_v,isscd,aqucd,remark,result){
				document.KSPayWeb.reAuthyn.value 	= authyn;
				document.KSPayWeb.reTrno.value 		= trno  ;
				document.KSPayWeb.reTrddt.value 	= trdt  ;
				document.KSPayWeb.reTrdtm.value 	= trtm  ;
				document.KSPayWeb.reAuthno.value 	= authno;
				document.KSPayWeb.reOrdno.value 	= ordno ;
				document.KSPayWeb.reMsg1.value 		= msg1  ;
				document.KSPayWeb.reMsg2.value 		= msg2  ;
				document.KSPayWeb.reAmt.value 		= amt   ;
				document.KSPayWeb.reTemp_v.value 	= temp_v;
				document.KSPayWeb.reIsscd.value 	= isscd ;
				document.KSPayWeb.reAqucd.value 	= aqucd ;
				document.KSPayWeb.reRemark.value 	= remark;
				document.KSPayWeb.reResult.value 	= result;
			}
		-->
		</script>
		<style type="text/css">
			BODY{font-size:9pt; line-height:160%}
			TD{font-size:9pt; line-height:160%}
			A {color:blue;line-height:160%; background-color:#E0EFFE}
			INPUT{font-size:9pt;}
			SELECT{font-size:9pt;}
			.emp{background-color:#FDEAFE;}
		</style>
	</head>
	<body style="margin:auto;margin-top:30px;text-align:center;">
		<!----------------------------------------------- <Part 1. KSPayWeb Form에 대한 설명 > ---------------------------------------->
		<!--결제 완료후 결과값을 받아처리할 결과페이지의 주소-->
		<!--KSPAY의 팝업결제창에서 결재가 이루어짐과 동시에 KSPayRcv.php가 구동되면서 아래의 value값이 채워지고 action경로로 값을 전달합니다-->
		<!--action의 경로는 상대경로 절대경로 둘다 사용가능합니다 -->
		<form name=KSPayWeb action = "./result.php" method=post>
		<!-- 결과값 수신 파라메터, value값을 채우지마십시오. KSPayRcv.php가 실행되면서 채워주는 값입니다-->
			<input type=hidden name=reAuthyn value="">
			<input type=hidden name=reTrno   value="">
			<input type=hidden name=reTrddt  value="">
			<input type=hidden name=reTrdtm  value="">
			<input type=hidden name=reAuthno value="">
			<input type=hidden name=reOrdno  value="">
			<input type=hidden name=reMsg1   value="">
			<input type=hidden name=reMsg2   value="">
			<input type=hidden name=reAmt    value="">
			<input type=hidden name=reTemp_v value="">
			<input type=hidden name=reIsscd  value="">
			<input type=hidden name=reAqucd  value="">
			<input type=hidden name=reRemark value="">
			<input type=hidden name=reResult value="">
		<!--업체에서 추가하고자하는 임의의 파라미터를 입력하면 됩니다.-->
			<input type=hidden name='type'   value="<?php echo $_GET[type];?>">
		<!--이 파라메터들은 지정된결과 페이지(result.php)로 전송됩니다.-->			
			<input type=hidden name=a        value="a1">
			<input type=hidden name=b        value="b1">
			<input type=hidden name=c        value="c1">
			<input type=hidden name=d        value="d1">
		<!--------------------------------------------------------------------------------------------------------------------------->
		<table border=0 width=500>
			<tr>
				<td>
					<hr noshade size=1>
					<b><?php echo $html["res_name"];?> 결제</b>
					<hr noshade size=1>
				</td>
			</tr>
		</table>
		<br>
		<table border=0 width=500>
			<tr>
				<td align=center>
					<table width=400 cellspacing=0 cellpadding=0 border=0 bgcolor=#4F9AFF>
						<tr>
							<td>
								<table width=100% cellspacing=1 cellpadding=2 border=0>
									<tr bgcolor=#4F9AFF height=25>
										<td style="text-align:center;color:#fff;">
											정보를 기입하신 후 결제하기 버튼을 눌러주십시오
										</td>
									</tr>
									<tr bgcolor=#FFFFFF>
										<td valign=top>
											<table width=100% cellspacing=0 cellpadding=2 border=0>
												<tr>
													<td align=center>
														<br>
														<table>
															<tr style="display:none;">
															<!----------------------------------------------- < Part 2. 고객에게 보여지지 않는 항목 > ------------------------------------>
															<!--이부분은 결제를 위해 상점에서 기본정보를 세팅해야 하는 부분입니다.														-->
															<!--단 고객에게는 보여지면 안되는 항목이니 테스트 후 필히 hidden으로 변경해주시길 바랍니다.									-->
																<td colspan=2>고객에게 보여지지 않아야 하는 설정값 항목</td>
															</tr>
															<tr style="display:none;">
															<!-- 화폐단위 원화로 설정 : 410 또는 WON -->
																<td>화폐단위 : </td>
																<td><input type=text name=sndCurrencytype size=30 maxlength=3 value="WON"></td>
															</tr>
															<tr style="display:none;">
															<!--주문번호는 30Byte(한글 15자) 입니다. 특수문자 ' " - ` 는 사용하실수 없습니다. 따옴표,쌍따옴표,빼기,백쿼테이션 -->
																<td>주문번호 : </td>
																<td><input type=text name=sndOrdernumber size=30 maxlength=30 value="<?php echo $af_order_no;?>"></td>
															</tr>
															<tr style="display:none;">
															<!--주민등록번호는 필수값이 아닙니다.-->
																<td>주민번호 : </td>
																<td><input type=text name=sndAllregid size=30 maxlength=30 value=""><font color=gray>"-"는 빼고 입력</font></td>
															</tr>
															<tr style="display:none;">
																<td colspan=2><hr></td>
															</tr>
															<tr style="display:none;">
																<td colspan=2>신용카드 기본항목</td>
															</tr>
															<tr style="display:none;">
															<!--상점에서 적용할 할부개월수를 세팅합니다. 여기서 세팅하신 값은 KSPAY결재팝업창에서 고객이 스크롤선택하게 됩니다 -->
															<!--아래의 예의경우 고객은 0~12개월의 할부거래를 선택할수있게 됩니다. -->
																<td>할부개월수  : </td>
																<td><input type=text name=sndInstallmenttype size=30 maxlength=30 value="0:2:3:4:5:6:7:8:9:10:11:12"></td>
															</tr>
															<tr style="display:none;">
															<!--무이자 구분값은 중요합니다. 무이자 선택하게 되면 상점쪽에서 이자를 내셔야합니다.-->
															<!--무이자 할부를 적용하지 않는 업체는 value='NONE" 로 넘겨주셔야 합니다. -->
															<!--예 : 모두 무이자 적용할 때는 value="ALL" / 무이자 미적용할 때는 value="NONE" -->
															<!--예 : 3,4,5,6개월 무이자 적용할 때는 value="3:4:5:6" -->
																<td>무이자구분  : </td>
																<td><input type=text name=sndInteresttype size=30 maxlength=30 value="NONE"></td>
															</tr>
															<tr style="display:none;">
																<td colspan=2><hr></td>
															</tr>
															<tr style="display:none;">
															<!--월드패스카드를 사용하시는 상점만 신경쓰시면 됩니다. 사용하지 않는 상점은 아무값이나 넘겨주시면 됩니다. 지우시면 안됩니다.-->	
																<td colspan=2>월드패스카드 기본항목</td>
															</tr>
															<tr style="display:none;">
																<TD>선/후불카드구분 :</TD>
																<TD>
																		<input type=text    name=sndWptype value="1">
																		<!--
																		<input type="radio" name="sndWptype" value="1" checked>선불카드
																		<input type="radio" name="sndWptype" value="2">후불카드
																		<input type="radio" name="sndWptype" value="0">모든카드             
																		-->
																</TD>
															</TR>
															<tr style="display:none;">
																<TD>성인확인여부 :</TD>
																<TD>
																	<input type="text" name="sndAdulttype" value="1">
																	<!--
																	<input type="radio" name="sndAdulttype" value="1" checked>성인확인필요
																	<input type="radio" name="sndAdulttype" value="0">성인확인불필요   
																	-->
																</TD>
															</tr>
															<tr>
																<td colspan=2><hr></td>
															</tr>

															<!----------------------------------------------- <Part 3. 고객에게 보여주는 항목 > ----------------------------------------------->

															<tr>
															<!--상품명은 30Byte(한글 15자)입니다. 특수문자 ' " - ` 는 사용하실수 없습니다. 따옴표,쌍따옴표,빼기,백쿼테이션 -->
																<td>구매상품 : </td>
																<td><input type=text name=sndGoodname size=30 maxlength=30 value="<?php echo $html["res_name"];?>" readonly></td>
															</tr>
															<tr>
																<td>결제금액 : </td>
																<td><input type=text name=sndAmount size=30 maxlength=9 value="<?php echo str_replace(",","",$_GET[res_mny]);?>" readonly></td>
															</tr>
															<tr>
																<td>고객이름 : </td>
																<td><input type=text name=sndOrdername size=30 maxlength=20 value="<?php echo iconv("UTF-8","EUC-KR",$_GET[cname]);?>"></td>
															</tr>
															<!--KSPAY에서 결제정보를 메일로 보내줍니다.(신용카드거래에만 해당)-->
															<tr>
																<td>전자우편 : </td>
																<td>
																<input type=text name=sndEmail size=30 maxlength=50 value="<?php echo iconv("UTF-8","EUC-KR",$_GET[cemail]);?>">
																</td>
															</tr>	
															<!--카드사에 SMS 서비스를 등록하신 고객에 한해서 SMS 문자메세지를 전송해 드립니다.-->
															<!--전화번호 value 값에 숫자만 넣게 해주시길 바랍니다. : '-' 가 들어가면 안됩니다.-->
															<tr>
																<td>이동전화 : </td>
																<td>
																<input type=text name=sndMobile size=30 maxlength=20 value="<?php echo str_replace("-","",$_GET[chp]);?>">	
																</td>
															</tr>
															<TR>
																<td>결제방법 :	</td>
																<td>
																	<input type="radio" name="pay_type" onclick="javascript:setPayMethod('1')" value="1" checked>신용카드
																	<!--<br>
																	<input type="radio" name="pay_type" onclick="javascript:setPayMethod('2')" value="2" >무통장입금
																	<br>
																	<input type="radio" name="pay_type" onclick="javascript:setPayMethod('3')" value="3" >계좌이체
																	<br>
																	<input type="radio" name="pay_type" onclick="javascript:setPayMethod('E')" value="E" >무통장입금(에스크로)
																	<br>
																	<input type="radio" name="pay_type" onclick="javascript:setPayMethod('M')" value="M" >휴대폰결제-->
																</td>
															</tr>
															<!--
															<TR>
																<TD conspan='2'>
																	10만원이상 현금결제시 무통장입금(에스크로)를 선택하시면 결제대금을 거래완료시까지 KSNET에서 안전하게 보관해 드립니다.
																</TD>
															</tr>
															-->
															<tr>
																<td colspan=2 align=center>
																<br>
																<input type="button" value=" 결제하기 " onClick="javascript:goOpen();" style="width:150px;height:35px;">
																<br><br>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<br>

		<table border=0 width=500>
			<tr>
				<td style="text-align:center;color:gray;">					
				전자우편과 이동전화번호를 입력받는 것은 귀하의 지불내역을 이메일 또는 SMS로
				알려드리기 위함이오니 반드시 기입하여 주시기 바랍니다.			
				</td>
			</tr>			
			<tr>
				<td><hr noshade size=1></td>
			</tr>
		</table>
		</form>
		<!--dummy.php는 보안경고를 방지하기 위한 것입니다. 수정하지 마세요. -->
		<IFRAME id=AuthFrame name=AuthFrame style="display:none" src="dummy.php"></IFRAME>
		<div style="display:none"> 
			<!----------------------------------------------- <Part 4. authFrmFrame Form에 대한 설명 >----------------------------------------------->
			<!-- 상점에서 KSNET 결제팝업창으로 전송하는 파라메터입니다.-->
			<form name=authFrmFrame target=AuthFrame method=post>

			<!-- 초기 신용카드 테스트 ID : 2999199999 / 에스크로 테스트 ID : 2999199998, 테스트 종료 후 KSPAY에서 발급받은 실제 상점아이디로 바꿔주십시오.-->
			<!-- 테스트아이디로 테스트하실 때 실제카드로 결제하셔도 고객에게 청구되지 않습니다. -->
				<input type=hidden name=sndStoreid         value="<?php echo $html["site_cd"];?>">
				<!--<input type=hidden name=sndStoreid         value="2999199999">테스트아이디->
				

			<!-- backUrl은 사용하지 않으셔도 무방한 옵션기능입니다.BackUrl파일명까지 경로값을 넣어주시길 바랍니다. 
			그리고 backurl에서 데이터를 쇼핑몰 DB에 업데이트 작업을 추가로 해주셔야 합니다. -->
				<input type=hidden name=sndBackUrl         value=""> 

			<!-- goOpen()에서 사용자가 접속한 URL을 받아와서 sndReply의 값에 세팅합니다.
			sndReply는 KSPayRcv.php(결제승인 후 결과값들을 본창의 KSPayWeb Form에 넘겨주는 페이지)의 절대경로를 넣어줍니다. -->
				<input type=hidden name=sndReply           value="">

			<!--KSPAY 결제팝업창에서 사용가능한 결제수단을 세팅합니다. 각 결재수단은 각각의 계약이 이루어져 오픈되있어야 사용가능합니다.-->
			<!--신용카드/가상계좌/계좌이체/월드패스카드/포인트/휴대폰결제-->
			<!--예 : 신용카드,가상계좌,월드패스카드 선택 value="110100' -->
				<input type=hidden name=sndPaymethod       value="100000"> <!-- 순서 : 신용카드, 가상계좌, 계좌이체, 월드패스카드, OK Cashbag, 휴대폰 -->
				<input type=hidden name=sndEscrow          value="0">				<!--에스크로적용여부-- 0: 적용안함, 1: 적용함 -->
				<input type=hidden name=sndOrdernumber	   value="">
				<input type=hidden name=sndGoodname        value="">
				<input type=hidden name=madeCompany	       value="">
				<input type=hidden name=madeCountry	       value="">
				<input type=hidden name=sndInstallmenttype value="">
				<input type=hidden name=sndAmount          value="">
				<input type=hidden name=sndOrdername       value="">
				<input type=hidden name=sndAllregid        value="">
				<input type=hidden name=sndEmail           value="">
				<input type=hidden name=sndMobile          value="">
				<input type=hidden name=sndInteresttype    value="">
				<input type=hidden name=sndCurrencytype    value="">
				<input type=hidden name=sndCashbag         value="0">          <!--OK CashBag-- 0: 미사용, 1: 사용 -->
				<input type=hidden name=sndWptype          value="">
				<input type=hidden name=sndAdulttype       value="">
				<input type=hidden name=sndStoreName       value="<?php echo $html["res_dummy2"];?>">   <!--회사명을 한글로 넣어주세요(최대20byte)-->
				<input type=hidden name=sndStoreNameEng    value="kspay_store">   <!--회사명을 영어로 넣어주세요(최대20byte)-->
				<input type=hidden name=sndStoreDomain     value="<?php echo $html["res_dummy3"];?>">   <!-- 회사 도메인을 http://를 포함해서 넣어주세요-->
				<input type=hidden name=sndCertimethod	   value="IM">    <!-- I  : ISP결제, M : MPI결제, N : 해외카드 -->
				<input type=hidden name=sndGoodType		   value="1">			<!--실물(1) / 디지털(2) -->
			</form>
		</div>
	</body>
</html>
<!--이 페이지에 있는 모든 파라메터는 지우시거나 변경하시면 결제가 이루어지지 않습니다.-->