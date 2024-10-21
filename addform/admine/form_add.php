<?php
include_once("../lib/lib.php");
include_once("../lib/C_CONNECT.php");
include_once("../lib/define_table.php");
include_once("../lib/authentication.php");
include_once("../function/f_af_formThumbUpload.php");
include_once("../function/f_af_formImgUpload.php");
include_once("../function/f_get_af_detailTxt.php");
include_once("../function/f_af_formStyle.php");
include_once("../function/f_get_af_formStyle.php");

/* ----------------------------------------------------------------------------------- */
/*	프로그램명 : 애드폼(영문 addform												   */									
/*	프로그램용도: 견적서 주문서 폼메일 제작											   */
/*	제작자: 박성규																	   */
/*	공식배포처: http://www.addform.net												   */
/*  프로그램 편집시 위 제작자 정보를 편집하거나 삭제해서는 안됩니다.				   */
/* ----------------------------------------------------------------------------------- */

//첨부파일있을 때 업로드 함수 실행
$f_af_formThumbUpload = f_af_formThumbUpload();					   //썸네일 이미지
$f_af_formImgUpload = f_af_formImgUpload();						   //폼설명이미지들
$af_arr_format = array("jpg","jpeg","gif");						   //업로드 된 허용확장자
//폼스타일 설정(pro)
$f_af_formStyle = f_af_formStyle();								
#########################################################################################
#################################  모드가 추가일 때  ####################################
#########################################################################################
if($_POST['mode']=="add"){
	$clean=array();	
		$clean['form_type'] = $_POST['form_type'];                 //폼형식
		$clean['no_group'] = $_POST['no_group'];                   //그룹번호		
		$clean['name'] = $_POST['name'];						   //폼이름		
		$clean['title_text'] = $_POST['title_text'];			   //제 목
		$clean['msg_top'] = $_POST['msg_top'];					   //상단 메시지
		$clean['msg_bottom'] = $_POST['msg_bottom'];			   //하단 메시지
		$clean['top_img'] = $_POST['top_img'];					   //상단 배너 이미지
		$clean['bottom_img'] = $_POST['bottom_img'];			   //하단 배너 이미지
		$clean['width'] = $_POST['width'];						   //너	비
		$clean['coin_unit'] = $_POST['coin_unit'];				   //통화단위
		$clean['secret_price'] = $_POST['secret_price'];	       //견적비밀여부
		$clean['email_address'] = $_POST['email_address'];		   //관리자이메일
		$clean['tel'] = $_POST['supply_tel'];					   //사업장전화번호,팩스		
		$clean['supply_name'] = $_POST['supply_name'];			   //사업자상호
		$clean['supply_num'] = $_POST['supply_num'];			   //사업자등록번호
		$clean['supply_man'] = $_POST['supply_man'];			   //사업자대표
		$clean['supply_address'] = $_POST['supply_address'];	   //사업장 주소
		$clean['supply_conditions'] = $_POST['supply_conditions']; //사업의종류(업태)
		$clean['supply_item'] = $_POST['supply_item'];			   //종목
		$clean['sell_num'] = $_POST['sell_num'];				   //통신판매번호
		$clean['skin_name'] = $_POST['skin_name'];                 //스킨이름
		$clean['banking'] = $_POST['banking'];					   //계좌정보
		$clean['max_file_size'] = $_POST['max_file_size'];		   //html 폼 첨부파일용량
		$clean['attachFormat'] = $_POST['attachFormat'];		   //첨부파일 허용 확장자
		$clean['client_items'] = $_POST['client_items'];		   //고객모듈 항목들
		$clean['client_text_name'] = $_POST['client_text_name'];
		$clean['client_text_email'] = $_POST['client_text_email'];
		$clean['client_text_hp'] = $_POST['client_text_hp'];
		$clean['client_text_tel'] = $_POST['client_text_tel'];
		$clean['client_text_fax'] = $_POST['client_text_fax'];
		$clean['client_text_address'] = $_POST['client_text_address'];
		$clean['client_text_memo'] = $_POST['client_text_memo'];
		$clean['sign_img'] = $_POST['sign_img'];				   //견적서 도장 이미지
		$clean['font_family'] = $_POST['font_family'];	
		$clean['font_size'] = $_POST['font_size'];	
		$clean['font_color'] = $_POST['font_color'];
		$clean['layout'] =	$_POST['layout'];	
		$clean['return_url'] =	$_POST['return_url'];			   //전송 후 리턴 페이지
		$clean['return_type'] =	$_POST['return_type'];			   //전송 후 리턴 타입 auto,click

		$clean['yesorno_pay'] = $_POST['yesorno_pay'];			   //전자결제 사용여부(on,off)
		$clean['res_name'] = $_POST['res_name'];				   //예약상품 이름					
		$clean['res_mny'] = $_POST['res_mny'];					   //예약비용
		$clean['res_dummy1'] = $_POST['res_dummy1'];			   //PG 이름
		$clean['res_dummy2'] = $_POST['res_dummy2'];			   //ksnet에 사용될 상호
		$clean['res_dummy3'] = $_POST['res_dummy3'];			   //ksnet에 사용될 도메인
		$clean['site_cd'] = $_POST['site_cd'];					   //전자결제 사이트코드
		$clean['site_key'] = $_POST['site_key'];				   //전자결제 사이트키
		$clean['quotaopt'] = $_POST['quotaopt'];				   //할부개월수 0~12
		$clean['sms_msg'] = $_POST['sms_msg'];					   //예약시 관리자에게 통보될 sms 제목

		$clean['dummy1'] =	$_POST['dummy1'];					   //파일첨부기능 여부
		$clean['dummy2'] =	$_POST['dummy2'];					   //유효일
		$clean['dummy3'] =	$_POST['dummy3'];					   //주문/견적서항목 표시법
		$clean['dummy4'] =	$_POST['dummy4'];					   //견적서 합계표시방법
		$clean['dummy5'] =	$_POST['dummy5'];					   //SMS 
		$clean['dummy6'] =	$_POST['dummy6'];					   //부가세 반영여부(아니오0,예1)					
		$clean['dummy7'] =	$_POST['dummy7'];					   //첨부파일 갯수
		$clean['dummy8'] =	$_POST['dummy8'];					   //폼메일 계산기능여부(아니오0,예1)
		//$clean['dummy9'] =	$_POST['dummy9'];				   //폼구간카운터(버전5.3)
		//$clean['dummy10'] =	$_POST['dummy10'];				   //기본고객정보 타이틀(버전6)
		$clean['dummy11'] =	$_POST['dummy11'];					   //접수시 관리자에게 메일 발송(발송=1)
		$clean['dummy12'] =	$_POST['dummy12'];					   //접수시 고객에게 메일 발송(발송=1)
		$clean['dummy13'] =	$_POST['dummy13'];					   //폼메일 표시문구(|구분자로 배열)
		$clean['dummy14'] =	$_POST['dummy14'];					   //주문폼 표시문구(|구분자로 배열)

		if($_POST['dummy17'] == "1")
		{
		$clean['dummy15'] = mktime(0,0,1,$_POST['mS'],$_POST['dS'],$_POST['yS']);
		$clean['dummy16'] = mktime(23,59,59,$_POST['mE'],$_POST['dE'],$_POST['yE']);		
		}
		else
		{
		$clean['dummy15'] =$_POST['dummy15'];					   //폼유효기간 시작일
		$clean['dummy16'] =$_POST['dummy16'];					   //폼유효기간 만료일
		}
		$clean['dummy17'] =$_POST['dummy17'];					   //폼유효기간 사용여부(0,1)

		$clean['dummy18'] =$_POST['dummy18'];					   //프레임이동방법(0,1=전체)
		$clean['dummy19'] =$_POST['dummy19'];					   //sms 고객용 메시지(090403)



		$clean['input_date'] = time();							   //폼 생성시각
        ####################  폼이름 중복검사 start  ####################		
		$name = $clean['name'];									   //폼이름 중복검사를 위한 name 정의
		$where = "where name='$name'";							   //조건절
		$res=$DBconn->f_selectDB("*",TABLE5,$where);				   //필드, 테이블, 조건절
		if($res[cnt] > 0) die("<script>history.back();alert('이미 $name 이라는 폼이름이 존재합니다. The name already exists');</script>");
		####################  폼이름 중복검사 end   ####################

	
		//C_CONNECT 클래스 멤버함수인 f_InsertDB($table,$array)에서,  $array 인자로 사용될 스칼라배열을 만듬		
		//$array[]=array($code[$i],$name[$i]);					  //DB 입력할 필드수만큼 쉼표로 구분나열하여 array
		
		//DB 입력f_InsertDB(테이블이름,&$array)	
		$DBconn->f_InsertDB(TABLE5,&$clean);						  //&$clean배열을 참조연산자&로 넘겨주어 보다 빠르게 처리

		
		//폼 생성시 폼이름에 기초한 품목 테이블 생성
		$formname = "".db_tblname."_".$_POST['name']."_item";	  //생성될 품목 테이블 이름
		$auto_addform_item="
			CREATE TABLE IF NOT EXISTS $formname(
			no INT(11) NOT NULL AUTO_INCREMENT ,
			code INT(11) DEFAULT 0,
			name_it VARCHAR(255) DEFAULT NULL,
			price VARCHAR(255) DEFAULT NULL,
			opt TEXT,	
			unit VARCHAR(255) DEFAULT NULL,	
			chk_input INT(11) DEFAULT 0,
			chk_filter INT(11) DEFAULT 0,
			chk_etc INT(11) DEFAULT 0,	
			default_text TEXT,
			default_opt TEXT,
			discount TEXT,
			dummy1 TEXT,
			dummy2 TEXT,
			dummy3 TEXT,
			dummy4 TEXT,
			dummy5 TEXT,
			dummy6 TEXT,
			dummy7 TEXT,
			dummy8 TEXT,
			dummy9 TEXT,
			dummy10 TEXT,
			dummy11 TEXT,
			dummy12 TEXT,
			dummy13 TEXT,
			dummy14 TEXT,
			dummy15 TEXT,
			dummy16 TEXT,
			dummy17 TEXT,
			dummy18 TEXT,
			dummy19 TEXT,
			dummy20 TEXT,
				

			PRIMARY KEY (no),
			KEY code(code)	
			)$af_charset";
        //
			mysql_query($auto_addform_item) or die("테이블 생성시 오류가 있습니다");//품목 테이블 생성

		//문서 새로 고침
		 die("<meta http-equiv=refresh content='0;url=addform_list.php'>");
		
}



#########################################################################################
##################################  모드가 수정일 때  ###################################
#########################################################################################
if($_POST['mode']=="modify_ok"){
	if($_POST['thumbDel'] == "1")								   //썸네일이미지 삭제
	{
		for($i = 0;$i < count($af_arr_format);$i++)
		{
		@unlink("../upload/".$_POST['name']."/thumb.".$af_arr_format[$i]."");		
		}
	}
	if($_POST['top_imgDel'] == "1")								   //상단배너이미지 삭제
	{
		for($i = 0;$i < count($af_arr_format);$i++)
		{
		@unlink("../upload/".$_POST['name']."/top_img.".$af_arr_format[$i]."");		
		}
	}
	if($_POST['bottom_imgDel'] == "1")							   //하단배너이미지 삭제
	{
		for($i = 0;$i < count($af_arr_format);$i++)
		{
		@unlink("../upload/".$_POST['name']."/bottom_img.".$af_arr_format[$i]."");		
		}
	}
	
	if($_POST['detailDel'])										   //물품상세이미지 삭제
	{		
		for($x = 0;$x < count($_POST['detailDel']);$x++)
		{	
			if($_POST['detailDel'][$x] == "1")
			{
				for($i = 0;$i < count($af_arr_format);$i++)
				{
				@unlink("../upload/".$_POST['name']."/".$x.".".$af_arr_format[$i]."");	
				//@unlink("../upload/".$_POST['name']."/".$x.".txt");		
				}
			}
		}
	}
	if($_POST['btn_submitDel'] == "1")							   //전송/접수 버튼이미지 삭제
	{
		for($i = 0;$i < count($af_arr_format);$i++)
		{
		@unlink("../upload/".$_POST['name']."/btn_submit.".$af_arr_format[$i]."");		
		}
	}
	if($_POST['btn_estimateDel'] == "1")						   //견적보기 버튼이미지 삭제
	{
		for($i = 0;$i < count($af_arr_format);$i++)
		{
		@unlink("../upload/".$_POST['name']."/btn_estimate.".$af_arr_format[$i]."");		
		}
	}
	if($_POST['btn_retryDel'] == "1")							   //다시작성 버튼이미지 삭제
	{
		for($i = 0;$i < count($af_arr_format);$i++)
		{
		@unlink("../upload/".$_POST['name']."/btn_retry.".$af_arr_format[$i]."");		
		}
	}

	$where = "";
	$clean=array();
	
	
		$clean['no'] = $_POST['no'];                               //폼번호
		$clean['form_type'] = $_POST['form_type'];                 //폼형식
		$clean['no_group'] = $_POST['no_group'];                   //그룹번호		
		$clean['name'] = $_POST['name'];						   //제 목		
		$clean['title_text'] = $_POST['title_text'];			   //폼 타이틀
		$clean['msg_top'] = $_POST['msg_top'];					   //상단 메시지
		$clean['msg_bottom'] = $_POST['msg_bottom'];			   //하단 메시지
		$clean['top_img'] = $_POST['top_img'];					   //상단 배너 이미지
		$clean['bottom_img'] = $_POST['bottom_img'];			   //하단 배너 이미지
		$clean['width'] = $_POST['width'];						   //너	비
		$clean['coin_unit'] = $_POST['coin_unit'];				   //통화단위
		$clean['secret_price'] = $_POST['secret_price'];	       //견적비밀여부
		$clean['email_address'] = $_POST['email_address'];		   //관리자이메일
		$clean['tel'] = $_POST['supply_tel'];					   //사업장전화번호|팩스
		$clean['supply_name'] = $_POST['supply_name'];			   //사업자상호
		$clean['supply_num'] = $_POST['supply_num'];			   //사업자등록번호
		$clean['supply_man'] = $_POST['supply_man'];			   //사업자대표
		$clean['supply_address'] = $_POST['supply_address'];	   //사업장 주소
		$clean['supply_conditions'] = $_POST['supply_conditions']; //사업의종류(업태)
		$clean['supply_item'] = $_POST['supply_item'];			   //종목
		$clean['sell_num'] = $_POST['sell_num'];				   //통신판매번호
		$clean['skin_name'] = $_POST['skin_name'];                 //스킨이름
		$clean['banking'] = $_POST['banking'];					   //계좌정보
		$clean['max_file_size'] = $_POST['max_file_size'];		   //html 폼 첨부파일용량
		$clean['attachFormat'] = $_POST['attachFormat'];		   //첨부파일 허용 확장자
		$clean['client_items'] = $_POST['client_items'];		   //고객모듈 항목들
		$clean['client_text_name'] = $_POST['client_text_name'];
		$clean['client_text_email'] = $_POST['client_text_email'];
		$clean['client_text_hp'] = $_POST['client_text_hp'];
		$clean['client_text_tel'] = $_POST['client_text_tel'];
		$clean['client_text_fax'] = $_POST['client_text_fax'];
		$clean['client_text_address'] = $_POST['client_text_address'];
		$clean['client_text_memo'] = $_POST['client_text_memo'];
		$clean['sign_img'] = $_POST['sign_img'];				   //견적서 도장 이미지
		$clean['font_family'] = $_POST['font_family'];	
		$clean['font_size'] = $_POST['font_size'];	
		$clean['font_color'] = $_POST['font_color'];
		$clean['layout'] =	$_POST['layout'];
		$clean['return_url'] =	$_POST['return_url'];			   //전송 후 리턴 페이지
		$clean['return_type'] =	$_POST['return_type'];			   //전송 후 리턴 타입 auto,click

		$clean['yesorno_pay'] = $_POST['yesorno_pay'];			   //전자결제 사용여부(on,off)
		$clean['res_name'] = $_POST['res_name'];				   //예약상품 이름					
		$clean['res_mny'] = $_POST['res_mny'];					   //예약비용
		$clean['res_dummy1'] = $_POST['res_dummy1'];			   //PG 이름
		$clean['res_dummy2'] = $_POST['res_dummy2'];			   //ksnet에 사용될 상호
		$clean['res_dummy3'] = $_POST['res_dummy3'];			   //ksnet에 사용될 도메인
		$clean['site_cd'] = $_POST['site_cd'];					   //전자결제 사이트코드
		$clean['site_key'] = $_POST['site_key'];				   //전자결제 사이트키
		$clean['quotaopt'] = $_POST['quotaopt'];				   //할부개월수 0~12
		$clean['sms_msg'] = $_POST['sms_msg'];					   //예약시 관리자에게 통보될 sms 제목

		$clean['dummy1'] =	$_POST['dummy1'];					   //파일첨부기능 여부
		$clean['dummy2'] =	$_POST['dummy2'];					   //유효일
		$clean['dummy3'] =	$_POST['dummy3'];					   //주문/견적서항목 표시법
		$clean['dummy4'] =	$_POST['dummy4'];					   //견적서 합계표시방법
		$clean['dummy5'] =	$_POST['dummy5'];					   //SMS
		$clean['dummy6'] =	$_POST['dummy6'];					   //부가세 반영여부(아니오0,예1)	
		$clean['dummy7'] =	$_POST['dummy7'];					   //첨부파일 개수
		$clean['dummy8'] =	$_POST['dummy8'];					   //폼메일 계산기능여부(아니오0,예1)
		//$clean['dummy9'] =	$_POST['dummy9'];				   //폼구간카운터(버전5.3)
		//$clean['dummy10'] =	$_POST['dummy10'];				   //기본고객정보 타이틀(버전6)
		$clean['dummy11'] =	$_POST['dummy11'];					   //접수시 관리자에게 메일 발송(발송=1 버전6)
		$clean['dummy12'] =	$_POST['dummy12'];					   //접수시 고객에게 메일 발송(발송=1 버전6)
		$clean['dummy13'] =	$_POST['dummy13'];					   //폼메일 표시문구(|구분자로 배열)			
		$clean['dummy14'] =	$_POST['dummy14'];					   //주문폼 표시문구(|구분자로 배열)

		if($_POST['dummy17'] == "1")
		{
		$clean['dummy15'] = mktime(0,0,1,$_POST['mS'],$_POST['dS'],$_POST['yS']);
		$clean['dummy16'] = mktime(23,59,59,$_POST['mE'],$_POST['dE'],$_POST['yE']);		
		}
		else
		{
		$clean['dummy15'] =$_POST['dummy15'];					   //폼유효기간 시작일
		$clean['dummy16'] =$_POST['dummy16'];					   //폼유효기간 만료일
		}
		$clean['dummy17'] =$_POST['dummy17'];					   //폼유효기간 사용여부(0,1)

		$clean['dummy18'] =$_POST['dummy18'];					   //프레임이동방법(0,1=전체)
		$clean['dummy19'] =$_POST['dummy19'];					   //sms 고객용 메시지


		$clean['edit_date'] = time();							   //폼 수정시각	
		$where = "where no=".$clean['no'];						   //조건절
	
		//C_CONNECT 클래스 멤버함수인 f_updateDB($table,$arr,$where="")에서,  $array 인자로 사용될 스칼라배열을 만듬		
		 $DBconn->f_updateDB(TABLE5,&$clean,$where);			//&$clean배열을 참조연산자&로 넘겨주어 보다 빠르게 처리
		 //DB 입력 후 문서 고침
		 die("<meta http-equiv=refresh content='0;url=".URL."?no=".$_POST['no']."&amp;mode=modify'>");
		
}

?>
<!--##################################################################################-->
<!--###############################  그룹선택상자 start  #############################-->
<!--##################################################################################-->
<?php
//<option>태그 생성
function f_opt($val,$text,$default="",$head="") {
	        $buf="<option value='$val'";
	        if ($default&&$default==$text) {
	            $buf.="selected";
	        }
	        $buf.=">".$head;
	        return $buf;
	    }
//select 선택상자 구성
function f_SelectBox($arr) {
	if ($arr[name]) $arr[name]="name=$arr[name]";
    if ($arr[id]) $arr[id]="id=$arr[id]";
    if ($arr[style]) $arr[style]="style='$arr[style]'";	
    if ($arr[disable]) $arr[disable]="disable";
    
    $buf="<select 
	    $arr[name]
        $arr[id]
        $arr[style]
		$arr[script]
        $arr[disable]
        >
		\n";
    if ($arr["end"]>$arr[start]) {		//숫자 범위 지정시
        for ($i=$arr[start];$i<=$arr["end"];$i++) {
            $buf.=opt($i,$arr["default"],$arr[head]).$i.$arr[tail]."\n";
        }
    } elseif (count($arr[text])) {		
        for ($i=0;$i<count($arr[text]);$i++) {
            $buf.=f_opt($arr[no][$i],&$arr[text][$i],$arr["default"],$arr[head]).$arr[text][$i].$arr[tail]."\n";
        }
    }
    
    $buf.="</select>\n";
    return $buf;
}
?>

<?php
$m=$_GET['mode'];
///////DB에서 그룹정보 가져와서 연관배열 만들기 start///////
function f_mkOptArr(){
global $DBconn;
global $m;
global $no_group;												//폼의 부모그룹 번호 전역변수
if($m == "modify") {											//수정 모드일 때
	$where="where no='$no_group'";								//조건절
	$temp=$DBconn->f_selectDB("*","".db_tblname."_group_table",$where);//필드, 테이블, 조건절
	$gr_name=mysql_result($temp[result],0,"name");				//mysql_result()함수로 이름 필드를 꺼내봄
}

$res=$DBconn->f_selectDB("*","".db_tblname."_group_table","");	//필드, 테이블, 조건절
$res_count=mysql_num_rows($res[result]);						//리턴된 행의 개수

$no=array();													//배열변수 정의(그룹고유번호)
$na=array();													//배열변수 정의(그룹이름)
	for ($i=0;$i<$res_count;$i++) {								//불러온 레코드의 수만큼 루프        
        $row=mysql_fetch_array($res[result]);					//배열의 요소들을 $row에 대입	
		$na[$i]=htmlspecialchars(stripslashes($row[name]));		//스칼라배열 만듬  
		$no[$i]=htmlspecialchars(stripslashes($row[no]));		//스칼라배열 만듬    
    }	
	//$arr=array("name"=>"comboGroup","id"=>"selectGroup","text"=>&$a);//연관배열 정의 방법1
	$arr=array();						//연관배열 정의 방법2
		$arr[head]="";
		$arr[tail]="";
		$arr[start]="";
		$arr['end']="";
		
		$arr['default']=$gr_name;		//디폴트로 선택될 text
		$arr[name]="comboGroup";		//선택상자 이름
		$arr[id]="comboGroup";			//선택상자 객체 구분 아이디
		$arr[style]="";					//선택상자 스타일
		$arr[script]="onchange='no_group.value=options[options.selectedIndex].value'"; //실행할 스크립트			
		$arr[optVal]="";				//옵션 value
		$arr[no]=$no;					//그룹 고유번호 배열
		$arr[text]=$na;					//실렉트 메뉴 배열
		

echo f_SelectBox ($arr);//f_SelectBox 함수 실행
}
///////DB에서 그룹정보 가져와서 연관배열 만들기 end///////
?>
<!--#############################  그룹선택상자 end  #################################-->
<!--##################################################################################-->


<!--##################################################################################-->
<!--#############################  스킨이름 가져오기 start  ##########################-->
<!--##################################################################################-->
<?php
//스킨 이름 가져오기
function f_skin($directory){
 global $skin_name;						//스킨이름  $skin_name 외부변수
 global $sms_cp;						//스킨이름  $sms_cp 외부변수

 $dir=$directory;						//디렉토리 경로
 $handle=opendir($dir);
 while ($dirs = readdir($handle))
 {
  if(!eregi("\.",$dirs))				//파일이 아닌 디렉토리인 경우
  {										//폴더 이름과 같을 경우
   if($dirs==$skin_name or $dirs==$sms_cp )
	   $select="selected";				//선택되게...
   else $select="";
   echo"<option value='$dirs' $select>$dirs</option>"."\n";
  }
 }
 closedir($handle);
}
?>


<!--##################################################################################-->
<!--#############################  신용카드선택 start  ##########################-->
<!--##################################################################################-->
<?php
function f_PG($directory){
 global $res_dummy1;					//PG 이름 외부변수

 $dir=$directory;						//디렉토리 경로
 $handle=opendir($dir);
 while ($dirs = readdir($handle))
 {
  if(!eregi("\.",$dirs))				//파일이 아닌 디렉토리인 경우
  {										//폴더 이름과 같을 경우
   if($dirs==$res_dummy1)
	   $checked="checked";				//선택되게...
   else $checked="";
   echo"<input type='radio' name='res_dummy1' value='$dirs' $checked onclick='displayPG(\"$dirs\",\"p\");'><span style='font-weight:bold;'>$dirs</span>"."&nbsp;\n";
  }
 }
 closedir($handle);
}
?>


<?php
#########################################################################################
####################  selectBox Part1: 통화 단위 선택상자 start    ######################
#########################################################################################

//<option>태그 생성
function f_opt2($val,$text,$default="",$head="") {
	        $buf="<option value='$val'";
	        if ($default&&$default==$text) {
	            $buf.="selected";
	        }
	        $buf.=">".$head;
	        return $buf;
	    }
//select 선택상자 구성
function f_SelectBox2($arr) {
	if ($arr[name]) $arr[name]="name=$arr[name]";
    if ($arr[id]) $arr[id]="id=$arr[id]";
    if ($arr[style]) $arr[style]="style='$arr[style]'";	
    if ($arr[disable]) $arr[disable]="disable";
    
    $buf="<select 
	    $arr[name]
        $arr[id]
        $arr[style]
		$arr[script]
        $arr[disable]
        >
			
    \n";
    if ($arr["end"]>$arr[start]) {							 //숫자 범위 지정시
        for ($i=$arr[start];$i <= $arr["end"];$i++) {
            $buf.=opt($i,$arr["default"],$arr[head]).$i.$arr[tail]."\n";
        }
    } elseif (count($arr[text]) > 1) {						 //text 배열의요소가 2개이상일 경우
        for ($i=0;$i < count($arr[text]);$i++) {
            $buf.=f_opt2($arr[optVal][$i],&$arr[text][$i],$arr["default"],$arr[head]).$arr[text][$i].$arr[tail]."\n";
        }
    }
    
    $buf.="</select>\n";
    return $buf;
}
?>

<?php
#########################################################################################
####    selectBox Part2: DB에서 통화단위필드의 정보 가져와서 연관배열 만들기 start  #####
#########################################################################################

function f_mkOptArr2($field,$obj){							 //인수$field=db의 필드명, $obj는 도큐멘트 입력필드명
global $DBconn;
$no = $_GET['no'];											 //폼번호
global $m;													 //모드
if($m == "modify") {										 //수정 모드일 때
	$where="where no='$no'";								 //조건절
	$temp=$DBconn->f_selectDB("*",TABLE5,$where);			 //필드, 테이블, 조건절
	$coin_u=mysql_result($temp[result],0,"coin_unit");		 //mysql_result()함수로 통화단위 필드를 꺼내봄
}

$res=$DBconn->f_selectDB("*","".db_tblname."_env","");		 //필드, 테이블, 조건절

$res_count=mysql_num_rows($res[result]);                     //리턴된 행의 개수
	
        $row=mysql_fetch_array($res[result]);                //배열의 요소들을 $row에 대입	
		$od_unit=htmlspecialchars(stripslashes($row[od_unit]));  
		$coin_unit=htmlspecialchars(stripslashes($row[coin_unit]));
		
		$od_unit = explode(",",$od_unit);					 //od_unit 필드의 콤마로 구분한 단위값들을 스칼라배열화
		$coin_unit = explode(",",$coin_unit);				 //coin_unit 필드의 콤마로 구분한 단위값들을 스칼라배열화

		if($field == "od_unit") $Val = $od_unit; 
		if($field == "coin_unit") $Val = $coin_unit;

		/* 테이블 행이 복수일 경우엔 아래와 같이 for문으로 연관배열처리(그룹실렉트의 경우예)
		$no=array();                                                 //배열변수 정의(그룹고유번호)
		$na=array();                                                 //배열변수 정의(그룹이름)
		for ($i=0;$i < $res_count;$i++) {							 //불러온 레코드의 수만큼 루프        
			$row=mysql_fetch_array($res[result]);                    //배열의 요소들을 $row에 대입	
			$na[$i]=htmlspecialchars(stripslashes($row[name]));                    //연관배열 만듬  
			$no[$i]=htmlspecialchars(stripslashes($row[no]));                      //연관배열 만듬    
		}	
		*/


 	
	//$arr=array("name"=>"comboGroup","id"=>"selectGroup","text"=>&$a);//연관배열 정의 방법1
	$arr=array();                                           //연관배열 정의 방법2
		$arr[head]="";
		$arr[tail]="";
		$arr[start]="";
		$arr['end']="";
		$arr['default']=$coin_u;                             //디폴트로 선택될 text
		$arr[name]="comboGroup2";                            //선택상자 이름
		$arr[id]="comboGroup2";                                         //선택상자 객체 구분 아이디
		$arr[style]="";                                      //선택상자 스타일
		$arr[script]="onchange='this.form.$obj.value=this.options[this.selectedIndex].value;'"; //실행할 스크립트			
		$arr[optVal]=$Val;								    //옵션 value 배열
		$arr[text]=$Val;                                    //실렉트 text 항목 배열
		

echo f_SelectBox2 ($arr);									//f_SelectBox 함수 실행
}
?>

<!--##################################################################################-->
<!--########################### 추가/수정일 때, 정보가져오기 start  ##################-->
<!--##################################################################################-->
<?php
////////////////////////////////추가모드 일 때///////////////////////////////////////////
if(!$_GET['mode']){															//추가모드일 때는, 관리자 정보 테이블에서 사업자정보만 가져옴
$re=$DBconn->f_selectDB("*","".db_tblname."_admine_table",$where);
$result = $re[result];
$row =  mysql_fetch_array($result);		
		$email_address = htmlspecialchars(stripslashes($row["email_address"]));			//관리자 이메일
		$sup_tel = htmlspecialchars(stripslashes($row["tel"]));							//전화번호(공급자)
		$sup_fax = htmlspecialchars(stripslashes($row["fax"]));							//팩스(공급자)
		$supply_name = htmlspecialchars(stripslashes($row["supply_name"]));				//사업자상호(공급자)
		$supply_num =htmlspecialchars(stripslashes( $row["supply_num"]));				//사업자등록번호(공급자)
		$supply_man = htmlspecialchars(stripslashes($row["supply_man"]));				//사업자대표(공급자)
		$supply_address = htmlspecialchars(stripslashes($row["supply_address"]));		//사업장주소(공급자)
		$supply_conditions = htmlspecialchars(stripslashes($row["supply_conditions"]));	//업태(공급자)
		$supply_item = htmlspecialchars(stripslashes($row["supply_item"]));				//종목(공급자)
		$sell_num = htmlspecialchars(stripslashes($row["sell_num"]));					//통신판매번호
		$banking = htmlspecialchars(stripslashes($row["banking"]));						//은행계좌정보	

		$bankingArr = explode("|",$banking);				//banking 필드의 구분자로 부터 배열화
			$bank_name = $bankingArr[0];					//첫번째 배열요소를 은행이름으로...
			$bank_num = $bankingArr[1];						//두번째 배열요소를 계좌번호로...
			$bank_who = $bankingArr[2];						//세번째 배열요소를 예금주로..		
								
}

////////////////////////////////수정모드 일 때///////////////////////////////////////////
if($_GET['mode']=="modify"){
$no = $_GET['no'];															//앞페이지에서 받아온 폼번호
$where="where no=$no";
$re=$DBconn->f_selectDB("*",TABLE5,$where);									//수정 모드일 때는 해당 테이블에서 정보가져옴
$result = $re[result];
$row =  mysql_fetch_array($result);

		$no = htmlspecialchars(stripslashes($row["no"]));								//고유번호
		$no_group = htmlspecialchars(stripslashes($row["no_group"]));					//속할 그룹번호
		$form_type = htmlspecialchars(stripslashes($row["form_type"]));					//폼형식
		$input_date = htmlspecialchars(stripslashes($row["input_date"]));				//생성시각
		$edit_date = htmlspecialchars(stripslashes($row["edit_date"]));					//수정시각
		$name = htmlspecialchars(stripslashes($row["name"]));							//주문폼		
		$title_text = htmlspecialchars(stripslashes($row["title_text"]));				//제 목
		$msg_top = htmlspecialchars(stripslashes($row['msg_top']));						//상단 메시지
		$msg_bottom = htmlspecialchars(stripslashes($row['msg_bottom']));				//하단 메시지
		$top_img = htmlspecialchars(stripslashes($row['top_img']));					    //상단 배너 이미지
		$bottom_img = htmlspecialchars(stripslashes($row['bottom_img']));				//하단 배너 이미지
		$width = htmlspecialchars(stripslashes($row['width']));						    //너	비
		$coin_unit = htmlspecialchars(stripslashes($row["coin_unit"]));					//통화단위
		$secret_price = htmlspecialchars(stripslashes($row["secret_price"]));			//산출금액 비밀 여부		
		$email_address = htmlspecialchars(stripslashes($row["email_address"]));			//관리자 이메일
		$supply_tel = htmlspecialchars(stripslashes($row["tel"]));						//전화번호,팩스(공급자)
		$supply_name = htmlspecialchars(stripslashes($row["supply_name"]));				//사업자상호(공급자)
		$supply_num =htmlspecialchars(stripslashes( $row["supply_num"]));				//사업자등록번호(공급자)
		$supply_man = htmlspecialchars(stripslashes($row["supply_man"]));				//사업자대표(공급자)
		$supply_address = htmlspecialchars(stripslashes($row["supply_address"]));		//사업장주소(공급자)
		$supply_conditions = htmlspecialchars(stripslashes($row["supply_conditions"]));	//업태(공급자)
		$supply_item = htmlspecialchars(stripslashes($row["supply_item"]));				//종목(공급자)
		$sell_num = htmlspecialchars(stripslashes($row["sell_num"]));					//통신판매번호
		$skin_name = htmlspecialchars(stripslashes($row["skin_name"]));					//스킨이름		
		$use_report_email = htmlspecialchars(stripslashes($row["use_report_email"]));	//관리자에게 이메일 전송여부
		$count_field = htmlspecialchars(stripslashes($row["count_field"]));				//접속통계
		$banking = htmlspecialchars(stripslashes($row["banking"]));						//종목(공급자)
		$max_file_size = htmlspecialchars(stripslashes($row["max_file_size"]));			//html 폼 첨부파일용량
		$attachFormat = htmlspecialchars(stripslashes($row["attachFormat"]));			//첨부파일 허용 확장자
		$client_items = htmlspecialchars(stripslashes($row["client_items"]));			//고객모듈 항목들
		$client_text_name = htmlspecialchars(stripslashes($row["client_text_name"]));
		$client_text_email = htmlspecialchars(stripslashes($row["client_text_email"]));
		$client_text_hp = htmlspecialchars(stripslashes($row["client_text_hp"]));
		$client_text_tel = htmlspecialchars(stripslashes($row["client_text_tel"]));
		$client_text_fax = htmlspecialchars(stripslashes($row["client_text_fax"]));
		$client_text_address = htmlspecialchars(stripslashes($row["client_text_address"]));
		$client_text_memo = htmlspecialchars(stripslashes($row["client_text_memo"]));	
		$sign_img = htmlspecialchars(stripslashes($row["sign_img"]));					//견적서 도장 이미지
		$font_family = htmlspecialchars(stripslashes($row["font_family"]));	
		$font_size = htmlspecialchars(stripslashes($row["font_size"]));	
		$font_color = htmlspecialchars(stripslashes($row["font_color"]));
		$layout =	htmlspecialchars(stripslashes($row["layout"]));
		$return_url =	htmlspecialchars(stripslashes($row["return_url"]));				//전송 후 리턴페이지
		$return_type =	htmlspecialchars(stripslashes($row["return_type"]));			//전송 후 리턴방법 auto,click

		$yesorno_pay =	htmlspecialchars(stripslashes($row["yesorno_pay"]));			//신용카드 결제여부
		$res_name =	htmlspecialchars(stripslashes($row["res_name"]));					//예약상품이름
		$res_mny =	htmlspecialchars(stripslashes($row["res_mny"]));					//예약비용
		$res_dummy1 = htmlspecialchars(stripslashes($row["res_dummy1"]));				//PG 이름				
		$res_dummy2 = htmlspecialchars(stripslashes($row["res_dummy2"]));				//ksnet에 사용될 상호			
		$res_dummy3 = htmlspecialchars(stripslashes($row["res_dummy3"]));				//ksnet에 사용될 도메인
		$site_cd =	htmlspecialchars(stripslashes($row["site_cd"]));					//전자결제 사이트코드
		$site_key =	htmlspecialchars(stripslashes($row["site_key"]));					//전자결제사이트키
		$quotaopt =	htmlspecialchars(stripslashes($row["quotaopt"]));					//할부개월수 0~12
		$sms_msg =	htmlspecialchars(stripslashes($row["sms_msg"]));					//예약시 관리자에게 통보될 sms 제목

		$dummy1 =	htmlspecialchars(stripslashes($row["dummy1"]));					    //파일첨부기능 여부
		$dummy2 =	htmlspecialchars(stripslashes($row["dummy2"]));					    //유효일
		$dummy3 =	htmlspecialchars(stripslashes($row["dummy3"]));					    //주문/견적서항목 표시법
		$dummy4 =	htmlspecialchars(stripslashes($row["dummy4"]));						//견적서 합계표시방법
		$dummy5 =	htmlspecialchars(stripslashes($row["dummy5"]));						//SMS
		$dummy6 =	htmlspecialchars(stripslashes($row["dummy6"]));						//부가세 반영여부(아니오0,예1)	
		$dummy7 =	htmlspecialchars(stripslashes($row["dummy7"]));						//첨부파일갯수
		$dummy8 =	htmlspecialchars(stripslashes($row["dummy8"]));						//폼메일 계산기능여부(아니오0,예1)
		$dummy9 =	htmlspecialchars(stripslashes($row["dummy9"]));
		$dummy10 =	htmlspecialchars(stripslashes($row["dummy10"]));
		$dummy11 =	htmlspecialchars(stripslashes($row["dummy11"]));
		$dummy12 =	htmlspecialchars(stripslashes($row["dummy12"]));
		$dummy13 =	htmlspecialchars(stripslashes($row["dummy13"]));
		$dummy14 =	htmlspecialchars(stripslashes($row["dummy14"]));

		$dummy15 =	htmlspecialchars(stripslashes($row["dummy15"]));					//폼유효기간 시작 스탬프
		$dummy16 =	htmlspecialchars(stripslashes($row["dummy16"]));					//폼유효기간 종료 스탬프
		$dummy17 =	htmlspecialchars(stripslashes($row["dummy17"]));					//폼유효기간 사용여부(0,1)
		$dummy18 =	htmlspecialchars(stripslashes($row["dummy18"]));					//프레임이동방법(0,1=전체)
		$dummy19 =	htmlspecialchars(stripslashes($row["dummy19"]));					//sms 고객용 메시지

		if($dummy15 and $dummy16)
		{
		$yS = date("Y",$dummy15);
		$mS = date("m",$dummy15);
		$dS = date("d",$dummy15);
		$yE = date("Y",$dummy16);
		$mE = date("m",$dummy16);
		$dE = date("d",$dummy16);
		}

		$bankingArr = explode("|",$banking);				//banking 필드의 구분자로 부터 배열화
			$bank_name = $bankingArr[0];					//첫번째 배열요소를 은행이름으로...
			$bank_num = $bankingArr[1];						//두번째 배열요소를 계좌번호로...
			$bank_who = $bankingArr[2];						//세번째 배열요소를 예금주로...

		$sectionArr = explode("|",$dummy3);					//dummy3 필드의 구분자로 부터 배열화
			$section1 = $sectionArr[0];						//첫번째 배열요소를 견적서항목 첫항목으로...
			$section2 = $sectionArr[1];						
			$section3 = $sectionArr[2];						
			$section4 = $sectionArr[3];						
			$section5 = $sectionArr[4];						
			$section6 = $sectionArr[5];						
			$section7 = $sectionArr[6];						
			$section8 = $sectionArr[7];	

		$smsArr = explode("|",$dummy5);	
			$sms_yesorno = $smsArr[0];
			$sms_cp = $smsArr[1];						
			$sms_id = $smsArr[2];						
			$sms_pw = $smsArr[3];						
			$sms_toDB = $smsArr[4];
			
		$telArr = explode("|",$supply_tel);						
			$sup_tel = $telArr[0];							//첫번째 배열요소를 전화번호로...
			$sup_fax = $telArr[1];							//두번째 배열요소를 팩시번호로...

		$client_itemsArr = explode("|",$client_items);		//client_items 필드의 구분자로 부터 배열화
		$arr_dummy13 = explode("|",$dummy13);				//폼메일 표시문구 배열
		$arr_dummy14 = explode("|",$dummy14);				//주문폼 표시문구 배열
	
}
?>

<!--##################################################################################-->
<!--################################  HTML start  ####################################-->
<!--##################################################################################-->
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>

<HEAD>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<meta name='robots' content='none,noindex,nofollow'>
<TITLE>애드폼 추가 add form</TITLE>
<META NAME="author" CONTENT="애드폼">
<LINK REL="stylesheet" HREF="global.css" TYPE="text/css">

<style type="text/css">
/* 폼 라벨 스타일 설정 */
#form1 .label {
	float: left;
	clear: left;
	width: 150px;
	margin-right: 10px;
	padding-right:5px;
	text-align: right;
	color:#616588;	
	border-width: 1px;
	border-bottom-style: dotted;
	border-color: #999999;
}
/*.estimate_onlyform {display:none;}*/
</style>

<?php
	if($sms_yesorno == "0" or $sms_yesorno=="")
	{		
	echo ("	
		<style type='text/css'>
		.sms {display:none;}
		</style>
		");
	}
	if($yesorno_pay=="off" or $yesorno_pay=="")
	{		
	echo ("	
		<style type='text/css'>
		.pay {display:none;}
		</style>
		");
	}
	if($res_dummy1=="")
	{		
	echo ("	
		<style type='text/css'>		
		.kcp {display:none;}
		.ksnet {display:none;}
		</style>
		");
	}	
	if($res_dummy1=="kcp")
	{		
	echo ("	
		<style type='text/css'>		
		.kcp {display:inline;}
		.ksnet {display:none;}
		</style>
		");
	}
	if($res_dummy1=="ksnet")
	{		
	echo ("	
		<style type='text/css'>		
		.kcp {display:none;}
		.ksnet {display:inline;}
		</style>
		");
	}	

?>

<script type="text/javascript" src='js/check_input.js'></script>
<script type="text/javascript" src='js/chk_null.js'></script>
<script type="text/javascript" src='js/only_en.js'></script>
<script type="text/javascript" src='js/display_sms.js'></script>
<script type="text/javascript" src='../js/display_css.js'></script>
<script type="text/javascript" src='../js/pop_img.js'></script>
<script type="text/javascript" src='js/conf_style.js'></script>


<script type="text/javascript">	
<!--
function Mix(f)
{
	if(f.yesorno_pay[0].checked == true)					//신용카드결제사용일 때
	{
		f.dummy1[1].checked = true;					//파일첨부기능 사용못하게	
	}

	var val_name = f.bank_name.value;
	var val_num = f.bank_num.value;
	var val_who = f.bank_who.value;	

	var val_tel = f.tel.value;	
	var val_fax = f.fax.value;	
	
		var mix_data ="" 
			+val_name+"|"
			+val_num+"|"
			+val_who;

		var mix_tel ="" 
			+val_tel+"|"
			+val_fax;
														
document.form1.banking.value = mix_data;					//은행계좌정보 필드값 합치기
document.form1.supply_tel.value = mix_tel;					//사업자 전화,팩스번호 합치기	
	
	var mix_client_item = "";
	for(i= 0 ; i < f.client_item.length; i++)
	{
		if(f.client_item[i].checked==true)
		{
			 mix_client_item = mix_client_item+"1|";
		}
		else  mix_client_item = mix_client_item+"0|";
	}
	 mix_client_itemLen = mix_client_item.length;
	 mix_client_item = mix_client_item.substr(0,mix_client_itemLen-1);
	f.client_items.value = mix_client_item;					//고객정보 입력항목 합치기

	var mix_formmail_txts = "";
	for(i= 0 ; i < f.formmail_txts.length; i++)
	{
		mix_formmail_txts += f.formmail_txts[i].value+"|";		
	}
	 mix_formmail_txtsLen = mix_formmail_txts.length;
	 mix_formmail_txts = mix_formmail_txts.substr(0,mix_formmail_txtsLen-1);
	f.dummy13.value = mix_formmail_txts;					//폼메일 표시문구 합치기
	
	var mix_orderform_txts = "";
	for(i= 0 ; i < f.orderform_txts.length; i++)
	{
		mix_orderform_txts += f.orderform_txts[i].value+"|";		
	}
	 mix_orderform_txtsLen = mix_orderform_txts.length;
	 mix_orderform_txts = mix_orderform_txts.substr(0,mix_orderform_txtsLen-1);
	f.dummy14.value = mix_orderform_txts;					//주문폼 표시문구 합치기	
}

function Mix_sms(f)
{										
	
	var sms_yesorno = "";
	if(f.sms_yesorno[0].checked==true)
	{
		sms_yesorno = "1";
	}
	else sms_yesorno = "0";

	var sms_cp = f.sms_cp.value;
	var sms_id = f.sms_id.value;
	var sms_pw = f.sms_pw.value;
	var sms_to = f.sms_to.value;
	
		var mix_data ="" 
			+sms_yesorno+"|"
			+sms_cp+"|"
			+sms_id+"|"
			+sms_pw+"|"
			+sms_to;
														
document.form1.dummy5.value = mix_data;						//sms 필드값 합치기	
}

function wrapper_width(f,that)
{
	if(that.checked == true)
	{
		f.width.value = that.value;
	}
}


function Section(f)
{
	var section1 = f.section1.value;
	var section2 = f.section2.value;
	var section3 = f.section3.value;
	var section4 = f.section4.value;
	var section5 = f.section5.value;
	var section6 = f.section6.value;
	var section7 = f.section7.value;
	var section8 = f.section8.value;
	
		var mix_data ="" 
			+section1+"|"
			+section2+"|"
			+section3+"|"
			+section4+"|"
			+section5+"|"
			+section6+"|"
			+section7+"|"
			+section8;
														
document.form1.dummy3.value = mix_data;
}


function attachFiles(x)
{
	if(x.value < 1)
	{
		alert("<?php echo af_txt_form_add_68;?>");
		x.value = "1";
	}
}

function eq_detailDel(th,x)
{
	if(th.checked == true)
	{
		document.getElementById('detailDel'+x+'').value = "1";
	}
	else document.getElementById('detailDel'+x+'').value = "0";
}

//년월일 선택상자
<?php 
	if($dummy17 == "1") $style_select = "style=\"background-color:#ffff99\"";
?>
function f_daySelect1(y, m, token) 
{ 
	var txt = "";
	var onchangeY = 'onchange="f_daySelect1(this.options[this.selectedIndex].value, document.form1.mS.options[mS.selectedIndex].value,1)"';	
	var onchangeM = 'onchange="f_daySelect1(document.form1.yS.options[yS.selectedIndex].value, this.options[this.selectedIndex].value,1)"';
	var selected_y = '';
	var selected_m = '';
	var get_yS = "<?php echo $yS;?>";
	var get_mS = "<?php echo $mS;?>";
	var get_dS = "<?php echo $dS;?>";
	var d = "<?php echo date("d");?>";
	
	if(token != 1)
	{
		if(get_yS) y = get_yS;
		if(get_mS) m = get_mS;
		if(get_dS) d = get_dS;
	}
	
		
		
		//년    
		txt += '<select name="yS" '+onchangeY+' <?php echo $style_select;?>>';
		for (i = 2000; i < 2100; i++) 
		{        
			if (i == y) selected_y = "selected";
				else    selected_y = "";      
		   txt += '<option value="' + i + '" '+selected_y+'>' + i + ''; 
		}
		txt += '<\/select><?php echo af_txt_y;?>';

		//월    
		txt += '<select name="mS" '+onchangeM+' <?php echo $style_select;?>>';
		for (i = 1; i < 13; i++) 
		{        
			if (i == m) selected_m = "selected";
				else    selected_m = "";      
		   txt += '<option value="' + i + '" '+selected_m+'>' + i + ''; 
		}
		txt += '<\/select><?php echo af_txt_m;?>';

		//일
		var dShift1 = (y+(y-y%4)/4-(y-y%100)/100+(y-y%400)/400 
			  +m*2+(m*5-m*5%9)/9-(m<3?y%4||y%100==0&&y%400?2:3:4))%7; 
		txt += '<select name="dS" <?php echo $style_select;?>>';
		for (i = 0; i < 42; i++) 
		{   
			if ((i+1-dShift1) == d) var selected_d = "selected";
							else    var selected_d = ""; 
			if (i < dShift1 || i >= dShift1+(m*9-m*9%8)/8%2+(m==2?y%4||y%100==0&&y%400?28:29:30)) 
				txt += ''; 
			else 
				txt += '<option value="' + (i+1-dShift1) + '" '+selected_d+'>' + (i+1-dShift1) + ''; 
		} 

		txt += '<\/select><?php echo af_txt_d;?> ~ ';
		
    document.getElementById('patchCalendar1').innerHTML = txt + '<\/tr>\n<\/table>'; 
} 

function f_daySelect2(y, m, token) 
{
	var txt = "";	
	var onchangeY = 'onchange="f_daySelect2(this.options[this.selectedIndex].value, document.form1.mE.options[mE.selectedIndex].value,1)"';
	var onchangeM = 'onchange="f_daySelect2(document.form1.yE.options[yE.selectedIndex].value, this.options[this.selectedIndex].value,1)"';
	var selected_y = '';
	var selected_m = '';
	var get_yE = "<?php echo $yE;?>";
	var get_mE = "<?php echo $mE;?>";
	var get_dE = "<?php echo $dE;?>";
	var d = "<?php echo date("d");?>";
	
	if(token != 1)
	{
		if(get_yE) y = get_yE;
		if(get_mE) m = get_mE;
		if(get_dE) d = get_dE;
	}
		
		
		//년    
		txt += '<select name="yE" '+onchangeY+' <?php echo $style_select;?>';
		for (i = 2000; i < 2100; i++) 
		{        
			if (i == y) selected_y = "selected";
				else    selected_y = "";      
		   txt += '<option value="' + i + '" '+selected_y+'>' + i + ''; 
		}
		txt += '<\/select><?php echo af_txt_y;?>';

		//월    
		txt += '<select name="mE" '+onchangeM+' <?php echo $style_select;?>>';
		for (i = 1; i < 13; i++) 
		{        
			if (i == m) selected_m = "selected";
				else    selected_m = "";      
		   txt += '<option value="' + i + '" '+selected_m+'>' + i + ''; 
		}
		txt += '<\/select><?php echo af_txt_m;?>';

		//일
		var dShift1 = (y+(y-y%4)/4-(y-y%100)/100+(y-y%400)/400 
			  +m*2+(m*5-m*5%9)/9-(m<3?y%4||y%100==0&&y%400?2:3:4))%7; 
		txt += '<select name="dE" <?php echo $style_select;?>>';
		for (i = 0; i < 42; i++) 
		{   
			if ((i+1-dShift1) == d) var selected_d = "selected";
							else    var selected_d = ""; 
			if (i < dShift1 || i >= dShift1+(m*9-m*9%8)/8%2+(m==2?y%4||y%100==0&&y%400?28:29:30)) 
				txt += ''; 
			else 
				txt += '<option value="' + (i+1-dShift1) + '" '+selected_d+'>' + (i+1-dShift1) + ''; 
		} 

		txt += '<\/select><?php echo af_txt_d;?>';
		
    document.getElementById('patchCalendar2').innerHTML = txt + '<\/tr>\n<\/table>'; 
} 

//PG사 선택에 따른 숨기고 보이기
function displayPG(cName,tag)
{	
var obj=document.getElementsByTagName("*");
for (var i=0; i < obj.length;i++)
	{	
	if(cName == "kcp")
		{
		if (obj[i].className == "kcp")	
			{
				obj[i].style.display="inline";				
			}
		if (obj[i].className == "ksnet")	
			{
				obj[i].style.display="none";							
			}			
		}
	if(cName == "ksnet")
		{
		if (obj[i].className == "kcp")	
			{
				obj[i].style.display="none";									
			}
		if (obj[i].className == "ksnet")	
			{
				obj[i].style.display="inline";				
			}			
		}				
	}			
}	

-->
</script>


</HEAD>

<!--//////////////////////////////////////////////////////////////////////////////////-->
<!--################################  BODY start  ####################################-->
<!--//////////////////////////////////////////////////////////////////////////////////-->
<BODY onload="f_daySelect1(<?php echo date("Y");?>,<?php echo date("m");?>);f_daySelect2(<?php echo date("Y");?>,<?php echo date("m");?>);">

<DIV>  
 
  <div id="main_left">
    <h1 id="en">FORM <?php if($_GET['mode']=="modify") echo "MODIFY"; else echo "ADD";?></h1>

	<FORM NAME="form1" id="form1" method="post" action='<?php echo $_SERVER['PHP_SELF'];?>' enctype='multipart/form-data' onsubmit='return false;'>
	<INPUT TYPE="hidden" NAME="NAX_FILE_SIZE" value="20000000">


	<?php if(!$_GET['mode']) {?>
	<input type="hidden" name="mode" value="add">
	<?}?>
	<?php if($_GET['mode']=="modify") {?>
	<input type="hidden" name="mode" value="modify_ok">
	<input type="hidden" name="no" value="<?php echo $_GET['no']?>">
	<?}?>		

			
	<?php if($_GET['mode']=="modify") echo "&nbsp;<h2><strong style='color:red;'>$title_text($name)</strong> ".af_txt_form_add_1."</h2>"; else echo "&nbsp;<h2>".af_txt_form_add_2."</h2>";?>
	<div style="text-align:right">
			<!-- 수정하기, 폼보기, 항목설정 버튼-->
			<?php if($_GET['mode']=="modify") {?>
			<input type='button' value='수정하기' onclick="Mix(this.form);Mix_sms(this.form);Section(this.form);only_en(this.form.name,this.form.name.value);chk_email(this.form,this.form.email_address);" class="btn_set">			
			<input type='button' value='<?php echo af_txt_add_items_50;?>' onclick="javascript:void(window.open('../view_addform.php?fname=<?php echo $name;?>','popup_view2',''))" class="btn_set">
			<input type='button' value='<?php echo af_txt_set_item;?>' onClick="location.href='add_items.php?fname=<?php echo $name;?>&amp;form_type=<?php echo $form_type;?>&amp;no=<?php echo $no;?>'" class='btn_set'>
			<?}?>

	</div>	
	<HR>
	
	<!-- /////////////////////////////////	폼형식 설정   ////////////////////////////-->		
	<DIV class="sms_wrapper">
	<FIELDSET>
		<LEGEND>폼형식</LEGEND>
		<p><strong>폼메일</strong>: 온라인문의,신청서,예약접수등의 접수/관리업무에 적합합니다.<br>
		   <strong>주문폼</strong>: 견적서와 연동된 제품판매등의 주문서 접수/관리가 필요할 경우 적합합니다.
		</p>
		<P>
			<label for="form_type" class="label"><?php echo af_txt_form_add_3;?></label>
				<input type="radio" name="form_type" value="1" onclick="dispaly_css(this.form,this,secret_price,'estimate_onlyform','div',this);" <?php if($form_type=="1" or !$_GET['mode']=="modify") echo "checked"?>><span class="radio_select"><?php echo af_txt_formType1;?></span>					    
				<input type="radio" name="form_type" value="0" onclick="dispaly_css(this.form,this,secret_price,'estimate_onlyform','div');" <?php if($form_type=="0") echo "checked"?>><span class="radio_select">
				<?php echo af_txt_formType0;?></span>			
		</P>		
	</FIELDSET>
	</DIV>
	<?php if($_GET['mode']=="modify") {?>
			<div style="text-align:right;">
			<input type='button' value='modify' onclick="Mix(this.form);Mix_sms(this.form);Section(this.form);only_en(this.form.name,this.form.name.value);chk_email(this.form,this.form.email_address);" class="btn_set">			
			</div>
	<?php }?>

	<!-- ///////////////////////////////	기본설정 (필수)   ////////////////////////-->	
	<DIV class="sms_wrapper">
	<FIELDSET>
		<LEGEND>기본설정 (필수)</LEGEND>
		<!--	그룹선택	-->
		<P>
			 <label for="comboGroup" class="label"><?php echo af_txt_select_group;?></label>			
					<?php echo f_mkOptArr();?>
					<input type="hidden" name="no_group" value="<?php if($no_group) echo"$no_group"; else echo"1";?>">
		</P>
				
		<!--	스킨선택	-->	
		<P>
			<label for="comboSkin" class="label"><?php echo af_txt_form_add_4;?></label>	
					<select name=comboSkin id=comboSkin onchange='skin_name.value=options[options.selectedIndex].value'>		
						<?php echo f_skin("../skins");?>					
					</select>
					<input type='hidden' name='skin_name' value="<?php if($skin_name) echo $skin_name; else echo "addform_default";?>">
		</P>

		<!--	관리자 이메일	-->
		<P>
			<label for="email_address" class="label">* <?php echo af_txt_form_add_12;?></label>		
				<INPUT TYPE="text" NAME="email_address" id="email_address" STYLE="IME-MODE: disabled;background-color:#6699cc" VALUE="<?php echo $email_address?>" class="ess">
				고객접수시 메일발송여부: <input type='checkbox' name='dummy11' value='1' <?php if($dummy11 == "1" or !$_GET['mode']=="modify") echo "checked";?>>관리자 <input type='checkbox' name='dummy12' value='1' <?php if($dummy12 == "1" or !$_GET['mode']=="modify") echo "checked";?>>접수고객
		</P>
		

		<!--	폼이름	-->
		<P>
			<label for="name" class="label">* <?php echo af_txt_form_add_name;?></label>			
				<INPUT TYPE="text" class="ess" NAME="name" id="name" style="ime-mode:Disabled;background-color:#6699cc;<?php if($_GET['mode']=="modify") echo "border-style:none;background-color: #e7e3e7;";?>"  onblur='quot_Del(this);' VALUE="<?php echo $name;?>" <?php if($_GET['mode']=="modify") echo "readonly";?>>
				<?php if(!$_GET['mode']){?>
				<INPUT TYPE="button" value="<?php echo af_txt_form_add_btnDubleChk;?>" onclick="window.open('chk_formname.php?name='+this.form.name.value+'','chk_name','width=100,height=100,statusbar=no,scrollbars=no,toolbar=no')">
				<?php }?>
		</P>

		<!--	제 목	-->
		<P>
			<label for="title_text" class="label">* <?php echo af_txt_form_add_5;?></label>		
				<INPUT TYPE="text" class="ess" NAME="title_text" id="title_text" STYLE="IME-MODE: active;background-color:#6699cc;"  onblur='quot_Del(this);' VALUE="<?php echo $title_text?>">
		</P>		
	</FIELDSET>
	</DIV>
	<?php if($_GET['mode']=="modify") {?>
			<div style="text-align:right;">
			<input type='button' value='modify' onclick="Mix(this.form);Mix_sms(this.form);Section(this.form);only_en(this.form.name,this.form.name.value);chk_email(this.form,this.form.email_address);" class="btn_set">
			</div>
	<?php }?>

	<!-- ///////////////////////////////	폼 유효기간 설정  ////////////////////////-->	
	<DIV class="sms_wrapper">
	<FIELDSET>
		<LEGEND>폼 유효기간 설정</LEGEND>
		<p>신청서제출 마감일이나 제출기간등의 설정이 필요할 경우, 아래에서 YES에 체크 후, 유효기간을 설정하세요.</p>
		<p>	 
			<label for="dummy17" class="label">폼 유효기간 사용</label>
				<input type="radio" name="dummy17" value="1" <?php if($dummy17 == "1") echo "checked";?>><span style='font-weight:bold;'>YES</span>		    		    
				<input type="radio" name="dummy17" value="0" <?php if($dummy17== "0" or $dummy17 == null) echo "checked";?>><span style='font-weight:bold;'>NO</span>			
		</p>
		
			<label for="dummy15" class="label" style="padding-top:10px;">폼 유효기간 설정</label>			
				<ul style="padding-top:5px;">
					<li style="display:inline;" id="patchCalendar1"></li>
					<li style="display:inline;" id="patchCalendar2"></li>
				</ul>			
				<input type="hidden" name="dummy15" value="<?php if($dummy15) echo $dummy15;?>">
				<input type="hidden" name="dummy16" value="<?php if($dummy16) echo $dummy16;?>">		 	 
	</FIELDSET>
	</DIV>
	<?php if($_GET['mode']=="modify") {?>
			<div style="text-align:right;">
			<input type='button' value='modify' onclick="Mix(this.form);Mix_sms(this.form);Section(this.form);only_en(this.form.name,this.form.name.value);chk_email(this.form,this.form.email_address);" class="btn_set">
			</div>
	<?php }?>

	<!-- /////////////////////////////  	글꼴 설정   //////////////////////////////-->
	<DIV class="sms_wrapper">
	<FIELDSET>
		<LEGEND>글꼴 설정</LEGEND>
		<!--	폰트	-->
		<P>
			<label for="font_family" class="label"><?php echo af_txt_form_add_55;?></label>		
				<INPUT TYPE="text" NAME="font_family" STYLE="IME-MODE: active"  onblur='quot_Del(this)' VALUE="<?php if($font_family) echo $font_family; else echo "돋움";?>">
		</P>
		<!--	폰트 사이트	-->
		<P>
			<label for="font_size" class="label"><?php echo af_txt_form_add_56;?></label>		
				<INPUT TYPE="text" NAME="font_size" STYLE="IME-MODE: active"  onblur='quot_Del(this)' VALUE="<?php if($font_size) echo $font_size; else echo "13px";?>"> 
				보통크기는 13px 입니다.
		</P>
		<!--	폰트 색상	-->
		<P>
			<label for="font_color" class="label"><?php echo af_txt_form_add_57;?></label>		
				<INPUT TYPE="text" NAME="font_color" STYLE="IME-MODE: active"  onblur='quot_Del(this)' VALUE="<?php if($font_color) echo $font_color; else echo "#000000";?>">
				6자리 색상코드앞에 #을 붙입니다.
		</P>		
	</FIELDSET>
	</DIV>
	<?php if($_GET['mode']=="modify") {?>
			<div style="text-align:right;">
			<input type='button' value='modify' onclick="Mix(this.form);Mix_sms(this.form);Section(this.form);only_en(this.form.name,this.form.name.value);chk_email(this.form,this.form.email_address);" class="btn_set">
			</div>
	<?php }?>
	
	<!-- /////////////////	상하단 표시문구 및 상하단 배너이미지 설정  ///////////////-->
	<DIV class="sms_wrapper">
	<FIELDSET>
		<LEGEND>상하단 표시문구 및 상하단 배너이미지 설정</LEGEND>
		<P>폼의 상하단에 표시될 문구나 이미지를 설정합니다.</P>
		<!--	상단 메시지	-->
		<P>
			<label for="msg_top" class="label"><?php echo af_txt_form_add_6;?></label>		
				<TEXTAREA NAME="msg_top" id="msg_top" STYLE="IME-MODE: active;width:500px;" class="tag" rows="6"><?php echo $msg_top?></TEXTAREA>
		</P>

		<!--	하단 메시지	-->
		<P>
			<label for="msg_bottom" class="label"><?php echo af_txt_form_add_7;?></label>		
				<TEXTAREA NAME="msg_bottom" id="msg_bottom" STYLE="IME-MODE: active;width:500px;" class="tag" rows="6"><?php echo $msg_bottom?></TEXTAREA>
		</P>
		<!--	상단 이미지	-->
		<P>
			<label for="top_img" class="label"><?php echo af_txt_form_add_8;?></label>		
				<input type="file" name="top_img" size="50" style="height:20px;"><?php echo af_txt_form_add_64;?>(gif,jpg)	
				<?php
						
				for($z=0; $z < count($af_arr_format);$z++)
					{
					if(file_exists("../upload/".$name."/top_img.".$af_arr_format[$z].""))
						{					
						echo "<img src='../upload/".$name."/top_img.".$af_arr_format[$z]."' style='vertical-align:middle;width:130px;height:50px;border:1px solid #000;' alt='상단배너이미지'>";
						echo "<input type='checkbox' name='top_imgDel' value='1'>".af_txt_form_add_66."";			
						}
					}
				?>
		</P>

		<!--	하단 이미지	-->
		<P>
			<label for="bottom_img" class="label"><?php echo af_txt_form_add_9;?></label>		
				<input type="file" name="bottom_img" size="50" style="height:20px;"><?php echo af_txt_form_add_64;?>(gif,jpg)	
				<?php
						
				for($z=0; $z < count($af_arr_format);$z++)
					{
					if(file_exists("../upload/".$name."/bottom_img.".$af_arr_format[$z].""))
						{					
						echo "<img src='../upload/".$name."/bottom_img.".$af_arr_format[$z]."' style='vertical-align:middle;width:130px;height:50px;border:1px solid #000;' alt='하단배너이미지'>";
						echo "<input type='checkbox' name='bottom_imgDel' value='1'>".af_txt_form_add_66."";			
						}
					}
				?>
		</P>		
	</FIELDSET>
	</DIV>
	<?php if($_GET['mode']=="modify") {?>
			<div style="text-align:right;">
			<input type='button' value='modify' onclick="Mix(this.form);Mix_sms(this.form);Section(this.form);only_en(this.form.name,this.form.name.value);chk_email(this.form,this.form.email_address);" class="btn_set">
			</div>
	<?php }?>
	
	<!-- //////////////////////////////  	레이아웃   //////////////////////////////-->
	<DIV class="sms_wrapper">
	<FIELDSET>
		<LEGEND>레이아웃 설정</LEGEND>		
		<!--	화면표시 너비	-->
		<P>
			<label for="width" class="label"><?php echo af_txt_form_add_10;?></label>		
				<INPUT TYPE="text" NAME="width" id="width" STYLE="IME-MODE: active"  onblur='Numbering2(this);' VALUE="<?php if($width) echo $width; else echo "645";?>">
				<INPUT TYPE="radio" NAME="width_chk"  onclick='wrapper_width(this.form,this);' VALUE="780">
				<?php echo af_txt_form_add_wide;?>
				<INPUT TYPE="radio" NAME="width_chk"  onclick='wrapper_width(this.form,this);' VALUE="100">100%
				<INPUT TYPE="radio" NAME="width_chk"  onclick='wrapper_width(this.form,this);' VALUE="90">90%
				
		</P>

		<!--	레이아웃	-->
		<p>폼만 표시되기를 원하는 경우, 여덟번째 레이아웃을 선택합니다.</p>
		<P>			
				<INPUT TYPE="radio" NAME="layout" VALUE="1" <?php if($layout=="1") echo "checked"?> onclick="this.form.width.value='980'"><img src="img/layout1.gif" alt="layout1" align="top">
				<INPUT TYPE="radio" NAME="layout" VALUE="2" <?php if($layout=="2") echo "checked"?>><img src="img/layout2.gif" alt="layout2" align="top">
				<INPUT TYPE="radio" NAME="layout" VALUE="3" <?php if($layout=="3") echo "checked"?>><img src="img/layout3.gif" alt="layout3" align="top">
				<INPUT TYPE="radio" NAME="layout" VALUE="4" <?php if($layout=="4") echo "checked"?>><img src="img/layout4.gif" alt="layout4" align="top">
				<INPUT TYPE="radio" NAME="layout" VALUE="5" <?php if($layout=="5") echo "checked"?>><img src="img/layout5.gif" alt="layout5" align="top">
				<INPUT TYPE="radio" NAME="layout" VALUE="6" <?php if($layout=="6") echo "checked"?>><img src="img/layout6.gif" alt="layout6" align="top">
				<INPUT TYPE="radio" NAME="layout" VALUE="7" <?php if($layout=="7") echo "checked"?>><img src="img/layout7.gif" alt="layout7" align="top">
				<INPUT TYPE="radio" NAME="layout" VALUE="8" <?php if($layout=="8" or !$layout or !$_GET['mode']=="modify") echo "checked"?>><img src="img/layout8.gif" alt="layout8" align="top">			
		</P>		
	</FIELDSET>
	</DIV>
	<?php if($_GET['mode']=="modify") {?>
			<div style="text-align:right;">
			<input type='button' value='modify' onclick="Mix(this.form);Mix_sms(this.form);Section(this.form);only_en(this.form.name,this.form.name.value);chk_email(this.form,this.form.email_address);" class="btn_set">
			</div>
	<?php }?>

	<!-- /////////////////////////////  	썸네일 이미지   //////////////////////////-->
	<DIV class="sms_wrapper">
	<FIELDSET>
		<LEGEND>썸네일 이미지</LEGEND>
		<p>폼의 좌우레이아웃에 표시될, 현재폼의 작은 대표이미지입니다.<br>
		위 레이아웃 설정에서, 4,5,6,8 번 레이아웃을 사용할 경우엔, 등록할 필요가 없습니다.
		</p>
		<P>
		<label for="thumbnail" class="label"><?php echo af_txt_form_add_63;?></label>		
			<input type="file" name="thumbnail" size="50" style="height:20px;">70px * 50px <?php echo af_txt_form_add_64;?>(gif,jpg)	
			<?php
					
			for($z=0; $z < count($af_arr_format);$z++)
				{
				if(file_exists("../upload/".$name."/thumb.".$af_arr_format[$z].""))
					{					
					echo "<img src='../upload/".$name."/thumb.".$af_arr_format[$z]."' style='vertical-align:middle;width:70px;height:50px;border:1px solid #000;' alt='thumbnail img'>";
					echo "<input type='checkbox' name='thumbDel' value='1'>".af_txt_form_add_66."";			
					}
				}
			?>
		</P>		
	</FIELDSET>
	</DIV>
	<?php if($_GET['mode']=="modify") {?>
			<div style="text-align:right;">
			<input type='button' value='modify' onclick="Mix(this.form);Mix_sms(this.form);Section(this.form);only_en(this.form.name,this.form.name.value);chk_email(this.form,this.form.email_address);" class="btn_set">
			</div>
	<?php }?>

	<!-- //////////////////////////////  	첨부파일   //////////////////////////////-->
	<DIV class="sms_wrapper">
	<FIELDSET>
		<LEGEND>첨부파일 기능 설정</LEGEND>
		<p>
			첨부파일이 저장되는 경로(이메일에첨부 또는 웹서버에 저장)를 <strong>폼추가수정 > 전체폼기본환경설정</strong> 에서 설정할 수 있습니다.<br>
			신용카드결제 연동시, 안전한 거래를 위해 첨부파일기능은 자동으로 해제됩니다.
		</p>
		<!--	파일 첨부 기능 여부 -->		
		<P>
			<label for="dummy1" class="label"><?php echo af_txt_form_add_11;?></label>				    
				<input type="radio" name="dummy1" value="1" <?php if($dummy1=="1") echo "checked"?>><span class="radio_select">YES</span>&nbsp;&nbsp;&nbsp;
			
				<input type="radio" name="dummy1" value="0" <?php if($dummy1=="0" or $dummy1==null or !$_GET['mode']=="modify") echo "checked"?>><span class="radio_select">NO</span>&nbsp;&nbsp;			
				<?php echo af_txt_form_add_44;?>:
				<input type="text" name="max_file_size" value="<?php if($max_file_size=="0" or $max_file_size==null or !$_GET['mode']=="modify") echo "2000000"; else echo $max_file_size;?>" STYLE="IME-MODE: disabled"  onblur=' Numbering2(this)' size="10">
				Byte 
				[MAX: <span style="color:red"><?php echo upload_max_filesize;?></span> Byte]			
		</P>
		<!--	파일 첨부 기능 여부 -->		
		<P>
			<label for="dummy7" class="label"><?php echo af_txt_form_add_69;?></label>			
				<input type="text" name="dummy7" value="<?php if($dummy7) echo "$dummy7"; else echo "1";?>"  size="2" readonly>
				<input type="button" value="+" onclick="this.form.dummy7.value++">
				<input type="button" value="-" onclick="this.form.dummy7.value--;attachFiles(this.form.dummy7);">			
		</P>
		<!--	첨부파일 허용 확장자 -->	
		<p>
			<label for="attachFormat" class="label"><?php echo af_txt_form_add_45;?></label>			
				<input type="text" name="attachFormat" value="<?php if($attachFormat=="" or $attachFormat==null or !$_GET['mode']=="modify") echo "jpg,jpeg,gif,png,psd,xls,doc,hwp,txt,zip,tar,ppt,dwg"; else echo $attachFormat;?>" STYLE="IME-MODE: disabled" size="50" onblur='quot_Del(this)'>	
		</p>
	</FIELDSET>
	</DIV>
	<?php if($_GET['mode']=="modify") {?>
			<div style="text-align:right;">
			<input type='button' value='modify' onclick="Mix(this.form);Mix_sms(this.form);Section(this.form);only_en(this.form.name,this.form.name.value);chk_email(this.form,this.form.email_address);" class="btn_set">
			</div>
	<?php }?>

	<!-- //////////////////////////////// 	고객항목   ///////////////////////////////-->
	<DIV class="sms_wrapper">
	<FIELDSET>
		<LEGEND>기본고객정보 입력항목</LEGEND>		
		<!--	고객정보 입력항목 선택 -->
		<p>이 항목은, 폼의 항목이나 품목을 추가하는, <strong>품목설정</strong>에서 다시 설정할 수 있습니다.</p>
		<p>
		<label for="client_item" class="label"><?php echo af_txt_form_add_46;?></label>				
		<input type="checkbox" name="client_item" value="1" <?php if($client_itemsArr[0]=="1" or !$_GET['mode']=="modify") echo "checked";?>>
			<input type="text" name="client_text_name" value="<?php if($client_text_name) echo $client_text_name; else echo af_txt_form_add_47;?>" onblur='quot_Del(this)' size="7">
		<input type="checkbox" name="client_item" value="1" <?php if($client_itemsArr[1]=="1" or !$_GET['mode']=="modify") echo "checked";?>>
			<input type="text" name="client_text_email" value="<?php if($client_text_email) echo $client_text_email; else echo af_txt_form_add_48;?>" onblur='quot_Del(this)' size="7">
		<input type="checkbox" name="client_item" value="1" <?php if($client_itemsArr[2]=="1" or !$_GET['mode']=="modify") echo "checked";?>>
			<input type="text" name="client_text_hp" value="<?php if($client_text_hp) echo $client_text_hp; else echo af_txt_form_add_49;?>" onblur='quot_Del(this)' size="7">
		<input type="checkbox" name="client_item" value="1" <?php if($client_itemsArr[3]=="1" or !$_GET['mode']=="modify") echo "checked";?>>
			<input type="text" name="client_text_tel" value="<?php if($client_text_tel) echo $client_text_tel; else echo af_txt_form_add_50;?>" onblur='quot_Del(this)' size="7">
		<input type="checkbox" name="client_item" value="1" <?php if($client_itemsArr[4]=="1" or !$_GET['mode']=="modify") echo "checked";?>>
			<input type="text" name="client_text_fax" value="<?php if($client_text_fax) echo $client_text_fax; else echo af_txt_form_add_51;?>" onblur='quot_Del(this)' size="7">
		<input type="checkbox" name="client_item" value="1" <?php if($client_itemsArr[5]=="1" or !$_GET['mode']=="modify") echo "checked";?>>
			<input type="text" name="client_text_address" value="<?php if($client_text_address) echo $client_text_address; else echo af_txt_form_add_52;;?>" onblur='quot_Del(this)' size="7">
		<input type="checkbox" name="client_item" value="1" <?php if($client_itemsArr[6]=="1" or !$_GET['mode']=="modify") echo "checked";?>>
			<input type="text" name="client_text_memo" value="<?php if($client_text_memo) echo $client_text_memo; else echo af_txt_form_add_53;?>" onblur='quot_Del(this)' size="7">
		<input type="hidden" name="client_items" value="">
		</p>
	</FIELDSET>
	</DIV>
	<?php if($_GET['mode']=="modify") {?>
			<div style="text-align:right;">
			<input type='button' value='modify' onclick="Mix(this.form);Mix_sms(this.form);Section(this.form);only_en(this.form.name,this.form.name.value);chk_email(this.form,this.form.email_address);" class="btn_set">
			</div>
	<?php }?>

	<!-- //////////////////////////////// 	전송후 이동방법   ///////////////////////////////-->
	<DIV class="sms_wrapper">
	<FIELDSET>
		<LEGEND>전송후, 화면 처리</LEGEND>		
		<!--	전송 후 리턴 url -->
		<P>
			<label for="return_url" class="label"><?php echo af_txt_form_add_59;?></label>		
				<INPUT TYPE="text" NAME="return_url" STYLE="IME-MODE: disabled"  size="50" onblur='quot_Del(this)' VALUE="<?php if($return_url) echo $return_url; else echo "";?>"> <?php echo af_txt_form_add_65;?>
		</P>
		<!--	전송후 이동방법 -->
		<P>
			<label for="return_type" class="label"><?php echo af_txt_form_add_60;?></label>		
				<INPUT TYPE="radio" NAME="return_type" VALUE="auto" <?php if($return_type=="auto" or !$_GET['mode']=="modify") echo "checked"?>><?php echo af_txt_form_add_61;?>
				<INPUT TYPE="radio" NAME="return_type" VALUE="click" <?php if($return_type=="click") echo "checked"?>><?php echo af_txt_form_add_62;?>
		</P>
		<!--	프레임 이동방법 -->
		<P>
			<label for="dummy18" class="label">프레임 이동방법</label>		
				<input type="radio" name="dummy18" value="0" <?php if($dummy18 == "0" or $dummy18 == null) echo "checked";?>>아이프레임안에서 이동
				<input type="radio" name="dummy18" value="1" <?php if($dummy18== "1") echo "checked";?>>아이프레임밖에서 이동			
		</P>

		<!--	전송버튼 이미지	-->
		<P>
			<label for="btn_submit" class="label">전송/접수 버튼이미지</label>		
				<input type="file" name="btn_submit" size="50" style="height:20px;">100px * 35px<?php echo af_txt_form_add_64;?>(gif,jpg)	
				<?php
						
				for($z=0; $z < count($af_arr_format);$z++)
					{
					if(file_exists("../upload/".$name."/btn_submit.".$af_arr_format[$z].""))
						{					
						echo "<img src='../upload/".$name."/btn_submit.".$af_arr_format[$z]."' style='vertical-align:middle;width:100px;height:35px;' alt='전송하기 버튼이미지'>";
						echo "<input type='checkbox' name='btn_submitDel' value='1'>".af_txt_form_add_66."";			
						}
					}
				?>
		</P>
		<!--	다시작성 버튼 이미지	-->
		<P>
			<label for="btn_submit" class="label">다시작성 버튼이미지</label>		
				<input type="file" name="btn_retry" size="50" style="height:20px;">100px * 35px<?php echo af_txt_form_add_64;?>(gif,jpg)	
				<?php
						
				for($z=0; $z < count($af_arr_format);$z++)
					{
					if(file_exists("../upload/".$name."/btn_retry.".$af_arr_format[$z].""))
						{					
						echo "<img src='../upload/".$name."/btn_retry.".$af_arr_format[$z]."' style='vertical-align:middle;width:100px;height:35px;' alt='다시작성 버튼이미지'>";
						echo "<input type='checkbox' name='btn_retryDel' value='1'>".af_txt_form_add_66."";			
						}
					}
				?>
		</P>		
	</FIELDSET>
	</DIV>
	<?php if($_GET['mode']=="modify") {?>
		<div style="text-align:right;">
		<input type='button' value='modify' onclick="Mix(this.form);Mix_sms(this.form);Section(this.form);only_en(this.form.name,this.form.name.value);chk_email(this.form,this.form.email_address);" class="btn_set">
		</div>
	<?php }?>

	<!-- //////////////////////////////// 	폼메일일 때 계산기능   ///////////////////////////////-->
	<DIV class="sms_wrapper">
	<FIELDSET>
		<LEGEND><?php echo af_txt_form_add_70;?></LEGEND>
		<p>폼메일 항목의 옵션들에 가격을 설정시, 고객이 체크한 항목의 합계가 폼하단에 표시됩니다. <br>
		no 에 체크하면, 폼하단에 합계나 가격에 관련된것이 표시되지 않습니다.<br>
		<!--신용카드 결제와 연동하려면, 아래의 신용카드결제 연동을 체크해야 합니다.--></p>
		<P>		
		<label for="dummy8" class="label"><?php echo af_txt_form_add_71;?></label>				    
			<input type="radio" name="dummy8" value="1" <?php if($dummy8=="1") echo "checked"?>><span class="radio_select">YES</span>&nbsp;&nbsp;&nbsp;		
			<input type="radio" name="dummy8" value="0" <?php if(!$dummy8 or $dummy8=="0") echo "checked"?>><span class="radio_select">NO</span>		
		</P>
	</FIELDSET>
	</DIV>
	<?php if($_GET['mode']=="modify") {?>
		<div style="text-align:right;">
		<input type='button' value='modify' onclick="Mix(this.form);Mix_sms(this.form);Section(this.form);only_en(this.form.name,this.form.name.value);chk_email(this.form,this.form.email_address);" class="btn_set">
		</div>
	<?php }?>

	<!-- ////////////////////////////  신용카드결제연동   ////////////////////////////-->
	<DIV class="sms_wrapper">
	<FIELDSET>
		<LEGEND><?php echo af_txt_form_add_73;?></LEGEND>
		<P>
		<label for="yesorno_pay" class="label"><?php echo af_txt_form_add_74;?></label>		   
			<input type="radio" name="yesorno_pay" value="on" <?php if($yesorno_pay=="on") echo "checked"?> onclick="this.form.dummy8[0].checked=true;display_sms(this.form,this,'pay','div');"><span class="radio_select">YES</span>&nbsp;&nbsp;&nbsp;		
			<input type="radio" name="yesorno_pay" value="off" onclick="display_sms(this.form,this,'pay','div');" <?php if($yesorno_pay=="off" or $yesorno_pay=="" or !$_GET['mode']=="modify") echo "checked"?>><span class="radio_select">NO</span>
		</P>
		<div class="pay">		
			<P class="kcp">
			* <strong style="color:#02587b;">KCP</strong> 신용카드결제 연동을 하기 위해서는, 한국사이버결제(KCP)와 가맹점 계약을 맺어야 합니다.<br>
			<a href='http://kcp.co.kr/' target='new'>한국사이버결제 http://kcp.co.kr</a> 에 접속하여, 가맹점 계약을 맺으면, 사이트코드와 사이트키가 부여됩니다.<br>
			부여받은 사이트코드와 사이트키를, 아래에 입력하고 위 신용카드결제사용여부를 YES 에 체크하면, 고객이 폼메일 또는 주문폼접수시 결제연동이 됩니다.<br>
			*카드결제금액은 1000원 이상이어야 하며, 결제연동시 안전한 거래를 위해 파일첨부기능은 사용하지 못합니다.
			</P>
		
			<P class="ksnet">
			* <strong style="color:#092768;">KSNET</strong> 신용카드결제 연동을 하기 위해서는, 케이에스넷(KSNET)과 가맹점 계약을 맺어야 합니다.<br>
			<a href='http://www.ksnet.co.kr' target='new'>케이에스넷 http://www.kspay.co.kr</a> 에 접속하여, 가맹점 계약을 맺으면, 상점아이디가 부여됩니다.<br>
			부여받은 상점아이디를, 아래에 입력하고 위 신용카드결제사용여부를 YES 에 체크하면, 고객이 폼메일 또는 주문폼접수시 결제연동이 됩니다.<br>
			*카드결제금액은 1000원 이상이어야 하며, 결제연동시 안전한 거래를 위해 파일첨부기능은 사용하지 못합니다.
			</P>		
			
			<!-- 신용카드 PG사 선택	-->
			<P>
				<label for="res_dummy1" class="label">PG사 선택</label>				
				<?php echo f_PG("../plugin/PG");?>			
			</P>
			<P>
				<label for="site_cd" class="label">
				*	<span class="kcp">사이트코드</span>
					<span class="ksnet">상점아이디</span>
				</label>		
					<INPUT TYPE="text" NAME="site_cd" id="site_cd" STYLE="IME-MODE: disabled"  onblur='quot_Del(this)' VALUE="<?php echo $site_cd?>">
			</P>
			<P class="kcp">
				<label for="site_key" class="label">* 사이트키</label>		
					<INPUT TYPE="text" NAME="site_key" id="site_key" STYLE="IME-MODE: disabled"  onblur='quot_Del(this)' VALUE="<?php echo $site_key?>">
			</P>
			<P>
				<label for="res_name" class="label">* 상품이름</label>		
					<INPUT TYPE="text" NAME="res_name" id="res_name" onblur='quot_Del(this)' VALUE="<?php echo $res_name?>">
			</P>
			<P class="ksnet">
				<label for="res_dummy2" class="label">* 회사상호</label>		
					<INPUT TYPE="text" NAME="res_dummy2" id="res_dummy2" STYLE="IME-MODE: active"  onblur='quot_Del(this)' VALUE="<?php echo $res_dummy2?>">
			</P>
			<P class="ksnet">
				<label for="res_dummy3" class="label">* 사이트주소</label><br>		
					<INPUT TYPE="text" NAME="res_dummy3" id="res_dummy3" STYLE="IME-MODE: disabled"  onblur='quot_Del(this)' VALUE="<?php if(!$res_dummy3) echo "http://";else echo $res_dummy3;?>">
			</P>
			<P style="display:none;">
				<label for="res_mny" class="label">* 예약비용</label>		
					<INPUT TYPE="text" NAME="res_mny" id="res_mny" STYLE="IME-MODE: disabled"  onblur='quot_Del(this)' VALUE="<?php if($res_mny != null) echo $res_mny;else echo '1000';?>"> *카드결제금액은 1000원 이상이어야 하며, 콤마없이 숫자만 입력 
			</P>
			<P class="kcp">
				<label for="quotaopt" class="label">할부개월수</label>		
					<select name="quotaopt">								
						<?php
							for($i = 0; $i < 13;$i++)
							{	
								if($i == $quotaopt)
								{
									$quotaopt_selected = "selected";
								}
								else $quotaopt_selected = "";
								if($i == 0)
								{
								echo "<option value='$i' ".$startDay_selected.">일시불만 가능";
								}
								else
								{
								echo "<option value='$i' ".$quotaopt_selected.">".$i." 개월까지 가능";
								}
							}
						?>
						</select>
						*할부는 5만원 이상일 때 부터 적용됩니다.
			</P>
		</div>
	</FIELDSET>
	</DIV>
	<?php if($_GET['mode']=="modify") {?>
		<div style="text-align:right;display:none;">
		<input type='button' value='modify' onclick="Mix(this.form);Mix_sms(this.form);Section(this.form);only_en(this.form.name,this.form.name.value);chk_email(this.form,this.form.email_address);" class="btn_set">
		</div>
	<?php }?>

	<!-- //////////////////////////////// 	SMS 연동   ///////////////////////////////-->
	<DIV class="sms_wrapper">
	<FIELDSET>
		<LEGEND><?php echo af_txt_form_add_13;?></LEGEND>
		<P>
			<label for="sms_yesorno" class="label">SMS 사용여부</label>			    
				<input type="radio" name="sms_yesorno" value="1" onclick="display_sms(this.form,this,'sms','div');" <?php if($sms_yesorno=="1") echo "checked"?>><span class="radio_select">YES</span>&nbsp;&nbsp;&nbsp;		
				<input type="radio" name="sms_yesorno" value="0" onclick="display_sms(this.form,this,'sms','div');" <?php if($sms_yesorno=="0" or $sms_yesorno=="" or !$_GET['mode']=="modify") echo "checked"?>><span class="radio_select">NO</span>	
		</P>
		<div class="sms">
		<P>
			*고객접수시 SMS 문자메시지로 통보받기 위해선, SMS호스팅 서비스회사에 가입되어 있어야 합니다.<BR />
			*애드폼에서는, 후이즈호스팅의 SMS 모듈을 연동시켜놓았으므로, SMS문자알림연동을 원하신다면<BR />
			<a href='http://whoisweb.net/' target='new'>후이즈 http://whoisweb.net/</a>에 접속하여, SMS호스팅을 신청하신 후, 아래에 연동하면 됩니다..<BR />		
		</P>
		<!-- SMS호스팅 회사 	-->
		<P>
			<label for="comboSMS" class="label">SMS호스팅사 선택</label>	
				<select name="comboSMS" id="comboSMS" onchange="sms_cp.value=options[options.selectedIndex].value">	
				<option value="">가입한 SMS호스팅사를 선택하세요
				<?php echo f_skin("../plugin/sms");?>					
				</select>
				<input type='hidden' name='sms_cp' value="<?php if($sms_cp) echo"$sms_cp"; else echo"";?>">
		</P>
		<P>
			<label for="sms_id" class="label">SMS계정 아이디</label>		
				<INPUT TYPE="text" NAME="sms_id" id="sms_id" STYLE="IME-MODE: disabled"  onblur='quot_Del(this)' VALUE="<?php echo $sms_id?>">
		</P>
		<P>
			<label for="sms_pw" class="label">SMS계정 비밀번호</label>		
				<INPUT TYPE="text" NAME="sms_pw" id="sms_pw" STYLE="IME-MODE: disabled"  onblur='quot_Del(this)' VALUE="<?php echo $sms_pw?>">
		</P>
		<P>
			<label for="sms_to" class="label">수신 휴대폰번호(관리자)</label>		
				<INPUT TYPE="text" NAME="sms_to" id="sms_to" STYLE="IME-MODE: disabled"  onblur=' Numbering2(this)' VALUE="<?php echo $sms_toDB?>">
		</P>
		<P>
			<label for="sms_msg" class="label">메시지(관리자에게)</label>	
				<textarea NAME="sms_msg" id="sms_msg" STYLE="IME-MODE: active"  onblur='quot_Del(this)' rows='5'><?php if($sms_msg) echo $sms_msg;?></textarea>				
		</P>
		<P>
			<label for="dummy19" class="label">메시지(고객에게)</label>	
				<textarea NAME="dummy19" id="dummy19" STYLE="IME-MODE: active"  onblur='quot_Del(this)' rows='5'><?php if($dummy19) echo $dummy19;?></textarea>				
		</P>
				<INPUT TYPE="hidden" NAME="dummy5" STYLE="IME-MODE: active"  onblur='quot_Del(this)' VALUE="<?php echo $dummy5?>">
		</div>
	</FIELDSET>
	</DIV>
	<?php if($_GET['mode']=="modify") {?>
		<div style="text-align:right;">
		<input type='button' value='modify' onclick="Mix(this.form);Mix_sms(this.form);Section(this.form);only_en(this.form.name,this.form.name.value);chk_email(this.form,this.form.email_address);" class="btn_set">
		</div>
	<?php }?>

	<!-- ///////////////////////////// 	주문/견적서 관련설정   ///////////////////////-->
	<DIV class="estimate_onlyform">
	<FIELDSET>
		<LEGEND><?php echo af_txt_form_add_14;?></LEGEND>
		<!--	통화단위 선택	-->
		<p>폼형식이 폼메일일 때는, 아래설정 내용이 적용되지 않습니다. 폼형식이 주문폼일 때, 설정하세요</p>
		<P>
			<label for="comboGroup2" class="label"><?php echo af_txt_form_add_15;?></label>	
				<?php echo f_mkOptArr2("coin_unit","coin_unit");?>
				<input type='hidden' name='coin_unit' onblur='quot_Del(this)' value="<?php if($coin_unit) echo"$coin_unit"; else echo"원";?>">
		</P>

		<!--	자동견적 사용여부 -->		
		<P>
			<label for="secret_price" class="label"><?php echo af_txt_form_add_autoCal;?></label>			   
				<input type="radio" name="secret_price" value="1" <?php if($secret_price=="1" or !$_GET['mode']=="modify") echo "checked"?>><span class="radio_select">YES</span>&nbsp;&nbsp;&nbsp;			
				<input type="radio" name="secret_price" value="0" <?php if($secret_price=="0") echo "checked"?>><span class="radio_select">NO</span>&nbsp;&nbsp;			
				<img src="../imgs/q.gif" style="vertical-align:middle;" alt="도움말" onclick="alert('*<?php echo af_txt_form_add_alt_autoCal;?>')">		
		</P>

		<!--	견적서 유효일 -->		
		<P>
			<label for="dummy2" class="label"><?php echo af_txt_form_add_16;?></label>				    
				<INPUT TYPE="text" NAME="dummy2" id="dummy2" STYLE="IME-MODE: active"  onblur='quot_Del(this);' VALUE="<?php if($dummy2) {echo $dummy2;} else {echo af_txt_form_add_16_1;}?>">			
		</P>

		<!--	표 상단에 표시될 항목 제목들 -->		
		<P>
			<label for="section1" class="label"><?php echo af_txt_form_add_17;?></label>	   
				<INPUT TYPE="text" NAME="section1" id="section1" STYLE="IME-MODE: active"  onblur='quot_Del(this);' VALUE="<?php if($section1) {echo $section1;} else {echo af_txt_form_add_18;}?>" size="5">
				<INPUT TYPE="text" NAME="section2" id="section2" STYLE="IME-MODE: active"  onblur='quot_Del(this);' VALUE="<?php if($section2) {echo $section2;} else {echo af_txt_form_add_19;}?>" size="5">
				<INPUT TYPE="text" NAME="section3" id="section3" STYLE="IME-MODE: active"  onblur='quot_Del(this);' VALUE="<?php if($section3) {echo $section3;} else {echo af_txt_form_add_20;}?>" size="5">
				<INPUT TYPE="text" NAME="section4" id="section4" STYLE="IME-MODE: active"  onblur='quot_Del(this);' VALUE="<?php if($section4) {echo $section4;} else {echo af_txt_form_add_21;}?>" size="5">
				<INPUT TYPE="text" NAME="section5" id="section5" STYLE="IME-MODE: active"  onblur='quot_Del(this);' VALUE="<?php if($section5) {echo $section5;} else {echo af_txt_form_add_22;}?>" size="5">
				<INPUT TYPE="text" NAME="section6" id="section6" STYLE="IME-MODE: active"  onblur='quot_Del(this);' VALUE="<?php if($section6) {echo $section6;} else {echo af_txt_form_add_23;}?>" size="5">
				<INPUT TYPE="text" NAME="section7" id="section7" STYLE="IME-MODE: active"  onblur='quot_Del(this);' VALUE="<?php if($section7) {echo $section7;} else {echo af_txt_form_add_24;}?>" size="5">
				<INPUT TYPE="text" NAME="section8" id="section8" STYLE="IME-MODE: active"  onblur='quot_Del(this);' VALUE="<?php if($section8) {echo $section8;} else {echo af_txt_form_add_25;}?>" size="5">
				<img src="../imgs/q.gif" style="vertical-align:middle;" alt="도움말" onclick="alert('<?php echo af_txt_form_add_26;?>')">			
				<INPUT TYPE="hidden" NAME="dummy3" id="dummy3" onblur='quot_Del(this);' VALUE="<?php if($dummy3) echo $dummy3;?>">		
		</P>

		<!--	견적서 상단 합계표시 방법  -->		
		<P>
			<label for="dummy4" class="label"><?php echo af_txt_form_add_27;?></label>			    
				<input type="radio" name="dummy4" value="1" <?php if($dummy4=="1" or !$_GET['mode']=="modify") echo "checked"?>><span class="radio_select"><?php echo af_txt_form_add_28;?></span>&nbsp;&nbsp;&nbsp;	
				<input type="radio" name="dummy4" value="2" <?php if($dummy4=="2") echo "checked"?>><span class="radio_select"><?php echo af_txt_form_add_29;?></span>&nbsp;&nbsp;		
				<input type="radio" name="dummy4" value="3" <?php if($dummy4=="3") echo "checked"?>><span class="radio_select">USD</span>  United States dollar(s)		
		</P>

		<!--	도장 이미지  -->		
		<P>
			<label for="sign_img" class="label"><?php echo af_txt_form_add_54;?></label>		
				<input type="text" name="sign_img" value="<?php if($sign_img) echo $sign_img;?>" onblur='quot_Del(this)' size="50">
				<img src="../imgs/q.gif" style="vertical-align:middle;" alt="도움말" onclick="alert('ex) http://www.addform.net/images/sign.gif')">
		</P>
		<!--	견적보기버튼 이미지	-->
		<P>
			<label for="btn_estimate" class="label">견적보기 버튼이미지</label>		
				<input type="file" name="btn_estimate" size="50" style="height:20px;">100px * 35px<?php echo af_txt_form_add_64;?>(gif,jpg)	
				<?php
						
				for($z=0; $z < count($af_arr_format);$z++)
					{
					if(file_exists("../upload/".$name."/btn_estimate.".$af_arr_format[$z].""))
						{					
						echo "<img src='../upload/".$name."/btn_estimate.".$af_arr_format[$z]."' style='vertical-align:middle;width:100px;height:35px;' alt='견적보기버튼 이미지'>";
						echo "<input type='checkbox' name='btn_estimateDel' value='1'>".af_txt_form_add_66."";			
						}
					}
				?>
		</P>

		<!--	부가세 반영여부 - 현재 사용안함  	
		<P>
		<span class="label">부가가치세 반영</span>
		<label>				    
			<input type="radio" name="dummy6" value="1" <?php if($dummy6=="1") echo "checked"?>><span class="radio_select">YES</span>&nbsp;&nbsp;&nbsp;
		</label>
		<label>
			<input type="radio" name="dummy6" value="0" <?php if($dummy6=="0" or $dummy6==null) echo "checked"?>><span class="radio_select">NO</span>&nbsp;&nbsp;
		</label>				
		</P>-->	

		
		<!-- #################	 계좌 정보 4.3 이후로 사용안함  #####################-->
			
		<FIELDSET style="display:none;">
			<LEGEND><?php echo af_txt_form_add_30;?></LEGEND>
				
			<?php echo af_txt_form_add_31;?>
						
			<INPUT TYPE="text" NAME="bank_name" STYLE="IME-MODE: active"  onblur='quot_Del(this)' VALUE="<?php echo $bank_name?>">
						
			<?php echo af_txt_form_add_32;?>
						
			<INPUT TYPE="text" NAME="bank_num" STYLE="IME-MODE: disabled"  onblur='quot_Del(this)' VALUE="<?php echo $bank_num?>">
						
			<?php echo af_txt_form_add_33;?>
						
			<INPUT TYPE="text" NAME="bank_who" STYLE="IME-MODE: active"  onblur='quot_Del(this)' VALUE="<?php echo $bank_who?>">
			<INPUT TYPE="hidden" NAME="banking" STYLE="IME-MODE: active"  onblur='quot_Del(this)' VALUE="<?php echo $banking?>">
						
		</FIELDSET>
	
		<!-- #################	 사업자정보 4.3 이후로 사용안함  ####################-->
		<FIELDSET style="display:none;">
			<LEGEND><?php echo af_txt_form_add_34;?></LEGEND>
				
						
						<P>
							<label for="tel" class="label"><?php echo af_txt_form_add_35;?></label>		
							<INPUT TYPE="text" NAME="tel" id="tel" STYLE="IME-MODE: disabled"  onblur='quot_Del(this)' VALUE="<?php echo $sup_tel?>">
						</P>
						
						<P>
							<label for="fax" class="label"><?php echo af_txt_form_add_36;?></label>		
							<INPUT TYPE="text" NAME="fax" id="fax" STYLE="IME-MODE: disabled"  onblur='quot_Del(this)' VALUE="<?php echo $sup_fax?>">							
						</P>

						<INPUT TYPE="hidden" NAME="supply_tel" id="supply_tel" VALUE="<?php echo $supply_tel?>">
					
						
						<P>
							<label for="supply_name" class="label"><?php echo af_txt_form_add_37;?></label>		
							<INPUT TYPE="text" NAME="supply_name" id="supply_name"STYLE="IME-MODE: active"  onblur='quot_Del(this)' VALUE="<?php echo $supply_name?>">
						</P>

						<P>
							<label for="supply_num" class="label"><?php echo af_txt_form_add_38;?></label>		
							<INPUT TYPE="text" NAME="supply_num" id="supply_num" STYLE="IME-MODE: disabled"  onblur='quot_Del(this)' VALUE="<?php echo $supply_num?>">
						</P>

						<P>
							<label for="supply_man" class="label"><?php echo af_txt_form_add_39;?></label>		
							<INPUT TYPE="text" NAME="supply_man" id="supply_man" STYLE="IME-MODE: active"  onblur='quot_Del(this)' VALUE="<?php echo $supply_man?>">
						</P>

						<P>
							<label for="supply_address" class="label"><?php echo af_txt_form_add_40;?></label>		
							<INPUT TYPE="text" NAME="supply_address" id="supply_address" STYLE="IME-MODE: active"  onblur='quot_Del(this)' VALUE="<?php echo $supply_address?>">
						</P>

						<P>
							<label for="supply_conditions" class="label"><?php echo af_txt_form_add_41;?></label>		
							<INPUT TYPE="text" NAME="supply_conditions" id="supply_conditions" style='IME-MODE: active' onblur='quot_Del(this)'  VALUE="<?php echo $supply_conditions?>">
						</P>

						<P>
							<label for="supply_item" class="label"><?php echo af_txt_form_add_42;?></label>		
							<INPUT TYPE="text" NAME="supply_item" id="supply_item" style='IME-MODE: active' onblur='quot_Del(this)'  VALUE="<?php echo $supply_item?>">
						</P>
						
						<P>
							<label for="sell_num" class="label">통신판매업신고번호</label>		
							<INPUT TYPE="text" NAME="sell_num" id="sell_num" onblur='quot_Del(this)'  VALUE="<?php echo $sell_num?>">
						</P>	
						
		</FIELDSET>	
		</FIELDSET>	
		</DIV>
		<?php if($_GET['mode']=="modify") {?>
			<div style="text-align:right;">
			<input type='button' value='modify' onclick="Mix(this.form);Mix_sms(this.form);Section(this.form);only_en(this.form.name,this.form.name.value);chk_email(this.form,this.form.email_address);" class="btn_set">
			</div>
		<?php }?>

		<!-- ////////////////////////// 	사용자스타일(pro)   //////////////////////-->
		<?php 
		$upload_path = "../upload/";
		$formStyle = f_get_af_formStyle($upload_path,$name);
		?>
		<DIV>
			<FIELDSET>
				<LEGEND>폼 스타일 설정 <input type="button" name="btn_formStyle" onclick="conf_style(this.form)" value='기본값입력/복구'></LEGEND>
				<p>
					폼메일과 주문폼의 주요스타일을 설정합니다. 위 기본값입력 버튼을 클릭하면, 기본적용된 스타일이 자동입력됩니다.<br>					
					<span style='color:red;'>스타일을 잘못 편집하여 폼출력에 문제가 있다면, 기본값으로 복구하면 됩니다.</span>
				</p>
				<P>
					<TEXTAREA NAME="formStyle" id="formStyle" STYLE="IME-MODE:inactive;width:100%;" rows="20"><?php echo $formStyle["formStyle"]?></TEXTAREA>
					<TEXTAREA NAME="formStyleOrign" id="formStyleOrign" STYLE="display:none" rows="20"><?php echo $formStyle["formStyleOrigin"]?></TEXTAREA>
				</P>		
			</FIELDSET>		
		</DIV>
		<?php if($_GET['mode']=="modify") {?>
			<div style="text-align:right;">
			<input type='button' value='modify' onclick="Mix(this.form);Mix_sms(this.form);Section(this.form);only_en(this.form.name,this.form.name.value);chk_email(this.form,this.form.email_address);" class="btn_set">
			</div>
		<?php }?>

		<!-- ////////////////////////// 	물품상세이미지등록   /////////////////////-->
		<div>
		<fieldset>
		<legend><?php echo af_txt_form_add_72;?> gif,jpg</legend>
			<P>
				<?php echo af_txt_form_add_75;?>
			</P>
		<!--	물품상세 이미지 start	-->
					
					<?php
					$limit = 10;
					for($x = 0; $x < $limit; $x++)
					{
					$upload_path = "../upload/";	

					$float_file = @file($upload_path.$name."/float.txt");			//float 속성 파일
					if($float_file[$x]) $af_float = $float_file[$x];
					else $af_float = "none";
					$chk_left = "";
					$chk_none = "";
					$chk_right = "";
					if($af_float == "left"."\n") $chk_left = "checked";
					if($af_float == "none"."\n") $chk_none = "checked";
					if($af_float == "none") $chk_none = "checked";
					if($af_float == "right"."\n") $chk_right = "checked";

					$af_detailTxt = f_get_af_detailTxt($upload_path,$name,$x);		//이미지 설명글 텍스트 파일에서 메모가져옴
					
					
																					//파일찾기	
							echo "<table class='noborder'>";
							echo "<tr>";
								echo "<td colspan='2' style='text-align:left;width:250px;'>";
								echo "<input type='file' name='detail_imgs[]' style='height:20px;'>";
								echo "</td>";
								echo "<td rowspan='2' style='text-align:left;width:100%'>";
																						//설명글(아래 for 문 안에는 넣지말것)
								echo "<textarea name='detail_memo[]' rows='6' style='vertical-align:middle;width:100%;' class='tag'>".htmlspecialchars(stripslashes($af_detailTxt['detail_memo']))."</textarea>";
																						//체크하였을 때 값입력될 히든필드(아래 for 문 안에는 넣지말것)
								echo "<input type='hidden' id='detailDel".$x."' name='detailDel[]' value='0'>";
																						//라디오버튼 체크시 값입력될 히든필드(아래 for 문 안에는 넣지말것)	
																						//type='hidden' 으로 하니 에러나서 style='visibility:hidden'로 감춤(배포본4.2에는 적용안했음)
								echo "<input type='text' id='float".$x."' name='float[]' value='".$af_float."' style='visibility:hidden'>";
								

								echo "</td>";
							echo "</tr>";
							echo "<tr>";
								echo "<td>";
							#####	업로드 된 이미지가 있을 경우 이미지+설명글+삭제박스+이미지사이즈 출력		
							for($i=0; $i < count($af_arr_format);$i++)
								{
								if(file_exists($upload_path.$name."/".$x.".".$af_arr_format[$i].""))
									{							
									echo "<img src='../upload/".$name."/".$x.".".$af_arr_format[$i]."' style='vertical-align:middle;width:70px;height:50px;border:1px solid #000;cursor:hand;' alt='detail img' onclick=\"pop_img('../upload/".$name."/".$x.".".$af_arr_format[$i]."')\">";	
									echo "</td>";
									echo "<td>";
									echo "<input type='checkbox' name='detailChk[]' onclick='eq_detailDel(this,".$x.")'>".af_txt_form_add_66."";					
									echo "<span style='color:#666666;font-size:0.9em;'> [".number_format(filesize("../upload/".$name."/".$x.".".$af_arr_format[$i]."")/1024,2)."KB]</span><br>";
									echo "<input type='radio' name='align$x' value='left' onclick='document.getElementById(\"float$x\").value=this.value;' ".$chk_left."><img src='img/float_left.gif' style='vertical-align:middle;'>";	
									echo "<input type='radio' name='align$x' value='none' onclick='document.getElementById(\"float$x\").value=this.value;' ".$chk_none."><img src='img/float_none.gif' style='vertical-align:middle;'>";
									echo "<input type='radio' name='align$x' value='right' onclick='document.getElementById(\"float$x\").value=this.value;' ".$chk_right."><img src='img/float_right.gif' style='vertical-align:middle;'>";

									}
								}
							
							
								echo "</td>";
							echo "</tr><tr><td colspan='2'><hr></td></tr></table>";
					}
					?>
		<!--	물품상세 이미지 end	-->
		</fieldset>
		</div>
		<?php if($_GET['mode']=="modify") {?>
			<div style="text-align:right;">
			<input type='button' value='modify' onclick="Mix(this.form);Mix_sms(this.form);Section(this.form);only_en(this.form.name,this.form.name.value);chk_email(this.form,this.form.email_address);" class="btn_set">
			</div>
		<?php }?>

		<!-- ////////////////////////// 	화면표시문구설정   ///////////////////////-->
		<div>
		<fieldset id="display_txt">
		<legend>화면표시 문구정의</legend>
			<P>
				아래에서 여분필드외에는, 각 입력란을 빈란으로 두어도, 기본문구가 자동으로 표시됩니다. 편집이 필요할 경우엔 수정하세요.<br>
				여분 필드는, 개발될 상위버전에서 사용할, 추후 확장을 위한 필드이므로, 입력하지 마세요.
			</P>
			<table>
				<tr>
					<td colspan="2" class="thead">
						폼메일 화면표시 문구
					</td>
				</tr>
				<tr>
					<td class="item">
						전송하기 버튼문구
					</td>
					<td class="val">
						<input type="text" name="formmail_txts" value="<?php if($arr_dummy13[0]) echo $arr_dummy13[0]; else echo af_txt_view_addform_skin_12;?>" onblur='quot_Del(this);'>
					</td>
				</tr>
				<tr>
					<td class="item">
						파일첨부 표시문구 
					</td>
					<td class="val">
						<input type="text" name="formmail_txts" value="<?php if($arr_dummy13[1]) echo $arr_dummy13[1]; else echo af_txt_view_addform_skin_8;?>" onblur='quot_Del(this);'>
					</td>
				</tr>
				<tr>
					<td class="item">
						합계금액 문구
					</td>
					<td class="val">
						<input type="text" name="formmail_txts" value="<?php if($arr_dummy13[2]) echo $arr_dummy13[2]; else echo "합계금액";?>" onblur='quot_Del(this);'>
					</td>
				</tr>
				<tr>
					<td class="item">
						다시작성 버튼문구
					</td>
					<td class="val">
						<input type="text" name="formmail_txts" value="<?php if($arr_dummy13[3]) echo $arr_dummy13[3]; else echo "다시작성";?>" onblur='quot_Del(this);'>
					</td>
				</tr>
				<tr>
					<td class="item">
						여분
					</td>
					<td class="val">
						<input type="text" name="formmail_txts" value="<?php echo $arr_dummy13[4];?>" onblur='quot_Del(this);'>
					</td>
				</tr>
				<tr>
					<td class="item">
						여분
					</td>
					<td class="val">
						<input type="text" name="formmail_txts" value="<?php echo $arr_dummy13[5];?>" onblur='quot_Del(this);'>
					</td>
				</tr>
				<tr>
					<td class="item">
						여분
					</td>
					<td class="val">
						<input type="text" name="formmail_txts" value="<?php echo $arr_dummy13[6];?>" onblur='quot_Del(this);'>
					</td>
				</tr>
				<tr>
					<td class="item">
						여분
					</td>
					<td class="val">
						<input type="text" name="formmail_txts" value="<?php echo $arr_dummy13[7];?>" onblur='quot_Del(this);'>
					</td>
				</tr>
				<tr>
					<td class="item">
						여분
					</td>
					<td class="val">
						<input type="text" name="formmail_txts" value="<?php echo $arr_dummy13[8];?>" onblur='quot_Del(this);'>
					</td>
				</tr>
				<tr>
					<td class="item">
						여분
					</td>
					<td class="val">
						<input type="text" name="formmail_txts" value="<?php echo $arr_dummy13[9];?>" onblur='quot_Del(this);'>
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td colspan="2" class="thead">
						주문폼 화면표시 문구
					</td>
				</tr>
				<tr>
					<td class="item">
						주문하기 버튼문구
					</td>
					<td class="val">				
						<input type="text" name="orderform_txts" value="<?php if($arr_dummy14[0]) echo $arr_dummy14[0]; else echo af_txt_view_addform_skin_11;?>" onblur='quot_Del(this);'>
					</td>
				</tr>
				<tr>
					<td class="item">
						견적보기 버튼문구
					</td>
					<td class="val">
						<input type="text" name="orderform_txts" value="<?php if($arr_dummy14[1]) echo $arr_dummy14[1]; else echo af_txt_view_addform_skin_10;?>" onblur='quot_Del(this);'>
					</td>
				</tr>
				<tr>
					<td class="item">
						subtotal(소계) 문구
					</td>
					<td class="val">
						<input type="text" name="orderform_txts" value="<?php if($arr_dummy14[2]) echo $arr_dummy14[2]; else echo "Subtotal";?>" onblur='quot_Del(this);'>
					</td>
				</tr>
				<tr>
					<td class="item">
						TOTOL(합계) 문구
					</td>
					<td class="val">
						<input type="text" name="orderform_txts" value="<?php if($arr_dummy14[3]) echo $arr_dummy14[3]; else echo "TOTAL";?>" onblur='quot_Del(this);'>
					</td>
				</tr>
				<tr>
					<td class="item">
						구매자 문구
					</td>
					<td class="val">
						<input type="text" name="orderform_txts" value="<?php if($arr_dummy14[4]) echo $arr_dummy14[4]; else echo af_txt_view_addform_skin_1;?>" onblur='quot_Del(this);'>
					</td>
				</tr>
				<tr>
					<td class="item">
						수취인 문구
					</td>
					<td class="val">
						<input type="text" name="orderform_txts" value="<?php if($arr_dummy14[5]) echo $arr_dummy14[5]; else echo af_txt_view_addform_skin_2;?>" onblur='quot_Del(this);'>
					</td>
				</tr>
				<tr>
					<td class="item">
						구매자와동일 문구
					</td>
					<td class="val">
						<input type="text" name="orderform_txts" value="<?php if($arr_dummy14[6]) echo $arr_dummy14[6]; else echo af_txt_view_addform_skin_3;?>" onblur='quot_Del(this);'>
					</td>
				</tr>
				<tr>
					<td class="item">
						여분
					</td>
					<td class="val">
						<input type="text" name="orderform_txts" value="<?php echo $arr_dummy14[7];?>" onblur='quot_Del(this);'>
					</td>
				</tr>
				<tr>
					<td class="item">
						여분
					</td>
					<td class="val">
						<input type="text" name="orderform_txts" value="<?php echo $arr_dummy14[8];?>" onblur='quot_Del(this);'>
					</td>
				</tr>
				<tr>
					<td class="item">
						여분
					</td>
					<td class="val">
						<input type="text" name="orderform_txts" value="<?php echo $arr_dummy14[9];?>" onblur='quot_Del(this);'>
					</td>
				</tr>
			</table>

		</fieldset>
		<input type="hidden" name="dummy13" value="<?php echo $dummy13;?>">
		<input type="hidden" name="dummy14" value="<?php echo $dummy14;?>">
		</div>



		<div style="text-align:center">
			<!-- 수정,추가 버튼 -->
			<input type='button' <?php if($_GET['mode']=="modify") echo "value='수정하기'"; else echo "value='".af_txt_form_add_43."'";?> id="addBtn" onclick="Mix(this.form);Mix_sms(this.form);Section(this.form);only_en(this.form.name,this.form.name.value);chk_email(this.form,this.form.email_address);" class="btn_set">
			<!-- 폼보기,항목설정 버튼 -->
			<?php if($_GET['mode']=="modify") {?>
			<input type='button' value='<?php echo af_txt_add_items_50;?>' onclick="javascript:void(window.open('../view_addform.php?fname=<?php echo $name;?>','popup_view2',''))" class="btn_set">
			<input type='button' value='<?php echo af_txt_set_item;?>' onClick="location.href='add_items.php?fname=<?php echo $name;?>&amp;form_type=<?php echo $form_type;?>&amp;no=<?php echo $no;?>'" class='btn_set'>
			<?}?>

		</div>					
</FORM>
	
		<!-- /////////////////////////////////		안내팁    ////////////////////////////-->		
	<DIV class="sms_wrapper">
	<FIELDSET>
		<LEGEND>사용하기전에...</LEGEND>
		<p>아래와 같은 원인으로, 고객접수시 고객과 관리자에게 발송되는 확인 메일수신이 지연되거나 일시적, 간헐적, 영구적인 장애가 있을 수 있습니다.</p>
		<P style="font-size:11px;background-color:#e5c4c4;padding:10px;">
			* 보내는 메일서버의 메일데몬이 sendmail 이 아닐 경우<br>
			* 사용중인 호스팅의 보내는메일서버가 KISA(한국정보보호진흥원) 또는, 각 메일포털의 받는메일서버에 불량리스트(스팸)로 등재된 경우<br>	
			* KISA(한국정보보호진흥원)에 화이트도메인으로 등록한 후, 폼메일의 보내는이의 메일주소가 발송서버의 도메인과 일치하지 않을 때<br>
			* 공유 호스팅환경에서 어느특정업체의 다량의 메일발송으로, 일시적 메일서버 과부하가 있는 경우<br>
			* 보내는 메일서버 또는, 받는 메일서버의 장애나 트래픽폭주/과다로, 메일송수신에 지연이나 장애가 발생한 경우<br>
			* 메일포털과 수신자가 특정메시지의 제목과 내용을 담은 메일을 수신거부 설정해 놓은 경우<br>
			* 이용중인 웹호스팅 환경에서, 일일 메일전송횟수 제한이 있고, 초과된 경우<br>
			* 기타 받는메일서버측의 각기 다른 스팸강화정책으로 정상적인 메일발송이 수신거부될 수 있습니다.
			
		</P>
		<p>위와 같은 요인들로, 고객접수시 확인차원에서 발송되는 메일이 발송되지 않거나, 수신되지 않을 수 있으므로, 아래와 같이 사용합니다.</p>
		<P style="font-size:11px;background-color:#b8cadc;padding:10px;">
			* 폼메일접수시 확인메일송수신의 지연이나 수신거부는, 프로그램에서 해결할수없으므로, 되도록 애드폼관리자모드에서 확인하고 관리합니다.<br>
			* 고객접수내역을 놓치지 않고 실시간으로 인지하려면, 개별폼의 수정하기에서 SMS(단문문자메시지전송)을 연동시킵니다.<br>
			* 확인메일 수신에 장애가 감지된다면, 전체폼기본환경설정에서 첨부파일 저장타겟을 서버에저장으로 선택하여, 첨부파일을 놓치지 않도록 합니다.			
		</P>
	</FIELDSET>
	</DIV>

</div>
</DIV>
</BODY>

</HTML>
