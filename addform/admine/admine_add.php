<?php
include_once("../lib/lib.php");
include_once("../lib/C_CONNECT.php");
include_once("../lib/define_table.php");
include_once("../lib/authentication.php");
include_once("../function/f_af_formThumbUpload.php");

/* ----------------------------------------------------------------------------------- */
/*	프로그램명 : 애드폼(영문 addform												   */									
/*	프로그램용도: 견적서 주문서 폼메일 제작											   */
/*	제작자: 박성규																	   */
/*	공식배포처: http://www.addform.net												   */
/*  프로그램 편집시 위 제작자 정보를 편집하거나 삭제해서는 안됩니다.				   */
/* ----------------------------------------------------------------------------------- */

//첨부파일있을 때 업로드 함수 실행
$f_af_formThumbUpload = f_af_formThumbUpload();					   //사원사진 업로드
$af_arr_format = array("jpg","jpeg","gif");						   //업로드 된 허용확장자
							
#########################################################################################
#################################  모드가 추가일 때  ####################################
#########################################################################################
if($_POST['mode']=="add"){
	$clean=array();	
		$clean["no"] = $_POST["no"];							//고유번호
		$clean["level"] = $_POST["level"];						//레벨
		$clean["user_id"] =  $_POST["user_id"];					//아이디
		$clean["password"] = $_POST["password"];				//비밀번호
		$clean["name"] = $_POST["name"];						//이름
		$clean["email_address"] = $_POST["email_address"];		//이메일
		$clean["tel"] = $_POST["tel"];							//전화번호
		$clean["hp"] = $_POST["hp"];							//
		$clean["fax"] = $_POST["fax"];							//
		$clean["supply_name"] = $_POST["supply_name"];			//폼추가시 자동입력 상호	
		$clean["supply_num"] = $_POST["supply_num"];			//폼추가시 자동입력 사업자번호	
		$clean["supply_man"] = $_POST["supply_man"];			//폼추가시 자동입력 대표	
		$clean["supply_address"] = $_POST["supply_address"];	//폼추가시 자동입력 주소
		$clean["supply_conditions"] = $_POST["supply_conditions"];	//폼추가시 업태
		$clean["supply_item"] = $_POST["supply_item"];			//폼추가시 자동입력 종목
		$clean["sell_num"] = $_POST["sell_num"];				//통신판매번호
		$clean["banking"] = $_POST["banking"];					//폼추가시 자동입력 은행정보	
		$clean['join_date'] = time();							//가입시각
		//$clean["edit_date"] = $_POST["edit_date"];				//수정시각	
		$clean["dummy1"] = $_POST["dummy1"];					//부서명					
		$clean["dummy2"] = $_POST["dummy2"];					//직위					
		$clean["dummy3"] = $_POST["dummy3"];					//비고				 
		$clean["dummy4"] = $_POST["dummy4"];					
		$clean["dummy5"] = $_POST["dummy5"];					
		$clean["dummy6"] = $_POST["dummy6"];				
		$clean["dummy7"] = $_POST["dummy7"];				
		$clean["dummy8"] = $_POST["dummy8"];				
		$clean["dummy9"] = $_POST["dummy9"];				
		$clean["dummy10"] = $_POST["dummy10"];
		$clean["dummy11"] = $_POST["dummy11"];				 
		$clean["dummy12"] = $_POST["dummy12"];				
		$clean["dummy13"] = $_POST["dummy13"];				
		$clean["dummy14"] = $_POST["dummy14"];				 
		$clean["dummy15"] = $_POST["dummy15"];				
		$clean["dummy16"] = $_POST["dummy16"];				
		$clean["dummy17"] = $_POST["dummy17"];				
		$clean["dummy18"] = $_POST["dummy18"];				
		$clean["dummy19"] = $_POST["dummy19"];				
		$clean["dummy20"] = $_POST["dummy20"];


		
        ####################  아이디 중복검사 start  ####################		
		$user_id = $clean['user_id'];							 //중복검사를 위한 $user_id 정의
		$where = "where user_id='$user_id'";					 //조건절
		$res=$DBconn->f_selectDB("*",TABLE1,$where);			 //필드, 테이블, 조건절
		if($res[cnt] > 0) die("<script>history.back();alert('이미 $user_id 아이디는 존재합니다. User ID already exists');</script>");
		####################  아이디 중복검사 end   #####################
		
		####################  패스워드 일치검사 start  ##################		
		if($clean['password']!=$_POST['password_test'])			 //비밀번호가 서로 다를 경우
		{
		 die ("<script>alert('".af_txt_modify_admine_2."');window.history.go(-1);</script>");
		}	
		else $clean['password'] = MD5($clean['password']);
		####################  패스워드 일치검사 end  ####################

	
		//C_CONNECT 클래스 멤버함수인 f_InsertDB($table,$array)에서,  $array 인자로 사용될 스칼라배열을 만듬		
		//$array[]=array($code[$i],$name[$i]);					 //DB 입력할 필드수만큼 쉼표로 구분나열하여 array
		
		//DB 입력f_InsertDB(테이블이름,&$array)	
		$DBconn->f_InsertDB(TABLE1,&$clean);					 //&$clean배열을 참조연산자&로 넘겨주어 보다 빠르게 처리

		
		
		//문서 새로 고침
		 die("<script type='text/javascript'>alert('신규 관리사원을 등록하였습니다. 계속해서 신규사원을 등록할 수 있습니다.');window.opener.location.reload();</script><meta http-equiv=refresh content='0;url=".URL."'>");
		
}



#########################################################################################
##################################  모드가 수정일 때  ###################################
#########################################################################################
if($_POST['mode']=="modify_ok"){
	if($_POST['thumbDel'] == "1")								   //사원사진 삭제
	{
		for($i = 0;$i < count($af_arr_format);$i++)
		{
		@unlink("../upload/member_pic/".$_POST['user_id'].".".$af_arr_format[$i]."");		
		}
	}
	
	$where = "";
	$clean=array();
	
		$clean["no"] = $_POST["no"];							//고유번호
		$clean["level"] = $_POST["level"];						//레벨
		//$clean["user_id"] =  $_POST["user_id"];					//아이디
		$clean["password"] = $_POST["password"];				//비밀번호
		$clean["name"] = $_POST["name"];						//이름
		$clean["email_address"] = $_POST["email_address"];		//이메일
		$clean["tel"] = $_POST["tel"];							//전화번호
		$clean["hp"] = $_POST["hp"];							//
		$clean["fax"] = $_POST["fax"];							//
		//$clean["supply_name"] = $_POST["supply_name"];			//폼추가시 자동입력 상호	
		//$clean["supply_num"] = $_POST["supply_num"];			//폼추가시 자동입력 사업자번호	
		//$clean["supply_man"] = $_POST["supply_man"];			//폼추가시 자동입력 대표	
		$clean["supply_address"] = $_POST["supply_address"];	//폼추가시 자동입력 주소
		//$clean["supply_conditions"] = $_POST["supply_conditions"];	//폼추가시 업태
		//$clean["supply_item"] = $_POST["supply_item"];			//폼추가시 자동입력 종목
		//$clean["sell_num"] = $_POST["sell_num"];				//통신판매번호
		//$clean["banking"] = $_POST["banking"];					//폼추가시 자동입력 은행정보	
		//$clean['join_date'] = time();							//가입시각
		$clean['edit_date'] = time();							//수정시각
		$clean["dummy1"] = $_POST["dummy1"];					//부서명					
		$clean["dummy2"] = $_POST["dummy2"];					//직위					
		$clean["dummy3"] = $_POST["dummy3"];					//비고			 
		$clean["dummy4"] = $_POST["dummy4"];					
		$clean["dummy5"] = $_POST["dummy5"];					
		$clean["dummy6"] = $_POST["dummy6"];				
		$clean["dummy7"] = $_POST["dummy7"];				
		$clean["dummy8"] = $_POST["dummy8"];				
		$clean["dummy9"] = $_POST["dummy9"];				
		$clean["dummy10"] = $_POST["dummy10"];
		$clean["dummy11"] = $_POST["dummy11"];				 
		$clean["dummy12"] = $_POST["dummy12"];				
		$clean["dummy13"] = $_POST["dummy13"];				
		$clean["dummy14"] = $_POST["dummy14"];				 
		$clean["dummy15"] = $_POST["dummy15"];				
		$clean["dummy16"] = $_POST["dummy16"];				
		$clean["dummy17"] = $_POST["dummy17"];				
		$clean["dummy18"] = $_POST["dummy18"];				
		$clean["dummy19"] = $_POST["dummy19"];				
		$clean["dummy20"] = $_POST["dummy20"];


			
		$where = "where no=".$clean['no'];						//조건절

		################# 수정시 패스워드 일치검사 start  ###############		
		if(!$clean['password'] && !$_POST['password_test'])		//비밀번호 입력이 없을 경우
		{	
			$clean['password'] = $_POST['pass_origin'];
		}
		else if($clean['password'] && $_POST['password_test'])	//둘다 입력했을 경우    
		{
			if($clean['password']!=$_POST['password_test'])		//비밀번호가 비밀번호확인과 서로 다를 경우
			{
				die ("<script type='text/javascript'>alert('".af_txt_modify_admine_2."');window.history.go(-1);</script>");
			}
			else $clean['password'] = MD5($clean['password']);	//비밀번호가 비밀번호확인과 일치할 때
		}	
		else													//둘 중 하나만 입력했을 경우
		{
			if($clean['password'])								
			{
				$clean['password'] = MD5($clean['password']);
			}
			else												//비밀번호 확인만 입력시엔 경고출력
			{
				die ("<script type='text/javascript'>alert('".af_txt_modify_admine_2."');window.history.go(-1);</script>");
			}
		}
		####################  패스워드 일치검사 end  ####################
	
		//C_CONNECT 클래스 멤버함수인 f_updateDB($table,$arr,$where="")에서,  $array 인자로 사용될 스칼라배열을 만듬		
		 $DBconn->f_updateDB(TABLE1,&$clean,$where);			//&$clean배열을 참조연산자&로 넘겨주어 보다 빠르게 처리
		//DB 입력 후 문서 고침
		if($_POST[dummy] == "1")
		{	//내정보 수정일때 권한상관없이 수정가능하게 no 인자 제거
			die("<script type='text/javascript'>alert('수정되었습니다.');window.opener.location.reload();</script>;<meta http-equiv=refresh content='0;url=".URL."?&amp;mode=modify'>");			
		}
		else
		{
			die("<script type='text/javascript'>alert('수정되었습니다.');window.opener.location.reload();</script>;<meta http-equiv=refresh content='0;url=".URL."?no=".$_POST['no']."&amp;mode=modify'>");
		}
		
}

?>
<?php
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
			<option value='10'>등급선택</option>			
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
		

echo f_SelectBox($arr);										 //f_SelectBox 함수 실행
}
?>



<!--##################################################################################-->
<!--###########################      수정일 때, 정보가져오기 start  ##################-->
<!--##################################################################################-->
<?php
if($_GET['mode']=="modify")
{
	if($_GET['no']){$no = $_GET['no'];}
	else		   {$no = $af_adminMember["no"];}	
$where="where no=$no";
$re=$DBconn->f_selectDB("*",TABLE1,$where);									//수정 모드일 때는 해당 테이블에서 정보가져옴
$result = $re[result];
$row =  mysql_fetch_array($result);

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
}
?>

<!--##################################################################################-->
<!--################################  HTML start  ####################################-->
<!--##################################################################################-->
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>

<HEAD>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<meta name='robots' content='none,noindex,nofollow'>
<TITLE>애드폼 관리사원 <?php if($_GET['mode']=="modify") echo "수정";else echo "등록";?></TITLE>
<META NAME="author" CONTENT="애드폼">
<LINK REL="stylesheet" HREF="global.css" TYPE="text/css">

<style type="text/css">
/* 폼 라벨 스타일 설정 */
#form1 .label {
	float: left;
	clear: left;
	width: 150px;
	margin-right: 10px;
	padding-right:5px;
	text-align: right;
	color:#616588;	
	border-width: 1px;
	border-bottom-style: dotted;
	border-color: #999999;
}
</style>

<script type="text/javascript" src='js/check_input.js'></script>
<script type="text/javascript" src='js/chk_null.js'></script>
<script type="text/javascript" src='js/only_en.js'></script>
<script type="text/javascript" src='js/pop_center.js'></script>

</HEAD>

<!--//////////////////////////////////////////////////////////////////////////////////-->
<!--################################  BODY start  ####################################-->
<!--//////////////////////////////////////////////////////////////////////////////////-->
<BODY>

<DIV> 
	<div id="main_left">	
	
   	<FORM NAME="form1" id="form1" method="post" action='<?php echo $_SERVER['PHP_SELF'];?>' enctype='multipart/form-data' onsubmit='return false;'>
	<INPUT TYPE="hidden" NAME="NAX_FILE_SIZE" value="20000000">


	<?php if(!$_GET['mode']) {?>
	<input type="hidden" name="mode" value="add">
	<?}?>
	<?php if($_GET['mode']=="modify") {?>
	<input type="hidden" name="mode" value="modify_ok">
	<input type="hidden" name="no" value="<?php echo $no;?>">	
	<input type="hidden" name="pass_origin" value="<?php echo $html["password"];?>">
		<?php if(!$_GET[no])
			//수정모드에서 권한없어도 자기정보는 수정할 수 있게 임시추가한 히든필드
			echo "<input type='hidden' name='dummy' value='1'>";
		?>
	<?}?>		

			
	<TABLE class="noborder">
		<TR>
			<TD colspan="2" style="background-color:white;text-align:left">
				<strong>관리사원 <?php if($_GET['mode']=="modify") echo "수정";else echo "등록";?></strong>
			</TD>
		</TR>
		<TR>
			<TD style="background-color:white;text-align:left">			
				<?php
				if($_GET['mode']=="") echo 	"<P>애드폼 관리사원을  등록합니다.</P>";
				if($_GET['mode']=="modify")
				{
					echo "<p>등록번호 : <strong>".$html["no"]."</strong><br>등록날짜: ".date("Y년m월j일H시i분",$html["join_date"])."";
					if($html["edit_date"]) echo "<br>최근수정: ".date("Y년m월j일H시i분",$html["edit_date"])."";
					echo "</p>";
				}
				?>
			</TD>
			<TD style="background-color:white;text-align:right;font-size:2em;font-weight:bold;color:#669999;padding-right:30px;">
				<?php 
					if($html["level"])
					{
						if($html["level"] == 1)	echo "".$html["level"]."급사원<span style='font-weight:bold;color:red'>(최고관리자)</span>";
						else					echo "".$html["level"]."급사원"; 
					}
				?>				
			</TD>
		</TR>		
	</TABLE>
	<HR>
	
	<!-- /////////////////////////////  	썸네일 이미지   //////////////////////////-->
	<DIV class="sms_wrapper">
	<FIELDSET>
		<LEGEND>사/진/등/록</LEGEND>
		<TABLE class="noborder">
			<TR>
				<TD style="text-align:center;padding:10px;width:133px;">
					<?php
					$z_token = 0;
					for($z=0; $z < count($af_arr_format);$z++)
						{						
						if(file_exists("../upload/member_pic/".$html["user_id"].".".$af_arr_format[$z].""))
							{					
							echo "<img src='../upload/member_pic/".$html["user_id"].".".$af_arr_format[$z]."' style='vertical-align:middle;width:85px;height:113px;border:5px solid #fff;' alt='사원사진'>";
							echo "<br><input type='checkbox' name='thumbDel' value='1'> 사진삭제";
							$z_token++;
							}					
						}
					if($z_token==0) echo "<img src='img/man.jpg' style='border:5px solid #fff;'>";
					?>
				</TD>		
				<TD style="text-align:left;padding:10px;">
					<input type="file" name="member_pic"><br>85px * 113px <?php echo af_txt_form_add_64;?>(gif,jpg)	
				</TD>
			</TR>		
		</TABLE>		
	</FIELDSET>
	</DIV>

	<!-- ///////////////////////////////	기본설정 (필수)   ////////////////////////-->	
	<DIV class="sms_wrapper">
	<FIELDSET>
		<LEGEND>사/원/정/보</LEGEND>
		<!--	이름	-->
		<P>
			<label for="name" class="label">* 이름</label>
			<INPUT TYPE="text" class="ess" NAME="name" id="name" style="ime-mode:active;"  onblur='quot_Del(this);' VALUE="<?php echo $html["name"];?>">
		</P>

		<!--	아이디	-->
		<P>
			<label for="user_id" class="label">* 아이디</label>
			<INPUT TYPE="text" class="ess" NAME="user_id" id="user_id" style="ime-mode:disabled;"  onblur='quot_Del(this);' VALUE="<?php echo $html["user_id"];?>" <?php if($_GET['mode']=="modify") echo "readonly";?>>
			<?php if(!$_GET['mode']){?>
			<INPUT TYPE="button" value="<?php echo af_txt_form_add_btnDubleChk;?>" onclick="window.open('chk_id.php?user_id='+this.form.user_id.value+'','chk_id','width=100,height=100,statusbar=no,scrollbars=no,toolbar=no')">
			<?php }?>
		</P>
		
		<!--	비밀번호	-->
		<P>
			<label for="password" class="label">* <?php echo af_txt_modify_admine_6;?></label>			
			<input type="password" name="password" id="password" onblur="quot_Del(this)" value="" <?php if($_GET['mode']=="modify" && $af_adminMember["level"] == '1') echo "class=''"; else echo "class='ess'";?>>
		</P>
		<!--	비밀번호확인-->		
		<P>
			<label for="password_test" class="label">* <?php echo af_txt_modify_admine_7;?></label>
			<input type="password" name="password_test" id="password_test" onblur="quot_Del(this)" value="" <?php if($_GET['mode']=="modify" && $af_adminMember["level"] == '1') echo "class=''"; else echo "class='ess'";?>>
		</P>

		<!--	등급	-->
		<P>
			<label for="combolevel" class="label">* 등급</label>
			<?php 
			if($af_adminMember["user_id"]==$html["user_id"])
				{	
					echo $html["level"]." 등급";//자신의 등급은 변경하지 못하게...
				}
			else
				{					
					echo f_mkOptArr("combolevel",$html["level"],"onchange='this.form.level.value=this.options[this.selectedIndex].value;'");
				}
			?>		
			<input type="hidden" name="level" value="<?php if($html["level"]) echo $html["level"]; else echo "10";?>">			
			<span style='color:gray;'> * 1등급이 가장 높은등급입니다.</span>			
		</P>
				
		<!--	이메일	-->
		<P>
			<label for="email_address" class="label">* 이메일</label>		
				<INPUT TYPE="text" NAME="email_address" id="email_address" onblur='quot_Del(this);' STYLE="IME-MODE: disabled;" VALUE="<?php echo $html["email_address"];?>" class="ess">				
		</P>
		

		<!--	일반전화	-->
		<P>
			<label for="tel" class="label">일반전화</label>
			<INPUT TYPE="text" NAME="tel" id="tel"  onblur='quot_Del(this);' VALUE="<?php echo $html["tel"];?>">
		</P>

		<!--	이동전화	-->
		<P>
			<label for="hp" class="label">이동전화</label>
			<INPUT TYPE="text" NAME="hp" id="hp"  onblur='quot_Del(this);' VALUE="<?php echo $html["hp"];?>">
		</P>

		<!--	팩시밀리	-->
		<P>
			<label for="fax" class="label">팩시밀리</label>
			<INPUT TYPE="text" NAME="fax" id="fax"  onblur='quot_Del(this);' VALUE="<?php echo $html["fax"];?>">
		</P>
		
		<!--	부서명	-->
		<P>
			<label for="dummy1" class="label">부서명</label>
			<INPUT TYPE="text" NAME="dummy1" id="dummy1" style="ime-mode:active;" onblur='quot_Del(this);' VALUE="<?php echo $html["dummy1"];?>">
		</P>

		<!--	직위	-->
		<P>
			<label for="dummy2" class="label">직위</label>
			<INPUT TYPE="text" NAME="dummy2" id="dummy2" style="ime-mode:active;" onblur='quot_Del(this);' VALUE="<?php echo $html["dummy2"];?>">
		</P>

		<!--	주소	-->
		<P>
			<label for="supply_address" class="label">주소</label>
			<INPUT TYPE="text" NAME="supply_address" id="supply_address" style="ime-mode:active;" onblur='quot_Del(this);' VALUE="<?php echo $html["supply_address"];?>" size="50">
		</P>

		<!--	비고	-->
		<P>
			<label for="dummy3" class="label">비고</label>
			<textarea name="dummy3" rows="5" cols="45" style="ime-mode:active;"><?php echo $html["dummy3"];?></textarea>			
		</P>
	</FIELDSET>
	</DIV>

	<DIV style="text-align:center">
		<!-- 수정,추가 버튼 -->
		<input type='button' <?php if($_GET['mode']=="modify") echo "value='수정하기'"; else echo "value='등 록'";?> id="addBtn" onclick="chk_email(this.form,this.form.email_address);" class="btn_set">
		<!-- 닫기 버튼 -->
		<input type='button' value='<?php echo af_txt_closeWin;?>' onClick='window.close();' class="btn_set">
	</DIV>					
	</FORM>
	</div>
</DIV>
</BODY>

</HTML>
