<?php
include_once("lib/lib.php");
include_once("lib/authentication.php");

$tbls = db_tblname;
$uninstall_addform = mysql_query("show table status from $dbname like '$tbls%'") or error("Uninstall Failure");
		while($table=mysql_fetch_array($uninstall_addform)) {
			mysql_query("drop table $table[Name]");
		}
@unlink("lib/db_ini.php");
@unlink("lib/db_tblname.php");
@unlink("lib/initial_lib.php");

die("
<!DOCTYPE html PUBLIC '-//W3C//DTD HTML 4.01//EN'   'http://www.w3.org/TR/html4/strict.dtd'>
<HTML>
<HEAD>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<title></title>
</HEAD>
<BODY>
	<TABLE style='border:0;width:100%;'>
	<TR>
		<TD style='text-align:center;color:#616588'>
			<h2><strong>애드폼이 제거되었습니다</strong></h2>
			<h2><strong>Success! Uninstall completion</strong></h2>
		</TD>
	</TR>
	</TABLE>
</BODY>
</HTML>
");
?>
