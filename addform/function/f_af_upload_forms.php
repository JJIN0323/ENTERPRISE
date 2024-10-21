<?
function f_af_upload_forms()
{
#########################################################################################
#############						폼백업파일 업로드 			   ######################
#########################################################################################
if($_FILES['upload_forms'])
	{	
		$tmp_name = $_FILES['upload_forms']['tmp_name'];				//서버에 저장된 임시파일이름
		$fileName = $_FILES['upload_forms']['name'];					//원본 파일이름
		$fileSize = $_FILES['upload_forms']['size'];					//파일용량
		$fileType = $_FILES['upload_forms']['type'];					//파일확장자			
		$attachFormat = "php";											//허용확장자
		$uploadPath = "../upload/";										//업로드 경로
		$array = pathinfo($fileName);
		$name = "backup_forms";
		$target_path = $uploadPath . $name.".".$array['extension'];	//파일이 저장될 위치와 파일이름
		
		if($fileName)												//에러방지위해 파일이 있을 경우만
			{
			F_UPLOAD_MULTI($tmp_name,$fileName,$fileSize,$fileType,$target_path,$attachFormat);			
			}	
	}
}
?>