<?
function f_af_formStyle()
{
#########################################################################################
#############				폼스타일 업로드 함수 호출			   ######################
#########################################################################################
if($_POST)
	{
	if(!is_dir("../upload/".$_POST['name'].""))
		{
	mkdir("../upload/".$_POST['name']."", 0707);
	chmod("../upload/".$_POST['name']."", 0707);
		}		

		$uploadPath = "../upload/".$_POST['name']."/";				//업로드 경로
	
		$connect_file = fopen("".$uploadPath ."formStyle.css", "w") or die("파일 읽기에 실패하였습니다.");
		fwrite($connect_file, $_POST['formStyle']);
		fclose($connect_file);
	}
	
}
?>