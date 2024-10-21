<?php
include_once("lib/lib.php");
include_once("lib/C_CONNECT.php");
include_once("lib/define_table.php");
include_once("function/f_get_afTABLE.php");
include_once("function/f_get_afTABLE1.php");
include_once("function/f_get_afTABLE2.php");
include_once("function/f_get_afTABLE5.php");
include_once("function/f_get_afTABLE7.php");

/* ----------------------------------------------------------------------------------- */
/*	프로그램명 : 애드폼(영문 addform												   */									
/*	프로그램용도: 견적서 주문서 폼메일 제작											   */
/*	제작자: 박성규																	   */
/*	공식배포처: http://www.addform.net												   */
/*  프로그램 편집시 위 제작자 정보를 편집하거나 삭제해서는 안됩니다.				   */
/* ----------------------------------------------------------------------------------- */


?>

<?
$records = '20';										// 한 화면에 뿌려질 레코드 수
$page_n = '10';											// 하단 페이지 리스트 수

#########################################################################################
##################### 처리상황 출력위한 전역변수 선언		   ##########################
#########################################################################################

$af_TABLE1 = f_get_afTABLE1("no","1");					//관리자 테이블에서 가져오기
$af_TABLE2 = f_get_afTABLE2("no","1");					//DB처리상황 테이블에서 가져오기
$af_TABLE5 = f_get_afTABLE5("name",$_GET['fname']);		//폼이름
$af_TABLE7 = f_get_afTABLE7("no","1");


#########################################################################################
############     사용자가 검색을 실행할 경우 $where 검색조건 정의 start     #############
#########################################################################################

if($_GET['mode'] == "search_form"){	
	$fname="";
	$fname = $_GET['fname'];
	$keywd="";
	$keywd = $_GET['keywd']; 

	$vowels = array("'","\"");								//제거할 특수문자 배열
	$fname = str_replace($vowels, "", $fname);				//인용부호 제거
	$keywd = str_replace($vowels, "", $keywd);				//인용부호 제거    	
	
	if($keywd) {											//검색키워드가 있을때		
		//다른폼에서 가져오는것을 방지하기 위해 폼이름과 고객이름 일치 또는 폼이름과 접수번호일치  검색
		$where = " where mom like '%$fname%' and client_name like '%$keywd%'";	
		$where .= "or mom like '%$fname%' and af_order_no like '%$keywd%'";			
		//$where .= " no like '%$keywd%' ";					//레코드번호 검색
		//$where .= "or af_order_no like '%$keywd%' ";		//접수번호 검색
		//$where .= "or client_name like '%$keywd%' ";		//고객 이름 검색
		//$where .= "or client_tel like '%$keywd%' ";		//고객 전화번호 검색
		//$where .= "or client_hp like '%$keywd%' ";		//고객 휴대폰 검색
		//$where .= "or client_email like '%$keywd%' ";		//고객 이메일 검색
		//$where .= "or client_address like '%$keywd%' ";	//고객 주소 검색
		//$where .= "or client_memo like '%$keywd%' ";		//고객 메모	 검색
		//$where .= "or supply_memo like '%$keywd%' ";		//관리자 메모 검색
		//$where .= "or hostinfo like '%$keywd%' ";			//고객 아이피 검색
		//$where .= "or select_items like '%$keywd%' ";		//주문정보 검색
		//$where .= "or sum like '%$keywd%' ";				//합    계 검색
		//$where .= "or dummy1 like '%$keywd%' ";			//폼의제목 검색
		//$where .= "or dummy5 like '%$keywd%' ";			//수취인정보 검색
		//$where .= "and mom like 'safdsafasfasfdasfd' ";	//수취인정보 검색

	}
}


#########################################################################################
#######				nameMode 초기접속 경우 $where 검색조건 정의 start			#########
#########################################################################################

else if($_GET['mode'] == "nameMode"){	
	$fname="";
	$fname = $_GET['fname'];

	$vowels = array("'","\"");							//제거할 특수문자 배열
	$fname = str_replace($vowels, "", $fname);			//인용부호 제거
    
	if($fname) {										//검색키워드가 있을때			
		$where = " where mom like '%$fname%' ";			//mom은 폼이름   
	}			
}



#########################################################################################
#####################    검색이 아닌 초기접속시 $where 정의 start     ###################
#########################################################################################

else{
	$where = "";
	}
///////DB에서 가져오기///////
$res=$DBconn->f_selectDB("*",TABLE4,$where);			//필드, 테이블, 조건절
//$rows = mysql_fetch_array($res[result]);				//리턴된 배열을 $row에 저장
$res_count=mysql_num_rows($res[result]);				//리턴된 행의 개수



#########################################################################################
############################    페이지 나누기 start      ################################
#########################################################################################

$page = $_GET['page'];

	if(!$page){
		$page = 1;
		} 
	$start = ($page-1)*$records;
	$end = $start+$records;
	$over_page = floor($start/($records*$page_n));
	$total_page = floor($res_count/$records+1);

	if($end > $res_count){
		$end=$res_count; 
		} 
	if($page>$total_page){
		$page=$total_page; 
		}	



#########################################################################################
##########################     레코드 배열 출력함수 start     ###########################
#########################################################################################

function f_loopRec(){
	$code = $_GET['code'];
	$desc = $_GET['desc'];
	global $where;
	global $start;
	global $end;
	global $af_TABLE2;
	
	$dummy1 = explode("|",htmlspecialchars(stripslashes($af_TABLE2["dummy1"])));		
	$arr_situation = explode(",",$dummy1[0]);		 //$dummy1 필드의 구분자로 부터 배열화(구분문구)
	$arr_situation_color = explode(",",$dummy1[1]);	 //$dummy1 필드의 구분자로 부터 배열화(구분색상)

	for($i= $start ; $i < $end ; $i++){	
		if(!$code) $code="no"; else $code=$code; 
		if(!$desc) $desc="desc"; else $desc=$desc;
		//$code="no";                                //no필드를 기준으로 정렬

	    $load = "select * from ".TABLE4;
		$load .= $where;//검색조건
		$load .= " order by $code $desc ";           //정렬조건 desc 는 내림차순, asc 는 오름차순
		$load .= " limit $i,1 ";                     //한페이지에 출력될 수 제한(while문 무한루프돌지 않게)

		$result = mysql_query($load);
		$rows = mysql_num_rows($result);

		if($rows){
	while($row = mysql_fetch_array($result)){		
		$no = htmlspecialchars(stripslashes($row["no"]));                           //고유번호
		$af_order_no = htmlspecialchars(stripslashes($row["af_order_no"]));			//접수번호
		$mom = htmlspecialchars(stripslashes($row["mom"]));							//폼이름
		$client_name = htmlspecialchars(stripslashes($row["client_name"]));			//고객이름
		$client_tel = htmlspecialchars(stripslashes($row["client_tel"]));			//고객전화
		$client_hp = htmlspecialchars(stripslashes($row["client_hp"]));				//휴대폰

		$client_email = htmlspecialchars($row["client_email"]);						//고객이메일(작은따옴표 있으면 에러나서 stripslashes 뺐음)
																					//add_items.php 간단설명에서도...

		$client_address = htmlspecialchars(stripslashes($row["client_address"]));   //고객주소
		$client_memo = htmlspecialchars(stripslashes($row["client_memo"]));			//고객메모
		$hostinfo = htmlspecialchars(stripslashes($row["hostinfo"]));				//고객아이피		
		$input_date = htmlspecialchars(stripslashes($row["input_date"]));           //생성시각
		$edit_date = htmlspecialchars(stripslashes($row["edit_date"]));             //수정시각	
		$select_items = htmlspecialchars(stripslashes($row["select_items"]));       //주문데이타
		$sum = htmlspecialchars(stripslashes($row["sum"]));							//주문합계	
		$situation = htmlspecialchars(stripslashes($row["situation"]));				//상 황

		$subject = htmlspecialchars(stripslashes($row["dummy1"]));					//제 목
		$form_type = htmlspecialchars(stripslashes($row["dummy2"]));				//폼의형식		
		$fileName = htmlspecialchars(stripslashes($row["dummy3"]));					//첨부된 파일이름
		$readN = htmlspecialchars(stripslashes($row["dummy6"]));					//관리자열람(null or 1)
			
		
		
		$input_date1 =  date("Y.m.d",$input_date);                            //접수시각
		
		if($client_name) $client_name = $client_name;
		else $client_name = "no name";

		$arr_client_email = explode("@",$client_email);
		$email = $arr_client_email[0]."@xxxxx.xxx";
		
		$getinja = "w=550&amp;h=500&amp;pageid=progress&amp;title=$subject&amp;af_order_no=$af_order_no&amp;client_name=$client_name&amp;client_email=$email&amp;input_date=$input_date&amp;readN=$readN&amp;situation=".$arr_situation[$situation-1]."";

			echo("	
				 	<tr>
						<td nowrap>
						$af_order_no
						</td>
						<td nowrap>						
						$subject
						</td>						
						<td nowrap>
						$client_name						
						</td>												
						<td nowrap>
						$input_date1					
						</td>
						<td nowrap class='situ' style='background-color:".$arr_situation_color[$situation-1].";cursor:hand;' onclick=\"javascript:void(window.open('html/index.html?$getinja','progress','width=550,height=500,status=yes,scrollbars=yes,toolbar=no,location=no,resizable=yes'))\">
						".$arr_situation[$situation-1]."
						</td>
					</tr>			
				 ");
			
		}// while문 끝
	}// if문 끝	
}// for문 끝
}
############################     레코드 배열 출력함수 end       #########################
#########################################################################################



#########################################################################################
###############################    페이지 나누기 함수 start       #######################
#########################################################################################

function f_pageDiv(){	
	global $page; 
	global $page_n;
	global $over_page;
	global $total_page;

	$code = $_GET['code'];
	$desc = $_GET['desc'];
	$mode = $_GET['mode'];
	$keywd = $_GET['keywd'];
	$fname = $_GET['fname'];

	echo "<div>";
	if($page > $page_n){ 
		$prev = $over_page * $page_n;
		echo("<a href='".URL."?code=$code&amp;desc=$desc&amp;page=$prev&amp;mode=$mode&amp;keywd=$keywd&amp;fname=$fname'><img src='imgs/btn_pre.gif' align='middle'></a>&nbsp;&nbsp;"); 
	}else{
		echo("<img src='imgs/btn_pre.gif'  align='middle'>&nbsp;&nbsp;");
	} 


	for($j=0 ; $j < 10 ;$j++){ 
		$link = $j+$page_n*$over_page+1;
		$vlink= $over_page*$page_n+$j+1;
		if($link <= $total_page){
			if($vlink == $page){
				echo("<font color=red>$vlink</font>&nbsp;&nbsp;");
			}else{
				echo("<a href='".URL."?code=$code&amp;desc=$desc&amp;page=$link&amp;mode=$mode&amp;keywd=$keywd&amp;fname=$fname'>[$vlink]</a>&nbsp;&nbsp;");
			}
		} 
	} 

	if($total_page > ($over_page+1)*$page_n){
		$next = $over_page*$page_n+$page_n+1;
		echo("<a href='".URL."?code=$code&amp;desc=$desc&amp;page=$next&amp;mode=$mode&amp;keywd=$keywd&amp;fname=$fname'><img src='imgs/btn_next.gif'  align='middle'></a>");
	}else{
		echo("<img src='imgs/btn_next.gif'  align='middle'>");
	}
	echo "</div>";
}

if(!$af_TABLE5["font_family"]) $af_TABLE5["font_family"] = "'돋움', '돋움체', '굴림', '굴림체', 'Times New Roman', 'Verdana', 'Tahoma', 'Arial'";
if(!$af_TABLE5["font_size"]) $af_TABLE5["font_size"] = "13px";
if(!$af_TABLE5["font_color"]) $af_TABLE5["font_color"] = "#000000";
if(!$af_TABLE5["layout"]) $af_TABLE5["layout"] = "8";

if(!$af_TABLE5["width"]) $af_TABLE5["width"] = "95%";    //너비값이 없을 때
if($af_TABLE5["width"] > 100) $af_w_unit = "px";
else $af_w_unit = "%";
?>
<!--##################################################################################-->
<!--########################		HTML start	 #####################################-->
<!--##################################################################################-->
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<title><?php echo $af_TABLE5["title_text"];?></title>

<!--########################			스타일 start			######################-->
<LINK REL="stylesheet" HREF="skins/<?php echo $af_TABLE5["skin_name"]?>/style.css" TYPE="text/css">
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
<!--########################			스타일 end				######################-->
<script type="text/javascript" src='js/pop_center.js'></script>
<script type="text/javascript" src='js/change_form.js'></script>
</HEAD>

<BODY>
<?php include "skins/".$af_TABLE5["skin_name"]."/index_list.php";?>	
	
</BODY>
</HTML>