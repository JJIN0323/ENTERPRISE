<?
/*------------------------------------------------------------------------------
 FILE NAME : result.php
 DATE : 2006-09-01
 ���������� �ŷ������ �޾� ����ڿ��� �����ְų�, DBó���� ����ó���� �ϱ����� �����������Դϴ�.
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
	<title>KSPAY �������� ���</title>
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
			//ksnet �ֹ���ȣ���� - Ư������ �����Ͽ����Ƿ�, �ٽ� replace
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
		<div style="margin-bottom:20px;font-weight:bold;color:#fff;background-color:#4d6392;font-size:1.3em;padding:20px;border:1px solid #e3e3e3;text-align:center;">KSPAY ���ͳ� �������� ���</div>	
		<div>
			<TABLE>			
				<TR>
					<TD class="item">���α���</TD>					
					<TD><?if($Authyn == "O") echo("<span style='color:green;'>����</span>"); else echo("<span style='color:red;'>����</span>");?></TD>					
				</TR>
				<TR>
					<TD class="item">�ŷ���ȣ</TD>				
					<TD class="val"><?echo($Trno)?></TD>					
				</TR>
				<!--<TR>
					<TD>�ŷ�����</TD>
					<TD>trddt</TD>
					<TD><?echo($Trddt)?></TD>
					<TD>&nbsp;</TD>
				</TR>
				<TR>
					<TD>�ŷ��ð�</TD>
					<TD>trdtm</TD>
					<TD><?echo($Trdtm)?></TD>
					<TD>&nbsp;</TD>
				</TR>
				<TR>
					<TD>ī��� ���ι�ȣ/���� �ڵ��ȣ</TD>
					<TD>authno</TD>
					<TD><?echo($Authno)?></TD>
					<TD>���ι�ȣ�� ī��翡�� �߱��ϴ� ������ ����ũ���� �������� ������ �����Ͻʽÿ�.</TD>
				</TR>
				<TR>
					<TD>�߱޻��ڵ�/������¹�ȣ/������ü��ȣ/�޴����������</TD>
					<TD>isscd</TD>
					<TD><?echo($Isscd)?></TD>
					<TD>&nbsp;</TD>
				</TR>
				<TR>
					<TD>���Ի��ڵ�/�ǹ�-�����б���</TD>
					<TD>Aqucd</TD>
					<TD><?echo($Aqucd)?></TD>
					<TD>&nbsp;</TD>
				</TR>-->
				<TR>
					<TD class="item">�ֹ���ȣ</TD>					
					<TD class="val"><?echo(str_replace("_","-",$Ordno))?></TD>					
				</TR>
				<TR>
					<TD class="item">�����ݾ�</TD>				
					<TD class="val"><?echo($Amt)?></TD>					
				</TR>
				<TR>
					<TD class="item">ī���޽���</TD>					
					<TD class="val"><?echo($Msg1)?></TD>				
				</TR>
				<!--<TR>
					<TD>�޼���2</TD>
					<TD>msg2</TD>
					<TD><?echo($Msg2)?></TD>
					<TD>���μ����� �̺κп� OK�� ���ι�ȣ�� ǥ�õ˴ϴ�.</TD>
				</TR>
				<TR>
					<TD>��������</TD>
					<TD>result</TD>
					<TD><?echo($Result)?></TD>
					<TD>���������� ǥ�õ˴ϴ�.</TD>
				</TR>
				<TR>
					<TD>������߰� ���ڰ�</TD>
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
				if($Authyn == "O") echo("<span style='color:green;'>KSENT ���ͳ� ���������� ���������� ���εǾ����ϴ�.</span><br>�̿��Ͽ� �ּż� �����մϴ�."); 
				else echo("<span style='color:red;'>KSNET ���ͳ� �������ҿ� �����Ͽ����ϴ�.</span><br>����Ʈ�����ڿ��� �����Ͽ� �ֽʽÿ�."); 
				?>
			</div>
		</div>
	</div>
</body>
</html>
<?php 
//������ ������ �� DBó���� �۾� �ڵ�
if($Authyn == "O")
{
	echo "<script type='text/javascript'>submit_opener();</script>";
}
?>