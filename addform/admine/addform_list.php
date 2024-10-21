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


$records = '10';			// 한 화면에 뿌려질 레코드 수
$page_n = '10';				// 하단 페이지 리스트 수
?>

<?php

#########################################################################################
###########################     선택한 애드폼 삭제 start     ############################
#########################################################################################

if($_POST['mode']=="del") 
{
		echo f_del($_POST['chk_list']);						//$chk_list인자는 선택한 체크박스 배열
}

function f_del($no)
{															//선택폼 삭제 함수 start
	global $DBconn;
	$prev_mode = $_POST['prev_mode'];
	$code = $_POST['code'];
	$desc = $_POST['desc'];
	$page = $_POST['page'];	
	$keywd = $_POST['keywd'];	

	$n = count($no);										//전달받은 배열의 크기

	for($i=0;$i < $n;$i++)
		{
			$where="where name='$no[$i]'";							//no필드대신 name필드를 조건하였고 문자형이므로 작은따옴표 붙임에 주의
			$DBconn->f_deleteTable(TABLE5,$where);					//테이블, 조건절
			mysql_query("drop table ".db_tblname."_$no[$i]_item");	//폼이 생성되면서 같이 만들어진 품목 테이블도 삭제
			$af_arr_format = array("jpg","jpeg","gif");			    //업로드 된 폼이미지들 허용확장자(form_add.php 참조)
			for($f = 0;$f < count($af_arr_format);$f++)				//폼 썸네일,상하단 배너 이미지 삭제
				{
				@unlink("../upload/".$no[$i]."/thumb.".$af_arr_format[$f]."");
				@unlink("../upload/".$no[$i]."/top_img.".$af_arr_format[$f]."");
				@unlink("../upload/".$no[$i]."/bottom_img.".$af_arr_format[$f]."");
				@unlink("../upload/".$no[$i]."/btn_submit.".$af_arr_format[$f]."");
				@unlink("../upload/".$no[$i]."/btn_estimate.".$af_arr_format[$f]."");
				@unlink("../upload/".$no[$i]."/btn_submit.".$af_arr_format[$f]."");
				@unlink("../upload/".$no[$i]."/btn_retry.".$af_arr_format[$f]."");
				}

			for($x = 0;$x < 100;$x++)								//폼 물품상세이미지와 txt 파일 모두 삭제
				{
				for($f = 0;$f < count($af_arr_format);$f++)				
					{
					@unlink("../upload/".$no[$i]."/".$x.".".$af_arr_format[$f]."");	
					@unlink("../upload/".$no[$i]."/".$x.".txt");
					}		
				}
	@unlink("../upload/".$no[$i]."/float.txt");				//float 속성 파일도 삭제
	@unlink("../upload/".$no[$i]."/formStyle.css");			//사용자스타일 속성 파일도 삭제(pro)
	rmdir("../upload/".$no[$i]);							//폼 이미지업로드 폴더도 삭제(파일이 존재시 false이므로 모두 비운 후 삭제)						
		}
	 die("<meta http-equiv=refresh content='0;url=".URL."?mode=$prev_mode&amp;code=$code&amp;desc=$desc&amp;page=$page&amp;keywd=$keywd'>");	//쿼리실행 후 문서 고침
}

#########################################################################################
###########################     구간카운터 재설정 start     ############################
#########################################################################################

if($_POST['mode']=="count_zero") 
{
		echo f_count_zero($_POST['chk_list']);				//$chk_list인자는 선택한 체크박스 배열
}

function f_count_zero($no)
{															//선택폼 구간카운터 재설정 start
	global $DBconn;
	$prev_mode = $_POST['prev_mode'];
	$code = $_POST['code'];
	$desc = $_POST['desc'];
	$page = $_POST['page'];	
	$keywd = $_POST['keywd'];	

	$n = count($no);										//전달받은 배열의 크기
	$where = "";
	$clean=array();	
	$clean['dummy9'] = "0";									//구간카운터 필드를 0으로	
	
	for($i=0;$i < $n;$i++)
		{
			$where="where name='$no[$i]'";					//no필드대신 name필드를 조건하였고 문자형이므로 작은따옴표 붙임에 주의
			$DBconn->f_updateDB(TABLE5,$clean,$where);		//$clean 배열이 하나이므로, 여기서는 참조연산자&$clean로 넘기면 안됨					
		}
	 die("<meta http-equiv=refresh content='0;url=".URL."?mode=$prev_mode&amp;code=$code&amp;desc=$desc&amp;page=$page&amp;keywd=$keywd'>");	//쿼리실행 후 문서 고침
}


#########################################################################################
############     사용자가 검색을 실행할 경우 $where 검색조건 정의 start     #############
#########################################################################################

if($_POST['mode'] == "search_form" or $_GET['mode'] == "search_form"){
	$keywd="";
	$keywd = $_GET['keywd'].$_POST['keywd']; 

	$vowels = array("'","\"");								//제거할 특수문자 배열
	$keywd = str_replace($vowels, "", $keywd);				//인용부호 제거    	
	
	if($keywd) {											//검색키워드가 있을때			
		$where = " where name like '%$keywd%' ";			//폼이름 검색
		$where .= "or no like '%$keywd%' ";					//폼번호 검색
		$where .= "or no_group like '%$keywd%' ";			//그룹번호 검색		
		$where .= "or title_text like '%$keywd%' ";			//폼제목 검색
		$where .= "or msg_top like '%$keywd%' ";			//상단글 검색
		$where .= "or msg_bottom like '%$keywd%' ";			//하단글 검색
		$where .= "or email_address like '%$keywd%' ";		//관리자 이메일 검색
		$where .= "or supply_name like '%$keywd%' ";		//사업자상호 검색
		$where .= "or supply_man like '%$keywd%' ";			//사업자대표 검색
		$where .= "or supply_address like '%$keywd%' ";		//사업장주소 검색
		$where .= "or supply_conditions like '%$keywd%' ";	//업태 검색
		$where .= "or supply_item like '%$keywd%' ";	    //종목 검색
		$where .= "or banking like '%$keywd%' ";			//계좌번호 검색
		$where .= "or etc like '%$keywd%' ";				//비고 검색
	}
}



#########################################################################################
#######  선택상자에서 그룹을 선택하였을 경우 $where 검색조건 정의 start    ##############
#########################################################################################

else if($_GET['mode'] == "groupMode"){
	$keywd="";
	$keywd = $_GET['keywd'].$_POST['keywd'];

	$vowels = array("'","\"");							//제거할 특수문자 배열
	$keywd = str_replace($vowels, "", $keywd);			//인용부호 제거
    
	if($keywd) {										//검색키워드가 있을때			
		$where = " where no_group like '%$keywd%' ";		   
	}			
}



#########################################################################################
##########################    검색이 아닌 초기접속시 $where 정의 start     ##############
#########################################################################################

else{
	$where = "";

	}
///////DB에서 가져오기///////
$res=$DBconn->f_selectDB("*",TABLE5,$where);  //필드, 테이블, 조건절
//$rows = mysql_fetch_array($res[result]);   //리턴된 배열을 $row에 저장
$res_count=mysql_num_rows($res[result]);     //리턴된 행의 개수



#########################################################################################
#################################      페이지 나누기 start      #########################
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
###################################     레코드 배열 출력함수 start     ##################
#########################################################################################

function f_loopRec(){
	$code = $_GET['code'];
	$desc = $_GET['desc'];
	global $where;
	global $start;
	global $end;
	for($i= $start ; $i < $end ; $i++){	
		if(!$code) $code="no"; else $code=$code; 
		if(!$desc) $desc="desc"; else $desc=$desc;
		//$code="no";                                //no필드를 기준으로 정렬

	    $load = "select * from ".db_tblname."_table";
		$load .= $where;//검색조건
		$load .= " order by $code $desc ";           //정렬조건 desc 는 내림차순, asc 는 오름차순
		$load .= " limit $i,1 ";                     //한페이지에 출력될 수 제한(while문 무한루프돌지 않게)
		$result = mysql_query($load);
		$rows = mysql_num_rows($result);

		if($rows){
	while($row = mysql_fetch_array($result)){
		$no = htmlspecialchars(stripslashes($row["no"]));                                  //고유번호
		$no_group = htmlspecialchars(stripslashes($row["no_group"]));                      //속할 그룹번호
		$form_type = htmlspecialchars(stripslashes($row["form_type"]));                    //폼형식
		$input_date = htmlspecialchars(stripslashes($row["input_date"]));                  //생성시각
		$edit_date = htmlspecialchars(stripslashes($row["edit_date"]));                    //수정시각
		$name = htmlspecialchars(stripslashes($row["name"]));                              //주문폼		
		$title_text = htmlspecialchars(stripslashes($row["title_text"]));                  //테이블 타이틀 텍스트
		$coin_unit = htmlspecialchars(stripslashes($row["coin_unit"]));                    //통화단위
		$secret_price = htmlspecialchars(stripslashes($row["secret_price"]));              //산출금액 비밀 여부		
		$email_address = htmlspecialchars(stripslashes($row["email_address"]));            //관리자 이메일
		$tel = htmlspecialchars(stripslashes($row["tel"]));                                //전화번호(공급자)
		$supply_name = htmlspecialchars(stripslashes($row["supply_name"]));                //사업자상호(공급자)
		$supply_num =htmlspecialchars(stripslashes( $row["supply_num"]));                  //사업자등록번호(공급자)
		$supply_man = htmlspecialchars(stripslashes($row["supply_man"]));                  //사업자대표(공급자)
		$supply_address = htmlspecialchars(stripslashes($row["supply_address"]));          //사업장주소(공급자)
		$supply_conditions = htmlspecialchars(stripslashes($row["supply_conditions"]));    //업태(공급자)
		$supply_item = htmlspecialchars(stripslashes($row["supply_item"]));                //종목(공급자)
		$skin_name = htmlspecialchars(stripslashes($row["skin_name"]));                    //스킨이름		
		$use_report_email = htmlspecialchars(stripslashes($row["use_report_email"]));      //관리자에게 이메일 전송여부
		$banking = htmlspecialchars(stripslashes($row["banking"]));						   //계좌정보
		$count_field = htmlspecialchars(stripslashes($row["count_field"]));                //접속통계(누적)
		$count_zero = htmlspecialchars(stripslashes($row["dummy9"]));					   //구간통계(버전5.2)
		if(!$count_zero) $count_zero = 0;

		if($form_type == "0") $form_type_txt = af_txt_formType0;
		if($form_type == "1") $form_type_txt = af_txt_formType1;
		
		$input_date =  date("Y.m.d",$input_date);                            //타임스탬프를 날짜형식으로 변환		
		//주문폼이 속한 그룹의 그룹이름을 가져와서 $group_name에 대입
		$result2 = mysql_query("select name from ".db_tblname."_group_table where no like $no_group");
		$row2 = mysql_fetch_array($result2);
		$group_name = htmlspecialchars(stripslashes($row2["name"]));

			echo("	
				 	<tr>
						<td>
						<input type='checkbox' name='chk_list[]' value='$name' class='c'>				
						</td>
						<td nowrap style=\"display:none;\">
						$group_name
						</td>	
						<td>
						$name
						</td>
						<td>
						$form_type_txt						
						</td>						
						<td>
						<a href='../view_addform.php?fname=$name' target='new' style='color:blue;text-decoration:none;'>$title_text</a>
						</td>
						<td>
							<table>
								<tr>
									<td style='background-color:#d9d6d9;'>
										".af_txt_addform_list_2."
									</td>
									<td style='background-color:#d9d6d9;'>
										".af_txt_addform_list_3."
									</td>
								</tr>
								<tr>
									<td>
										$count_zero
									</td>
									<td>
										$count_field
									</td>
								</tr>
							</table>					
						</td>
						<td>						
						$input_date
						</td>
						<td style='text-align:center;' nowrap>
						<input type='button' value='".af_txt_set_modify."' onClick=\"location.href='form_add.php?no=$no&amp;mode=modify'\"  class='btn_list'>											
						</td>
						<td style='text-align:center;' nowrap>						
						<input type='button' value='접속주소복사' onClick=\"javascript:void(window.open('url_copy.php?w=780&amp;h=600&amp;name=".urlencode($name)."&amp;title_text=".$title_text."','url_copy','width=780,height=600,status=yes,scrollbars=yes,toolbar=no,resizable=yes'))\" class='btn_list' style='width:90px;'>
						</td>
						<td style='text-align:center;' nowrap>
						<input type='button' value='".af_txt_addform_list_1."' 						onClick=\"javascript:void(window.open('form_copy.php?w=450&amp;h=300&amp;no=$no&amp;name=".urlencode($name)."','form_copy','width=450,height=300,statusbar=no,scrollbars=no,toolbar=no'))\" class='btn_list'>
						</td>						
					</tr>			
								");        


			
		}// while문 끝
	}// if문 끝	
}// for문 끝
}

###################################     레코드 배열 출력함수 end       ##################
#########################################################################################





#########################################################################################
###################################     페이지 나누기 함수 start       ##################
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

	echo "<div>";
	if($page > $page_n){ 
		$prev = $over_page * $page_n;
		echo("<a href='".URL."?code=$code&amp;desc=$desc&amp;page=$prev&amp;mode=$mode&amp;keywd=$keywd'><img src='../imgs/btn_pre.gif' align='middle'></a>&nbsp;&nbsp;"); 
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
				echo("<a href='".URL."?code=$code&amp;desc=$desc&amp;page=$link&amp;mode=$mode&amp;keywd=$keywd'>[$vlink]</a>&nbsp;&nbsp;");
			}
		} 
	} 

	if($total_page > ($over_page+1)*$page_n){
		$next = $over_page*$page_n+$page_n+1;
		echo("<a href='".URL."?code=$code&amp;desc=$desc&amp;page=$next&amp;mode=$mode&amp;keywd=$keywd'><img src='../imgs/btn_next.gif'  align='middle'></a>");
	}else{
		echo("<img src='../imgs/btn_next.gif'  align='middle'>");
	}
	echo "</div>";
} 
?>

<?php
#########################################################################################
####################    selectBox Part1: 그룹 선택상자 start    #########################
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
    
    $buf="<select 
	    $arr[name]
        $arr[id]
        $arr[style]
		$arr[script]
        $arr[disable]
        >
			<option value=''>".af_txt_selectBox_opt1."</option>
			<option value='".URL."?code=$code&amp;desc=$desc&amp;page=$prev&amp;mode=groupMode&amp;keyword='>".af_txt_group."</option>
    \n";
    if ($arr["end"]>$arr[start]) {             //숫자 범위 지정시
        for ($i=$arr[start];$i <= $arr["end"];$i++) {
            $buf.=opt($i,$arr["default"],$arr[head]).$i.$arr[tail]."\n";
        }
    } elseif (count($arr[text])) {          
        for ($i=0;$i < count($arr[text]);$i++) {
            $buf.=f_opt($arr[optVal].$arr[no][$i],&$arr[text][$i],$arr["default"],$arr[head]).$arr[text][$i].$arr[tail]."\n";
        }
    }
    
    $buf.="</select>\n";
    return $buf;
}
?>

<?php
#########################################################################################
#############	  selectBox Part2: DB에서 그룹정보 가져와서 연관배열 만들기	  ###########
#########################################################################################

function f_mkOptArr(){
global $DBconn;

$res=$DBconn->f_selectDB("*","".db_tblname."_group_table",$where);  //필드, 테이블, 조건절
//$rows = mysql_fetch_array($res[result]);                   //리턴된 배열을 $row에 저장
$res_count=mysql_num_rows($res[result]);                     //리턴된 행의 개수
//리턴행이 여러개일 경우 아래와 같이 for문으로 연관배열화
$no=array();                                                 //배열변수 정의(그룹고유번호)
$na=array();                                                 //배열변수 정의(그룹이름)
	for ($i=0;$i < $res_count;$i++) {                        //불러온 레코드의 수만큼 루프        
        $row=mysql_fetch_array($res[result]);                //배열의 요소들을 $row에 대입	
		$na[$i]=htmlspecialchars(stripslashes($row[name]));  //연관배열 만듬  
		$no[$i]=htmlspecialchars(stripslashes($row[no]));    //연관배열 만듬    
    }	
	//$arr=array("name"=>"comboGroup","id"=>"selectGroup","text"=>&$a);//연관배열 정의 방법1
	$arr=array();                                           //연관배열 정의 방법2
		$arr[head]="";
		$arr[tail]="";
		$arr[start]="";
		$arr['end']="";
		$arr['default']="";                                  //디폴트로 선택될 text
		$arr[name]="comboGroup";                             //선택상자 이름
		$arr[id]="";                                         //선택상자 객체 구분 아이디
		$arr[style]="width:152px;";                          //선택상자 스타일
		$arr[script]="onchange='groupMode(this);'"; //실행할 스크립트			
		$arr[optVal]=URL."?code=$code&amp;desc=$desc&amp;page=$prev&amp;mode=groupMode&amp;keywd=";//옵션 value
		$arr[no]=$no;                                        //그룹 고유번호 배열
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
<script type="text/javascript" src='js/chk_moveN.js'></script>
<script type="text/javascript" src='js/chk_count_zeroN.js'></script>

<script type="text/javascript">
<!--//선택상자 항목 선택시 url 이동
function groupMode(x) {
	if(x.selectedIndex !=0){
		location.href=x.options[x.selectedIndex].value;	//불여우에서는 document.location.href(인자);와 같이 사용하면 안됨	
	}
						
}
//-->
</script>


<script type="text/javascript">	
<!--
		window.onload=function(){tableruler();} 					 //테이블 행간 롤오버 함수 호출
-->
</script>

</HEAD>

<BODY>
<DIV ID="mainDiv">

<!--//////////////////////////////////////////////////////////////////////-->
<!--###########################     검색조회 구역     ####################--> 
<!--//////////////////////////////////////////////////////////////////////-->
	<FIELDSET style="margin-top:0;">
		<LEGEND>폼검색</LEGEND>
			<!--상단 선택상자 및 검색--> 
			<TABLE summary="그룹선택 및 검색 테이블" class="noborder" STYLE="HEIGHT:80px">
				<TR>
					<TD style="text-align:left" nowrap> 
						<FORM NAME="form1" action="">
							<?php echo f_mkOptArr();?> Group
						</FORM>
						<FORM NAME="search_form" METHOD="get" ACTION="<?php echo URL;?>" style="margin:0;padding:0;margin-top:5px;">			
							<INPUT TYPE="hidden" NAME="code" VALUE="no"> 
							<INPUT TYPE="hidden" NAME="desc" VALUE="desc"> 
							<INPUT TYPE="hidden" NAME="mode" VALUE="search_form"> 
							<INPUT TYPE="text" NAME="keywd" VALUE="<?php echo $_GET['keywd']?>"> 
							<INPUT TYPE="submit" VALUE="<?php echo af_txt_search;?>">
						</FORM>
					</TD>
					<TD style="text-align:right;padding-right:6px;">
						<input type="button" value="폼추가" onclick="location.href='form_add.php'" class="btn_big_main" style="width:129px;">
						<input type="button" value="전체폼기본환경설정" onclick="location.href='form_env.php'" class="btn_big_main" style="width:129px;">
					</TD>
				</TR>
			</TABLE>
	</FIELDSET>	

	<!--레코드 테이블 출력--> 
	<FIELDSET>
		<LEGEND><?php echo af_txt_search_result;?> (<?php echo $res_count;?>)</LEGEND> 
			<FORM NAME="chk_box" METHOD="POST" ACTION="<?php echo URL?>"/>
			<!-- del 모드시 참고될 get 인자들  -->
			<input type="hidden" name="mode" value="">
			<input type="hidden" name="prev_mode" value="<?php echo $_GET['mode'];?>">
			<INPUT TYPE="hidden" NAME="code" VALUE="no"> 
			<INPUT TYPE="hidden" NAME="desc" VALUE="desc">
			<input type="hidden" name="page" value="<?php echo $_GET['page'];?>">
			<input type="hidden" name="keywd" value="<?php echo $_GET['keywd'];?>">

			  <TABLE summary="폼 리스트 출력및 관리 테이블" class="ruler"> 
				  <caption>
					&nbsp;
				  </caption>

				<thead>
					<tr>
						<th class="order" scope="col" style='width:20px'><input type="button" value="all" onfocus="this.blur()" onClick="this.value=chk_all(this.form)"></th>
						<th class="order" scope="col" style="display:none;">GROUP</th>
						<th class="order" scope="col" style='width:100px;'>NAME</th>
						<th class="order" scope="col" style='width:70px;'>TYPE</th>
						<th class="order" scope="col">TITLE</th>
						<th class="order" scope="col" style='width:150px;'>COUNT</th>
						<th class="order" scope="col" style='width:80px;'>Create Time</th>
						<th class="order" scope="col" style='text-align:center;width:70px;'>MODIFY</th>
						<th class="order" scope="col" style='text-align:center;width:100px;'>PAGE LINK</th>
						<th class="order" scope="col" style='text-align:center;width:70px;'>COPY</th>						
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
			<div style="margin:10px">
				<?php echo f_pageDiv();?> 
			</div>
	</FIELDSET>

	<FIELDSET>
		<LEGEND>폼그룹 이동/폼삭제</LEGEND>
			<TABLE summary="그룹선택 및 검색 테이블" class="noborder" STYLE="HEIGHT:80px">
				<TR>
					<TD style="text-align:left" nowrap> 
						<ul class="tip">
							<li>
								폼을 선택한 후, 이동 버튼을 클릭하여, 원하는 그룹으로 이동할 수 있습니다.
							</li>
							<li>
								폼선택 후, 카운터초기화 버튼을 클릭하여, 구간카운터를 초기화 할 수 있습니다.
							</li>
							<li>
								폼삭제시, upload 폴더에 저장되있는 해당폼의 첨부파일과 이미지도 삭제됩니다.
							</li>
						</ul>
					</TD>
					<TD style="text-align:right;padding-right:6px;">
						<INPUT TYPE="button" NAME="move" VALUE="<?php echo af_txt_move;?>" onClick="chk_moveN(this.form)" class="btn_list">&nbsp;&nbsp;&nbsp;
						<INPUT TYPE="button" NAME="count_zero" VALUE="<?php echo af_txt_addform_list_4;?>" onClick="this.form.mode.value='count_zero';chk_count_zeroN(this.form)" class="btn_list" style='width:90px;'>&nbsp;&nbsp;&nbsp;
						<INPUT TYPE="button" NAME="del" VALUE="<?php echo af_txt_del;?>" onClick="this.form.mode.value='del';chk_delN(this.form)" class="btn_list" style="color:red;">						 
					</TD>
				</TR>
			</TABLE>			
	</FIELDSET>

</DIV>

</BODY>

</HTML>
