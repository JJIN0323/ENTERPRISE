<?php
include_once("../lib/lib.php");
include_once("../lib/C_CONNECT.php");
include_once("../lib/define_table.php");
include_once("../lib/authentication.php");
include_once("../function/f_af_attachFileUpload.php");
include_once("../function/f_get_afTABLE1.php");


/* ----------------------------------------------------------------------------------- */
/*	프로그램명 : 애드폼(영문 addform												   */									
/*	프로그램용도: 견적서 주문서 폼메일 제작											   */
/*	제작자: 박성규																	   */
/*	공식배포처: http://www.addform.net												   */
/*  프로그램 편집시 위 제작자 정보를 편집하거나 삭제해서는 안됩니다.				   */
/* ----------------------------------------------------------------------------------- */


if($_POST['mode'] == "send")
{
#########################################################################################
############################	폼으로 부터 받아와서 업데이트	#########################	
#########################################################################################
if($_POST['yesorno_cookie'] == "yes")
	{
		if($_COOKIE[lastmail])
		{
			setcookie("lastmail","".$_COOKIE[lastmail].",".$_POST['ship_mail']."",365*24*60*60+time(),"/");
		}
		else
		{
			setcookie("lastmail","".$_POST['ship_mail']."",365*24*60*60+time(),"/");
		}
	}

$clean=array();
		
		$clean['ship_name'] = htmlspecialchars(stripslashes($_POST['ship_name']));
		$clean['ship_mail'] = htmlspecialchars(stripslashes($_POST['ship_mail']));
		$clean['ship_subject'] = htmlspecialchars(stripslashes($_POST['ship_subject']));
		$clean['send_msg'] = nl2br(stripslashes($_POST['send_msg']));
		$clean['send_name'] = htmlspecialchars(stripslashes($_POST['send_name']));
		$clean['send_mail'] = htmlspecialchars(stripslashes($_POST['send_mail']));		

	//#########################	고객 에게 메일 발송		#########################//
	$arr = "";
	$arr = array();
	$arr[name] = $clean['send_name'];										//이름
	$arr[from] = $clean['send_mail'];										//예약폼관리자 이메일
	$arr[to] = $clean['ship_mail'];											//전송받을 고객 이메일
	$arr[subject] = $clean['ship_subject'];									//메일 제목
	$arr[body] = $clean['send_msg'];										//변경시 고객통보될 내용 또는 인클루드 문서
	
	if($clean['ship_mail'])
	{																		//메일 보내기 함수 호출
	F_MIME($arr,$f_af_attachFileUpload["upload_result"],"toClient");		
	}
		
																			//DB 입력 후 문서 고침
echo("<script>alert('메일 전송을 완료하였습니다')</script>");		
}

$af_TABLE1 = f_get_afTABLE1("no","1");										//관리자 테이블에서 가져오기
#########################################################################################
############################	DB order_table에서 가져오기	#############################	
#########################################################################################
$no = $_GET['order_no'].$_POST['order_no'];									//접수번호
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
		//$html['reserver_time'] = htmlspecialchars(stripslashes($row["reserver_time"]));		//예약시간	
		$html['input_date'] = htmlspecialchars(stripslashes($row["input_date"]));			//최초접수
		$html['edit_date'] = htmlspecialchars(stripslashes($row["edit_date"]));				//최근수정


$arr_formdata = explode("|*|",$html['select_items']);						//"|*|" 구분자로 1차 배열	
					$it_name = explode(";",$arr_formdata[0]);				//1.항목이름 2차배열
					$input_data = explode(";",$arr_formdata[1]);			//2.항목 값  2차배열

//@$mytime_a = date("Y년n월d일 a g시i분",$html['reserver_time']);				//예약시간
//$mytime_a = str_replace("am","오전",$mytime_a);
//$mytime_a = str_replace("pm","오후",$mytime_a);	

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
		$html['email_address'] = htmlspecialchars(stripslashes($row2["email_address"]));
		$html['client_text_name'] = htmlspecialchars(stripslashes($row2["client_text_name"]));
		$html['client_text_email'] = htmlspecialchars(stripslashes($row2["client_text_email"]));
		$html['client_text_hp'] = htmlspecialchars(stripslashes($row2["client_text_hp"]));
		$html['client_text_tel'] = htmlspecialchars(stripslashes($row2["client_text_tel"]));
		$html['client_text_fax'] = htmlspecialchars(stripslashes($row2["client_text_fax"]));
		$html['client_text_address'] = htmlspecialchars(stripslashes($row2["client_text_address"]));
		$html['client_text_memo'] = htmlspecialchars(stripslashes($row2["client_text_memo"]));
		$html['dummy8'] = htmlspecialchars(stripslashes($row2["dummy8"]));

		if(!$html['client_text_name']) $html['client_text_name'] = "이름";
		if(!$html['client_text_email']) $html['client_text_email'] = "이메일";
		if(!$html['client_text_hp']) $html['client_text_hp'] = "휴대폰";
		if(!$html['client_text_tel']) $html['client_text_tel'] = "전화번호";
		if(!$html['client_text_fax']) $html['client_text_fax'] = "fax";
		if(!$html['client_text_address']) $html['client_text_address'] = "주소";
		if(!$html['client_text_memo']) $html['client_text_memo'] = "고객메모";


#########################################################################################
############################	최근에 사용한 메일  가져오기	#########################
#########################################################################################
  
function f_lastmail()
{	                                                 
	$arr_mail = explode(",",$_COOKIE[lastmail]);
	$mails=array(); $_COOKIE[reffer];                                            
	//리턴행이 여러개일 경우 아래와 같이 for문으로 연관배열화
	for ($i=0;$i < count($arr_mail);$i++) 
	{
		$mails[$i]=htmlspecialchars(stripslashes($arr_mail[$i]));	
	}	
	 
	for ($i=0;$i < count($mails);$i++) 
	{
		echo "<option value='".$mails[$i]."'>".$mails[$i]."</option>\n\t\t\t\t\t";
	}
}		
?>
<!--//////////////////////////////////////////////////////////////////////////////////-->
<!--########################### HTML START ###########################################-->
<!--//////////////////////////////////////////////////////////////////////////////////-->
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
	<meta http-equiv='content-type' content='text/html; charset=utf-8'>
	<meta name='robots' content='none,noindex,nofollow'>
	<TITLE>애드폼 접수내용 전달</TITLE>
	<LINK REL="stylesheet" HREF="global.css" TYPE="text/css">
	<script type="text/javascript" src='js/pop_center.js'></script>
	<script type="text/javascript" src='js/check_input.js'></script>
	<script type="text/javascript" src='js/chk_null.js'></script>
	
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
		width: 100px;
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
	</div>	

	<FORM NAME="form1" id="form1" method="post" action='<?php echo $_SERVER['PHP_SELF'];?>' onsubmit="return false;">
	<input type="hidden" name="mode" value="send">
	<input type="hidden" name="order_no" value="<?php echo $_GET['order_no'].$_POST['order_no'];?>">
	<div style="text-align:left;padding:10px;">
		* 접수받은 내용을 간략하게, 제3자의 이메일로 전달할 수 있습니다.
	</div>
	<!--//////////////////////////////////////////////////////////////////////////////////-->
	<!--								받는사람   start								  -->
	<!--//////////////////////////////////////////////////////////////////////////////////-->
	<fieldset style="text-align:left;">
		<legend><strong>받는사람</strong></legend>
			 <p>
			 <label for="ship_name" class="label">이름 : </label>
				<input type="text" name="ship_name" value="" class="ess">
			 </p>
			 <p>
			 <label for="ship_mail" class="label">메일 : </label>
				<input type="text" name="ship_mail" value="" size="30" class="ess">
				<input type="checkbox" name="yesorno_cookie" value="yes">쿠키에1년간저장
				<input type="checkbox" name="yesorno_cookie" value="no" style="display:none;">
				<select name="lastmail" id="lastmail" onchange="this.form.ship_mail.value=lastmail.options[lastmail.selectedIndex].value;">
					<option>최근사용한 이메일</option>
					<?php echo f_lastmail();?>
				</select>
			 </p>
			  <p>
			 <label for="ship_mail" class="label">제목 : </label>
				<input type="text" name="ship_subject" value="<?php echo $html['title_text'];?>" size="76" class="ess">
			 </p>
			  <p>
			 <label for="send_msg" class="label">내용 : </label>
<textarea name="send_msg" rows="20" style="width:470px;text-align:left;" class="tag">
<?php echo $html['title_text'];?><?php echo "\n";?>
--------------------------------------------------------------------------
접수번호: <?php echo $html['af_order_no'];?><?php echo "\n";?>
<?php echo $html['client_text_name'];?>: <?php echo $html['client_name'];?><?php echo "\n";?>
<?php echo $html['client_text_email'];?>: <?php echo $html['client_email'];?><?php echo "\n";?>
<?php echo $html['client_text_hp'];?>: <?php echo $html['client_hp'];?><?php echo "\n";?>
<?php echo $html['client_text_tel'];?>: <?php echo $html['client_tel'];?><?php echo "\n";?>
<?php echo $html['client_text_fax'];?>: <?php echo $html['client_fax'];?><?php echo "\n";?>
<?php echo $html['client_text_address'];?>: <?php echo $html['client_address'];?><?php echo "\n";?>
<?php echo $html['client_text_memo'];?>: <?php echo $html['client_memo'];?><?php echo "\n";?>
--------------------------------------------------------------------------
<?php
for ($i=0;$i<count($it_name);$i++) 
{			
	echo("".$it_name[$i].": ".$input_data[$i]."\n\n");				
}
?>
</textarea>
				<input type="button" value="+" onclick="this.form.send_msg.rows=this.form.send_msg.rows+3">
				<input type="button" value="-" onclick="this.form.send_msg.rows=this.form.send_msg.rows-3">
			 </p>
			 
	</fieldset>

	<!--//////////////////////////////////////////////////////////////////////////////////-->
	<!--								보내는사람   start								  -->
	<!--//////////////////////////////////////////////////////////////////////////////////-->
	<fieldset style="text-align:left;">
		<legend><strong>보내는사람</strong></legend>
			 <p>
			 <label for="send_name" class="label">이름 : </label>
				<input type="text" name="send_name" value="<?php echo $af_TABLE1['name'];?>" class="ess">
			 </p>
			 <p>
			 <label for="send_mail" class="label">메일 : </label>
				<input type="text" name="send_mail" value="<?php echo $af_TABLE1['email_address'];?>" class="ess">
			 </p>				 
	</fieldset>
	<!-- 전송 버튼  -->
	<div style="text-align:center;padding:10px;">
	<input type="button" value="전송하기" style="width:100px;height:30px;" onclick="chk_null(this.form)">
	</div>	
	</form>
</div>
</body>
</html>





