<? 
mb_http_input("euc-kr"); 
mb_http_output("euc-kr"); 
?>
<?
/*------------------------------------------------------------------------------
 FILE NAME : KSPayRcv.php
 DATE : 2006-09-01
 ���������� kspay���հ���â���κ��� �ŷ������ �޾� ������������������ �ŷ������ �ѱ�� ������ �մϴ�.
------------------------------------------------------------------------------*/

// ����--------------------------------------------------------------------------------------
    $reEncType       = $_POST["reEncType"];                          // ��ȣȭ����                                  
    $reVersion       = $_POST["reVersion"];                          // ��������                                    
    $reType          = $_POST["reType"];                             // ��������                                    
    $reResend        = $_POST["reResend"];                           // ���۱���                                    
    $reRequestDate   = $_POST["reRequestDate"];                      // ��û��                                      
    $reStoreId       = $_POST["reStoreId"];                          // �������̵�                                  
    $reOrderNumber   = $_POST["reOrderNumber"];                      // �ֹ���ȣ                                    
    $reOrderName     = $_POST["reOrderName"];                        // �ֹ��ڸ�                                    
    $reAllRegid      = $_POST["reAllRegid"];                         // �ֹι�ȣ                                    
    $reEmail         = $_POST["reEmail"];                            // �̸���                                      
    $reGoodType      = $_POST["reGoodType"];                         // ��ǰ���� 1:�ǹ�, 2: ������                  
    $reGoodName      = $_POST["reGoodName"];                         // ��ǰ��                                      
    $reKeyInType     = $_POST["reKeyInType"];                        // Keyin���� K : Keyin                         
    $reLineType      = $_POST["reLineType"];                         // ���������� 0: offline, 1: online(internet)  
    $reMobile        = $_POST["reMobile"];                           // �޴�����ȣ                                  
    $reApprovalCount = $_POST["reApprovalCount"];                    // ��������                                    
    $reHeadFiller    = $_POST["reHeadFiller"];                       // ����                                        
    $reApprovalType  = $_POST["reApprovalType"];                     // ���α���                                    
                                                                                                                             
// �ſ�ī��--------------------------------------------------------------------------------------                            
    $reTransactionNo     = $_POST["reTransactionNo"];                // �ŷ���ȣ                                    
    $reStatus            = $_POST["reStatus"];                       // ����                                        
    $reTradeDate         = $_POST["reTradeDate"];                    // �ŷ�����                                    
    $reTradeTime         = $_POST["reTradeTime"];                    // �ŷ��ð�                                    
    $reIssCode           = $_POST["reIssCode"];                      // �߱޻��ڵ�                                  
    $reAquCode           = $_POST["reAquCode"];                      // ���Ի��ڵ�                                  
    $reAuthNo            = $_POST["reAuthNo"];                       // ���ι�ȣ                                    
    $reMessage1          = $_POST["reMessage1"];                     // �޽���1                                     
    $reMessage2          = $_POST["reMessage2"];                     // �޽���2                                     
    $reCardNo            = $_POST["reCardNo"];                       // ī���ȣ14�ڸ�+XXXX                         
    $reExpDate           = $_POST["reExpDate"];                      // ��ȿ�Ⱓ YYMM                               
    $reInstallment       = $_POST["reInstallment"];                  // �Һΰ�����                                  
    $reAmount            = $_POST["reAmount"];                       // �ݾ�                                        
    $reMerchantNo        = $_POST["reMerchantNo"];                   // ��������ȣ                                  
    $reAuthSendType      = $_POST["reAuthSendType"];                 // ��������                                    
    $reApprovalSendType  = $_POST["reApprovalSendType"];             // ���α���                                    
    $rePoint1            = $_POST["rePoint1"];                       //                                             
    $rePoint2            = $_POST["rePoint2"];                       //                                             
    $rePoint3            = $_POST["rePoint3"];                       //                                             
    $rePoint4            = $_POST["rePoint4"];                       //                                             
    $reVanTransactionNo  = $_POST["reVanTransactionNo"];             //                                             
    $reFiller            = $_POST["reFiller"];                       //                                             
    $reAuthType          = $_POST["reAuthType"];                     //                                             
    $reMPIPositionType   = $_POST["reMPIPositionType"];              //                                             
    $reMPIReUseType      = $_POST["reMPIReUseType"];                 //                                             
    $reInterest          = $_POST["reInterest"];                     // ���ڱ��� 1: �Ϲ�, 2: ������                 
                                                                                                                             
	$rePApprovalType     = $_POST["rePApprovalType"];                // ����Ʈ���α���                              
	$rePTransactionNo    = $_POST["rePTransactionNo"];               // ����Ʈ�ŷ���ȥ                              
	$rePStatus           = $_POST["rePStatus"];                      // ����Ʈ���λ���                              
	$rePTradeDate        = $_POST["rePTradeDate"];                   // ����Ʈ�ŷ�����                              
	$rePTradeTime        = $_POST["rePTradeTime"];                   // ����Ʈ�ŷ��ð�                              
	$rePIssCode          = $_POST["rePIssCode"];                     // ����Ʈ�߱޻��ڵ�                            
	$rePAuthNo           = $_POST["rePAuthNo"];                      // ����Ʈ���ι�ȣ                              
	$rePMessage1         = $_POST["rePMessage1"];                    // �޽���1                                     
	$rePMessage2         = $_POST["rePMessage2"];                    // �޽���2                                     
	$rePPoint1           = $_POST["rePPoint1"];                      // �ŷ�����Ʈ                                  
	$rePPoint2           = $_POST["rePPoint2"];                      // ��������Ʈ                                  
	$rePPoint3           = $_POST["rePPoint3"];                      // ��������Ʈ                                  
	$rePPoint4           = $_POST["rePPoint4"];                      // ����������Ʈ                                
	$rePMerchantNo       = $_POST["rePMerchantNo"];                  // ��������ȣ                                  
	$rePNotice1          = $_POST["rePNotice1"];                     //                                             
	$rePNotice2          = $_POST["rePNotice2"];                     //                                             
	$rePNotice3          = $_POST["rePNotice3"];                     //                                             
	$rePNotice4          = $_POST["rePNotice4"];                     //                                             
	$rePFiller           = $_POST["rePFiller"];                      //                                             
                                                                                                                             
// �������--------------------------------------------------------------------------------------                            
	$reVATransactionNo   = $_POST["reVATransactionNo"];              // ������°ŷ���ȣ                            
	$reVAStatus          = $_POST["reVAStatus"];                     // ����                                        
	$reVATradeDate       = $_POST["reVATradeDate"];                  // �ŷ�����                                    
	$reVATradeTime       = $_POST["reVATradeTime"];                  // �ŷ��ð�                                    
	$reVABankCode        = $_POST["reVABankCode"];                   // �����ڵ�                                    
	$reVAVirAcctNo       = $_POST["reVAVirAcctNo"];                  // ������¹�ȣ                                
	$reVAName            = $_POST["reVAName"];                       // �����ָ�                                    
	$reVAMessage1        = $_POST["reVAMessage1"];                   // �޽���1                                     
	$reVAMessage2        = $_POST["reVAMessage2"];                   // �޽���2                                     
	$reVAFiller          = $_POST["reVAFiller"];                     // ����                                        
                                                                                                                             
// �����н�--------------------------------------------------------------------------------------                            
	$reWPTransactionNo   = $_POST["reWPTransactionNo"];              // �����н��ŷ���ȣ                            
	$reWPStatus          = $_POST["reWPStatus"];                     // ����                                        
	$reWPTradeDate       = $_POST["reWPTradeDate"];                  // �ŷ�����                                    
	$reWPTradeTime       = $_POST["reWPTradeTime"];                  // �ŷ��ð�                                    
	$reWPIssCode         = $_POST["reWPIssCode"];                    // �߱޻��ڵ�                                  
	$reWPAuthNo          = $_POST["reWPAuthNo"];                     // ���ι�ȣ                                    
	$reWPBalanceAmount   = $_POST["reWPBalanceAmount"];              // �ܾ�                                        
	$reWPLimitAmount     = $_POST["reWPLimitAmount"];                // �ѵ���                                      
	$reWPMessage1        = $_POST["reWPMessage1"];                   // �޽���1                                     
	$reWPMessage2        = $_POST["reWPMessage2"];                   // �޽���2                                     
	$reWPCardNo          = $_POST["reWPCardNo"];                     // ī���ȣ                                    
	$reWPAmount          = $_POST["reWPAmount"];                     // �ݾ�                                        
	$reWPMerchantNo      = $_POST["reWPMerchantNo"];                 // ��������ȣ                                  
	$reWPFiller          = $_POST["reWPFiller"];                     // ����                                        
 
// �޴��� ---------------------------------------------------------------------------------------
	$reMTransactionNo	= $_POST["reMTransactionNo"];				// �ŷ���ȣ     
	$reMStatus			= $_POST["reMStatus"];						// �ŷ��������� 
	$reMTradeDate		= $_POST["reMTradeDate"];					// �ŷ�����     
	$reMTradeTime		= $_POST["reMTradeTime"];					// �ŷ��ð�     
	$reMBalAmount		= $_POST["reMBalAmount"];					// �ܾ�         
	$reMTid				= $_POST["reMTid"];							// ��������ڵ� 
	$reMRespCode		= $_POST["reMRespCode"];					// �����ڵ�     
	$reMRespMsg			= $_POST["reMRespMsg"];						// ����޽���   
	$reMBypassMsg		= $_POST["reMBypassMsg"];					// ���񽺱��
	$reMCompCode		= $_POST["reMCompCode"];					// ����ڵ�     
	$reMFiller			= $_POST["reMFiller"];						// ����         

	// �ſ�ī��(1=MPI, I=ISP)
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
    else if(substr($reApprovalType,0,1) == "4" ) {							// ����Ʈ
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
    else if(substr($reApprovalType,0,1) == "6" ) {							// �������
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
	    else if(substr($reApprovalType,0,1) == "2" ) {							// ������ü
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
    else if(substr($reApprovalType,0,1) == "7" ) {							// �����н�
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
    else if(substr($reApprovalType,0,1) == "M" ) {							// �޴���
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
	/*init() - �Լ����� : ����Ϸ��� opener������(AuthFrm.jsp)�� �ִ� paramSet(), goResult() �Լ��� ȣ���Ѵ�*/
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