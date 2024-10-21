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


#########################################################################################
##################################   모드가 수정일 때   #################################
#########################################################################################
if($_POST['mode']=="modify"){
	$where = "";
	$clean=array();	
		$clean['no'] = $_POST['no'];                               //번호	
		$clean['level'] = $_POST['level'];						   //레벨
		$clean['user_id'] = $_POST['user_id'];                     //아이디		
		$clean['password'] = $_POST['password'];				   //비밀번호	
		$password_test = $_POST['password_test'];				   //비밀번호 확인
		$pass_origin = $_POST['pass_origin'];					   //원래비밀번호
		$clean['name'] = $_POST['name'];			               //이	름
		$clean['email_address'] = $_POST['email_address'];		   //이메일
		$clean['tel'] = $_POST['tel'];							   //전화번호
		
		//$clean['join_date'] = $_POST['join_date'];			   //생성시각
		$clean['edit_date'] = $_POST['edit_date'];			       //수정시각	


		$clean['edit_date'] = time();							   //수정시각	
		$where = "where no=".$clean['no'];						   //조건절

	if(!$clean['password'] && !$password_test){						//비밀번호 입력이 없을 경우
		$clean['password'] = $pass_origin;
		//C_CONNECT 클래스 멤버함수인 f_updateDB($table,$arr,$where="")에서,  $array 인자로 사용될 스칼라배열을 만듬		
		 $DBconn->f_updateDB(TABLE1,&$clean,$where);			//&$clean배열을 참조연산자&로 넘겨주어 보다 빠르게 처리
		//DB 입력 후 문서 고침
		 die("<script>alert('".af_txt_modify_admine_1."');document.location.href='modify_admine.php';</script>");
	}

	if($clean['password']!=$password_test){						   //비밀번호가 서로 다를 경우
		 die ("<script>alert('".af_txt_modify_admine_2."');window.history.go(-1);</script>");
	}	
	else $clean['password'] = MD5($clean['password']);
		
		//C_CONNECT 클래스 멤버함수인 f_updateDB($table,$arr,$where="")에서,  $array 인자로 사용될 스칼라배열을 만듬		
		 $DBconn->f_updateDB(TABLE1,&$clean,$where);			//&$clean배열을 참조연산자&로 넘겨주어 보다 빠르게 처리
		//DB 입력 후 문서 고침
		 die("<script>alert('".af_txt_modify_admine_1."');document.location.href='modify_admine.php';</script>");
	
}

?>



<!--##################################################################################-->
<!--#########################	 정보가져오기 start  #################################-->
<!--##################################################################################-->
<?php

if(!$_GET['mode'] or !$_POST['mode']){
													
$where="";

$re=$DBconn->f_selectDB("*",TABLE1,$where);									
$result = $re[result];
$row =  mysql_fetch_array($result);				
		
		$no = htmlspecialchars(stripslashes($row["no"]));								//번호
		$level = htmlspecialchars(stripslashes($row["level"]));							//레벨
		$user_id = htmlspecialchars(stripslashes($row["user_id"]));						//아이디
		$password = htmlspecialchars(stripslashes($row["password"]));					//비밀번호
		$name = htmlspecialchars(stripslashes($row["name"]));							//이	름
		$email_address = htmlspecialchars(stripslashes($row["email_address"]));			//관리자 이메일
		$tel = htmlspecialchars(stripslashes($row["tel"]));								//전화번호(공급자)
		$supply_name = htmlspecialchars(stripslashes($row["supply_name"]));				//사업자상호(공급자)
		$supply_num =htmlspecialchars(stripslashes( $row["supply_num"]));				//사업자등록번호(공급자)
		$supply_man = htmlspecialchars(stripslashes($row["supply_man"]));				//사업자대표(공급자)
		$supply_address = htmlspecialchars(stripslashes($row["supply_address"]));		//사업장주소(공급자)
		$supply_conditions = htmlspecialchars(stripslashes($row["supply_conditions"]));	//업태(공급자)
		$supply_item = htmlspecialchars(stripslashes($row["supply_item"]));				//종목(공급자)	
		$banking = htmlspecialchars(stripslashes($row["banking"]));						//은행계좌정보
		$join_date = htmlspecialchars(stripslashes($row["join_date"]));
		$edit_date = htmlspecialchars(stripslashes($row["edit_date"]));

		$bankingArr = explode("|",$banking);				//banking 필드의 구분자로 부터 배열화
			$bank_name = $bankingArr[0];					//첫번째 배열요소를 은행이름으로...
			$bank_num = $bankingArr[1];						//두번째 배열요소를 계좌번호로...
			$bank_who = $bankingArr[2];						//세번째 배열요소를 예금주로..	
}
?>


<!--##################################################################################-->
<!--###############################  HTML start  #####################################-->
<!--##################################################################################-->
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>

<HEAD>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<meta name='robots' content='none,noindex,nofollow'>
<TITLE></TITLE>
<META NAME="author" CONTENT="">
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
<script type="text/javascript">
function only_en(frm,fval){

    var pattern = /(^[a-zA-Z0-9\-_]+$)/;
    if(!pattern.test(fval) || fval.length > 10 || fval.length < 1)
	{
        alert('아이디를 10자이하의 영문과 숫자의 조합으로 입력하여 주십시오.\n\n Enter a few characters,10');
		frm.focus();
		frm.value=""; 
		return false;        
    }
	else
	{
        chk_null(document.form1);
    }
}
</script>

</HEAD>


<BODY>

<DIV>
<div id="main_left">
<H1 id="en">ADMINISTRATOR</H1>
<H2><?php echo af_txt_modify_admine_3;?></H2>
<p>
애드폼설치 후, 가장 먼저, 관리자 아이디와 비밀번호를 변경하는것이 좋습니다.<br>
보안상 아파치 자체인증을 사용하여, 아이디와 비밀번호를 분실시 관리자도 웹상에서 확인할 방법이 없으므로, 잘 보관해 둡니다.<br>
로그아웃은 웹브라우저를 완전히 닫는것으로 인증이 종료되므로, 공공PC 에서 사용후엔, 반드시 창을 닫습니다.<br>
관리자 아이디와 비밀번호는, 신뢰할 수 없는 관계자와 공유해서는 안되고, 최소한의 관리자를 둡니다.
</p>
<FORM NAME="form1" id="form1" method="post" action='<?php echo $_SERVER['PHP_SELF'];?>' onsubmit='return false;'>	
	<input type="hidden" name="no" value="<?php echo $no?>">
	<input type="hidden" name="level" value="<?php echo $level?>">
	<input type="hidden" name="pass_origin" value="<?php echo $password?>">
	<input type="hidden" name="mode" value="modify">


<FIELDSET>
<LEGEND><?php echo af_txt_modify_admine_4;?></LEGEND>
			
	<P>
		<label for="" class="label"><?php echo af_txt_modify_admine_5;?></label>			
			 <input type="text" name="user_id" id="user_id" onblur="quot_Del(this)" value="<?php echo $user_id?>" style="ime-mode:disabled" class='ess'>
	</P>
		
	<P>
		<label for="password" class="label"><?php echo af_txt_modify_admine_6;?></label>			
			 <input type="password" name="password" id="password" onblur="quot_Del(this)" value="" class='ess'>
	</P>
			
	<P>
		<label for="password_test" class="label"><?php echo af_txt_modify_admine_7;?></label>
			 <input type="password" name="password_test" id="password_test" onblur="quot_Del(this)" value="" class='ess'>
	</P>
			
	<P>
		<label for="name" class="label"><?php echo af_txt_modify_admine_8;?></label>
			 <input type="text" name="name" id="name" onblur="quot_Del(this)" value="<?php echo $name?>" style="ime-mode:active" class='ess'>
	 </P>

	<P style="display:none;">
		<label for="email_address" class="label"><?php echo af_txt_modify_admine_9;?></label>
			    <INPUT TYPE="text" NAME="email_address" id="email_address" VALUE="<?php echo $email_address?>"  STYLE="ime-mode:disabled">
	</P>
			
	<P style="display:none;">
		<label for="tel" class="label"><?php echo af_txt_modify_admine_10;?></label>
			 <input type="text" name="tel" id="tel" onblur="quot_Del(this)"  value="<?php echo $tel?>">
	</P>			
		

</FIELDSET>





<div style="text-align:center"> 
	<input type='button' value='<?php echo af_txt_modify;?>' id="addBtn" onclick="only_en(this.form.user_id,this.form.user_id.value);" class="btn_set">	
</div>																			
			
</FORM>
</div>
</DIV>
</BODY>

</HTML>
