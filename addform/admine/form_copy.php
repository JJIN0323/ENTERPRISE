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

$no = $_GET['no'].$_POST['no'];						 //복사대사 폼번호
$c_name = $_GET['name'].$_POST['c_name'];			 //복사대상 폼이름

$mode =  $_POST['mode'];							 //현재창에서 폼으로 받은 모드...
$no_add =  $_POST['no'];							 //현재창에서 폼으로 받은 폼번호
$name =  $_POST['name'];							 //현재창에서 폼으로 받은 복사될 폼이름
$title_text =  $_POST['title_text'];				 //현재창에서 폼으로 받은 폼제목


if($mode=="add")									 //모드가 추가(복사)일 때
{
 ####################  폼이름 중복검사 start  ####################		
		$where = "where name='$name'";				 //조건절
		$res=$DBconn->f_selectDB("*",TABLE5,$where); //필드, 테이블, 조건절
		if($res[cnt] > 0) die("<script>history.back();alert('이미 $name 이라는 폼이름이 존재합니다. The name already exists');</script>");
####################  폼이름 중복검사 end   ####################	
#-----------------------	폼테이블 복사하기 위해 데이타 가져옴	--------------------#	
	$where="where no=$no_add";
	$re=$DBconn->f_selectDB("*",TABLE5,$where);								
	$result = $re[result];
	$row =  mysql_fetch_array($result);

		$c_no = htmlspecialchars(stripslashes($row["no"]));								 //고유번호
		$c_no_group = htmlspecialchars(stripslashes($row["no_group"]));					 //속할 그룹번호
		$c_form_type = htmlspecialchars(stripslashes($row["form_type"]));				 //폼형식
		$c_input_date = htmlspecialchars(stripslashes($row["input_date"]));				 //생성시각
		$c_edit_date = htmlspecialchars(stripslashes($row["edit_date"]));				 //수정시각
		$c_name = htmlspecialchars(stripslashes($row["name"]));							 //주문폼		
		$c_title_text = htmlspecialchars(stripslashes($row["title_text"]));				 //제 목
		$c_msg_top = htmlspecialchars(stripslashes($row['msg_top']));					 //상단 메시지
		$c_msg_bottom = htmlspecialchars(stripslashes($row['msg_bottom']));				 //하단 메시지
		$c_top_img = htmlspecialchars(stripslashes($row['top_img']));					 //상단 배너 이미지
		$c_bottom_img = htmlspecialchars(stripslashes($row['bottom_img']));				 //하단 배너 이미지
		$c_width = htmlspecialchars(stripslashes($row['width']));						 //너	비
		$c_coin_unit = htmlspecialchars(stripslashes($row["coin_unit"]));				 //통화단위
		$c_secret_price = htmlspecialchars(stripslashes($row["secret_price"]));			 //산출금액 비밀 여부		
		$c_email_address = htmlspecialchars(stripslashes($row["email_address"]));		 //관리자 이메일
		$c_tel = htmlspecialchars(stripslashes($row["tel"]));							 //전화번호,팩스(공급자)
		$c_supply_name = htmlspecialchars(stripslashes($row["supply_name"]));			 //사업자상호(공급자)
		$c_supply_num =htmlspecialchars(stripslashes($row["supply_num"]));				 //사업자등록번호(공급자)
		$c_supply_man = htmlspecialchars(stripslashes($row["supply_man"]));				 //사업자대표(공급자)
		$c_supply_address = htmlspecialchars(stripslashes($row["supply_address"]));		 //사업장주소(공급자)
		$c_supply_conditions = htmlspecialchars(stripslashes($row["supply_conditions"]));//업태(공급자)
		$c_supply_item = htmlspecialchars(stripslashes($row["supply_item"]));			 //종목(공급자)
		$c_sell_num = htmlspecialchars(stripslashes($row["sell_num"]));					 //통신판매번호
		$c_skin_name = htmlspecialchars(stripslashes($row["skin_name"]));				 //스킨이름		
		$c_use_report_email = htmlspecialchars(stripslashes($row["use_report_email"]));  //관리자에게 이메일 전송여부
		$c_banking = htmlspecialchars(stripslashes($row["banking"]));					 //은행정보
		$c_count_field = htmlspecialchars(stripslashes($row["count_field"]));			 //접속통계	
		$c_etc = htmlspecialchars(stripslashes($row["etc"]));							 //비 고
		$c_max_file_size = htmlspecialchars(stripslashes($row["max_file_size"]));		 //html 폼 첨부파일 허용용량
		$c_attachFormat = htmlspecialchars(stripslashes($row["attachFormat"]));			 //첨부파일 허용 확장자
		$c_client_items = htmlspecialchars(stripslashes($row["client_items"]));			 //고객모듈 항목
		$c_client_text_name = htmlspecialchars(stripslashes($row["client_text_name"]));
		$c_client_text_email = htmlspecialchars(stripslashes($row["client_text_email"]));
		$c_client_text_hp = htmlspecialchars(stripslashes($row["client_text_hp"]));
		$c_client_text_tel = htmlspecialchars(stripslashes($row["client_text_tel"]));
		$c_client_text_fax = htmlspecialchars(stripslashes($row["client_text_fax"]));
		$c_client_text_address = htmlspecialchars(stripslashes($row["client_text_address"]));
		$c_client_text_memo = htmlspecialchars(stripslashes($row["client_text_memo"]));
		$c_sign_img = htmlspecialchars(stripslashes($row["sign_img"]));					 //견적서 도장 이미지
		$c_font_family = htmlspecialchars(stripslashes($row["font_family"]));
		$c_font_size = htmlspecialchars(stripslashes($row["font_size"]));
		$c_font_color = htmlspecialchars(stripslashes($row["font_color"]));	
		$c_layout = htmlspecialchars(stripslashes($row["layout"]));	
		$c_return_url =	htmlspecialchars(stripslashes($row["return_url"]));				 //전송 후 리턴페이지
		$c_return_type = htmlspecialchars(stripslashes($row["return_type"]));			 //전송 후 리턴방법 auto,click
		$c_yesorno_pay = htmlspecialchars(stripslashes($row["yesorno_pay"]));			//신용카드 결제여부
		$c_res_name = htmlspecialchars(stripslashes($row["res_name"]));					//예약상품이름
		$c_res_mny = htmlspecialchars(stripslashes($row["res_mny"]));					//예약비용
		$c_res_dummy1 = htmlspecialchars(stripslashes($row["res_dummy1"]));				
		$c_res_dummy2 = htmlspecialchars(stripslashes($row["res_dummy2"]));				
		$c_res_dummy3 = htmlspecialchars(stripslashes($row["res_dummy3"]));
		$c_site_cd = htmlspecialchars(stripslashes($row["site_cd"]));					//전자결제 사이트코드
		$c_site_key = htmlspecialchars(stripslashes($row["site_key"]));					//전자결제사이트키	
		$c_quotaopt = htmlspecialchars(stripslashes($row["quotaopt"]));					//할부개월수 0~12
		$c_sms_msg = htmlspecialchars(stripslashes($row["sms_msg"]));					//문자메시지 제목
		$c_dummy1 =	htmlspecialchars(stripslashes($row["dummy1"]));					     //파일첨부기능 여부
		$c_dummy2 =	htmlspecialchars(stripslashes($row["dummy2"]));					     //유효일
		$c_dummy3 =	htmlspecialchars(stripslashes($row["dummy3"]));					     //주문/견적서항목 표시법
		$c_dummy4 =	htmlspecialchars(stripslashes($row["dummy4"]));						 //견적서 합계표시방법
		$c_dummy5 =	htmlspecialchars(stripslashes($row["dummy5"]));						 //SMS
		$c_dummy6 =	htmlspecialchars(stripslashes($row["dummy6"]));						 //부가세 반영여부(아니오0,예1)	
		$c_dummy7 =	htmlspecialchars(stripslashes($row["dummy7"]));						 //첨부파일 개수
		$c_dummy8 =	htmlspecialchars(stripslashes($row["dummy8"]));						 //폼메일 계산기능(아니오0,예1)	
		$c_dummy9 =	htmlspecialchars(stripslashes($row["dummy9"]));
		$c_dummy10 =htmlspecialchars(stripslashes($row["dummy10"]));
		$c_dummy11 =htmlspecialchars(stripslashes($row["dummy11"]));					  
		$c_dummy12 =htmlspecialchars(stripslashes($row["dummy12"]));					   
		$c_dummy13 =htmlspecialchars(stripslashes($row["dummy13"]));					    
		$c_dummy14 =htmlspecialchars(stripslashes($row["dummy14"]));						
		$c_dummy15 =htmlspecialchars(stripslashes($row["dummy15"]));						
		$c_dummy16 =htmlspecialchars(stripslashes($row["dummy16"]));						
		$c_dummy17 =htmlspecialchars(stripslashes($row["dummy17"]));
		$c_dummy18 =htmlspecialchars(stripslashes($row["dummy18"]));
		$c_dummy19 =htmlspecialchars(stripslashes($row["dummy19"]));
		$c_dummy20 =htmlspecialchars(stripslashes($row["dummy20"]));

		$c_time = time();

	$form_arr=array(
		"no_group"=>"$c_no_group",
		"form_type"=>"$c_form_type",
		"input_date"=>"$c_time",			//
		//"edit_date"=>"$c_edit_date",	
		"name"=>"$name",					//
		"title_text"=>"$title_text",		//
		"msg_top"=>"$c_msg_top",
		"msg_bottom"=>"$c_msg_bottom",
		"top_img"=>"$c_top_img",
		"bottom_img"=>"$c_bottom_img",
		"width"=>"$c_width",
		"coin_unit"=>"$c_coin_unit",
		"secret_price"=>"$c_secret_price",
		"email_address"=>"$c_email_address",
		"tel"=>"$c_tel",
		"supply_name"=>"$c_supply_name",
		"supply_num"=>"$c_supply_num",
		"supply_man"=>"$c_supply_man",
		"supply_address"=>"$c_supply_address",
		"supply_conditions"=>"$c_supply_conditions",
		"supply_item"=>"$c_supply_item",
		"sell_num"=>"$c_sell_num",
		"skin_name"=>"$c_skin_name",
		"use_report_email"=>"$c_use_report_email",
		"banking"=>"$c_banking",
		//"count_field"=>"$c_count_field",
		"etc"=>"$c_etc",
		"max_file_size"=>"$c_max_file_size",
		"attachFormat"=>"$c_attachFormat",
		"client_items"=>"$c_client_items",
		"client_text_name"=>"$c_client_text_name",
		"client_text_email"=>"$c_client_text_email",
		"client_text_hp"=>"$c_client_text_hp",
		"client_text_tel"=>"$c_client_text_tel",
		"client_text_fax"=>"$c_client_text_fax",
		"client_text_address"=>"$c_client_text_address",
		"client_text_memo"=>"$c_client_text_memo",
		"sign_img"=>"$c_sign_img",	
		"font_family"=>"$c_font_family",
		"font_size"=>"$c_font_size",
		"font_color"=>"$c_font_color",
		"layout"=>"$c_layout",
		"return_url"=>"$c_return_url",
		"return_type"=>"$c_return_type",
		"yesorno_pay"=>"$c_yesorno_pay",
		"res_name"=>"$c_res_name",
		"res_mny"=>"$c_res_mny",
		"res_dummy1"=>"$c_res_dummy1",
		"res_dummy2"=>"$c_res_dummy2",
		"res_dummy3"=>"$c_res_dummy3",
		"site_cd"=>"$c_site_cd",
		"site_key"=>"$c_site_key",
		"quotaopt"=>"$c_quotaopt",
		"sms_msg"=>"$c_sms_msg",
		"dummy1"=>"$c_dummy1",
		"dummy2"=>"$c_dummy2",
		"dummy3"=>"$c_dummy3",
		"dummy4"=>"$c_dummy4",
		"dummy5"=>"$c_dummy5",
		"dummy6"=>"$c_dummy6",
		"dummy7"=>"$c_dummy7",
		"dummy8"=>"$c_dummy8",
		"dummy9"=>"$c_dummy9",
		"dummy10"=>"$c_dummy10",
		"dummy11"=>"$c_dummy11",
		"dummy12"=>"$c_dummy12",
		"dummy13"=>"$c_dummy13",
		"dummy14"=>"$c_dummy14",
		"dummy15"=>"$c_dummy15",
		"dummy16"=>"$c_dummy16",
		"dummy17"=>"$c_dummy17",
		"dummy18"=>"$c_dummy18",
		"dummy19"=>"$c_dummy19",
		"dummy20"=>"$c_dummy20"
	);


####################  폼이름 중복검사 start  ####################		
	$where = "where name='$name_add'";						   //조건절
	$res=$DBconn->f_selectDB("*",TABLE5,$where);				   //필드, 테이블, 조건절
	if($res[cnt] > 0) die("<script>history.back();alert('이미 $name 이라는 폼이름이 존재합니다. The name already exists');</script>");
####################  폼이름 중복검사 end   ####################

#------------------------------------	DB에 입력	------------------------------------#	

	$DBconn->f_InsertDB(TABLE5,$form_arr);//테이블, 연관배열

#-----------------------------------	폼목 테이블 복사	----------------------------#	
$c_item = "".db_tblname."_".$c_name."_item";							//복사할 내용이 있는 품목테이블 이름
$v_item = "".db_tblname."_".$name."_item";								//복제될 품목테이블 이름
$create_items="
CREATE TABLE IF NOT EXISTS $v_item(			
	no INT(11) NOT NULL AUTO_INCREMENT ,
	code INT(11) DEFAULT 0,
	name_it VARCHAR(255) DEFAULT NULL,
	price VARCHAR(255) DEFAULT NULL,
	opt TEXT,	
	unit VARCHAR(255) DEFAULT NULL,	
	chk_input INT(11) DEFAULT 0,
	chk_filter INT(11) DEFAULT 0,
	chk_etc INT(11) DEFAULT 0,
	default_text TEXT,
	default_opt TEXT,
	discount TEXT,
	dummy1 TEXT,
	dummy2 TEXT,
	dummy3 TEXT,
	dummy4 TEXT,
	dummy5 TEXT,
	dummy6 TEXT,
	dummy7 TEXT,
	dummy8 TEXT,
	dummy9 TEXT,
	dummy10 TEXT,
	dummy11 TEXT,
	dummy12 TEXT,
	dummy13 TEXT,
	dummy14 TEXT,
	dummy15 TEXT,
	dummy16 TEXT,
	dummy17 TEXT,
	dummy18 TEXT,
	dummy19 TEXT,
	dummy20 TEXT,

	PRIMARY KEY (no),
	KEY code(code)
	)$af_charset";

mysql_query($create_items) or die(mysql_error());			//품목 테이블 생성
															//내용 복사
mysql_query("INSERT INTO $v_item SELECT * FROM $c_item") or die(mysql_error());	


#-----------------------------------	복사 완료 후	----------------------------#
	echo("
	<script type='text/javascript'>
		alert('".af_txt_form_copy_1."');
		opener.location.reload();
		top.opener=top.window.close();
	</script>
	");
}


?>
<!--##################################################################################-->
<!-- ############################	HTML START	##################################### -->
<!--##################################################################################-->
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<meta name='robots' content='none,noindex,nofollow'>
<TITLE></TITLE>
<META NAME="author" CONTENT="애드폼">
<LINK REL="stylesheet" HREF="global.css" TYPE="text/css">
<script type="text/javascript" src='js/check_input.js'></SCRIPT>
<script type="text/javascript" src='js/pop_center.js'></SCRIPT>

<script type="text/javascript">
<!--
function form_copy(f) 
{
<!--
if (!f.name.value) 
	{
        alert('<?php echo af_txt_form_copy_2;?>"');
        return f.name.focus();
    }	
if (!f.title_text.value) 
	{
        alert('<?php echo af_txt_form_copy_3;?>');
        return f.title_text.focus();
    }

f.submit();
}
-->
</script>

<script type="text/javascript">
<!--
function autoFc() {
if (document.forms.length > 0) {
var field = document.forms[0];
for (i = 0; i < field.length; i++) {
if ((field.elements[i].type == "text") || (field.elements[i].type == "textarea") || (field.elements[i].type.toString().charAt(0) == "s")) {
document.forms[0].elements[i].focus();
break;
         }
      }
   }
}
//-->
</script>
</HEAD>


<BODY onload="autoFc();">

<FORM NAME="form1" method="post" action='<?php echo $_SERVER['PHP_SELF'];?>' onSubmit="return false">

<?php 
if(!$mode){?>
	<input type="hidden" name="mode" value="add">
	<input type="hidden" name="no" value="<?php echo $no;?>">
	<input type="hidden" name="c_name" value="<?php echo $c_name;?>">
	<TABLE class="noborder">
		<TR>
			<TD COLSPAN="2" style="background-color:white;text-align:left">
				<strong><?php echo af_txt_form_copy_4;?></strong>
			</TD>
		</TR>
		<TR>
			<TD COLSPAN="2" style="background-color:white;text-align:left">
				<P><?php echo $c_name;?> <?php echo af_txt_form_copy_5;?></P>
			</TD>
		</TR>
		<TR>
			<TD style="width:30%;text-align:right;">
				<?php echo af_txt_form_copy_6;?>
			</TD>
			<TD style="text-align:left;width:70%">
			<INPUT TYPE="text" NAME="name"  SIZE="10" STYLE="ime-mode:Disabled;"  onblur='quot_Del(this)'><INPUT TYPE="button" value="<?php echo af_txt_form_add_btnDubleChk;?>" onclick="window.open('chk_formname.php?name='+this.form.name.value+'','chk_name','width=100,height=100,statusbar=no,scrollbars=no,toolbar=no')">
			</TD>
		</TR>
		<TR>
			<TD style="width:30%;text-align:right">
				<?php echo af_txt_form_copy_7;?>
			</TD>
			<TD style="text-align:left;width:70%">
			<INPUT TYPE="text" NAME="title_text" STYLE="width:90%;IME-MODE: active"  onblur='quot_Del(this)'>
			</TD>
		</TR>
		<TR>
			<TD  COLSPAN="2" style="text-align:center">
				<HR>
			<input type='button' value='<?php echo af_txt_form_copy_4;?>' id="addBtn" onClick="form_copy(this.form);"><input type='button' value='<?php echo af_txt_closeWin;?>' onClick='window.close();'>
			</TD>
		</TR>
	</TABLE>
<?}?>


</FORM>
</BODY>

</HTML>
