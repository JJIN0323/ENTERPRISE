<?php
/* ---------------------------------  그룹 선택상자  -----------------------------------*/
function group_SelectBox($no_group)
{
global $DBconn;
$res=$DBconn->f_selectDB("*","".db_tblname."_group_table",$where);  //필드, 테이블, 조건절
//$rows = mysql_fetch_array($res[result]);                   //리턴된 배열을 $row에 저장
$res_count=mysql_num_rows($res[result]);                     //리턴된 행의 개수

$no=array();                                                 //배열변수 정의(그룹고유번호)
$na=array();                                                 //배열변수 정의(그룹이름)
	for ($i=0;$i<$res_count;$i++) {                          //불러온 레코드의 수만큼 루프        
        $row=mysql_fetch_array($res[result]);                //배열의 요소들을 $row에 대입	
		$na[$i]=htmlspecialchars(stripslashes($row[name]));  //스칼라배열 만듬  
		$no[$i]=htmlspecialchars(stripslashes($row[no]));    //스칼라배열 만듬    
    }	
	//$arr=array("name"=>"comboGroup","id"=>"selectGroup","text"=>&$a);//연관배열 정의 방법1
	$arr=array();                                           //연관배열 정의 방법2
		$arr[head]="";
		$arr[tail]="";
		$arr[start]="";
		$arr['end']="";
		$arr['default']="".$no_group."";                     //디폴트로 선택될 text
		$arr[name]="group_select";                           //선택상자 이름
		$arr[id]="";                                         //선택상자 객체 구분 아이디
		$arr[style]="";                                      //선택상자 스타일
		$onchange = "";
		for($i=0;$i<count($no);$i++)
		{			
		$onchange .="this.form.form_select".$no[$i].".style.display='none';";		
		}
		$onchange .="change_form(this.form,this.options[this.selectedIndex].value);";		
		$arr[script]="onchange=\"".$onchange."\"";
		$arr[optVal]="";									 //옵션 value
		$arr[no]=$no;                                        //그룹 고유번호 배열
		$arr[text]=$na;                                      //실렉트 메뉴 배열
		

echo fm_groupSelectBox2 ($arr);//f_SelectBox 함수 실행
}


/* ---------------------------------  폼 선택상자  -----------------------------------*/
function form_SelectBox($form_name)
{
global $DBconn;
global $af_TABLE5;
$resGr=$DBconn->f_selectDB("*","".db_tblname."_group_table",$where);  //필드, 테이블, 조건절
//$rows = mysql_fetch_array($res[result]);                   //리턴된 배열을 $row에 저장
$res_countGr=mysql_num_rows($resGr[result]);
$arr_group = "";
$arr_group = array();
for ($i=0;$i < $res_countGr;$i++) 
	{														 //불러온 레코드의 수만큼 루프        
        $row=mysql_fetch_array($resGr[result]);              //배열의 요소들을 $row에 대입		
		$arr_group[$i]=htmlspecialchars(stripslashes($row[no]));
	}	


for ($j=0;$j < count($arr_group);$j++)							 //그룹수만큼 루프돌림	
	{	
	$keywd = $arr_group[$j];
	$where = "where no_group like '$keywd' ";
	$style = "";
	if($arr_group[$j] == $af_TABLE5["no_group"])
		{
			$style = "";
		}
	else	$style = "display:none;";
	
	$res=$DBconn->f_selectDB("*",TABLE5,$where);				 //필드, 테이블, 조건절
	//$rows = mysql_fetch_array($res[result]);                   //리턴된 배열을 $row에 저장
	$res_count=mysql_num_rows($res[result]);                     //리턴된 행의 개수
	//리턴행이 여러개일 경우 아래와 같이 for문으로 연관배열화
	$no=array();                                                 //배열변수 정의(접수번호)
	$na=array();                                                 //배열변수 정의(폼이름)
	$ntitle=array();											 //배열변수 정의(폼제목)
		for ($i=0;$i < $res_count;$i++) 
		{														 //불러온 레코드의 수만큼 루프        
			$row=mysql_fetch_array($res[result]);                //배열의 요소들을 $row에 대입	
			$na[$i]=htmlspecialchars(stripslashes($row[name]));                //연관배열 만듬  
			$no[$i]=htmlspecialchars(stripslashes($row[no]));                  //연관배열 만듬
			$ntitle[$i]=htmlspecialchars(stripslashes($row[title_text]));      //연관배열 만듬 
		}	
		//$arr=array("name"=>"comboGroup","id"=>"selectGroup","text"=>&$a);//연관배열 정의 방법1
		$arr=array();                                            //연관배열 정의 방법2
			$arr[head]="";
			$arr[tail]=$ntitle;
			$arr[start]="";
			$arr['end']="";
			$arr['default']="$form_name";                        //디폴트로 선택될 text
			$arr[name]="form_select".$arr_group[$j];			 //선택상자 이름
			$arr[id]="form_select".$arr_group[$j];				 //선택상자 객체 구분 아이디
			$arr[style]="$style";								 //선택상자 스타일															
			$arr[script]="onchange='change_form2(this.options[this.selectedIndex].value);'";//실행할 스크립트
		if($_GET[mode]=="nameMode")	$arr[optVal]=URL."?mode=nameMode&amp;fname=";  //옵션 value
		else						$arr[optVal]=URL."?fname="; 	
			$arr[no]=$no;                                        //폼번호 
			$arr[na]=$na;                                        //폼이름
			$arr[text]=$na;                                      //실렉트 텍스트 항목 배열
			

	echo fm_formSelectBox2 ($arr);								 //f_SelectBox 함수 실행
	}
}

/* ---------------------------------    출 력       -----------------------------------*/
echo "<div class='groupANDform'>";
	echo "<table>";
		echo "<tr>";
			echo "<td style='text-align:left;' nowrap>";
				echo group_SelectBox($af_TABLE5["no_group"]);
				echo form_SelectBox($af_fname);
			echo "</td>";
			echo "<td style='text-align:right;'>";
				echo date("Y.m.d (D)");
			echo "</td>";		
		echo "</tr>";
	echo "</table>";
echo "</div>";
?>