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

?>

<?php

$list = $_GET['a'];															 //폼으로 넘기기 위한, 부모창에서 가져온 리스트 배열 소스


#########################################################################################
###########################     선택한 애드폼 이동 start     ############################
#########################################################################################

if($_POST['mode']=="move") {
	
	$list = "";
	$list = explode("|",$_POST['list']);                                     //변수값의 구분자를 기준으로 배열화
	array_shift($list);														 //배열에서 첫번째 배열요소 삭제
	if (ctype_digit($_POST['group_no']))									 //변수 세탁(alnum=숫자와알파벳, alpha=알파벳, digit=숫자)
	{
		$clean['no_group'] = $_POST['group_no'];							 //이동시킬 그룹번호
	}											 

	
	
		$n = count($list);												     //배열의 크기		

		for ($i=0;$i<$n;$i++) {												 //체크항목만큼 sql 쿼리 반복 처리
		$where="where name = '$list[$i]'";									 //no필드대신 name필드를 조건하였고 문자형이므로 작은따옴표 붙임에 주의
		$DBconn->f_updateDB(TABLE5,$clean,&$where);							 //테이블, 필드와값, 조건절
		
	}

	 die("<script>alert('".af_txt_alt_moveGroup_success."');opener.location.href='addform_list.php';top.opener=top.window.close();</script>");//쿼리실행 후 문서 고침 
}


#########################################################################################
##############################     그룹 선택상자 start       ############################
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
    \n";
    if ($arr["end"]>$arr[start]) {             //숫자 범위 지정시
        for ($i=$arr[start];$i<=$arr["end"];$i++) {
            $buf.=opt($i,$arr["default"],$arr[head]).$i.$arr[tail]."\n";
        }
    } elseif (count($arr[text])) {          
        for ($i=0;$i<count($arr[text]);$i++) {
            $buf.=f_opt($arr[optVal].$arr[no][$i],&$arr[text][$i],$arr["default"],$arr[head]).$arr[text][$i].$arr[tail]."\n";
        }
    }
    
    $buf.="</select>\n";
    return $buf;
}
?>

<?php
#########################################################################################
###############      DB에서 그룹정보 가져와서 연관배열 만들기 start       ###############
#########################################################################################

function f_mkOptArr(){
global $DBconn;
$res=$DBconn->f_selectDB("*","".db_tblname."_group_table",$where);  //필드, 테이블, 조건절
//$rows = mysql_fetch_array($res[result]);                   //리턴된 배열을 $row에 저장
$res_count=mysql_num_rows($res[result]);                     //리턴된 행의 개수

$no=array();                                                 //배열변수 정의(그룹고유번호)
$na=array();                                                 //배열변수 정의(그룹이름)
	for ($i=0;$i<$res_count;$i++) {                          //불러온 레코드의 수만큼 루프        
        $row=mysql_fetch_array($res[result]);                //배열의 요소들을 $row에 대입	
		$na[$i]=htmlspecialchars(stripslashes($row[name]));  //스칼라배열 만듬  
		$no[$i]=htmlspecialchars(stripslashes($row[no]));    //스칼라배열 만듬    
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
		$arr[style]="";                                      //선택상자 스타일
		$arr[script]="";									 //실행할 스크립트			
		$arr[optVal]="";									 //옵션 value
		$arr[no]=$no;                                        //그룹 고유번호 배열
		$arr[text]=$na;                                      //실렉트 메뉴 배열
		

echo f_SelectBox ($arr);//f_SelectBox 함수 실행
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>

<HEAD>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<meta name='robots' content='none,noindex,nofollow'>
<TITLE>폼 이 동</TITLE>
<META NAME="author" CONTENT="애드폼">
<LINK REL="stylesheet" HREF="global.css" TYPE="text/css">
<!--외부 스크립트-->
<script type="text/javascript" src='js/check_input.js'></SCRIPT>
<script type="text/javascript" src='js/pop_center.js'></SCRIPT>

<SCRIPT type="text/javascript">
<!-- 
function chk_combo(frm) {
  if (frm.comboGroup.options[0].selected) {					//선택행위가 없을 경우 중지
	   alert("<?php echo af_txt_alt_selectGroup;?>");
	   return false; 
  }
  else{ 													//그룹을 선택하였을 경우 폼전송
	   frm.group_no.value = frm.comboGroup.options[frm.comboGroup.selectedIndex].value;
	   frm.submit();
  }
}
//-->
</script>


</HEAD>


<BODY>
 <FORM NAME="form1" method="post" action='<?php $_SERVER['PHP_SELF'];?>' onSubmit="return false">

   <input type="hidden" name=list value=<?php echo $list?>>
   <input type="hidden" name=group_no value="">

	<TABLE class="noborder">
		<TR>
			<TD STYLE="text-align:left;background-color:white;height:20px;padding:5px">
				<B><?php echo af_txt_moveForm;?></B>
			</TD>
		</TR>
		<TR>
			<TD STYLE="text-align:left;background-color:white;height:20px;padding:5px" COLSPAN="2">
				 <?php echo af_txt_moveFormAnotherGR;?>
			</TD>
		</TR>
		<TR>
			<TD STYLE="width:30%;height:100px;text-align:center">
				
					
						<input type="hidden" name="mode" value="move">
						<?php echo af_txt_select_group;?> <?php echo f_mkOptArr();?>
					
				
			</TD>			
		</TR>
		<TR>
			<TD STYLE="text-align:center">
				<HR>
			<input type='button' value='<?php echo af_txt_move;?>' id="addBtn" onClick="chk_combo(this.form)">&nbsp;&nbsp;<input type='button' value='<?php echo af_txt_del;?>' onClick='window.close();'>
			</TD>
		</TR>
	</TABLE>
	</FORM>
</BODY>

</HTML>
