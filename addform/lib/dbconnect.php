<?
$sock=mysql_connect($db_hostname,$db_username,$db_password) or die("데이타베이스 연결에 실패했습니다");
$db = mysql_select_db($dbname,$sock) or die("데이타베이스 연결에 실패했습니다");
mysql_query("set names utf8");
?>