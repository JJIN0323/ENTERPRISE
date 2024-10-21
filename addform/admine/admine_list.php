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
###########################     선택한 사원 삭제 start     ############################
#########################################################################################

if($_POST['mode']=="del") 
{
		echo f_del($_POST['chk_list'],$_POST['user_id']);	//$chk_list인자는 선택한 체크박스 배열
}

function f_del($no,$id)
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
			//아이디가져오기(반드시 아래 $DBconn의 상단에 위치해야 변수세탁안되어 에러안남)
			$result=@mysql_query("select * from ".db_tblname."_admine_table where no='$no[$i]'") or die(mysql_error());
			$row =  mysql_fetch_array($result);			
			$user_id =  htmlspecialchars(stripslashes($row["user_id"]));	
			//삭제하기
			$where="where no='$no[$i]'";							
			$DBconn->f_deleteTable(TABLE1,$where);			//테이블, 조건절			
			//아이디에 해당하는 사진삭제
			$af_arr_format = array("jpg","jpeg","gif");		//업로드 된 폼이미지들 허용확장자(form_add.php 참조)
			for($f = 0;$f < count($af_arr_format);$f++)		//사원사진 삭제
				{
				@unlink("../upload/member_pic/".$user_id.".".$af_arr_format[$f]."");
				}				
		}
	 die("<meta http-equiv=refresh content='0;url=".URL."?mode=$prev_mode&amp;code=$code&amp;desc=$desc&amp;page=$page&amp;keywd=$keywd'>");	//쿼리실행 후 문서 고침
}


#########################################################################################
############     사용자가 검색을 실행할 경우 $where 검색조건 정의 start     #############
#########################################################################################

if($_POST['mode'] == "search_form" or $_GET['mode'] == "search_form")
{
	$keywd="";
	$keywd = $_GET['keywd'].$_POST['keywd']; 

	$vowels = array("'","\"");								//제거할 특수문자 배열
	$keywd = str_replace($vowels, "", $keywd);				//인용부호 제거    	
	
	if($keywd) 
	{														//검색키워드가 있을때			
		$where = " where level like '%$keywd%' ";			
		$where .= "or user_id like '%$keywd%' ";					
		$where .= "or name like '%$keywd%' ";			
		$where .= "or email_address like '%$keywd%' ";			
		$where .= "or tel like '%$keywd%' ";			
		$where .= "or hp like '%$keywd%' ";			
		$where .= "or fax like '%$keywd%' ";		
		$where .= "or supply_address like '%$keywd%' ";		
		$where .= "or dummy1 like '%$keywd%' ";		
		$where .= "or dummy2 like '%$keywd%' ";		
		$where .= "or dummy3 like '%$keywd%' ";	
		$where .= "or dummy4 like '%$keywd%' ";		
		$where .= "or dummy5 like '%$keywd%' ";		
		
	}
}



#########################################################################################
#######  선택상자에서 레벨을 선택하였을 경우 $where 검색조건 정의 start    ##############
#########################################################################################

else if($_GET['mode'] == "groupMode")
{
	$keywd="";
	$keywd = $_GET['keywd'].$_POST['keywd'];

	$vowels = array("'","\"");							//제거할 특수문자 배열
	$keywd = str_replace($vowels, "", $keywd);			//인용부호 제거
    
	if($keywd) 
	{													//검색키워드가 있을때			
		$where = " where level like '%$keywd%' ";		   
	}			
}



#########################################################################################
##########################    검색이 아닌 초기접속시 $where 정의 start     ##############
#########################################################################################

else{$where = "";}
///////DB에서 가져오기///////
$res=$DBconn->f_selectDB("*",TABLE1,$where); //필드, 테이블, 조건절
//$rows = mysql_fetch_array($res[result]);   //리턴된 배열을 $row에 저장
$res_count=mysql_num_rows($res[result]);     //리턴된 행의 개수



#########################################################################################
#################################      페이지 나누기 start      #########################
#########################################################################################

$page = $_GET['page'];

if(!$page){$page = 1;} 
$start = ($page-1)*$records;
$end = $start+$records;
$over_page = floor($start/($records*$page_n));
$total_page = floor($res_count/$records+1);

if($end > $res_count){$end=$res_count;} 
if($page>$total_page){$page=$total_page;}	


#########################################################################################
##############################     등급 선택상자 part1      #############################
#########################################################################################

//<option>태그 생성
function f_opt($val,$text,$default="",$head="") 
{
	$buf="<option value='$val'";
	if ($default&&$default==$text) 
	{
		$buf.="selected";
	}
	$buf.=">".$head;
	return $buf;
}
//select 선택상자 구성
function f_SelectBox($arr) 
{
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
			<option value=''>등급</option>			
    \n";
    if ($arr["end"]>$arr[start]) 
	{   //숫자 범위 지정시
        for ($i=$arr[start];$i<=$arr["end"];$i++) 
		{
            $buf.=opt($i,$arr["default"],$arr[head]).$i.$arr[tail]."\n";
        }
    } else if (count($arr[text])) 
		{          
        for ($i=0;$i<count($arr[text]);$i++) 
		{
            $buf.=f_opt($arr[optVal][$i],&$arr[text][$i],$arr["default"],$arr[head]).$arr[text][$i].$arr[tail]."\n";
        }
    }
    
    $buf.="</select>\n";
    return $buf;
}


#########################################################################################
###############################     등급 선택상자 part2      ############################
#########################################################################################

function f_mkOptArr($name,$default_inja,$combo_script)
{
															 //디폴트로 선택될 콤보박스 텍스트
$default="";												 //사원등급
$default = $default_inja;
$style = "";

$no=array();                                                 //배열변수 정의(상황번호)
$na=array();                                                 //배열변수 정의(상황이름)

	for ($i=0;$i<9;$i++) 
	{														 //배열길이 만큼 루프       
		$na[$i]=$i+2;										 //이름 스칼라배열 만듬  
		$no[$i]=$i+2;										 //상황번호 스칼라배열 만듬			
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
		

echo f_SelectBox($arr);								 //f_SelectBox 함수 실행
}


#########################################################################################
############################   선택한사원 등급변경 start	   ##########################
#########################################################################################
if($_POST['mode']=="Modify") 
{
															//chk_list인자는 선택한 체크박스 배열
															//change_no인자는 선택한 변경될  숫자
		echo f_Modify($_POST['chk_list'],$_POST['change_no']);			
}

function f_Modify($no,$change_no)
{								
	global $DBconn;	
	
	$get_situMinja = "";
	$get_situMinja .= "mode=".$_POST['prev_mode']."&amp;code=".$_POST['code']."&amp;desc=".$_POST['desc']."&amp;";
	//$get_situMinja .= "mode_key=".$_POST['mode_key']."&amp;situ_key=".$_POST['situ_key']."&amp;";
	//$get_situMinja .= "basis_time=".$_POST['basis_time']."&amp;yS=".$_POST['yS']."&amp;mS=".$_POST['mS']."&amp;dS=".$_POST['dS']."&amp;yE=".$_POST['yE']."&amp;mE=".$_POST['mE']."&amp;dE=".$_POST['dE']."&amp;";
	$get_situMinja .= "keywd=".$_POST['keywd']."&amp;";
	$get_situMinja .= "page=".$_POST['page']."";

	$clean['level'] = $change_no;							//변경될 등급(숫자)	
	
	$n = count($no);										//전달받은 배열의 크기	
	
	for($i=0;$i < $n;$i++)
	{	
	$where="where no=$no[$i]";						
	$DBconn->f_updateDB(TABLE1,$clean,$where);				//$clean이 하나이므로 참조연산자&로 넘겨줄 필요없음에 주의	
	}
	die("<meta http-equiv=refresh content='0;url=".URL."?".$get_situMinja."'>");	//쿼리실행 후 문서 고침
}


#########################################################################################
###################################     레코드 배열 출력함수 start     ##################
#########################################################################################

function f_loopRec()
{
	$code = $_GET['code'];
	$desc = $_GET['desc'];
	global $where;
	global $start;
	global $end;
	global $af_adminMember;

	for($i= $start ; $i < $end ; $i++)
	{	
		if(!$code) $code="no"; else $code=$code; 
		if(!$desc) $desc="desc"; else $desc=$desc;
		//$code="no";                                //no필드를 기준으로 정렬

	    $load = "select * from ".db_tblname."_admine_table";
		$load .= $where;//검색조건
		$load .= " order by $code $desc ";           //정렬조건 desc 는 내림차순, asc 는 오름차순
		$load .= " limit $i,1 ";                     //한페이지에 출력될 수 제한(while문 무한루프돌지 않게)
		$result = mysql_query($load);
		$rows = mysql_num_rows($result);
		$html = "";
		$html = array();

		if($rows)
		{
	while($row = mysql_fetch_array($result))
		{
		$html["no"] = htmlspecialchars(stripslashes($row["no"]));							//고유번호
		$html["level"] = htmlspecialchars(stripslashes($row["level"]));						//레벨
		$html["user_id"] =  htmlspecialchars(stripslashes($row["user_id"]));				//아이디
		$html["password"] = htmlspecialchars(stripslashes($row["password"]));				//비밀번호
		$html["name"] = htmlspecialchars(stripslashes($row["name"]));						//이름
		$html["email_address"] = htmlspecialchars(stripslashes($row["email_address"]));		//이메일
		$html["tel"] = htmlspecialchars(stripslashes($row["tel"]));							//전화번호
		$html["hp"] = htmlspecialchars(stripslashes($row["hp"]));							//
		$html["fax"] = htmlspecialchars(stripslashes($row["fax"]));							//
		$html["supply_name"] = htmlspecialchars(stripslashes($row["supply_name"]));			//폼추가시 자동입력 상호	
		$html["supply_num"] = htmlspecialchars(stripslashes($row["supply_num"]));			//폼추가시 자동입력 사업자번호	
		$html["supply_man"] = htmlspecialchars(stripslashes($row["supply_man"]));			//폼추가시 자동입력 대표	
		$html["supply_address"] = htmlspecialchars(stripslashes($row["supply_address"]));	//폼추가시 자동입력 주소
		$html["supply_conditions"] = htmlspecialchars(stripslashes($row["supply_conditions"]));	//폼추가시 업태
		$html["supply_item"] = htmlspecialchars(stripslashes($row["supply_item"]));			//폼추가시 자동입력 종목
		$html["sell_num"] = htmlspecialchars(stripslashes($row["sell_num"]));				//통신판매번호
		$html["banking"] = htmlspecialchars(stripslashes($row["banking"]));					//폼추가시 자동입력 은행정보	
		$html["join_date"] = htmlspecialchars(stripslashes($row["join_date"]));				//가입시각	
		$html["edit_date"] = htmlspecialchars(stripslashes($row["edit_date"]));				//수정시각	
		$html["dummy1"] = htmlspecialchars(stripslashes($row["dummy1"]));					//부서명					
		$html["dummy2"] = htmlspecialchars(stripslashes($row["dummy2"]));					//직위					
		$html["dummy3"] = htmlspecialchars(stripslashes($row["dummy3"]));					//비고			 
		$html["dummy4"] = htmlspecialchars(stripslashes($row["dummy4"]));					
		$html["dummy5"] = htmlspecialchars(stripslashes($row["dummy5"]));					
		$html["dummy6"] = htmlspecialchars(stripslashes($row["dummy6"]));				
		$html["dummy7"] = htmlspecialchars(stripslashes($row["dummy7"]));				
		$html["dummy8"] = htmlspecialchars(stripslashes($row["dummy8"]));				
		$html["dummy9"] = htmlspecialchars(stripslashes($row["dummy9"]));				
		$html["dummy10"] = htmlspecialchars(stripslashes($row["dummy10"]));
		$html["dummy11"] = htmlspecialchars(stripslashes($row["dummy11"]));				 
		$html["dummy12"] = htmlspecialchars(stripslashes($row["dummy12"]));				
		$html["dummy13"] = htmlspecialchars(stripslashes($row["dummy13"]));				
		$html["dummy14"] = htmlspecialchars(stripslashes($row["dummy14"]));				 
		$html["dummy15"] = htmlspecialchars(stripslashes($row["dummy15"]));				
		$html["dummy16"] = htmlspecialchars(stripslashes($row["dummy16"]));				
		$html["dummy17"] = htmlspecialchars(stripslashes($row["dummy17"]));				
		$html["dummy18"] = htmlspecialchars(stripslashes($row["dummy18"]));				
		$html["dummy19"] = htmlspecialchars(stripslashes($row["dummy19"]));				
		$html["dummy20"] = htmlspecialchars(stripslashes($row["dummy20"]));
		
		if($html["level"] != 1)		//최고관리자일 경우 출력 안되게
			{

		//사진불러오기
		$af_arr_format = array("jpg","jpeg","gif");
		$z_token = 0;
		for($z=0; $z < count($af_arr_format);$z++)
			{						
			if(file_exists("../upload/member_pic/".$html["user_id"].".".$af_arr_format[$z].""))
				{					
				$pic = "<img src='../upload/member_pic/".$html["user_id"].".".$af_arr_format[$z]."' style='width:50px;height:67px;border:5px solid #fff;' alt='사원사진'>";				
				$z_token++;
				}					
			}
		if($z_token==0)
			{
				$pic = "<img src='img/man.jpg' style='width:50px;height:67px;border:5px solid #fff;'>";
			}
		
		if($af_adminMember["user_id"]==$html["user_id"])
			{	
				$name_tip = "(<span style='color:red;'>나</span>)";
			}
		else $name_tip = "";
		
		//출력
			echo("	
				 	<tr>
						<td>");
							//체크박스
							if($af_adminMember["user_id"]==$html["user_id"])
							{	
								//본인것은 삭제나 등급변경못하게
							}
							else
							{
								echo "<input type='checkbox' name='chk_list[]' value='".$html["no"]."' class='c' id='checkbox$i'>";		
							}
										
			echo("		</td>
						<td>
							".$pic."
						</td>
						<td style='font-weight:bold;' nowrap>
							".$html['name']."".$name_tip."<br><span style='color:gray;font-size:11px;'>".$html['user_id']."</span><br>
							<span style='color:gray;font-size:11px;font-weight:normal;'>등록번호:".$html['no']."</span>
						</td>
						<td style='text-align:center;' nowrap>						
							".$html['dummy1']."
						</td>
						<td style='text-align:center;' nowrap>						
							".$html['dummy2']."
						</td>
						<td>");
							//선택상자 출력(선택상자객체명,상황코드,실행스크립트)
							if($af_adminMember["user_id"]==$html["user_id"])
							{	//본인것은 등급변경못하게
								echo $html["level"]." 등급";	
							}
							else
							{
								f_mkOptArr("combolevel[]",$html["level"],"onchange='this.form.change_no.value=this.options[this.selectedIndex].value;chk_levelModify(this.form,$i,this.options[this.selectedIndex].text,this.options[this.selectedIndex].value,".login_level.",".levelModify_level.",\"".levelModify_msg."\")'");
							}
										
			echo("		</td>				
						<td nowrap>
							".$html['email_address']."
						</td>
						<td nowrap>						
							".$html['tel']."
						</td>
						<td style='text-align:center;' nowrap>
							".$html['hp']."										
						</td>						
						<td style='text-align:right;' nowrap>
							<input type='button' value='수 정 하 기' onclick=\"javascript:void(window.open('admine_add.php?w=600&amp;h=650&amp;no=".$html['no']."&amp;mode=modify','modify','width=600,height=650,statusbar=no,scrollbars=yes,toolbar=no'))\"  class='btn_list' style='width:144px;'>
						</td>
							
					</tr>			
				");      

			}//최고관리자외 if 문 끝
			
		}// while문 끝
		}// if문 끝	
	}// for문 끝
}

###################################     레코드 배열 출력함수 end       ##################
#########################################################################################





#########################################################################################
###################################     페이지 나누기 함수 start       ##################
#########################################################################################

function f_pageDiv()
{	
	global $page; 
	global $page_n;
	global $over_page;
	global $total_page;

	$code = $_GET['code'];
	$desc = $_GET['desc'];
	$mode = $_GET['mode'];
	$keywd = $_GET['keywd'];

	echo "<div>";
	if($page > $page_n)
		{ 
		$prev = $over_page * $page_n;
		echo("<a href='".URL."?code=$code&amp;desc=$desc&amp;page=$prev&amp;mode=$mode&amp;keywd=$keywd'><img src='../imgs/btn_pre.gif' align='middle'></a>&nbsp;&nbsp;"); 
		}
	else{
		echo("<img src='../imgs/btn_pre.gif'  align='middle'>&nbsp;&nbsp;");
		} 


	for($j=0 ; $j < 10 ;$j++)
		{ 
		$link = $j+$page_n*$over_page+1;
		$vlink= $over_page*$page_n+$j+1;
		if($link <= $total_page)
			{
			if($vlink == $page)
				{
				echo("<font color=red>$vlink</font>&nbsp;&nbsp;");
				}
			else{
				echo("<a href='".URL."?code=$code&amp;desc=$desc&amp;page=$link&amp;mode=$mode&amp;keywd=$keywd'>[$vlink]</a>&nbsp;&nbsp;");
				}
			} 
		} 

	if($total_page > ($over_page+1)*$page_n)
		{
		$next = $over_page*$page_n+$page_n+1;
		echo("<a href='".URL."?code=$code&amp;desc=$desc&amp;page=$next&amp;mode=$mode&amp;keywd=$keywd'><img src='../imgs/btn_next.gif'  align='middle'></a>");
		}else
		{
		echo("<img src='../imgs/btn_next.gif'  align='middle'>");
		}
	echo "</div>";
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
<script type="text/javascript" src='js/chkAll_levelModify.js'></script>
<script type="text/javascript" src='js/chk_levelModify.js'></script>

<script type="text/javascript">
<!--
//레벨 선택상자 항목 선택시 url 이동
function groupMode(x) 
{
	if(x.selectedIndex !=0)
		{
			//&amp;로 구분하면 불여우와 크롬에서는 에러남
			var url = "<?php echo URL;?>?code=<?php echo $_GET[code];?>&desc=<?php echo $_GET[desc];?>&page=<?php echo $_GET[prev];?>&mode=groupMode&keywd=";
			location.href=url+x.options[x.selectedIndex].value;	//불여우에서는 document.location.href(인자);와 같이 사용하면 안됨
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
		<LEGEND>관리사원검색 / 등록</LEGEND>
			<!--상단 선택상자 및 검색--> 
			<TABLE summary="등급선택 및 검색 테이블" class="noborder" STYLE="HEIGHT:80px">
				<TR>
					<TD style="text-align:left;width:400px;" nowrap> 
						<FORM NAME="form1" action="">
							<?php
								f_mkOptArr("comboLevelTop","","onchange='groupMode(this);'");		
							?> Level Search
						</FORM>
						<FORM NAME="search_form" METHOD="get" ACTION="<?php echo URL;?>" style="margin:0;padding:0;margin-top:5px;">			
							<INPUT TYPE="hidden" NAME="code" VALUE="no"> 
							<INPUT TYPE="hidden" NAME="desc" VALUE="desc"> 
							<INPUT TYPE="hidden" NAME="mode" VALUE="search_form"> 
							<INPUT TYPE="text" NAME="keywd" VALUE="<?php echo $_GET['keywd']?>" <?php if($_GET['keywd']) echo "style='background-color:yellow;'";?>> 
							<INPUT TYPE="submit" VALUE="<?php echo af_txt_search;?>">
							<INPUT TYPE="button" VALUE="검색초기화" onclick="document.location.href='<?php echo URL;?>';">
						</FORM>
					</TD>
					<TD style="text-align:right;padding-right:6px;background:url(img/tip_btn_level.gif) no-repeat right bottom;">
						<input type="button" value="사원등록" onclick="javascript:void(window.open('admine_add.php?w=600&amp;h=650','admineadd','width=600,height=650,statusbar=no,scrollbars=yes,toolbar=no'))" class="btn_list">
						<input type="button" value="권한설정"  onclick="document.location.href='admine_level.php'" class="btn_list">
					</TD>
				</TR>
			</TABLE>
	</FIELDSET>	

	<!--레코드 테이블 출력--> 
	<FIELDSET>
		<LEGEND>관리사원 검색결과 (<?php echo $res_count;?>)</LEGEND> 
			<FORM NAME="chk_box" METHOD="POST" ACTION="<?php echo URL?>"/>
			<!-- del 모드시 참고될 get 인자들  -->
			<input type="hidden" name="mode" value="">
			<input type="hidden" name="prev_mode" value="<?php echo $_GET['mode'];?>">
			<INPUT TYPE="hidden" NAME="code" VALUE="no"> 
			<INPUT TYPE="hidden" NAME="desc" VALUE="desc">
			<input type="hidden" name="page" value="<?php echo $_GET['page'];?>">
			<input type="hidden" name="keywd" value="<?php echo $_GET['keywd'];?>">
			<input type="hidden" name="change_no" value="">

			  <TABLE summary="사원 리스트 출력및 관리 테이블" class="ruler"> 
				  <caption>
					1등급인 최고관리자는 검색결과에 출력되지 않습니다.
				  </caption>

				<thead>
					<tr>
						<th class="order" scope="col" style='width:20px'><input type="button" value="all" onfocus="this.blur()" onClick="this.value=chk_all(this.form)"></th>						
						<th class="order" scope="col" style='width:70px;'>사진</th>
						<th class="order" scope="col">이름<br>(아이디)</th>
						<th class="order" scope="col">부서명</th>
						<th class="order" scope="col">직위</th>
						<th class="order" scope="col">등급</th>						
						<th class="order" scope="col">이메일</th>
						<th class="order" scope="col">일반전화</th>
						<th class="order" scope="col">이동전화</th>						
						<th class="order" scope="col" style='width:150px;'>수 정 하 기</th>						
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

	<FIELDSET style="text-align:left;">
		<LEGEND>선택한 사원을 모두</LEGEND>				
		<table style="width:90%;margin:10px;">
			<tr>
				<td style="width:100px;text-align:left;border:0;">	
					<INPUT TYPE="button" NAME="del" VALUE="<?php echo af_txt_del;?>" onclick="this.form.mode.value='del';chk_delN(this.form,<?php echo login_level;?>,<?php echo admine_del_level;?>,'<?php echo admine_del_msg;?>')" class="btn_del">
				</td>
				<td style="width:150px;text-align:left;border:0;">  
					<?php f_mkOptArr("combolevelFoot","","");?><INPUT TYPE="button" NAME="levelModify" VALUE="<?php echo af_txt_order_list_14;?>" onclick="chkAll_levelModify(this.form,<?php echo login_level;?>,<?php echo levelModify_level;?>,'<?php echo levelModify_msg;?>');"> 
				</td>
				<td style="text-align:left;color:gray;border:0;"><br>  
					원하는 사원을 모두 선택 후, 일시에 등급을 변경할 수 있습니다.<br>
					1등급은 최고관리자 1명이고, 관리사원은 2 ~ 10등급으로 분류됩니다.<br>
					사원등급별 업무권한을 설정하려면, 우측상단의 권한설정 버튼을 클릭하세요.
				</td>
			</tr>
		</table>
	</FIELDSET>

</DIV>

</BODY>

</HTML>