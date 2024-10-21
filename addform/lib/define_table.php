<?php
if (!class_exists("C_CONNECT")) {
	die("C_CONNECT 클래스가 존재하지 않습니다!");
}	
//$DBconn로 C_CONNECT 클래스 객체를 생성하여 C_CONNECT 클래스의 함수와 변수에 접근
$DBconn=new C_CONNECT;
//상수정의:이 문서에서 주 작업대상이 되는 Mysql 테이블 정의
define("TABLE1","".db_tblname."_admine_table");
define("TABLE2","".db_tblname."_env");
define("TABLE3","".db_tblname."_group_table");
define("TABLE4","".db_tblname."_order_table");
define("TABLE5","".db_tblname."_table");
define("TABLE7","".db_tblname."_layout");
?>