<?php
####################  문서 로딩시 새로운 내용을 보여주기 위해 no-cache ###################
header("Pragma: no-cache");   
header("Cache-Control: no-cache,must-revalidate"); 
####################  문자코드 지정 ######################################################
header("content-type: text/html; charset=utf-8");
include_once("db_ini.php");      //DB 접속정보
include_once("db_tblname.php");  //사용자정의 DB 테이블
include_once("dbconnect.php");   //DB 접속
include_once("function.php");    //함수 모음파일

####################  변수들 정의	######################################################

define("af_ver","addform-v7.2");
define("ver_tag","beta");

//DB 테이블 생성시 문자셋
if(mysql_get_client_info() < "4.1.00") $af_charset = "";
else $af_charset = "ENGINE = MYISAM DEFAULT CHARSET = utf8";

// 도움말 이미지 경로
define("af_help_img","http://www.addform.net/addform_help/");


//서버의 php.ini 파일에 설정된 upload_max_filesize 첨부파일 허용용량
define("upload_max_filesize",intval(substr(ini_get(upload_max_filesize),0,-1)) * 1024 * 1024);

define("HTTP_HOST",$_SERVER['HTTP_HOST']);
define("URL",$_SERVER['PHP_SELF']);

//설정된 언어 스킨 폴더경로 구하기
//초기 설치시 에러메시지 출력방지 위해 @ 처리하였음
$lang_result = @mysql_query("select * from ".db_tblname."_env where no=1");
$lang_row =  @mysql_fetch_array($lang_result);
define("addform_rang",htmlspecialchars(stripslashes($lang_row["lang"])));

if(addform_rang)								//초기설치시 에러메시지 출력방지 위해 if
	{
	include_once("lang/".addform_rang."/language.php"); 
	}
else{
	include_once("lang/korean/language.php"); 
	}

//관리자모드에 사용될 이미지 경로
define("af_admine_img","../lib/lang/".addform_rang."/img");
include_once("Func_textlicense.php");

//*************************		레벨권한(페이지별,기능별)		***********************//
function f_get_level_txt()
{
	if(file_exists("level.ini"))
	{	
	$path = "level.ini";
	}
	if(file_exists("lib/level.ini"))
	{	
	$path = "lib/level.ini";
	}
	if(file_exists("../lib/level.ini"))
	{	
	$path = "../lib/level.ini";
	}
	if(file_exists("../../lib/level.ini"))
	{	
	$path = "../../lib/level.ini";
	}

	$array = parse_ini_file($path);	
	return $array;
}
$arr_levelini = f_get_level_txt();

$page_id = basename(URL);
$arr_pageid = explode("®",$arr_levelini[$page_id]);				 //페이지별 열람권한배열

$arr_view_order = explode("®",$arr_levelini[view_order]);		 //접수내역 보기권한 배열
define("view_order_level",$arr_view_order[1]);	
define("view_order_msg",$arr_view_order[2]);

$arr_modify_order = explode("®",$arr_levelini[modify_order]);    //접수내역 수정권한 배열
define("modify_order_level",$arr_modify_order[1]);	
define("modify_order_msg",$arr_modify_order[2]);

$arr_del_order = explode("®",$arr_levelini[del_order]);			 //접수내역 삭제권한 배열
define("del_order_level",$arr_del_order[1]);	
define("del_order_msg",$arr_del_order[2]);

$arr_read_order = explode("®",$arr_levelini[read_order]);			 //접수내역 읽은상태로표시권한 배열
define("read_order_level",$arr_read_order[1]);	
define("read_order_msg",$arr_read_order[2]);

$arr_send_order = explode("®",$arr_levelini[send_order]);		 //견적보기 발송하기 전달하기 권한 배열
define("send_order_level",$arr_send_order[1]);	
define("send_order_msg",$arr_send_order[2]);

$arr_admine_del = explode("®",$arr_levelini[admine_del]);		  //사원삭제 권한 배열
define("admine_del_level",$arr_admine_del[1]);			
define("admine_del_msg",$arr_admine_del[2]);

$arr_levelModify = explode("®",$arr_levelini[admine_levelModify]);//등급변환 권한 배열
define("levelModify_level",$arr_levelModify[1]);			
define("levelModify_msg",$arr_levelModify[2]);

$arr_situModify = explode("®",$arr_levelini[situModify]);		 //처리상황변경 권한 배열
define("situModify_level",$arr_situModify[1]);			
define("situModify_msg",$arr_situModify[2]);

//*************************		레벨권한(페이지별,기능별)끝		***********************//


?>
