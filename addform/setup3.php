<?php
include_once("function/f_yagoseng_hetda.php");

/*--------------------------------------------------------------------------------------*/
/*						설치 적합성 검사												*/
/*--------------------------------------------------------------------------------------*/
############	폼에서 넘어온 db 계정 값이 맞는지 검사						#############
$sock_test=mysql_connect($_POST['db_hostname'],$_POST['db_username'],$_POST['db_password']) or die("<meta http-equiv='content-type' content='text/html; charset=utf-8'>데이타베이스 연결에 실패했습니다");
$db_test = mysql_select_db($_POST['dbname'],$sock_test) or die("<meta http-equiv='content-type' content='text/html; charset=utf-8'>데이타베이스 연결에 실패했습니다");

############	이전에 생성된 db_ini.php가 있을 경우 변조를 방지하기 위한...#############
if ( file_exists("lib/db_ini.php") ) 
    { 
        die("<meta http-equiv='content-type' content='text/html; charset=utf-8'><DIV><H1>설치실패!</H1><P style='color:#ff6600'>이미 애드폼이 설치되어 있습니다.</P><DIV><H1>Failure!</H1><P style='color:#ff6600'>addform already exists.</P>"); // exists 
    }  
############이미 생성된 테이블 있을 경우 설치 불가(사용자정의테이블명_admine_table 만 검사) #############
$addform_list = mysql_query("show table status from ".$_POST['dbname']." like '".$_POST['db_tblname']."_af%'") or error("애드폼 설치에 실패하였습니다.");
$tables=mysql_num_rows($addform_list);
	
	if($tables >= 1){
die("
<DIV><H1>애드폼 설치 실패</H1><P style='color:#ff6600'>이미 ".$_POST['db_tblname']." 로 시작하는 테이블이 DB에 존재하여 설치를 할 수 없습니다.</P><P>앞 과정으로 돌아가서 테이블 이름을 변경한 후, 다시 시도해보세요.</P></DIV>
");
	}	


/*--------------------------------------------------------------------------------------*/
/*						파일 및 폴더 생성												*/
/*--------------------------------------------------------------------------------------*/
#################################	초기 설치 정보 파일 생성	##########################
$initial_lib  = "<?php"."\n";
$initial_lib .="define(\"setup_date\",\"".time()."\");"."\n";
$initial_lib .= "?>";

$connect_file = fopen("lib/initial_lib.php", "w") or die("<meta http-equiv='content-type' content='text/html; charset=utf-8'>lib 폴더 퍼미션을 707 이상으로 설정해 주세요");
fwrite($connect_file, $initial_lib);
fclose($connect_file);

##########################	db_ini.php 파일 생성 ########################################
$db_ini  = "<?php"."\n";
$db_ini .= "$"."db_hostname=\"".$_POST['db_hostname']."\";"."\n";
$db_ini .= "$"."dbname=\"".$_POST['dbname']."\";"."\n";
$db_ini .= "$"."db_username=\"".$_POST['db_username']."\";"."\n";
$db_ini .= "$"."db_password=\"".$_POST['db_password']."\";"."\n";
$db_ini .= "?>";

$connect_file = fopen("lib/db_ini.php", "w") or die("파일 읽기에 실패하였습니다.");
fwrite($connect_file, $db_ini);
fclose($connect_file);

##########################	db_tblname.php 파일 생성 ########################################
$db_tblname  = "<?php"."\n";
$db_tblname .= "define(\"db_tblname\",\"".$_POST['db_tblname']."_af\");"."\n";
$db_tblname .= "?>";

$connect_file = fopen("lib/db_tblname.php", "w") or die("파일 읽기에 실패하였습니다.");
fwrite($connect_file, $db_tblname);
fclose($connect_file);

###########################  upload 폴더 생성 ###########################################
if(!is_dir("upload")){
	mkdir("upload", 0707);
	chmod("upload", 0707);
}


include_once("lib/lib.php");
?>


<?php
/*--------------------------------------------------------------------------------------*/
/*						DB 셋팅															*/
/*--------------------------------------------------------------------------------------*/
include_once("lib/C_CONNECT.php");		//DB 입출력 class 파일
include_once("lib/define_table.php");	
include_once("lib/addform_scheme.php");	//초기 DB 테이블 구조


										//실행할 sql 을 배열
$arr=array(
	$create_addform_admine,
	$create_addform_group,
	$create_addform,
	$create_addform_env,
	$add_admine,
	$add_group1,
	$add_group2,

	$add_addform1,
	$create_addform_item1,
	$add_addform2,
	$create_addform_item2,	

	$add_env,
	$create_addform_order,
	
	$create_addform_layout,
	$add_layout
	);
	
echo ("
	<!DOCTYPE html PUBLIC '-//W3C//DTD HTML 4.01//EN'   'http://www.w3.org/TR/html4/strict.dtd'>
	<HTML>
	<HEAD>
	<meta http-equiv='content-type' content='text/html; charset=utf-8'>
	<meta name='robots' content='none,noindex,nofollow'>
	<title>애드폼 설치</title>
	<LINK REL='stylesheet' HREF='style_setup.css' TYPE='text/css'>
	</head>
	<body style='background: url(imgs/box.jpg);background-repeat:no-repeat;background-position:center center;'>
	");
echo "<div style='width:300px;height:300px;position:absolute;top:50%;left:50%;margin-left:-150px;margin-top:-150px;'>";
	echo "<table style='width:100%;border:1px solid #999;margin-top:100px;'>
			<tr>				
	 ";
for($i=0;$i<count($arr);$i++)
	{
		echo "<td id='progres_td$i' style='background-color:#ccc;height:30px;width:10px;'></td>";
	}
	echo "</tr></table>";
echo "</div>";
echo "</body></html>";
f_yagoseng_hetda($arr);					//sql 실행
?>

<?
$DBconn=new C_CONNECT;					//$DBconn로 C_CONNECT 클래스 객체를 생성하여 C_CONNECT 클래스의 함수와 변수에 접근

										//초기기본폼 TestForm에 딸린 품목/옵션생성을 위한 2차원 배열

  $arr2=array(array(1, '고객구분', '0', '옵션|개인ⓘ단체|0,0|1|2', '개', 0, 0, 0, '', '', '', '', '3', '', 'yes', '', '0', '', '', '<img src="http://www.addform.net/images/01.gif">', ''),  
		array(2, '신청이력', '0', '옵션|신규접수ⓘ재접수|0,0|0|2', '개', 0, 0, 0, '', '', '', '', '3', '', 'yes', '', '0', '', '', '', ''),
		array(3, '여행사선택', '0', '여행사|별나라 우주여행사 1,000,000원ⓘ빛처럼빠른 여행사 2,000,000원ⓘ묻지마 우주관광 3,000,000원|1000000,2000000,3000000|1|0', '개', 1, 0, 0, '', '', '', '', '3', '', '', '1', '0', '<span style="color:red;font-size:11px;">여행사 사정에 따라, 일정이 변경될 수 있습니다.</span> ', '', '<img src="http://www.addform.net/images/03.gif">', ''),
		array(4, '우주선선택', '0', '우주선|은하철도999 1,000,000원ⓘ블랙펄호 2,000,000원ⓘ초광속엔터프라이즈 3,000,000원|1000000,2000000,3000000|0|0', '개', 0, 0, 0, '', '은하철도999', '', '', '3', '', '', '', '0', '<br>메텔과 함께, 영원한 생명을 얻는 여행을 원하신다면, 은하철도 999를 선택하십시오. ', '', '', ''),
		array(5, '행성선택', '0', '행성|수성 5,000원ⓘ금성 10,000원ⓘ화성 15,000원ⓘ목성 20,000원ⓘ토성 25,000원ⓘ천왕성 30,000원|5000,10000,15000,20000,25000,30000|1|2', '개', 1, 0, 0, '', '', '', '', '3', '', '', '', '0', '', '', '', ''),
		array(6, '부가서비스', '0', '서비스|프레쉬워터무한리필 3,000원ⓘ전용샤워시설 5,000원ⓘ다이렉트태양열썬텐 7,000원ⓘ조종석1일체험 9,000원|3000,5000,7000,9000|0|1', '개', 0, 0, 0, '', '', '', '', '3', '', '', '', '0', '', '', '<img src="imgs/ex-itemTip1.gif">', ''),
		array(7, '인솔자성명', '0', '', '개', 0, 0, 0, '', '', '', '', '3', '', '', '', '0', '미성년자 대동시엔 인솔자가 반드시 필요합니다. ', '', '', ''),
		array(8, '인솔자연락처', '0', '', '개', 0, 0, 0, '', '', '', '', '11', '', '', '', '0', '', '', '', ''),
		array(9, '좌석', '0', '좌석|특등석 50,000원ⓘ1등급실 40,000원ⓘ2등급실 30,000원ⓘ3등급실 20,000원|50000,40000,30000,20000|0|0', '개', 0, 0, 0, '', '1등급실', '', '', '3', '', 'yes', '', '0', '', '', '', ''),
		array(10, '음식', '0', '음식|한식ⓘ중식ⓘ양식ⓘ뷔페|0,0,0,0|0|0', '개', 0, 0, 0, '', '한식', '', '', '3', '', 'yes', '', '0', '', '', '', ''),
		array(11, '태양계시민코드', '0', '', '개', 0, 2, 0, '', '', '', '3', '10', '', '', '', '0', '', '', '<img src="http://www.addform.net/images/04.gif">', ''),
		array(12, '소지품사전신고', '0', '소지품|희망소지품1ⓘ희망소지품2ⓘ희망소지품3|0,0,0|0|3', '개', 0, 0, 0, '', '', '', '', '3', '', '', '', '0', '', '', '', ''),
		array(13, '여행기간', '0', '', '개', 0, 0, 0, '', '', '', '', '6', '', '', '', '0', '', '', '', ''),
		array(14, '우편물수령주소', '0', '', '개', 0, 0, 0, '', '', '', '100', '13', '', '', '', '0', '', '', '', ''),
		array(15, '요구사항', '0', '', '개', 0, 0, 0, '우주법상 금지되어 있는 요구는 할 수 없습니다. ', '', '', '5', '4', '', '', '', '0', '', '', '', ''),
		array(16, '약관동의', '0', '옵션|약관에 동의합니다.|0|1|1', '개', 0, 0, 0, '', '', '', '', '3', '', '', '', '0', '', '', '여행약관<br><textarea name="row" rows="5" style="width:100%;color:gray;font-size:11px;">보기의 아래와 같이, 해당폼의 품목설정에서 약관동의라는 항목을 하나 추가한 후, 옵션을 체크박스로 하고 필수로 선택하게 하면, 이용약관등을 만들 수 도 있습니다. 기본적인 html 태그만 활용할 줄 안다면, 원하는 형식의 다양한 폼메일을 만들 수 있습니다. php 와 자바스크립트 같은 스크립트는 잘 모르더라도, 기초적인 html 태그를 알고 있다면, 애드폼과 애드폼 프로그램 사용자는, 하나가 되어, 최상의 방법으로 프로그램을 운용할 수 있습니다. </textarea>', '')
			  ); 

  $arr3=array(array(1, '테스트 품목1', '5000', '', '개', 0, 0, 0, NULL, NULL, 0, '', '3', '', '', '', '0', '', NULL, NULL, NULL),  
			  array(2, '테스트 품목2', '2500', '', '박스', 0, 0, 0, NULL, NULL, 0, '', '3', '', '', '', '0', '', NULL, NULL, NULL),
			  array(3, '테스트 품목3', '3000', '옵션|옵션항목1ⓘ옵션항목2ⓘ옵션항목3|2000,3000,4000|1|0', '장', 0, 0, 0, NULL, NULL, 0, '', '3', '', '', '', '0', '', NULL, NULL, NULL),
			  array(4, '테스트 품목4', '5000', '', '대', 0, 0, 0, NULL, NULL, 0, '', '3', '', '', '', '0', '', NULL, NULL, NULL),
			  array(5, '테스트 품목5', '10000', '', '개', 0, 0, 0, NULL, NULL, 0, '', '3', '', '', '', '0', '', NULL, NULL, NULL),
			  array(6, '테스트 품목6', '15000', '', 'SET', 0, 0, 0, NULL, NULL, 0, '', '3', 'yes', '', '', '0', '', NULL, NULL, NULL),
			  array(7, '테스트 품목7', '25000', '', 'PCS', 0, 0, 0, NULL, NULL, 0, '', '3', '', '', '', '0', '', NULL, NULL, NULL)			  	
			  );

  $arr4=array("lang"=>$_POST['lang']);
			

																   //DB 입력f_InsertDBMulti(테이블이름,"필드1,필드2,필드3...",&$array)
																   //$array배열을 참조연산자로 넘겨주어 보다 빠르게 처리
    $DBconn->f_InsertDBMulti("".db_tblname."_TestForm1_item","code,name_it,price,opt,unit,chk_input,chk_filter,chk_etc,default_text,default_opt,discount,dummy1,dummy2,dummy3,dummy4,dummy5,dummy6,dummy7,dummy8,dummy9,dummy10",&$arr2);
	$DBconn->f_InsertDBMulti("".db_tblname."_TestForm2_item","code,name_it,price,opt,unit,chk_input,chk_filter,chk_etc,default_text,default_opt,discount,dummy1,dummy2,dummy3,dummy4,dummy5,dummy6,dummy7,dummy8,dummy9,dummy10",&$arr3);

	$DBconn->f_updateDB("".db_tblname."_env",$arr4,"where no=1");		   //언어셋팅


/*--------------------------------------------------------------------------------------*/
/*						완료 후 이동													*/
/*--------------------------------------------------------------------------------------*/
die("
<script type='text/javascript'>document.location.href='zipcode/zipcode.php'</script>
");
?>
