<?php
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

//상수와 변수정의:이 문서에서 주 작업대상이 되는 Mysql 테이블 정의
$fname ="";
$form_type = "";
$NO = "";
$opt_no = "";

if (strlen($_GET['fname']) <= 10 ) {	//폼이름을 10자 이상 안받았으므로 클린검사
	$fname = $_GET['fname'];
	$form_type = $_GET['form_type'];
	define("TABLE","".db_tblname."_".$fname."_item");	
}

if (ctype_digit($_GET['NO'])) {			//NO인자(부모창의 폼목의 고유번호)로 전달받은값이 숫자인지 클린검사
	$NO = $_GET['NO'];	
}

if (ctype_digit($_GET['opt_no'])) {		//opt_no인자(부모창의 옵션필드 배열번호)로 전달받은값이 숫자인지 클린검사
	$opt_no = $_GET['opt_no'];	
}

?>

<?
#########################################################################################
############################### 전역변수사용을 위한 것 ##################################
#########################################################################################

$re=$DBconn->f_selectDB("*",TABLE,"where no=$NO");			//C_CONNECT 클래스 멤버함수인 f_selectDB($field="*",$table,$where="")를 실행하여
															//$re[result]에 저장하고 불러온 레코드 수를 $re[cnt]에 저장 
	
           
        for ($i=0;$i<$re[cnt];$i++) {						//불러온 레코드의 수만큼 루프        
        $row=mysql_fetch_array($re[result]);				//배열의 요소들을 $row에 대입

			$no = htmlspecialchars(stripslashes($row["no"]));			
			$opt = htmlspecialchars(stripslashes($row["opt"]));
			$default_opt = htmlspecialchars(stripslashes($row["default_opt"]));
			
		}	
		
		$opt = explode("|",$opt);						    //db opt 필드의 구분자로 부터 배열화
			$subject = $opt[0];								//첫번째 배열요소를 옵션 제목으로...
			$ess =	   $opt[3];								//네번째 배열요소를 선택필수여부로...

															//필수선택 체크가 아니오일때만 아니오에 체크되게
			if($ess == "0") $check_radio = "document.form1.ess[1].checked=true;";
			if($default_opt) $check_default_opt = "document.form1.default_opt_yesorno[0].checked=true;";
			else $check_default_opt = "document.form1.default_opt_yesorno[1].checked=true;";
			


#########################################################################################
#########  자바스크립트에서 사용하기 위해 DB 테이블에서 데이타 가져오는 함수  ###########
#########################################################################################

function get_dbTable_recode() {								//이 함수는 자바스크립트문에서 출력할것임
    global $DBconn;											//$DBconn 글로벌변수 참조
	global $NO;

    $re=$DBconn->f_selectDB("*",TABLE,"where no=$NO");	    //C_CONNECT 클래스 멤버함수인 f_selectDB($field="*",$table,$where="")를 실행하여
															//$re[result]에 저장하고 불러온 레코드 수를 $re[cnt]에 저장 
	
           
        for ($i=0;$i<$re[cnt];$i++) {						//불러온 레코드의 수만큼 루프        
        $row=mysql_fetch_array($re[result]);				//배열의 요소들을 $row에 대입

			$no = htmlspecialchars(stripslashes($row["no"]));			
			$opt = htmlspecialchars(stripslashes($row["opt"]));			
		}	
		
		$opt = explode("|",$opt);						    //db opt 필드의 구분자로 부터 배열화
			$subject = $opt[0];								//첫번째 배열요소를 옵션 제목으로...
			$subject_optExist = $opt[1];					//항목제목의 존재여부를 판단하기 위한 변수
			$subject_opt = $opt[1];							//두번째 배열요소를 항목제목으로...
			$price = $opt[2];						        //세번째 배열요소를 항목가격으로...
			$ess = $opt[3];									//네번째 배열요소를 선택필수여부로...		

			$subject_opt = explode("ⓘ",$subject_opt);		//제목들에서 쉼표로 다시 구분하여 배열화
			$price = explode(",",$price);				    //가격들에서 쉼표로 다시 구분하여 배열화			


		$buffer="var items=new Array();\n";					//본 문서 자바스크립트문 안에서 사용하기 위해 배열을 자바스크립트로 치환 


		if($subject_optExist){								//항목제목이 존재한다면 옵션이 있는것으로 간주
			
		for ($i=0;$i<count($subject_opt);$i++) {		    //옵션항목의 수 만큼 루프        
															//자바스크립트 변수배열형태 재정의
															//변수형에 따라 쿼터링 주의
															//연관배열일 경우 $subject_opt와같이... 스칼라는 $subject_opt[$i]와 같이...
															//$price 문자형으로 처리해야 소숫점 뒷자리 0 입력됨															
			$buffer.="\t items[$i]=['$subject_opt[$i]','$price[$i]'];\n"; 
			
		}
	 }	 															
   
    return $buffer;	 
	 }



function get_fieldType_select() {							//이 함수는 자바스크립트문에서 출력할것임
    global $DBconn;											//$DBconn 글로벌변수 참조
	global $NO;

    $re=$DBconn->f_selectDB("*",TABLE,"where no=$NO");	    //C_CONNECT 클래스 멤버함수인 f_selectDB($field="*",$table,$where="")를 실행하여
															//$re[result]에 저장하고 불러온 레코드 수를 $re[cnt]에 저장 
	
           
        for ($i=0;$i<$re[cnt];$i++) {						//불러온 레코드의 수만큼 루프        
        $row=mysql_fetch_array($re[result]);				//배열의 요소들을 $row에 대입

			$no = htmlspecialchars(stripslashes($row["no"]));			
			$opt = htmlspecialchars(stripslashes($row["opt"]));	

		}	
		
		$opt = explode("|",$opt);						    //db opt 필드의 구분자로 부터 배열화
			 $fieldType = $opt[4];							

			
		if(!$fieldType){										
			 $fieldType_select = "document.form1.fieldType.options[0].selected = true;";
		}	
		else {			
			$fieldType_select = "document.form1.fieldType.options[$fieldType].selected = true;\n";
		}

	return $fieldType_select;	 
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<meta name='robots' content='none,noindex,nofollow'>
<title>애드폼 품목 옵션 추가 삭제</title>
<LINK REL="stylesheet" HREF="global.css" TYPE="text/css">
<?php if($_GET['form_type'] == 1){?>
		<!-- 폼형식이 폼메일일 때 -->
		<style type="text/css">
			.estimate_only{display:none};
			
		</style>

<?php } ?>

<?php if($_GET['form_type'] == 0){?>
		<!-- 폼형식이 주문/견적일 때 -->
		<style type="text/css">
			.formmail_only{display:none};			
		</style>

<?php } ?>

<!--##################################################################################-->
<!--########################	자바스크립트 start	##################################-->
<!--##################################################################################-->
<script type="text/javascript" src='js/pop_center.js'></script>
<script type="text/javascript" src='js/check_input.js'></script>
<script type="text/javascript" src='js/array_del.js'></script>
<SCRIPT TYPE='text/javascript'>
function check_radio()
{
	<?php echo $check_radio ?>
	<?php echo $check_default_opt ?>
}
</script>

<SCRIPT TYPE='text/javascript'>
function default_opt_yn()
{
	var field=document.getElementsByTagName('input');	 //input 태그 갯수 검사
	
		for (i = 0; i < field.length;i++)
			{											 //input 태그 갯수만큼 루프
										
			if(field[i].className=='chk_default')
				{										 //일치하는 클래스명이 있을 때
				field[i].checked=false;		     
				}
			}

}
</script>

<SCRIPT TYPE='text/javascript'>
//080324 추가 - 옵션필드의 5번째 구분값으로 부터 펼침목록 초기선택
function fieldType_select(){
	<?php echo get_fieldType_select();?> 
	<?php echo $fieldType_select;?> 
	}
</script>

<script type="text/javascript">
//## 1. DB 테이블에서 데이타 가져와서 배열화 하는 php 함수(윗부분 php구문안에 정의되있음)
<?php echo get_dbTable_recode();?>                         

var item_len;											   //전체 레코드의 행수

var CurrentPosition;									   //현재 배열 레코드 포인트의 값

function resetItemSize() {								   //현재 레코드의 수를 재정의
    item_len=items.length;	
}


//###########################	2. 새품목 추가함수 start	###########################//
function add_item(f) {									  
	
	//f['nCode'].value=item_len+1;						   //코드번호를 자동으로 1씩 증가하게

	if (!f['nName'].value) {
        alert('<?php echo af_txt_add_opt_1;?>');
        return f['nName'].focus();
    }	

	 if (!f['nPrice'].value) {
        alert('<?php echo af_txt_add_opt_2;?>');
        return f['nPrice'].focus();
    }
    
														   //현재 옵션의 요소들을 배열에 추가														   
	items[CurrentPosition]=[f['nName'].value,f['nPrice'].value]; 
    
    
    resetItemSize();									   //현재 배열 레코드의 수를 재정의
    
    
    paste_patchZone(htmlConvert_data(CurrentPosition++));  //배열을 html로 컨버팅하여, patchZone에 덧붙이고
														   //현재 배열 레코드 포인트의 값을 1증가    
    
    with (f) {
        nName.value = "";								   //품목 추가 입력 필드들 초기화
		nPrice.value = "0";
        nName.focus();
    }
    return true;
}
//#####	새품목 추가함수 end	#####//



//########################## 배열요소들을 HTML로 변환하는 함수 ########################//						
function htmlConvert_data(i) {
		var default_opt = "<?php echo $default_opt?>";
		if(default_opt && default_opt == items[i][0]) var checked = "checked";

		var buffer="<table class='norboder'><TBODY><tr>"

			+"<td style='text-align:left'><input name=name_it["+i+"] class=class_name onblur=\"quot_Del(this)\" "
            +"value=\""+items[i][0]+"\"><span class='formmail_only'> "
			+"<input type='radio' name='chk_default' onclick='this.form.default_opt_yesorno[0].checked=true;' class='chk_default' value=\""+items[i][0]+"\" "+checked+"><\/span> <\/td> "		
			
			+"<td style='text-align:left'><input type='text' name=price["+i+"] class=class_price onblur=\"NumberDot(this)\" "
            +"value=\""+items[i][1]+"\"><\/td> "		

            +"<td style='text-align:left'><input type=button value='<?php echo af_txt_del;?>' "
            +"onclick='del_item("+i+")'><\/td> <\/tr><\/TBODY><\/table>";
		
        return buffer;
}


//########### htmlConvert_data(i)에서 변환한 코드를 patchZone 에 쓰는 함수 ############//
function paste_patchZone(convertData) {					  
    //document.all['patchZone'].innerHTML+=convertData;	  //불여우에서는 동작안함
	document.getElementById('patchZone').innerHTML+=convertData;
}


//############################## 3. 품목삭제 함수 start  ##############################//
function del_item(i) {									  
    if (confirm('<?php echo af_txt_add_opt_3;?>')) {
        
        items=items.array_del(i);		
        //document.all['patchZone'].innerHTML+="";		  //불여우에서는 동작 안함	  
		document.getElementById('patchZone').innerHTML="";//해당 배열의 patchZone 을 비움   
        initial();										  //문서 초기화
	
	//옵션초기선택값 사용안함에 체크시 모든 옵션항목 체크해제
	var field=document.getElementsByTagName('input');	 //input 태그 갯수 검사
	if(document.form1.default_opt_yesorno && document.form1.default_opt_yesorno[1].checked==true)
		{	
		for (i = 0; i < field.length;i++)
			{											 //input 태그 갯수만큼 루프
										
			if(field[i].className=='chk_default')
				{										 //일치하는 클래스명이 있을 때
				field[i].checked=false;		     
				}
			}
		}
    }
}
															


//############################  초기 문서출력함수 start  ##############################//
function initial() {									  
    var buffer="";   
							
    resetItemSize();									  //현재 레코드의 수를 재정의
    
    for (var i=0;i<item_len;i++) {						  // items[] 배열수만큼      
        buffer+=htmlConvert_data(i);                      // HTML 변환
    } 
   
    CurrentPosition=i;									  //현재 배열 레코드 포인트의 값    
    
    paste_patchZone(buffer);							  //htmlConvert_data(i)에서 변환한 코드를 patchZone 에 쓰는 함수
	
}
//###########################  초기 문서출력함수 end  #################################//
</script>

<script type="text/javascript">	
<!--								 

function Mix(f){
	var val_subject = document.form1.optBigName.value;   //옵션제목
	var val_name = "";								     //옵션항목제목
	var val_price = "";									 //옵션항목가격
	var val_ess = document.form1.ess.value;		         //필수선택여부
														 //입력형식
	var val_fieldType = document.form1.fieldType.options[document.form1.fieldType.selectedIndex].value;	 

	if(f.ess[0].checked) val_ess = "1";
	else val_ess = "0";

	var field=document.getElementsByTagName('input');	 //input 태그 갯수 검사
	
		for (i = 0; i < field.length;i++){				 //input 태그 갯수만큼 루프
										
			if(field[i].className=='class_name'){		 //일치하는 클래스명이 있을 때
				val_name+=field[i].value+"ⓘ";		     //항목이름값들을 쉼표구분자로 합침
				}
			}

		for (i = 0; i < field.length;i++){				 //input 태그 갯수만큼 루프
										
			if(field[i].className=='class_price'){		 //일치하는 클래스명이 있을 때
				val_price+=field[i].value+",";		     //항목가격값들을 쉼표구분자로 합침
				}
			}
			
    if (val_name){										 //항목이 있을 때 각항목값들을 mix_data에 대입
	
		var mix_data ="" 
			+val_subject+"|"
			+val_name.slice(0,-1)+"|"
			+val_price.slice(0,-1)+"|"
			+val_ess+"|"
			+val_fieldType;
		}
	else mix_data = "";									 //항목이 없을 때 mix_data

	if (!f['optBigName'].value) {						 //옵션제목 입력여부 체크
        alert('<?php echo af_txt_add_opt_4;?>');
        return f['optBigName'].focus();
    }		


	var field=document.getElementsByTagName('input');	 //input 태그 갯수 검사
	
	var default_opt = "";	
		for (i = 0; i < field.length;i++){				 //input 태그 갯수만큼 루프
														 //일치하는 클래스명이 있고, 체크되어 있을 때
			if(field[i].className=='chk_default' && field[i].checked==true){		 
				var default_opt = field[i].value;		
				}
			}	
														 //조건을 통과시 부모창의 옵션필드에 입력
window.opener.document.form1["opt[<?php echo $opt_no;?>]"].value = mix_data;
														 //부모창의 옵션디폴트 필드에 입력
window.opener.document.form1["default_opt[<?php echo $opt_no;?>]"].value = default_opt;

top.opener=top.window.close();
	
}		

-->
</script>
<!--##################################################################################-->
<!--#################################	자바스크립트 end	##########################-->
<!--##################################################################################-->
</HEAD>

<BODY onload='initial();check_radio();fieldType_select();'>
<FORM name='form1' method='post' action='<?php echo $_SERVER['PHP_SELF'];?>?mode=save' onsubmit='return false'>
<input type="hidden" name="fname" value="<?php echo $fname?>">

<!--
onblur='Numbering(this)' 이벤트:커서를 영역밖으로 이동했을 때, Numbering함수 실행하여, 숫자만 입력했는지 체크
onkeyup='checkKey(addBtn)' 이벤트:checkKey()함수 실행하여, 폼전송
onblur='quot_Del(this)' 이벤트:입력필드항목의 인용부호(따옴표)를 제거
-->

<div>

<FIELDSET>
<LEGEND><strong><?php echo af_txt_add_opt_5;?></strong></LEGEND> 
<p style="text-align:left;font-size:11px;color:gray;">
* 옵션제목은 현재 기능상 사용되는곳이 없으므로, 임의의 제목을 입력해 놓으면 됩니다.
</p>
<TABLE class="noborder">
<TR>	
	<TD style='text-align:left'>  
		[<?php echo af_txt_add_opt_6;?>]
	</TD>
	<TD style="text-align:left">  
		<input name='optBigName' onkeyup='checkKey(addBtn)' onblur='quot_Del(this)' value="<?php if($subject) echo $subject; else echo '옵션';?>">
	</TD>	
</TR>

<TR>	
	<TD style='text-align:left'>
		[<?php echo af_txt_add_opt_7;?>]
	</TD>
	<TD style="text-align:left">
	<span style="background-color:#c88282;padding-top:2px;">
		YES  <input type='radio' name='ess'  value='1' checked>	
		NO<input type='radio' name='ess'  value='0'>	
	</span>
		
	</TD>	
</TR>

<TR>	
	<TD style="text-align:left"> 
		[<?php echo af_txt_add_opt_8;?>]
	</TD>

	
	<TD style="text-align:left">
	<?php if($form_type == 0) {?>
		<select name="fieldType">
			<option value="0"><?php echo af_txt_add_opt_9;?>
			<option value="1"><?php echo af_txt_add_opt_10;?>
			<option value="2"><?php echo af_txt_add_opt_11;?>	
		</select>
	<?php }?>

	<?php if($form_type == 1) {?>
		<select name="fieldType">
			<option value="0"><?php echo af_txt_add_opt_9;?>
			<option value="1"><?php echo af_txt_add_opt_10;?>
			<option value="2"><?php echo af_txt_add_opt_11;?>
			<option value="3"><?php echo af_txt_add_opt_12;?>
			<option value="4"><?php echo af_txt_add_opt_13;?>
		</select>
	<?php }?>

	</TD>	
</TR>
</TABLE>
</FIELDSET>

<FIELDSET style="margin-top:20px;">
<LEGEND><strong><?php echo af_txt_add_opt_14;?></strong></LEGEND> 
<TABLE class="noborder">
<TR>	
	<TD style='text-align:left'>  
		[<?php echo af_txt_add_opt_15;?>]
	</TD>
	<TD style='text-align:left'>  
		[<?php echo af_txt_add_opt_16;?>]
	</TD>	
</TR>

<TR>
	
	<TD style='text-align:left'>
		<input name='nName' onkeyup='checkKey(addBtn)' onblur='quot_Del(this)'>	
		<!-- 폼메일일 때 자리 맞추기용 -->
		<input type="radio" name="dummy" style="visibility:hidden" class="formmail_only">
	</TD>
	<TD style='text-align:left'>
		<input type='text' name='nPrice' onkeyup='checkKey(addBtn)' onblur='NumberDot(this)' value="0">		
	</TD>	
		
	<TD style='text-align:left'>	 
	    <input type='button' id='addBtn' value='<?php echo af_txt_add;?>' onclick='add_item(this.form)'>		
	</TD>
</TR>
</TABLE>
</FIELDSET>
</div>

<div>
<FIELDSET STYLE="BORDER:0;">
<TABLE CLASS="noborder">
<TR>
	<TD id="patchZone">	
	</TD>
</TR>
</TABLE>
</FIELDSET>
</div>

<div class="formmail_only">
<FIELDSET>
<TABLE CLASS="noborder">
<tr>
	<td style="width:50%;border-right:1px solid #cccccc;text-align:left">
	<?php echo af_txt_add_opt_17;?>
	</td>
	<TD style="font-weight:bold;text-align:left">
	<?php echo af_txt_add_opt_18;?>
	</TD>
	<TD style="font-weight:bold">
	<input type="radio" name="default_opt_yesorno">YES
	<input type="radio" name="default_opt_yesorno" onclick="default_opt_yn();">NO
	</TD>
</TR>
</TABLE>
</FIELDSET>
</div>

<TABLE CLASS="noborder">
<TR>
	<TD style="text-align:CENTER">
		<input type='button' value='<?php echo af_txt_confirm;?>' onclick='Mix(this.form)' class="btn_set">
	</TD>
</TR>
</TABLE>
<!--##########################  출력 테이블 디자인 end  ##############################-->
</FORM>

</BODY>
</HTML>