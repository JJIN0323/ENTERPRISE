<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<meta name='robots' content='none,noindex,nofollow'>
<title>애드폼 퍼미션 검사</title>
<LINK REL="stylesheet" HREF="style_setup.css" TYPE="text/css">
</head>
<body style='background: url(imgs/box_s.jpg);background-repeat:no-repeat;background-position:top right;'>

<img src="imgs/setup2.gif" alt="설치진행이미지2">
<h1>퍼미션검사 <span style='color:#999;font-size:15px'>STEP 2/5</span></h1>
<p>이 단계에서는, 특정한 폴더와 파일의 퍼미션(접근권한)을 검사합니다.</p>
<div id="chk_permsWrapper">
	<table id="head">
		<tr>
			<td class='left' nowrap>
				검사
			</td>				
			<td class='center' style="text-align:center"nowrap>
				폴더/파일 경로				
			</td>
			<td class='right' nowrap>
				결과
			</td>
		</tr>
	</table>
<?php
/* ------------------------------------------------------------------------------------*/
/*							퍼미션 체크할 폴더와 파일의 배열						   */
/* ------------------------------------------------------------------------------------*/
$arr_perm = array();
$arr_perm[0] = "lib";
//$arr_perm[1] = "lib/level.ini";
//$arr_perm[1] = "upload";

/*$folder=dir("upload/");
$num = 2;
while($entry=$folder->read())
{
	$target = "upload/$entry";
	//폴더안에 보이지 않는 무엇이 .. 과 .  폴더로 인식되어 and 처리
	if (is_dir($target) and $entry != ".." and $entry != ".")
	{
	$arr_perm[$num] = "upload/".$entry;
	$num++;
	}
}
$folder->rewind();
unset($folder);*/


$errN == 0;
/* ------------------------------------------------------------------------------------*/
/*							폴더 퍼미션 체크										   */
/* ------------------------------------------------------------------------------------*/
for($i = 0; $i < count($arr_perm); $i++)
{
	$f_perm = substr(sprintf('%o', fileperms(''.$arr_perm[$i].'')), -4);
	$alt_perm = "";
	if($f_perm == "0707" or $f_perm == "0777") 
	{
		$chk_img = "<img src='imgs/perms_ok.gif' alt='퍼미션정상'>";
		$alt_perm = "<span style='color:#006600'>퍼미션 OK</span>";	
	}
	else
	{
		$errN++;
		$chk_img = "<img src='imgs/perms_err.gif' alt='퍼미션에러'>";
		$alt_perm = "<span style='color:red'>퍼미션을 707 로 수정하세요</span>";		
	}
	echo "<table>";
		echo "<tr>";
			echo "<td class='left'>$chk_img</td>";
			echo "<td class='center' nowrap><img src='imgs/folder.gif' style='vertical-align:middle'> $arr_perm[$i]</td>";
			echo "<td class='right' nowrap>$alt_perm</td>";
		echo "</tr>";
	echo "</table>";
	flush(); 
	usleep(100000);
}

/* ------------------------------------------------------------------------------------*/
/*							pp_cli 파일의 퍼미션과 byte 검사						   */
/* ------------------------------------------------------------------------------------*/
$err_size = 0;
$pp_cliPath = "plugin/PG/kcp/payplus/bin/pp_cli";
if(file_exists($pp_cliPath))
{
$f_perm = substr(sprintf('%o', fileperms(''.$pp_cliPath.'')), -4);

if($f_perm == "0707" or $f_perm == "0777")
	{
	echo "<table>";
		echo "<tr>";
			echo "<td class='left'><img src='imgs/perms_ok.gif' alt='퍼미션정상'></td>";
			echo "<td class='center' nowrap><img src='imgs/folder.gif' style='vertical-align:middle'> $pp_cliPath</td>";
			echo "<td class='right' nowrap><span style='color:red'><span style='color:#006600'>퍼미션 OK</span></span></td>";
		echo "</tr>";
	echo "</table>";
	flush(); 
	usleep(100000);
	}
else
	{
	echo "<table>";
		echo "<tr>";
			echo "<td class='left'><img src='imgs/perms_err.gif' alt='퍼미션에러'></td>";
			echo "<td class='center' nowrap><img src='imgs/folder.gif' style='vertical-align:middle'> $pp_cliPath</td>";
			echo "<td class='right' nowrap><span style='color:red'>퍼미션을 777 로 수정하세요</span></td>";
		echo "</tr>";
	echo "</table>";
	$err_size++;
	flush(); 
	usleep(100000);
	}

if(filesize($pp_cliPath) != 337032)
	{
	echo "<table>";
		echo "<tr>";
			echo "<td class='left'><img src='imgs/perms_err.gif' alt='사이즈에러'></td>";
			echo "<td class='center' nowrap><img src='imgs/folder.gif' style='vertical-align:middle'> $pp_cliPath</td>";
			echo "<td class='right' nowrap><img src='imgs/err_pp_cli.gif' alt='파일사이즈 에러'></td>";
		echo "</tr>";
	echo "</table>";
	$err_size++;
	flush(); 
	usleep(100000);
	}
else
	{
	echo "<table>";
		echo "<tr>";
			echo "<td class='left'><img src='imgs/perms_ok.gif' alt='사이즈정상'></td>";
			echo "<td class='center' nowrap><img src='imgs/folder.gif' style='vertical-align:middle'> $pp_cliPath</td>";	
			echo "<td class='right' nowrap><span style='color:#006600'>파일사이즈 적합(".filesize($pp_cliPath)." byte)</span></td>";
		echo "</tr>";
	echo "</table>";
	flush(); 
	usleep(100000);
	}	
}
				

/* ------------------------------------------------------------------------------------*/
/*							퍼미션에러일 때는 무조건 재검사							   */
/* ------------------------------------------------------------------------------------*/
$errTotal = $errN+$err_size;
if($errN > 0) 
{
	echo ("
		  <table>
			  <tr>
				  <td colspan=3 style='background-color:#fff;padding:10px;'>
				  <h2>결과보고(result)</h2>
					<p>부적합한 항목이 <strong>$errTotal</strong> 개 있습니다.</p>
					<p><img src='imgs/perms_err.gif' style='vertical-align:middle'> 로 표시된 항목의 결과를 본 후, 지시에 따라 주십시오.</p>
					<input type='button' value='재검사' onclick='document.location.href=\"setup1.php\";' style='width:100px;height:30px;'>
				  </td>			
			  </tr>
		  </table>
		");
}

/* ------------------------------------------------------------------------------------*/
/*							퍼미션은 정상이나 pp_cli 사이즈는 부적합일 때 양자택일	   */
/* ------------------------------------------------------------------------------------*/
if($errN == 0 and $err_size > 0) 
{
	echo ("
		  <table>
			  <tr>
				  <td colspan=3 style='background-color:#fff;padding:10px;'>
				  <h2>결과보고(result)</h2>
					<p>KCP 신용카드결제 연동시 부적합한 항목이 <strong>$errTotal</strong> 개 있습니다.</p>
					<p>접수나 주문시 KCP 신용카드결제 연동을 하지 않을 경우엔, 무시하고 설치해도 됩니다.</p>
					<p><img src='imgs/perms_err.gif' style='vertical-align:middle'> 로 표시된 항목의 결과를 본 후, 지시에 따라 주십시오.</p>
					<input type='button' value='재검사' onclick='document.location.href=\"setup1.php\";' style='width:100px;height:30px;'>
					<input type='button' value='무시하고 설치하기' onclick='document.location.href=\"setup2.php\";' style='width:150px;height:30px;'>
				  </td>			
			  </tr>
		  </table>
		");
}

/* ------------------------------------------------------------------------------------*/
/*							모두 정상일 때 다음과정으로 							   */
/* ------------------------------------------------------------------------------------*/
if($errN == 0 and $err_size == 0) 
{	
	echo ("
		  <table>
			  <tr>
				  <td colspan=3 style='background-color:#fff;padding:10px;'>
				  <h2>결과보고(result)</h2>
					<p><img src='imgs/perms_ok.gif' style='vertical-align:middle'> 퍼미션 적합성에 통과하였습니다.</p>
					<p>최상위 설치폴더의 퍼미션은 체크하지 못하므로, 조정하지 않았다면, 최상위 설치폴더 퍼미션을 707로 조정하시고 설치하십시오.</p>
					<input type='button' value='설치하기' onclick='document.location.href=\"setup2.php\";'>
				  </td>			
			  </tr>
		  </table>
		");
}
?>
</div>
</body>
</html>