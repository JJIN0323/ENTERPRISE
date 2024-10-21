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
#########################################################################################
#################################     폼 이동 start     #################################
#########################################################################################

if($_POST['mode']=="move") {

	$arr = "";
	$clean = "";
	$arr = array();															 //인자로 넘기기 위한 빈 배열선언
	$clean = array();														 //빈 클린 배열 선언

	### addform_table 에서 이전페이지로 부터 받은 그룹번호를 가진 레코드의 정보 가져오기 start ###

	$no = $_POST['parent_no'];												 //이전페이지에서 받아 히든폼으로 넘겨받은 삭제대상 그룹번호
	$where = "where no_group=".$no;											 

	$res=$DBconn->f_selectDB("*",TABLE5,$where);
	$result = $res[result];
	$res_count = mysql_num_rows($res[result]);
	

	for($i = 0; $i < $res_count; $i++){
		$row=mysql_fetch_array($result); 
		$arr[$i]=htmlspecialchars(stripslashes($row[no]));					  //작업대상이 되는 폼번호들 스칼라배열 만듬
		}

	### addform_table 에서 이전페이지로 부터 받은 그룹번호를 가진 레코드의 정보 가져오기 end   ###

		
	if (ctype_digit($_POST['group_no']))									 //변수 세탁(alnum=숫자와알파벳, alpha=알파벳, digit=숫자)
	{
		$clean['no_group'] = $_POST['group_no'];							 //$_POST['group_no'] 현재 페이지에서 선택한 그룹번호
	}											 

			
		$n = count($arr);												     //배열의 크기		

		for ($i=0;$i<$n;$i++) {												 //체크항목만큼 sql 쿼리 반복 처리
		$where="where no = $arr[$i]";									     //값이 문자형일 경우 작은따옴표 붙임에 주의
		$DBconn->f_updateDB(TABLE5,$clean,&$where);							 //테이블, 필드와값, 조건절
		 }
	

	 die("<script>alert('".af_txt_alt_moveGroup_success."');location.href='addform_Group.php';</script>"); //쿼리실행 후 문서 고침 
}


#########################################################################################
#############################     그룹 선택상자 start       #############################
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
			<option value=''>선택하세요</option>			
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
###############     DB에서 그룹정보 가져와서 연관배열 만들기 start       ################
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
<TITLE></TITLE>
<META NAME="author" CONTENT="애드폼">
<LINK REL="stylesheet" HREF="global.css" TYPE="text/css">
<!--외부 스크립트-->
<script type="text/javascript" src='js/check_input.js'></SCRIPT>

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
 <FORM NAME="form1" method="post" action='<?php echo $_SERVER['PHP_SELF'];?>' onSubmit="return false">

 <input type="hidden" name="mode" value="move">
 <!--현재페이지에서 선택상자에서 선택한 값이 들어갈 히든 폼-->
 <input type="hidden" name=group_no value="">
 <!--이전페이지로 부터 get 전송받은 값을 담을 히든 폼-->
 <input type="hidden" name="parent_no" value=<?php echo $_GET['no']?>>

	<TABLE class="noborder">
		<TR>
			<TD STYLE="text-align:left;background-color:white;height:20px;padding:5px">
				<B><?php echo af_txt_moveForm;?></B>
			</TD>
		</TR>
		<TR>
			<TD STYLE="text-align:left;background-color:white;height:20px;padding:5px;color:#ff6600" COLSPAN="2">
				<?php echo af_txt_moveGR_forDelGR_guide;?>
			</TD>
		</TR>
		<TR>
			<TD STYLE="width:30%;height:100px;text-align:center">
				
					
						
						<?php echo af_txt_selectGR_forMove;?> <?php echo f_mkOptArr();?>
					
				
			</TD>			
		</TR>
		<TR>
			<TD STYLE="text-align:center">
				<HR>
			<input type='button' value='이 동' id="addBtn" onClick="chk_combo(this.form)" class="btn_set">
			</TD>
		</TR>
	</TABLE>
	</FORM>
</BODY>

</HTML>
