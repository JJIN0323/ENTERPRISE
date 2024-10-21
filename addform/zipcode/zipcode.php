<?php
/* ----------------------------------------------------------------------------------- */
/*	프로그램명 : 애드폼(영문 addform)												   */									
/*	프로그램용도: 견적서 주문서 폼메일 제작											   */
/*	제작자: 박성규																	   */
/*	공식배포처: http://www.addform.net												   */
/*  프로그램 편집시 위 제작자 정보를 편집하거나 삭제해서는 안됩니다.				   */
/* ----------------------------------------------------------------------------------- */
/*-------------------------------------------------------------------------------------*/
/*						우편번호 DB 셋팅											   */
/*-------------------------------------------------------------------------------------*/
include_once("../lib/C_CONNECT.php");		//DB 입출력 class 파일
include_once("../lib/define_table.php");	
include_once("../lib/addform_scheme.php");	//초기 DB 테이블 구조

//파일버전 : zipcode_20090224 type0
//2009년 제1차 우편번호 변경내역 (2009.02.24.자)


if(!$_POST and !$_GET)
{
	######################	이미 생성된 테이블 있을 경우 설치 불가 ######################
	$addform_list = mysql_query("show table status from ".$dbname." like '".db_tblname."_zipcode%'") or mysql_error();
	$tables=mysql_num_rows($addform_list);
	
	if($tables >= 1)
	{
	die("
	<DIV>이미 우편번호 DB 가 생성되어 있습니다.</DIV>
	");
	}

	################################	우편번호 테이블 생성 ############################
	mysql_query($create_addform_zipcode	) or die("<script type='text/javascript'>document.location.href='setup4.php'</script>");

	echo ("
	<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01//EN\"   \"http://www.w3.org/TR/html4/strict.dtd\">
	<HTML>

	<HEAD>
	<meta http-equiv='content-type' content='text/html; charset=utf-8'>
	<meta name='robots' content='none,noindex,nofollow'>
	<TITLE>애드폼 우편번호 셋팅</TITLE>
	<META NAME='author' CONTENT='애드폼'>
	<LINK REL='stylesheet' HREF='global.css' TYPE='text/css'>
	</HEAD>	
	<BODY>
	<div style='width:300px;height:100px;position:absolute;top:50%;left:50%;margin-left:-150px;margin-top:-150px;border:5px solid gray;'>
	<div style='font-weight:bold;margin:20px;text-align:center;'>잠시만 기다려주세요...</div>
	");
	
	for($i=0;$i<51;$i++)
	{
		include_once("zipcode".$i.".php");
		//우편번호 입력		
		$DBconn->f_InsertDBMulti("".db_tblname."_zipcode","zipcode,sido,gugun,dong,ri,bldg,bunji,seq",&$arr_zipcode);
		echo "<div id='progress$i' style='color:#669999;text-align:center;'>우편번호 DB 셋팅 <strong style='color:blue;'>".$i."</strong>/<strong>51</strong> 완료</div>";
		flush(); 
		usleep(100000);
		echo "<script type='text/javascript'>document.getElementById('progress$i').style.display='none';</script>";
		
	}

	echo ("
	</div>
	</BODY>

	</HTML>
	");


	###################################		완료후 이동 #################################
	die("<script type='text/javascript'>document.location.href='../setup4.php'</script>");
}
else{die("error!");}

?>