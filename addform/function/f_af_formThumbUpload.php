<?
function f_af_formThumbUpload()
{
#########################################################################################
#############					썸네일이미지 업로드 			   ######################
#########################################################################################
if($_FILES['thumbnail'])
	{	
	if(!is_dir("../upload/".$_POST['name'].""))
		{
	mkdir("../upload/".$_POST['name']."", 0707);
	chmod("../upload/".$_POST['name']."", 0707);
		}

	
		$tmp_name = $_FILES['thumbnail']['tmp_name'];				//서버에 저장된 임시파일이름
		$fileName = $_FILES['thumbnail']['name'];					//원본 파일이름
		$fileSize = $_FILES['thumbnail']['size'];					//파일용량
		$fileType = $_FILES['thumbnail']['type'];					//파일확장자			
		$attachFormat = "jpg,jpeg,gif";								//허용확장자
		$uploadPath = "../upload/".$_POST['name']."/";				//업로드 경로
		$array = pathinfo($fileName);
		$name = "thumb";
		$target_path = $uploadPath . $name.".".$array['extension'];	//파일이 저장될 위치와 파일이름
		
		if($fileName)												//에러방지위해 파일이 있을 경우만
			{
			F_UPLOAD_MULTI($tmp_name,$fileName,$fileSize,$fileType,$target_path,$attachFormat);		
			}	
	}
#########################################################################################
#############					상단 배너 이미지 업로드 		   ######################
#########################################################################################
if($_FILES['top_img'])
	{	
	if(!is_dir("../upload/".$_POST['name'].""))
		{
	mkdir("../upload/".$_POST['name']."", 0707);
	chmod("../upload/".$_POST['name']."", 0707);
		}

	
		$tmp_name = $_FILES['top_img']['tmp_name'];					//서버에 저장된 임시파일이름
		$fileName = $_FILES['top_img']['name'];						//원본 파일이름
		$fileSize = $_FILES['top_img']['size'];						//파일용량
		$fileType = $_FILES['top_img']['type'];						//파일확장자			
		$attachFormat = "jpg,jpeg,gif";								//허용확장자
		$uploadPath = "../upload/".$_POST['name']."/";				//업로드 경로
		$array = pathinfo($fileName);
		$name = "top_img";
		$target_path = $uploadPath . $name.".".$array['extension'];	//파일이 저장될 위치와 파일이름
		
		if($fileName)												//에러방지위해 파일이 있을 경우만
			{
			F_UPLOAD_MULTI($tmp_name,$fileName,$fileSize,$fileType,$target_path,$attachFormat);		
			}	
	}
#########################################################################################
#############					하단 배너 이미지 업로드 		   ######################
#########################################################################################
if($_FILES['bottom_img'])
	{	
	if(!is_dir("../upload/".$_POST['name'].""))
		{
	mkdir("../upload/".$_POST['name']."", 0707);
	chmod("../upload/".$_POST['name']."", 0707);
		}

	
		$tmp_name = $_FILES['bottom_img']['tmp_name'];				//서버에 저장된 임시파일이름
		$fileName = $_FILES['bottom_img']['name'];					//원본 파일이름
		$fileSize = $_FILES['bottom_img']['size'];					//파일용량
		$fileType = $_FILES['bottom_img']['type'];					//파일확장자			
		$attachFormat = "jpg,jpeg,gif";								//허용확장자
		$uploadPath = "../upload/".$_POST['name']."/";				//업로드 경로
		$array = pathinfo($fileName);
		$name = "bottom_img";
		$target_path = $uploadPath . $name.".".$array['extension'];	//파일이 저장될 위치와 파일이름
		
		if($fileName)												//에러방지위해 파일이 있을 경우만
			{
			F_UPLOAD_MULTI($tmp_name,$fileName,$fileSize,$fileType,$target_path,$attachFormat);		
			}
	}
#########################################################################################
#############					로고 이미지 업로드 				   ######################
#########################################################################################
if($_FILES['logo_img'])
	{	
	if(!is_dir("../upload/logo"))
		{
	mkdir("../upload/logo", 0707);
	chmod("../upload/logo", 0707);
		}

	
		$tmp_name = $_FILES['logo_img']['tmp_name'];				//서버에 저장된 임시파일이름
		$fileName = $_FILES['logo_img']['name'];					//원본 파일이름
		$fileSize = $_FILES['logo_img']['size'];					//파일용량
		$fileType = $_FILES['logo_img']['type'];					//파일확장자			
		$attachFormat = "jpg,jpeg,gif";								//허용확장자
		$uploadPath = "../upload/logo/";				//업로드 경로
		$array = pathinfo($fileName);
		$name = "logo_img";
		$target_path = $uploadPath . $name.".".$array['extension'];	//파일이 저장될 위치와 파일이름
		
		if($fileName)												//에러방지위해 파일이 있을 경우만
			{
			F_UPLOAD_MULTI($tmp_name,$fileName,$fileSize,$fileType,$target_path,$attachFormat);		
			}
	}

#########################################################################################
#############					전송/접수 버튼이미지 업로드 	   ######################
#########################################################################################
if($_FILES['btn_submit'])
	{	
	if(!is_dir("../upload/".$_POST['name'].""))
		{
	mkdir("../upload/".$_POST['name']."", 0707);
	chmod("../upload/".$_POST['name']."", 0707);
		}

	
		$tmp_name = $_FILES['btn_submit']['tmp_name'];				//서버에 저장된 임시파일이름
		$fileName = $_FILES['btn_submit']['name'];					//원본 파일이름
		$fileSize = $_FILES['btn_submit']['size'];					//파일용량
		$fileType = $_FILES['btn_submit']['type'];					//파일확장자			
		$attachFormat = "jpg,jpeg,gif";								//허용확장자
		$uploadPath = "../upload/".$_POST['name']."/";				//업로드 경로
		$array = pathinfo($fileName);
		$name = "btn_submit";
		$target_path = $uploadPath . $name.".".$array['extension'];	//파일이 저장될 위치와 파일이름
		
		if($fileName)												//에러방지위해 파일이 있을 경우만
			{
			F_UPLOAD_MULTI($tmp_name,$fileName,$fileSize,$fileType,$target_path,$attachFormat);		
			}	
	}

#########################################################################################
#############					견적보기 버튼이미지 업로드 		   ######################
#########################################################################################
if($_FILES['btn_estimate'])
	{	
	if(!is_dir("../upload/".$_POST['name'].""))
		{
	mkdir("../upload/".$_POST['name']."", 0707);
	chmod("../upload/".$_POST['name']."", 0707);
		}

	
		$tmp_name = $_FILES['btn_estimate']['tmp_name'];			//서버에 저장된 임시파일이름
		$fileName = $_FILES['btn_estimate']['name'];				//원본 파일이름
		$fileSize = $_FILES['btn_estimate']['size'];				//파일용량
		$fileType = $_FILES['btn_estimate']['type'];				//파일확장자			
		$attachFormat = "jpg,jpeg,gif";								//허용확장자
		$uploadPath = "../upload/".$_POST['name']."/";				//업로드 경로
		$array = pathinfo($fileName);
		$name = "btn_estimate";
		$target_path = $uploadPath . $name.".".$array['extension'];	//파일이 저장될 위치와 파일이름
		
		if($fileName)												//에러방지위해 파일이 있을 경우만
			{
			F_UPLOAD_MULTI($tmp_name,$fileName,$fileSize,$fileType,$target_path,$attachFormat);		
			}	
	}

#########################################################################################
#############					다시쓰기 버튼이미지 업로드 		   ######################
#########################################################################################
if($_FILES['btn_retry'])
	{	
	if(!is_dir("../upload/".$_POST['name'].""))
		{
	mkdir("../upload/".$_POST['name']."", 0707);
	chmod("../upload/".$_POST['name']."", 0707);
		}

	
		$tmp_name = $_FILES['btn_retry']['tmp_name'];				//서버에 저장된 임시파일이름
		$fileName = $_FILES['btn_retry']['name'];					//원본 파일이름
		$fileSize = $_FILES['btn_retry']['size'];					//파일용량
		$fileType = $_FILES['btn_retry']['type'];					//파일확장자			
		$attachFormat = "jpg,jpeg,gif";								//허용확장자
		$uploadPath = "../upload/".$_POST['name']."/";				//업로드 경로
		$array = pathinfo($fileName);
		$name = "btn_retry";
		$target_path = $uploadPath . $name.".".$array['extension'];	//파일이 저장될 위치와 파일이름
		
		if($fileName)												//에러방지위해 파일이 있을 경우만
			{
			F_UPLOAD_MULTI($tmp_name,$fileName,$fileSize,$fileType,$target_path,$attachFormat);		
			}	
	}	

#########################################################################################
#############						사원사진  업로드 			   ######################
#########################################################################################
if($_FILES['member_pic'])
	{	
	if(!is_dir("../upload/member_pic"))
		{
	mkdir("../upload/member_pic", 0707);
	chmod("../upload/member_pic", 0707);
		}

	
		$tmp_name = $_FILES['member_pic']['tmp_name'];			//서버에 저장된 임시파일이름
		$fileName = $_FILES['member_pic']['name'];				//원본 파일이름
		$fileSize = $_FILES['member_pic']['size'];				//파일용량
		$fileType = $_FILES['member_pic']['type'];				//파일확장자			
		$attachFormat = "jpg,jpeg,gif";							//허용확장자
		$uploadPath = "../upload/member_pic/";					//업로드 경로
		$array = pathinfo($fileName);
		$name = $_POST["user_id"];
		$target_path = $uploadPath . $name.".".$array['extension'];	//파일이 저장될 위치와 파일이름
		
		if($fileName)												//에러방지위해 파일이 있을 경우만
			{
			F_UPLOAD_MULTI($tmp_name,$fileName,$fileSize,$fileType,$target_path,$attachFormat);		
			}	
	}	

}
?>