<?
/* ----------------------------------------------------------------------------------- */
/*	프로그램명 : 애드폼(영문 addform												   */									
/*	프로그램용도: 견적서 주문서 폼메일 제작											   */
/*	제작자: 박성규																	   */
/*	공식배포처: http://www.addform.net												   */
/*  프로그램 편집시 위 제작자 정보를 편집하거나 삭제해서는 안됩니다.				   */
/* ----------------------------------------------------------------------------------- */

/*
초기셋업 테이블 구조
	1 DB 8 Table
	테이블 설명
	    사용자정의_admine_table		(애드폼 관리자 테이블)
		사용자정의_group_table		(애드폼 그룹 테이블)
		사용자정의_table			(폼 테이블)			
		사용자정의_env				(통합 환경설정 테이블)
		사용자정의_order_table		(주문서관리 테이블)
		사용자정의_$name_item		(각 폼의 품목 테이블)
		사용자정의_layout			(레이아웃편집 테이블)
		사용자정의_zipcode			(우편번호검색 테이블)
*/

$reg_date=time();                                                // 초단위의 타임스탬프 값

///////이 페이지에 사용된 주요 변수///////////////////////////////////////////////////////////////////////////////////////
$addform_admine	= "".db_tblname."_admine_table";	             //애드폼 관리자 테이블
$addform_group	= "".db_tblname."_group_table";	                 //애드폼 그룹테이블

$addform	= "".db_tblname."_table";	                         //애드폼 추가 테이블

$name1 = "TestForm1";											 //초기 자동생성되는 연습용폼의 폼이름
$name2 = "TestForm2";											 //초기 자동생성되는 연습용폼의 폼이름

$addform_item1	= "".db_tblname."_".$name1."_item";				 //해당 애드폼의 품목 테이블 이름																
$addform_item2	= "".db_tblname."_".$name2."_item";				 //해당 애드폼의 품목 테이블 이름

$addform_env	= "".db_tblname."_env";							 //애드폼 사용자설정 환경 테이블
$addform_order	= "".db_tblname."_order_table";					 //접수내역 관리 테이블
$addform_layout	= "".db_tblname."_layout";						 //레이아웃 테이블

$addform_zipcode	= "".db_tblname."_zipcode";					 //우편번호 테이블(090331추가)

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


#######################################################################################
#############################	start addform scheme	###############################
#######################################################################################

//관리자 테이블 생성
$create_addform_admine="
	CREATE TABLE IF NOT EXISTS $addform_admine(
	no INT(11) NOT NULL AUTO_INCREMENT ,
	level INT(11) NOT NULL DEFAULT 10,
	user_id VARCHAR(255) DEFAULT NULL,
	password  VARCHAR(255) DEFAULT NULL,
	name VARCHAR(255) DEFAULT NULL,
	email_address VARCHAR(255) DEFAULT NULL,
	tel VARCHAR(255) DEFAULT NULL,
	hp TEXT,
	fax TEXT,
	supply_name VARCHAR(255) DEFAULT NULL,
	supply_num VARCHAR(255) DEFAULT NULL,
	supply_man VARCHAR(255) DEFAULT NULL,
	supply_address VARCHAR(255) DEFAULT NULL,
	supply_conditions VARCHAR(255) DEFAULT NULL,
	supply_item VARCHAR(255) DEFAULT NULL,
	sell_num TEXT, 
	banking VARCHAR(255) DEFAULT NULL,
	join_date VARCHAR(255) DEFAULT NULL,
	edit_date VARCHAR(255) DEFAULT NULL,
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
	KEY user_id(user_id),
	KEY name(name)
	)$af_charset";



//애드폼 그룹테이블 생성
$create_addform_group="
	CREATE TABLE IF NOT EXISTS $addform_group(
	no INT(11) NOT NULL AUTO_INCREMENT ,	
	name VARCHAR(255) DEFAULT NULL,
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
	KEY name(name)
	)$af_charset";

//애드폼 테이블 생성
$create_addform="
	CREATE TABLE IF NOT EXISTS $addform(
	no INT(11) NOT NULL AUTO_INCREMENT ,
	no_group INT(11) NOT NULL DEFAULT 1,
	form_type TINYINT DEFAULT 0,
	input_date VARCHAR(255) DEFAULT NULL,
	edit_date VARCHAR(255) DEFAULT NULL,
	name VARCHAR(255) DEFAULT NULL,	
	title_text VARCHAR(255) DEFAULT NULL,
	msg_top TEXT,
	msg_bottom TEXT,
	top_img VARCHAR(255) DEFAULT NULL,
	bottom_img VARCHAR(255) DEFAULT NULL,
	width VARCHAR(255) DEFAULT NULL,
	coin_unit VARCHAR(255) DEFAULT NULL,
	secret_price TINYINT DEFAULT 1,	
	email_address VARCHAR(255) DEFAULT NULL,
	tel VARCHAR(255) DEFAULT NULL,
	supply_name VARCHAR(255) DEFAULT NULL,
	supply_num VARCHAR(255) DEFAULT NULL,
	supply_man VARCHAR(255) DEFAULT NULL,
	supply_address VARCHAR(255) DEFAULT NULL,
	supply_conditions VARCHAR(255) DEFAULT NULL,
	supply_item VARCHAR(255) DEFAULT NULL,
	sell_num TEXT,
	skin_name VARCHAR(255) DEFAULT NULL,	
	use_report_email TINYINT(1) DEFAULT 1,
	banking VARCHAR(255) DEFAULT NULL,
	count_field INT(11) DEFAULT 0,
	etc VARCHAR(255) DEFAULT NULL,
	max_file_size TEXT,
	attachFormat TEXT,
	client_items TEXT,
	client_text_name TEXT,
	client_text_email TEXT,
	client_text_hp TEXT,
	client_text_tel TEXT,
	client_text_fax TEXT,
	client_text_address TEXT,
	client_text_memo TEXT,
	sign_img TEXT,
	font_family TEXT,
	font_size TEXT,
	font_color TEXT,
	layout TEXT,
	return_url TEXT,
	return_type TEXT,
	yesorno_pay TEXT,
	res_name TEXT,
	res_mny TEXT,
	res_dummy1 TEXT,
	res_dummy2 TEXT,
	res_dummy3 TEXT,
	site_cd TEXT,
	site_key TEXT,
	quotaopt TEXT,
	sms_msg TEXT,
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
	KEY name(name)
	)$af_charset";

//초기연습용폼 품목 테이블 생성1
$create_addform_item1="
	CREATE TABLE IF NOT EXISTS $addform_item1(
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

//초기연습용폼  품목 테이블 생성2
$create_addform_item2="
	CREATE TABLE IF NOT EXISTS $addform_item2(
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


//애드폼 사용자설정 환경 테이블 생성
$create_addform_env="
	CREATE TABLE IF NOT EXISTS $addform_env(
	no INT(11) NOT NULL AUTO_INCREMENT ,
	lang VARCHAR(255) DEFAULT NULL,
	od_unit VARCHAR(255) DEFAULT NULL,
	coin_unit VARCHAR(255) DEFAULT NULL,
	upload_space TEXT,
	upload_space_per TEXT,
	upload_use_alert TEXT,
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
	KEY lang(lang)	
	)$af_charset";

//주문데이타 관리 테이블 생성
$create_addform_order="
	CREATE TABLE IF NOT EXISTS $addform_order(
	no INT(11) NOT NULL AUTO_INCREMENT ,
	af_order_no TEXT,
	mom VARCHAR(255) DEFAULT NULL,
	client_name VARCHAR(255) DEFAULT NULL,
	client_tel VARCHAR(255) DEFAULT NULL,
	client_hp  VARCHAR(255) DEFAULT NULL,
	client_fax VARCHAR(255) DEFAULT NULL,
	client_email  VARCHAR(255) DEFAULT NULL,
	client_address  VARCHAR(255) DEFAULT NULL,
	client_memo TEXT,
	
	supply_name VARCHAR(255) DEFAULT NULL,
	supply_num VARCHAR(255) DEFAULT NULL,
	supply_man VARCHAR(255) DEFAULT NULL,
	supply_address VARCHAR(255) DEFAULT NULL,
	supply_conditions VARCHAR(255) DEFAULT NULL,
	supply_item VARCHAR(255) DEFAULT NULL,
	supply_memo TEXT,

	hostinfo VARCHAR(255) DEFAULT NULL,
	
	input_date VARCHAR(255) DEFAULT NULL,
	edit_date VARCHAR(255) DEFAULT NULL,

	select_items TEXT,
	sum VARCHAR(255) DEFAULT NULL,
	situation INT(11) DEFAULT 1,

	tno TEXT,
	pay_cancel TEXT,

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
	KEY client_name(client_name),
	KEY client_tel(client_tel),
	KEY client_email(client_email)	
	)$af_charset";

//레이아웃 테이블 생성
$create_addform_layout="
	CREATE TABLE IF NOT EXISTS $addform_layout(
	no INT(11) NOT NULL AUTO_INCREMENT ,
	logo_link TEXT,
	yn_topmenu TEXT,
	yn_top_custom TEXT,
	topmenu_idx TEXT,
	top_custom TEXT,

	left_width TEXT,
	left_wUnit TEXT,
	yn_leftmenu TEXT,
	yn_thumblist TEXT,	
	yn_lastest TEXT,
	yn_best TEXT,
	yn_tel TEXT,
	yn_bank TEXT,
	yn_left_custom TEXT,
	leftmenu_idx TEXT,
	thumb_width TEXT,
	thumb_height TEXT,
	lastestN TEXT,
	bestN TEXT,
	left_custom TEXT,

	right_width TEXT,
	right_wUnit TEXT,
	yn_dokdo TEXT,
	yn_lastestR TEXT,
	yn_bestR TEXT,
	yn_right_custom TEXT,
	lastestRN TEXT,
	bestRN TEXT,
	right_custom TEXT,

	yn_companydata TEXT,
	yn_footer_custom TEXT,
	footer_custom TEXT,

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
	
	PRIMARY KEY (no)		
	)$af_charset";

//우편번호 검색 테이블 생성
$create_addform_zipcode="
	CREATE TABLE IF NOT EXISTS $addform_zipcode(
	no INT(11) NOT NULL AUTO_INCREMENT ,
	zipcode TEXT,
	sido TEXT,
	gugun TEXT,
	dong TEXT,
	ri TEXT,
	bldg TEXT,
	bunji TEXT,
	seq INT(11),
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
	
	PRIMARY KEY (no),
	KEY seq(seq)	
	)$af_charset";

#######################################################################################
###############################		end addform scheme  ###############################
#######################################################################################



#######################################################################################
#####################	각 테이블 초기 레코드 생성 start	###########################
#######################################################################################
//관리자 정보 생성
$add_admine="
	insert into $addform_admine(
		level,
		user_id,
		password,  
		name,
		email_address,
		tel,
		supply_name,
		supply_num,
		supply_man,
		supply_address,
		supply_conditions,
		supply_item,
		banking,
		join_date,
		edit_date
	) values(	
		'1',
		'addform',
		MD5('1111'),
		'홍길동',
		'',
		'555-555-5555',
		'대박날우리회사',
		'xxx-xxx-xxxx',
		'박대박',
		'서울특별시 중구 태평로 1가 1번지 1F 101호',
		'서비스',
		'온라인정보제공',
		'국민은행|777777-77-777777|홍길동',
		'$reg_date',
		'')
	";

//초기 기본 그룹 생성(2개)
$add_group1="
	insert into $addform_group(
		name	
	) values(	
		'폼메일그룹')
	";
$add_group2="
	insert into $addform_group(
		name	
	) values(	
		'주문폼그룹')
	";

//초기 기본 애드폼 생성(2개)
$add_addform1="
	insert into $addform(
		no_group,
		form_type,
		input_date,
		edit_date,
		name,		
		title_text,
		msg_top,
		msg_bottom,
		top_img,
		bottom_img,
		width,
		coin_unit,
		secret_price,			
		email_address,
		tel,
		supply_name,
		supply_num,
		supply_man,
		supply_address,
		supply_conditions,
		supply_item,
		skin_name,		
		use_report_email,
		banking,
		count_field,
		etc,
		client_items,
		sign_img,
		return_type,
		layout,
		dummy3,
		dummy7,
		yesorno_pay,
		quotaopt,
		dummy10,
		dummy11,
		dummy12
	)values(
		'1',
		'1',
		'$reg_date',
		'',
		'TestForm1',		
		'테스트 폼메일',
		'해당폼의 품목설정에서, 설정한 품목과 옵션이 어떻게 표현되는지를 파악 후, 복잡한 폼양식을 쉽게 작성할 수 있습니다',
		'',
		'',
		'',
		'645',
		'￦',
		'0',			
		'',
		'',
		'',
		'',
		'',
		'',
		'',
		'',
		'addform_default',		
		'',
		'',
		'',
		'',
		'1|1|1|1|1|1|1',
		'',
		'click',
		'8',
		'번 호|품 목|규 격|단 위|수 량|단 가|소 계|세 액',
		'1',
		'off',
		'0',
		'<img src=\"http://www.addform.net/images/02.gif\">',
		'1',
		'1'
		)
	";

$add_addform2="
	insert into $addform(
		no_group,
		form_type,
		input_date,
		edit_date,
		name,		
		title_text,
		msg_top,
		msg_bottom,
		top_img,
		bottom_img,
		width,
		coin_unit,
		secret_price,			
		email_address,
		tel,
		supply_name,
		supply_num,
		supply_man,
		supply_address,
		supply_conditions,
		supply_item,
		skin_name,		
		use_report_email,
		banking,
		count_field,
		etc,
		client_items,
		sign_img,
		return_type,
		layout,
		dummy3,
		dummy7,
		yesorno_pay,
		quotaopt,
		dummy10,
		dummy11,
		dummy12
	)values(
		'2',
		'0',
		'$reg_date',
		'',
		'TestForm2',		
		'테스트 주문폼',
		'<span style=\"font-size:11px;color:gray;\">이곳에는, 폼추가/수정 메뉴에서, <strong>상단에 표시될 글</strong>입력란에 입력한, 글이 표시됩니다.</span>',
		'',
		'',
		'',
		'645',
		'￦',
		'1',			
		'',
		'',
		'',
		'',
		'',
		'',
		'',
		'',
		'addform_default',		
		'',
		'',
		'',
		'',
		'1|1|1|1|1|1|1',
		'',
		'click',
		'8',
		'번 호|품 목|규 격|단 위|수 량|단 가|소 계|세 액',
		'1',
		'off',
		'0',
		'',
		'1',
		'1'
		)
	";


	

//사용자 설정 환경 테이블 초기값
$add_env="
	insert into $addform_env(
		od_unit,
		coin_unit,
		upload_space,
		upload_space_per,
		upload_use_alert,
		dummy1,
		dummy3
	)values(
		'개,박스,장,명,접,축,필,인분,주,피,시간,발,대,끼,회,BOX,SET,PCS,ea,Kg,g,mg',		
		'￦,원,$,EURO,ECU,ACU,￥',
		'200000000',
		'70',
		'1',
		'접수완료,처리중,처리불가,처리완료|#ffff99,#b5d5b5,#ffcccc,#d0d9e3',
		'1')
	";

//레이아웃 테이블 초기값
$add_layout="
	insert into $addform_layout(		
		logo_link,
		yn_topmenu,
		yn_top_custom,
		topmenu_idx,
		top_custom,
		left_width,
		left_wUnit,
		yn_leftmenu,
		yn_thumblist,	
		yn_lastest,
		yn_best,
		yn_tel,
		yn_bank,
		yn_left_custom,
		leftmenu_idx,
		thumb_width,
		thumb_height,
		lastestN,
		bestN,
		left_custom,
		right_width,
		right_wUnit,
		yn_dokdo,
		yn_lastestR,
		yn_bestR,
		yn_right_custom,
		lastestRN,
		bestRN,
		right_custom,
		yn_companydata,
		yn_footer_custom,
		footer_custom
		)values(
		'',
		'on',
		'off',
		'<li><a href=\'#\'>사이트메뉴1</a></li>\n<li><a href=\'#\'>사이트메뉴2</a></li>\n<li><a href=\'#\'>사이트메뉴3</a></li>\n<li><a href=\'#\'>사이트메뉴4</a></li>\n<li><a href=\'#\'>사이트메뉴5</a></li>',
		'',
		'170',
		'px',
		'on',
		'on',
		'off',
		'off',
		'on',
		'on',
		'off',
		'<li><a href=\'#\'>임의설정메뉴1</a></li>\n<li><a href=\'#\'>임의설정메뉴2</a></li>\n<li><a href=\'#\'>임의설정메뉴3</a></li>\n<li><a href=\'#\'>임의설정메뉴4</a></li>\n<li><a href=\'#\'>임의설정메뉴5</a></li>\n<li><a href=\'#\'>임의설정메뉴6</a></li>\n<li><a href=\'#\'>임의설정메뉴7</a></li>',
		'70',
		'50',
		'3',
		'3',
		'',
		'130',
		'px',
		'on',
		'on',
		'on',
		'off',
		'3',
		'3',
		'',
		'on',
		'on',
		'Copyright © your domain All Rights Reserved.')
	";
#######################################################################################
#######################		각 테이블 초기 레코드 생성 end	###########################
#######################################################################################


?>

