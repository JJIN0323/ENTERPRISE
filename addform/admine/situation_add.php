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


$mode = $_POST['mode'];
$get_no = $_GET['situation_no'];							//get 인자로 받은 구분번호
$post_no = $_POST['situation_no'];							//현재페이지 폼으로부터 구분번호
$post_change_no = $_POST['change_no'];						//현재페이지 폼으로부터 이동할번호


$situation_sec1 = "";										//변수 선언
$situation_sec2 = $_POST['situation_sec2'].",";				//입력값 + 구분자
$situation_sec3 = "";										//변수 선언

$situation_color1 = "";										//변수 선언
$situation_color2 = $_POST['situation_color2'].",";			//입력값 + 구분자
$situation_color3 = "";										//변수 선언

?>

<?
#########################################################################################
############################### 전역변수사용을 위한 것 ##################################
#########################################################################################

$re=$DBconn->f_selectDB("*",TABLE2,"where no=1");			//C_CONNECT 클래스 멤버함수인 f_selectDB($field="*",$table,$where="")를 실행하여
															//$re[result]에 저장하고 불러온 레코드 수를 $re[cnt]에 저장 
	
           
              
        $row=mysql_fetch_array($re[result]);				//배열의 요소들을 $row에 대입
															//애드폼환경 테이블  $dummy1 필드의 값
			$dummy1 = explode("|",htmlspecialchars(stripslashes($row["dummy1"])));		
			$arr_situation = explode(",",$dummy1[0]);		
			$arr_situation_color = explode(",",$dummy1[1]);		
			$front_situation = $arr_situation[$get_no-1];	//부모창에서 버튼클릭으로 선택된 상황





#########################################################################################
###################################   추가 mode   #######################################
#########################################################################################

if($mode=="add"){											//추가일 때

 for ($n=0;$n<$post_no;$n++) {
				 $situation_sec1 .= $arr_situation[$n].",";			//인자로 받은 구분자 이전의 글자들
				 $situation_color1 .= $arr_situation_color[$n].",";	
			 }
 for ($n=$post_no;$n<count($arr_situation);$n++) {
				 $situation_sec3 .= $arr_situation[$n].",";	//인자로 받은 구분자 이후의 글자들
				 $situation_color3 .= $arr_situation_color[$n].",";	
			 }		

															//합체
	$situation_mix = $situation_sec1.$situation_sec2.$situation_sec3;
	$c_count = strlen($situation_mix);						//뒷 문자들의 수															
	$situation_mix = substr($situation_mix,-0,$c_count-1);	//뒷 문자에서 쉼표제거
	
	$situation_mix_color = $situation_color1.$situation_color2.$situation_color3;
	$c_count_color = strlen($situation_mix_color);			//뒷 문자들의 수															
	$situation_mix_color = substr($situation_mix_color,-0,$c_count_color-1);	

	$clean = array();
	$clean['no'] = "1";										//번호	
	$clean['dummy1'] = $situation_mix."|".$situation_mix_color;						

	///////	DB에 업데이트	///////
													
		$where="where no = ".$clean['no'];					//문자형일 경우 작은따옴표 붙임에 주의
		$DBconn->f_updateDB(TABLE2,$clean,&$where);			//테이블, 필드와값, 조건절

	///////	DB에 업데이트(접수테이블)	///////
	for ($n=count($arr_situation);$n>$post_no;$n--) {		//끝 상황코드 부터, 추가지점 상황코드 다음까지 역순으로
	$clean2 = array();
	$clean2['situation'] = $n+1;							//코드번호를 1씩 증가
		$where="where situation = ".$n;					    //문자형일 경우 작은따옴표 붙임에 주의
															//테이블, 필드와값, 조건절
		$DBconn->f_updateDB(TABLE4,$clean2,&$where);			
			 }

echo ("
	<script type='text/javascript'>
		opener.location.href='situation_modify.php';		//모드가 새로고침되므로 reload() 로 하지 말것	
		opener.opener.location.reload();
		alert('".af_txt_situation_add_1."');
		top.opener=top.window.close();
	</script>
");
	
}




#########################################################################################
###################################   이동 mode   #######################################
#########################################################################################

if($mode=="move"){											//이동일 때 

	//$post_no												//get 인자로 받고 다시 폼으로 받은 변경대상 숫자
	//$post_change_no 										//현재페이지 폼으로부터 받은 변경숫자

	$clean = array();		
	$clean['situation'] = $post_change_no;						

	///////	DB에 업데이트	///////
													
		$where="where situation = ".$post_no;				//문자형인지 숫자형인지 주의
		$DBconn->f_updateDB(TABLE4,$clean,&$where);			//테이블, 필드와값, 조건절

echo ("
	<script type='text/javascript'>
		opener.location.href='situation_modify.php';		//모드가 새로고침되므로 reload() 로 하지 말것		
		opener.opener.location.reload();
		alert('".af_txt_situation_add_2."');
		top.opener=top.window.close();
	</script>
");
	
}





#########################################################################################
##############################     상황 선택상자 start       ############################
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
    } else if (count($arr[text])) {          
        for ($i=0;$i<count($arr[text]);$i++) {
            $buf.=f_opt($arr[optVal][$i],&$arr[text][$i],$arr["default"],$arr[head]).$arr[text][$i].$arr[tail]."\n";
        }
    }
    
    $buf.="</select>\n";
    return $buf;
}




#########################################################################################
###############     DB 폼환경테이블 dummy1필드로 부터 상황배열 만들기 start      ########
#########################################################################################

function f_mkOptArr(){
global $arr_situation;										 //dummy1필드의 값을 쉼표로 구분한 배열
global $front_situation;

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
		$arr['default']=$front_situation;                    //디폴트로 선택될 text
		$arr[name]="comboGroup";                             //선택상자 이름
		$arr[id]="";                                         //선택상자 객체 구분 아이디
		$arr[style]="";                                      //선택상자 스타일
		$arr[script]="";									 //실행할 스크립트			
		$arr[optVal]=$no;									 //옵션 value		
		$arr[text]=$na;                                      //실렉트 메뉴 배열
		

echo f_SelectBox ($arr);									 //f_SelectBox 함수 실행
}

?>

<?php
if($_GET['mode'] == "add") $title = af_txt_situation_add_add; 
					  else $title = af_txt_situation_add_move;
if($_GET['mode'] == "add") $td_title = af_txt_situation_add_3; 
					  else $td_title = af_txt_situation_add_4;
if($_GET['mode'] == "add") $subject = af_txt_situation_add_5; 
					  else $subject = af_txt_situation_add_6;
if($_GET['mode'] == "add") $act = "Mix(this.form)"; 
					  else $act = "Move(this.form)";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<meta name='robots' content='none,noindex,nofollow'>
<title><?php echo $title;?></title>
<LINK REL="stylesheet" HREF="global.css" TYPE="text/css">
<!--##################################################################################-->
<!--########################	자바스크립트 start	##################################-->
<!--##################################################################################-->
<script type="text/javascript" src='js/pop_center.js'></script>
<script type="text/javascript" src='js/check_input.js'></script>

<script type="text/javascript">	
<!--								 

function Mix(f){
	if(!f.situation_sec2.value){
		alert('<?php echo af_txt_situation_add_7;?>');
		f.situation_sec2.focus();
	}
	else f.submit();								//폼전송
}	

function Move(f){
	if (f.comboGroup.options[0].selected) {			//선택행위가 없을 경우 중지
	   alert("<?php echo af_txt_situation_add_8;?>");
	   return false; 
	}
	else{ 											//선택하였을 경우 히든필드에 값입력
	   f.change_no.value = f.comboGroup.options[f.comboGroup.selectedIndex].value;
	   f.submit();									//폼전송
	}
	
}		

-->
</script>
<!--##################################################################################-->
<!--#################################	자바스크립트 end	##########################-->
<!--##################################################################################-->
</HEAD>

<BODY>
<TABLE CLASS="noborder">
<TR>
	<TD style="text-align:left;padding:20px;background-color:#ffffff">
		<strong style="margin-bottom:10px;"><big><?php echo $td_title;?></big></strong><br />		
		<span style="color:#ff6600"><?php echo $front_situation;?></span><?php echo $subject;?>
	</TD>
</TR>
</TABLE>

<FORM name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" onsubmit="return false">
<input type="hidden" name="mode" value="<?php echo $_GET['mode'];?>">
<input type="hidden" name="situation_no" value="<?php echo $_GET['situation_no'];?>">
<input type="hidden" name="change_no" value="">

<!--
onblur='Numbering(this)' 이벤트:커서를 영역밖으로 이동했을 때, Numbering함수 실행하여, 숫자만 입력했는지 체크
onkeyup='checkKey(addBtn)' 이벤트:checkKey()함수 실행하여, 폼전송
onblur='quot_Del(this)' 이벤트:입력필드항목의 인용부호(따옴표)를 제거
-->


<FIELDSET style="margin:20px;">
	<LEGEND style="margin-bottom:20px;"><strong><?php echo $title;?></strong></LEGEND> 

		<TABLE CLASS="noborder">
			<TR>
				<TD>
				<?php if($_GET['mode'] == "add"){?>
					구분이름 <input type="text" name="situation_sec2" value="" onblur='quot_Del(this)' style='ime-mode:active;'>
					<hr>
					구분색상 <input type="text" name="situation_color2" value="" onblur='quot_Del(this)' style='ime-mode:disabled;'>
				<?php }?>

				<?php if($_GET['mode'] == "move") f_mkOptArr();?>
				</TD>
			</TR>
		</TABLE>

</FIELDSET>

<TABLE CLASS="noborder">
<TR>
	<TD style="text-align:center">		
		<input type="button" value="<?php echo af_txt_confirm;?>" onclick="<?php echo $act;?>" class="btn_set">
	</TD>
</TR>
</TABLE>


</FORM>

</BODY>
</HTML>