<?php
include_once("../lib/lib.php");
include_once("../lib/C_CONNECT.php");
include_once("../lib/define_table.php");
include_once("../lib/authentication.php");


/* ----------------------------------------------------------------------------------- */
/*	프로그램명 : 애드폼(영문 addform												   */									
/*	프로그램용도: 견적서 주문서 폼메일 제작											   */
/*	제작자: 박성규																	   */
/*	공식배포처: http://www.addform.net												   */
/*  프로그램 편집시 위 제작자 정보를 편집하거나 삭제해서는 안됩니다.				   */
/* ----------------------------------------------------------------------------------- */


if($_POST['mode'] == "modify"){
#########################################################################################
############################	폼으로 부터 받아와서 업데이트	#########################	
#########################################################################################

$clean=array();
		if($_POST['pay_ok'] == "ok") $clean['pay_cancel'] = "on";
		if($_POST['pay_ok'] == "no") $clean['pay_cancel'] = "off";
	
		$clean['no'] = $_POST['no'];	
		$clean['client_name'] = $_POST['client_name'];		//폼으로 부터 받은 고객 이름
		$clean['client_tel'] = $_POST['client_tel'];		//폼으로 부터 받은 고객	전화번호	
		$clean['client_hp'] = $_POST['client_hp'];			//폼으로 부터 받은 고객	휴대폰
		$clean['client_fax'] = $_POST['client_fax'];		//폼으로 부터 받은 고객	fax
		$clean['client_email'] = $_POST['client_email'];	//폼으로 부터 받은 고객	이메일
		$clean['client_address'] = $_POST['client_address'];//폼으로 부터 받은 고객 주소
		$clean['client_memo'] = $_POST['client_memo'];		//폼으로 부터 받은 고객 메모
		$clean['supply_memo'] = $_POST['supply_memo'];		//폼으로 부터 받은 관리자 메모
		if($_POST['sum']){
		$clean['sum'] = $_POST['sum'];						//폼으로 부터 받은 합계
		}
		
		foreach($_POST['it_name'] as $val) $items .= $val.";";
		foreach($_POST['input_data'] as $val2) $items_val .= $val2.";";
		$items = substr($items,0,-1);
		$items_val = substr($items_val,0,-1);	
		
		$clean['select_items'] = $items."|*|".$items_val;
		$clean['edit_date'] = time();						//폼 수정시각	
		
$where = "where no=".$clean['no'];							//조건절	
$DBconn->f_updateDB(TABLE4,&$clean,$where);			
															//DB 입력 후 문서 고침
die("<script>alert('success! modify');opener.location.reload();</script><meta http-equiv=refresh content='0;url=".URL."?order_no=".$_POST['no']."'>");		
}


#########################################################################################
############################	DB order_table에서 가져오기	#############################	
#########################################################################################
$no = $_GET['order_no'];													//접수번호
$where="where no='$no'";
$re=$DBconn->f_selectDB("*",TABLE4,$where);									//해당 테이블에서 정보가져옴
$result = $re[result];
$row =  mysql_fetch_array($result);


$html=array();
		$html['af_order_no'] = htmlspecialchars(stripslashes($row["af_order_no"]));			//접수번호
		$html['mom'] =  htmlspecialchars(stripslashes($row["mom"]));						//속한 주문폼 이름
		$html['order_date'] = htmlspecialchars(stripslashes($row["input_date"]));			//등록시각
		$html['client_name'] = htmlspecialchars(stripslashes($row["client_name"]));			//고객 이름
		$html['client_tel'] = htmlspecialchars(stripslashes($row["client_tel"]));			//고객	전화번호	
		$html['client_hp'] = htmlspecialchars(stripslashes($row["client_hp"]));				//고객	휴대폰
		$html['client_fax'] = htmlspecialchars(stripslashes($row["client_fax"]));			//고객	fax
		$html['client_email'] = htmlspecialchars(stripslashes($row["client_email"]));		//고객	이메일
		$html['client_address'] = htmlspecialchars(stripslashes($row["client_address"]));	//고객 주소
		$html['client_memo'] = htmlspecialchars(stripslashes($row["client_memo"]));			//고객 메모
		$html['supply_memo'] = htmlspecialchars(stripslashes($row["supply_memo"]));			//관리자 메모
		$html['select_items'] = htmlspecialchars(stripslashes($row["select_items"]));		//데이타
		$html['total_sum'] = htmlspecialchars(stripslashes($row["sum"]));					//합  계
		$html['tno'] = htmlspecialchars(stripslashes($row["tno"]));							//kcp 거래번호(취소/매입시 사용)
		$html['pay_cancel'] = htmlspecialchars(stripslashes($row["pay_cancel"]));			//kcp 결제취소(on,off)
		$html['input_date'] = htmlspecialchars(stripslashes($row["input_date"]));			//최초접수
		$html['edit_date'] = htmlspecialchars(stripslashes($row["edit_date"]));				//최근수정


$arr_formdata = explode("|*|",$html['select_items']);						//"|*|" 구분자로 1차 배열	
					$it_name = explode(";",$arr_formdata[0]);				//1.항목이름 2차배열
					$input_data = explode(";",$arr_formdata[1]);			//2.항목 값  2차배열

$input_date = date("Y년n월d일 H시i분",$html['input_date']);
if($html['edit_date']) $edit_date = date("Y년n월d일 H시i분",$html['edit_date']);
else $edit_date = "0 회";


#########################################################################################
############################	DB addform_table에서 가져오기	#########################
#########################################################################################
$where2="where name='".$html['mom']."'";
$re2=$DBconn->f_selectDB("*",TABLE5,$where2);								//해당 테이블에서 정보가져옴
$result2 = $re2[result];
$row2 =  mysql_fetch_array($result2);
		$html['title_text'] = htmlspecialchars(stripslashes($row2["title_text"]));
		$html['coin_unit'] = htmlspecialchars(stripslashes($row2["coin_unit"]));
		$html['client_text_name'] = htmlspecialchars(stripslashes($row2["client_text_name"]));
		$html['client_text_email'] = htmlspecialchars(stripslashes($row2["client_text_email"]));
		$html['client_text_hp'] = htmlspecialchars(stripslashes($row2["client_text_hp"]));
		$html['client_text_tel'] = htmlspecialchars(stripslashes($row2["client_text_tel"]));
		$html['client_text_fax'] = htmlspecialchars(stripslashes($row2["client_text_fax"]));
		$html['client_text_address'] = htmlspecialchars(stripslashes($row2["client_text_address"]));
		$html['client_text_memo'] = htmlspecialchars(stripslashes($row2["client_text_memo"]));
		$html['dummy8'] = htmlspecialchars(stripslashes($row2["dummy8"]));
		$html['site_cd'] = htmlspecialchars(stripslashes($row2["site_cd"]));
		$html['site_key'] = htmlspecialchars(stripslashes($row2["site_key"]));

		if(!$html['client_text_name']) $html['client_text_name'] = "".af_txt_form_add_47."";
		if(!$html['client_text_email']) $html['client_text_email'] = "".af_txt_form_add_48."";
		if(!$html['client_text_hp']) $html['client_text_hp'] = "".af_txt_form_add_49."";
		if(!$html['client_text_tel']) $html['client_text_tel'] = "".af_txt_form_add_50."";
		if(!$html['client_text_fax']) $html['client_text_fax'] = "".af_txt_form_add_51."";
		if(!$html['client_text_address']) $html['client_text_address'] = "".af_txt_form_add_52."";
		if(!$html['client_text_memo']) $html['client_text_memo'] = "".af_txt_form_add_53."";

		
?>
<!--##################################################################################-->
<!--########################### HTML START ###########################################-->
<!--##################################################################################-->
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
	<meta http-equiv='content-type' content='text/html; charset=utf-8'>
	<meta name='robots' content='none,noindex,nofollow'>
	<TITLE>접수번호 <?php echo $html['af_order_no'];?> 에 대한 기록</TITLE>
	<LINK REL="stylesheet" HREF="global.css" TYPE="text/css">
	<script type="text/javascript" src='js/pop_center.js'></script>
	<script type="text/javascript" src='js/check_input.js'></SCRIPT>

	<style type="text/css">
	/* 폼 스타일 설정 */
	input 
		{
		background-color:#fff;
		}
	textarea 
		{
		background-color:#fff;
		}
	/* 폼 라벨 스타일 설정 */
	#form1 .label 
		{
		float: left;
		clear: left;
		width: 150px;
		margin-right: 10px;
		padding-right:5px;
		text-align: right;
		color:#616588;	
		border-width: 1px;
		border-bottom-style: dotted;
		border-color: #999999;
		}
	</style>
	</head>
<body>

<div>

<table>
		<tr>
			<td style="line-height:1.3em;text-align:left;font-weight:bold;border-top:1px solid #fff;border-right:0;border-bottom:1px solid #aba9a9;border-left:1px solid #fff;">
				<?php echo $html['af_order_no'];?><br>
				<?php echo $html['title_text'];?>							
			</td>
			<td style="line-height:1.3em;text-align:right;color:gray;border-top:1px solid #fff;border-right:1px solid #aba9a9;border-bottom:1px solid #aba9a9;border-left:0;">
				최초접수: <?php echo $input_date;?><br>
				최근수정: <?php echo $edit_date;?>
			</td>
		</tr>
	</table>

<FORM NAME="form1" id="form1" method="post" action='<?php echo $_SERVER['PHP_SELF'];?>'>
<input type="hidden" name="mode" value="modify">
<input type="hidden" name="no" value="<?php echo $_GET['order_no'];?>">

	<!--//////////////////////////////////////////////////////////////////////////////////-->
	<!--								고객 정보 출력   start							  -->
	<!--//////////////////////////////////////////////////////////////////////////////////-->
	<fieldset style="text-align:left;display:none;">
		<legend><strong>고객입력자료</strong></legend>

		<!--	이름	-->
		<P>
			 <label for="client_name" class="label"><?php echo $html['client_text_name'];?> : </label>			
				<input type="text" name="client_name" value="<?php echo $html['client_name'];?>" onblur='quot_Del(this);' style="background-color:#99ccff;">
		</P>
		<!--	이메일	-->
		<P>
			 <label for="client_email" class="label"><?php echo $html['client_text_email'];?> :</label>			
				<input type="text" name="client_email" value="<?php echo $html['client_email'];?>" style="width:370px;">
		</P>
		<!--	휴대폰	-->
		<P>
			 <label for="client_hp" class="label"><?php echo $html['client_text_hp'];?> : </label>			
				<input type="text" name="client_hp" value="<?php echo $html['client_hp'];?>" onblur='quot_Del(this);'>
		</P>
		<!--	전화번호	-->
		<P>
			 <label for="client_tel" class="label"><?php echo $html['client_text_tel'];?> : </label>			
				<input type="text" name="client_tel" value="<?php echo $html['client_tel'];?>" onblur='quot_Del(this);'>
		</P>
		<!--	팩스	-->
		<P>
			 <label for="client_fax" class="label"><?php echo $html['client_text_fax'];?> : </label>			
				<input type="text" name="client_fax" value="<?php echo $html['client_fax'];?>" onblur='quot_Del(this);'>
		</P>
		<!--	주소	-->
		<P>
			 <label for="client_address" class="label"><?php echo $html['client_text_address'];?> : </label>			
				<input type="text" name="client_address" value="<?php echo $html['client_address'];?>" style="width:370px;" onblur='quot_Del(this);'>
		</P>
		<!--	고객메모	-->
		<P>
			 <label for="client_memo" class="label"><?php echo $html['client_text_memo'];?> : </label>			
				<textarea name="client_memo" rows="3" style="width:370px;" onblur='quot_Del(this);'><?php echo $html['client_memo'];?></textarea>
				<input type="button" value="+" onclick="this.form.client_memo.rows=this.form.client_memo.rows+3">
				<input type="button" value="-" onclick="this.form.client_memo.rows=this.form.client_memo.rows-3">
		</P>
		<hr>
	<!--//////////////////////////////////////////////////////////////////////////////////-->
	<!--							항목 배열의 길이만큼 루핑  start					  -->
	<!--//////////////////////////////////////////////////////////////////////////////////-->
		<table>
		<?php

		for ($i=0;$i<count($it_name);$i++) 
		{		
				
			echo("	
					<tr>
						<td style='border:0;padding-left:0;margin-left:0;;padding-right:0;margin-right:0;' valign='top' >
							<input type='text' name='it_name[]' value='".$it_name[$i]."' onblur='quot_Del(this);'>
						</td>
						<td style='text-align:left;border:0;'>
						");
					 echo ("
					 <textarea name='input_data[]' style='width:370px;' onblur='quot_Del(this);' rows='2' id='input_data$i'>".$input_data[$i]."</textarea>
					 <input type='button' value='+' onclick='document.getElementById(\"input_data$i\").rows=document.getElementById(\"input_data$i\").rows+3'>
					 <input type='button' value='-' onclick='document.getElementById(\"input_data$i\").rows=document.getElementById(\"input_data$i\").rows-3'>
					 ");
				  echo("</td>
					</tr>							
				"); 
		}

		?> 
	</table>	
	</fieldset>	

	<!--//////////////////////////////////////////////////////////////////////////////////-->
	<!--			결제비용 및 결제취소   start					  -->
	<!--//////////////////////////////////////////////////////////////////////////////////-->
	<!--  -->	
	<fieldset style="text-align:left;">
		<legend><strong>결제금액</strong></legend>
		<!--	결제비용	-->
		<P>
			 <label for="sum" class="label">결제금액 : </label>			
				<input type='text' name='sum' value="<?php echo $html['total_sum'];?>" style='text-align:right;border:0;' onblur="NumberDot(this)" readonly> 원
		</P>
		<!--	결제방법	-->
		<P>
			 <label for="" class="label">결제방법 : </label>			
			 <?php if($html['tno']) echo "전자결제";?>
			 <?php if(!$html['tno']) echo "무통장입금";?>	
		</P>
		<!--	결제유무	-->
		<P>
			 <label for="" class="label">결제유무 : </label>			
			 <?php if($html['pay_cancel'] == "on") {?>
				 <span style='color:blue'>결제완료</span>
				 <?php if($html['tno']) {?>
					 &nbsp;거래번호 : <?php echo "<strong>".$html['tno']."</strong><br>";?> 
					 <!--<input type="button" value="결제취소하기" onclick="document.location.href='../plugin/kcp/mod_admin.html?tno=<?php echo $html[tno];?>;site_cd=<?php echo $html[site_cd];?>;;site_key=<?php echo $html[site_key];?>'">-->
					 &nbsp;(거래번호는 결제대행사에 접속하여 주문취소/검색등에 사용하면 됩니다.)
				 <?php }?>
				 <?php if(!$html['tno']) {?>
					<!--<input type='checkbox' name='pay_ok' value='no'>결제취소-->
				 <?php }?>
			 <?php }?>
			 <?php if(!$html['pay_cancel']) echo "<span style='color:#cc6600'>미결제</span> ..........<input type='checkbox' name='pay_ok' value='ok'>입금확인";?>
			 <?php if($html['pay_cancel'] == "off") echo "<span style='color:red'>결제취소</span>";?>
		</P>		

	</fieldset>

	<div style="text-align:right;padding:10px;display:none;">
	<input type="submit" value="수정하기" style="width:100px;height:30px;">
	</div>

	<!--//////////////////////////////////////////////////////////////////////////////////-->
	<!--									관리자메모   start							  -->
	<!--//////////////////////////////////////////////////////////////////////////////////-->
	<fieldset style="text-align:left;">
		<legend><strong>관리자기록란</strong></legend>
	<!--	관리자메모	-->
		<P>
			 <label for="client_memo" class="label">관리자메모 : </label>			
				<textarea name="supply_memo" rows="10" style="width:100%;background-color:#ccc;" onblur='quot_Del(this);'><?php echo $html['supply_memo'];?></textarea>
				<input type="button" value="+" onclick="this.form.supply_memo.rows=this.form.supply_memo.rows+3">
				<input type="button" value="-" onclick="this.form.supply_memo.rows=this.form.supply_memo.rows-3">
		</P>
	</fieldset>
	<div style="text-align:right;padding:10px;">
	<input type="submit" value="수정하기" style="width:100px;height:30px;">
	</div>

	</form>
</div>
</body>
</html>





