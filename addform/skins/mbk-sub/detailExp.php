<?php
include_once("function/f_get_af_detailTxt.php");

$af_limit = 10;
$arr_float = array();
$af_upload_path = "upload/";	


for($x = 0; $x < $af_limit; $x++)
{
$float_file = @file($af_upload_path.$_GET['fname']."/float.txt");		//float 속성 파일을 개행 배열
$arr_float[$x] = $float_file[$x];										//다시 배열화		
}
?>

<?php 
$af_arr_format = array("jpg","jpeg","gif");									//업로드 된 허용확장자
$chk_division = 0;															//출력된 것이 있나 체크하기 위한 변수

for($x = 0; $x < $af_limit; $x++)
{
																			//이미지 설명글 텍스트 파일에서 메모가져옴
	$af_detailTxt = f_get_af_detailTxt($af_upload_path,$_GET['fname'],$x);
	$af_detailTxt = nl2br(stripslashes($af_detailTxt['detail_memo']));	

	#####	float 일 때 이미지 div 좌우 마진 처리  #####	
	if($arr_float[$x] == "left\n")
		{
		$imgMargin = "margin:0 1.5em 1em 0;";								
		}
	else if($arr_float[$x] == "right\n")
		{
		$imgMargin = "margin:0 0 1em 1.5em;";							
		}
	else
		{
		$imgMargin = "margin:0 0 1em 0;";	
		}
	
	#####	업로드 된 이미지가 있을 경우 이미지 출력  #####		
	for($i=0; $i < count($af_arr_format);$i++)
		{
		if(file_exists($af_upload_path.$_GET['fname']."/".$x.".".$af_arr_format[$i].""))
			{
			echo "<div style='text-align:center;float:".$arr_float[$x].";".$imgMargin."'>";
			echo "<img src='".$af_upload_path.$_GET['fname']."/".$x.".".$af_arr_format[$i]."' style='border:1px solid #000;cursor:hand;' alt='detail img' onclick=\"pop_img('".$af_upload_path.$_GET['fname']."/".$x.".".$af_arr_format[$i]."')\">";
			echo "</div>";
			$chk_division++;
			$chk_float++;
			}
		}	

	#####	텍스트 파일이 있을 경우 텍스트 출력  #####	
	if($af_detailTxt)													
		{		
		echo "<div style='text-align:left;color:#333333;padding:0;'>";
		echo $af_detailTxt;
		echo "</div>";	
		$chk_division++;
		}

	#####	이미지 div 좌우 float일 때 아래 div 가 차고 올라오는것 방지	#####
	if($chk_division > 0)
		{
		echo "<div style='clear:both;margin:2em;padding:0;'></div>";
		}
}
?>