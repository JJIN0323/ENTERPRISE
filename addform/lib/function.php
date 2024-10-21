<?php
/* ----------------------------------------------------------------------------------- */
/*	프로그램명 : 애드폼(영문 addform												   */									
/*	프로그램용도: 견적서 주문서 폼메일 제작											   */
/*	제작자: 박성규																	   */
/*	공식배포처: http://www.addform.net												   */
/*  프로그램 편집시 위 제작자 정보를 편집하거나 삭제해서는 안됩니다.				   */
/* ----------------------------------------------------------------------------------- */

#---------------------------------------------------------------------------------------# 
#								인쇄버튼 출력함수										#
#---------------------------------------------------------------------------------------# 

function F_print(){
	echo ("<input type='button' value='Print' onClick='window.print()' style='height:30px;width:100px;'>");
}



#---------------------------------------------------------------------------------------# 
#								메일 보내기 함수										#
#---------------------------------------------------------------------------------------# 

function F_MIME($arr,$upload_result,$to) 
{       
	//메일 보낸이 이름과 제목 한글깨짐 방지
	$arr[name] = '=?UTF-8?B?'.base64_encode($arr[name]).'?='; 
	$arr[subject] = '=?UTF-8?B?'.base64_encode($arr[subject]).'?=';	
	if (strtoupper(substr(PHP_OS,0,3)=='WIN')) 
	{
		$rn="\r\n";
	} 
	elseif (strtoupper(substr(PHP_OS,0,3)=='MAC'))
	{
		$rn="\r";
	} 
	else 
	{
		$rn="\n";
	} 
	//공통 헤드 정의	
	$head .= "From: $arr[name]<$arr[from]>".$rn;			//보내는 사람 이름
	$head .= "X-Sender: $arr[from]".$rn;					//보내는 측의 이메일
	$head .= "X-Mailer: PHP".$rn;							//메일 프로그램
	$head .= "X-Priority: 1 (Highest)".$rn;					//메일의 중요도
	$head .= "Return-Path: $arr[from]".$rn;					//반송받을 메일 주소	
	
	$boundary = uniqid(rand()."part");

	//*****************	첨부파일이 있고, 이메일로 첨부일 때	***************************//
	if($upload_result == "email")							
	{
		//첨부파일이 있는지 검사
		$arr_files = "";
		$arr_type = "";
		$arr_name = "";
		$arr_files = array();
		$arr_type = array();
		$arr_name = array();
		$is_upload = "";

		for($i=0; $i < count($_FILES['client_file']['name']); $i++)
			{
			if(is_uploaded_file($_FILES['client_file']['tmp_name'][$i]) && !empty($_FILES['client_file']['size'][$i]) && !empty($_FILES['client_file']['name'][$i]))
				{
				 $is_upload = 1;			 
				 $fp	  =fopen($_FILES['client_file']['tmp_name'][$i], 'r'); 
				 $fp_data =fread($fp, $_FILES['client_file']['size'][$i]); 
				 $arr_files[]=chunk_split(base64_encode($fp_data));
				 fclose($fp);
				 $arr_type[] = $_FILES['client_file']['type'][$i];
				 $arr_name[] = $_FILES['client_file']['name'][$i];
				}
			}

		//첨부파일이 있을 경우 //////////////////////////////////////////////////////////////
		if($is_upload==1) 
		{
			$attach_files="";
			for($j=0;$j<count($arr_type); $j++)
			{
				//아래 $attach_files 를 통으로 정의하지말고 아래와 같이, 나누어 정의해야 정상첨부됨
				$attach_files.="--".$boundary."".$rn;
				$attach_files.="Content-Type:".$arr_type[$j].";name=\"".$arr_name[$j]."\"".$rn;
				$attach_files.="Content-Transfer-Encoding: base64".$rn;
				$attach_files.="Content-Disposition: attachment; filename=\"".$arr_name[$j]."\"".$rn.$rn;
				$attach_files.=$arr_files[$j].$rn.$rn;
			}
			$head .= "MIME-Version: 1.0".$rn;
			$head .= "Content-Type: Multipart/mixed; boundary = \"".$boundary."\"".$rn;
			$body = "This is a multi-part message in MIME format.".$rn.$rn;

			$body .= "--".$boundary."".$rn."";
			$body .= "Content-Type: text/html; charset=utf-8".$rn.$rn;	//$rn 2개로 해야 주석소스노출없음
			if ($to=="toClient") 
			{															//고객에게 메일발송일 경우			
			$body .= "감사합니다. 아래와 같이 접수되었습니다.<hr>".$rn;		
			}
			$body .= $arr[body].$rn.$rn;								//본 문 내 용		
			
			//$body .= "--".$boundary."".$rn; 중복되어 NamelessFile_ReNameByNaver의 원인이 됨
			$body .= $attach_files;

			$body .= "--".$boundary."--";		
		}
	}
	//*****************	첨부파일이 없거나, 서버에 저장일 때	***************************//
	else
	{	
			$head .= "Content-Type: text/html; charset=utf-8".$rn.$rn; 
			if ($to=="toAdmine" and $upload_result=="true")				//관리자에게..서버에 업로드 된 파일이 있다면	
			{			
			$body .= "<strong>파일이 첨부되었으니, 애드폼 관리자모드에서 확인하십시오.</strong><hr>".$rn;	
			}
			if ($to=="toClient") 
			{															//고객에게 메일발송일 경우			
			$body = "감사합니다. 아래와 같이 접수되었습니다.<hr>".$rn;		
			}
			$body .= $arr[body].$rn;									//본 문 내 용
			$head .= "\n\n";
	}
	
	mail($arr[to],$arr[subject],$body,$head);

}


#---------------------------------------------------------------------------------------# 
#							 폼이미지 멀티 업로드  함수									#
#---------------------------------------------------------------------------------------# 

function F_UPLOAD_MULTI($tmp_name,$fileName,$fileSize,$fileType,$target_path,$attachFormat)
{  																
	if($attachFormat)											//확장자검사 start	
	{
	$attachFormatArr = explode(",",$attachFormat);
	}
	else
	{
	$attachFormatArr = array("jpg","jpeg","gif","png");
	}

	$arr_originName = explode(".",$fileName); 
	if(count($arr_originName) != 2)
	{
	echo "<script type='text/javascript'>alert('".$fileName." 파일형식은 첨부 불가능합니다.');history.back();</script>"; 
	exit; 
	}

    $tmpN = 0;		
	foreach ($attachFormatArr as $val) 
		{         
		if ($val == strtolower($arr_originName[1])) 
			{ 
			$tmpN++; 
			}	
		}
			
	if ($tmpN == 0) 
	{ 
		echo "<script type='text/javascript'>alert('".$fileName." 파일형식은 첨부 불가능합니다.');history.back();</script>"; 
		exit; 
	}															//확장자검사 end

																//용량 체크 start	
	if($fileSize >= upload_max_filesize)
	{
		echo "<script type='text/javascript'>alert('첨부파일이 허용용량을 초과하였습니다.');history.back();</script>"; 
		exit;
	}

																 
        
    $fp = fopen($tmp_name, 'r');
    $content = fread($fp, $fileSize);
    $content = addslashes($content);
		  fclose($fp);

if (is_uploaded_file($tmp_name))								//업로드된 파일의 이름이 $tmp_name에 의한것이면 
	{    
	move_uploaded_file($tmp_name, $target_path);				//파일이 유효할 때, $target_path로 이동복사
	}
else{
  switch($_FILES['client_file']['error'])
	  {
    case 0: //no error; possible file attack!
      die ("정상적인 파일업로드가 아닙니다");
      break;
    case 1: //uploaded file exceeds the upload_max_filesize directive in php.ini
      die ("첨부파일이 허용용량을 초과하였습니다");
      break;
    case 2: //uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form
      die ("첨부파일이 허용용량을 초과하였습니다");
      break;
    case 3: //uploaded file was only partially uploaded
      die ("파일의 일부분만 업로드 되었습니다. 다시 시도하여 주세요.");
      break;
    case 4: //no file was uploaded
      die ("업로드 된 파일이 없습니다.");
      break;
    default: //a default error, just in case!  :)
      die ("파일업로드에 문제가 있습니다.");
      break;
		}
	}
}


#---------------------------------------------------------------------------------------# 
#							파일업로드  함수											#
#---------------------------------------------------------------------------------------# 

function F_UPLOAD($fileName,$target_path,$attachFormat)
{
	//$fileName = $_FILES['client_file']['name'];
    $tmpName  = $_FILES['client_file']['tmp_name'];
    $fileSize = $_FILES['client_file']['size'];
    $fileType = $_FILES['client_file']['type'];
															//확장자검사 start	
	
	if($attachFormat)
	{
	$attachFormatArr = explode(",",$attachFormat);
	}
	else
	{
	$attachFormatArr = array("jpg","jpeg","gif","png","psd","xls","doc","hwp","txt","zip","tar","ppt","dwg");
	}

	$arr_originName = explode(".",$_FILES['client_file']['name']); 
	if(count($arr_originName) != 2)
	{
	echo "<script type='text/javascript'>alert('".$_FILES['client_file']['name']." 파일형식은 첨부 불가능합니다.');history.back();</script>"; 
	exit; 
	}

    $tmpN = 0;		
	foreach ($attachFormatArr as $val) 
		{         
		if ($val == strtolower($arr_originName[1])) 
			{ 
			$tmpN++; 
			}	
		}
			
	if ($tmpN == 0) 
	{ 
		echo "<script type='text/javascript'>alert('".$_FILES['client_file']['name']." 파일형식은 첨부 불가능합니다.');history.back();</script>"; 
		exit; 
	}															//확장자검사 end

																//용량 체크 start	
	if($fileSize >= upload_max_filesize)
	{
		echo "<script type='text/javascript'>alert('첨부파일이 허용용량을 초과하였습니다.');history.back();</script>"; 
		exit;
	}

																 
        
    $fp = fopen($tmpName, 'r');
    $content = fread($fp, $fileSize);
    $content = addslashes($content);
		  fclose($fp);

if (is_uploaded_file($tmpName))									//업로드된 파일의 이름이 $tmpName에 의한것이면 
	{    
	move_uploaded_file($tmpName, $target_path);					//파일이 유효할 때, $target_path로 이동복사
	}
else{
  switch($_FILES['client_file']['error'])
	  {
    case 0: //no error; possible file attack!
      die ("정상적인 파일업로드가 아닙니다");
      break;
    case 1: //uploaded file exceeds the upload_max_filesize directive in php.ini
      die ("첨부파일이 허용용량을 초과하였습니다");
      break;
    case 2: //uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form
      die ("첨부파일이 허용용량을 초과하였습니다");
      break;
    case 3: //uploaded file was only partially uploaded
      die ("파일의 일부분만 업로드 되었습니다. 다시 시도하여 주세요.");
      break;
    case 4: //no file was uploaded
      die ("업로드 된 파일이 없습니다.");
      break;
    default: //a default error, just in case!  :)
      die ("파일업로드에 문제가 있습니다.");
      break;
		}
	}
}



#---------------------------------------------------------------------------------------# 
#						 리턴 레코드 행수 뽑아와서 개수 출력 함수						#
#---------------------------------------------------------------------------------------# 
function F_resCount($field,$table,$where){
	global $DBconn;
	$res=$DBconn->f_selectDB($field,$table,$where);  //필드, 테이블, 조건절	
	echo $res[cnt];									 //$result배열이 $res에 대입되었으므로...
}




#---------------------------------------------------------------------------------------# 
#								파일확장자 구하기 함수									#
#---------------------------------------------------------------------------------------# 

function getFormat($fileName)
{
    $arr = explode('.',$fileName);
    return $arr[sizeof($arr)-1];
}





#---------------------------------------------------------------------------------------# 
#								합계금액 한글화 함수									#
#---------------------------------------------------------------------------------------# 

function F_money_kr($insu)
{
	$arr_krUnit  = array(
		"천","백","십","무량대수",
		"천","백","십","불가사의",
		"천","백","십","나유타",
		"천","백","십","아승기",
		"천","백","십","항하사",	
		"천","백","십","극",
		"천","백","십","재",
		"천","백","십","정",
		"천","백","십","간",
		"천","백","십","구",
		"천","백","십","양",
		"천","백","십","자",
		"천","백","십","해",
		"천","백","십","경",
		"천","백","십","조",
		"천","백","십","억",
		"천","백","십","만",
		"천","백","십",""
	);

    $arr_kr = array(
		"일",
		"이",
		"삼",
		"사",
		"오",
		"육",
		"칠",
		"팔",
		"구"
	);

	$arr_krDecimal = array(
		"십",
		""
	);

    
   	$insu = explode(".",$insu);

	$i = 0;
    $n = count($arr_krUnit)-1;    
    $insuString = '';
	$insuString2 = '';
    $extractStr = '';
	$extractStr2 = '';

	//소수점 왼쪽 금액 문자화    
    for($i = strlen($insu[0]);$i>0;$i--)
    {
        $extractStr = substr($insu[0],$i-1,1);
        if($extractStr != '0' ||
          (($n+1)%4 == 0 &&
            (($i >= 2 && substr($insu[0],$i-2,1) !='0') ||
            ($i >= 3 && substr($insu[0],$i-3,1) !='0') ||
            ($i >= 4 && substr($insu[0],$i-4,1) !='0')			  
            )
          )
          )
            $insuString = $arr_krUnit[$n].$insuString;
        if($extractStr != '0')
            $insuString = $arr_kr[intval($extractStr)-1].$insuString;
        $n--;
    }
	

	//소수점 오른쪽 금액 문자화
	if ($insu[1])
	{
	if (strlen($insu[1]) > 0)
	{
		for($i = 0; $i < strlen($insu[1]); $i++)
		{
			$extractStr2 = substr($insu[1],$i,1);
				if($extractStr2 != '0')
				{
					$insuString2 = $insuString2.$arr_kr[intval($extractStr2)-1].$arr_krDecimal[$i];
				}       
		}

	}
	}

	
	if ($insu[1])
	{
		$kr_coin = $insuString."원".$insuString2."전";
	}
	else $kr_coin = $insuString."원";
	
	return $kr_coin;
	
}





#---------------------------------------------------------------------------------------# 
#								합계금액 한자화 함수									#
#---------------------------------------------------------------------------------------# 

function F_money_china($insu)
{
	$arr_krUnit  = array(
		"仟","百","拾","無量大數",
		"仟","百","拾","不可思議",
		"仟","百","拾","那由他",
		"仟","百","拾","阿僧祇",
		"仟","百","拾","恒河沙",		
		"仟","百","拾","極",
		"仟","百","拾","載",
		"仟","百","拾","正",
		"仟","百","拾","澗",
		"仟","百","拾","溝",
		"仟","百","拾","穰",
		"仟","百","拾","柘",
		"仟","百","拾","垓",
		"仟","百","拾","京",
		"仟","百","拾","兆",
		"仟","百","拾","亿",
		"仟","百","拾","万",
		"仟","百","拾",""
	);

    $arr_kr = array(
		"壹",
		"貳",
		"參",
		"肆",
		"伍",
		"陸",
		"柒",
		"捌",
		"玖"
	);
    

	$arr_krDecimal = array(
		"拾",
		""
	);

    
   	$insu = explode(".",$insu);

	$i = 0;
    $n = count($arr_krUnit)-1;    
    $insuString = '';
	$insuString2 = '';
    $extractStr = '';
	$extractStr2 = '';

	//소수점 왼쪽 금액 문자화    
    for($i = strlen($insu[0]);$i>0;$i--)
    {
        $extractStr = substr($insu[0],$i-1,1);
        if($extractStr != '0' ||
          (($n+1)%4 == 0 &&
            (($i >= 2 && substr($insu[0],$i-2,1) !='0') ||
            ($i >= 3 && substr($insu[0],$i-3,1) !='0') ||
            ($i >= 4 && substr($insu[0],$i-4,1) !='0')			  
            )
          )
          )
            $insuString = $arr_krUnit[$n].$insuString;
        if($extractStr != '0')
            $insuString = $arr_kr[intval($extractStr)-1].$insuString;
        $n--;
    }
	

	//소수점 오른쪽 금액 문자화
	if ($insu[1])
	{
	if (strlen($insu[1]) > 0)
	{
		for($i = 0; $i < strlen($insu[1]); $i++)
		{
			$extractStr2 = substr($insu[1],$i,1);
				if($extractStr2 != '0')
				{
					$insuString2 = $insuString2.$arr_kr[intval($extractStr2)-1].$arr_krDecimal[$i];
				}       
		}

	}
	}

	
	if ($insu[1])
	{
		$kr_coin = $insuString."원".$insuString2."전";
	}
	else $kr_coin = $insuString."원";
	
	return $kr_coin;
	
}

#---------------------------------------------------------------------------------------#
#							 한국 지역번호 변수 설정									#
#---------------------------------------------------------------------------------------#
$af_kr_areaCode = "
	<option value=''>지역번호
	<option value='02'>	 02 서울
	<option value='031'>031 경기
	<option value='032'>032 인천
	<option value='033'>033 강원
	<option value='041'>041 충남
	<option value='042'>042 대전
	<option value='043'>043 충북
	<option value='051'>051 부산
	<option value='052'>052 울산
	<option value='053'>053 대구
	<option value='054'>054 경북
	<option value='055'>055 경남
	<option value='061'>061 전남
	<option value='062'>062 광주
	<option value='063'>063 전북
	<option value='064'>064 제주
	<option value='060'>060
	<option value='070'>070
	<option value='080'>080
	<option value='0502'>0502
	<option value='1544'>1544
	<option value='1644'>1644
	<option value='1588'>1588
	<option value='1577'>1577
	 ";


#---------------------------------------------------------------------------------------#
#								한국 휴대폰 국번 설정									#
#---------------------------------------------------------------------------------------#
$af_kr_hpNum = "
	<option value=''>선 택
	<option value='010'>010
	<option value='011'>011
	<option value='016'>016
	<option value='017'>017
	<option value='018'>018
	<option value='019'>019		
	";




?>