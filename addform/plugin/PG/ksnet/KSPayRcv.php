<? 
mb_http_input("euc-kr"); 
mb_http_output("euc-kr"); 
?>
<?
/*------------------------------------------------------------------------------
 FILE NAME : KSPayRcv.php
 DATE : 2006-09-01
 이페이지는 kspay통합결재창으로부터 거래결과를 받아 가맹점결재페이지로 거래결과를 넘기는 역할을 합니다.
------------------------------------------------------------------------------*/

// 공통--------------------------------------------------------------------------------------
    $reEncType       = $_POST["reEncType"];                          // 암호화구분                                  
    $reVersion       = $_POST["reVersion"];                          // 전문버전                                    
    $reType          = $_POST["reType"];                             // 전문구분                                    
    $reResend        = $_POST["reResend"];                           // 전송구분                                    
    $reRequestDate   = $_POST["reRequestDate"];                      // 요청일                                      
    $reStoreId       = $_POST["reStoreId"];                          // 상점아이디                                  
    $reOrderNumber   = $_POST["reOrderNumber"];                      // 주문번호                                    
    $reOrderName     = $_POST["reOrderName"];                        // 주문자명                                    
    $reAllRegid      = $_POST["reAllRegid"];                         // 주민번호                                    
    $reEmail         = $_POST["reEmail"];                            // 이메일                                      
    $reGoodType      = $_POST["reGoodType"];                         // 상품구분 1:실물, 2: 디지털                  
    $reGoodName      = $_POST["reGoodName"];                         // 상품명                                      
    $reKeyInType     = $_POST["reKeyInType"];                        // Keyin구분 K : Keyin                         
    $reLineType      = $_POST["reLineType"];                         // 유무선구분 0: offline, 1: online(internet)  
    $reMobile        = $_POST["reMobile"];                           // 휴대폰번호                                  
    $reApprovalCount = $_POST["reApprovalCount"];                    // 전문갯수                                    
    $reHeadFiller    = $_POST["reHeadFiller"];                       // 예비                                        
    $reApprovalType  = $_POST["reApprovalType"];                     // 승인구분                                    
                                                                                                                             
// 신용카드--------------------------------------------------------------------------------------                            
    $reTransactionNo     = $_POST["reTransactionNo"];                // 거래번호                                    
    $reStatus            = $_POST["reStatus"];                       // 상태                                        
    $reTradeDate         = $_POST["reTradeDate"];                    // 거래일자                                    
    $reTradeTime         = $_POST["reTradeTime"];                    // 거래시간                                    
    $reIssCode           = $_POST["reIssCode"];                      // 발급사코드                                  
    $reAquCode           = $_POST["reAquCode"];                      // 매입사코드                                  
    $reAuthNo            = $_POST["reAuthNo"];                       // 승인번호                                    
    $reMessage1          = $_POST["reMessage1"];                     // 메시지1                                     
    $reMessage2          = $_POST["reMessage2"];                     // 메시지2                                     
    $reCardNo            = $_POST["reCardNo"];                       // 카드번호14자리+XXXX                         
    $reExpDate           = $_POST["reExpDate"];                      // 유효기간 YYMM                               
    $reInstallment       = $_POST["reInstallment"];                  // 할부개월수                                  
    $reAmount            = $_POST["reAmount"];                       // 금액                                        
    $reMerchantNo        = $_POST["reMerchantNo"];                   // 가맹점번호                                  
    $reAuthSendType      = $_POST["reAuthSendType"];                 // 인증구분                                    
    $reApprovalSendType  = $_POST["reApprovalSendType"];             // 승인구분                                    
    $rePoint1            = $_POST["rePoint1"];                       //                                             
    $rePoint2            = $_POST["rePoint2"];                       //                                             
    $rePoint3            = $_POST["rePoint3"];                       //                                             
    $rePoint4            = $_POST["rePoint4"];                       //                                             
    $reVanTransactionNo  = $_POST["reVanTransactionNo"];             //                                             
    $reFiller            = $_POST["reFiller"];                       //                                             
    $reAuthType          = $_POST["reAuthType"];                     //                                             
    $reMPIPositionType   = $_POST["reMPIPositionType"];              //                                             
    $reMPIReUseType      = $_POST["reMPIReUseType"];                 //                                             
    $reInterest          = $_POST["reInterest"];                     // 이자구분 1: 일반, 2: 무이자                 
                                                                                                                             
	$rePApprovalType     = $_POST["rePApprovalType"];                // 포인트승인구분                              
	$rePTransactionNo    = $_POST["rePTransactionNo"];               // 포인트거래번혼                              
	$rePStatus           = $_POST["rePStatus"];                      // 포인트승인상태                              
	$rePTradeDate        = $_POST["rePTradeDate"];                   // 포인트거래일자                              
	$rePTradeTime        = $_POST["rePTradeTime"];                   // 포인트거래시간                              
	$rePIssCode          = $_POST["rePIssCode"];                     // 포인트발급사코드                            
	$rePAuthNo           = $_POST["rePAuthNo"];                      // 포인트승인번호                              
	$rePMessage1         = $_POST["rePMessage1"];                    // 메시지1                                     
	$rePMessage2         = $_POST["rePMessage2"];                    // 메시지2                                     
	$rePPoint1           = $_POST["rePPoint1"];                      // 거래포인트                                  
	$rePPoint2           = $_POST["rePPoint2"];                      // 가용포인트                                  
	$rePPoint3           = $_POST["rePPoint3"];                      // 누적포인트                                  
	$rePPoint4           = $_POST["rePPoint4"];                      // 가맹점포인트                                
	$rePMerchantNo       = $_POST["rePMerchantNo"];                  // 가맹점번호                                  
	$rePNotice1          = $_POST["rePNotice1"];                     //                                             
	$rePNotice2          = $_POST["rePNotice2"];                     //                                             
	$rePNotice3          = $_POST["rePNotice3"];                     //                                             
	$rePNotice4          = $_POST["rePNotice4"];                     //                                             
	$rePFiller           = $_POST["rePFiller"];                      //                                             
                                                                                                                             
// 가상계좌--------------------------------------------------------------------------------------                            
	$reVATransactionNo   = $_POST["reVATransactionNo"];              // 가상계좌거래번호                            
	$reVAStatus          = $_POST["reVAStatus"];                     // 상태                                        
	$reVATradeDate       = $_POST["reVATradeDate"];                  // 거래일자                                    
	$reVATradeTime       = $_POST["reVATradeTime"];                  // 거래시간                                    
	$reVABankCode        = $_POST["reVABankCode"];                   // 은행코드                                    
	$reVAVirAcctNo       = $_POST["reVAVirAcctNo"];                  // 가상계좌번호                                
	$reVAName            = $_POST["reVAName"];                       // 예금주명                                    
	$reVAMessage1        = $_POST["reVAMessage1"];                   // 메시지1                                     
	$reVAMessage2        = $_POST["reVAMessage2"];                   // 메시지2                                     
	$reVAFiller          = $_POST["reVAFiller"];                     // 예비                                        
                                                                                                                             
// 월드패스--------------------------------------------------------------------------------------                            
	$reWPTransactionNo   = $_POST["reWPTransactionNo"];              // 월드패스거래번호                            
	$reWPStatus          = $_POST["reWPStatus"];                     // 상태                                        
	$reWPTradeDate       = $_POST["reWPTradeDate"];                  // 거래일자                                    
	$reWPTradeTime       = $_POST["reWPTradeTime"];                  // 거래시간                                    
	$reWPIssCode         = $_POST["reWPIssCode"];                    // 발급사코드                                  
	$reWPAuthNo          = $_POST["reWPAuthNo"];                     // 승인번호                                    
	$reWPBalanceAmount   = $_POST["reWPBalanceAmount"];              // 잔액                                        
	$reWPLimitAmount     = $_POST["reWPLimitAmount"];                // 한도액                                      
	$reWPMessage1        = $_POST["reWPMessage1"];                   // 메시지1                                     
	$reWPMessage2        = $_POST["reWPMessage2"];                   // 메시지2                                     
	$reWPCardNo          = $_POST["reWPCardNo"];                     // 카드번호                                    
	$reWPAmount          = $_POST["reWPAmount"];                     // 금액                                        
	$reWPMerchantNo      = $_POST["reWPMerchantNo"];                 // 가맹점번호                                  
	$reWPFiller          = $_POST["reWPFiller"];                     // 예비                                        
 
// 휴대폰 ---------------------------------------------------------------------------------------
	$reMTransactionNo	= $_POST["reMTransactionNo"];				// 거래번호     
	$reMStatus			= $_POST["reMStatus"];						// 거래성공여부 
	$reMTradeDate		= $_POST["reMTradeDate"];					// 거래일자     
	$reMTradeTime		= $_POST["reMTradeTime"];					// 거래시간     
	$reMBalAmount		= $_POST["reMBalAmount"];					// 잔액         
	$reMTid				= $_POST["reMTid"];							// 기관응답코드 
	$reMRespCode		= $_POST["reMRespCode"];					// 응답코드     
	$reMRespMsg			= $_POST["reMRespMsg"];						// 응답메시지   
	$reMBypassMsg		= $_POST["reMBypassMsg"];					// 서비스기관
	$reMCompCode		= $_POST["reMCompCode"];					// 기관코드     
	$reMFiller			= $_POST["reMFiller"];						// 예비         

	// 신용카드(1=MPI, I=ISP)
    if(substr($reApprovalType,0,1) == "1" || substr($reApprovalType,0,1) == "I" ) {				
        $authyn = $_POST["reStatus"];
        $trno   = $_POST["reTransactionNo"];
        $trddt  = $_POST["reTradeDate"];
        $trdtm  = $_POST["reTradeTime"];
        $amt    = $_POST["reAmount"];
        $authno = $_POST["reAuthNo"];
        $msg1   = $_POST["reMessage1"];
        $msg2   = $_POST["reMessage2"];
        $ordno  = $_POST["reOrderNumber"];
        $isscd  = $_POST["reIssCode"];
        $aqucd  = $_POST["reAquCode"];
        $temp_v = $_POST["reTemp_v"];
        $result = $_POST["reApprovalType"];
	}
    else if(substr($reApprovalType,0,1) == "4" ) {							// 포인트
        $authyn = $_POST["rePStatus"];
        $trno   = $_POST["rePTransactionNo"];
        $trddt  = $_POST["rePTradeDate"];
        $trdtm  = $_POST["rePTradeTime"];
        $amt    = $_POST["reAmount"];
        $authno = $_POST["rePAuthNo"];
        $msg1   = $_POST["rePMessage1"];
        $msg2   = $_POST["rePMessage2"];
        $ordno  = $_POST["reOrderNumber"];
        $isscd  = $_POST["rePIssCode"];
        $aqucd  = "";
     	$temp_v = $_POST["reTemp_v"];
        $result = $_POST["reApprovalType"];
	}
    else if(substr($reApprovalType,0,1) == "6" ) {							// 가상계좌
        $authyn = $_POST["reVAStatus"];
        $trno   = $_POST["reVATransactionNo"];
        $trddt  = $_POST["reVATradeDate"];
        $trdtm  = $_POST["reVATradeTime"];
        $amt    = $_POST["reAmount"];
        $authno = $_POST["reVABankCode"];
        $msg1   = $_POST["reVAMessage1"];
        $msg2   = $_POST["reVAMessage2"];
        $ordno  = $_POST["reOrderNumber"];
        $isscd  = $_POST["reVAVirAcctNo"];
        $aqucd  = "";
        $temp_v = $_POST["reTemp_v"];
        $result = $_POST["reApprovalType"];
	}
	    else if(substr($reApprovalType,0,1) == "2" ) {							// 계좌이체
        $authyn = $_POST["reVAStatus"];
        $trno   = $_POST["reVATransactionNo"];
        $trddt  = $_POST["reVATradeDate"];
        $trdtm  = $_POST["reVATradeTime"];
        $amt    = $_POST["reAmount"];
        $authno = $_POST["reVABankCode"];
        $msg1   = $_POST["reVAMessage1"];
        $msg2   = $_POST["reVAMessage2"];
        $ordno  = $_POST["reOrderNumber"];
        $isscd  = $_POST["reVAVirAcctNo"];
        $aqucd  = "";
        $temp_v = $_POST["reTemp_v"];
        $result = $_POST["reApprovalType"];
	}
    else if(substr($reApprovalType,0,1) == "7" ) {							// 월드패스
        $authyn = $_POST["reWPStatus"];
        $trno   = $_POST["reWPTransactionNo"];
        $trddt  = $_POST["reWPTradeDate"];
        $trdtm  = $_POST["reWPTradeTime"];
        $amt    = $_POST["reAmount"];
        $authno = $_POST["reWPAuthNo"];
        $msg1   = $_POST["reWPMessage1"];
        $msg2   = $_POST["reWPMessage2"];
        $ordno  = $_POST["reOrderNumber"];
        $isscd  = "";
        $aqucd  = "";
        $temp_v = $_POST["reTemp_v"];
        $result = $_POST["reApprovalType"];
	}
    else if(substr($reApprovalType,0,1) == "M" ) {							// 휴대폰
		$authyn	= $_POST["reMStatus"];
		$trno	= $_POST["reMTransactionNo"];
		$trddt	= $_POST["reMTradeDate"];
		$trdtm	= $_POST["reMTradeTime"];
		$amt	= $_POST["reMBalAmount"];
		$authno	= $_POST["reMRespCode"];  
		$msg1	= $_POST["reMRespMsg"];
		$msg2	= $_POST["reMobile"];	  
		$ordno	= $_POST["reOrderNumber"];
		$isscd	= $_POST["reMBypassMsg"];
		$aqucd	= $_POST["reGoodType"];
		$temp_v	= $_POST["reTemp_v"];
		$result	= $_POST["reApprovalType"];
	}
?>  
<html>
<head>
<title>KSPay</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<script language="JavaScript">
<!--
	/*init() - 함수설명 : 결재완료후 opener페이지(AuthFrm.jsp)에 있는 paramSet(), goResult() 함수를 호출한다*/
    function init()
	{ 
		top.opener.paramSet("<?echo($authyn)?>","<?echo($trno)?>","<?echo($trddt)?>","<?echo($trdtm)?>","<?echo($authno)?>","<?echo($ordno)?>","<?echo($msg1)?>","<?echo($msg2)?>","<?echo($amt)?>","<?echo($temp_v)?>","<?echo($isscd)?>","<?echo($aqucd)?>","","<?echo($result)?>");
        top.opener.goResult();
        window.close();
    }

    init();
-->
</script>
</head>
</html>