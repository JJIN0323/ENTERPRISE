<?
/*------------------------------------------------------------------------------
 FILE NAME : backUrl.php
 DATE : 2006-09-01
 ����������	BackURL�� ������ �������� ���� ��������� �ް� ���������� �ϱ����� �����������Դϴ�.
------------------------------------------------------------------------------*/

// ============= Input ����	=================================================================
// strModule   : Module	Name
// strFunction : Function Name
// strLogMsg   : Logging ��	����
// ==========================================================================================

function TraceLog ($strLogMsg)
{
//***************************************************************************
//	 Log File ����(�ش��ü���� �α������� ���� ��� ����)
//	 ex) $LOG_PATH	= "C:\1\" (C����̺� ���� 1���丮 �ؿ� ����)
//***************************************************************************
  $LOG_PATH	= "C:\1\";

  $ForReading =	1;
  $ForWriting =	2;
  $ForAppending	= 8;

//*************************************************************************
// ����	��¥�� ����
//*************************************************************************
  $iMonth =	strftime("%m");
  $iDay	= strftime("%d");
  $iYear = strftime("%Y");

  if(strlen($iMonth) == 1){
	$iMonth	= "0".$iMonth;
  }

  if(strlen($iDay) == 1){
	$iDay =	"0".$iDay;
  }

  $strLogFile =	$LOG_PATH. $strModule .	$iYear.	$iMonth. $iDay.	".txt";

//*************************************************************************
// Logging �� Record ����
//*************************************************************************
  $strRecord = ( "[" . $iYear. $iMonth.	$iDay. "]");
  $strRecord = $strRecord. $strFunction	;
  $strRecord = $strRecord .	": " . ($strLogMsg)	. "\n";

//*************************************************************************
// ȭ�Ͽ� Logging
//*************************************************************************
	$fp	= fopen($strLogFile, "a");
	fwrite($fp,	"$strRecord");
	fclose($fp);
}
?>
<?
	global $data;
	global $ret	;
	global $paraData;
	global $strLen ;
	global $writeData ;
	global $send ;
	global $strBool;

	$data =	trim($data);

	$data =	urldecode($data);

	$paraData =	explode("`", $data);
	$strLen	= count($paraData);

//*****************************************Header ����*******************************************************
//0:����,1:��ȣȭ����,2:����,3:Type,4:resend,5:��û�Ͻ�,6:�������̵�,7:�ֹ���ȣ,8:�ֹ��ڸ�,9:�ֹι�ȣ,10:�̸���
//11:Product Type,12:��ǰ��,13:KeyIn ����,14:����������,15:����� ��������,16:�޴�����ȣ,17:����
//************************************************************************************************************
	$Version				= $paraData[1];		// 0:��ȣ����, 1:��ȣȭ(openssl), 2:��ȣȭ(seed)
	$Type					= $paraData[2];		// ��������	: 311
	$msg_sele				= $paraData[3];		// ��������
	$Resend					= $paraData[4];		// �����۱���
	$RequestDate			= $paraData[5];		// ��û�Ͻ�
	$StoreId				= $paraData[6];		// �������̵�
	$OrderNumber			= $paraData[7];		// �ֹ���ȣ
	$UserName				= $paraData[8];		// �ֹ��ڸ�
	$IdNum					= $paraData[9];		// �ֹι�ȣ
	$Email					= $paraData[10];	// �̸���
	$GoodType				= $paraData[11];	// ��ǰ���� 1 : �ǹ�, 2 : ������
	$GoodName				= $paraData[12];	// ��ǰ��
	$KeyInType				= $paraData[13];	// keyin����
	$LineType				= $paraData[14];	// ����������
	$PhoneNo				= $paraData[15];	// �޴�����ȣ
	$ApprovalCount			= $paraData[16];	// ���հ����Ǽ�
	$HaedFiller				= $paraData[17];	// ����

	TraceLog ($data);

	$strBool = 0;
	$ret = "false";
//�ſ�ī��(ISP,Visa3D����) paraData[18]=>���α���
//*****************************************�ſ�ī��	Data����*************************************************
//18:���α���,19:�ŷ���ȣ,20:��������,21:�ŷ�����,22:�ŷ��ð�,23:�߱޻��ڵ�,24:���Ի��ڵ�,25:���ι�ȣ
//26:�޽���1,27:�޽���2,28:ī���ȣ,29:��ȿ�Ⱓ,30:�Һ�,31:�ݾ�,32:��������ȣ,33:��������,34:���ο���
//35:����,36:��������,37:MPI�������,38:ISP�Ǵ�	Visa3D��������
//************************************************************************************************************

if(substr($paraData[18],0,1) ==	"1"	|| substr($paraData[18],0,1) ==	"I"){

	$rApprovalType			= $paraData[18];
	$rTransactionNo			= $paraData[19];	// �ŷ���ȣ
	$rStatus				= $paraData[20];	// ����	O :	����, X	: ����
	$rTradeDate				= $paraData[21];	// �ŷ�����
	$rTradeTime				= $paraData[22];	// �ŷ��ð�
	$rIssCode				= $paraData[23];	// �߱޻��ڵ�
	$rAquCode				= $paraData[24];	// ���Ի��ڵ�
	$rAuthNo				= $paraData[25];	// ���ι�ȣ	or ������ �����ڵ�
	$rMessage1				= $paraData[26];	// �޽���1
	$rMessage2				= $paraData[27];	// �޽���2
	$rCardNo				= $paraData[28];	// ī���ȣ
	$rExpDate				= $paraData[29];	// ��ȿ�Ⱓ
	$rInstallment			= $paraData[30];	// �Һ�
	$rAmount				= $paraData[31];	// �ݾ�
	$rMerchantNo			= $paraData[32];	// ��������ȣ
	$rAuthSendType			= $paraData[33];	// ���۱���= new String(this.read(2));
	$rApprovalSendType		= $paraData[34];	// ���۱���(0 :	����, 1	: ����,	2: ��ī��)
	$rPoint1				= $paraData[35];	// Point1
	$rPoint2				= $paraData[36];	// Point2
	$rPoint3				= $paraData[37];	// Point3
	$rPoint4				= $paraData[38];	// Point4
	$rVanTransactionNo		= $paraData[39]; //	Van�ŷ���ȣ
	$rFiller				= $paraData[40];	// ����
	$rAuthType				= $paraData[41];	// ISP : ISP�ŷ�, MP1, MP2 : MPI�ŷ�, SPACE	: �Ϲݰŷ�
	$rMPIPositionType		= $paraData[42];	// K : KSNET, R	: Remote, C	: ��3���, SPACE : �Ϲݰŷ�
	$rMPIReUseType			= $paraData[43]; //	Y :	����,	N :	����ƴ�
	$rEncData				= $paraData[44]; //	MPI, ISP ������
	$ret = "true";
	}

//*****************************************������¹߱�	Data����*************************************************
//18:���α���,19:�ŷ���ȣ,20:��������,21:�ŷ�����,22:�ŷ��ð�,23:����,24:�������,25:������
//26:�޽���1,27:�޽���2,28:����
//************************************************************************************************************

	else if(substr($paraData[18],0,1) == "6"){		//������¹߱�
	$rVAApprovalType		= $paraData[18];  //
	$rVATransactionNo		= $paraData[19];  // �ŷ���ȣ
	$rVAStatus				= $paraData[20];  // ����
	$rVATradeDate			= $paraData[21];  // �ŷ�����
	$rVATradeTime			= $paraData[22];  // �ŷ��ð�
	$rVABankCode			= $paraData[23];  // �����ڵ�
	$rVAVirAcctNo			= $paraData[24];  // ������¹�ȣ
	$rVAName				= $paraData[25];  // ������
	$rVAMessage1			= $paraData[26];  // �޽���1
	$rVAMessage2			= $paraData[27];  // �޽���2
	$rVAFiller				= $paraData[28];  // ����
	$ret = "true";
	}

//*****************************************�����н�ī��	Data����*************************************************
//18:���α���,19:�ŷ���ȣ,20:��������,21:�ŷ�����,22:�ŷ��ð�,23:�߱޻��ڵ�,24:���ι�ȣ,25:�ܾ�
//26:�ѵ���,27:�޽���1,28:�޽���2,29:ī���ȣ,30:�ݾ�,31:��������ȣ,32:����
//************************************************************************************************************

	else if(substr($paraData[18],0,1) == "7"){		//�����н�ī�� paraData[18]=>���α���

	$rApprovalType		= $paraData[18];	  //
	$rWPTransactionNo	= $paraData[19];	  //	�ŷ���ȣ
	$rWPStatus			= $paraData[20];	  //	���� O : ����, X : ����
	$rWPTradeDate		= $paraData[21];	  //	�ŷ�����
	$rWPTradeTime		= $paraData[22];	  //	�ŷ��ð�
	$rWPIssCode			= $paraData[23];	  //	�߱޻��ڵ�
	$rWPAuthNo			= $paraData[24];	  //	���ι�ȣ
	$rWPBalanceAmount	= $paraData[25];	  //	�ܾ�
	$rWPLimitAmount		= $paraData[26];	  //	�ѵ���
	$rWPMessage1		= $paraData[27];	  //	�޽���1
	$rWPMessage2		= $paraData[28];	  //	�޽���2
	$rWPCardNo			= $paraData[29];	  //	ī���ȣ
	$rWPAmount			= $paraData[30];	  //	�ݾ�
	$rWPMerchantNo		= $paraData[31];	  //	��������ȣ
	$rWPFiller			= $paraData[32];	  //	����
	$ret = "true";
	}

//*****************************************������ü	Data����*************************************************
//18:���α���,19:�ŷ���ȣ,20:��������,21:�ŷ�����,22:�ŷ��ð�,23:������ü����,24:�����μ�޼���
//25:�Աݸ���������ڵ�,26:�Աݸ����¹�ȣ,27:��������ڵ�,28:��ݰ��¹�ȣ,29:�����ݾ�,30:���������ڵ�
//31:�޽���1,32:�޽���2,33:����
//************************************************************************************************************

	else if(substr($paraData[18],0,1) == "2"){		//������ü paraData[18]=>���α���
	$rVAApprovalType	= $paraData[18];	  //
	$rVATransactionNo	= $paraData[19];	  //	�ŷ���ȣ
	$rVAStatus			= $paraData[20];	  //	���� O : ����, X : ����
	$rVATradeDate		= $paraData[21];	  //	�ŷ�����
	$rVATradeTime		= $paraData[22];	  //	�ŷ��ð�
	$rVAAcctType		= $paraData[23];	  //	������ü����
	$rVArVAPrintMsg		= $paraData[24];	  //	�����μ�޼���
	$rVAPBankCode		= $paraData[25];	  //	�Աݸ���������ڵ�
	$rVAPAcctNo			= $paraData[26];	  //	�Աݸ����¹�ȣ
	$rVABankCode		= $paraData[27];	  //	��������ڵ�
	$rVAAcctNo			= $paraData[28];	  //	��ݰ��¹�ȣ
	$rVAAmount			= $paraData[29];	  //	�����ݾ�
	$rVABankRespCode	= $paraData[30];	  //	���������ڵ�
	$rVAMessage1		= $paraData[31];	  //	�޽���1
	$rVAMessage2		= $paraData[32];	  //	�޽���2
	$rVAFiller			= $paraData[33];	  //	����

	$ret = "true";
	}

//*****************************************�޴������� Data����*************************************************
//18:���α���,19:�ŷ���ȣ,20:��������,21:�ŷ�����,22:�ŷ��ð�,23:�ݾ�,24:��������ڵ�
//25:�����ڵ�,26:����޽���,27:���񽺾�ü,28:����ڵ�,29:����
//************************************************************************************************************

	else if(substr($paraData[18],0,1) == "M"){		//������ü paraData[18]=>���α���
	$rMApprovalType		= $paraData[18];	  //
	$rMTransactionNo	= $paraData[19];	  //	�ŷ���ȣ     
	$rMStatus			= $paraData[20];	  //	�ŷ��������� 
	$rMTradeDate		= $paraData[21];	  //	�ŷ�����     
	$rMTradeTime		= $paraData[22];	  //	�ŷ��ð�     
	$rMBalAmount		= $paraData[23];	  //	�ܾ�         
	$rMTid				= $paraData[24];	  //	��������ڵ� 
	$rMRespCode			= $paraData[25];	  //	�����ڵ�     
	$rMRespMsg			= $paraData[26];	  //	����޽���   
	$rMBypassMsg		= $paraData[27];	  //	���񽺾�ü   
	$rMCompCode			= $paraData[28];	  //	����ڵ�     
	$rMFiller			= $paraData[29];	  //	����         
	$ret = "true";
	}
?>
ret=<?echo($ret)?>