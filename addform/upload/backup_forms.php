<?php 
/***************************************************************************************/  
/* 
set names utf8; 
-- 애드폼 폼백업 
-- version: addform-v7.2 
-- 프로그램출처 http://www.addform.net 
-- 데이타베이스: tax0125
-- 설치시 테이블이름: addform
-- 백업시각: 2016.05.25.13.40.04
*/ 
/***************************************************************************************/  


$arr_formupload = array();
define("chkver","addform-v7.2"); 
$db_tblname=db_tblname; 
$arr_formname = ""; 
$arr_formtitle = ""; 
$arr_formname = array(); 
$arr_formtitle = array(); 
$arr_formname[0] = "subs"; 
$arr_formtitle[0] = "서비스신청"; 



$tbl_tail="_table"; 
/* 
-- addform_af_table 테이블의 덤프데이터 (dump of addform_af_table) 
*/ 
if($_POST[chk_formname][0] == '1')  
{  
$arr_formupload[] = " 
INSERT INTO $db_tblname$tbl_tail VALUES('', '1', '1', '1464072329', '1464072575', 'subs', '서비스신청', '', '', '', '', '100', '원', '1', 'test@tester.com', '555-555-5555|', '대박날우리회사', 'xxx-xxx-xxxx', '박대박', '서울특별시 중구 태평로 1가 1번지 1F 101호', '서비스', '온라인정보제공', '', 'mbk-sub', '1', '국민은행|777777-77-777777|홍길동', '63', '', '2000000', 'jpg,jpeg,gif,png,psd,xls,doc,hwp,txt,zip,tar,ppt,dwg', '1|0|1|0|0|0|1', '이름 (의뢰인명)', '이메일', '연락처', '전화번호', 'fax', '주소', '고객메모', '', '돋움', '13px', '#000000', '8', 'http://officetax.biz/custom.html', 'auto', 'off', '', '1000', '', '', 'http://', '', '', '0', '', '0', '견적 당일', '번호|품목|규격|단위|수량|단가|소계|세액', '1', '0||||', '', '1', '0', '65', '', '', '', '전송하기|파일첨부|합계금액|다시작성||||||', '주문하기|견적보기|Subtotal|TOTAL|구매자|수취인|구매자와동일|||', '', '', '0', '1', '', '')";
}  




$tbl_tail="_subs_item"; 
if($_POST[chk_formname][0] == '1')  
{  
/***************************************************************************************/  
/* 
-- addform_af_subs_item 의 테이블 구조 (scheme of addform_af_subs_item) 
*/ 
/***************************************************************************************/  
$arr_formupload[] = " 
DROP TABLE IF EXISTS $db_tblname$tbl_tail"; 

$arr_formupload[] = " 
CREATE TABLE $db_tblname$tbl_tail ( 
no int(11)  NOT NULL  auto_increment ,
code int(11)  default 0 ,
name_it varchar(255) ,
price varchar(255) ,
opt text ,
unit varchar(255) ,
chk_input int(11)  default 0 ,
chk_filter int(11)  default 0 ,
chk_etc int(11)  default 0 ,
default_text text ,
default_opt text ,
discount text ,
dummy1 text ,
dummy2 text ,
dummy3 text ,
dummy4 text ,
dummy5 text ,
dummy6 text ,
dummy7 text ,
dummy8 text ,
dummy9 text ,
dummy10 text ,
dummy11 text ,
dummy12 text ,
dummy13 text ,
dummy14 text ,
dummy15 text ,
dummy16 text ,
dummy17 text ,
dummy18 text ,
dummy19 text ,
dummy20 text ,
 PRIMARY KEY (no)

)ENGINE = MYISAM DEFAULT CHARSET = utf8";

/* 
-- addform_af_subs_item 테이블의 덤프데이터 (dump of addform_af_subs_item) 
*/ 
$arr_formupload[] = " 
INSERT INTO $db_tblname$tbl_tail VALUES('357', '1', '상품종류', '0', '옵션|SE 라이트ⓘSEⓘ프리미엄|0,0,0|0|2', '개', '0', '0', '0', '', '', '', '', '3', '', '', '1', '0', '', 'http://www.addform.net/images/tip/itemThumb.gif', '', '', '', '', '', '', '', '', '', '', '', '')";
} 




?>




