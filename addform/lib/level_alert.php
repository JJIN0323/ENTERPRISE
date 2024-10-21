<?php
if($page_id == "admine_add.php" and ($_GET[mode] == "modify" or $_POST[mode] == "modify_ok") and !$_GET[no])
{
	//내정보수정일 때는 권한과 관계없이 가능하게...
}
else
{
	if($arr_pageid[1] and $af_adminMember[level] > $arr_pageid[1])
	{
		die("
			<!DOCTYPE html PUBLIC '-//W3C//DTD HTML 4.01//EN'   'http://www.w3.org/TR/html4/strict.dtd'>
			<HTML>
			<HEAD>
			<meta http-equiv='content-type' content='text/html; charset=utf-8'>
			<meta name='robots' content='none,noindex,nofollow'>
			<TITLE>권한이 필요합니다.</TITLE>
			<META NAME='author' CONTENT='애드폼'>
			<LINK REL='stylesheet' HREF='global.css' TYPE='text/css'>
			<style type='text/css'>
				td{padding:10px;}
				.item{width:150px;background-color:gray;font-weight:bold;color:#fff;}
				.val{text-align:left;}
			</style>
			</HEAD>		
			<BODY>
			<DIV style='margin-top:100px;width:70%;padding:30px;border:5px solid gray;background-color:#fff;'> 

				<table>
					<tr>
						<td class='item'>
							사원 I D
						</td>
						<td class='val' style='font-weight:bold;'>
							".$af_adminMember[user_id]."
							<input type='button' value='내정보보기' onclick=\"javascript:void(window.open('admine_add.php?w=600&amp;h=650&amp;mode=modify','modify','width=600,height=650,statusbar=no,scrollbars=yes,toolbar=no'))\">
						</td>
					</tr>
					<tr>
						<td class='item'>
							사원등급
						</td>
						<td class='val'>
							".$af_adminMember[level]." 등급
						</td>
					</tr>
					<tr>
						<td class='item'>
							Message
						</td>
						<td class='val' style='color:red;'>
							".$arr_pageid[2]."		
						</td>
					</tr>
				</table>
				
			</DIV>
			</BODY>
			</HTML>		
		");
	}
}
?>