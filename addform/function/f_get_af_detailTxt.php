<?
function f_get_af_detailTxt($upload_path,$name,$x)		//업로드 경로,폼이름,파일이름일련번호
{

#########################################################################################
##############	업로드 폴더에서 물품상세 텍스트 가져오기	#####################
#########################################################################################
	if(file_exists($upload_path.$name."/".$x.".txt"))	//이미지 설명 파일이 있을 경우 읽기모드로 가져옴
		{
		$txt_path = $upload_path.$name."/".$x.".txt";
		if(filesize($txt_path) == 0) $fs = "100";		//filesize(경로)에서 0 일 경우 에러방지위해...
		else $fs = filesize($txt_path);				
		$fp = fopen($txt_path,"r");
		$detail_memo = fread($fp,$fs);
		}


	$arr = array();
	$arr["detail_memo"] = $detail_memo;	
	return $arr;
}
?>