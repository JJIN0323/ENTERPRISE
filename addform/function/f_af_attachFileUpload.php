<?
function f_af_attachFileUpload()
{
global $DBconn;
//addform_env 테이블로 부터 가져오기
$re2=$DBconn->f_selectDB("*",TABLE2,$where);									
$result2 = $re2[result];
$row2 =  mysql_fetch_array($result2);	
		$dummy2 = htmlspecialchars(stripslashes($row2["dummy2"]));		//첨부파일타겟(이메일0,서버1)
#########################################################################################
############################	파일업로드 함수 호출	#################################
#########################################################################################
$is_upload = "";
if($_FILES['client_file'])												//첨부파일 객체가 있을 때
	{
	for($i=0; $i < count($_FILES['client_file']['name']); $i++)
		{																//실제 유효폼에 의해 업로드 된 것이 있는지 검사
		if(is_uploaded_file($_FILES['client_file']['tmp_name'][$i]) && !empty($_FILES['client_file']['size'][$i]) && !empty($_FILES['client_file']['name'][$i]))
			{
			 $is_upload = 1;		 
			}	
		}

	if($is_upload==1)													//첨부파일이 있을 경우
		{
			if($dummy2 == "1")											//서버에 저장일 경우
			{
			$names = "";
			$count = count($_FILES['client_file']['tmp_name']);
			for($i = 0;$i < $count ;$i++)
				{
				$tmp_name = $_FILES['client_file']['tmp_name'][$i];		//서버에 저장된 임시파일이름
				$fileName = $_FILES['client_file']['name'][$i];			//원본 파일이름
				$fileSize = $_FILES['client_file']['size'][$i];			//파일용량
				$fileType = $_FILES['client_file']['type'][$i];			//파일확장자			
				$currentdir = getcwd();									//현재작업 디렉토리를 반환
				$uploadPath = $currentdir . "/upload/";					//업로드 경로
				$array = pathinfo($fileName);
				$name = "order_".time()."_".md5(uniqid(rand(), true)).".".$array['extension'];  //파일이름 암호화
				$target_path = $uploadPath . $name;						//파일이 저장될 위치와 파일이름
				
				if($fileName)											//에러방지위해 파일이 있을 경우만
					{
					F_UPLOAD_MULTI($tmp_name,$fileName,$fileSize,$fileType,$target_path,$_POST['attachFormat']);	
					$upload_result = "true";					
					$names .= $name.";";			
					}
				}
			}
			else														//서버에 저장이 아닐 경우
			{
				$upload_result = "email";				
			}
		}
	else																//첨부파일이 없을 경우
		{
				$upload_result = "false";				
		}
	}

	$arr = array();
	$arr["upload_result"] = $upload_result;
	$arr["fileName"] = substr($names,0,-1);
	return $arr;
}
?>