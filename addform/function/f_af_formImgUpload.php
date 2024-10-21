<?
function f_af_formImgUpload()
{
#########################################################################################
#############				상세이미지 업로드 함수 호출			   ######################
#########################################################################################
if($_FILES['detail_imgs'])
	{	
	if(!is_dir("../upload/".$_POST['name'].""))
		{
	mkdir("../upload/".$_POST['name']."", 0707);
	chmod("../upload/".$_POST['name']."", 0707);
		}

		$count = count($_FILES['detail_imgs']['tmp_name']);
		
	for($i = 0;$i < $count;$i++)
		{
		$tmp_name = $_FILES['detail_imgs']['tmp_name'][$i];			//서버에 저장된 임시파일이름
		$fileName = $_FILES['detail_imgs']['name'][$i];				//원본 파일이름
		$fileSize = $_FILES['detail_imgs']['size'][$i];				//파일용량
		$fileType = $_FILES['detail_imgs']['type'][$i];				//파일확장자			
		$attachFormat = "jpg,jpeg,gif";								//허용확장자
		$uploadPath = "../upload/".$_POST['name']."/";				//업로드 경로
		$array = pathinfo($fileName);
		$name = $i;
		$target_path = $uploadPath . $name.".".$array['extension'];	//파일이 저장될 위치와 파일이름

																	//이미지 설명 텍스트 파일 생성
																	//텍스트만 수정하는 경우도 잇으므로 아래 if 문안에 안 넣음
			$detail_memo  = $_POST['detail_memo'][$i];
			$connect_file = fopen("".$uploadPath . $name.".txt", "w") or die("파일 읽기에 실패하였습니다.");
			fwrite($connect_file, $detail_memo);
			fclose($connect_file);

			$floats  .= $_POST['float'][$i]."\n";					//float 속성
			
		
		if($fileName)												//에러방지위해 파일이 있을 경우만
			{				
			F_UPLOAD_MULTI($tmp_name,$fileName,$fileSize,$fileType,$target_path,$attachFormat);			
			}
		}															//for 문 끝
																	//float 속성 텍스트 파일생성
		$connect_file = fopen("".$uploadPath ."float.txt", "w") or die("파일 읽기에 실패하였습니다.");
		fwrite($connect_file, $floats);
		fclose($connect_file);
	
	}
	
}




?>