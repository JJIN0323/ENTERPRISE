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


$no = $_GET['no'];									 //부모창에서 받은 그룹번호
$name = $_GET['name'];								 //부모창에서 받은 그룹이름
$mode = $_GET['mode'];

$type =  $_POST['type'];							 //현재창에서 폼으로 받은...
$name_add =  $_POST['name'];						 //현재창에서 폼으로 받은 값

if($type=="add"){									 //추가일 때

	$a=array("name"=>"$name_add");

	///////	DB에 입력	///////

	$DBconn->f_InsertDB(TABLE3,$a);//테이블, 연관배열

	echo("
	<script type='text/javascript'>
		opener.location.reload();
		top.opener=top.window.close();
	</script>
	");
}

if($type=="modify"){								 //수정일 때

	$clean = array();
	$clean['no'] = $_POST['no'];                     //번호	
	$clean['name'] = $_POST['name'];				 //레벨
	

	///////	DB에 업데이트	///////

													
		$where="where no = ".$clean['no'];			 //no필드대신 name필드를 조건하였고 문자형이므로 작은따옴표 붙임에 주의
		$DBconn->f_updateDB(TABLE3,$clean,&$where);	 //테이블, 필드와값, 조건절
	

	echo("
	<script type='text/javascript'>
		opener.location.reload();
		top.opener=top.window.close();
	</script>
	");
}
?>
<!--##################################################################################-->
<!-- ############################	HTML START	##################################### -->
<!--##################################################################################-->
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<meta name='robots' content='none,noindex,nofollow'>
<TITLE></TITLE>
<META NAME="author" CONTENT="애드폼">
<LINK REL="stylesheet" HREF="global.css" TYPE="text/css">
<script type="text/javascript" src='js/check_input.js'></SCRIPT>
<script type="text/javascript" src='js/pop_center.js'></SCRIPT>

<script type="text/javascript">
<!--
function add_Group(f) {
<!--
	 if (!f.name.value) {
        alert('<?php echo af_txt_alt_addGroup;?>');
        return f.name.focus();
    }
	f.submit();
}
-->
</script>

<script type="text/javascript">
<!--
function autoFc() {
if (document.forms.length > 0) {
var field = document.forms[0];
for (i = 0; i < field.length; i++) {
if ((field.elements[i].type == "text") || (field.elements[i].type == "textarea") || (field.elements[i].type.toString().charAt(0) == "s")) {
document.forms[0].elements[i].focus();
break;
         }
      }
   }
}
//-->
</script>
</HEAD>


<BODY onload="autoFc();">

<FORM NAME="form1" method="post" action='<?php echo $_SERVER['PHP_SELF'];?>' onSubmit="return false">

<?php 
if(!$mode){?>
	<input type="hidden" name="type" value="add">
	<TABLE class="noborder">
		<TR>
			<TD COLSPAN="2" style="background-color:white;text-align:left">
				<strong><?php echo af_txt_addGroup;?></strong>
			</TD>
		</TR>
		<TR>
			<TD COLSPAN="2" style="background-color:white;text-align:left">
				<P><?php echo af_txt_addGroup_guide;?></P>
			</TD>
		</TR>
		<TR>
			<TD style="width:30%;height:100px">
				<P style="text-alging=right">&nbsp;<?php echo af_txt_addGroup_name;?> &nbsp;</P>
			</TD>
			<TD style="text-alging=left;width:70%">
			<INPUT TYPE="text" NAME="name" STYLE="width:90%;"  onblur='quot_Del(this)'>
			</TD>
		</TR>
		<TR>
			<TD  COLSPAN="2" style="text-alging=center">
				<HR>
			<input type='button' value='<?php echo af_txt_addGroup;?>' id="addBtn" onClick="add_Group(this.form);"><input type='button' value='<?php echo af_txt_closeWin;?>' onClick='window.close();'>
			</TD>
		</TR>
	</TABLE>
<?}?>

<?php 
if($mode == "modify"){?>

	<input type="hidden" name="type" value="modify">
	<input type="hidden" name="no" value="<?php echo $no?>">
	<TABLE class="noborder">
		<TR>
			<TD COLSPAN="2" style="background-color:white;text-align:left">
				<strong><?php echo af_txt_groupModify;?></strong>
			</TD>
		</TR>
		<TR>
			<TD COLSPAN="2" style="background-color:white;text-align:left">
				<P><?php echo af_txt_groupNameModify;?></P>
			</TD>
		</TR>
		<TR>
			<TD style="width:30%;height:100px;text-align:right">
				<?php echo af_txt_addGroup_name;?>
			</TD>
			<TD style="text-align:left;width:70%">
			<INPUT TYPE="text" NAME="name" STYLE="width:90%;"  onblur='quot_Del(this)' value="<?php echo $name?>">
			</TD>
		</TR>
		<TR>
			<TD  COLSPAN="2" style="text-alging=center">
				<HR>
			<input type='button' value='<?php echo af_txt_groupModify;?>' id="addBtn" onClick="add_Group(this.form);"><input type='button' value='<?php echo af_txt_closeWin;?>' onClick='window.close();'>
			</TD>
		</TR>
	</TABLE>

<?}?>


</FORM>
</BODY>

</HTML>
