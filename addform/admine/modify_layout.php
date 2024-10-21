<?php
include_once("../lib/lib.php");
include_once("../lib/C_CONNECT.php");
include_once("../lib/define_table.php");
include_once("../lib/authentication.php");
include_once("../function/f_get_afTABLE7.php");
include_once("../function/f_af_formThumbUpload.php");


/* ----------------------------------------------------------------------------------- */
/*	프로그램명 : 애드폼(영문 addform												   */									
/*	프로그램용도: 견적서 주문서 폼메일 제작											   */
/*	제작자: 박성규																	   */
/*	공식배포처: http://www.addform.net												   */
/*  프로그램 편집시 위 제작자 정보를 편집하거나 삭제해서는 안됩니다.				   */
/* ----------------------------------------------------------------------------------- */

//첨부파일있을 때 업로드 함수 실행
$f_af_formThumbUpload = f_af_formThumbUpload();					   //로고 이미지
$af_arr_format = array("jpg","jpeg","gif");						   //업로드 된 허용확장자
#########################################################################################
##################################   모드가 수정일 때   #################################
#########################################################################################
if($_POST['mode']=="modify")
{

	if($_POST['logoDel'] == "1")								   //로고이미지 삭제
	{
		for($i = 0;$i < count($af_arr_format);$i++)
		{
		@unlink("../upload/logo/logo_img.".$af_arr_format[$i]."");	
		}
	}

	$where = "";
	$clean=array();	
		$clean['logo_link'] = $_POST['logo_link'];
		$clean['yn_topmenu'] = $_POST['yn_topmenu'];
		$clean['yn_top_custom'] = $_POST['yn_top_custom'];
		$clean['topmenu_idx'] = $_POST['topmenu_idx'];
		$clean['top_custom'] = $_POST['top_custom'];

		$clean['left_width'] = $_POST['left_width'];
		$clean['left_wUnit'] = $_POST['left_wUnit'];
		$clean['yn_leftmenu'] = $_POST['yn_leftmenu'];
		$clean['yn_thumblist'] = $_POST['yn_thumblist']	;
		$clean['yn_lastest'] = $_POST['yn_lastest'];
		$clean['yn_best'] = $_POST['yn_best'];
		$clean['yn_tel'] = $_POST['yn_tel'];
		$clean['yn_bank'] = $_POST['yn_bank'];
		$clean['yn_left_custom'] = $_POST['yn_left_custom'];
		$clean['leftmenu_idx'] = $_POST['leftmenu_idx'];
		$clean['thumb_width'] = $_POST['thumb_width'];
		$clean['thumb_height'] = $_POST['thumb_height'];
		$clean['lastestN'] = $_POST['lastestN'];
		$clean['bestN'] = $_POST['bestN'];
		$clean['left_custom'] = $_POST['left_custom'];

		$clean['right_width'] = $_POST['right_width'];
		$clean['right_wUnit'] = $_POST['right_wUnit'];
		$clean['yn_dokdo'] = $_POST['yn_dokdo'];
		$clean['yn_lastestR'] = $_POST['yn_lastestR'];
		$clean['yn_bestR'] = $_POST['yn_bestR'];
		$clean['yn_right_custom'] = $_POST['yn_right_custom'];
		$clean['lastestRN'] = $_POST['lastestRN'];
		$clean['bestRN'] = $_POST['bestRN'];
		$clean['right_custom'] = $_POST['right_custom'];

		$clean['yn_companydata'] = $_POST['yn_companydata'];
		$clean['yn_footer_custom'] = $_POST['yn_footer_custom'];
		$clean['footer_custom'] = $_POST['footer_custom'];


		$where = "where no=1";							//조건절

		
		$DBconn->f_updateDB(TABLE7,&$clean,$where);			//&$clean배열을 참조연산자&로 넘겨주어 보다 빠르게 처리
		//DB 입력 후 문서 고침
		die("<script>alert('수정되었습니다. success');</script><meta http-equiv=refresh content='0;url=modify_layout.php'>");
}
?>



<!--##################################################################################-->
<!--#########################	 정보가져오기 start  #################################-->
<!--##################################################################################-->
<?php

if(!$_POST['mode'])
{	
	$af_TABLE7 = f_get_afTABLE7("no","1");	//DB layout 테이블에서 가져오기
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
<TITLE>레이아웃 편집</TITLE>
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
<script type="text/javascript">
<!--
	function initinal(fld)
	{
	var topmenu_idx =  "<li><a href='#'>사이트메뉴1</a></li>\n";
		topmenu_idx += "<li><a href='#'>사이트메뉴2</a></li>\n";
		topmenu_idx += "<li><a href='#'>사이트메뉴3</a></li>\n";
		topmenu_idx += "<li><a href='#'>사이트메뉴4</a></li>\n";
		topmenu_idx += "<li><a href='#'>사이트메뉴5</a></li>";

	var leftmenu_idx = "<li><a href='#'>임의설정메뉴1</a></li>\n";
		leftmenu_idx += "<li><a href='#'>임의설정메뉴2</a></li>\n";
		leftmenu_idx += "<li><a href='#'>임의설정메뉴3</a></li>\n";
		leftmenu_idx += "<li><a href='#'>임의설정메뉴4</a></li>\n";
		leftmenu_idx += "<li><a href='#'>임의설정메뉴5</a></li>\n";
		leftmenu_idx += "<li><a href='#'>임의설정메뉴6</a></li>\n";
		leftmenu_idx += "<li><a href='#'>임의설정메뉴7</a></li>";	

		if(fld.name == "topmenu_idx")
		{
			fld.value = topmenu_idx;			
		}
		if(fld.name == "leftmenu_idx")
		{
			fld.value = leftmenu_idx;			
		}
	}
-->
</script>


</HEAD>


<BODY>

<DIV>
<div id="main_left">
<H1 id="en">LAYOUT EDIT</H1>
<H2>레이아웃을 편집합니다.</H2>
<p style="font-weight:bold;color:#ff6600;;">운영중인 홈페이지나 블로그,까페등에 고객접수용 폼화면만 링크시켜 사용할 때는, 상하좌우 레이아웃이 출력되지 않으므로, 레이아웃을 편집할 필요가 없습니다.</p>
<FORM NAME="form1" id="form1" method="post" action='<?php echo $_SERVER['PHP_SELF'];?>' enctype='multipart/form-data'>	
	<input type="hidden" name="no" value="<?php echo $no?>">	
	<input type="hidden" name="mode" value="modify">

<!--  HEAD	-->
<FIELDSET>
<LEGEND>HEADER.HTML</LEGEND>
	<p><?php echo af_txt_modify_layout_41;?></p>
	<p><img src="img/edit_head.gif" alt="도움말 이미지" style="vertical-align:middle;"> <?php echo af_txt_modify_layout_26;?></p>
	<hr>
			
	<!-- 사이트 로고 이미지 -->
	<P>
		<label for="logo_img" class="label"><?php echo af_txt_modify_layout_1;?></label>		
			<input type="file" name="logo_img" size="50" style="height:20px;"> gif,jpg <?php echo af_txt_modify_layout_40;?>
			<?php
					
			for($i=0; $i < count($af_arr_format);$i++)
				{
				if(file_exists("../upload/logo/logo_img.".$af_arr_format[$i].""))
					{					
					echo "<img src='../upload/logo/logo_img.".$af_arr_format[$i]."' style='vertical-align:middle;width:130px;height:50px;border:1px solid #000;' alt='로고이미지'>";
					echo "<input type='checkbox' name='logoDel' value='1'> Delete";			
					}
				}
			?>
	</P>
		
	<P>
		<label for="password" class="label"><?php echo af_txt_modify_layout_2;?></label>			
			 <input type="text" name="logo_link" id="logo_link" onblur="quot_Del(this)" value="<?php echo $af_TABLE7['logo_link'];?>" style="ime-mode:inactive;">  ex) http://www.naver.com
	</P>
			
	<P>
		<label for="topmenu_idx" class="label"><?php echo af_txt_modify_layout_3;?><br> 
		<input type="radio" name="yn_topmenu" value="on" <?php if($af_TABLE7['yn_topmenu'] == "on") echo "checked";?>><?php echo af_txt_modify_layout_5;?>
		<input type="radio" name="yn_topmenu" value="off" <?php if($af_TABLE7['yn_topmenu'] == "off") echo "checked";?>><?php echo af_txt_modify_layout_6;?><br>
		<input type="button" value="<?php echo af_txt_modify_layout_7;?>" onclick="initinal(this.form.topmenu_idx);">
		</label>			
		<TEXTAREA NAME="topmenu_idx" id="topmenu_idx" STYLE="width:80%;" class="tag" rows="6" onclick="this.rows=this.rows+3" onmouseout="this.rows=6"><?php echo $af_TABLE7['topmenu_idx'];?></TEXTAREA>
	</P>
			
	<P>
		<label for="top_custom" class="label"><?php echo af_txt_modify_layout_4;?><br> 
		<input type="radio" name="yn_top_custom" value="on" <?php if($af_TABLE7['yn_top_custom'] == "on") echo "checked";?>><?php echo af_txt_modify_layout_5;?>
		<input type="radio" name="yn_top_custom" value="off" <?php if($af_TABLE7['yn_top_custom'] == "off") echo "checked";?>><?php echo af_txt_modify_layout_6;?>
		</label>			
		<TEXTAREA NAME="top_custom" id="top_custom" STYLE="width:80%;" class="tag" rows="6" onclick="this.rows=this.rows+3" onmouseout="this.rows=6"><?php echo $af_TABLE7['top_custom'];?></TEXTAREA>
	</P>		

</FIELDSET>

<div style="text-align:right;"> 
	<input type='submit' value='Modify' id="addBtn" class="btn_set">	
</div>	

<!--  LEFT	-->
<FIELDSET>
<LEGEND>LEFT.HTML</LEGEND>
	<p><?php echo af_txt_modify_layout_42;?></p>
	<p><img src="img/edit_left.gif" style="vertical-align:middle;"> <?php echo af_txt_modify_layout_27;?></p>
	<hr>
		
	<P>
		<label for="left_width" class="label"><?php echo af_txt_modify_layout_8;?></label>			
			 <input type="text" name="left_width" id="left_width" onblur='Numbering2(this)' value="<?php echo $af_TABLE7['left_width'];?>" style="ime-mode:disabled;" size="3">					
			 <select name="left_wUnit">
				<option value="px" <?php if($af_TABLE7['left_wUnit'] == "px") echo "selected";?>>px</option>
				<option value="%" <?php if($af_TABLE7['left_wUnit'] == "%") echo "selected";?>>%</option>
			 </select>
	</P>
			
	<P>
		<label for="leftmenu_idx" class="label"><?php echo af_txt_modify_layout_9;?><br> 
		<input type="radio" name="yn_leftmenu" value="on" <?php if($af_TABLE7['yn_leftmenu'] == "on") echo "checked";?>><?php echo af_txt_modify_layout_5;?>
		<input type="radio" name="yn_leftmenu" value="off" <?php if($af_TABLE7['yn_leftmenu'] == "off") echo "checked";?>><?php echo af_txt_modify_layout_6;?><br>
		<input type="button" value="<?php echo af_txt_modify_layout_7;?>" onclick="initinal(this.form.leftmenu_idx);">
		</label>			
		<TEXTAREA NAME="leftmenu_idx" id="leftmenu_idx" STYLE="width:80%;" class="tag" rows="6" onclick="this.rows=this.rows+3" onmouseout="this.rows=6"><?php echo $af_TABLE7['leftmenu_idx'];?></TEXTAREA>
	</P>			

	
	<P>
		<label for="lastestN" class="label"><?php echo af_txt_modify_layout_11;?><br> 
		<input type="radio" name="yn_lastest" value="on" <?php if($af_TABLE7['yn_lastest'] == "on") echo "checked";?>><?php echo af_txt_modify_layout_5;?>
		<input type="radio" name="yn_lastest" value="off" <?php if($af_TABLE7['yn_lastest'] == "off") echo "checked";?>><?php echo af_txt_modify_layout_6;?>	
		</label>
		<?php echo af_txt_modify_layout_31;?><br>
		<strong><?php echo af_txt_modify_layout_25;?></strong>
		<select name="lastestN">								
				<?php
					for($i = 1; $i < 31;$i++)
					{	
						if($i == $af_TABLE7['lastestN'])
						{
							$lastestN_selected = "selected";
						}
						else $lastestN_selected = "";						
						echo "<option value='$i' ".$lastestN_selected.">$i";						
					}
				?>
		</select>
	</P>

	<P>
		<label for="bestN" class="label"><?php echo af_txt_modify_layout_12;?><br> 
		<input type="radio" name="yn_best" value="on" <?php if($af_TABLE7['yn_best'] == "on") echo "checked";?>><?php echo af_txt_modify_layout_5;?>
		<input type="radio" name="yn_best" value="off" <?php if($af_TABLE7['yn_best'] == "off") echo "checked";?>><?php echo af_txt_modify_layout_6;?>	
		</label>
		<?php echo af_txt_modify_layout_32;?><br>
		<strong><?php echo af_txt_modify_layout_25;?></strong>
		<select name="bestN">								
				<?php
					for($i = 1; $i < 31;$i++)
					{	
						if($i == $af_TABLE7['bestN'])
						{
							$bestN_selected = "selected";
						}
						else $bestN_selected = "";						
						echo "<option value='$i' ".$bestN_selected.">$i";						
					}
				?>
		</select>
	</P>

	<P>
		<label for="thumb_width" class="label"><?php echo af_txt_modify_layout_10;?><br> 
		<input type="radio" name="yn_thumblist" value="on" <?php if($af_TABLE7['yn_thumblist'] == "on") echo "checked";?>><?php echo af_txt_modify_layout_5;?>
		<input type="radio" name="yn_thumblist" value="off" <?php if($af_TABLE7['yn_thumblist'] == "off") echo "checked";?>><?php echo af_txt_modify_layout_6;?>	
		</label>
		<?php echo af_txt_modify_layout_30;?><br>
		<?php echo af_txt_modify_layout_39;?> <strong><?php echo af_txt_modify_layout_23;?></strong><input type="text" name="thumb_width" id="thumb_width" onblur='Numbering2(this)' value="<?php echo $af_TABLE7['thumb_width'];?>" style="ime-mode:disabled;" size="3">px
		&nbsp;&nbsp;&nbsp;<?php echo af_txt_modify_layout_39;?> <strong><?php echo af_txt_modify_layout_24;?></strong><input type="text" name="thumb_height" id="thumb_height" onblur='Numbering2(this)' value="<?php echo $af_TABLE7['thumb_height'];?>" style="ime-mode:disabled;" size="3">px
	</P>

	<P>
		<label for="" class="label"><?php echo af_txt_modify_layout_13;?><br> 
		<input type="radio" name="yn_tel" value="on" <?php if($af_TABLE7['yn_tel'] == "on") echo "checked";?>><?php echo af_txt_modify_layout_5;?>
		<input type="radio" name="yn_tel" value="off" <?php if($af_TABLE7['yn_tel'] == "off") echo "checked";?>><?php echo af_txt_modify_layout_6;?>	
		</label>
		<?php echo af_txt_modify_layout_33;?>
	</P>

	<P>
		<label for="" class="label"><?php echo af_txt_modify_layout_14;?><br> 
		<input type="radio" name="yn_bank" value="on" <?php if($af_TABLE7['yn_bank'] == "on") echo "checked";?>><?php echo af_txt_modify_layout_5;?>
		<input type="radio" name="yn_bank" value="off" <?php if($af_TABLE7['yn_bank'] == "off") echo "checked";?>><?php echo af_txt_modify_layout_6;?>	
		</label>
		<?php echo af_txt_modify_layout_34;?>
	</P>

	<P>
		<label for="left_custom" class="label"><?php echo af_txt_modify_layout_15;?><br> 
		<input type="radio" name="yn_left_custom" value="on" <?php if($af_TABLE7['yn_left_custom'] == "on") echo "checked";?>><?php echo af_txt_modify_layout_5;?>
		<input type="radio" name="yn_left_custom" value="off" <?php if($af_TABLE7['yn_left_custom'] == "off") echo "checked";?>><?php echo af_txt_modify_layout_6;?>	
		</label>			
		<TEXTAREA NAME="left_custom" id="left_custom" STYLE="width:80%;" class="tag" rows="6" onclick="this.rows=this.rows+3" onmouseout="this.rows=6"><?php echo $af_TABLE7['left_custom'];?></TEXTAREA>
	</P>

</FIELDSET>

<div style="text-align:right;"> 
	<input type='submit' value='Modify' id="addBtn" class="btn_set">	
</div>

<!--  RIGHT	-->
<FIELDSET>
<LEGEND>RIGHT.HTML</LEGEND>
	<p><?php echo af_txt_modify_layout_43;?></p>
	<p><img src="img/edit_right.gif" style="vertical-align:middle;"> <?php echo af_txt_modify_layout_28;?></p>
	<hr>
		
	<P>
		<label for="right_width" class="label"><?php echo af_txt_modify_layout_16;?></label>			
			 <input type="text" name="right_width" id="right_width" onblur='Numbering2(this)' value="<?php echo $af_TABLE7['right_width'];?>" style="ime-mode:disabled;" size="3">					
			 <select name="right_wUnit">
				<option value="px" <?php if($af_TABLE7['right_wUnit'] == "px") echo "selected";?>>px</option>
				<option value="%" <?php if($af_TABLE7['right_wUnit'] == "%") echo "selected";?>>%</option>
			 </select>
	</P>
			
	<P>
		<label for="" class="label"><?php echo af_txt_modify_layout_17;?><br>
		<input type="radio" name="yn_dokdo" value="on" <?php if($af_TABLE7['yn_dokdo'] == "on") echo "checked";?>><?php echo af_txt_modify_layout_5;?>
		<input type="radio" name="yn_dokdo" value="off" <?php if($af_TABLE7['yn_dokdo'] == "off") echo "checked";?>><?php echo af_txt_modify_layout_6;?><br>
		</label> 
		<?php echo af_txt_modify_layout_35;?>
	</P>	
	
	<P>
		<label for="lastestRN" class="label"><?php echo af_txt_modify_layout_18;?><br>
		<input type="radio" name="yn_lastestR" value="on" <?php if($af_TABLE7['yn_lastestR'] == "on") echo "checked";?>><?php echo af_txt_modify_layout_5;?>
		<input type="radio" name="yn_lastestR" value="off" <?php if($af_TABLE7['yn_lastestR'] == "off") echo "checked";?>><?php echo af_txt_modify_layout_6;?>	
		</label>
		<?php echo af_txt_modify_layout_36;?><br>
		<strong><?php echo af_txt_modify_layout_25;?></strong>
		<select name="lastestRN">								
				<?php
					for($i = 1; $i < 31;$i++)
					{	
						if($i == $af_TABLE7['lastestRN'])
						{
							$lastestN_selectedR = "selected";
						}
						else $lastestN_selectedR = "";						
						echo "<option value='$i' ".$lastestN_selectedR.">$i";						
					}
				?>
		</select>
	</P>

	<P>
		<label for="bestRN" class="label"><?php echo af_txt_modify_layout_19;?><br>
		<input type="radio" name="yn_bestR" value="on" <?php if($af_TABLE7['yn_bestR'] == "on") echo "checked";?>><?php echo af_txt_modify_layout_5;?>
		<input type="radio" name="yn_bestR" value="off" <?php if($af_TABLE7['yn_bestR'] == "off") echo "checked";?>><?php echo af_txt_modify_layout_6;?>	
		</label>
		<?php echo af_txt_modify_layout_37;?><br>
		<strong><?php echo af_txt_modify_layout_25;?></strong>
		<select name="bestRN">								
				<?php
					for($i = 1; $i < 31;$i++)
					{	
						if($i == $af_TABLE7['bestRN'])
						{
							$bestN_selectedR = "selected";
						}
						else $bestN_selectedR = "";						
						echo "<option value='$i' ".$bestN_selectedR.">$i";						
					}
				?>
		</select>
	</P>

	<P>
		<label for="right_custom" class="label"><?php echo af_txt_modify_layout_20;?><br>
		<input type="radio" name="yn_right_custom" value="on" <?php if($af_TABLE7['yn_right_custom'] == "on") echo "checked";?>><?php echo af_txt_modify_layout_5;?>
		<input type="radio" name="yn_right_custom" value="off" <?php if($af_TABLE7['yn_right_custom'] == "off") echo "checked";?>><?php echo af_txt_modify_layout_6;?>	
		</label>			
		<TEXTAREA NAME="right_custom" id="right_custom" STYLE="width:80%;" class="tag" rows="6" onclick="this.rows=this.rows+3" onmouseout="this.rows=6"><?php echo $af_TABLE7['right_custom'];?></TEXTAREA>
	</P>

</FIELDSET>

<div style="text-align:right;"> 
	<input type='submit' value='Modify' id="addBtn" class="btn_set">	
</div>

<!--  FOOTER.HTML	-->
<FIELDSET>
<LEGEND>FOOTER.HTML</LEGEND>
	<p><?php echo af_txt_modify_layout_44;?></p>
	<p><img src="img/edit_footer.gif" style="vertical-align:middle;"> <?php echo af_txt_modify_layout_29;?></p>
	<hr>
			
	<P>
		<label for="" class="label"><?php echo af_txt_modify_layout_21;?><br>
		<input type="radio" name="yn_companydata" value="on" <?php if($af_TABLE7['yn_companydata'] == "on") echo "checked";?>><?php echo af_txt_modify_layout_5;?>
		<input type="radio" name="yn_companydata" value="off" <?php if($af_TABLE7['yn_companydata'] == "off") echo "checked";?>><?php echo af_txt_modify_layout_6;?><br>
		</label> 
		<?php echo af_txt_modify_layout_38;?>
	</P>	
	
	<P>
		<label for="footer_custom" class="label"><?php echo af_txt_modify_layout_22;?><br>
		<input type="radio" name="yn_footer_custom" value="on" <?php if($af_TABLE7['yn_footer_custom'] == "on") echo "checked";?>><?php echo af_txt_modify_layout_5;?>
		<input type="radio" name="yn_footer_custom" value="off" <?php if($af_TABLE7['yn_footer_custom'] == "off") echo "checked";?>><?php echo af_txt_modify_layout_6;?>	
		</label>			
		<TEXTAREA NAME="footer_custom" id="footer_custom" STYLE="width:80%;" class="tag" rows="6" onclick="this.rows=this.rows+3" onmouseout="this.rows=6"><?php echo $af_TABLE7['footer_custom'];?></TEXTAREA>
	</P>

</FIELDSET>

<div style="text-align:right;"> 
	<input type='submit' value='Modify' id="addBtn" class="btn_set">	
</div>
			
</FORM>
</div>
</DIV>
</BODY>

</HTML>
