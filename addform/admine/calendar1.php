<?
//현재일 타임스탬프
$tStamp = time();

//작은달력에 건네줄 현재달과 다음달 4개의 년도구하기
if($_POST["y"])
{
	$Y1 = $_POST["y"];
	$M1 = $_POST["m"];
	$M1txt = date("M",mktime(0,0,0,$M1,1,$Y1));
}
else
{
	$Y1 = date("Y");
	$M1 = date("n");
	$M1txt = date("M",mktime(0,0,0,$M1,1,$Y1));
}

$YM = $Y1.$M1;
if(date("Yn",time()) == $YM)
{
	$c1Style = "background-image:url(img/".$M1."c.gif);background-repeat:no-repeat;background-position:center 45px;";
}
else 
{
	$c1Style = "background-image:url(img/".$M1.".gif);background-repeat:no-repeat;background-position:center 45px;";
}
?>