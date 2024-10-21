<?
/*------------------------------------------------------------------------------
 FILE NAME : result.php
 DATE : 2006-09-01
 이페이지는 거래결과를 받아 사용자에게 보여주거나, DB처리등 사후처리를 하기위한 샘플페이지입니다.
------------------------------------------------------------------------------*/

	$Authyn = $_POST["reAuthyn"];
	$Trno   = $_POST["reTrno"  ];
	$Trddt  = $_POST["reTrddt" ];
	$Trdtm  = $_POST["reTrdtm" ];
	$Authno = $_POST["reAuthno"];
	$Ordno  = $_POST["reOrdno" ];
	$Msg1   = $_POST["reMsg1"  ];
	$Msg2   = $_POST["reMsg2"  ];
	$Amt    = $_POST["reAmt"   ];
	$Temp_v = $_POST["reTemp_v"];
	$Isscd  = $_POST["reIsscd" ];
	$Aqucd  = $_POST["reAqucd" ];
	$Remark = $_POST["reRemark"];
	$Result = $_POST["reResult"];
	
	$a        = $_POST["a"];
	$b        = $_POST["b"];
	$c        = $_POST["c"];
	$d        = $_POST["d"];
?>
<html>
<head> 
	<title>KSPAY 전자지불 결과</title>
	<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
	<link rel="stylesheet" href="form.css" type="text/css">
	<style type="text/css">	
		table{width:100%;border-collapse: collapse;}
		td{padding:10px;border:1px solid #e3e3e3;font-size:13px;}
		.item{width:100px;text-align:right;background-color:#8897b7;}
		.val{text-align:left;}
	</style>
	<script type="text/javascript">
       <!--
		function submit_opener()
		{
			var type = "<?php echo $_POST[type];?>";
			var dummy = "";
			//ksnet 주문번호에는 - 특수문자 사용못하였으므로, 다시 replace
			window.opener.form1.pay_order_no.value = "<?php echo str_replace('_','-',$Ordno);?>";
			window.opener.form1.tno.value = "<?php echo $Trno;?>";
			if(type == "formmail")	window.opener.submit_formmail(window.opener.form1,dummy);
			if(type == "order")	window.opener.submit_data(window.opener.form1,dummy);			
		}
		-->
    </script>
</head>
<body style="margin:auto;text-align:center;" onload="self.focus();window.onblur=function(){window.focus()}">
	<div style="margin:10px;width:500px;">	
		<div style="margin-bottom:20px;font-weight:bold;color:#fff;background-color:#4d6392;font-size:1.3em;padding:20px;border:1px solid #e3e3e3;text-align:center;">KSPAY 인터넷 전자지불 결과</div>	
		<div>
			<TABLE>			
				<TR>
					<TD class="item">승인구분</TD>					
					<TD><?if($Authyn == "O") echo("<span style='color:green;'>승인</span>"); else echo("<span style='color:red;'>거절</span>");?></TD>					
				</TR>
				<TR>
					<TD class="item">거래번호</TD>				
					<TD class="val"><?echo($Trno)?></TD>					
				</TR>
				<!--<TR>
					<TD>거래일자</TD>
					<TD>trddt</TD>
					<TD><?echo($Trddt)?></TD>
					<TD>&nbsp;</TD>
				</TR>
				<TR>
					<TD>거래시간</TD>
					<TD>trdtm</TD>
					<TD><?echo($Trdtm)?></TD>
					<TD>&nbsp;</TD>
				</TR>
				<TR>
					<TD>카드사 승인번호/은행 코드번호</TD>
					<TD>authno</TD>
					<TD><?echo($Authno)?></TD>
					<TD>승인번호는 카드사에서 발급하는 것으로 유니크하지 않을수도 있음에 주의하십시요.</TD>
				</TR>
				<TR>
					<TD>발급사코드/가상계좌번호/계좌이체번호/휴대폰결제기관</TD>
					<TD>isscd</TD>
					<TD><?echo($Isscd)?></TD>
					<TD>&nbsp;</TD>
				</TR>
				<TR>
					<TD>매입사코드/실물-디지털구분</TD>
					<TD>Aqucd</TD>
					<TD><?echo($Aqucd)?></TD>
					<TD>&nbsp;</TD>
				</TR>-->
				<TR>
					<TD class="item">주문번호</TD>					
					<TD class="val"><?echo(str_replace("_","-",$Ordno))?></TD>					
				</TR>
				<TR>
					<TD class="item">결제금액</TD>				
					<TD class="val"><?echo($Amt)?></TD>					
				</TR>
				<TR>
					<TD class="item">카드사메시지</TD>					
					<TD class="val"><?echo($Msg1)?></TD>				
				</TR>
				<!--<TR>
					<TD>메세지2</TD>
					<TD>msg2</TD>
					<TD><?echo($Msg2)?></TD>
					<TD>승인성공시 이부분엔 OK와 승인번호가 표시됩니다.</TD>
				</TR>
				<TR>
					<TD>결제수단</TD>
					<TD>result</TD>
					<TD><?echo($Result)?></TD>
					<TD>결제수단이 표시됩니다.</TD>
				</TR>
				<TR>
					<TD>사용자추가 인자값</TD>
					<TD>&nbsp;</TD>
					<TD>
					a = <?echo($a)?><br>
					b = <?echo($b)?><br>
					c= <?echo($c)?><br>
					d = <?echo($d)?>
					</TD>
					<TD>&nbsp;</TD>
				</TR>-->
			</TABLE>
			<div style="margin-top:20px;padding:20px;border:1px solid #e3e3e3;text-align:center;font-size:13px;color:gray;background-color:#e7eaf1;">
				<?
				if($Authyn == "O") echo("<span style='color:green;'>KSENT 인터넷 전자지불이 정상적으로 승인되었습니다.</span><br>이용하여 주셔서 감사합니다."); 
				else echo("<span style='color:red;'>KSNET 인터넷 전자지불에 실패하였습니다.</span><br>사이트관리자에게 문의하여 주십시오."); 
				?>
			</div>
		</div>
	</div>
</body>
</html>
<?php 
//지불이 성공일 때 DB처리할 작업 코딩
if($Authyn == "O")
{
	echo "<script type='text/javascript'>submit_opener();</script>";
}
?>