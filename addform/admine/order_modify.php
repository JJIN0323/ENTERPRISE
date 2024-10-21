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

$get_mode = $_GET['mode'];
$post_type = $_POST['post_type'];


#########################################################################################
############################	DB addform_table에서 가져오기	#########################
#########################################################################################
$f_mom = $_GET['f_mom'];																	//폼이름
$where="where name='$f_mom'";
$res1=$DBconn->f_selectDB("*",TABLE5,$where);									
$result1 = $res1[result];
$row1 =  mysql_fetch_array($result1);

	$html['coin_unit'] = htmlspecialchars(stripslashes($row1["coin_unit"]));				//통화단위

	$html['title_text'] = htmlspecialchars(stripslashes($row1["title_text"]));
	$html['client_text_name'] = htmlspecialchars(stripslashes($row1["client_text_name"]));
	$html['client_text_email'] = htmlspecialchars(stripslashes($row1["client_text_email"]));
	$html['client_text_hp'] = htmlspecialchars(stripslashes($row1["client_text_hp"]));
	$html['client_text_tel'] = htmlspecialchars(stripslashes($row1["client_text_tel"]));
	$html['client_text_fax'] = htmlspecialchars(stripslashes($row1["client_text_fax"]));
	$html['client_text_address'] = htmlspecialchars(stripslashes($row1["client_text_address"]));
	$html['client_text_memo'] = htmlspecialchars(stripslashes($row1["client_text_memo"]));
	$html['site_cd'] = htmlspecialchars(stripslashes($row2["site_cd"]));
	$html['site_key'] = htmlspecialchars(stripslashes($row2["site_key"]));

	if(!$html['client_text_name']) $html['client_text_name'] = "".af_txt_form_add_47."";
	if(!$html['client_text_email']) $html['client_text_email'] = "".af_txt_form_add_48."";
	if(!$html['client_text_hp']) $html['client_text_hp'] = "".af_txt_form_add_49."";
	if(!$html['client_text_tel']) $html['client_text_tel'] = "".af_txt_form_add_50."";
	if(!$html['client_text_fax']) $html['client_text_fax'] = "".af_txt_form_add_51."";
	if(!$html['client_text_address']) $html['client_text_address'] = "".af_txt_form_add_52."";
	if(!$html['client_text_memo']) $html['client_text_memo'] = "".af_txt_form_add_53."";



if($post_type == "modify"){
#########################################################################################
############################	수정모드일 때 폼으로 부터 받아오기	#####################
#########################################################################################
$clean=array();
		if($_POST['pay_ok'] == "ok") $clean['pay_cancel'] = "on";
		if($_POST['pay_ok'] == "no") $clean['pay_cancel'] = "off";
	
		$clean['no'] = $_POST['post_no'];					//폼으로 부터 받은 접수 번호
		$clean['client_name'] = $_POST['client_name'];		//폼으로 부터 받은 고객 이름
		$clean['client_tel'] = $_POST['client_tel'];		//폼으로 부터 받은 고객	전화번호	
		$clean['client_hp'] = $_POST['client_hp'];			//폼으로 부터 받은 고객	휴대폰
		$clean['client_fax'] = $_POST['client_fax'];		//폼으로 부터 받은 고객	fax
		$clean['client_email'] = $_POST['client_email'];	//폼으로 부터 받은 고객	이메일
		$clean['client_address'] = $_POST['client_address'];//폼으로 부터 받은 고객 주소
		$clean['client_memo'] = $_POST['client_memo'];		//폼으로 부터 받은 고객 메모
		$clean['supply_memo'] = $_POST['supply_memo'];		//폼으로 부터 받은 관리자 메모
		$clean['edit_date'] = $_POST['edit_date'];			//폼으로 부터 수정 시각
		$clean['select_items'] = $_POST['total_data'];		//폼으로 부터 받은 주문 믹싱 데이타
		$clean['sum'] = $_POST['total_sum'];				//폼으로 부터 받은 합  계
		$clean['sum'] = str_replace(",","",$clean['sum']);	//폼으로 부터 받은 합  계에서 쉼표제거
		$clean['dummy4'] = $_POST['total_sum2'];			//폼으로 부터 받은 한자,한글 합  계
		$clean['edit_date'] = time();						//폼 수정시각	

		


///////	DB에 업데이트	///////
													
		$where="where no = ".$clean['no'];			 //문자형일 경우 작은따옴표 붙임에 주의
		$DBconn->f_updateDB(TABLE4,$clean,&$where);	 //테이블, 필드와값, 조건절

echo ("
	<script type='text/javascript'>
		document.location.href='order_modify.php?mode=admine&order_no=".$clean['no']."';
		alert('".af_txt_order_modify_1."');
	</script>
");
	
}


if($get_mode == "admine"){
#########################################################################################
############################	DB order_table에서 가져오기	#############################	
#########################################################################################
$no = $_GET['order_no'];													//접수번호
$where="where no='$no'";
$re=$DBconn->f_selectDB("*",TABLE4,$where);									//해당 테이블에서 정보가져옴
$result = $re[result];
$row =  mysql_fetch_array($result);


$clean=array();
		$af_order_no = htmlspecialchars(stripslashes($row["af_order_no"]));					//접수번호
		$mom =  htmlspecialchars(stripslashes($row["mom"]));								//속한 주문폼 이름 
		$order_date = htmlspecialchars(stripslashes($row["input_date"]));					//등록시각
		$clean['client_name'] = htmlspecialchars(stripslashes($row["client_name"]));		//고객 이름
		$clean['client_tel'] = htmlspecialchars(stripslashes($row['client_tel']));			//고객	전화번호	
		$clean['client_hp'] = htmlspecialchars(stripslashes($row["client_hp"]));			//고객	휴대폰
		$clean['client_fax'] = htmlspecialchars(stripslashes($row["client_fax"]));			//고객	휴대폰
		$clean['client_email'] = htmlspecialchars(stripslashes($row['client_email']));		//고객	이메일
		$clean['client_address'] = htmlspecialchars(stripslashes($row['client_address']));	//고객 주소
		$clean['client_memo'] = htmlspecialchars(stripslashes($row['client_memo']));		//고객 메모
		$clean['supply_memo'] = htmlspecialchars(stripslashes($row['supply_memo']));		//관리자 메모
		$clean['total_data'] = htmlspecialchars(stripslashes($row["select_items"]));		//데이타
		$clean['total_sum'] = htmlspecialchars(stripslashes($row["sum"]));					//합  계
		$clean['total_sum2'] = htmlspecialchars(stripslashes($row["dummy4"]));				//한자, 한글 합  계
		$clean['tno'] = htmlspecialchars(stripslashes($row["tno"]));							//kcp 거래번호(취소/매입시 사용)
		$clean['pay_cancel'] = htmlspecialchars(stripslashes($row["pay_cancel"]));			//kcp 결제취소(on,off)
		$clean['input_date'] = htmlspecialchars(stripslashes($row["input_date"]));			//최초접수
		$clean['edit_date'] = htmlspecialchars(stripslashes($row["edit_date"]));			//최근수정

		$clean_memo = $clean['client_memo'];
	

$arr_formdata = explode("|*|",$clean['total_data']);						//"|*|" 구분자로 1차 배열			
					$it_name = explode(";",$arr_formdata[0]);				//1.품목이름 2차배열
					$opt_text = explode(";",$arr_formdata[1]);				//2.옵션제목 2차배열 
					$opt_price = explode(";",$arr_formdata[2]);				//3.옵션가격 2차배열
					$it_unit = explode(";",$arr_formdata[3]);				//4.품목규격 2차배열
					$it_num = explode(";",$arr_formdata[4]);				//5.주문수량 2차배열
					$it_price = explode(";",$arr_formdata[5]);				//6.품목단가 2차배열
					$it_sumPrice = explode(";",$arr_formdata[6]);			//7.공급가액 2차배열
					$it_price_taxDB = explode(";",$arr_formdata[7]);		//8.세	  율 2차배열

$arr_formdata2 = explode("|",$clean['total_sum2']);							//"|" 구분자로 배열			
					$total_kr = $arr_formdata2[0];							//1. 한글 합계
					$total_china = $arr_formdata2[1];						//2. 한자 합계

$input_date = date("Y년n월d일 H시i분",$clean['input_date']);
if($clean['edit_date']) $edit_date = date("Y년n월d일 H시i분",$clean['edit_date']);
else $edit_date = "0 회";

}




#########################################################################################
#############################  위 데이타로 $buffer 만들기  ##############################
#########################################################################################

function get_dbTable_recode() {								//이 함수는 자바스크립트문에서 출력할것임 
	global $it_name;
	global $opt_text;
	global $opt_price;
	global $it_unit;
	global $it_num;
	global $it_price;
	global $it_sumPrice;
	global $it_price_taxDB;
	
    $buffer="var items=new Array();\n";						//본 문서 자바스크립트문 안에서 사용하기 위해 배열을 자바스크립트로 치환
    
    for ($i=0;$i<count($it_name);$i++) {					//주문한 품목수만큼 루프        
        
		if(!$it_price_taxDB[$i]) $it_price_taxDB[$i] = 0;
															//루프된 items 자바스크립트 변수배열형태 재정의
															//변수형에 따라 쿼터링 주의
															//연관배열일 경우 $code와같이... 스칼라는 $code[$i]와 같이...
        $buffer.="\t items[$i]=['$it_name[$i]','$opt_text[$i]',$opt_price[$i],'$it_unit[$i]',$it_num[$i],$it_price[$i],$it_sumPrice[$i],$it_price_taxDB[$i]];\n"; 
    }
    return $buffer;
}

?>
<!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
<!--################     품목별 세액 합계와 총합계 구하기 start	  ####################-->
<!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
<?php
######################	주문서와 견적서출력에 소숫점 반영 여부   ######################## 

if (substr_count($arr_formdata[2],".") > 0)					//옵션값에서 소수출현회수
{									
		$opt_price_dot = "yes";
}
else $opt_price_dot = "no";

if (substr_count($arr_formdata[5],".") > 0)					//품목값에서 소수출현횟수
{									
		$it_price_dot = "yes";
}
else $it_price_dot = "no";

if ($opt_price_dot == "yes" || $it_price_dot == "yes")		//둘 중 하나라도 소수가 있다면
{					
$number_formatN = "2";
}
else $number_formatN = "0";



$taxTotal = 0;											//각품목별 세액의 합

for ($i=0;$i<count($it_name);$i++)						//품목 배열의길이 만큼 루프
{
														//1행 소계 세액
	$it_sumPrice_tax[$i] = $it_sumPrice[$i] * $it_price_taxDB[$i]/100;
	$taxTotal = $taxTotal + $it_sumPrice_tax[$i];		//품목별 세액 합계
}
$taxTotal_txt = number_format($taxTotal,$number_formatN);
														//부가세포함 총합계
$total_thispage = number_format($clean['total_sum'] + $taxTotal,$number_formatN);		

?>
<!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
<!--################     품목별 세액 합계와 총합계 구하기 end	  ####################-->
<!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->

<!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
<!--########################### HTML START ###########################################-->
<!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
	<meta http-equiv='content-type' content='text/html; charset=utf-8'>
		<title>	
		<?php echo af_txt_order_modify_2;?> <?php echo $_GET['order_no'];?> <?php echo af_txt_order_modify_3;?>
		</title>	
		<LINK REL="stylesheet" HREF="global.css" TYPE="text/css">
		
<!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
<!--###############################  자바스크립트 start	 #############################-->
<!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
<script type="text/javascript" src='js/pop_center.js'></script>
<script type="text/javascript" src='../js/money_kr.js'></SCRIPT>
<script type="text/javascript" src='../js/money_china.js'></SCRIPT>
<script type="text/javascript" src='js/check_input.js'></script>
<script type="text/javascript" src='js/array_del.js'></script>
<script type="text/javascript">
<?php echo get_dbTable_recode();?>                         //##### 1. DB 테이블에서 데이타 가져와서 배열화 하는 php 함수(윗부분 php구문안에 정의되어 있음)

var item_len;											   //전체 레코드의 행수

var CurrentPosition;									   //현재 배열 레코드 포인트의 값

function resetItemSize() {								   //현재 레코드의 수를 재정의
    item_len=items.length;	
}



function add_item(f) {									   //#####	2. 새품목 추가함수 start	#####//
	
	
	if (!f['Nit_name'].value) {
        alert("<?php echo af_txt_order_modify_4;?>");		
        return f['Nit_name'].focus();
    }
    
	
	if (!f['Nit_num'].value) {
        alert('<?php echo af_txt_order_modify_5;?>');		
        return f['Nit_num'].focus();
    }

	if (!f['Nopt_price'].value) {
        alert('<?php echo af_txt_order_modify_6;?>');		
        return f['Nopt_price'].focus();
    }

	if (f['Nopt_price'].value > 0 && !f['Nopt_text'].value) {
        alert('<?php echo af_txt_order_modify_7;?>');		
        return f['Nopt_text'].focus();
    }

	if (!f['Nit_price'].value) {
        alert('<?php echo af_txt_order_modify_8;?>');		
        return f['Nit_price'].focus();
    }

	
	if (!f['Nit_unit'].value){
		f['Nit_unit'].value = "<?php echo af_txt_order_modify_9;?>";
	}

														 
    
														   //현재 품목의 요소들을 배열에 추가														   
	items[CurrentPosition]=[f['Nit_name'].value,f['Nopt_text'].value,f['Nopt_price'].value,f['Nit_unit'].value,f['Nit_num'].value,f['Nit_price'].value,f['Nit_sumPrice'].value,f['Nit_price_taxDB'].value]; 
    
    
    resetItemSize();									   //현재 배열 레코드의 수를 재정의
    
    
    paste_patchZone(htmlConvert_data(CurrentPosition++));  //배열을 html로 컨버팅하여, patchZone에 덧붙이고
														   //현재 배열 레코드 포인트의 값을 1증가    
    
    with (f) {
        Nit_name.value="";								   //품목 추가 입력 필드들 초기화
		Nopt_text.value="";
		Nit_num.value="1";
		Nit_price.value="0";
		Nopt_price.value="0";
		Nit_sumPrice.value="0";
    }
    return true;
}
														   //##	새품목 추가함수 end	###//


//#####################################################################################//

//배열요소들을 HTML로 변환하는 함수
//위 61번라인의 DB 입력 배열과 맟춤에만 주의(인터페이스를위해 순서는 상관없음)

//#####################################################################################//

function htmlConvert_data(i) {
		var ini_tax = items[i][6] * items[i][7]/100;	    //처음 표시될 품목의 세액
				
	    var buffer="<ul><li class='th2'> " 

			+"<input type='text' name=it_name["+i+"] onblur=\"quot_Del(this)\" "
            +"value=\""+items[i][0]+"\" id=\"it_name["+i+"]\"> "

			+"<input type='text' name=it_price["+i+"] onblur=\"NumberDot(this)\" onkeyup=\"NumberDot(this);subtotal(this.form,"+i+");\" "
            +"value=\""+items[i][5]+"\" style='text-align:right;' size='10'> "

			+"<input type='text' name=it_num["+i+"] onblur=\"Numbering(this)\" onkeyup=\"Numbering(this);subtotal(this.form,"+i+");\" "
            +"value=\""+items[i][4]+"\" size='5'  style='text-align:right'> "

			+"<!--<img src='../imgs/btn_up.gif' onclick='it_num_decrease(document.form1,"+i+",\"up\",\"\",\"\");' onmouseover='this.src=\"../imgs/btn_up_over.gif\";' onmouseout='this.src=\"../imgs/btn_up.gif\";'> "
			+"<img src='../imgs/btn_down.gif' onclick='it_num_decrease(document.form1,"+i+",\"down\",\"\",\"\");' onmouseover='this.src=\"../imgs/btn_down_over.gif\";' onmouseout='this.src=\"../imgs/btn_down.gif\";'>--> "	

			+"<input type='text' name=it_unit["+i+"] "
            +"value=\""+items[i][3]+"\" size='5'>&nbsp;"

			+"<input type='text' name=opt_text["+i+"] onblur=\"quot_Del(this)\" "
            +"value=\""+items[i][1]+"\" id=\"opt_text["+i+"]\"> "

			+"<input type='text' name=opt_price["+i+"] onblur=\"NumberDot(this)\" onkeyup=\"NumberDot(this);subtotal(this.form,"+i+");\" "
            +"value=\""+items[i][2]+"\" style='text-align:right;' size='10'>&nbsp;"			
			
			+"<input type='text' name=it_sumPrice["+i+"] onblur=\"NumberDot(this)\" "
            +"value=\""+items[i][6]+"\" style='text-align:right;color:blue;' size='20' class='subTotal' readonly> "

			+"<input type='text' name=it_price_taxDB["+i+"] onblur=\"NumberDot(this)\" onkeyup=\"NumberDot(this);subtotal(this.form,"+i+");\" "
            +"value=\""+items[i][7]+"\" style='text-align:right;' size='5'>% "
			+"<input type='hidden' name='it_price_tax["+i+"]' id='it_price_tax["+i+"]' value="+ini_tax+" class='subTax' readonly> "

			+"<input type=button value='<?php echo af_txt_del;?>' "
            +"onclick='del_item("+i+")' class='btn_red'>"
			+"<\/li><\/ul>";

        return buffer;
}

//############# htmlConvert_data(i)에서 변환한 코드를 patchZone 에 쓰는 함수 ##########//
function paste_patchZone(convertData) {					  
        //document.all['patchZone'].innerHTML+=convertData;	  //불여우에서는 동작안함
	document.getElementById('patchZone').innerHTML+=convertData;
}

//########################  3. 품목삭제 함수 start  ###################################//
function del_item(i) {  									  
    if (confirm('<?php echo af_txt_order_modify_10;?>')) {
        
        items=items.array_del(i);		
        //document.all['patchZone'].innerHTML+="";		  //불여우에서는 동작 안함	  
		document.getElementById('patchZone').innerHTML="";//해당 배열의 patchZone 을 비움   
        initial();										  //문서 초기화
		subtotal_sum();									  //합계 다시 구하기
    }
}
	
//#####################################################################################//
//##################	소계와 합계 스크립트 starrt	   ################################//
//#####################################################################################//

function add_NsumPrice(frm)									     //주문항목 추가시 추가행 임시 소계
{																 //각행의 소계구하기 함수
																 
	var Nit_num = frm["Nit_num"].value;					 //주문량 필드 값
																 //품목의 값(실수로)
	var Nit_price = Math.round(parseFloat(frm["Nit_price"].value)*100)/100;
															     //규격(옵션)의 값	(실수로)
	var Nopt_price = Math.round(parseFloat(frm["Nopt_price"].value)*100)/100;	 
	
	if(Nit_price == "0")											 //품목의 값이 0원일 때는
		{														 //소계를 위한 곱셈 연산자를 옵션의 값으로 대체															 
		frm["Nit_sumPrice"].value = Math.round(Nopt_price * Nit_num *100)/100;															
		}

	else{														 //품목의 값이 0원이 아닐경우엔...
		if(Nopt_price == "0") 
			{													 //품목에만 값이 있을 경우, 소계
			frm["Nit_sumPrice"].value = Math.round(Nit_price * Nit_num *100)/100;															
			}

		else{													 //품목과 옵션에 모두 값이 있을 경우
			frm["Nit_sumPrice"].value = Math.round(Nit_price * Nit_num + Nopt_price)*100/100;															
			}
		}	

}


function subtotal(frm,i)
{																 //각행의 소계구하기 함수
																 
	var it_num = frm["it_num["+i+"]"].value;					 //주문량 필드 값
																 //해당 품목의 값(실수로)
	var it_price = Math.round(parseFloat(frm["it_price["+i+"]"].value)*100)/100;
															     //해당 규격(옵션)의 값	(실수로)
	var opt_price = Math.round(parseFloat(frm["opt_price["+i+"]"].value)*100)/100;	 
	
	if(it_price == "0")
		{														 //해당 품목의 값이 0원일 때는
																 //소계를 위한 곱셈 연산자를 옵션의 값으로 대체
		frm["it_sumPrice["+i+"]"].value = Math.round(opt_price * it_num *100)/100;	 				
																 //품목 세금
		frm["it_price_tax["+i+"]"].value = Math.round(frm["it_sumPrice["+i+"]"].value * frm["it_price_taxDB["+i+"]"].value /100 * 100)/100;
		subtotal_sum();	
		}

	else{														 //품목의 값이 0원이 아닐경우엔...
	
		if(opt_price == "0") 
			{													 //품목에만 값이 있을 경우, 소계
			frm["it_sumPrice["+i+"]"].value = Math.round(it_price * it_num *100)/100;
																 //품목 세금
			frm["it_price_tax["+i+"]"].value = Math.round(frm["it_sumPrice["+i+"]"].value * frm["it_price_taxDB["+i+"]"].value /100 * 100)/100;		
			subtotal_sum();		
			}

		else{													 //품목과 옵션에 모두 값이 있을 경우
			frm["it_sumPrice["+i+"]"].value = Math.round(it_price * it_num + opt_price)*100/100;
																 //품목 세금
			frm["it_price_tax["+i+"]"].value = Math.round(frm["it_sumPrice["+i+"]"].value * frm["it_price_taxDB["+i+"]"].value /100 * 100)/100;	
			subtotal_sum();		
			}
		}	

}


function subtotal_sum(){										 //합계구하기 함수	
		
		var z = 0;												 //DB 입력될 합계(부가세제외금액)
		var t = 0;												 //세액 합계(DB입력안함)
		var field=document.getElementsByTagName('input');		

		for (var i=0; i < field.length;i++)
			{			
			if(field[i].className=='subTotal')
				{				
				//z+= parseInt(field[i].value);					 //정수로 파서하지 않으면 문자열이 됨	
				z+= parseFloat(field[i].value);					 //소수점 반영위해 실수화					
				}									
			}
			
		for (var i=0; i < field.length;i++)
			{				
			if(field[i].className=='subTax')
				{				
				t+= parseFloat(field[i].value);					//실수로 파서하지 않으면 소숫점표현안됨					
				}									
			}
		z = Math.round(z * 100)/100;							//소수점 두자리에서 반올림	
		t = Math.round(t * 100)/100;							//소수점 두자리에서 반올림
		comma(z,t)												//숫자에 콤마찍기 함수 호출
 }

function comma(z,t)
{
/*-------------------------------------------------------------------------------------*/
/*						DB입력위한 합계와 문자화합계								   */
/*-------------------------------------------------------------------------------------*/
	 var x = document.form1.total_sum;							 //합계::콤마찍어 표현 후, db입력시엔 콤마제거함
	 var x3 = document.form1.total_sum3;						 //한자, 한글 금액입력위한 가상필드(콤마안찍고) => total_sum2에 입력
	 var y = String(z);											 //숫자를 문자화	 

		while(y.match(/^(-?\d+)(\d{3})/))
		{
		y = y.replace(/^(-?\d+)(\d{3})/,'$1,$2');
		}		
	
	x.value = y;												
	x3.value = z;
/*-------------------------------------------------------------------------------------*/
/*						부가세합계와 TOTAL 표시(보이기위함의 용도)					   */
/*-------------------------------------------------------------------------------------*/
	t2= String(t);												 //부가세합계를 문자화

	while(t2.match(/^(-?\d+)(\d{3})/))
		{
		t2 = t2.replace(/^(-?\d+)(\d{3})/,'$1,$2');
		}
	
	document.form1.sumTax.value = t2;							 //부가세합계 콤마


	var dummy_total =  Math.round((z + t) * 100)/100;
	var dummy_total = String(dummy_total);						 //소계합 + 부가세를 문자화

	while(dummy_total.match(/^(-?\d+)(\d{3})/))
		{
		dummy_total = dummy_total.replace(/^(-?\d+)(\d{3})/,'$1,$2');
		}

	document.form1.taxPlusTotal.value = dummy_total;			 //TOTAL 콤마
}



//#######################  수량 가감 버튼 클릭시 실행함수   ###############################//
function it_num_decrease(frm,i,type,extra1,extra2){					//배열번호, 가감타입, 여분1,여분2
	if (frm["it_num["+i+"]"].value <= 0 && type == "down"){
		alert('수량이 0 보다 작을 수는 없습니다');		
	}
	else{
	
		if(type == "up"){
			frm["it_num["+i+"]"].value++;			
			subtotal(frm,i);		
		}
		if(type == "down"){
			frm["it_num["+i+"]"].value--;			
			subtotal(frm,i);		
		}
	}
}

function Nit_num_decrease(type,extra1,extra2){				//배열번호, 가감타입, 여분1,여분2
	if (document.form1.Nit_num.value <= 0 && type == "down"){
		alert('수량이 0 보다 작을 수는 없습니다');		
	}
	else{
	
		if(type == "up"){
			document.form1.Nit_num.value++;			
			add_NsumPrice(document.form1);		
		}
		if(type == "down"){
			document.form1.Nit_num.value--;			
			add_NsumPrice(document.form1);		
		}
	}
}




//#####################################################################################//
//##################	주문내역 믹싱후 폼전송 스크립트  start	   ####################//
//#####################################################################################//

function mixing(frm){
	
	var it_name = "";											//품목이름 지역변수로 선언
	var opt_text = "";											//옵션이름 지역변수로 선언	
	var opt_price = "";											//옵션가격 지역변수로 선언
	var it_unit = "";											//품목단위 지역변수로 선언
	var it_num = "";											//주문수량 지역변수로 선언
	var it_price = "";											//품목가격 지역변수로 선언
	var it_sumPrice = "";										//소	계 지역변수로 선언
	var it_price_taxDB = "";									//세    율 지역변수로 선언
		
	
		for (var i=0; i < item_len;i++){						//item_len(items[] 배열수만큼 반복)		
												
				it_name+=frm["it_name["+i+"]"].value+";";		
				opt_text+=frm["opt_text["+i+"]"].value+";";
				opt_price+=frm["opt_price["+i+"]"].value+";";				
				it_unit+=frm["it_unit["+i+"]"].value+";";		
				it_num+=frm["it_num["+i+"]"].value+";";		
				it_price+=frm["it_price["+i+"]"].value+";";					
				it_sumPrice+=frm["it_sumPrice["+i+"]"].value+";";
				it_price_taxDB+=frm["it_price_taxDB["+i+"]"].value+";";
			}													//for문 end	 

	var it_name = it_name.slice(0,-1);							//문자열 끝의 배열에 필요없는 쉼표, 제거
	var opt_text = opt_text.slice(0,-1);											
	var opt_price = opt_price.slice(0,-1);	
	var it_unit = it_unit.slice(0,-1);
	var it_num = it_num.slice(0,-1);											
	var it_price = it_price.slice(0,-1);											
	var it_sumPrice = it_sumPrice.slice(0,-1);
	var it_price_taxDB = it_price_taxDB.slice(0,-1);

	frm.total_data.value = it_name+"|*|"+opt_text+"|*|"+opt_price+"|*|"+it_unit+"|*|"+it_num+"|*|"+it_price+"|*|"+it_sumPrice+"|*|"+it_price_taxDB;
																//한자,한글 합계입력을 위한...
	var moneyKr = money_kr(frm.total_sum3.value);				//한글화
	var moneyChina = money_china(frm.total_sum3.value);			//한자화
	frm.total_sum2.value = moneyKr+"|"+moneyChina;				//한글금액|한자금액	

	frm.submit();
}


//#####################################################################################//
//########################  초기 문서출력함수 start  ##################################//
//#####################################################################################//
function initial() {									  
    var buffer="";   
							
    resetItemSize();											//현재 레코드의 수를 재정의
    
    for (var i=0;i<item_len;i++) {								// items[] 배열수만큼      
        buffer+=htmlConvert_data(i);							// HTML 변환
    } 
   
    CurrentPosition=i;											//현재 배열 레코드 포인트의 값    
		//htmlConvert_data(i)에서 변환한 코드를 patchZone 에 쓰는 함수
    paste_patchZone(buffer);							  
	
}														  
//########################  초기 문서출력함수 end  ####################################//


function toDB(frm) {
	
    if (confirm('<?php echo af_txt_order_modify_11;?>')) {
        mixing(frm);							 // 저장하기 위해 폼 전송
    }
}


</script>
<!--##################################################################################-->
<!--###########################	자바스크립트 end	##################################-->
<!--##################################################################################-->
</head>

<BODY onload='initial()'>

<div style="margin:auto;font-family:돋움,Arial;">
<?php if($get_mode == "admine"){?>
<table style="width:100%" class="noborder">
	<tr>
		<td style="text-align:left;border:1px solid #ffffff;border-bottom:1px solid #999999;border-right:0;padding:10px;background-color:#cdcdcd">
			<strong><big> <?php echo af_txt_order_modify_12;?> </big></strong><br /><br />
			
			 &nbsp;&nbsp;<?php echo af_txt_order_modify_2;?>:&nbsp;<?php echo $af_order_no;?> <?php echo af_txt_order_modify_13;?>				
		</td>
		<td style="text-align:right;border:1px solid #ffffff;border-bottom:1px solid #999999;border-left:0;padding:10px;background-color:#cdcdcd">
				최초접수: <?php echo $input_date;?><br>
				최근수정: <?php echo $edit_date;?>
		</td>
	</tr>
</table>


<FORM name="form1" method="post" action="<?php $_SERVER['PHP_SELF'];?>" onsubmit="return false">
<input type="hidden" name="post_type" value="modify">
<input type="hidden" name="post_no" value="<?php echo $_GET['order_no'];?>">
<input type="hidden" name="edit_date" value="<?php echo time();?>">


<table style="width:100%;margin-top:30px;" id="order_modify">
    <tr>
        <td rowspan="6">
          <?php echo af_txt_order_modify_14;?>
        </td>
        <TD nowrap class="tdAlignLEFT" colspan="2" style="background-color:#cdcdcd">
		  <ul>
		  <li class="th">
			<input name="th1" value="<?php echo af_txt_order_modify_15;?>" readonly>
			<input name="th6" value="<?php echo af_txt_order_modify_16;?>" size='10' readonly>
			<input name="th5" value="<?php echo af_txt_order_modify_17;?>" size='5' readonly>
			<input name="th4" value="<?php echo af_txt_order_modify_18;?>" size='5' readonly>
			<input name="th2" value="<?php echo af_txt_order_modify_19;?>" readonly>
			<input name="th3" value="<?php echo af_txt_order_modify_20;?>"  size='10' readonly>		
			<input name="th7" value="<?php echo af_txt_order_modify_21;?>" size="20" readonly>
			<input name="th5" value="<?php echo af_txt_order_modify_22;?>" size='5' readonly>
		  </li>
		  
          <li>
			<input type="text" name="Nit_name" onblur="quot_Del(this)" value="">
			<input type="text" name="Nit_price" onblur="NumberDot(this);" onkeyup="NumberDot(this);add_NsumPrice(this.form);" value="0" size='10' style='text-align:right;'>	
			<input type="text" name="Nit_num" onblur="Numbering(this)" onkeyup='Numbering(this);add_NsumPrice(this.form);' value="1" size='5' style="text-align:right"> 
			<!--<img src='../imgs/btn_up.gif' onclick="Nit_num_decrease('up','','');" onmouseover="this.src='../imgs/btn_up_over.gif';" onmouseout="this.src='../imgs/btn_up.gif';"><br>
			<img src='../imgs/btn_down.gif' onclick="Nit_num_decrease('down','','');" onmouseover="this.src='../imgs/btn_down_over.gif';" onmouseout="this.src='../imgs/btn_down.gif';">-->			
			<input type="text" name="Nit_unit" value="<?php echo af_txt_order_modify_9;?>" size='5'>
			<input type="text" name="Nopt_text" onblur="quot_Del(this)" value="">
			<input type="text" name="Nopt_price" onblur="NumberDot(this);" onkeyup="NumberDot(this);add_NsumPrice(this.form);" value="0" size='10' style='text-align:right;'>							
			<input type="text" name="Nit_sumPrice" value="0" style="text-align:right;color:blue;" size="20" readonly>
			<input type="text" name="Nit_price_taxDB" onblur="NumberDot(this);" onkeyup="NumberDot(this);" value="0" style="text-align:right;" size="5">%			
			<!-- 추가시 합계 다시 구하기 위해 subtotal_sum() 추가 -->
			&nbsp;<input type="button" id="addBtn" value='<?php echo af_txt_add;?>' onclick='add_item(this.form);subtotal_sum();' class='btn_blue'>
		  </li>  
		  </ul>		 
        </td>
    </tr>
	<tr>
		<TD nowrap class="tdAlignLEFT" colspan="2" style="background-color:#cdcdcd" id="patchZone">
		

		</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:right;border-top:2px solid #999999;padding-right:5px;background-color:#cdcdcd">
			<?php echo af_txt_order_modify_23;?>
			<?php echo $html['coin_unit'];?> <input type="text" name="total_sum" value="<?php if(substr_count($clean['total_sum'],".") > 0){echo number_format($clean['total_sum'],2);} else {echo number_format($clean['total_sum']);}?>" readonly style="text-align:right;color:blue;" size="13">
			<!-- 한자, 한글 금액 입력을 위한 히든 필드(total_sum3를 소스로 하여 total_sum2에 문자화 입력) -->
			<input type="hidden" name="total_sum2" value="0" readonly>
			<input type="hidden" name="total_sum3" value="<?php echo $clean['total_sum'];?>" readonly>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:right;border-top:1px solid #999999;padding-right:5px;background-color:#cdcdcd">
			<?php echo af_txt_order_modify_24;?>
			<?php echo $html['coin_unit'];?> <input type="text" name="sumTax" value="<?php echo $taxTotal_txt;?>" readonly style="text-align:right;" size="13">
		</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:right;border-top:1px solid #999999;padding-right:5px;background-color:#cdcdcd">
			<?php echo af_txt_order_modify_25;?>
			<?php echo $html['coin_unit'];?> <input type="text" name="taxPlusTotal" value="<?php echo $total_thispage;?>" readonly style="text-align:right;color:red;" size="13"><br>		
			<input type="hidden" name="total_data" value="" readonly>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:right;border-top:1px solid #999999;padding-right:5px;background-color:#cdcdcd">
			<!--//////////////////////////////////////////////////////////////////////////////////-->
			<!--			결제비용 및 결제취소   start										  -->
			<!--//////////////////////////////////////////////////////////////////////////////////-->
			<!--  -->	
			<table id="sum" style="border-collapse:collapse;border:2px solid #777777;width:100%;font-size:13px;">
				<tr>
					<td class="section" style="border:1px solid #777777;width:130px;text-align:center;background-color:#e3e3e3;">
						결제방법
					</td>
					<!--	결제방법	-->
					<td class="memo" colspan="3" style="border:1px solid #777777;text-align:left;padding:3px;">		
						 <?php if($clean['tno']) echo "전자결제";?>
						 <?php if(!$clean['tno']) echo "무통장입금";?>	
					</td>
					<!--	결제유무	-->
				<tr>
					<td class="section" style="border:1px solid #777777;width:130px;text-align:center;background-color:#e3e3e3;">
						결제유무
					</td>
					<td class="memo" style="border:1px solid #777777;text-align:left;padding:3px;">			
						 <?php if($clean['pay_cancel'] == "on") {?>
							 <span style='color:blue'>결제완료</span>
							 <?php if($clean['tno']) {?>
								 &nbsp;거래번호 : <?php echo "<strong>".$clean['tno']."</strong>";?> 
								<!--<input type="button" value="결제취소하기" onclick="document.location.href='../plugin/kcp/mod_admin.html?tno=<?php echo $clean[tno];?>;site_cd=<?php echo $html[site_cd];?>;;site_key=<?php echo $html[site_key];?>'">-->
								&nbsp;<br>(거래번호는 결제대행사에 접속하여 주문취소/검색등에 사용하면 됩니다.)
							 <?php }?>
							 <?php if(!$clean['tno']) {?>
								<!--<input type='checkbox' name='pay_ok' value='no'>결제취소-->
							 <?php }?>
						 <?php }?>
						 <?php if(!$clean['pay_cancel']) echo "<span style='color:#cc6600'>미결제</span> ..........<input type='checkbox' name='pay_ok' value='ok'>입금확인";?>
						 <?php if($clean['pay_cancel'] == "off") echo "<span style='color:red'>결제취소</span>";?>
					</td>
					<td class="section" style="border:1px solid #777777;width:130px;text-align:center;background-color:#e3e3e3;">
						결제금액
					</td>
					<td style="text-align:right;">
						<?php echo $total_thispage;?>		
					</td>
				</tr>
			</table>
		</td>
	</tr>
    <tr>
        <td rowspan="7">
           <?php echo af_txt_order_modify_26;?>
        </td>
        <td class="td_client_orderM">
           <?php echo $html['client_text_name'];?>
        </td>
        <td class="tdAlignLEFT">
          <input type="text" name="client_name" value="<?php echo $clean['client_name'];?>" onblur="quot_Del(this)" class='ess'>
        </td>
    </tr>
	    <tr>
       <td class="td_client_orderM">
          <?php echo $html['client_text_email'];?>
        </td>
        <td class="tdAlignLEFT">
             <input type="text" name="client_email" value="<?php echo $clean['client_email'];?>" class='ess'>
        </td>
    </tr>
	<tr>
        <td class="td_client_orderM">
           <?php echo $html['client_text_hp'];?>
        </td>
        <td class="tdAlignLEFT">
            <input type="text" name="client_hp" value="<?php echo $clean['client_hp'];?>" class='ess' onblur="quot_Del(this)">
        </td>
    </tr>
    <tr>
        <td class="td_client_orderM">
           <?php echo $html['client_text_tel'];?>
        </td>
        <td class="tdAlignLEFT">
            <input type="text" name="client_tel" value="<?php echo $clean['client_tel'];?>" onblur="quot_Del(this)">
        </td>
    </tr>
	<tr>
        <td class="td_client_orderM">
           <?php echo $html['client_text_fax'];?>
        </td>
        <td class="tdAlignLEFT">
            <input type="text" name="client_fax" value="<?php echo $clean['client_fax'];?>" onblur="quot_Del(this)"> 			
        </td>
    </tr>
    <tr>
        <td class="td_client_orderM">
            <?php echo $html['client_text_address'];?>
        </td>
        <td class="tdAlignLEFT">
          <input type="text" name="client_address" value="<?php echo $clean['client_address'];?>" style="width:90%;" onblur="quot_Del(this)"> 	
        </td>
    </tr>
	<tr>
        <td class="td_client_orderM">
            <?php echo $html['client_text_memo'];?>
		</td>
        <td class="tdAlignLEFT">
          <textarea name="client_memo" style="width:100%;font-size:12px;" rows="5" onblur="quot_Del(this)"><?php echo $clean['client_memo'];?></textarea>	
        </td>
    </tr>
	<tr>
        <td colspan="2" style="border-bottom:2px solid #999999;border-top:2px dotted #999999;">
            admine memo
		</td>
        <td class="tdAlignLEFT" style="border-bottom:2px solid #999999;border-top:2px dotted #999999;">
          <textarea name="supply_memo" style="width:100%;font-size:12px;" rows="5" onblur="quot_Del(this)"><?php echo $clean['supply_memo'];?></textarea>	
        </td>
    </tr>





</table>
<div style="margin:20px;"><input type="button" value="<?php echo af_txt_modify;?>" onclick="toDB(this.form);" class="btn_big"></div>
</form>

<? } ?>


</div>
</body>
</html>


