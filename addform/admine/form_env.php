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
		
		$clean['supply_name'] = $_POST['supply_name'];			   //사업자상호
		$clean['supply_num'] = $_POST['supply_num'];			   //사업자등록번호
		$clean['supply_man'] = $_POST['supply_man'];			   //사업자대표
		$clean['supply_address'] = $_POST['supply_address'];	   //사업장주소
		$clean['supply_conditions'] = $_POST['supply_conditions']; //업	태
		$clean['supply_item'] = $_POST['supply_item'];			   //종	목
		$clean['sell_num'] = $_POST['sell_num'];				   //통신판매번호
		$clean['tel'] = $_POST['tel'];							   //대표전화
		$clean['fax'] = $_POST['fax'];							   //팩스
		$clean['email_address'] = $_POST['email_address'];		   //이메일
		$clean['banking'] = $_POST['banking'];					   //계좌번호
		//$clean['join_date'] = $_POST['join_date'];			   //생성시각
		$clean['edit_date'] = $_POST['edit_date'];			       //수정시각	


		$clean['edit_date'] = time();							   //수정시각	
		$where = "where no=".$clean['no'];						   //조건절

	$clean2=array();
		$clean2['no'] = $_POST['no'];
		$clean2['lang'] = $_POST['lang'];						   //언어설정
		$clean2['od_unit'] = $_POST['od_unit'];					   //규격/단위
		$clean2['coin_unit'] = $_POST['coin_unit'];			       //통화단위
		$clean2['upload_space'] = $_POST['upload_space'];		   //업로드 폴더 용량
		$clean2['upload_space_per'] = $_POST['upload_space_per'];  //경고시작용량 %
		$clean2['upload_use_alert'] = $_POST['upload_use_alert'];  //경고여부 0,1
		$clean2['dummy2'] = $_POST['dummy2'];					   //첨부파일타겟(이메일0,서버1)
		$clean2['dummy3'] = $_POST['dummy3'];					   //폼분류 선택상자 표시여부(0,1)


	
		//C_CONNECT 클래스 멤버함수인 f_updateDB($table,$arr,$where="")에서,  $array 인자로 사용될 스칼라배열을 만듬		
		 $DBconn->f_updateDB(TABLE1,&$clean,$where);			   //addform_admine_table 업데이트 
		 $DBconn->f_updateDB(TABLE2,&$clean2,$where);			   //addform_env 테이블 업데이트
		//DB 입력 후 문서 고침
		 die("<script>alert('".af_txt_form_env_1."');window.top.location.href='index.html';</script>");
	}

?>



<!--##################################################################################-->
<!--#########################	 정보가져오기 start  #################################-->
<!--##################################################################################-->
<?php

if(!$_GET['mode'] or !$_POST['mode']){
													
$where="";
//addform_admine_table 로 부터 가져오기
$re=$DBconn->f_selectDB("*",TABLE1,$where);									
$result = $re[result];
$row =  mysql_fetch_array($result);				
		
		$no = htmlspecialchars(stripslashes($row["no"]));								//번호
		
		$supply_name = htmlspecialchars(stripslashes($row["supply_name"]));				//사업자상호(공급자)
		$supply_num =htmlspecialchars(stripslashes( $row["supply_num"]));				//사업자등록번호(공급자)
		$supply_man = htmlspecialchars(stripslashes($row["supply_man"]));				//사업자대표(공급자)
		$supply_address = htmlspecialchars(stripslashes($row["supply_address"]));		//사업장주소(공급자)
		$supply_conditions = htmlspecialchars(stripslashes($row["supply_conditions"]));	//업태(공급자)
		$supply_item = htmlspecialchars(stripslashes($row["supply_item"]));				//종목(공급자)	
		$sell_num = htmlspecialchars(stripslashes($row["sell_num"]));					//통신판매번호
		$tel = htmlspecialchars(stripslashes($row["tel"]));								//대표전화
		$fax = htmlspecialchars(stripslashes($row["fax"]));								//팩스번호
		$email_address = htmlspecialchars(stripslashes($row["email_address"]));			//이메일
		$banking = htmlspecialchars(stripslashes($row["banking"]));						//은행계좌정보
		$join_date = htmlspecialchars(stripslashes($row["join_date"]));
		$edit_date = htmlspecialchars(stripslashes($row["edit_date"]));

		$bankingArr = explode("|",$banking);				//banking 필드의 구분자로 부터 배열화
			$bank_name = $bankingArr[0];					//첫번째 배열요소를 은행이름으로...
			$bank_num = $bankingArr[1];						//두번째 배열요소를 계좌번호로...
			$bank_who = $bankingArr[2];						//세번째 배열요소를 예금주로..	

//addform_env 테이블로 부터 가져오기
$re2=$DBconn->f_selectDB("*",TABLE2,$where);									
$result2 = $re2[result];
$row2 =  mysql_fetch_array($result2);				
		$lang = htmlspecialchars(stripslashes($row2["lang"]));							//언어설정
		$od_unit = htmlspecialchars(stripslashes($row2["od_unit"]));					//규격/단위
		$coin_unit = htmlspecialchars(stripslashes($row2["coin_unit"]));				//통화 단위
		$upload_space = htmlspecialchars(stripslashes($row2["upload_space"]));			//업로드 폴더 알림 설정용량
		$upload_space_per = htmlspecialchars(stripslashes($row2["upload_space_per"]));	//경고수위
		$upload_use_alert = htmlspecialchars(stripslashes($row2["upload_use_alert"]));	//알림설정 사용여부 0,1
		$dummy2 = htmlspecialchars(stripslashes($row2["dummy2"]));						//첨부파일타겟(이메일0,서버1)
		$dummy3 = htmlspecialchars(stripslashes($row2["dummy3"]));						//폼분류 선택상자표시(0,1)

		
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
<script type="text/javascript" src='js/only_en.js'></SCRIPT>
<script type="text/javascript" src='js/chk_null.js'></script>
<script type="text/javascript" src='js/format_byte.js'></script>

<script type="text/javascript">	
<!--								 

function Mix(f){											//은행계좌정보 필드값 합치기
	
	var val_name = f.bank_name.value;
	var val_num = f.bank_num.value;
	var val_who = f.bank_who.value;	
	
		var mix_data ="" 
			+val_name+"|"
			+val_num+"|"
			+val_who;
														
	f.banking.value = mix_data;
	//f.submit();

	
}		

-->
</script>


</HEAD>


<BODY onload="document.form1.upload_space_ex.value=document.form1.upload_space.value/1000/1000;">

<DIV>
<div id="main_left">
<H1 id="en">ENVIRONMENT</H1>
<H2><?php echo af_txt_form_env_2;?></H2>
<FORM NAME="form1" id="form1" method="post" action='<?php echo $_SERVER['PHP_SELF'];?>' onsubmit='return false;'>	
	<input type="hidden" name="no" value="<?php echo $no?>">
	<input type="hidden" name="level" value="<?php echo $level?>">
	<input type="hidden" name="pass_origin" value="<?php echo $password?>">
	<input type="hidden" name="mode" value="modify">


<FIELDSET>
<LEGEND><?php echo af_txt_form_env_3;?></LEGEND>
		
<!--##################################################################################-->
<!--#############################  언어설정 가져오기 start  ##########################-->
<!--##################################################################################-->
<?php
//언어 스킨폴더 이름가져오기
function f_skin($directory){
 global $lang;							//설정된 언어 $lang 외부변수 

 $dir=$directory;						//디렉토리 경로
 $handle=opendir($dir);
 while ($dirs = readdir($handle))
 {
  if(!eregi("\.",$dirs))				//파일이 아닌 디렉토리인 경우
  {										//폴더 이름과 같을 경우
   if($dirs==$lang)
	   $select="selected";				//선택되게...
   else $select="";
   echo"<option value='$dirs' $select>$dirs</option>"."\n";
  }
 }
 closedir($handle);
}
?>
	<p>
	<label for="comboLang" class="label"><?php echo af_txt_form_env_3;?></label>	
	<select name='comboLang' id='comboLang' onchange='document.form1.lang.value=options[options.selectedIndex].value'>		
	<?php echo f_skin("../lib/lang");?>					
	</select>
	<input type='hidden' name='lang' value="<?php if($lang) echo $lang; else echo "korean";?>">
	</P>	
</FIELDSET>

<!--##################################################################################-->
<!--#############################  주문단위 및 통화단위 start  ##########################-->
<!--##################################################################################-->
<FIELDSET>
<LEGEND><?php echo af_txt_form_env_4;?></LEGEND>
	<p><?php echo af_txt_form_env_5;?></p>		
	<P>
		<label for="od_unit" class="label"><?php echo af_txt_form_env_6;?></label>						
			<INPUT TYPE="text" NAME="od_unit"  id="od_unit" onblur='quot_Del(this)' VALUE="<?php echo $od_unit?>" class='ess' style="width:70%;">
	</P>					
						
	<P>
		<label for="coin_unit" class="label"><?php echo af_txt_form_env_7;?></label>						
			<INPUT TYPE="text" NAME="coin_unit" id="coin_unit" onblur='quot_Del(this)' VALUE="<?php echo $coin_unit?>" class='ess' style="width:70%;">
	</P>	
</FIELDSET>

<!--##################################################################################-->		
<!--###########################  사업자정보 출력 start  ##############################-->
<!--##################################################################################-->
<FIELDSET><LEGEND>사업자정보</LEGEND>
						
	<P>
		<label for="supply_name" class="label"><?php echo af_txt_form_add_37;?></label>						
			<INPUT TYPE="text" NAME="supply_name"  id="upply_name" onblur='quot_Del(this)' VALUE="<?php echo $supply_name?>" STYLE="ime-mode:active" class='ess'>
	</P>					
						
	<P>
		<label for="supply_num" class="label"><?php echo af_txt_form_add_38;?></label>						
			<INPUT TYPE="text" NAME="supply_num" id="supply_num" onblur='quot_Del(this)' VALUE="<?php echo $supply_num?>">
	</P>	
						
	<P>
		<label for="supply_man" class="label"><?php echo af_txt_form_add_39;?></label>
			<INPUT TYPE="text" NAME="supply_man" id="supply_man" onblur='quot_Del(this)' VALUE="<?php echo $supply_man?>" STYLE="ime-mode:active">
	</P>
						
	<P>
		<label for="supply_address" class="label"><?php echo af_txt_form_add_40;?></label>
			<INPUT TYPE="text" NAME="supply_address" id="supply_address" onblur='quot_Del(this)' VALUE="<?php echo $supply_address?>" STYLE="ime-mode:active;width:370px">
	</P>	
						
	<P>
		<label for="supply_conditions" class="label"><?php echo af_txt_form_add_41;?></label>
			<INPUT TYPE="text" NAME="supply_conditions" id="supply_conditions" onblur='quot_Del(this)'  VALUE="<?php echo $supply_conditions?>" STYLE="ime-mode:active">
	</P>
					
						
	<P>
		<label for="supply_item" class="label"><?php echo af_txt_form_add_42;?></label>						
			<INPUT TYPE="text" NAME="supply_item" id="supply_item" onblur='quot_Del(this)'  VALUE="<?php echo $supply_item?>" STYLE="ime-mode:active">
	</P>

	<P>
		<label for="tel" class="label"><?php echo af_txt_form_env_16;?></label>						
			<INPUT TYPE="text" NAME="tel" id="tel" onblur='quot_Del(this)'  VALUE="<?php echo $tel?>" STYLE="ime-mode:disabled">
	</P>

	<P>
		<label for="fax" class="label"><?php echo af_txt_form_env_17;?></label>						
			<INPUT TYPE="text" NAME="fax" id="fax" onblur='quot_Del(this)'  VALUE="<?php echo $fax?>" STYLE="ime-mode:disabled">
	</P>

	<P>
		<label for="sell_num" class="label"><?php echo af_txt_form_env_18;?></label>						
			<INPUT TYPE="text" NAME="sell_num" id="sell_num" onblur='quot_Del(this)'  VALUE="<?php echo $sell_num?>">
	</P>

	<P>
		<label for="email_address" class="label"><?php echo af_txt_form_env_19;?></label>						
			<INPUT TYPE="text" NAME="email_address" id="email_address" onblur='quot_Del(this)'  VALUE="<?php echo $email_address?>" STYLE="ime-mode:inactive">
	</P>
						
			
</FIELDSET>

<!--##################################################################################-->
<!--############################### 계좌정보 출력 start  #############################-->
<!--##################################################################################-->
				
<FIELDSET>
		<LEGEND><?php echo af_txt_form_env_20;?></LEGEND>	
			<p>					
			<?php echo af_txt_form_add_31;?>
			
			<INPUT TYPE="text" NAME="bank_name" onblur='quot_Del(this)' VALUE="<?php echo $bank_name?>" STYLE="ime-mode:active">
			
				<?php echo af_txt_form_add_32;?>
			
			
			<INPUT TYPE="text" NAME="bank_num" onblur='quot_Del(this)' VALUE="<?php echo $bank_num?>">	
			
				<?php echo af_txt_form_add_33;?>
			
			<INPUT TYPE="text" NAME="bank_who" onblur='quot_Del(this)' VALUE="<?php echo $bank_who?>" STYLE="ime-mode:active">
			<INPUT TYPE="hidden" NAME="banking" onblur='quot_Del(this)' VALUE="<?php echo $banking?>">
			</p>

</FIELDSET>

<!--##################################################################################-->
<!--#############################  첨부파일 타겟 start	    ##########################-->
<!--##################################################################################-->
<FIELDSET>
<LEGEND>첨부파일 저장타겟 선택(attachment target)</LEGEND>
	<p>기본은 폼관리자 이메일로 첨부파일이 전송되며, 서버에저장을 선택할 경우, 애드폼 관리자모드에서 첨부파일을 확인할 수 있습니다.</p>		
	<P>
		<label for="dummy2" class="label">첨부파일</label>					
			<INPUT TYPE="radio" NAME="dummy2" VALUE="0" <?php if($dummy2 == "0" or $dummy2 == null) echo "checked";?>>이메일(email)로 첨부
			<INPUT TYPE="radio" NAME="dummy2" VALUE="1" <?php if($dummy2 == "1") echo "checked";?>>서버(server)에 저장			
	</P>
</FIELDSET>

<!--##################################################################################-->
<!--#############################  upload 폴더 허용용량 start  ##########################-->
<!--##################################################################################-->
<FIELDSET>
<LEGEND><?php echo af_txt_form_env_11;?></LEGEND>
	<p><?php echo af_txt_form_env_12;?></p>		
	<P>
		<label for="upload_use_alert" class="label"><?php echo af_txt_form_env_13;?></label>					
			<INPUT TYPE="radio" NAME="upload_use_alert" VALUE="1" <?php if($upload_use_alert == "1") echo "checked";?>>YES
			<INPUT TYPE="radio" NAME="upload_use_alert" VALUE="0" <?php if($upload_use_alert == "0") echo "checked";?>>NO
	</P>					
						
	<P>
		<label for="upload_space" class="label"><?php echo af_txt_form_env_14;?></label>						
			<INPUT TYPE="text" NAME="upload_space" id="upload_space" onblur='Numbering2(this);' VALUE="<?php if($upload_space) echo $upload_space; else echo "200000000";?>" style="ime-mode:disabled" onkeyup="format_byte(this,this.form.upload_space_ex);" onmouseout="format_byte(this,this.form.upload_space_ex);"> Byte => 
			<INPUT TYPE="text" NAME="upload_space_ex" id="upload_space_ex" readonly size="6" style="border:0;background-color:#e9e9e9;">Mbyte
	</P>	

	<P>
		<label for="upload_space_per" class="label"><?php echo af_txt_form_env_15;?></label>						
			<INPUT TYPE="text" NAME="upload_space_per" id="upload_space_per" onblur='Numbering2(this);' VALUE="<?php if($upload_space_per) echo $upload_space_per; else echo "70";?>" size="2" style="ime-mode:disabled">%
	</P>
</FIELDSET>

<!--##################################################################################-->
<!--#############################  폼분류 선택상자 표시 start   ##########################-->
<!--##################################################################################-->
<FIELDSET>
<LEGEND>폼분류 선택상자 표시 여부</LEGEND>
	<p>기본은, 표시되지 않고, YES 에 체크할 경우, 생성한 모든 폼의 상단부에, 폼분류 선택상자가 표시됩니다.<br>
	생성한 폼들을 유기적인 환경으로 연결하여, 사용할 경우 사용될 수 있는 기능입니다.</p>		
	<P>
		<label for="dummy3" class="label">폼분류 선택상자 표시</label>					
			<INPUT TYPE="radio" NAME="dummy3" VALUE="1" <?php if($dummy3 == "1") echo "checked";?>>YES
			<INPUT TYPE="radio" NAME="dummy3" VALUE="0" <?php if($dummy3 == "0" or $dummy3 == null) echo "checked";?>>NO
	</P>
</FIELDSET>

<div style="text-align:center"> 
	<input type='button' value='<?php echo af_txt_modify;?>' id="addBtn" onclick="Mix(this.form);chk_email(this.form,this.form.email_address);" class="btn_set">	
</div>																			
			
</FORM>
</div>
</DIV>
</BODY>

</HTML>
