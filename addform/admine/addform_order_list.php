<?php
include_once("../lib/lib.php");
include_once("../lib/C_CONNECT.php");
include_once("../lib/define_table.php");
include_once("../lib/authentication.php");
include_once("../function/f_get_af_dir.php");


/* ----------------------------------------------------------------------------------- */
/*	프로그램명 : 애드폼(영문 addform												   */									
/*	프로그램용도: 견적서 주문서 폼메일 제작											   */
/*	제작자: 박성규																	   */
/*	공식배포처: http://www.addform.net												   */
/*  프로그램 편집시 위 제작자 정보를 편집하거나 삭제해서는 안됩니다.				   */
/* ----------------------------------------------------------------------------------- */
//addform_env 테이블로 부터 가져오기
$env_res=$DBconn->f_selectDB("*",TABLE2,$where);									
$env_result = $env_res[result];
$env_row =  mysql_fetch_array($env_result);				
		$env_upload_space = htmlspecialchars(stripslashes($env_row["upload_space"]));			//업로드 폴더 알림 설정용량
		$env_upload_space_per = htmlspecialchars(stripslashes($env_row["upload_space_per"]));	//경고수위
		$env_upload_use_alert = htmlspecialchars(stripslashes($env_row["upload_use_alert"]));	//알림설정 사용여부 0,1

//업로드 폴더 정보 배열
$af_dir_upload = f_get_af_dir("../upload/");


if($env_upload_use_alert == "1" and $af_dir_upload["totalsize"] > $env_upload_space*$env_upload_space_per/100)
{
	echo "<script type='text/javascript'>alert('".af_txt_order_list_18."".number_format($af_dir_upload["totalsize"]/1024/1024,2)." Mbyte".af_txt_order_list_19."');</script>";
}


if($_COOKIE[af_odlistN])
{
	$records = 	$_COOKIE[af_odlistN];
}
else $records = '10';									// 한 화면에 뿌려질 레코드 수
$page_n = '10';											// 하단 페이지 리스트 수

?>

<?php

#########################################################################################
##################### 처리상황 선택상자 출력위한 전역변수 선언 ##########################
#########################################################################################

$re=$DBconn->f_selectDB("*",TABLE2,"where no=1");			//C_CONNECT 클래스 멤버함수인 f_selectDB($field="*",$table,$where="")를 실행하여
															//$re[result]에 저장하고 불러온 레코드 수를 $re[cnt]에 저장 
	
           
              
        $row=mysql_fetch_array($re[result]);				//배열의 요소들을 $row에 대입
															//애드폼환경 테이블  $dummy1 필드의 값
			$dummy1 = explode("|",htmlspecialchars(stripslashes($row["dummy1"])));		
			$arr_situation = explode(",",$dummy1[0]);		//$dummy1 필드의 구분자로 부터 배열화(구분문구)
			$arr_situation_color = explode(",",$dummy1[1]);	//$dummy1 필드의 구분자로 부터 배열화(구분색상)
			$front_situation = $arr_situation[$get_no-1];	//부모창에서 버튼클릭으로 선택된 상황





#########################################################################################
##############################     상황 선택상자 part1      #############################
#########################################################################################

//<option>태그 생성
function f_opt_situ($val,$text,$default="",$head="") {
	        $buf="<option value='$val'";
	        if ($default&&$default==$text) {
	            $buf.="selected";
	        }
	        $buf.=">".$head;
	        return $buf;
	    }
//select 선택상자 구성
function f_SelectBox_situ($arr) {
	if ($arr[name]) $arr[name]="name=$arr[name]";
    if ($arr[id]) $arr[id]="id=$arr[id]";
    if ($arr[style]) $arr[style]="style='$arr[style]'";	
    if ($arr[disable]) $arr[disable]="disable";
    
    $buf="<select 
	    $arr[name]
        $arr[id]
        $arr[style]
		$arr[script]
        $arr[disable]
        >
			<option value=''>".af_txt_selectBox_opt1."</option>			
    \n";
    if ($arr["end"]>$arr[start]) {             //숫자 범위 지정시
        for ($i=$arr[start];$i<=$arr["end"];$i++) {
            $buf.=opt($i,$arr["default"],$arr[head]).$i.$arr[tail]."\n";
        }
    } else if (count($arr[text])) {          
        for ($i=0;$i<count($arr[text]);$i++) {
            $buf.=f_opt_situ($arr[optVal][$i],&$arr[text][$i],$arr["default"],$arr[head]).$arr[text][$i].$arr[tail]."\n";
        }
    }
    
    $buf.="</select>\n";
    return $buf;
}




#########################################################################################
###############################     상황 선택상자 part2      ############################
#########################################################################################

function f_mkOptArr_situ($name,$situation_no,$combo_script){
global $arr_situation;										 //dummy1필드의 값을 쉼표로 구분한 배열(구분문구)
global $arr_situation_color;								 //dummy1필드의 값을 쉼표로 구분한 배열(구분색상)
global $front_situation;	
															 //디폴트로 선택될 콤보박스 텍스트
$default="";												 //situation필드의 기본값이 1이므로 -1처리
$default = $arr_situation[$situation_no-1];
$style = "";
$style="background-color:".$arr_situation_color[$situation_no-1].";";

$no=array();                                                 //배열변수 정의(상황번호)
$na=array();                                                 //배열변수 정의(상황이름)

	for ($i=0;$i<count($arr_situation);$i++) {               //배열길이 만큼 루프       
		$na[$i]=$arr_situation[$i];							 //이름 스칼라배열 만듬  
		$no[$i]=$i+1;										 //상황번호 스칼라배열 만듬			
    }	
	//$arr=array("name"=>"comboGroup","id"=>"selectGroup","text"=>&$a);//연관배열 정의 방법1
	$arr=array();                                            //연관배열 정의 방법2
		$arr[head]="";
		$arr[tail]="";
		$arr[start]="";
		$arr['end']="";
		$arr['default']=$default;							 //디폴트로 선택될 text
		$arr[name]=$name;									 //선택상자 이름
		$arr[id]="";                                         //선택상자 객체 구분 아이디
		$arr[style]=$style;									 //선택상자 스타일
		$arr[script]=$combo_script;							 //실행할 스크립트			
		$arr[optVal]=$no;									 //옵션 value		
		$arr[text]=$na;                                      //실렉트 메뉴 배열
		

echo f_SelectBox_situ($arr);								 //f_SelectBox_situ 함수 실행
}


#########################################################################################



#########################################################################################
#########################    선택한 접수레코드 삭제 start     ###########################
#########################################################################################

if($_POST['mode']=="del") {
	
		echo f_del($_POST['chk_list']);					//$chk_list인자는 선택한 체크박스 배열
}

function f_del($no){									
	global $DBconn;	
	$get_delInja = "";
	$get_delInja .= "mode=".$_POST['prev_mode']."&amp;code=".$_POST['code']."&amp;desc=".$_POST['desc']."&amp;";
	$get_delInja .= "mode_key=".$_POST['mode_key']."&amp;situ_key=".$_POST['situ_key']."&amp;";
	$get_delInja .= "basis_time=".$_POST['basis_time']."&amp;yS=".$_POST['yS']."&amp;mS=".$_POST['mS']."&amp;dS=".$_POST['dS']."&amp;yE=".$_POST['yE']."&amp;mE=".$_POST['mE']."&amp;dE=".$_POST['dE']."&amp;";
	$get_delInja .= "keywd=".$_POST['keywd']."&amp;";
	$get_delInja .= "page=".$_POST['page']."";

	$n = count($no);									//전달받은 배열의 크기	

	for($i=0;$i < $n;$i++){
	//$where="where name='$no[$i]'";					//no필드대신 name필드를 조건하였고 문자형이므로 작은따옴표 붙임에 주의
	$where="where no=$no[$i]";	
	
	$re=$DBconn->f_selectDB("*",TABLE4,$where);			//첨부파일의 이름을 가져오기 위해 검색
	$result = $re[result];
	$row =  mysql_fetch_array($result);
		$upload_file = htmlspecialchars(stripslashes($row["dummy3"]));//업로드된 파일이름		
	@unlink("../upload/$upload_file");					//첨부파일삭제

	$DBconn->f_deleteTable(TABLE4,$where);				//레코드 삭제(테이블, 조건절)	
	}
	die("<meta http-equiv=refresh content='0;url=".URL."?".$get_delInja."'>");			//쿼리실행 후 문서 고침
}

//----------------------------	 첨부파일만 삭제시	-----------------------------------//

if($_GET['del_file_name']) 
	{
		$get_delfileInja = "";
		$get_delfileInja .= "mode=".$_GET['mode']."&amp;code=".$_GET['code']."&amp;desc=".$_GET['desc']."&amp;";
		$get_delfileInja .= "mode_key=".$_GET['mode_key']."&amp;situ_key=".$_GET['situ_key']."&amp;";
		$get_delfileInja .= "basis_time=".$_GET['basis_time']."&amp;yS=".$_GET['yS']."&amp;mS=".$_GET['mS']."&amp;dS=".$_GET['dS']."&amp;yE=".$_GET['yE']."&amp;mE=".$_GET['mE']."&amp;dE=".$_GET['dE']."&amp;";
		$get_delfileInja .= "keywd=".$_GET['keywd']."&amp;";
		$get_delfileInja .= "page=".$_GET['page']."";
		@unlink($_GET['del_file_name']);				//첨부파일만 삭제	
		die("<meta http-equiv=refresh content='0;url=".URL."?".$get_delfileInja."'>");	//쿼리실행 후 문서 고침				
	}



#########################################################################################
######################   선택한 접수레코드 읽은상태로 변경 start     ####################
#########################################################################################
if($_POST['mode']=="read") {
														//chk_list인자는 선택한 체크박스 배열														
		echo f_read($_POST['chk_list']);			
}

function f_read($no){								
	global $DBconn;	
	
	$get_situMinja = "";
	$get_situMinja .= "mode=".$_POST['prev_mode']."&amp;code=".$_POST['code']."&amp;desc=".$_POST['desc']."&amp;";
	$get_situMinja .= "mode_key=".$_POST['mode_key']."&amp;situ_key=".$_POST['situ_key']."&amp;";
	$get_situMinja .= "basis_time=".$_POST['basis_time']."&amp;yS=".$_POST['yS']."&amp;mS=".$_POST['mS']."&amp;dS=".$_POST['dS']."&amp;yE=".$_POST['yE']."&amp;mE=".$_POST['mE']."&amp;dE=".$_POST['dE']."&amp;";
	$get_situMinja .= "keywd=".$_POST['keywd']."&amp;";
	$get_situMinja .= "page=".$_POST['page']."";

	$clean['dummy6'] = "1";								//읽은상태로 표시(1)

	$n = count($no);									//전달받은 배열의 크기	

	for($i=0;$i < $n;$i++){	
	$where="where no=$no[$i]";						
	$DBconn->f_updateDB(TABLE4,$clean,$where);			//$clean이 하나이므로 참조연산자&로 넘겨줄 필요없음에 주의	
	}
	die("<meta http-equiv=refresh content='0;url=".URL."?".$get_situMinja."'>");	//쿼리실행 후 문서 고침
}


#########################################################################################
######################   선택한 접수레코드 읽지않은상태로 변경 start     ################
#########################################################################################
if($_POST['mode']=="read_no") {
														//chk_list인자는 선택한 체크박스 배열														
		echo f_read_no($_POST['chk_list']);			
}

function f_read_no($no){								
	global $DBconn;	
	
	$get_situMinja = "";
	$get_situMinja .= "mode=".$_POST['prev_mode']."&amp;code=".$_POST['code']."&amp;desc=".$_POST['desc']."&amp;";
	$get_situMinja .= "mode_key=".$_POST['mode_key']."&amp;situ_key=".$_POST['situ_key']."&amp;";
	$get_situMinja .= "basis_time=".$_POST['basis_time']."&amp;yS=".$_POST['yS']."&amp;mS=".$_POST['mS']."&amp;dS=".$_POST['dS']."&amp;yE=".$_POST['yE']."&amp;mE=".$_POST['mE']."&amp;dE=".$_POST['dE']."&amp;";
	$get_situMinja .= "keywd=".$_POST['keywd']."&amp;";
	$get_situMinja .= "page=".$_POST['page']."";

	$clean['dummy6'] = "";								//읽지은상태로 표시(0 또는 null)

	$n = count($no);									//전달받은 배열의 크기	

	for($i=0;$i < $n;$i++){	
	$where="where no=$no[$i]";						
	$DBconn->f_updateDB(TABLE4,$clean,$where);			//$clean이 하나이므로 참조연산자&로 넘겨줄 필요없음에 주의	
	}
	die("<meta http-equiv=refresh content='0;url=".URL."?".$get_situMinja."'>");	//쿼리실행 후 문서 고침
}




#########################################################################################
######################   선택한 접수레코드 상황 변경 start     ##########################
#########################################################################################
if($_POST['mode']=="situModify") {
														//chk_list인자는 선택한 체크박스 배열
														//change_no인자는 선택한 변경될  숫자
		echo f_situModify($_POST['chk_list'],$_POST['change_no']);			
}

function f_situModify($no,$change_no){								
	global $DBconn;	
	
	$get_situMinja = "";
	$get_situMinja .= "mode=".$_POST['prev_mode']."&amp;code=".$_POST['code']."&amp;desc=".$_POST['desc']."&amp;";
	$get_situMinja .= "mode_key=".$_POST['mode_key']."&amp;situ_key=".$_POST['situ_key']."&amp;";
	$get_situMinja .= "basis_time=".$_POST['basis_time']."&amp;yS=".$_POST['yS']."&amp;mS=".$_POST['mS']."&amp;dS=".$_POST['dS']."&amp;yE=".$_POST['yE']."&amp;mE=".$_POST['mE']."&amp;dE=".$_POST['dE']."&amp;";
	$get_situMinja .= "keywd=".$_POST['keywd']."&amp;";
	$get_situMinja .= "page=".$_POST['page']."";

	$clean['situation'] = $change_no;					//변경될 상황코드(숫자)

	$n = count($no);									//전달받은 배열의 크기	

	for($i=0;$i < $n;$i++){	
	$where="where no=$no[$i]";						
	$DBconn->f_updateDB(TABLE4,$clean,$where);			//$clean이 하나이므로 참조연산자&로 넘겨줄 필요없음에 주의	
	}
	die("<meta http-equiv=refresh content='0;url=".URL."?".$get_situMinja."'>");	//쿼리실행 후 문서 고침
}









#########################################################################################
############     사용자가 검색을 실행할 경우 $where 검색조건 정의 start     #############
############	 ver 6에서 대부분의 검색오류 수정							#############
#########################################################################################
if($_GET[mode] or $POST[mode])
{
$mode_key="";
$situ_key="";
$keywd="";
$mode_key = $_GET['mode_key'].$_POST['mode_key'];	//검색조건1 폼이름
$situ_key = $_GET['situ_key'].$_POST['situ_key'];	//검색조건2 처리상황
$keywd = $_GET['keywd'].$_POST['keywd'];			//검색조건3 키워드

$vowels = array("'","\"");							//제거할 특수문자 배열
$mode_key = str_replace($vowels, "", $mode_key);	//인용부호 제거
$situ_key = str_replace($vowels, "", $situ_key);	//인용부호 제거
$keywd = str_replace($vowels, "", $keywd);			//인용부호 제거

//검색키워드가 있을때
	if($keywd) 
	{													
		//$kwds = " (mom = '$keywd' ";								//폼이름 검색(ver 6부터 검색안함)
		//$kwds .= "or no like '%$keywd%' $m_key $s_key ";			//레코드번호 검색(ver 6부터 검색안함)
		$kwds .= " (af_order_no like '%$keywd%' $m_key $s_key ";	//접수번호 검색(ver 6부터 괄호처리)
		$kwds .= "or client_name like '%$keywd%' $m_key $s_key ";	//고객 이름 검색
		$kwds .= "or client_tel like '%$keywd%' $m_key $s_key ";	//고객 전화번호 검색
		$kwds .= "or client_hp like '%$keywd%' $m_key $s_key ";		//고객 휴대폰 검색
		$kwds .= "or client_email like '%$keywd%' $m_key $s_key ";	//고객 이메일 검색
		$kwds .= "or client_address like '%$keywd%' $m_key $s_key ";//고객 주소 검색
		$kwds .= "or client_memo like '%$keywd%' $m_key $s_key ";	//고객 메모	 검색
		$kwds .= "or supply_memo like '%$keywd%' $m_key $s_key ";	//관리자 메모 검색
		$kwds .= "or hostinfo like '%$keywd%' $m_key $s_key ";		//고객 아이피 검색
		$kwds .= "or select_items like '%$keywd%' $m_key $s_key ";	//주문정보 검색
		$kwds .= "or sum like '%$keywd%' $m_key $s_key ";			//합    계 검색
		$kwds .= "or dummy1 like '%$keywd%' $m_key $s_key ";		//폼의제목 검색
		$kwds .= "or dummy5 like '%$keywd%' $m_key $s_key) ";		//수취인정보 검색
	}

	if($_GET[basis_time])											//검색조건4 기간조회
	{	
	$where = " where (".$_GET['basis_time']." between ".mktime(0,0,1,$_GET['mS'],$_GET['dS'],$_GET['yS'])." and ".mktime(23,59,59,$_GET['mE'],$_GET['dE'],$_GET['yE'])." ) ";		
	if($mode_key) $where .= "and mom = '$mode_key' ";				//전체검색이 아닌 폼이름 검색제한		
	if($situ_key) $where .= "and situation = '$situ_key' ";			//전체검색이 아닌 상황별 검색제한
	if($keywd) $where .= "and".$kwds."";							//키워드 검색이 있을 때
	}
	else															//기간검색은 없을 때
	{
		if(!$mode_key and !$situ_key and !$keywd)
		{
		$where = "";	
		}
		else
		{
		$where = " where ";	
		if($mode_key) $where .= "mom = '$mode_key' ";				//전체검색이 아닌 폼이름 검색제한		
		if($situ_key) 
			{
			if($mode_key) $and = "and ";
			$where .= $and."situation = '$situ_key' ";				//전체검색이 아닌 상황별 검색제한		
			}
		if($keywd)
			{
			if($mode_key or $situ_key) $and = "and ";
			$where .= $and.$kwds;									//키워드 검색이 있을 때	
			}
		}
	}
}
#########################################################################################
#####################    검색이 아닌 초기접속시 $where 정의 start     ###################
#########################################################################################
else
{
	$where = "";
}

///////DB에서 가져오기///////
$res=$DBconn->f_selectDB("*",TABLE4,$where);				//필드, 테이블, 조건절
//$rows = mysql_fetch_array($res[result]);					//리턴된 배열을 $row에 저장
$res_count=mysql_num_rows($res[result]);					//리턴된 행의 개수










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
													  //예약일과 접수일기준이 최종 조건일때는 code 강제
	if($_GET['basis_time']) $code = $_GET['code'] = $_GET['basis_time'];
	else $code = $_GET['code'];						  //다른 모드일 때는 그냥 get인자 참조
	$desc = $_GET['desc'];
	
	global $where;
	global $start;
	global $end;
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
		$readN = htmlspecialchars(stripslashes($row["dummy6"]));					//읽은횟수(v7.1pro)
		
		$uploadPath = "../upload/";													//업로드 폴더 경로
		$download_file = "";														//멀티이므로 빈 변수 선언
		$arr_fileName = explode(";",$fileName);										//첨부파일 이름들 ; 구분자로 배열화
		for($n=0;$n<count($arr_fileName);$n++)
		{
		if ($fileName)
			{
			$target_path = $uploadPath . $arr_fileName[$n];							//파일이 저장된 위치와 파일이름
			if (file_exists($target_path))
				{
				$download_file .= "<img src='img/disket.gif' style='vertical-align:middle;cursor:hand;' alt='첨부파일저장' onclick='window.open(\"$target_path\")'>";	
				$download_file .= "<img src='img/del.gif' style='vertical-align:middle;cursor:hand;' alt='첨부파일삭제' onclick='del_file(\"$target_path\")'>";
				}			
			}		
		}
		
		
		if($situation == "1") $situation_txt = "<span style='color:red;'>미처리</span>";
		if($situation == "4") $situation_txt = "종 - 결";	

		if($form_type == "0") {
			$form_type_txt = af_txt_formType0;
			$icon = "<img src='img/icon_order.gif' alt='주문서' style='vertical-align:middle'>&nbsp;&nbsp;";
			$view_file = "order.php";
			$estimate_report = "
			<input type='button' value='".af_txt_order_list_27."' onclick=\"esti_newWin('../estimate.php','admine','',$no,'$client_email','')\" class='btn_esti'><br>	
			<input type='button' value='".af_txt_order_list_1."' onclick=\"esti_newWin('../estimate.php','admine','send_esti',$no,'$client_email','$af_order_no')\" class='btn_esti'>";
			$order_modify = "
			<input type='button' value='".af_txt_order_list_28."' onclick=\"javascript:void(window.open('order_modify.php?w=980&amp;h=800&amp;mode=admine&amp;order_no=$no&amp;f_mom=$mom','order_modify','width=980,height=800,status=yes,scrollbars=yes,toolbar=no,location=no,resizable=yes'))\" class='btn_list'>";
			$formmail_modify = "";
			$formmail_reply = "";
			}
		if($form_type == "1") {
			$form_type_txt = af_txt_formType1;
			$icon = "<img src='img/icon_mail.gif' alt='폼메일' style='vertical-align:middle'>&nbsp;&nbsp;";
			$view_file = "formmail.php";
			$estimate_report = "";	
			$order_modify = "";
			$formmail_modify = "
			<input type='button' value='".af_txt_order_list_29."' onclick=\"javascript:void(window.open('formmail_modify.php?w=730&amp;h=530&amp;order_no=$no','formmail_modify','width=730,height=530,status=yes,scrollbars=yes,toolbar=no,location=no,resizable=yes'))\" class='btn_list'>";
			$formmail_reply = "
			<input type='button' value='".af_txt_order_list_26."' onclick=\"javascript:void(window.open('mail_delivery.php?w=730&amp;h=800&amp;order_no=$no','mail_delivery','width=730,height=800,status=yes,scrollbars=yes,toolbar=no,location=no,resizable=yes'))\" class='btn_delivery'>";			
			}	
		
		$input_date =  date("Y.m.d",$input_date)."<br><span class='time'>".date("ah시i분",$input_date)."</span>";//접수시각
		//$edit_date = date("Y.m.d",$edit_date);							 //수정시각	

		if($client_name) $client_name = $client_name;
		else $client_name = "no name";

		if($readN >= 1) $icon_read = "<img src='img/icon_read.gif' alt='읽은 접수내역' style='vertical-align:middle;'>";
		else $icon_read = "<img src='img/icon_noread.gif' alt='읽지않은 접수내역' style='vertical-align:middle;'>";

		$arr_hostinfo = explode(".",$hostinfo);
		

			echo("	
				 	<tr>
						<td nowrap class='order_list'>
							<input type='checkbox' name='chk_list[]' value='".$no."' class='c' id='checkbox$i'>
						</td>
						<td nowrap class='order_list' style='display:none;'>
							".$af_order_no."
						</td>
						<td nowrap class='order_list' style='font-weight:bold;color:#333;font-size:1.1em;'>							
							".$icon_read." ".$client_name."										
						</td>
						<td nowrap class='order_list' style='font-size:11px;color:#999;padding:5px;'>							
							".$subject."<br><strong>".$af_order_no."</strong><br>ip address ".$arr_hostinfo[0].".".$arr_hostinfo[1].". ~									
						</td>					
						<td nowrap class='order_list'>
							".$input_date."				
						</td>
						<td nowrap class='order_list'>");
							//선택상자 출력(선택상자객체명,상황코드,실행스크립트)
							f_mkOptArr_situ("comboSitu[]",$situation,"onchange='this.form.change_no.value=this.options[this.selectedIndex].value;chk_situModify(this.form,$i,this.options[this.selectedIndex].text,this.options[this.selectedIndex].value,".login_level.",".situModify_level.",\"".situModify_msg."\")'");
			echo("      </td>
						<td nowrap class='order_list'>						
							".$download_file."
						</td>
						<td style='text-align:center;' nowrap class='order_list'>");
							if(login_level > view_order_level)
							{
								echo ("<input type='button' value='".af_txt_order_list_2."' onClick=\"alert('".view_order_msg."');\" class='btn_list'>");
							}
							else 
							{
								echo ("<input type='button' value='".af_txt_order_list_2."' onClick=\"javascript:void(window.open('../$view_file?w=820&amp;h=800&amp;mode=admine&amp;order_no=$no','admine_view','width=980,height=820,status=yes,scrollbars=yes,toolbar=no,location=no,resizable=yes'))\" class='btn_list'>");
							}
							if(login_level > modify_order_level)
							{
								if($form_type == "0") echo (" <input type='button' value='".af_txt_order_list_29."' onClick=\"alert('".modify_order_msg."');\" class='btn_list'>");
								if($form_type == "1") echo (" <input type='button' value='".af_txt_order_list_28."' onClick=\"alert('".modify_order_msg."');\" class='btn_list'>");
							}
							else 
							{
								echo $order_modify;
								echo $formmail_modify;
							}
			echo("		</td>
						<td style='text-align:right;border-right:0;' nowrap class='order_list'>");
							if(login_level > send_order_level)
							{
								if($form_type == "0")
								{
								echo (" <input type='button' value='".af_txt_order_list_27."' onclick=\"alert('".send_order_msg."')\" class='btn_esti'><br>
									    <input type='button' value='".af_txt_order_list_1."' onclick=\"alert('".send_order_msg."')\" class='btn_esti'>");
								}
								else
								{
								echo (" <input type='button' value='".af_txt_order_list_26."' onclick=\"alert('".send_order_msg."')\" class='btn_delivery'>");
								}
								
							}
							else 
							{
								echo $estimate_report;
								echo $formmail_reply;
							}
							
			echo("		</td>
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

	$get_pageInja = "";
	$get_pageInja .= "mode=".$_GET['mode']."&amp;code=".$_GET['code']."&amp;desc=".$_GET['desc']."&amp;";
	$get_pageInja .= "mode_key=".$_GET['mode_key']."&amp;situ_key=".$_GET['situ_key']."&amp;";
	$get_pageInja .= "basis_time=".$_GET['basis_time']."&amp;yS=".$_GET['yS']."&amp;mS=".$_GET['mS']."&amp;dS=".$_GET['dS']."&amp;yE=".$_GET['yE']."&amp;mE=".$_GET['mE']."&amp;dE=".$_GET['dE']."&amp;";
	$get_pageInja .= "keywd=".$_GET['keywd']."";	

	echo "<div>";
	if($page > $page_n){ 
		$prev = $over_page * $page_n;
		echo("<a href='".URL."?page=$prev&amp;".$get_pageInja."'><img src='../imgs/btn_pre.gif' align='middle'></a>&nbsp;&nbsp;"); 
	}else{
		echo("<img src='../imgs/btn_pre.gif'  align='middle'>&nbsp;&nbsp;");
	} 


	for($j=0 ; $j < 10 ;$j++){ 
		$link = $j+$page_n*$over_page+1;
		$vlink= $over_page*$page_n+$j+1;
		if($link <= $total_page){
			if($vlink == $page){
				echo("<font color=red>$vlink</font>&nbsp;&nbsp;");
			}else{
				echo("<a href='".URL."?page=$link&amp;".$get_pageInja."'>[$vlink]</a>&nbsp;&nbsp;");
			}
		} 
	} 

	if($total_page > ($over_page+1)*$page_n){
		$next = $over_page*$page_n+$page_n+1;
		echo("<a href='".URL."?page=$next&amp;".$get_pageInja."'><img src='../imgs/btn_next.gif'  align='middle'></a>");
	}else{
		echo("<img src='../imgs/btn_next.gif'  align='middle'>");
	}
	echo "</div>";
} 
?>







<?php
#########################################################################################
########################   selectBox Part1: 폼 선택상자 start    ######################
#########################################################################################

//<option>태그 생성
function f_opt($val,$text,$default="",$head="") {
	        $buf="<option value='$val'";
	        if ($default&&$default==$text) {
	            $buf.="selected ";			
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
    
    $buf="<select 
	    $arr[name]
        $arr[id]
        $arr[style]
		$arr[script]
        $arr[disable]
        >
			<option value=''>".af_txt_selectBox_opt1."</option>
			<option value='".URL."?code=$code&amp;desc=$desc&amp;page=$prev&amp;mode=nameMode&amp;keyword=' selected>".af_txt_order_list_21."</option>
    \n";
    if ($arr["end"]>$arr[start]) {             //숫자 범위 지정시
        for ($i=$arr[start];$i <= $arr["end"];$i++) {
            $buf.=opt($i,$arr["default"],$arr[head]).$i.$arr[tail]."\n";
        }
    } elseif (count($arr[text])) {          
        for ($i=0;$i < count($arr[text]);$i++) {
            $buf.=f_opt($arr[optVal].$arr[na][$i]."&amp;situ_key=".$_GET['situ_key']."&amp;keywd=".$_GET['keywd']."",&$arr[text][$i],$arr["default"],$arr[head]).$arr[tail][$i]."\n";
        }
    }
    
    $buf.="</select>\n";
    return $buf;
}
?>


<?php
#########################################################################################
############  selectBox Part2: DB에서 그룹정보 가져와서 연관배열 만들기	  ###############
#########################################################################################

function f_mkOptArr($form_name){
global $DBconn;
$get_nameModeInja = "";
$get_nameModeInja .= "mode=nameMode&amp;code=".$_GET['code']."&amp;desc=".$_GET['desc']."&amp;";
$get_nameModeInja .= "basis_time=".$_GET['basis_time']."&amp;yS=".$_GET['yS']."&amp;mS=".$_GET['mS']."&amp;dS=".$_GET['dS']."&amp;yE=".$_GET['yE']."&amp;mE=".$_GET['mE']."&amp;dE=".$_GET['dE']."&amp;";

if($_GET['mode_key']) $style = "background-color:#ffff99;width:182px;";
else $style = "width:182px;";

$res=$DBconn->f_selectDB("*",TABLE5,$where);				 //필드, 테이블, 조건절
//$rows = mysql_fetch_array($res[result]);                   //리턴된 배열을 $row에 저장
$res_count=mysql_num_rows($res[result]);                     //리턴된 행의 개수
//리턴행이 여러개일 경우 아래와 같이 for문으로 연관배열화
$no=array();                                                 //배열변수 정의(접수번호)
$na=array();                                                 //배열변수 정의(폼이름)
$ntitle=array();											 //배열변수 정의(폼제목)
	for ($i=0;$i < $res_count;$i++) {                        //불러온 레코드의 수만큼 루프        
        $row=mysql_fetch_array($res[result]);                //배열의 요소들을 $row에 대입	
		$na[$i]=htmlspecialchars(stripslashes($row[name]));                //연관배열 만듬  
		$no[$i]=htmlspecialchars(stripslashes($row[no]));                  //연관배열 만듬
		$ntitle[$i]=htmlspecialchars(stripslashes($row[title_text]));      //연관배열 만듬 
    }	
	//$arr=array("name"=>"comboGroup","id"=>"selectGroup","text"=>&$a);//연관배열 정의 방법1
	$arr=array();                                            //연관배열 정의 방법2
		$arr[head]="";
		$arr[tail]=$ntitle;
		$arr[start]="";
		$arr['end']="";
		$arr['default']="$form_name";                        //디폴트로 선택될 text
		$arr[name]="comboGroup";                             //선택상자 이름
		$arr[id]="";                                         //선택상자 객체 구분 아이디
		$arr[style]=$style;                                  //선택상자 스타일
		$arr[script]="onchange='nameMode(this);'";			 //실행할 스크립트			
		$arr[optVal]=URL."?".$get_nameModeInja."mode_key=";	 //옵션 value
		$arr[no]=$no;                                        //접수번호 
		$arr[na]=$na;                                        //폼이름
		$arr[text]=$na;                                      //실렉트 텍스트 항목 배열
		

echo f_SelectBox ($arr);//f_SelectBox 함수 실행
}
?>
<!--##################################################################################-->
<!--#########################     HTML start     #####################################--> 
<!--##################################################################################-->
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>

<HEAD>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<meta name='robots' content='none,noindex,nofollow'>
<TITLE></TITLE>
<LINK REL="stylesheet" HREF="global.css" TYPE="text/css">

<!--외부 스크립트-->
<script type="text/javascript" src='js/tableruller.js'></script>
<script type="text/javascript" src='js/chk_all.js'></script>
<script type="text/javascript" src='js/chk_delN.js'></script>
<script type="text/javascript" src='js/chk_readN.js'></script>
<script type="text/javascript" src='js/chk_readN_no.js'></script>
<script type="text/javascript" src='js/chkAll_situModify.js'></script>
<script type="text/javascript" src='js/chk_situModify.js'></script>
<script type="text/javascript" src='js/cookie_listN.js'></script>
<!--<script type="text/javascript" src='js/chk_moveN.js'></script>-->

<script type="text/javascript">
<!--
function del_file(del_file_name) 
{	
	var get_inja = "";
	get_inja += "code=<?php echo $_GET['code'];?>&amp;desc=<?php echo $_GET['desc'];?>&amp;";
	get_inja += "mode=<?php echo $_GET['mode'];?>&amp;mode_key=<?php echo $_GET['mode_key'];?>&amp;situ_key=<?php echo $_GET['situ_key'];?>&amp;";
	get_inja += "basis_time=<?php echo $_GET['basis_time'];?>&amp;";
	get_inja += "yS=<?php echo $_GET['yS'];?>&amp;mS=<?php echo $_GET['mS'];?>&amp;dS=<?php echo $_GET['dS'];?>&amp;";
	get_inja += "yE=<?php echo $_GET['yE'];?>&amp;mE=<?php echo $_GET['mE'];?>&amp;dE=<?php echo $_GET['dE'];?>&amp;";
	get_inja += "keywd=<?php echo $_GET['keywd'];?>&amp;";
	get_inja += "page=<?php echo $_GET['page'];?>";

	checking=confirm('선택한 첨부파일을 삭제하시겠습니까?\n\n To delete the selected attach file?');
	if (checking==true)
	{			  
		location.href="<?php echo URL?>?del_file_name="+del_file_name+"&amp;"+get_inja+"";
	}
	else return false;	
}
-->
</script>

<script type="text/javascript">
<!--
//선택상자 항목 선택시 url 이동
function nameMode(x) {
	if(x.selectedIndex !=0){
		location.href=x.options[x.selectedIndex].value;	//불여우에서는 document.location.href(인자);와 같이 사용하면 안됨	
	}
}

//견적서발송 및 새창으로 보기
function esti_newWin(url,mode,mode2,no,email,af_order_no) 
{
	if(mode2 == "")
	{
		window.open(""+url+"?w=730&h=800&mode="+mode+"&order_no="+no+"","admine_view","width=730,height=800,status=yes,scrollbars=yes,toolbar=no,location=yes,resizable=yes");
		}
	else{
	checking=confirm('접수번호 '+af_order_no+' 의 견적서를 고객의 이메일 '+email+' 로 발송하시겠습니까?\n\n Do you want to customer estimate sent?');
		    	if (checking==true)
				{			  
                   window.open(""+url+"?w=730&h=800&mode="+mode+"&mode2="+mode2+"&order_no="+no+"","admine_view","width=730,height=800,status=yes,scrollbars=yes,toolbar=no,location=yes");
				}
				else return false;	
	}
}

//선택한 접수내역 처리상황 변경
function Move(f){
	if (f.comboGroup.options[0].selected) {			//선택행위가 없을 경우 중지
	   alert("선택하여 주십시오.");
	   return false; 
	}
	else{ 											//선택하였을 경우 히든필드에 값입력
	   f.change_no.value = f.comboGroup.options[f.comboGroup.selectedIndex].value;
	   f.submit();									//폼전송
	}
	
}		


//-->
</script>

<!-- 년월일 실렉트  -->
<?php 
	if($_GET['basis_time']) $style_select = "style=\"background-color:#ffff99\"";
?>
<script type="text/javascript">
<!--
function f_daySelect1(y, m, token) { 
	var txt = "";
	var onchangeY = 'onchange="f_daySelect1(this.options[this.selectedIndex].value, document.days_form.mS.options[mS.selectedIndex].value,1)"';	
	var onchangeM = 'onchange="f_daySelect1(document.days_form.yS.options[yS.selectedIndex].value, this.options[this.selectedIndex].value,1)"';
	var selected_y = '';
	var selected_m = '';
	var get_yS = "<?php echo $_GET['yS'];?>";
	var get_mS = "<?php echo $_GET['mS'];?>";
	var get_dS = "<?php echo $_GET['dS'];?>";
	var d = "<?php echo date("d");?>";
	
	if(token != 1)
	{
		if(get_yS) y = get_yS;
		if(get_mS) m = get_mS;
		if(get_dS) d = get_dS;
	}
	
		
		
		//년    
		txt += '<select name="yS" '+onchangeY+' <?php echo $style_select;?>>';
		for (i = 2000; i < 2100; i++) 
		{        
			if (i == y) selected_y = "selected";
				else    selected_y = "";      
		   txt += '<option value="' + i + '" '+selected_y+'>' + i + ''; 
		}
		txt += '<\/select><?php echo af_txt_y;?>';

		//월    
		txt += '<select name="mS" '+onchangeM+' <?php echo $style_select;?>>';
		for (i = 1; i < 13; i++) 
		{        
			if (i == m) selected_m = "selected";
				else    selected_m = "";      
		   txt += '<option value="' + i + '" '+selected_m+'>' + i + ''; 
		}
		txt += '<\/select><?php echo af_txt_m;?>';

		//일
		var dShift1 = (y+(y-y%4)/4-(y-y%100)/100+(y-y%400)/400 
			  +m*2+(m*5-m*5%9)/9-(m<3?y%4||y%100==0&&y%400?2:3:4))%7; 
		txt += '<select name="dS" <?php echo $style_select;?>>';
		for (i = 0; i < 42; i++) 
		{   
			if ((i+1-dShift1) == d) var selected_d = "selected";
							else    var selected_d = ""; 
			if (i < dShift1 || i >= dShift1+(m*9-m*9%8)/8%2+(m==2?y%4||y%100==0&&y%400?28:29:30)) 
				txt += ''; 
			else 
				txt += '<option value="' + (i+1-dShift1) + '" '+selected_d+'>' + (i+1-dShift1) + ''; 
		} 

		txt += '<\/select><?php echo af_txt_d;?> ~ ';
		
    document.getElementById('patchCalendar1').innerHTML = txt + '<\/tr>\n<\/table>'; 
} 

function f_daySelect2(y, m, token) {
	var txt = "";	
	var onchangeY = 'onchange="f_daySelect2(this.options[this.selectedIndex].value, document.days_form.mE.options[mE.selectedIndex].value,1)"';
	var onchangeM = 'onchange="f_daySelect2(document.days_form.yE.options[yE.selectedIndex].value, this.options[this.selectedIndex].value,1)"';
	var selected_y = '';
	var selected_m = '';
	var get_yE = "<?php echo $_GET['yE'];?>";
	var get_mE = "<?php echo $_GET['mE'];?>";
	var get_dE = "<?php echo $_GET['dE'];?>";
	var d = "<?php echo date("d");?>";
	
	if(token != 1)
	{
		if(get_yE) y = get_yE;
		if(get_mE) m = get_mE;
		if(get_dE) d = get_dE;
	}
		
		
		//년    
		txt += '<select name="yE" '+onchangeY+' <?php echo $style_select;?>';
		for (i = 2000; i < 2100; i++) 
		{        
			if (i == y) selected_y = "selected";
				else    selected_y = "";      
		   txt += '<option value="' + i + '" '+selected_y+'>' + i + ''; 
		}
		txt += '<\/select><?php echo af_txt_y;?>';

		//월    
		txt += '<select name="mE" '+onchangeM+' <?php echo $style_select;?>>';
		for (i = 1; i < 13; i++) 
		{        
			if (i == m) selected_m = "selected";
				else    selected_m = "";      
		   txt += '<option value="' + i + '" '+selected_m+'>' + i + ''; 
		}
		txt += '<\/select><?php echo af_txt_m;?>';

		//일
		var dShift1 = (y+(y-y%4)/4-(y-y%100)/100+(y-y%400)/400 
			  +m*2+(m*5-m*5%9)/9-(m<3?y%4||y%100==0&&y%400?2:3:4))%7; 
		txt += '<select name="dE" <?php echo $style_select;?>>';
		for (i = 0; i < 42; i++) 
		{   
			if ((i+1-dShift1) == d) var selected_d = "selected";
							else    var selected_d = ""; 
			if (i < dShift1 || i >= dShift1+(m*9-m*9%8)/8%2+(m==2?y%4||y%100==0&&y%400?28:29:30)) 
				txt += ''; 
			else 
				txt += '<option value="' + (i+1-dShift1) + '" '+selected_d+'>' + (i+1-dShift1) + ''; 
		} 

		txt += '<\/select><?php echo af_txt_d;?>';
		
    document.getElementById('patchCalendar2').innerHTML = txt + '<\/tr>\n<\/table>'; 
} 
-->
</script>

<script type="text/javascript">
<!--
function null_chk(f)
{
	if(!f.keywd.value)
	{
		alert('<?php echo af_txt_alertNull;?>');
		f.keywd.focus();
	}
	else f.submit();
}
-->
</script>

<!-- 달력 스크립트 -->
<script type="text/javascript">
<!--
function calendar1(f,mode)
{
	//버튼클릭에 의한 이전달,년도 이후달,년도 구하기
	var Y1 = f.y.value;  
	var M1 = f.m.value;

	Y1 = Number(Y1);
	M1 = Number(M1);

	if(mode == "before")
	{
		if(M1 == 1) 
		{
			f.y.value = Y1-1;
			f.m.value = M1+11;
		}
		else 
		{
			f.y.value = Y1;
			f.m.value = M1-1;
		}
		
	}
	if(mode == "after")
	{
		if(M1 == 12) 
		{
			f.y.value = Y1+1;
			f.m.value = M1-11;
		}
		else 
		{
			f.y.value = Y1;
			f.m.value = M1+1;
		}			
	}	

	//f_jsCalendar_thumb 함수에 건네줄 변수 설정
	var cStamp = "<?php echo time();?>";
	var y = f.y.value;
	var m = f.m.value;
	var nd = new Date(y,m,1,0,0,0);
	var eMonth = new Array("Dec","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov");
	var phpM = eMonth[nd.getMonth()]; //달력상단에 표시될 영문 월표시	
	var phpD = "<?php echo date('j');?>";
	var zone = "c1";

	f_jsCalendar_thumb(cStamp,y,m,phpM,phpD,zone) 
	//f.submit();
}

function f_jsCalendar_thumb(cStamp,y,m,phpM,phpD,zone) 
{ 
	//var y = new Date(Stamp*1000).getFullYear();
	//var m = new Date(Stamp*1000).getMonth()+1;
	var thisY = new Date().getFullYear();
	var thisM = new Date().getMonth()+1;
	var cY = new Date(cStamp*1000).getFullYear();
	var cM = new Date(cStamp*1000).getMonth()+1;
	var cD = new Date(cStamp*1000).getDate();

	var bg_color = "background-color:#fff;";
	if(y == thisY && m == thisM) bg_color = "background-color:#fff;";
	else bg_color = "background-color:#fff;";

	var bg_img = "background-image:url(img/"+m+".gif);background-repeat:no-repeat;background-position:center 45px;";
	var border1 = "border:1px solid #d9d5d9;";
	var bgcolorYoil = "background-color:#b5cad6;";

	var txt = '<table class="calendar_thumb" style="'+bg_color+bg_img+'" >';
	txt += '<tr>';	
	txt += '<td style="padding:2px;background-color:#aec7eb;'+border1+'" colspan="7">';
	txt += '<table><tr>';
	txt += '<td style="font-weight:bold;text-align:left;">';
    txt += '<span style="font-size:15px;">' + ((m < 10) ? ( + m) : m) + '<\/span> ' + phpM +' <span style="color:#004a84;">'+ y + '<\/span>';
	txt += '<\/td>';
	txt += '<td style="text-align:right">';
	txt += "<img src='img/before.gif' onclick='calendar1(document.calendar1_form,\"before\");' style='vertical-align:middle;cursor:hand;' alt='이전달'>";
	txt += " <img src='img/after.gif' onclick='calendar1(document.calendar1_form,\"after\");' style='vertical-align:middle;cursor:hand;' alt='이후달'>";
	txt += " <img src='img/today.gif' onclick='document.location.href=\"addform_order_list.php\";' style='vertical-align:middle;cursor:hand;' alt='오늘'>";
	txt += '<\/td>';
	txt += '<\/tr><\/table>';
	//txt += '<hr size="1" style="color:#ccc;">';
    txt += '<\/td>'; 
	txt += '<\/tr>';
	txt += '<tr>';
	txt += '<td style="'+border1+bgcolorYoil+'color:#cc0000;">일<\/td>';
	txt += '<td style="'+border1+bgcolorYoil+'">월<\/td>';
	txt += '<td style="'+border1+bgcolorYoil+'">화<\/td>';
	txt += '<td style="'+border1+bgcolorYoil+'">수<\/td>';
	txt += '<td style="'+border1+bgcolorYoil+'">목<\/td>';
	txt += '<td style="'+border1+bgcolorYoil+'">금<\/td>';
	txt += '<td style="'+border1+bgcolorYoil+'">토<\/td>';

    var dShift1 = (y+(y-y%4)/4-(y-y%100)/100+(y-y%400)/400+m*2+(m*5-m*5%9)/9-(m<3?y%4||y%100==0&&y%400?2:3:4))%7;	

    for (i = 0; i < 42; i++) 
	{ 
		var font_Style = "";
		if (i%7==0) txt += '<\/tr><tr>'; 
        if (i < dShift1 || i >= dShift1+(m*9-m*9%8)/8%2+(m==2?y%4||y%100==0&&y%400?28:29:30)) 
		{txt += '<td style="background-color:#e7e3e7;"><\/td>';} 
        else			
		{
			//var todayTxt = String(thisY)+String(thisM)+phpD;					//오늘 년월일
			var cTxt = String(cY)+String(cM)+String(cD);						//선택한 년월일
			var iTxt = String(y)+String(m)+(i+1-dShift1);						//달력의 년월일
			var bTxt = String("<?php echo $_GET['yE'];?>")+String("<?php echo $_GET['mE'];?>")+String("<?php echo $_GET['dE'];?>");	//브라우저 년월일
			/*if(todayTxt == iTxt)
			{																	//오늘날짜일 경우
				font_Style = "style='color:red;background-color:yellow;text-decoration:underline;'";
			}*/
			if(cTxt == iTxt)
			{																	//오늘 날짜일 때
				font_Style = "style='background-color:#669999;color:#fff;'";
			}
			if(bTxt == iTxt)
			{																	//선택한 날짜일 때
				font_Style = "style='background-color:yellow;text-decoration:underline;'";
			}
		txt += "<td style='border:1px solid #d9d5d9;'><a href='javascript:document.location.href=\"<?php echo URL;?>?mode=between&basis_time=input_date&yS="+y+"&mS="+m+"&dS="+ (i+1-dShift1) +"&yE="+y+"&mE="+m+"&dE="+ (i+1-dShift1) +"\"' " + (i%7 ? "" : " style='color:#cc0000;' "+font_Style+"") + " "+font_Style+">" + (i+1-dShift1) + "<\/a><\/td>";
		}			
    } 

	txt += '<\/tr>';
	txt += '<\/table>';
    document.getElementById(""+zone+"").innerHTML = txt; 
} 
-->
</script>


</HEAD>

<BODY onload="f_daySelect1(<?php echo date("Y");?>,<?php echo date("m");?>);f_daySelect2(<?php echo date("Y");?>,<?php echo date("m");?>);tableruler();f_jsCalendar_thumb(<?php echo time();?>,<?php if($_GET['yE']) echo $_GET['yE']; else echo date("Y");?>,<?php if($_GET['mE']) echo $_GET['mE']; else echo date("n");?>,'<?php echo date("M");?>','<?php echo date('j');?>','c1');">
	<DIV ID="mainDiv" style="background-image:url(img/bg_f11.gif);background-repeat:no-repeat;background-position:right top;">
		<TABLE id="order_list_tbl">
			<TR>
				<TD style="text-align:left;width:150px;" valign="top">
					<!--//////////////////////////////////////////////////////////////////////////-->
					<!--###########################     처리상황 구역     ########################--> 
					<!--//////////////////////////////////////////////////////////////////////////-->
					<div id="order_summary">			
						<fieldset style="margin-top:0;padding-top:0;">
							<legend style="padding:10px;">처리상황</legend>	
							<ul>
								<li style="padding:0;border:0;padding-bottom:10px;">
									<input type='button' value="<?php echo af_txt_order_list_5;?>" onclick="window.open('situation_modify.php?w=600&amp;h=500','addsituation','width=600,height=500,toolbar=no,scrollbars=yes')" style="width:130px;" class="btn_big_main">
								</li>
								<li onmouseover="this.style.backgroundColor='#c4e4a5'" onmouseout="this.style.backgroundColor='#ccc'" onclick="document.location.href='<?php echo URL;?>'" style="background-color:#ccc;cursor:hand;"><?php echo af_txt_order_list_4;?><?php F_resCount("*",TABLE4,"");?></li>
								<?php 
								for ($i=0;$i<count($arr_situation);$i++) {?>	
									
									<?php $z = $i+1;
									$get_situInja = "";
									$get_situInja .= "mode=situation&amp;code=".$_GET['code']."&amp;desc=".$_GET['desc']."&amp;";
									$get_situInja .= "mode_key=".$_GET['mode_key']."&amp;situ_key=".$z."&amp;";
									$get_situInja .= "basis_time=".$_GET['basis_time']."&amp;yS=".$_GET['yS']."&amp;mS=".$_GET['mS']."&amp;dS=".$_GET['dS']."&amp;yE=".$_GET['yE']."&amp;mE=".$_GET['mE']."&amp;dE=".$_GET['dE']."&amp;";
									$get_situInja .= "keywd=".$_GET['keywd']."";	
									?>
									<?php 
										if($_GET['situ_key'] == $z) 
											{
												$style_situLi = "background-color:".$arr_situation_color[$i].";cursor:hand;";
												$bgstyle_situLi = "background-image:url(img/search_on.gif);background-repeat:no-repeat; background-position:right center;";												
												$onevent = "";
											}
										else 
											{
												$style_situLi = "background-color:".$arr_situation_color[$i].";cursor:hand;";
												$bgstyle_situLi = "";
												$onevent = "onmouseover='this.style.backgroundColor=\"#c4e4a5\"' onmouseout='this.style.backgroundColor=\"".$arr_situation_color[$i]."\"'";											
											}
									?>
									<li style="<?php echo $bgstyle_situLi.$style_situLi;?>" <?php echo $onevent;?> onclick="document.location.href='<?php echo URL."?".$get_situInja;?>'">
										<!--<a href="<?php echo URL."?".$get_situInja;?>">-->
											<?php echo $arr_situation[$i];?>
											<span class="link"><?php F_resCount("situation",TABLE4,"where situation=$z");?></span>
										<!--</a>-->	
									</li>			
								 <? } ?>
								 
							</ul>
						</fieldset>			
					</div>					
					<!-- 달력 -->
					<div id="calendar1div">	
						<form NAME="calendar1_form" METHOD="post" ACTION="<?php echo URL;?>" style="margin:0;padding:o;">
						<input type="hidden" name="y" value="<?php if($_GET['yE']) echo $_GET['yE']; else echo date("Y");?>">
						<input type="hidden" name="m" value="<?php if($_GET['mE']) echo $_GET['mE']; else echo date("n");?>">
							<table id="calendar1tbl">						
								<tr>				
									<td id="c1" valign="top">
									
									</td>				
								</tr>			
							</table>
						</form>		
					</div>
				</TD>
				<TD style="text-align:left;padding-left:10px;" valign="top">		
					<div id="order_list">
						<!--//////////////////////////////////////////////////////////////////////-->
						<!--###########################     검색조회 구역     ####################--> 
						<!--//////////////////////////////////////////////////////////////////////-->
						<fieldset style="margin-top:0;">
							<LEGEND>검/색/조/건</LEGEND>
							<table border="0">								
								<tr>
									<td style="text-align:left;" nowrap> 
										<!-- 폼 선택 -->
										<form NAME="form1" action="" style="float:left;margin:6px 10px 0 0;padding:0;" >
											<?php echo f_mkOptArr($_GET['mode_key']);?>
										</form>					
										<!-- 검색 필드 -->
										<form NAME="search_form" METHOD="get" ACTION="<?php echo URL;?>" style="margin:0;padding:0;margin-top:5px;" >			
											<input TYPE="hidden" NAME="code" VALUE="no"> 
											<input TYPE="hidden" NAME="desc" VALUE="desc">
											<input TYPE="hidden" NAME="mode" VALUE="search_form">
											<input TYPE="hidden" NAME="mode_key" VALUE="<?php echo $_GET['mode_key']?>"> 
											<input TYPE="hidden" NAME="situ_key" VALUE="<?php echo $_GET['situ_key']?>">	
											<INPUT TYPE="hidden" NAME="basis_time" VALUE="<?php echo $_GET['basis_time'];?>">
											<INPUT TYPE="hidden" NAME="yS" VALUE="<?php echo $_GET['yS'];?>"> 
											<INPUT TYPE="hidden" NAME="mS" VALUE="<?php echo $_GET['mS'];?>"> 
											<INPUT TYPE="hidden" NAME="dS" VALUE="<?php echo $_GET['dS'];?>"> 
											<INPUT TYPE="hidden" NAME="yE" VALUE="<?php echo $_GET['yE'];?>"> 
											<INPUT TYPE="hidden" NAME="mE" VALUE="<?php echo $_GET['mE'];?>"> 
											<INPUT TYPE="hidden" NAME="dE" VALUE="<?php echo $_GET['dE'];?>">
											<input TYPE="text" NAME="keywd" VALUE="<?php echo $_GET['keywd']?>" style='color:blue;font-weight:bold;width:158px;'>					 
											<INPUT TYPE="submit" VALUE="<?php echo af_txt_search;?>">					
										</form>
									
										<!-- 기간 검색  -->
										<?php 
										if($_GET['basis_time']) $style_basis = "style = 'background-color:#ffff99;' ";
										if($_GET['basis_time'] == "reserver_time") $selected_basis0 = "selected" ;
										if($_GET['basis_time'] == "input_date") $selected_basis1 = "selected" ;
										?>
										<form NAME="days_form" METHOD="get" ACTION="<?php echo URL;?>" style="margin:5px 0 0 0;padding:0;">
											<input TYPE="hidden" NAME="code" VALUE="no">
											<input TYPE="hidden" NAME="desc" VALUE="desc">
											<input TYPE="hidden" NAME="mode" VALUE="between">
											<input TYPE="hidden" NAME="mode_key" VALUE="<?php echo $_GET['mode_key'];?>">
											<input TYPE="hidden" NAME="situ_key" VALUE="<?php echo $_GET['situ_key'];?>">
											<input TYPE="hidden" NAME="keywd" VALUE="<?php echo $_GET['keywd'];?>">
											<ul>
											<li style="display:inline;">									
												<!-- 아래 히든필드 애드타임에서는 select box로 구현 -->
												<input type="hidden" name="basis_time" value="input_date">					
											 </li>
											 <li style="display:inline;" id="patchCalendar1">
											 </li>
											 <li style="display:inline;" id="patchCalendar2">
											 </li>		 
											 <li style="display:inline;">
												<input type="submit" value="<?php echo af_txt_search;?>">
											 </li>
											</ul>			
										</form>	
									</td>
									<td style="text-align:right;" nowrap>
										<input type="button" value="페이지 갱신" onClick="javascript:void(document.location.href='addform_order_list.php')" class="btn_big_main" style="width:115px;">
										<input type="button" value="<?php echo af_txt_order_list_15;?>" onClick="javascript:void(window.open('dump_odlist.php?w=500&amp;h=700','backup','width=500,height=700,statusbar=no,scrollbars=yes,toolbar=no,menubar=no'))" class="btn_big_main" style="width:115px;">	
									</td>
								</tr>
							</table>
						</FIELDSET>


						<FORM NAME="chk_box" METHOD="POST" ACTION="<?php echo URL;?>"  style="margin:0;padding:0;" />
						<!-- del 모드시 참고될 get 인자들  -->
						<input type="hidden" name="mode" value="del">
						<input type="hidden" name="page" value="<?php echo $_GET['page'];?>">
						<INPUT TYPE="hidden" NAME="code" VALUE="<?php echo $_GET['no'];?>"> 
						<INPUT TYPE="hidden" NAME="desc" VALUE="<?php echo $_GET['desc'];?>">
						<input type="hidden" name="prev_mode" value="<?php echo $_GET['mode'];?>">
						<INPUT TYPE="hidden" NAME="mode_key" VALUE="<?php echo $_GET['mode_key'];?>"> 
						<INPUT TYPE="hidden" NAME="situ_key" VALUE="<?php echo $_GET['situ_key'];?>"> 
						<INPUT TYPE="hidden" NAME="basis_time" VALUE="<?php echo $_GET['basis_time'];?>">
						<INPUT TYPE="hidden" NAME="yS" VALUE="<?php echo $_GET['yS'];?>"> 
						<INPUT TYPE="hidden" NAME="mS" VALUE="<?php echo $_GET['mS'];?>"> 
						<INPUT TYPE="hidden" NAME="dS" VALUE="<?php echo $_GET['dS'];?>"> 
						<INPUT TYPE="hidden" NAME="yE" VALUE="<?php echo $_GET['yE'];?>"> 
						<INPUT TYPE="hidden" NAME="mE" VALUE="<?php echo $_GET['mE'];?>"> 
						<INPUT TYPE="hidden" NAME="dE" VALUE="<?php echo $_GET['dE'];?>"> 
						<INPUT TYPE="hidden" NAME="page" VALUE="<?php echo $_GET['page'];?>"> 

						<input type="hidden" name="keywd" value="<?php echo $_GET['keywd'];?>">
						<input type="hidden" name="change_no" value="">

						<!--//////////////////////////////////////////////////////////////////////-->
						<!--###########################     접수내역 구역     ####################--> 
						<!--//////////////////////////////////////////////////////////////////////-->
						<FIELDSET>
							<LEGEND><?php echo af_txt_order_list_7;?></LEGEND> 
							<!-- 검색조건 표시 테이블 -->
							<table>
								<tr>
									<td style="width:50%;text-align:left;font-size:11px;" nowrap>
										<?php if(!$_GET[mode_key] && !$_GET[situ_key] && !$_GET[basis_time]) echo '<img src="img/search_on.gif" style="vertical-align:middle;">'; else echo  '<img src="img/search_off.gif" style="vertical-align:middle;">';?> <?php echo af_txt_order_list_21;?>&nbsp;&nbsp; 
										<?php if($_GET[mode_key]) echo '<img src="img/search_on.gif" style="vertical-align:middle;">'; else echo  '<img src="img/search_off.gif" style="vertical-align:middle;">';?> <?php echo af_txt_order_list_24;?>&nbsp;&nbsp;
										<?php if($_GET[situ_key]) echo '<img src="img/search_on.gif" style="vertical-align:middle;">'; else echo  '<img src="img/search_off.gif" style="vertical-align:middle;">';?> <?php echo af_txt_order_list_25;?>&nbsp;&nbsp;
										<?php if($_GET[basis_time]) echo '<img src="img/search_on.gif" style="vertical-align:middle;">'; else echo  '<img src="img/search_off.gif" style="vertical-align:middle;">';?> <?php echo af_txt_order_list_22;?>&nbsp;&nbsp;
										에서 <span style="color:red"><?php echo $res_count;?></span> 건 
										<select name="change_listN" onchange="change_cookie(this.form,this.options[this.selectedIndex].value);">
											<?php 
											for($i=1;$i < 501;$i++)
											{
												$list_select = "";
												if($_COOKIE[af_odlistN])
												{
													if($_COOKIE[af_odlistN] == $i) $list_select = "selected";
												}
												else
												{
													if($records == $i) $list_select = "selected";
												}
												echo "<option value='$i' $list_select>$i</option>";
											}
											?>
										</select> 개씩 보기
									</td>	
									<td style="text-align:right;padding-top:10px;font-size:11px;">
										<?php echo af_txt_order_list_16;?> <span style="color:blue"><?php echo number_format($af_dir_upload["totalsize"]/1024/1024,2);?></span> Mbyte <?php echo af_txt_order_list_17;?>			
									</td>	
								</tr>
							</table>
							<!-- 접수내역 테이블 -->
							<TABLE summary="접수리스트 출력및 관리 테이블" class="ruler" style="margin:0;padding:0;">				  
							<?php 
								$get_inja = "";
								$get_inja .= "".$_GET['mode']."&amp;mode_key=".$_GET['mode_key']."&amp;situ_key=".$_GET['situ_key']."&amp;";
								$get_inja .= "basis_time=".$_GET['basis_time']."&amp;yS=".$_GET['yS']."&amp;mS=".$_GET['mS']."&amp;dS=".$_GET['dS']."&amp;yE=".$_GET['yE']."&amp;mE=".$_GET['mE']."&amp;dE=".$_GET['dE']."&amp;";
								$get_inja .= "keywd=".$_GET['keywd']."&amp;";	
								//$get_inja .= "page=".$_GET['page']."";
								?>
							<thead>
								<tr>
									<th nowrap class="order" scope="col" style='width:20px'><input type=button value="all" onfocus="this.blur()" onClick="this.value=chk_all(this.form)"></th>
									<th nowrap class="order" scope="col" style="display:none;">no
										&nbsp;
									</th>
									<th nowrap class="order" scope="col"><?php echo af_txt_order_list_9;?>
										<a href="<?php echo URL;?>?code=client_name&amp;desc=asc&amp;mode=<?php echo $get_inja;?>"><img src="img/asc.gif" style="vertical-align:middle"></a><a href="<?php echo URL;?>?code=client_name&amp;desc=desc&amp;mode=<?php echo $get_inja;?>"><img src="img/desc.gif" style="vertical-align:middle"></a>			
									</th>
									<th nowrap class="order" scope="col">
										<?php echo af_txt_order_list_8;?> <a href="<?php echo URL;?>?code=mom&amp;desc=asc&amp;mode=<?php echo $get_inja;?>"><img src="img/asc.gif" style="vertical-align:middle"></a><a href="<?php echo URL;?>?code=mom&amp;desc=desc&amp;mode=<?php echo $get_inja;?>"><img src="img/desc.gif" style="vertical-align:middle"></a><br>
										접수번호 <a href="<?php echo URL;?>?code=no&amp;desc=asc&amp;mode=<?php echo $get_inja;?>"><img src="img/asc.gif" style="vertical-align:middle;margin:0;"></a><a href="<?php echo URL;?>?code=no&amp;desc=desc&amp;mode=<?php echo $get_inja;?>"><img src="img/desc.gif" style="vertical-align:middle;margin:0;"></a>
									</th>
									
									<th nowrap class="order" scope="col"><?php echo af_txt_order_list_10;?>
										<a href="<?php echo URL;?>?code=input_date&amp;desc=asc&amp;mode=<?php echo $get_inja;?>"><img src="img/asc.gif" style="vertical-align:middle"></a><a href="<?php echo URL;?>?code=input_date&amp;desc=desc&amp;mode=<?php echo $get_inja;?>"><img src="img/desc.gif" style="vertical-align:middle"></a>
									</th>
									<th nowrap class="order" scope="col"><?php echo af_txt_order_list_11;?>
										<a href="<?php echo URL;?>?code=situation&amp;desc=asc&amp;mode=<?php echo $get_inja;?>"><img src="img/asc.gif" style="vertical-align:middle"></a><a href="<?php echo URL;?>?code=situation&amp;desc=desc&amp;mode=<?php echo $get_inja;?>"><img src="img/desc.gif" style="vertical-align:middle"></a>
									</th>
									<th nowrap class="order" scope="col">file</th>
									<th nowrap class="order" scope="col" style='text-align:center;width:160px;'><?php echo af_txt_order_list_2;?></th>
									<th nowrap class="order" scope="col" style='text-align:center;width:70px;'><?php echo af_txt_order_list_12;?></th>
								 </tr>
							</thead>

							<tbody>	

								<?php echo f_loopRec();?>

							</tbody>

							<tfoot class="noborder">
								<tr>
									<td colspan="7"></td>
								</tr>
							</tfoot>

							</TABLE>

							<div style="margin:10px;text-align:center;">
								<?php echo f_pageDiv();?> 
							</div>
						</FIELDSET>
						
						<!--//////////////////////////////////////////////////////////////////////-->
						<!--###########################     삭제/상황변경     ####################--> 
						<!--//////////////////////////////////////////////////////////////////////-->
						<FIELDSET>
							<LEGEND><?php echo af_txt_order_list_13;?></LEGEND>				
							<ul style="margin:10px;">
								<li style="display:inline;margin-right:20px;">	
									<INPUT TYPE="button" NAME="del" VALUE="<?php echo af_txt_del;?>" onclick="chk_delN(this.form,<?php echo login_level;?>,<?php echo del_order_level;?>,'<?php echo del_order_msg;?>')" class="btn_del">
									<INPUT TYPE="button" NAME="read" VALUE="<?php echo af_txt_order_list_31;?>" onclick="chk_readN(this.form,<?php echo login_level;?>,<?php echo read_order_level;?>,'<?php echo read_order_msg;?>')" class="btn_read">
									<INPUT TYPE="button" NAME="read_no" VALUE="<?php echo af_txt_order_list_32;?>" onclick="chk_readN_no(this.form,<?php echo login_level;?>,<?php echo read_order_level;?>,'<?php echo read_order_msg;?>')" class="btn_read_no">
								</li>
								<li style="display:inline;padding-left:20px;">  
									<?php echo af_txt_order_list_14;?> <?php f_mkOptArr_situ("comboSituFoot","","");?><INPUT TYPE="button" NAME="situModify" VALUE="<?php echo af_txt_confirm;?>" onclick="chkAll_situModify(this.form,<?php echo login_level;?>,<?php echo situModify_level;?>,'<?php echo situModify_msg;?>')"> 
								</li>								
							</ul>
						</FIELDSET>
							
					</div>
				</TD>				
			</TR>
		</TABLE>
	</DIV>
</BODY>
</HTML>
