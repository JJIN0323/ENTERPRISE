<?php
include_once("../lib/C_CONNECT.php");
include_once("../lib/define_table.php");
include_once("../lib/authentication.php");
include_once("../function/f_get_afTABLE5.php");
/* ----------------------------------------------------------------------------------- */
/*	프로그램명 : 애드폼(영문 addform												   */									
/*	프로그램용도: 견적서 주문서 폼메일 제작											   */
/*	제작자: 박성규																	   */
/*	공식배포처: http://www.addform.net												   */
/*  프로그램 편집시 위 제작자 정보를 편집하거나 삭제해서는 안됩니다.				   */
/* ----------------------------------------------------------------------------------- */

$fname = "";
$form_type = "";
$no = "";

if (strlen($_GET['fname']) <= 10 || strlen($_POST['fname']) <= 10 ) //폼이름을 10자 이상 안받았으므로 클린검사
{
	$fname = $_GET['fname'].$_POST['fname'];
	$form_type = $_GET['form_type'].$_POST['form_type'];
	$no = $_GET['no'].$_POST['no'];	

	if($form_type == "0") $form_type_txt = af_txt_formType0;
	if($form_type == "1") $form_type_txt = af_txt_formType1;

	$af_TABLE5 = f_get_afTABLE5("name",$fname);

	//상수정의:이 문서에서 주 작업대상이 되는 Mysql 테이블 정의
	define("TABLE","".db_tblname."_".$fname."_item");	
}

if($form_type == "1")
{
	$re=$DBconn->f_selectDB("*",TABLE4,"where mom='".$fname."'");		//090105추가-현재폼의 접수내역을 가져옴
	if($re[cnt] > 0)
	{
		$order_exist_alert ="<div style='margin-top:10px;text-align:left;font-weight:bold;color:#ff6600;'>현재 수정하려는 폼메일에 접수받은 접수내역이 하나 이상 있습니다.<br>이 경우, 항목의 추가 수정 삭제를 할 경우, 현재 수정하는 폼의 <span style='color:blue;'>기존 접수내역</span>을 관리자모드에서 열었을때, 변화가 있을 수 있습니다.<br><span style='color:black'>수정이 필요하다면, 폼을 복사 후, 새로운 폼으로 접수를 받거나,<br> 접수받은 내역이 테스트용도였다면, 접수목록에서 해당폼의 접수내역을 삭제 후, 수정하는 방법을 권고합니다.<br>상관없다면 항목을 추가 수정 삭제하셔도 됩니다.</span></div>";
	}
	else $order_exist_alert = "";
}
$reTABLE=$DBconn->f_selectDB("*",TABLE,"order by code");				//품목의 갯수를 알기위함
?>

<?
#########################################################################################
###################################   save mode   #######################################
#########################################################################################

if ($_GET['mode']=="save") 
{   
    echo af_txt_add_items_1;										  //저장중 메시지 출력
    flush();	

	#############################		1.품목테이블에 업데이트		#####################
	$clean="";														  //$clean 초기화
	$clean=array();													  //$clean 배열선언
	
		$clean['code'] = $_POST['code'];							  //순서 코드 번호
		$clean['name_it'] = $_POST['name_it'];						  //품목이름	
		$clean['price'] = $_POST['price'];							  //가격
		$clean['opt'] = $_POST['opt'];						          //옵션		
		$clean['unit'] = $_POST['unit'];			                  //단위	
		$clean['chk_input'] = $_POST['chk_input'];					  //필수입력(폼메일에서)
		$clean['chk_filter'] = $_POST['chk_filter'];				  //영어와숫자만(폼메일에서)
		$clean['chk_etc'] = $_POST['chk_etc'];						  //숫자만(폼메일에서)
		$clean['default_text'] = $_POST['default_text'];			  //폼메일 필드 초기값
		$clean['default_opt'] = $_POST['default_opt'];				  //폼메일 필드 초기값 (여분)
		$clean['discount'] = $_POST['discount'];					  //폼메일 필드 초기값 (여분)
		
		$clean['dummy1'] = $_POST['dummy1'];						  //입력필드너비(품목)
		$clean['dummy2'] = $_POST['dummy2'];						  //입력형식(품목)
		$clean['dummy3'] = $_POST['dummy3'];						  //사용자입력형 여부(yes,null(""))
		$clean['dummy4'] = $_POST['dummy4'];						  //가로짝짓기여부(yes,null(""))
		$clean['dummy5'] = $_POST['dummy5'];						  //고객정보모듈위치(1,null(""))
		$clean['dummy6'] = $_POST['dummy6'];						  //부가세율
		$clean['dummy7'] = $_POST['dummy7'];						  //간단설명
		$clean['dummy8'] = $_POST['dummy8'];						  //항목 썸네일이미지경로
		$clean['dummy9'] = $_POST['dummy9'];						  //항목 단 끊기 내용		
    
   if (!$clean['code'])												  //모두 삭제하고 저장할 경우...
   {											  
	   $DBconn->f_deleteTable(TABLE);							      //DB 테이블에서 데이타를 모두 지움
	   die("<meta http-equiv=refresh content='0;url=".$_SERVER['PHP_SELF']."?fname=$fname&amp;form_type=$form_type&amp;no=".$_POST['no']."'>");//문서 새로고침
   }
	
	
	$DBconn->f_deleteTable(TABLE);							           //DB 테이블에서 데이타를 지우고 새로 등록하기 위해...
    
    
    for ($i=0;$i<count($clean['code']);$i++)						   //폼으로 전달된 배열을 $code[] 배열수로 루프
	{						   
		//C_CONNECT 클래스 멤버함수인 f_InsertDBMulti($table,$fields,$array)에서,  $array 인자로 사용될 스칼라배열을 만듬
		//DB 입력할 필드수만큼 쉼표로 구분나열하여 배열
		
        $array[]=array($clean['code'][$i],$clean['name_it'][$i],$clean['price'][$i],$clean['opt'][$i],$clean['unit'][$i],$clean['chk_input'][$i],$clean['chk_filter'][$i],$clean['chk_etc'][$i],$clean['default_text'][$i],$clean['default_opt'][$i],$clean['discount'][$i],$clean['dummy1'][$i],$clean['dummy2'][$i],$clean['dummy3'][$i],$clean['dummy4'][$i],$clean['dummy5'][$i],$clean['dummy6'][$i],$clean['dummy7'][$i],$clean['dummy8'][$i],$clean['dummy9'][$i]);					
    }    
																	   //DB 입력f_InsertDBMulti(테이블이름,"필드1,필드2,필드3...",&$array)
																	   //$array배열을 참조연산자로 넘겨주어 보다 빠르게 처리
    $DBconn->f_InsertDBMulti(TABLE,"code,name_it,price,opt,unit,chk_input,chk_filter,chk_etc,default_text,default_opt,discount,dummy1,dummy2,dummy3,dummy4,dummy5,dummy6,dummy7,dummy8,dummy9",&$array);
	
	#############################		2.메인테이블에 업데이트		#####################
	if($_POST['client_items'])										   //if 처리 안하면, 처음 품목수정시 공백이 되므로...
	{
	$clean="";														   //$clean 초기화
	$clean=array();													   //$clean 배열선언	
		$clean['client_items'] = $_POST['client_items'];			  
		$clean['client_text_name'] = $_POST['client_text_name'];
		$clean['client_text_email'] = $_POST['client_text_email'];
		$clean['client_text_hp'] = $_POST['client_text_hp'];
		$clean['client_text_tel'] = $_POST['client_text_tel'];
		$clean['client_text_fax'] = $_POST['client_text_fax'];
		$clean['client_text_address'] = $_POST['client_text_address'];
		$clean['client_text_memo'] = $_POST['client_text_memo'];
		$clean['dummy10'] = $_POST['dummy10'];						   //기본고객정보 타이틀
		
	$clean['edit_date'] = time();									   //폼 수정시각	
	$where = "where name='".$fname."'";								   //조건절
	
	$DBconn->f_updateDB(TABLE5,&$clean,$where);						   //&$clean배열을 참조연산자&로 넘겨주어 보다 빠르게 처리	
	}
    
    ###########################		3.DB 입력 후, 문서 새로고침		#####################
    die("<meta http-equiv=refresh content='0;url=".$_SERVER['PHP_SELF']."?fname=$fname&amp;form_type=$form_type&amp;no=".$_POST['no']."&amp;title_text=".$_POST['title_text']."'>");
}


#########################################################################################
#########################  고객기본입력정보 모듈 선택 출력함수  #########################
#########################################################################################
function get_clientChk()								
{
	global $fname;
	$af_TABLE5 = f_get_afTABLE5("name",$fname);
	$client_itemsArr = explode("|",$af_TABLE5["client_items"]);
	if($client_itemsArr[0]=='1') $checked0 = "checked"; else $checked0 = "";
	if($client_itemsArr[1]=='1') $checked1 = "checked"; else $checked1 = "";
	if($client_itemsArr[2]=='1') $checked2 = "checked"; else $checked2 = "";
	if($client_itemsArr[3]=='1') $checked3 = "checked"; else $checked3 = "";
	if($client_itemsArr[4]=='1') $checked4 = "checked"; else $checked4 = "";
	if($client_itemsArr[5]=='1') $checked5 = "checked"; else $checked5 = "";
	if($client_itemsArr[6]=='1') $checked6 = "checked"; else $checked6 = "";

	if($af_TABLE5["client_text_name"]) $client_text_name = $af_TABLE5["client_text_name"]; else $client_text_name = af_txt_form_add_47;
	if($af_TABLE5["client_text_email"]) $client_text_email = $af_TABLE5["client_text_email"]; else $client_text_email = af_txt_form_add_48;
	if($af_TABLE5["client_text_hp"]) $client_text_hp = $af_TABLE5["client_text_hp"]; else $client_text_hp = af_txt_form_add_49;
	if($af_TABLE5["client_text_tel"]) $client_text_tel = $af_TABLE5["client_text_tel"]; else $client_text_tel = af_txt_form_add_50;
	if($af_TABLE5["client_text_fax"]) $client_text_fax = $af_TABLE5["client_text_fax"]; else $client_text_fax = af_txt_form_add_51;
	if($af_TABLE5["client_text_address"]) $client_text_address = $af_TABLE5["client_text_address"]; else $client_text_address = af_txt_form_add_52;
	if($af_TABLE5["client_text_memo"]) $client_text_memo = $af_TABLE5["client_text_memo"]; else $client_text_memo = af_txt_form_add_53;	

	$bgcolor = "style='background-color:#cfcfcf;'";
	
			echo "<td class='item_optL' nowrap>";
				echo "상단내용";
			echo "</td>";
			echo "<td class='item_optR'>";
				echo "<textarea rows='5' cols='80' name='dummy10' class='tag' onblur=\"quot_Del2(this)\">".$af_TABLE5["dummy10"]."</textarea>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class='item_optL' nowrap>";
				echo "항목선택";
			echo "</td>";
			echo "<td class='item_optR'>";
				echo "<table>";
					echo "<tr>";
						echo "<td $bgcolor>";
							echo "<input type='checkbox' name='client_item' value='1' ".$checked0.">이름";
						echo "</td>";
						echo "<td $bgcolor>";
							echo "<input type='checkbox' name='client_item' value='1' ".$checked1.">이메일";
						echo "</td>";
						echo "<td $bgcolor>";
							echo "<input type='checkbox' name='client_item' value='1' ".$checked2.">휴대폰";
						echo "</td>";
						echo "<td $bgcolor>";
							echo "<input type='checkbox' name='client_item' value='1' ".$checked3.">전화번호";
						echo "</td>";
						echo "<td $bgcolor>";
							echo "<input type='checkbox' name='client_item' value='1' ".$checked4.">팩스";
						echo "</td>";
						echo "<td $bgcolor>";
							echo "<input type='checkbox' name='client_item' value='1' ".$checked5.">주소";
						echo "</td>";
						echo "<td $bgcolor>";
							echo "<input type='checkbox' name='client_item' value='1' ".$checked6.">고객메모";
						echo "</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>";
							echo "<input type='text' name='client_text_name' value='".$client_text_name."' onblur='quot_Del(this)' size='7'>";
						echo "</td>";
						echo "<td>";
							echo "<input type='text' name='client_text_email' value='".$client_text_email."' onblur='quot_Del(this)' size='7'>";
						echo "</td>";
						echo "<td>";
							echo "<input type='text' name='client_text_hp' value='".$client_text_hp."' onblur='quot_Del(this)' size='7'>";
						echo "</td>";
						echo "<td>";
							echo "<input type='text' name='client_text_tel' value='".$client_text_tel."' onblur='quot_Del(this)' size='7'>";
						echo "</td>";
						echo "<td>";
							echo "<input type='text' name='client_text_fax' value='".$client_text_fax."' onblur='quot_Del(this)' size='7'>";
						echo "</td>";
						echo "<td>";
							echo "<input type='text' name='client_text_address' value='".$client_text_address."' onblur='quot_Del(this)' size='7'>";
						echo "</td>";
						echo "<td>";
							echo "<input type='text' name='client_text_memo'value='".$client_text_memo."' onblur='quot_Del(this)' size='7'>
								  <input type='hidden' name='client_items' value=''>";
						echo "</td>";
					echo "</tr>";					
				echo "</table>";
			echo "</td>";
		
}

function get_clientPos()								
{								
    global $DBconn;											//$DBconn 글로벌변수 참조	

    $re=$DBconn->f_selectDB("*",TABLE,"order by code");		//C_CONNECT 클래스 멤버함수인 f_selectDB($field="*",$table,$where="")를 실행하여
															//$re[result]에 저장하고 불러온 레코드 수를 $re[cnt]에 저장   
	if($re[cnt] >= 1)										//추가항목이 1 이상일 때만...
	{
	echo "<div style='text-align:left;' class='formmail_hide'>";
		echo "<fieldset>";
			echo "<legend>기본고객정보 위치선택 및 표시항목 설정</legend>";
				echo "<table style='margin-top:10px;'>";
					echo "<tr>";
						echo "<td class='item_optL' nowrap>";
							echo "출력위치";
						echo "</td>";
						echo "<td class='item_optR'>";
							echo "<select name='clientBox' size='1' onchange='this.form.client_positionBtn[this.options[this.selectedIndex].value-1].checked = true;client_position(this.form.client_positionBtn[this.options[this.selectedIndex].value-1],this.options[this.selectedIndex].value-1);'>";														
							for ($i=1;$i<$re[cnt]+1;$i++)							//불러온 레코드의 수만큼 루프     
							{
								$row=mysql_fetch_array($re[result]);				//배열의 요소들을 $row에 대입															
								$name_it = htmlspecialchars(stripslashes($row["name_it"]));//항목이름
								$dummy5 = htmlspecialchars(stripslashes($row["dummy5"]));  //고객정보모듈위치(1,null("")) 
								if($dummy5 == "1")
								{
									echo "<option value='$i' selected>$i</option>";
									$name_it_txt = $name_it;
								}
								else
								{
									echo "<option value='$i'>$i</option>";			
								}
							}
							echo "</select>";
							echo " 번째 순서에 있는, <strong style='color:#004a84;'>$name_it_txt</strong> 추가항목 위로 출력합니다.<br>";
						echo "</td>";
					echo "</tr>";
					echo "<tr>";
					echo get_clientChk();
					echo "</tr>";
				echo "</table>";
		echo "</fieldset>";
	echo "</div>";
	}
}



#########################################################################################
#########################  DB 테이블에서 데이타 가져오는 함수  ##########################
#########################################################################################

function get_dbTable_recode()								//이 함수는 자바스크립트문에서 출력할것임 
{								
    global $DBconn;											//$DBconn 글로벌변수 참조	

    $re=$DBconn->f_selectDB("*",TABLE,"order by code");		//C_CONNECT 클래스 멤버함수인 f_selectDB($field="*",$table,$where="")를 실행하여
															//$re[result]에 저장하고 불러온 레코드 수를 $re[cnt]에 저장    
	
    $buffer="var items=new Array();\n";						//본 문서 자바스크립트문 안에서 사용하기 위해 배열을 자바스크립트로 치환
    
    for ($i=0;$i<$re[cnt];$i++)								//불러온 레코드의 수만큼 루프     
	{							   
        $row=mysql_fetch_array($re[result]);				//배열의 요소들을 $row에 대입

			$no = htmlspecialchars(stripslashes($row["no"]));             
			$code = htmlspecialchars(stripslashes($row["code"]));         
			$name_it = htmlspecialchars(stripslashes($row["name_it"]));  
			$price = htmlspecialchars(stripslashes($row["price"]));
			$opt = htmlspecialchars(stripslashes($row["opt"]));                 
			$unit = htmlspecialchars(stripslashes($row["unit"]));	
			$chk_input = htmlspecialchars(stripslashes($row["chk_input"]));	
			$chk_filter = htmlspecialchars(stripslashes($row["chk_filter"]));
			$chk_etc = htmlspecialchars(stripslashes($row["chk_etc"]));
			$default_text = htmlspecialchars(stripslashes($row["default_text"]));
			$default_opt = htmlspecialchars(stripslashes($row["default_opt"]));
			$discount = htmlspecialchars(stripslashes($row["discount"]));
			
			$dummy1 = htmlspecialchars(stripslashes($row["dummy1"]));		//입력필드너비(품목)
			$dummy2 = htmlspecialchars(stripslashes($row["dummy2"]));		//입력형식(품목)
			$dummy3 = htmlspecialchars(stripslashes($row["dummy3"]));		//사용자입력형 여부(yes,null(""))
			$dummy4 = htmlspecialchars(stripslashes($row["dummy4"]));		//가로짝짓기여부(yes,null(""))
			$dummy5 = htmlspecialchars(stripslashes($row["dummy5"]));		//고객정보모듈위치(1,null(""))
			$dummy6 = htmlspecialchars(stripslashes($row["dummy6"]));		//부가세율

			$dummy7 = htmlspecialchars(stripslashes($row["dummy7"]));		//간단설명
			$dummy8 = htmlspecialchars(stripslashes($row["dummy8"]));		//항목 썸네일이미지경로
			$dummy9 = htmlspecialchars(stripslashes($row["dummy9"]));		//항목 단 끊기 내용
			$arr_item_exp = explode("\n",$dummy7);
			$item_expNdel = "";
			if($dummy7)														//아래 trim 에서 " " 한칸 여백추가되므로, 있을때만 trim처리
			{
			for($in=0;$in<sizeof($arr_item_exp);$in++)
				{ 
				$item_expNdel .= trim($arr_item_exp[$in])." ";				//textarea 개행문자 제거(자바스크립트 에러방지)
				}
			}

			$arr_dummy9 = explode("\n",$dummy9);
			$item_dummy9Ndel = "";
			if($dummy9)														//아래 trim 에서 " " 한칸 여백추가되므로, 있을때만 trim처리
			{
			for($in=0;$in<sizeof($arr_dummy9);$in++)
				{ 
				$item_dummy9Ndel .= trim($arr_dummy9[$in])." ";				//textarea 개행문자 제거(자바스크립트 에러방지)
				}
			}
			
			if($re[cnt] == "1") $dummy5 = "1";								//항목이 1개일 때, 기본고객필드 맨 첨에 위치하게...
				
																																		
			
															//루프된 items 자바스크립트 변수배열형태 재정의
															//변수형에 따라 쿼터링 주의(작은따옴표 에러방지 위해 문자형은 \"으로 처리
															//연관배열일 경우 $code와같이... 스칼라는 $code[$i]와 같이...
															//$price 문자형으로 처리해야 소숫점 뒷자리 0 입력됨	
        $buffer.="items[$i]=[$no,$code,\"$name_it\",\"$price\",\"$opt\",\"$unit\",$chk_input,$chk_filter,$chk_etc,\"$dummy1\",\"$dummy2\",\"$dummy3\",\"$dummy4\",\"$dummy5\",\"$dummy6\",\"$item_expNdel\",\"$default_text\",\"$default_opt\",\"$dummy8\",\"$item_dummy9Ndel\"];\n"; 
    }
    return $buffer;
}
?>

<?php
#########################################################################################
####################     selectBox Part1: 단위 선택상자 start      ######################
#########################################################################################

//<option>태그 생성
function f_opt($val,$text,$default="",$head="") {
	        $buf="<option value='$val'";
	        if ($default&&$default==$text) {
	            $buf.="selected";
	        }
	        $buf.=">".$head;
	        return $buf;
	    }
//select 선택상자 구성
function f_SelectBox($arr) {
	if ($arr[name]) $arr[name]="name=$arr[name]";
    if ($arr[id]) $arr[id]="id=$arr[id]";
    if ($arr[style]) $arr[style]="style='$arr[style]'";	
    if ($arr[disable]) $arr[disable]="disable";
    
    $buf="";
    if ($arr["end"]>$arr[start]) {							 //숫자 범위 지정시
        for ($i=$arr[start];$i <= $arr["end"];$i++) {
            $buf.=opt($i,$arr["default"],$arr[head]).$i.$arr[tail];
        }
    } elseif (count($arr[text]) > 1) {						 //text 배열의요소가 2개이상일 경우
        for ($i=0;$i < count($arr[text]);$i++) {
            $buf.=f_opt($arr[optVal][$i],&$arr[text][$i],$arr["default"],$arr[head]).$arr[text][$i].$arr[tail];
        }
    }
    
    $buf.="";
    return $buf;
}
?>

<?php
####    selectBox Part2: DB에서 단위필드의 정보 가져와서 연관배열 만들기 start     ######

function f_mkOptArr($field,$obj){							 //인수$field=db의 필드명, $obj는 도큐멘트 입력필드명
global $DBconn;
$res=$DBconn->f_selectDB("*","".db_tblname."_env",$where);	 //필드, 테이블, 조건절

$res_count=mysql_num_rows($res[result]);                     //리턴된 행의 개수
	
        $row=mysql_fetch_array($res[result]);                //배열의 요소들을 $row에 대입	
		$od_unit=htmlspecialchars(stripslashes($row[od_unit]));  
		$coin_unit=htmlspecialchars(stripslashes($row[coin_unit]));
		
		$od_unit = explode(",",$od_unit);						 //od_unit 필드의 콤마로 구분한 단위값들을 스칼라배열화
		$coin_unit = explode(",",$coin_unit);					 //coin_unit 필드의 콤마로 구분한 단위값들을 스칼라배열화

		if($field == "od_unit") $Val = $od_unit; 
		if($field == "coin_unit") $Val = $coin_unit;

		/* 테이블 행이 복수일 경우엔 아래와 같이 for문으로 연관배열처리(그룹실렉트의 경우예)
		$no=array();                                                 //배열변수 정의(그룹고유번호)
		$na=array();                                                 //배열변수 정의(그룹이름)
		for ($i=0;$i < $res_count;$i++) {							 //불러온 레코드의 수만큼 루프        
			$row=mysql_fetch_array($res[result]);                    //배열의 요소들을 $row에 대입	
			$na[$i]=htmlspecialchars(stripslashes($row[name]));                    //연관배열 만듬  
			$no[$i]=htmlspecialchars(stripslashes($row[no]));                      //연관배열 만듬    
		}	
		*/


 	
	//$arr=array("name"=>"comboGroup","id"=>"selectGroup","text"=>&$a);//연관배열 정의 방법1
	$arr=array();                                           //연관배열 정의 방법2
		$arr[head]="";
		$arr[tail]="";
		$arr[start]="";
		$arr['end']="";
		$arr['default']="";                                  //디폴트로 선택될 text
		$arr[name]="comboGroup";                             //선택상자 이름
		$arr[id]="";                                         //선택상자 객체 구분 아이디
		$arr[style]="";                                      //선택상자 스타일
		$arr[script]="";									 //실행할 스크립트			
		$arr[optVal]=$Val;								     //옵션 value 배열
		$arr[text]=$Val;                                     //실렉트 text 항목 배열
		

echo f_SelectBox ($arr);								     //f_SelectBox 함수 실행
}
?>
<!--##################################################################################-->
<!--############################	HTML START	######################################-->
<!--##################################################################################-->
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<meta name='robots' content='none,noindex,nofollow'>
<title></title>
<LINK REL="stylesheet" HREF="global.css" TYPE="text/css">
	
	<?php if($_GET['form_type'] == 1){?>
		<!-- 폼형식이 폼메일일 때 -->
		<style type="text/css">
			.estimate_hide{display:none;}			
		</style>

	<?php } ?>

	<?php if($_GET['form_type'] == 0){?>
		<!-- 폼형식이 주문/견적일 때 -->
		<style type="text/css">
			.formmail_hide{display:none;}
			.linkimg{display:none;}
			.linkbox{display:none;}
		</style>

	<?php } ?>

<!--##################################################################################-->
<!--###############################  자바스크립트 start	 #############################-->
<!--##################################################################################-->
<script type="text/javascript" src='js/check_input.js'></script>
<script type="text/javascript" src='js/array_del.js'></script>
<script type="text/javascript" src='js/trBgOver.js'></script>
<script type="text/javascript" src='js/link_itemDisplay.js'></script>
<script type="text/javascript" src='js/client_position.js'></script>
<script type="text/javascript" src='js/items_unlink.js'></script>
<script type="text/javascript" src="../plugin/js/jquery-latest.js"></script>  
<script type="text/javascript" src="../plugin/js/ui.base.js"></script>
<script type="text/javascript" src="../plugin/js/ui.sortable.js"></script>
<script type="text/javascript" src="../plugin/js/obj.dragble.js"></script>
<script type="text/javascript" src="js/code_re.js"></script>
<script type="text/javascript" src="js/displayOpt_all.js"></script>
<script type="text/javascript" src="js/displayOpt.js"></script>

<script type="text/javascript">
function Mix(f)
{
var mix_client_item = "";
if(f.client_item)										   //해당객체가 있을때만해야 오류 안남...
{
	for(i= 0 ; i < f.client_item.length; i++)
	{
		if(f.client_item[i].checked==true)
		{
			 mix_client_item = mix_client_item+"1|";
		}
		else  mix_client_item = mix_client_item+"0|";
	}
	 mix_client_itemLen = mix_client_item.length;
	 mix_client_item = mix_client_item.substr(0,mix_client_itemLen-1);
	f.client_items.value = mix_client_item;				   //고객정보 입력항목 합치기
}
}

<?php echo get_dbTable_recode();?>                         //##### 1. DB 테이블에서 데이타 가져와서 배열화 하는 php 함수(윗부분 php구문안에 정의되어 있음)

var item_len;											   //전체 레코드의 행수

var CurrentPosition;									   //현재 배열 레코드 포인트의 값

function resetItemSize() 
{															//현재 레코드의 수를 재정의
    item_len=items.length;	
}



function add_item(f) 
{															//#####	2. 새품목 추가함수 start	#####//
	
	f['nCode'].value=item_len+1;						   //코드번호를 자동으로 1씩 증가하게
	
	var n = f.dummy.length;								   //dummy 필드배열의 크기(오류방지 위해 이페이지에서 항시 1 있음)
	
    if (!f['nName'].value) 
	{
        alert('<?php echo af_txt_add_items_4;?>');		
        return f['nName'].focus();
    }	

	 if (!f['nPrice'].value) 
	{
        alert('<?php echo af_txt_add_items_5;?>');		
        return f['nPrice'].focus();
    }

	var dummy5 = "";																		   
	if(item_len == 0) dummy5 = "1";						   //ver 6에서 추가(추가시 항목이 하나도 없을 때, 기본고객필드 상단에 위치하게)
    
														   //현재 품목의 요소들을 배열에 추가
														   //htmlConvert_data(i)의 배열을 맞추기 위해  "" 공백 요소 추가(이페이지에서만...) 
   
	items[CurrentPosition]=["",f['nCode'].value,f['nName'].value,f['nPrice'].value,f['nOpt'].value,f['nUnit'].value,"","","",f['nDummy1'].value,"","","",dummy5,f['nTax'].value,f['nExp'].value,f['nDefault_text'].value,"","",""]; 
    
    
    resetItemSize();									   //현재 배열 레코드의 수를 재정의
    
    
    paste_patchZone(htmlConvert_data(CurrentPosition++));  //배열을 html로 컨버팅하여, patchZone에 덧붙이고
														   //현재 배열 레코드 포인트의 값을 1증가    
    
    with (f) 
	{
        nName.value="";									   //품목 추가 입력 필드들 초기화
		nDefault_text.value="";
		nPrice.value="0";
		nExp.value="";
        nName.focus();
			
		if(n) alert(n+'<?php echo af_txt_add_items_6;?>'); //한행도 없을때 undefined 되므로 n이 있을때만
    }
	code_re();
    return true;

}
														   //##	새품목 추가함수 end	###//


//#####################################################################################//
//#####################################################################################//
//#####################################################################################//
//배열요소들을 HTML로 변환하는 함수
//위 61번라인의 DB 입력 배열과 맟춤에만 주의(인터페이스를위해 순서는 상관없음)
//#####################################################################################//
//#####################################################################################//
//#####################################################################################//						
function htmlConvert_data(i) 
{
	var chk_input = "";
	var chk_filter = "";
	var chk_etc = "";
	if(items[i][6] == "1") chk_input = "checked";		   //DB의 chk_input 값이 1일 경우 체크되게
														   //DB의 chk_filter 값에 따라 체크
	//if(items[i][7] == "1") document.form1["chk_filter["i"]"].checked = true;		  
	//if(items[i][7] == "2") document.form1["chk_filter["i"]"].checked = true;	
	
	//*** 080325 입력형식 선택 펼침목록 select 출력을위한 추가 ***//
	var val_select = "value ='0'";							//펼침목록
	var val_checkbox = "value ='1'";						//체크박스
	var val_radio = "value ='2'";							//라디오버튼
	var val_text = "value ='3'";							//한줄글상자
	var val_textArea = "value ='4'";						//스크롤글상자
	var val_SelectDate1 = "value ='5'";						//날짜입력1
	var val_SelectDate2 = "value ='6'";						//날짜입력2
	var val_text2 = "value ='7'";							//한줄글상자2
	var val_text3 = "value ='8'";							//한줄글상자3
	var val_text4 = "value ='9'";							//한줄글상자4
	var val_text5 = "value ='10'";							//한줄글상자5
	var val_tel = "value ='11'";							//전화번호 입력란
	var val_hp = "value ='12'";								//휴대폰 입력란
	var val_zipcode = "value ='13'";						//우편번호주소검색(090402)

	if(items[i][10] == "0")	val_select = "value ='0' selected";	
	if(items[i][10] == "1")	val_checkbox = "value ='1' selected";
	if(items[i][10] == "2")	val_radio = "value ='2' selected";
	if(items[i][10] == "3")	val_text = "value ='3' selected";
	if(items[i][10] == "4")	val_textArea = "value ='4' selected";
	if(items[i][10] == "5")	val_SelectDate1 = "value ='5' selected";
	if(items[i][10] == "6")	val_SelectDate2 = "value ='6' selected";
	if(items[i][10] == "7")	val_text2 = "value ='7' selected";
	if(items[i][10] == "8")	val_text3 = "value ='8' selected";
	if(items[i][10] == "9")	val_text4 = "value ='9' selected";
	if(items[i][10] == "10")val_text5 = "value ='10' selected";
	if(items[i][10] == "11")val_tel = "value ='11' selected";
	if(items[i][10] == "12")val_hp = "value ='12' selected";
	if(items[i][10] == "13")val_zipcode = "value ='13' selected";


	if(items[i][11] == "yes") chk_userType = "checked";	   //DB의 dummy3이 yes일 경우 사용자입력형 체크
	else chk_userType = "";

	//*** 080409 항목간 가로 짝짓기 위한 추가  ***//
	var dummy4VisiBility;								   //윗항목과 가로짝짓기위한 체크박스 표시여부
	var targetNUM = i-1;								   //제어대상 링크이미지번호
	var img_name = "link_item"+targetNUM+"";			   //제어대상 이미지네임
	if(i%2) dummy4VisiBility = "";						   //홀수행일 때 보이게(배열기준)	
	else dummy4VisiBility = "style='VisiBility:hidden'";   //짝수행일 때 안보이게(배열기준)
	if(items[i][12] == "yes")							   //DB의 dummy4가 yes일 경우 체크
	{
		chk_dummy4 = "checked";	
		link_itemVisiBility = "style='VisiBility:visible'";
	}
	else
	{
		chk_dummy4 = "";	
		link_itemVisiBility = "style='VisiBility:hidden'";
	}

	//*** 0804011 고객정보입력모듈 위치지정 위한 추가  ***//
	if(items[i][13] == "1") chk_dummy5 = "checked";  //DB의 dummy5가 1일 경우 라디오버튼 체크
	else chk_dummy5 = "";
	//*** 0804014 부가세율 설정 위한 추가  ***//
	if(items[i][14]) val_dummy6 = items[i][14];		 //DB의 dummy6이 있을 경우
	else val_dummy6 = "0";
	//*** 0804014 항목 간단설명 위한 추가  ***//
	if(items[i][15]) val_dummy7 = items[i][15];		 //DB의 dummy7이 있을 경우
	else val_dummy7 = "";
	//*** 081126 썸네일 위한 추가  ***//
	if(items[i][18]) val_dummy8 = items[i][18];		 //DB의 dummy8이 있을 경우
	else val_dummy8 = "http://www.addform.net/images/tip/itemThumb.gif";
	//*** 090112 ver 5.4 추가 - 항목 단나누기 내용  ***//
	if(items[i][19]) 
		{
		val_dummy9 = items[i][19];		 //DB의 dummy9가 있을 경우		
		}
	else
		{		
		val_dummy9 = "";		
		}
	var form_type = "<?php echo $form_type;?>";
	if(form_type == "0") dummy9Colspan = "4";
	if(form_type == "1") dummy9Colspan = "4";
	
        var buffer=""
			+"<li style='padding:0;margin:5px 0 0 0;border:1px solid #c0c0c0;' onmouseup='code_re();items_unlink("+i+")'>"				
				+"<table class='item_list'>"
					+"<TBODY>"						
						+"<tr>"
							//순서
							+"<td style='width:40px;' nowrap>"
								+"<input type='radio' name='client_positionBtn' value=''  style='display:none;' onclick='client_position(this,"+i+");alert(\"<?php echo af_txt_add_items_7;?>\");' "+chk_dummy5+">"
								+"<input type='hidden' name=dummy5["+i+"] value='"+items[i][13]+"'>"
								+"<input name=code["+i+"] id=code["+i+"] size='2'"
								+"value=\""+items[i][1]+"\" onblur=\"Numbering(this)\" class='code_re' onclick='alert(\"품목을저장한 후, 해당행의 빈공간위에서 마우스 끌어놓기로 순서를 자동 정렬할 수 있습니다.\\n\\n임시추가상태에서는 마우스끌어놓기가 동작하지 않습니다.\")'>"	
																		   
							+"<input type='hidden' name='dummy' size='3' value=\""//순서 일련번호 중복방지를 위해 히든속성의	   
							+items[i][1]+"\" onblur=\"Numbering(this)\">"		  //dummy 필드 추가하여 위 add_item함수에서 체킹(폼태그 아래에도 상시 1 존재하게...)
							+"<\/td>"
							//품목(썸네일,항목이름,설명)
							+"<td nowrap style='text-align:left;'>"								
								//항목이름							
								+"<img src='img/hand1.gif' onmousedown='this.src=\"img/hand2.gif\"' onmouseout='this.src=\"img/hand1.gif\"' align='middle'> "
								+"<img src='../imgs/link_item.gif' name='link_item"+i+"' align='middle' class='linkimg' "+link_itemVisiBility+">"
								+"<input type='checkbox' name=dummy4["+i+"] value='yes'  class='linkbox' "+dummy4VisiBility+" "+chk_dummy4 +" onclick='link_itemDisplay(this.form,this,\"link_item"+targetNUM+"\","+targetNUM+");alert(\"<?php echo af_txt_add_items_8;?>\");'>"
								+"<input name=name_it["+i+"] onblur=\"quot_Del(this)\" "					
								+"value=\""+items[i][2]+"\" class='input_big'> "								
							+"<\/td> "
							//#####################################################################################//		
							//#################		수정버튼 클릭시 표시될 설정항목들 start   #####################//
							//#####################################################################################//
							+"<td style='display:none;' id='item_optTD"+i+"' class='item_optTD'>"
								+"<div>"
									+"<fieldset><legend>속성 및 옵션설정<\/legend>"	
										+"<table class='item_opt'>"
											+"<tr>"
												+"<td colspan='2' style='text-align:right;border:0;'>"
												+"<img src='img/del.gif' alt='닫기' onmousedown='document.getElementById(\"item_optTD"+i+"\").style.display=\"none\"' style='cursor:hand;'>"													
												+"<\/td>"
											+"<\/tr>"
											//단나누기
											+"<tr class='formmail_hide'>"
												+"<td class='item_optL' nowrap> "
													+"단나누기 내용"													
												+"<\/td>"
												+"<td class='item_optR'> "													
													+"내용을 입력시, 본 항목위에서 단나누기가 됩니다.<br><textarea name=dummy9["+i+"] rows='5' class='tag_s' id='dummy9_textarea"+i+"' style='color:#666;width:350px;' onblur=\"quot_Del2(this)\">"+val_dummy9+"<\/textarea>"
												+"<\/td>"
											+"<\/tr>"
											//썸네일
											+"<tr class='estimate_hide'>"
												+"<td class='item_optL' nowrap> "
													+"썸네일"													
												+"<\/td>"
												+"<td class='item_optR'> "
													+"<img src='"+val_dummy8+"' style='width:80px;height:50px;border:1px solid #000;' id='thumb"+i+"' style='vertical-align:middle;'><span style='color:gray;font-size:11px;margin:10px;'>이미지를 등록하지 않으면, 주문폼에 품목이름만 표시됩니다.<\/span> "
													+"<input type='text' name=dummy8["+i+"] id='dummy8"+i+"' value='"+val_dummy8+"' size='50' onblur=\"quot_Del(this)\"><br>"
													+"<input type='button' value='이미지수정' onmousedown='document.getElementById(\"thumb"+i+"\").src=document.getElementById(\"dummy8"+i+"\").value;'>"
												+"<\/td>"
											//초기값
											+"<tr class='formmail_hide'>"
												+"<td class='item_optL' nowrap> "
													+"초기값"													
												+"<\/td>"
												+"<td class='item_optR'><input type='text' name=default_text["+i+"] onblur=\"quot_Del(this)\" "
												+"value=\""+items[i][16]+"\"> 미리입력되어 있을 문구"
												+"<\/td> "
											+"<\/tr>"
											//품목가격
											+"<tr class='estimate_hide'>"
												+"<td class='item_optL' nowrap> "
													+"품목가격"													
												+"<\/td>"
												+"<td class='item_optR'><input name=price["+i+"] onblur=\"NumberDot(this)\"  "
													+"value=\""+items[i][3]+"\" style='text-align:right;float:left;margin-right:10px;' size='10'>"
													+"<div style='color:gray;font-size:11px;'>* 품목가격 = 0원일 때, [1행 합계 = 수량 * 선택된 옵션가격]><br>"
													+"* 품목가격 > 0 보다 클때, [1행 합계 = (수량 * 품목가격) + 선택된 옵션가격]<\/div>"
												+"<\/td> "
											+"<\/tr>"
											//부가세율
											+"<tr class='estimate_hide'>"
												+"<td class='item_optL' nowrap> "
													+"부가세율"													
												+"<\/td>"
												+"<td class='item_optR'><input name=dummy6["+i+"] onblur=\"NumberDot(this)\"  "
													+"value=\""+val_dummy6+"\" style='text-align:right;' size='2'>% "			
												+"<\/td> "											
											+"<\/tr>"
											//단위
											+"<tr class='estimate_hide'>"
												+"<td class='item_optL' nowrap> "
													+"단위"													
												+"<\/td>"
												+"<td class='item_optR'><input type='text' name=unit["+i+"] onblur=\"quot_Del(this)\" "
													+"value=\""+items[i][5]+"\" size='10' readonly> "
													+"선택하세요<select name='unit_select["+i+"]' onchange='this.form[\"unit["+i+"]\"].value=this.options[this.selectedIndex].value;'>"
													+" <?php echo f_mkOptArr('od_unit','');?>"
													+"<\/select>"
												+"<\/td> "
											+"<\/tr>"
											//고객입력형 여부
											+"<tr class='estimate_hide'>"
												+"<td class='item_optL' nowrap> "
													+"고객입력형여부"													
												+"<\/td>"
												+"<td class='item_optR'><input type='checkbox' name=dummy3["+i+"] "
													+"value='yes' "+chk_userType+" style='float:left;margin-right:10px;'> "													
													+"<div style='color:gray;font-size:11px;margin:5px;' class='estimate_hide'>* 체크하면, 아래 옵션에 설정한 것은 무효하고, 한줄글상자가 표시됩니다.<\/div>"
												+"<\/td> "
											+"<\/tr>"
											//#####################################################################################//		
											//####################  폼메일일 때 나타날 필터링옵션들 start  ########################//
											//#####################################################################################//
											//필수입력 체크상자
											+"<tr class='formmail_hide'>"
												+"<td class='item_optL' nowrap> "
													+"필수입력"													
												+"<\/td>"
												+"<td class='item_optR'>"
													+"<input type='checkbox' name=chk_input["+i+"] value='1' "+chk_input+" > 체크할 경우, 필수입력항목이 됩니다."
												+"<\/td>"
											+"<\/tr>"
											//#####################################################################################//										
												//DB의 chk_filter 값에 따라 필터링 체크
												//필터링이 겹칠 경우 간섭이 있을 수 있으므로, 라디오버튼으로 하였음
											//#####################################################################################//
											+"<tr class='formmail_hide'>"
												+"<td class='item_optL' nowrap> "
													+"입력필터링"													
												+"<\/td>"
												+"<td class='item_optR' style='font-weight:bold;'>";
												//한글입력금지 라디오버튼										
												if(items[i][7] == "1") {
												buffer+="한글입력금지<input type='radio' name=chk_filter["+i+"] value='1' "+chk_filter+" checked>&nbsp;&nbsp;&nbsp;";}
												else{
												buffer+="한글입력금지<input type='radio' name=chk_filter["+i+"] value='1' "+chk_filter+" >&nbsp;&nbsp;&nbsp;";}										
												//숫자만입력 라디오버튼
												if(items[i][7] == "2") {
												buffer+="숫자만입력<input type='radio' name=chk_filter["+i+"] value='2' "+chk_filter+" checked>&nbsp;&nbsp;&nbsp;";}
													else{
												buffer+="숫자만입력<input type='radio' name=chk_filter["+i+"] value='2' "+chk_filter+" >&nbsp;&nbsp;&nbsp;";}										
												//해제버튼
												buffer+="해제<input type='radio' name=chk_filter["+i+"] value='0' "+chk_filter+" >"
												+"<\/td>"
											+"<\/tr>"
											//#####################################################################################//
											//######################  폼메일일 때 나타날 필터링옵션들 end   #######################//
											//#####################################################################################//
											//폼메일 입력형식(품목)
											+"<tr class='formmail_hide'>"
												  +"<td class='item_optL' nowrap> "
													  +"입력형식"													
												  +"<\/td>"
												  +"<td class='item_optR'> "												  
													  +"<select name=dummy2["+i+"] style='float:left;margin-right:10px;'> "
													  +"<option "+val_text+"><?php echo af_txt_add_items_9;?> "		
													  +"<option "+val_textArea+"><?php echo af_txt_add_items_10;?> "	
													  +"<option "+val_SelectDate1+"><?php echo af_txt_add_items_11;?>"	  
													  +"<option "+val_SelectDate2+"><?php echo af_txt_add_items_12;?>"
													  +"<option "+val_text2+"><?php echo af_txt_add_items_13;?>"
													  +"<option "+val_text3+"><?php echo af_txt_add_items_14;?>"
													  +"<option "+val_text4+"><?php echo af_txt_add_items_15;?>"
													  +"<option "+val_text5+"><?php echo af_txt_add_items_16;?>"
													  +"<option "+val_tel+"><?php echo af_txt_add_items_17;?>"
													  +"<option "+val_hp+"><?php echo af_txt_add_items_18;?>"
													  +"<option "+val_zipcode+">우편번호와주소검색"
													  +"<\/select>"
													  +"<div style='color:gray;font-size:11px;'>* 여러개중에 한개를 선택하는 펼침메뉴,라디오버튼,체크박스등은 아래 <strong style='font-size:11px;'>옵션추가/수정<\/strong> 버튼을 클릭하여 옵션으로 설정하세요.<\/div>"
												  +"<\/td> "
											+"<\/tr>"
											//사이즈(품목)
											+"<tr class='formmail_hide'>"
												  +"<td class='item_optL' nowrap> "
												      +"사이즈"													
												  +"<\/td>"
												  +"<td class='item_optR'><input name=dummy1["+i+"] onblur=\"Numbering(this)\" "
													  +"value=\""+items[i][9]+"\" size=\"3\" > <span style='font-size:11px;color:gray;'>숫자만 입력하세요 (스크롤글상자의 경우엔 줄수가 됩니다.)<\/span> "
												  +"<\/td>"	
											+"<\/tr>"
											//옵션설정
											+"<tr>"	
												  +"<td class='item_optL' nowrap> "
													  +"옵션설정"													
												  +"<\/td>"
												  +"<td class='item_optR'> "													
													  +"<input type='hidden' name=default_opt["+i+"] value=\""+items[i][17]+"\"> "
													  +"<input type='text' name=opt["+i+"] onblur=\"quot_Del(this)\" "
													  +"value=\""+items[i][4]+"\" readonly> "
													  +"<input type='button' value='옵션추가/수정' onclick=\"javascript:void(window.open('add_opt.php?form_type=<?php echo $form_type?>&w=500&h=400&fname=<?php echo $fname?>&NO="
													  +items[i][0]+"\&opt_no="+i+"','addopt','status=yes,scrollbars=yes,toolbar=no'))\">"
													  +"<div style='color:gray;font-size:11px;' class='formmail_hide'>* 옵션을 설정하면, 위에서 설정한 <strong style='font-size:11px;'>[초기값,필수입력,입력필터링,입력형식]<\/strong>는 무효합니다.<\/div>"
												  +"<\/td>"
											+"<\/tr>"
											//간단설명
											+"<tr>"	
												  +"<td class='item_optL' nowrap> "
													 +"부가설명"													
												  +"<\/td>"
												  +"<td class='item_optR'> "												 												
													 +"<textarea name=dummy7["+i+"] rows='5' class='tag_s' id='exp_textarea"+i+"' style='width:350px;' onblur=\"quot_Del2(this)\">"+val_dummy7+"<\/textarea>"
												+"<\/td>"
											+"<\/tr>"														
										+"<\/table>"
										+"<div style='text-align:right;'>"
										+"<input type='button' value='저장하기' onclick='Mix(this.form);toDB(this.form)' class='btn_list'>"
										+"<input type='button' value='폼보기' onclick=\"javascript:void(window.open('../view_addform.php?fname=<?php echo $fname;?>','popup_view2',''))\" class='btn_list'>"
										+"<\/div>"
									+"<\/fieldset>"
								+"<\/div>"
							+"<\/td>"
							//#####################################################################################//		
							//#################		수정버튼 클릭시 표시될 설정항목들 end	  #####################//
							//#####################################################################################//

							//수정,삭제
							+"<td nowrap style='width:150px;padding-right:15px;'>"
								+"<input type=button value='속성/옵션' onclick='displayOpt(this,\"item_optTD"+i+"\")' class='btn_list'>"					
								+"<input type=button value='<?php echo af_txt_del;?>' onclick='del_item("+i+")' class='btn_list'>"
							+"<\/td>"
						+"<\/tr>"						
					 +"<\/TBODY>"
				 +"<\/table>"
			 +"<\/li>"

	 
												
        return buffer;
			
}
//#####################################################################################//
//#####################################################################################//
//#####################################################################################//
//#####################################################################################//
//#####################################################################################//
//#####################################################################################//



//############# htmlConvert_data(i)에서 변환한 코드를 patchZone 에 쓰는 함수 ##########//
function paste_patchZone(convertData) {					  
     //document.all['patchZone'].innerHTML+=convertData;	//불여우에서는 동작안함
	document.getElementById('patchZone').innerHTML+=convertData;
	//document.patchZone.rows(0).cells(0).innerHTML+=convertData;
	//snake_zone.rows(0).cells(0).innerHTML='bb'
}

//########################  3. 품목삭제 함수 start  ###################################//
function del_item(i) {  									  
    if (confirm('<?php echo af_txt_add_items_20;?>')) {
        
        items=items.array_del(i);		
        //document.all['patchZone'].innerHTML+="";		  //불여우에서는 동작 안함	  
		document.getElementById('patchZone').innerHTML="";//해당 배열의 patchZone 을 비움   
        initial();										  //문서 초기화
    }
}
															

//########################  초기 문서출력함수 start  ##################################//
function initial() 
{									  
    var buffer="";   
							
    resetItemSize();									  //현재 레코드의 수를 재정의
    
    for (var i=0;i<item_len;i++) 
	{													  // items[] 배열수만큼      
        buffer+=htmlConvert_data(i);                      // HTML 변환
    } 
   
    CurrentPosition=i;									  //현재 배열 레코드 포인트의 값    
		//htmlConvert_data(i)에서 변환한 코드를 patchZone 에 쓰는 함수
    paste_patchZone(buffer);	
	code_re();
	
}														  
//########################  초기 문서출력함수 end  ####################################//


function toDB(form) {
	
    if (confirm('<?php echo af_txt_add_items_21;?>')) {
        return form.submit();							 // 저장하기 위해 폼 전송
    }
}
</script>

<!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
<!--###########################	자바스크립트 end	##################################-->
<!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->

</HEAD>

<BODY onload="initial();">	
	<FORM name='form1' method=post action='<?php echo $_SERVER['PHP_SELF'];?>?mode=save' onsubmit='return false'>
		<input type="hidden" name="fname" value="<?php echo $fname?>">
		<input type="hidden" name="form_type" value="<?php echo $form_type?>">
		<input type="hidden" name="no" value="<?php echo $no?>">
		<input type="hidden" name="title_text" value="<?php echo $_GET[title_text].$_POST[title_text]?>">
		
		<!--  패치된 dummy 가 1일 때 배열로 인식못하므로 무의미한 더미필드를 상시 존재하게(순서중복검사에 사용)  -->
		<input type='hidden' name='dummy' value="0">

		<!--
		onblur='Numbering(this)' 이벤트:커서를 영역밖으로 이동했을 때, Numbering함수 실행하여, 숫자만 입력했는지 체크
		onkeyup='checkKey(addBtn)' 이벤트:checkKey()함수 실행하여, 폼전송
		onblur='quot_Del(this)' 이벤트:입력필드항목의 인용부호(따옴표)를 제거
		-->

		<!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
		<!--###########################		품목추가구역			##########################-->
		<!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
		<DIV style="background-image:url(img/bg_f11.gif);background-repeat:no-repeat;background-position:right top;">
			<FIELDSET style="margin:0;padding:0;">
			<LEGEND><?php echo "<strong style='color:red;font-size:1.5em;'>".$af_TABLE5["title_text"]."</strong> 에 품목/항목 추가";?></LEGEND>
				<!--상단 선택상자 및 검색--> 
				<TABLE summary="품목추가 테이블" class="noborder" style="margin:0;padding:0;">
					<TR>
						<TD style="text-align:left;" nowrap> 
							<!-- 도움말 -->
							<FIELDSET style="text-align:left;height:110px;margin:5px;">
								<LEGEND>Tip</LEGEND>										
									<ul style="text-align:left;margin-top:10px;">
										<li>오른쪽 옆에 있는, 품목/항목추가 입력란에 입력 후, 품목추가를 합니다.</li>
										<li>품목/항목추가후에는, 속성/옵션 버튼을 눌러서, 속성과 옵션을 설정할 수 있습니다.</li>
										<li>품목과 항목은 같은 뜻을 의미합니다.(주문폼에서는 품목, 폼메일에서는 항목)</li>
									</ul>
							</FIELDSET>						
						</TD>
						<TD style="text-align:right;width:300px;">
							<!-- 추가필드와 버튼 -->
							<FIELDSET style="height:110px;margin:5px;">
								<LEGEND>품목/항목 추가</LEGEND>	
								<table style="margin-top:10px;">
									<tr>
										<td style="text-align:left;">										
											<input name='nName' onkeyup='checkKey(addBtn)' onblur='quot_Del(this)' class="input_big">
										</td>
										<td>
											<input type='button' id='addBtn' value='<?php echo af_txt_add_items_30;?>' onclick='add_item(this.form)' class="btn_big_main" style="width:139px;">
										</td>
									</tr>
								</table>							
								<div style='display:none;'>
									<input type="hidden" name='nCode' size="2">									
									<input type='hidden' name='nOpt' onkeyup='checkKey(addBtn)' onblur='quot_Del(this)'>							 
									<input name='nDefault_text' onkeyup='checkKey(addBtn)' onblur='quot_Del(this)' style='width:100%'>						
									<input name='nPrice' onkeyup='checkKey(addBtn)' onblur='NumberDot(this)' value="0" style='text-align:right;'>							
									<input name='nTax' onkeyup='checkKey(addBtn)' onblur='NumberDot(this)' value="0" size='2' style='text-align:right;'>%							
									<input type='hidden' name='nUnit' onkeyup='checkKey(addBtn)' onblur='quot_Del(this)' value='개'>
									<!--<?php echo f_mkOptArr("od_unit","nUnit");?>-->						
									<textarea name='nExp' rows='2' cols='38' onclick='this.cols="100";this.rows="10";' onmouseout='this.cols="38";this.rows="2";' class="tag"></textarea>								
									<!-- 폼메일 항목 사이즈 히든 -->	
									<input type='hidden' name='nDummy1' size='3' value=''>									
								</div>
							</FIELDSET>				
						</TD>
					</TR>
				</TABLE>
			</FIELDSET>	
		</DIV>

		<!--+++++++++++  폼메일일 추가항목1 이상일 때 고객기본입력 항목 모듈 표   ++++++++++++-->				
		<?php get_clientPos();?>
		
		<!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
		<!--###########################		품목편집 구역			##########################-->
		<!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
		<DIV style="margin-top:20px;">
			<FIELDSET style="margin:0;padding:0;">
				<LEGEND>추가한 품목편집</LEGEND> 
				<div style="text-align:left;margin-top:10px;" class="estimate_hide">					
				</div>			
				<?php echo $order_exist_alert;?>
				<!--+++++++++++++++++++    패치 테이블 상단	    ++++++++++++++++-->
				<div style="margin-top:20px;">				
					<table class="noborder">
						<tr>
							<td style="color:gray;text-align:left;">
							<?php if($reTABLE[cnt] > 0) {?>
								품목이나 항목추가는, 우측상단에 위치한 품목추가에서 입력 후, 추가하면 됩니다.<br>
								추가된 품목이나 항목의 속성과 옵션은 속성/옵션 버튼을 클릭하여 설정합니다.<br>
								품목이나 항목을 추가하거나 수정 후에, 하단의 품목저장 버튼을 클릭하여 저장합니다.<br>
								현재폼의 기본 환경설정으로 되돌아가고자 한다면, 오른쪽에 위치한 폼환경설정버튼을 클릭합니다.<br>
								손바닥 아이콘을 드래그하여, 순서를 자동정렬할 수 있습니다.(단, MS 익스플로러에서 작동하고, 품목저장 후 가능합니다.)<br>
								<span class="formmail_hide">항목의 짝수행에 표시된 체크상자에 체크하면, 해당항목 위의 항목과 가로 가로짝짓기가 됩니다.</span><br>


							<? }?>
							</td>
							<td style="text-align:right;padding-right:20px">
								<input type='button' value='<?php echo af_txt_add_items_50;?>' onclick="javascript:void(window.open('../view_addform.php?fname=<?php echo $fname;?>','popup_view2',''))" style="width:139px;font-size:11px;height:30px;"><br>
								<input type='button' value='<?php echo af_txt_add_items_51;?>' onclick="location.href='form_add.php?no=<?php echo $no;?>&amp;mode=modify'" style="width:139px;font-size:11px;height:30px;"><br>
								<input type='button' value='전체항목속성/옵션 열기' onclick='displayOpt_all(this,"item_optTD","td")' style="width:139px;font-size:11px;height:30px;">
							</td>
						</tr>
					</table>
				
				<!--+++++++++++++++++++    패치 테이블(li) start	   +++++++++-->
					<ul id="patchZone" style="margin:0;padding:0;">
					</ul>
				</div>				
			</FIELDSET>
		</DIV>
		
		<!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
		<!--###########################		하단 버튼				##########################-->
		<!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
		<DIV style="margin-top:10px;text-align:center;width:700px;padding-right:38px;">
			<input type='button' value='<?php echo af_txt_add_items_49;?>'	onclick='Mix(this.form);toDB(this.form)' class="btn_big_main" style="width:139px;">
			<input type='button' value='<?php echo af_txt_add_items_50;?>' onclick="javascript:void(window.open('../view_addform.php?fname=<?php echo $fname;?>','popup_view2',''))" class="btn_big_main" style="width:139px;">
		</DIV>

	</FORM>

</BODY>
</HTML>