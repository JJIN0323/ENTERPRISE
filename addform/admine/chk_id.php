<?
include_once("../lib/lib.php");
include_once("../lib/C_CONNECT.php");
include_once("../lib/define_table.php");
include_once("../lib/authentication.php");

/* ----------------------------------------------------------------------------------- */
/*	프로그램명 : 애드폼(영문 addform												   */									
/*	프로그램용도: 견적서 주문서 폼메일 제작											   */
/*	제작자: 박성규																	   */
/*	공식배포처: http://www.addform.net												   */
/*  프로그램 편집시 위 제작자 정보를 편집하거나 삭제해서는 안됩니다.				   */
/* ----------------------------------------------------------------------------------- */

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
	<HEAD>
		<meta http-equiv='content-type' content='text/html; charset=utf-8'>
		<meta name='robots' content='none,noindex,nofollow'>
		<TITLE>아이디 중복검사</TITLE>
		<script type="text/javascript"> 
			<!-- 
		var w= 100;//새창의 너비
		var h= 100;//새창의 높이
		var winH = (screen.height) ? (screen.height-h)/2 : 0;
		var winW = (screen.width) ? (screen.width-w)/2 : 0;
		window.moveTo(winW, winH); // 새창의 위치(왼쪽, 위쪽) 
		window.resizeTo(w, h); // 새창의크기 (가로, 세로) 
		//--> 
		</script>
	</HEAD>
	<BODY>
	</BODY>
</HTML>

<?
if (strlen($_GET['user_id']) < 1) {
	echo "<script type='text/javascript'>
		alert('아이디를 입력하여 주세요');
		opener.document.form1.user_id.select(); self.close();</script>
		"; exit;
}
#########################################################################################
################################  폼이름 중복검사 start  ################################
#########################################################################################
		$clean = "";
		$clean = $_GET['user_id'];								   //폼이름 중복검사를 위한 정의
		$where = "where user_id='$clean'";						   //조건절
		$res=$DBconn->f_selectDB("*",TABLE1,$where);			   //필드, 테이블, 조건절
		if($res[cnt] > 0) {
			echo "<script type='text/javascript'>
			alert('이미 등록되어 있는 아이디입니다.');opener.document.form1.user_id.select();self.close();</script>
			"; exit;
		}
		else {
			echo "<script type='text/javascript'>alert('사용할 수 있는 아이디입니다.');opener.document.form1.password.focus();self.close();</script>
			"; exit;
		}		
?>



