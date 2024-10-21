<?php
include_once("../lib/lib.php");
include_once("../lib/C_CONNECT.php");
include_once("../lib/define_table.php");
include_once("../lib/authentication.php");

function f_get_forms()
{
global $DBconn;
///////DB에서 가져오기///////
$where = "";
$res=$DBconn->f_selectDB("*",TABLE5,$where);  //필드, 테이블, 조건절
$rows=mysql_num_rows($res[result]);			  //리턴된 행의 개수
if($rows)
	{
	$i=0;
	while($row = mysql_fetch_array($res[result]))
		{
		$i++;
		$name = htmlspecialchars(stripslashes($row["name"]));                	
		$title_text = htmlspecialchars(stripslashes($row["title_text"]));    

		echo ("
		<tr>
			<td style='width:30px;'>
				<input type='checkbox' name='chk_formname[]' value='$name' class='c' onclick='if(this.checked==true)document.getElementById(\"chk_formtitle$i\").checked=true;if(this.checked==false)document.getElementById(\"chk_formtitle$i\").checked=false;'>
				<input type='checkbox' name='chk_formtitle[]' value='$title_text' id='chk_formtitle$i' class='c' style='display:none;'>
			</td>
			<td style='width:100px;'>
				$name
			</td>
			<td>
				$title_text
			</td>
		</tr>
		");
		}
	}
}


$af_res="";														//출력 변수
$af_res1="";


$af_res .= "<?php \n";
$af_res .= "/***************************************************************************************/  \n";
$af_res .= "/* \n";
$af_res .= "set names utf8; \n";
$af_res .= "-- 애드폼 폼백업 \n";
$af_res .= "-- version: ".af_ver." \n"; 
$af_res .= "-- 프로그램출처 http://www.addform.net \n"; 
$af_res .= "-- 데이타베이스: ".$dbname."\n";
$af_res .= "-- 설치시 테이블이름: ".str_replace('_af','',db_tblname)."\n";
$af_res .= "-- 백업시각: ". date("Y.m.d.H.i.s") . "\n";
$af_res .= "*/ \n";
$af_res .= "/***************************************************************************************/  \n\n\n";
$af_res .="$"."arr_formupload = array();\n";
$af_res .= "define(\"chkver\",\"".af_ver."\"); \n";					
$af_res .= "$"."db_tblname=db_tblname; \n";						//설치시 테이블 이름

$af_res .= "$"."arr_formname = \"\"; \n";
$af_res .= "$"."arr_formtitle = \"\"; \n";
$af_res .= "$"."arr_formname = array(); \n";
$af_res .= "$"."arr_formtitle = array(); \n";
for($i = 0; $i < count($_POST[chk_formname]); $i ++)
{	
$af_res .= "$"."arr_formname[$i] = \"".$_POST[chk_formname][$i]."\"; \n";
$af_res .= "$"."arr_formtitle[$i] = \"".$_POST[chk_formtitle][$i]."\"; \n";
}
$af_res .= "\n\n\n";

$bak_fname = $_POST['bak_fname'].'.php';						//저장될 파일이름

/*-------------------------------------------------------------------------------------*/
/*                            $af_tbls[] 백업루프수 정의							   */
/*-------------------------------------------------------------------------------------*/
$where = db_tblname."_table";									//폼테이블
$af_tbls="";
$af_tbls=array();
	$af_tbls[] = mysql_query("SHOW TABLES LIKE '$where'");
for($i = 0; $i < count($_POST[chk_formname]); $i ++)
{
	$where2 = db_tblname."_".$_POST[chk_formname][$i]."_item";	//품목테이블들
	$af_tbls[] = mysql_query("SHOW TABLES LIKE '$where2'");
}

/*-------------------------------------------------------------------------------------*/
/*                                      모드가 있을 때								   */
/*-------------------------------------------------------------------------------------*/
if(!empty($_POST['mode']))										
{
	for($t = 0; $t < count($af_tbls);$t++)							//선택한 폼배열수만큼 루프				
	{
	if( mysql_num_rows($af_tbls[$t]))								//사용자정의한 애프폼설치 테이블명이 있다면
		{
			for($i = 0; $i < mysql_num_rows($af_tbls[$t]); $i++)
			{	
			$af_tbl = mysql_tablename ($af_tbls[$t], $i);			//불러온 테이블 이름
			$arr_af_tbl = explode("_af_",$af_tbl);					//테이블 이름 배열화
			$tblName = "$"."db_tblname";							//셋팅될 테이블 이름 서두 정의
			$af_tbl_var = $tblName;									//셋팅될 테이블 이름 서두(변수화해야...)

			$af_res .= "$"."tbl_tail"."="."\"_$arr_af_tbl[1]\"; \n";
			$tbl_tail_var = "$"."tbl_tail";							//셋팅될 테이블 이름 꼬리 정의
			$af_tbl_var = $af_tbl_var.$tbl_tail_var;				//셋팅될 테이블 이름 완성(변수화해야...)

			/*-------------------------------------------------------------------------*/ 
			/*------ 폼테이블 TABLE5는 기존테이블에 레코드만 insert into			 --*/
			/*------ 품목테이블은 기존테이블제거후 새로만들면서 레코드 insert into	 --*/
			/*-------------------------------------------------------------------------*/			
			if($arr_af_tbl[1] != "table")							//table5 가 아닐 때
			{
			$ti=$t-1;
			$af_res .= "if($"."_POST[chk_formname][$ti] == '1')  \n";
			$af_res .= "{  \n";	
			$af_res .= "/***************************************************************************************/  \n";
			$af_res .= "/* \n";
			$af_res .= "-- $af_tbl 의 테이블 구조 (scheme of $af_tbl) \n";			
			$af_res .= "*/ \n";
			$af_res .= "/***************************************************************************************/  \n";		
			
			$af_res .="$"."arr_formupload[] = \" \n";			
			$af_res .="DROP TABLE IF EXISTS $af_tbl_var\"";		
			$af_res .="; \n\n";	
			
			$af_res .="$"."arr_formupload[] = \" \n";			
			$af_res .= "CREATE TABLE $af_tbl_var ( \n";
			$af_res_field = mysql_query( "SHOW FIELDS FROM ".$af_tbl);
			$af_res1= "";											//*중복 막기 위해 이곳에 선언

			while($first_row = mysql_fetch_row($af_res_field) ) 
				{
				$af_res.= "".$first_row[0].""." ".$first_row[1]." " ;
				if($first_row[2]=="NO")
				$af_res.=" NOT NULL ";
				if(($first_row[4]!=""))
				$af_res.=" default ".$first_row[4]." ";				//*문법오류막기 위해 ` -> '
				if($first_row[5]!="")
				$af_res.=" ".$first_row[5]." ";
				if($first_row[3]=="PRI")
				$af_res1.=" PRIMARY KEY (".$first_row[0].")\n";		//*마지막 , 에러 막기 위해 ,\n에서 ,제거후 아래 두줄 주석처리
				//if($first_row[3]=="MUL")
				//$af_res1.=" KEY ".$first_row[0]."("."`".$first_row[0]."`"."),\n";
				$af_res.=",\n";
				}
			$af_res .= $af_res1;
			$af_res .= "\n)$af_charset\";";							//$af_charset - 문자셋 세팅
			$af_res .="\n\n";
			}			
			
			/*-------------------------------------------------------------------------*/ 
			/*------ 폼테이블 TABLE5일 때는, 선택한폼이름과 일치하는 레코드만 백업   --*/			
			/*-------------------------------------------------------------------------*/			
			$where = "";											
			if($arr_af_tbl[1] == "table")							//table5 일때 검색조건설정
				{
					$where .= " where name = '".$_POST[chk_formname][0]."' ";					
					for($x = 0; $x < count($_POST[chk_formname]);$x++)
					{					
					$where .= "or name='".$_POST[chk_formname][$x+1]."' ";
					}
				}
		

			$q = mysql_query("select * from $af_tbl $where");
			$num_fields = mysql_num_fields($q);
			$numrow = mysql_num_rows($q);
			
			$af_res .= "/* \n";			
			$af_res .= "-- $af_tbl 테이블의 덤프데이터 (dump of $af_tbl) \n";			
			$af_res .= "*/ \n";
			$z = "0";
			while( $second_row = mysql_fetch_array($q, MYSQL_NUM))
				{
					if($arr_af_tbl[1] == "table")							
					{
						$af_res .= "if($"."_POST[chk_formname][".$z++."] == '1')  \n";
						$af_res .= "{  \n";
					}
					$af_res .="$"."arr_formupload[] = \" \n";
					$af_res .= "INSERT INTO ".$af_tbl_var." VALUES(";
					for($j=0; $j<$num_fields; $j++)
						{
						$second_row[$j] = addslashes($second_row[$j]);
						$second_row[$j] = str_replace("\n","\\n",$second_row[$j]);
						$second_row[$j] = str_replace("\r","",$second_row[$j]);
						if (isset($second_row[$j]))
							{
							if($arr_af_tbl[1] == "table" and $j == 0)
								{
								$af_res .= "''";//폼테이블은 drop후 하지 않아서, 일련번호 오토 인크리즈에 맡김
								}
							else
								{
								$af_res .= "'$second_row[$j]'";
								}
							}
						else
							{
							$af_res .= "''";
							}
						if ($j<($num_fields-1))
						$af_res .= ", ";
						}
					$af_res .= ")\";\n";
					if($arr_af_tbl[1] == "table")							
					{						
						$af_res .= "}  \n\n";
					}
				}
				if($arr_af_tbl[1] != "table")							
				{
				$af_res .= "} \n\n";
				}


			if ($i+1 != mysql_num_rows($af_tbls[$t]))
			$af_res .= "\n\n";			
			}//작은 for $i 문 end	

		}

	else  
		{
			die ("데이타베이스에 현재 사용중인 애드폼과 관련된 백업할 테이블이 없습니다.<br>The database is currently being used to backup the table is not associated with the addform");
		}
		$af_res .= "\n\n\n";
	}//큰 for $t문 end
	$af_res .= "?>";

	//Content-Disposition: attachment; 헤더로 강제 저장
	if((isset($_POST['mode'])) && ($_POST['mode'] == "bak"))
	{ 
		ob_clean();
		ob_start();
		Header("Content-type: application/octet-stream");
		Header("Content-Disposition: attachment; filename=$bak_fname");
		echo $af_res;
		ob_end_flush();
	}
}

/*-------------------------------------------------------------------------------------*/
/*                                 모드가 없는 초기화면								   */
/*-------------------------------------------------------------------------------------*/
else	
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<meta name='robots' content='none,noindex,nofollow'>
<LINK REL="stylesheet" HREF="global.css" TYPE="text/css">
<style type="text/css">
	div{width:90%;text-align:left;background-color:#fff;padding:10px;margin-top:10px;}
	fieldset{width:90%;}
</style>
<script type="text/javascript" src='js/pop_center.js'></script>
<script type="text/javascript">
<!--
var tag = "false";
function chk_all(frm,th) 
{
	var field=document.getElementsByTagName('input');				
	if (tag == "false") 
		{
		for (i = 0; i < field.length;i++)
			{							
			if(field[i].className=='c')
				{							
				field[i].checked = true;							
				}
			}
			tag = "true";
			th.value="전체해제"; 
		}
	else 
		{
		for (i = 0; i < field.length;i++)
			{								
			if(field[i].className=='c')
				{							
				field[i].checked = false;							
				}
			}
			tag = "false";
			th.value="전체선택"; 
		}
}

function f_backup(frm)
{
	var field=document.getElementsByTagName('input');
	var chkN = 0;
	
		for (i = 0; i < field.length;i++)
			{							
			if(field[i].className=='c')
				{							
				if(field[i].checked == true) chkN++;							
				}
			}
	if(chkN == 0) 
		{
			alert("백업할 폼을 하나 이상 선택하세요");	
			return false;
		}

	if(frm.bak_fname.value == "") 
		{
			alert("저장될 파일이름을 입력하여 주세요");			
			return false;
		}	
	
	frm.submit();
}
-->
</script>
<TITLE>애드폼 폼백업</TITLE>
</head>
<body>
	<form name='form1' method='post' action="" onsubmit='return false;'>
	<input type="hidden" name="mode" value="bak">

	<fieldset>
		<legend>폼백업</legend>
			<div>
				<p style="color:#004a84;">생성한 폼들을 PC 에 백업후, 아래와 같이 이용할 수 있습니다.</p>
				<hr>
				 - 필요할 때, 폼을 복구할 수 있습니다.<br>
				 - 다른 서버에 설치된 애드폼에 쉽게 이식할 수 있습니다.<br>
				 - 다른 애드폼 사용자와 폼을 교환하거나 공유할 수 있습니다.	
			</div>					
	</fieldset>

	<fieldset>
		<legend>백업할 폼 선택</legend>
			<div>
				<table style="width:100%;">
					<tr>
						<td colspan="3" style="border:0;text-align:left;padding-left:0;">
							<input type="button" name="chkbox_all" value="전체선택" onclick="chk_all(this.form,this);">
						</td>						
					</tr>
					<?php 
						f_get_forms();
					?>
				</table>
			</div>
	</fieldset>

	<fieldset>
		<legend>아래 이름으로 저장</legend>
			<div style="">
				<input type='text' name='bak_fname' value='BakupAddform<?php echo "_".date("Ymd");?>' size="30">.php
			</div>
	</fieldset>

	<input type='button' name='btn_submit' value='Backup' style="width:139px;height:50px;" onclick="f_backup(this.form);"> 
	</form>

</body>
</html>
<?
}//else 문 끝
?>





