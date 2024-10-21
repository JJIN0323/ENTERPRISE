<?php
include_once("lib/lib.php");
include_once("lib/C_CONNECT.php");
include_once("lib/define_table.php");

/* ----------------------------------------------------------------------------------- */
/*	프로그램명 : 애드폼(영문 addform )												   */									
/*	프로그램용도: 견적서 주문서 폼메일 제작											   */
/*	제작자: 박성규																	   */
/*	공식배포처: http://www.addform.net												   */
/*  프로그램 편집시 위 제작자 정보를 편집하거나 삭제해서는 안됩니다.				   */
/* ----------------------------------------------------------------------------------- */
?>
<!--##################################################################################-->
<!--###########################      우편번호 가져오기 start		##################-->
<!--##################################################################################-->
<?php
if($_GET['mode'] == "search")
{
	$keywd="";
	$keywd = $_GET['keywd'];
	
	if(!$keywd or strlen($keywd)<5)							//유니코드에서 한글1자 경고
	{
		die("<script type='text/javascript'>alert('검색할 읍면동이름을 2자이상 입력하세요');document.location.href='zipcode_search.php?id1=$_GET[id1]&id2=$_GET[id2]&id3=$_GET[id3]&id4=$_GET[id4]&formname=$_GET[formname]';</script>'");
	}

	$vowels = array("'","\"");								//제거할 특수문자 배열
	$keywd = str_replace($vowels, "", $keywd);				//인용부호 제거    	
	
	if($keywd)
	{														//검색키워드가 있을때			
		$where = " where dong like '%$keywd%' ";			
		$where .= "or ri like '%$keywd%' ";	
	}
}

function f_loopRec()
{
	global $where;	

	$table = "";
	$code = "";
	$desc = "";
	$load = "";
	$html = "";
	$table = db_tblname."_zipcode";							//검색테이블
	$code="seq";											//기준필드
	$desc="desc";											//정렬조건 desc 는 내림차순, asc 는 오름차순
	$load = "select * from $table";							//실행문인자
	$html = array();										//빈배열 선언		
		
		$load .= $where;									
		$load .= " order by $code $desc ";					
		$result = mysql_query($load);						
		$rows = mysql_num_rows($result);
		
		if(!$rows)											//검색결과가 없다면...
		{
			echo $msg = "검색결과가 없습니다. 다시 검색하여 주세요...";
		}
		else												//검색결과가 있다면...
		{
			echo ("
			<div>
			<p>검색결과: ".$rows."</p>
				<table class='ruler'>
					<thead>
					<tr>
						<th class='order' scope='col'>우편번호</th>
						<th class='order' scope='col'>주소</th>						
						<th class='order' scope='col'>선택</th>
					</tr>
					</thead>
					<tbody>
			");

			
			while($row = mysql_fetch_array($result))
				{
				$html["no"] = htmlspecialchars(stripslashes($row["no"]));							
				$html["zipcode"] = htmlspecialchars(stripslashes($row["zipcode"]));						
				$html["sido"] =  htmlspecialchars(stripslashes($row["sido"]));				
				$html["gugun"] = htmlspecialchars(stripslashes($row["gugun"]));				
				$html["dong"] = htmlspecialchars(stripslashes($row["dong"]));						
				$html["ri"] = htmlspecialchars(stripslashes($row["ri"]));		
				$html["bldg"] = htmlspecialchars(stripslashes($row["bldg"]));							
				$html["bunji"] = htmlspecialchars(stripslashes($row["bunji"]));							
				$html["seq"] = htmlspecialchars(stripslashes($row["seq"]));						

				$html["dummy1"] = htmlspecialchars(stripslashes($row["dummy1"]));						
				$html["dummy2"] = htmlspecialchars(stripslashes($row["dummy2"]));							
				$html["dummy3"] = htmlspecialchars(stripslashes($row["dummy3"]));				
				$html["dummy4"] = htmlspecialchars(stripslashes($row["dummy4"]));					
				$html["dummy5"] = htmlspecialchars(stripslashes($row["dummy5"]));					
				$html["dummy6"] = htmlspecialchars(stripslashes($row["dummy6"]));				
				$html["dummy7"] = htmlspecialchars(stripslashes($row["dummy7"]));				
				$html["dummy8"] = htmlspecialchars(stripslashes($row["dummy8"]));				
				$html["dummy9"] = htmlspecialchars(stripslashes($row["dummy9"]));				
				$html["dummy10"] = htmlspecialchars(stripslashes($row["dummy10"]));

				$zipcode = $html["zipcode"];
				$arr_zipcode = explode("-",$zipcode);
				$address = $html["sido"]." ".$html["gugun"]." ".$html["dong"]." ".$html["ri"]." ".$html["bldg"]." ".$html["bunji"];
				$address2 = $html["sido"]." ".$html["gugun"]." ".$html["dong"]." ".$html["ri"]." ".$html["bldg"];

				echo ("
					<tr>
						<td class='zipcode'>
							".$zipcode."
						</td>

						<td class='address'>
							".$address."
						</td>
						
						<td>
							<input type='button' value='선택' onclick='window.opener.document.$_GET[formname].$_GET[id1].value=\"$arr_zipcode[0]\";window.opener.document.$_GET[formname].$_GET[id2].value=\"$arr_zipcode[1]\";window.opener.document.$_GET[formname].$_GET[id3].value=\"$address2\";window.opener.document.$_GET[formname].$_GET[id4].focus();window.opener.document.$_GET[formname].$_GET[id4].style.backgroundColor=\"#688fb5\";window.close();'>
						</td>
					</tr>
				");
				}//while 문 끝
			

			echo ("
				</tbody>
				</table>
			</div>
			");
		}//결과 출력 끝
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
<TITLE>우편번호찾기</TITLE>
<META NAME="author" CONTENT="애드폼">
<style type="text/css">
*{font-size:13px;}
div{width:100%;margin:auto;text-align:center;}
#tip p{text-align:left;font-weight:bold;color:#616588;}
table{width:100%;}
th{background-color:#ccc;padding:5px;border:1px solid #999;}
tr.ruled{background-color:#669999;}
.ruled td{border:1px solid #ff6600;color:#fff;}
td{text-align:center;padding-left:5px;border:1px solid #e3e3e3;}
.zipcode{font-weight:bold;}
.address{text-align:left;}
input{font-size:11px;}
p{text-align:left;margin:0;padding:0;}
</style>

<script type="text/javascript" src='js/pop_center.js'></script>
<script type="text/javascript" src='admine/js/tableruller.js'></script>

</HEAD>

<!--//////////////////////////////////////////////////////////////////////////////////-->
<!--################################  BODY start  ####################################-->
<!--//////////////////////////////////////////////////////////////////////////////////-->
<BODY onload="document.form1.keywd.focus();tableruler();">

<DIV> 
	<FORM NAME="form1" id="form1" method="get" action='zipcode_search.php'>
	<input type="hidden" name="mode" value="search">
		<!--##############################	 head	##################################-->
		<div>
			<h1 style="background-color:white;text-align:left;font-size:1.5em;font-weight:bold;">우편번호찾기</h1>			
			<HR>		
		</div>
		<!--##############################	 main	##################################-->
		<div>
			<div style="text-align:left;margin-bottom:10px;color:gray;">
				<input type="text" name="keywd" value="<?php echo $_GET[keywd];?>" style="ime-mode:active;background-color:#5472a8;color:#fff;" onclick='this.value="";'>
				<input type="hidden" name="id1" value="<?php echo $_GET[id1];?>">
				<input type="hidden" name="id2" value="<?php echo $_GET[id2];?>">
				<input type="hidden" name="id3" value="<?php echo $_GET[id3];?>">
				<input type="hidden" name="id4" value="<?php echo $_GET[id4];?>">	
				<input type="hidden" name="formname" value="<?php echo $_GET[formname];?>">
				<input type="image" src="imgs/search_zipcode.gif" style="vertical-align:top;">
			</div>
			<?php 
			if($_GET[mode]=="search") 
				{
					f_loopRec();
				}
			else
				{
				echo ("
					<div id='tip'>
						<p>* 동(읍/면/리) 이름을 한글 2자 이상 입력하신 후, 찾아주세요</p>
						<p>* 검색예)  개포,개포동,개포1동...</p>
					</div>
					");
				}
			?>		
		</div>
		<!--##############################	 foot	##################################-->				
	</FORM>	
</DIV>
</BODY>

</HTML>
