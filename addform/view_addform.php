<?php
include_once("lib/C_CONNECT.php");
include_once("lib/define_table.php");
include_once("function/f_get_afTABLE.php");
include_once("function/f_get_afTABLE1.php");
include_once("function/f_get_afTABLE2.php");
include_once("function/f_get_afTABLE5.php");
include_once("function/f_get_afTABLE7.php");

/* ----------------------------------------------------------------------------------- */
/*	프로그램명 : 애드폼(영문 addform)												   */									
/*	프로그램용도: 견적서 주문서 폼메일 제작											   */
/*	제작자: 박성규																	   */
/*	공식배포처: http://www.addform.net												   */
/*  프로그램 편집시 위 제작자 정보를 편집하거나 삭제해서는 안됩니다.				   */
/* ----------------------------------------------------------------------------------- */
															 
$af_fname ="";
if (strlen($_GET['fname']) <= 10)									 //폼이름을 10자 이상 안받았으므로 클린검사
{									 
	$af_fname = $_GET['fname'].$af_get_fname;						 //090105 $af_get_fname 추가
	define("TABLE","".db_tblname."_".$af_fname."_item");			 //상수정의:해당폼의 품목 저장 Mysql 테이블 정의
}
else die("정상적인 접속이 아닙니다. incorrect!");
?>

<?
$af_TABLE1 = f_get_afTABLE1("no","1");								 //관리자 테이블에서 가져오기
$af_TABLE2 = f_get_afTABLE2("no","1");								 //전체폼기본환경 테이블에서 가져오기
$af_TABLE5 = f_get_afTABLE5("name",$af_fname);
$af_TABLE7 = f_get_afTABLE7("no","1");	

///////	폼 접속 카운터 업테이트(구간카운터가 null 일 때, ++ 해 주기 위해 이 위치로 버전5.2 일 때 옮겼음)	///////
mysql_query("update ".db_tblname."_table set count_field=count_field+1 where name='$af_fname'");
if(!$af_TABLE5["dummy9"]) $sector_count = "1"; else $sector_count = $af_TABLE5["dummy9"]+1;
mysql_query("update ".db_tblname."_table set dummy9=$sector_count where name='$af_fname'");

//////  폼유효기간 설정일 때 ////////////////////////////////////////////////////////////
if($_GET["mode"] != "admine")
{
	if($af_TABLE5["dummy17"] == "1")
	{
		$startD = date("Y년m월d일",$af_TABLE5["dummy15"]);
		$endD = date("Y년m월d일",$af_TABLE5["dummy16"]);
		if($af_TABLE5["dummy15"] > time())
		{			
			die("
			<div style='text-align:center;border:2px solid #e3e3e3;margin:100px;padding:100px;'>
			아직 접수할 수 있는 기간이 아닙니다.<br>
			<span style='color:green;'>접수는, $startD 부터 $endD 까지 하실 수 있습니다.</span><br>
			</div>
			");
		}
		
		if($af_TABLE5["dummy16"] < time())
		{			
			die("
			<div style='text-align:center;border:2px solid #e3e3e3;margin:100px;padding:100px;'>
			죄송합니다.<br>
			<span style='color:red;'>접수기간 $startD ~ $endD 을 경과하여 접수를 하실 수 없습니다.</span><br>
			</div>
			");
		}
	}
}
		
if($af_TABLE5["form_type"] == "1") $af_onload = "formmail_onloadSum();"; //폼메일일 때 초기 합계실행

if(!$af_TABLE5["client_text_name"]) $af_TABLE5["client_text_name"] = "".af_txt_form_add_47."";
if(!$af_TABLE5["client_text_email"]) $af_TABLE5["client_text_email"] = "".af_txt_form_add_48."";
if(!$af_TABLE5["client_text_hp"]) $af_TABLE5["client_text_hp"] = "".af_txt_form_add_49."";
if(!$af_TABLE5["client_text_tel"]) $af_TABLE5["client_text_tel"] = "".af_txt_form_add_50."";
if(!$af_TABLE5["client_text_fax"]) $af_TABLE5["client_text_fax"] = "".af_txt_form_add_51."";
if(!$af_TABLE5["client_text_address"]) $af_TABLE5["client_text_address"] = "".af_txt_form_add_52."";
if(!$af_TABLE5["client_text_memo"]) $af_TABLE5["client_text_memo"] = "".af_txt_form_add_53."";

if(!$af_TABLE5["font_family"]) $af_TABLE5["font_family"] = "'돋움', '돋움체', '굴림', '굴림체', 'Times New Roman', 'Verdana', 'Tahoma', 'Arial'";
if(!$af_TABLE5["font_size"]) $af_TABLE5["font_size"] = "13px";
if(!$af_TABLE5["font_color"]) $af_TABLE5["font_color"] = "#000000";
if(!$af_TABLE5["layout"]) $af_TABLE5["layout"] = "8";

$af_sectionArr = explode("|",$af_TABLE5["dummy3"]);                  //dummy3(견적서 상단표시 항목) 필드의 구분자로 부터 배열화


if($af_TABLE5["email_address"] == "xxx@addform.net")
{
die ("
<strong>".af_txt_view_addform_1."<br /></strong>
<img src='".af_help_img."error_email1.gif' border='1' alt='도움말이미지'>
<img src='".af_help_img."error_email2.gif'border='1' alt='도움말이미지'>
");
}

if(!$af_TABLE5["width"]) $af_TABLE5["width"] = "95%";                //너비값이 없을 때
if($af_TABLE5["width"] > 100) $af_w_unit = "px";
else $af_w_unit = "%";

$af_sup_telfax = explode("|",$af_TABLE5["tel"]);                     //공급자 전화번호|팩스번호

//첨부파일 용량필드에 값이 없을 때 기본 2MB
if(!$af_TABLE5["max_file_size"]) $af_TABLE5["max_file_size"] = "2000000";

$af_client_itemsArr = explode("|",$af_TABLE5["client_items"]);       //고객항목 배열화

$af_client_itemsN = 0;
if($af_TABLE5["client_items"])
{
foreach ($af_client_itemsArr as $val)
{
$af_client_itemsN = $af_client_itemsN+$val;							 //체크한 고객항목수
}
}

$arr_dummy13 = explode("|",$af_TABLE5["dummy13"]);					//폼메일 표시문구 배열
$arr_dummy14 = explode("|",$af_TABLE5["dummy14"]);					//주문폼 표시문구 배열

if($arr_dummy13[0]) $arr_dummy13[0] = $arr_dummy13[0];				//폼메일 전송버튼 표시문구
else $arr_dummy13[0] = af_txt_view_addform_skin_12;
if($arr_dummy13[1]) $arr_dummy13[1] = $arr_dummy13[1];				//폼메일 파일첨부 표시문구
else $arr_dummy13[1] = af_txt_view_addform_skin_8;
if($arr_dummy13[2]) $arr_dummy13[2] = $arr_dummy13[2];				//폼메일 합계금액 표시문구
else $arr_dummy13[2] = "합계금액";
if($arr_dummy13[3]) $arr_dummy13[3] = $arr_dummy13[3];				//폼메일 다시작성 표시문구
else $arr_dummy13[3] = "다시작성";

if($arr_dummy14[0]) $arr_dummy14[0] = $arr_dummy14[0];				//주문폼 주문버튼 표시문구
else $arr_dummy14[0] = af_txt_view_addform_skin_11;
if($arr_dummy14[1]) $arr_dummy14[1] = $arr_dummy14[1];				//주문폼 견적버튼 표시문구
else $arr_dummy14[1] = af_txt_view_addform_skin_10;					
if($arr_dummy14[2]) $arr_dummy14[2] = $arr_dummy14[2];				//주문폼 소계 표시문구
else $arr_dummy14[2] = "Subtotal";
if($arr_dummy14[3]) $arr_dummy14[3] = $arr_dummy14[3];				//주문폼 합계 표시문구
else $arr_dummy14[3] = "TOTAL";		
if($arr_dummy14[4]) $arr_dummy14[4] = $arr_dummy14[4];				//주문폼 구매자 표시문구
else $arr_dummy14[4] = af_txt_view_addform_skin_1;	
if($arr_dummy14[5]) $arr_dummy14[5] = $arr_dummy14[5];				//주문폼 수취인 표시문구
else $arr_dummy14[5] = af_txt_view_addform_skin_2;
if($arr_dummy14[6]) $arr_dummy14[6] = $arr_dummy14[6];				//주문폼 구매자와 동일 표시문구
else $arr_dummy14[6] = af_txt_view_addform_skin_3;
?>
<!--##################################################################################-->
<!--########################		HTML start	 #####################################-->
<!--##################################################################################-->
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<title><?php echo $af_TABLE5["title_text"];?></title>
<script type="text/javascript" src='js/pop_img.js'></script>

<!--########################			스타일 start			######################-->
<LINK REL="stylesheet" HREF="skins/<?php echo $af_TABLE5["skin_name"]?>/style.css" TYPE="text/css">
<LINK REL="stylesheet" HREF="upload/<?php echo $af_TABLE5["name"]?>/formStyle.css" TYPE="text/css">
<link href="skins/<?php echo $af_TABLE5["skin_name"];?>/sheet/print.css" rel="stylesheet" type="text/css" media="print" />
<style type="text/css">
/* 문서의 전체 폰트 속성 설정 */
*{
FONT-FAMILY:<?php echo $af_TABLE5["font_family"];?>;
FONT-SIZE:<?php echo $af_TABLE5["font_size"];?>;
COLOR:<?php echo $af_TABLE5["font_color"];?>;
 }
/* 뼈대를 구성하는 div 구성요소들 속성 설정*/	
div#container{width:<?php echo $af_TABLE5["width"].$af_w_unit;?>;}
</style>

<?php if($af_TABLE5["secret_price"] == 0){?>
<style type="text/css">
	/* 대외비견적일 때 스타일 속성  */
	.secret_price{display:none};
</style>
<?php } ?>


<?php if($af_TABLE5["dummy1"] == "0" or $af_TABLE5["dummy1"] == null){?>
<style type="text/css">
	/* 파일첨부 여부 스타일 속성  */
	tr.client_file td{display:none};
</style>
<?php } ?>


<?php if($af_TABLE5["dummy8"] == "0" or $af_TABLE5["dummy8"] == null){?>
<style type="text/css">
	/* 폼합계 스타일 속성  */
	#formmail_sum {display:none};
</style>
<?php } ?>
<!--########################			스타일 end				######################-->
<script type="text/javascript" src='js/change_form.js'></script>
</HEAD>

<BODY onload="roll_table('roll_table');<?php echo $af_onload;?>">
	<?php
	if($_POST["mode"] == "modify" or $_GET["mode"] == "admine")				    //관리자모드일 때
		{
			echo ("
			<div style='background-color:#efefe8;height:30px;padding:10px;' class='print'>
				<table style='width:100%;'>
					<tr>
						<td style='text-align:left;font-size:18px;font-weight:bold;'>						
							<span style='font-size:18px;font-weight:bold;background-color:#fff;color:#004a84;'>".$af_TABLE4['af_order_no']."</span>
							".$af_TABLE4['client_name']."
							<span style='font-size:18px;font-weight:bold;color:gray;'>".$af_TABLE4['client_hp']."</span>
						</td>
						<td style='text-align:right;'>
							<input type='button' value='수정모드' onclick='document.location.href=\"formmail.php?mode=admine&amp;order_no=".$_GET['order_no']."\"'>
							<input type='button' value='인쇄모드' onclick='document.location.href=\"formmail.php?mode=admine&amp;order_no=".$_GET['order_no']."&amp;mode2=normal\"'>
							<input type='button' value='인쇄하기' onclick='window.print();'>
						</td>
					</tr>
				</table>			
			</div>
			");
		}
	?>
	<FORM name='form1' id='form1' method=post action='' enctype='multipart/form-data' onsubmit='return false'>
		<input type="hidden" name="form_no" value="<?php echo $af_TABLE5["no"]?>">

		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $af_TABLE5["max_file_size"];?>"> 
		<input type="hidden" name="attachFormat" value="<?php echo $af_TABLE5["attachFormat"];?>">
		<!-- 090105 if문으로 구분 (formmail.php 와 연동)-->
		<input type="hidden" name="mode" value="<?php if($_GET['mode'] == "admine") echo 'modify';else echo 'post';?>">
		<!-- 090105 if문 추가 (formmail.php 와 연동)-->
		<?php if($_GET['mode'] == "admine") {?>
		<input type="hidden" name="order_no" value="<?php echo $_GET['order_no'];?>">
		<?php }?>

		<!-- KCP 관련 히든폼  -->
		<input type="hidden" name="pay_order_no" value="">
		<input type='hidden' name='tno' value='' size='20'>

		<?php include "skins/".$af_TABLE5["skin_name"]."/index.php";?>	
	
	</FORM>

<?php if($_GET['mode'] != "admine"){?>
</BODY>
</HTML>
<?php }?>