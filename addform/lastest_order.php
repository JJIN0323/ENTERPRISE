<?php
include_once("lib/lib.php");
include_once("lib/C_CONNECT.php");
include_once("lib/define_table.php");
include_once("function/f_get_afTABLE.php");
include_once("function/f_get_afTABLE2.php");
include_once("function/f_get_afTABLE5.php");


if (strlen($_GET['width']) >= 20 or strlen($_GET['fname']) >= 20) 
	{ //get 인자 검사
	die("정상적인 접속이 아닙니다. incorrect!");
	}
?>


<!--##################################################################################-->
<!--########################		HTML start	 #####################################-->
<!--##################################################################################-->
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<meta name='robots' content='none,noindex,nofollow'>
<title></title>

<!--########################			스타일 start			######################-->
<style type="text/css">
/* 문서의 전체 폰트 속성 설정 */
*{
FONT-FAMILY:돋움;
FONT-SIZE:13px;
COLOR:black;
 }

body{margin:0;padding:0;}
div{width:<?php echo $_GET['width'];?>;margin:0;padding:0;}
table{width:100%;margin:0;padding:0;margin-top:5px;}
td{border:0;}
#body td{margin:0;padding:2px;text-align:center;background-color:#c6d4b8;border:1px solid #ccc;}
#body td.lastest_head{background-color:#e3e3e3;}
img{vertical-align:middle;}
</style>
<!--########################			스타일 end				######################-->
<script type="text/javascript">
<!--
//페이지 새로고침
pagereload=window.setTimeout(function(){window.location.reload(); }, 60000); // 1분
-->
</script>
</HEAD>

<BODY>
<?php
function lastest_order($fname)
	{
		$af_TABLE2 = f_get_afTABLE2("no","1");					//DB처리상황 구분 테이블에서 가져오기
		$arr_situation_origin = explode("|",$af_TABLE2['dummy1']);
		$arr_situation = explode(",",$arr_situation_origin[0]);
		$arr_situation_color = explode(",",$arr_situation_origin[1]);
		$af_TABLE5 = f_get_afTABLE5("name",$fname);				//폼의 타이틀 가져오기
		if($fname) $af_title = $af_TABLE5['title_text'];
		else $af_title = "접수현황";							//폼이름을 지정하지 않았을 때 
		#############################################################################
		# $table = '가져올 테이블'													#
		# $field = '조건절 필드'													#
		# $kw =	   '조건절 키워드'													#
		# $odFld = '정렬에 사용될 기준필드'											#
		# $desc =  '내림차순 또는 오름차순' asc(오름차순) desc(내림차순)			#
		# $limit = '가져올 갯수'													#
		#############################################################################
		$af_tbl4_rows = f_get_afTABLE($table=TABLE4,$field='mom',$kw=$fname,$odFld='input_date',$desc='desc',$limit='5');	

		
		echo "<div>";
			echo "<table id='head'>
					<tr>
						<td style='width:70%;color:#333;font-weight:bold;'>
						".$af_title."
						</td>
						<td style='width:30%;text-align:right;'>				
							<img src='imgs/entry.gif' style='border:0;vertical-align:middle;cursor:hand;' onclick=\"javascript:void(window.open('view_addform.php?fname=".$fname."','entry','width=900,height=600,status=yes,scrollbars=yes,toolbar=no,location=no,resizable=yes'))\">
						</td>
					</tr>
				  </table>";
			echo "<table id='body'>";
				echo "<tr>
						<td class='lastest_head'><img src='imgs/man.gif'></td>						
						<td class='lastest_head'><img src='imgs/work.gif'></td>
						<td class='lastest_head'><img src='imgs/date.gif'></td>
					  </tr>";
			for($i=0;$i < $af_tbl4_rows['res_count'];$i++)
				{
				$situation = $af_tbl4_rows['row'][$i]['situation'];				
				$arr_hp = explode('-',$af_tbl4_rows['row'][$i]['client_hp']);
				$arr_client_email = explode('@',$af_tbl4_rows['row'][$i]['client_email']);
				echo "<tr>";
					//고객이름
					echo "<td>";
					echo $af_tbl4_rows['row'][$i]['client_name'];
					echo "</td>";					
					//진행상황
					echo "<td style='background-color:".$arr_situation_color[$situation-1].";cursor:hand;' onclick=\"javascript:void(window.open('html/index.html?$w=550&amp;h=500&amp;pageid=progress&amp;title=".$af_TABLE5[title_text]."&amp;af_order_no=".$af_tbl4_rows['row'][$i]['af_order_no']."&amp;client_name=".$af_tbl4_rows['row'][$i]['client_name']."&amp;client_email=".$arr_client_email[0]."@xxxxx.xxx&amp;input_date=".$af_tbl4_rows['row'][$i]['input_date']."&amp;readN=".$af_tbl4_rows['row'][$i]['dummy6']."&amp;situation=".$arr_situation[$situation-1]."','progress','width=550,height=500,status=yes,scrollbars=yes,toolbar=no,location=no,resizable=yes'))\">";					
					echo $arr_situation[$situation-1];
					echo "</td>";
					//접수날짜
					echo "<td style='color:#999;font-size:11px;'>";
					echo date("n.d",$af_tbl4_rows['row'][$i]['input_date']);
					echo "</td>";
				echo "</tr>";
				}		
			echo "</table>";
		echo "</div>";
}
//최근 접수현황출력 함수실행
lastest_order($_GET['fname']);
?>	
</BODY>
</HTML>