<?php
include_once("../lib/lib.php");
include_once("../lib/authentication.php");

$af_res="";
$af_res1="";


$af_res .= "set names utf8; \n";
$af_res .= "-- 애드폼 백업 \n";
$af_res .= "-- version: ".af_ver." \n"; 
$af_res .= "-- http://www.addform.net \n"; 
$af_res .= "-- 데이타베이스: ".$dbname."\n";
$af_res .= "-- 설치시 테이블이름: ".str_replace('_af','',db_tblname)."\n";
$af_res .= "-- 백업시각: ". date("Y.m.d.H.i.s") . "\n\n";


$bak_fname = db_tblname."_".date("Ymd").'.sql';					//저장될 파일이름
$where = db_tblname.$_POST['tbl']."%";

$af_tbls =mysql_query("SHOW TABLES LIKE '$where'");

if(!empty($_POST['mode']))										//모드가 있을 때
{
	if( mysql_num_rows($af_tbls))								//사용자정의한 애프폼설치 테이블명이 있다면
	{
		for($i = 0; $i < mysql_num_rows($af_tbls); $i++)
		{	
		$af_tbl = mysql_tablename ($af_tbls, $i);
		$af_res .= "-- ----------------------------------------------------------------------- \n";
		$af_res .= "-- $af_tbl 의 테이블 구조 (scheme of $af_tbl) \n";
		$af_res .= "-- \n";
	
		$af_res .="DROP TABLE IF EXISTS `$af_tbl`;\n";			//각 테이블 구조
		$af_res .= "CREATE TABLE `$af_tbl` ( \n";
		$af_res_field = mysql_query( "SHOW FIELDS FROM ".$af_tbl);
		$af_res1= "";											//*중복 막기 위해 이곳에 선언

		while($first_row = mysql_fetch_row($af_res_field) ) 
			{
			$af_res.= "`".$first_row[0]."`"." ".$first_row[1]." " ;
			if($first_row[2]=="NO")
			$af_res.=" NOT NULL ";
			if(($first_row[4]!=""))
			$af_res.=" default '".$first_row[4]."' ";			//*문법오류막기 위해 ` -> '
			if($first_row[5]!="")
			$af_res.=" ".$first_row[5]." ";
			if($first_row[3]=="PRI")
			$af_res1.=" PRIMARY KEY (`".$first_row[0]."`)\n";	//*마지막 , 에러 막기 위해 ,\n에서 ,제거후 아래 두줄 주석처리
			//if($first_row[3]=="MUL")
			//$af_res1.=" KEY ".$first_row[0]."("."`".$first_row[0]."`"."),\n";
			$af_res.=",\n";
			}
		$af_res .= $af_res1;
		$af_res .= "\n)$af_charset;\n\n";						//$af_charset - 문자셋 세팅

		$af_res .= "-- \n";
		$af_res .= "-- $af_tbl 테이블의 덤프데이터 (dump of $af_tbl) \n";
		$af_res .= "-- \n";
		$q = mysql_query("select * from $af_tbl");
		$num_fields = mysql_num_fields($q);
		$numrow = mysql_num_rows($q);

		while( $second_row = mysql_fetch_array($q, MYSQL_NUM))
			{
			$af_res .= "INSERT INTO ".$af_tbl." VALUES(";
			for($j=0; $j<$num_fields; $j++)
				{
				$second_row[$j] = addslashes($second_row[$j]);
				$second_row[$j] = str_replace("\n","\\n",$second_row[$j]);
				$second_row[$j] = str_replace("\r","",$second_row[$j]);
				if (isset($second_row[$j]))
				$af_res .= "\"$second_row[$j]\"";
				else
				$af_res .= "\"\"";
				if ($j<($num_fields-1))
				$af_res .= ", ";
				}
			$af_res .= ");\n";
			}

		if ($i+1 != mysql_num_rows($af_tbls))
		$af_res .= "\n";
		}

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

	else  die ("데이타베이스에 현재 사용중인 애드폼과 관련된 백업할 테이블이 없습니다.<br>The database is currently being used to backup the table is not associated with the addform");
	}
else	//모드가 없을 때
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<meta name='robots' content='none,noindex,nofollow'>
<LINK REL="stylesheet" HREF="global.css" TYPE="text/css">
<script type="text/javascript" src='js/pop_center.js'></script>
<TITLE><?php echo af_txt_backup_1;?></TITLE>
</head>
<body>

<fieldset style="width:90%;">
	<legend><?php echo af_txt_backup_1;?></legend>
	<form name='form1' method='post' action="">
	<input type="hidden" name="mode" value="bak">
	<input type='submit' name='submit1' value='Backup'>

	<fieldset style="text-align:left;">
		<legend>DB NAME</legend>
		<?php echo $dbname;?>
	</fieldset>

	<fieldset style="text-align:left;">
		<legend>tables</legend>
		<?php 
		for($i = 0; $i < mysql_num_rows($af_tbls); $i++)
			{	
			echo mysql_tablename ($af_tbls, $i)."<br/>";
			}
		?>
	</fieldset>	
	
	<input type='submit' name='submit2' value='Backup'>
	</form>
</fieldset>

</body>
</html>
<?
}//else 문 끝
?>





