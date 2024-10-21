<?php
include_once "../lib/lib.php";
include_once "../lib/C_CONNECT.php";
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
///////DB select 쿼리///////

/*
C_CONNECT 클래스 멤버함수인 f_selectDB($field="*",$table,$where="")를 실행하여
	$re[result]에 저장하고 불러온 레코드 수를 $re[cnt]에 저장
*/

#########################################################################################
#################################     선택한 그룹 삭제 start     ########################
#########################################################################################

if($_GET['mode']=="del") {
	
	### addform_table 에서 그룹번호를 가진 필드정보 가져오기 start ###

	$no = $_GET['no'];
	$where = "where no_group=".$no;

	$res=$DBconn->f_selectDB("*","".db_tblname."_table",$where);
	$result_form = $res[result];
	$res_count_form = mysql_num_rows($res[result]);

	### addform_table 에서 그룹번호를 가진 필드정보 가져오기 end   ###

	if($res_count_form > 0){
		echo ("
		<script type='text/javascript'>
			location.href='move_Group_forDel.php?no=$no';
		</script>				
		");
	}
	else echo f_del($no);								//삭제할 그룹번호 배열
}

function f_del($no){									//선택폼 삭제 함수 start
	global $DBconn;
	$n = count($no);									//전달받은 배열의 크기

	for($i=0;$i < $n;$i++){
	$where="where no=$no";								
	$DBconn->f_deleteTable(TABLE3,$where);				//테이블, 조건절
	}
	 die("<meta http-equiv=refresh content='0;url=addform_Group.php'>");	//쿼리실행 후 문서 고침
}

#########################################################################################
#################################     그 룹 정 보   가져오기     ########################
#########################################################################################

$re=$DBconn->f_selectDB("*",TABLE3,"order by no");//테이블, 연관배열
$result = $re[result];
$res_count = mysql_num_rows($re[result]);

function f_loopRec(){
	global $result;
	global $DBconn;

	while($row =  mysql_fetch_array($result)){		
		$no=htmlspecialchars(stripslashes($row[no]));
		$name=htmlspecialchars(stripslashes($row[name]));
			
			//아래 4줄은 그룹에 딸린 폼개수를 구하는...
			$where = "where no_group=".$no;

			$res=$DBconn->f_selectDB("*","".db_tblname."_table",$where);
			$result_form = $res[result];
			$res_count_form = mysql_num_rows($res[result]);

			if($no == "1"){
				echo ("
					<tr>
						<td style='text-align:left;font-weight:bold;font-size:1.3em;' nowrap>
						<img src='img/bg_addGroup.gif' style='vertical-align:middle' alt=''>&nbsp; $name &nbsp; [$res_count_form]
						</td>						
						<td style='text-align:center' nowrap>
						<input type='button' value='".af_txt_modify."' onClick=\"javascript:void(window.open('addGroup.php?w=450&amp;h=300&amp;no=$no&amp;mode=modify&amp;name=".urlencode($name)."','grModify','width=450,height=350,statusbar=no,scrollbars=no,toolbar=no'))\" class='btn_list'>
						<input type='button' value='".af_txt_del."' onClick=\"javascript:void(alert('".af_txt_alt_grDel."'))\" class='btn_list'>
						</td>
					</tr>
			");
			}


			else {echo ("
					<tr>
						<td style='text-align:left;font-weight:bold;font-size:1.3em;' nowrap>
						<img src='img/bg_addGroup.gif' style='vertical-align:middle' alt=''>&nbsp; $name &nbsp; [$res_count_form]
						</td>						
						<td style='text-align:center' nowrap>
						<input type='button' value='".af_txt_modify."' onClick=\"javascript:void(window.open('addGroup.php?w=450&amp;h=300&amp;no=$no&amp;mode=modify&amp;name=".urlencode($name)."','grModify','width=450,height=350,statusbar=no,scrollbars=no,toolbar=no'))\" class='btn_list'>
						<input type='button' value='".af_txt_del."' onclick=\"location.href='?mode=del&amp;no=$no'\" class='btn_list'>
						</td>
					</tr>
			");
		}
	}
}
?>
<!--##################################################################################-->
<!--#############################     HTML start     #################################--> 
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

<script type="text/javascript">	
<!--
		window.onload=function(){tableruler();} 					 //테이블 행간 롤오버 함수 호출
-->
</script>
</HEAD>

<BODY>
<DIV ID="mainDiv">

	<FIELDSET>
		<LEGEND>그룹 추가</LEGEND>
			<TABLE summary="그룹선택 및 검색 테이블" class="noborder" STYLE="HEIGHT:80px">
				<TR>
					<TD style="text-align:left;color:gray;" nowrap> 
						관련있는 폼끼리 그룹을 지어놓으면, 업무처리와 폼관리가 용이합니다.<br>
						그룹이름옆의 괄호한에 있는 숫자는, 해당그룹에 속한 폼의 갯수입니다.
					</TD>
					<TD style="text-align:right;padding-right:12px;">
						<input type="button" value="그룹추가" onClick="javascript:void(window.open('addGroup.php?w=450&amp;h=300','mGroup','width=450,height=350,statusbar=no,scrollbars=no,toolbar=no'))" class="btn_big_main" style="width:139px;">						
					</TD>
				</TR>
			</TABLE>		
	</FIELDSET>

	<!--레코드 테이블 출력-->
	<FIELDSET>
	<LEGEND><?php echo af_txt_group;?> (<?php echo $res_count;?>)</LEGEND>
		<TABLE summary="애드폼 그룹 목록" class="ruler">
			<caption>&nbsp;</caption>
			<thead>
				<tr>			
					<th class="order" scope="col" style='text-align:left'>GROUP NAME</th>
					<th class="order" scope="col" style='text-align:center;width:150px'>MODIFY</th>			
				 </tr>
			</thead>

				<tbody>
					<?php echo f_loopRec();?>			
				</tbody>

			<tfoot class="noborder">
				<tr>
					<td colspan="2"></td>
				</tr>
			</tfoot>
		</TABLE>
	</FIELDSET>

</DIV>
</BODY>

</HTML>