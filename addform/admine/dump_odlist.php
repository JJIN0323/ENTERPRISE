<?
include_once("../lib/lib.php");
include_once("../lib/C_CONNECT.php");
include_once("../lib/define_table.php");
include_once("../lib/authentication.php");

$bak_fname = "order_".$_POST['sel_formName']."_".date("Ymd").".xls";	//저장될 파일이름
#########################################################################################
########################   selectBox Part1: 폼 선택상자 start    ######################
#########################################################################################

//<option>태그 생성
function f_opt($val,$text,$default="",$head="") 
{
	$buf="<option value='$val'";
	if ($default&&$default==$text) 
		{
		$buf.="selected";
		}
	$buf.=">".$head;
	return $buf;
}
//select 선택상자 구성
function f_SelectBox($arr) 
{
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
			
			<option value='all'>".af_txt_group."</option>
    \n";
    if ($arr["end"]>$arr[start]) 
		{             //숫자 범위 지정시
        for ($i=$arr[start];$i <= $arr["end"];$i++) 
			{
            $buf.=opt($i,$arr["default"],$arr[head]).$i.$arr[tail]."\n";
			}
		} 
	else if (count($arr[text])) 
		{          
        for ($i=0;$i < count($arr[text]);$i++) 
			{
            $buf.=f_opt($arr[optVal][$i],&$arr[text][$i],$arr["default"],$arr[head]).$arr[text][$i].$arr[tail]."\n";
			}
		}
    
    $buf.="</select>\n";
    return $buf;
}

#########################################################################################
############  selectBox Part2: DB에서 폼정보 가져와서 연관배열 만들기	  ###############
#########################################################################################

function f_mkOptArr()
{
global $DBconn;

$res=$DBconn->f_selectDB("*",TABLE5,$where);					 //필드, 테이블, 조건절
//$rows = mysql_fetch_array($res[result]);                   //리턴된 배열을 $row에 저장
$res_count=mysql_num_rows($res[result]);                     //리턴된 행의 개수
//리턴행이 여러개일 경우 아래와 같이 for문으로 연관배열화
$no=array();                                                 //배열변수 정의(폼번호)
$na=array();                                                 //배열변수 정의(폼이름)
	for ($i=0;$i < $res_count;$i++) 
		{													 //불러온 레코드의 수만큼 루프        
        $row=mysql_fetch_array($res[result]);                //배열의 요소들을 $row에 대입	
		$na[$i]=htmlspecialchars(stripslashes($row[name]));  //연관배열 만듬  
		$no[$i]=htmlspecialchars(stripslashes($row[no]));    //연관배열 만듬    
		}	
	//$arr=array("name"=>"comboGroup","id"=>"selectGroup","text"=>&$a);//연관배열 정의 방법1
	$arr=array();                                            //연관배열 정의 방법2
		$arr[head]="";
		$arr[tail]="";
		$arr[start]="";
		$arr['end']="";
		$arr['default']="";                                  //디폴트로 선택될 text
		$arr[name]="sel_formName";							 //선택상자 이름
		$arr[id]="";                                         //선택상자 객체 구분 아이디
		$arr[style]="";                                      //선택상자 스타일
		$arr[script]="";									 //실행할 스크립트			
		$arr[optVal]=$na;									 //옵션 value
		$arr[no]=$no;                                        //폼번호 
		$arr[na]=$na;                                        //폼이름
		$arr[text]=$na;                                      //실렉트 텍스트 항목 배열
		

echo f_SelectBox ($arr);//f_SelectBox 함수 실행
}

//체크한 항목 필드가 있을 때
if(!empty($_POST['arrfield'])) 
{
	if($_POST['sel_formName'] == "all") $where = "";
	else $where = "where mom='".$_POST['sel_formName']."'";
	//$result = mysql_query("SELECT ".implode(',', $_POST['arrfield'])." FROM ".db_tblname."_order_table ORDER BY no desc");
	//한 필드에 한개의 값만 있는것이 아니므로 일단 모든 필드 뽑아와서...
	$result = mysql_query("SELECT * FROM ".db_tblname."_order_table $where ORDER BY no desc");
    if(!$result) die(mysql_error());

    $head = array(
                'no'            => af_txt_dump_odlist_1,
                'af_order_no'   => af_txt_dump_odlist_2,
                'mom'			=> af_txt_dump_odlist_3,
						
                'client_name'   => af_txt_dump_odlist_4,
                'client_tel'    => af_txt_dump_odlist_5,                
				'client_hp'		=> af_txt_dump_odlist_7,
				'client_fax'    => af_txt_dump_odlist_6,
                'client_email'  => af_txt_dump_odlist_8,
                'client_address'=> af_txt_dump_odlist_9,

				'shipTo_name'	=> af_txt_dump_odlist_10,
                'shipTo_tel'	=> af_txt_dump_odlist_11,
                'shipTo_fax'	=> af_txt_dump_odlist_12,
				'shipTo_hp'		=> af_txt_dump_odlist_13,
                'shipTo_email'	=> af_txt_dump_odlist_14,
                'shipTo_address'=> af_txt_dump_odlist_15,

				'client_memo'   => af_txt_dump_odlist_16,
                'supply_memo'   => af_txt_dump_odlist_17,

				'arr_items'		=> af_txt_dump_odlist_18,
                'total_sum'		=> af_txt_dump_odlist_19,
				'taxTotal_txt'  => af_txt_dump_odlist_20,
                'total_thispage'=> af_txt_dump_odlist_21
            );

    $data1 = "<table border='1'>";
	$data1 .= "<tr>";
	//$_POST['arrfield'] 배열에서 key 와 값을 분리하여 값을 $field에 할당
    foreach($_POST['arrfield'] as $field) $data1 .= "<td style='background-color:#009999;font-size:1.1em;font-weight:bold;text-align:center;'>".$head[$field]. "</td>";
	$data1 .= "</tr>";

	$x = 1;		
   
	//select 쿼리 결과를 $data2에 할당
    while($row = mysql_fetch_array($result))
		{
########################	DB에서 가져온 필드값들 재정의 start	##########################
$clean=array();
		$clean['no'] = htmlspecialchars(stripslashes($row['no']));						 //고유번호
		$clean['af_order_no'] = htmlspecialchars(stripslashes($row['af_order_no']));	 //접수번호
		$clean['mom'] =  htmlspecialchars(stripslashes($row['mom']));					 //속한 주문폼 이름 
		$clean['order_date'] = htmlspecialchars(stripslashes($row['input_date']));		 //등록시각
		$clean['client_name'] = htmlspecialchars(stripslashes($row['client_name']));	 //고객 이름
		$clean['client_tel'] = htmlspecialchars(stripslashes($row['client_tel']));		 //고객	전화번호	
		$clean['client_hp'] = htmlspecialchars(stripslashes($row['client_hp']));		 //고객	휴대폰
		$clean['client_fax'] = htmlspecialchars(stripslashes($row['client_fax']));		 //고객	fax
		$clean['client_email'] = htmlspecialchars(stripslashes($row['client_email']));	 //고객	이메일
		$clean['client_address'] = htmlspecialchars(stripslashes($row['client_address']));//고객 주소
		$clean['client_memo'] = htmlspecialchars(stripslashes($row['client_memo']));	  //고객 메모
		$clean['supply_memo'] = htmlspecialchars(stripslashes($row['supply_memo']));	  //고객 메모
		$clean['total_data'] = htmlspecialchars(stripslashes($row['select_items']));	  //데이타
		$clean['total_sum'] = htmlspecialchars(stripslashes($row['sum']));				  //합  계
		$clean['total_sum2'] = htmlspecialchars(stripslashes($row['dummy4']));			  //한자, 한글 합  계
		$clean['shipTo'] = htmlspecialchars(stripslashes($row['dummy5']));				  //수취인정보

		
$arr_formdata = explode("|*|",$clean['total_data']);						//"|*|" 구분자로 1차 배열			
					$it_name = explode(";",$arr_formdata[0]);				//1.품목이름 2차배열
					$opt_text = explode(";",$arr_formdata[1]);				//2.옵션제목 2차배열 
					$opt_price = explode(";",$arr_formdata[2]);				//3.옵션가격 2차배열
					$it_unit = explode(";",$arr_formdata[3]);				//4.품목규격 2차배열
					$it_num = explode(";",$arr_formdata[4]);				//5.주문수량 2차배열
					$it_price = explode(";",$arr_formdata[5]);				//6.품목단가 2차배열
					$it_sumPrice = explode(";",$arr_formdata[6]);			//7.공급가액 2차배열
					$it_price_taxDB = explode(";",$arr_formdata[7]);		//8.세	  율 2차배열
				if(!$it_price_taxDB)$it_price_taxDB = 0;

//품목수 만큼...구분자(품목간은 &로, 품목상세는 쉼표로 구분)
			if ($it_name)
			{
				$clean['arr_items'] = "<table border='1'><tr><td style='background-color:#ccc;font-weight:bold;text-align:center;'>항목이름</td>
				<td style='background-color:#ccc;font-weight:bold;text-align:center;'>".af_txt_dump_odlist_23."</td><td style='background-color:#ccc;font-weight:bold;text-align:center;'>".af_txt_dump_odlist_24."</td><td style='background-color:#ccc;font-weight:bold;text-align:center;'>".af_txt_dump_odlist_22."</td><td style='background-color:#ccc;font-weight:bold;text-align:center;'>".af_txt_dump_odlist_25."</td></tr>";
				for ($i=0;$i<count($it_name);$i++)						
				{
				$clean['arr_items'] .= "<tr><td>".$it_name[$i]."</td><td>".$it_price[$i]."</td><td>".$it_num[$i]."</td><td>".$it_unit[$i].$opt_text[$i]."</td><td style='text-align:right;'>".$it_price_taxDB[$i]."%</td></tr>";
				}
				$clean['arr_items'] .= "</table>";			
			}



$arr_shipTo = explode("|",$clean['shipTo']);					
					$clean['shipTo_name'] = $arr_shipTo[0];			//첫번째 배열요소를 수취인이름으로...
					$clean['shipTo_email'] = $arr_shipTo[1];
					$clean['shipTo_hp'] = $arr_shipTo[2];
					$clean['shipTo_tel'] = $arr_shipTo[3];
					$clean['shipTo_fax'] = $arr_shipTo[4];
					$clean['shipTo_address'] = $arr_shipTo[5];
#-------------------	품목별 세액 합계와 총합계 구하기 start	----------------------#
//	주문서와 견적서출력에 소숫점 반영 여부  start
			if (substr_count($arr_formdata[2],".") > 0)			   //옵션값에서 소수출현회수
			{									
					$opt_price_dot = "yes";
			}
			else $opt_price_dot = "no";

			if (substr_count($arr_formdata[5],".") > 0)			  //품목값에서 소수출현횟수
			{									
					$it_price_dot = "yes";
			}
			else $it_price_dot = "no";

			if ($opt_price_dot == "yes" || $it_price_dot == "yes")//둘 중 하나라도 소수가 있다면
			{					
			$number_formatN = "2";
			}
			else $number_formatN = "0";
//	주문서와 견적서출력에 소숫점 반영 여부  end


			$taxTotal = 0;									//각품목별 세액의 합

			for ($i=0;$i<count($it_name);$i++)				//품목 배열의길이 만큼 루프
			{
															//1행 소계 세액
			$it_sumPrice_tax[$i] = $it_sumPrice[$i] * $it_price_taxDB[$i]/100;
			$taxTotal = $taxTotal + $it_sumPrice_tax[$i];	//품목별 세액 합계
			}
			$clean['taxTotal_txt'] = number_format($taxTotal,$number_formatN);
															//부가세포함 총합계
			$clean['total_thispage'] = number_format($clean['total_sum'] + $taxTotal,$number_formatN);		

#-------------------	품목별 세액 합계와 총합계 구하기 end	----------------------#
########################	DB에서 가져온 필드값들 재정의 end	#######################
		if($x%2 == 0)									    //행간 색상 구분								
			{
			 $tdStyle = "background-color:#ffcccc;";									
			}
		else $tdStyle = "background-color:#fff;";	

		$data1 .= "<tr>";
		
		foreach($_POST['arrfield'] as $field) 
			{			
				$clean[$field] = "<td style='text-align:center;$tdStyle' valign='top'>".$clean[$field]."</td>"; 
				
			$data1 .= $clean[$field];
			}

		$data1 .=  "</tr>";
		$x++;
			       
		}//while 문 끝
	
	$data1 .=  "</table>";   

   //header("Content-Type: application/octet-stream");
   //header("Content-Disposition: attachment; filename=xxx.csv");
   header("Content-type: application/vnd.ms-excel");
   header("Content-Disposition: attachment; filename=$bak_fname");
   header("Pragma: no-cache");
   header("Expires: 0");

	echo chr(255).chr(254).iconv("utf-8","utf-16le",$data1); 
} 
//체크한 항목 필드가 없을 때
else
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<meta name='robots' content='none,noindex,nofollow'>
<LINK REL="stylesheet" HREF="global.css" TYPE="text/css">

<TITLE><?php echo af_txt_dump_odlist_26;?></TITLE>
</head>
<body>

<form method="post" name="form" action="">

<fieldset style="width:90%;">

<legend>Export</legend>
<table>
<tr>
<td style="width:50%;border:0;text-align:left;">
<fieldset>
<legend>select</legend>
    <ul>
        <li><input type="checkbox" name="arrfield[]" checked value="no" /><?php echo af_txt_dump_odlist_1;?></li>
        <li><input type="checkbox" name="arrfield[]" checked value="af_order_no" /><?php echo af_txt_dump_odlist_2;?></li>
        <li><input type="checkbox" name="arrfield[]" checked value="mom" /><?php echo af_txt_dump_odlist_3;?></li>
		
        <li><input type="checkbox" name="arrfield[]" checked value="client_name" /><?php echo af_txt_dump_odlist_4;?></li>
        <li><input type="checkbox" name="arrfield[]" checked value="client_tel" /><?php echo af_txt_dump_odlist_5;?></li>		
        <li><input type="checkbox" name="arrfield[]" checked value="client_hp" /><?php echo af_txt_dump_odlist_7;?></li> 
		<li><input type="checkbox" name="arrfield[]" checked value="client_fax" /><?php echo af_txt_dump_odlist_6;?></li>
		<li><input type="checkbox" name="arrfield[]" checked value="client_email" /><?php echo af_txt_dump_odlist_8;?></li> 
		<li><input type="checkbox" name="arrfield[]" checked value="client_address" /><?php echo af_txt_dump_odlist_9;?></li> 

		<li><input type="checkbox" name="arrfield[]" checked value="shipTo_name" /><?php echo af_txt_dump_odlist_10;?></li>
        <li><input type="checkbox" name="arrfield[]" checked value="shipTo_tel" /><?php echo af_txt_dump_odlist_11;?></li>
		<li><input type="checkbox" name="arrfield[]" checked value="shipTo_fax" /><?php echo af_txt_dump_odlist_12;?></li>
        <li><input type="checkbox" name="arrfield[]" checked value="shipTo_hp" /><?php echo af_txt_dump_odlist_13;?></li> 
		<li><input type="checkbox" name="arrfield[]" checked value="shipTo_email" /><?php echo af_txt_dump_odlist_14;?></li> 
		<li><input type="checkbox" name="arrfield[]" checked value="shipTo_address" /><?php echo af_txt_dump_odlist_15;?></li> 

		<li><input type="checkbox" name="arrfield[]" checked value="client_memo" /><?php echo af_txt_dump_odlist_16;?></li> 
		<li><input type="checkbox" name="arrfield[]" checked value="supply_memo" /><?php echo af_txt_dump_odlist_17;?></li> 

		<li><input type="checkbox" name="arrfield[]" checked value="arr_items" /><?php echo af_txt_dump_odlist_18;?></li> 
		<li><input type="checkbox" name="arrfield[]" checked value="total_sum" /><?php echo af_txt_dump_odlist_19;?></li> 
		<li><input type="checkbox" name="arrfield[]" checked value="taxTotal_txt" /><?php echo af_txt_dump_odlist_20;?></li> 
		<li><input type="checkbox" name="arrfield[]" checked value="total_thispage" /><?php echo af_txt_dump_odlist_21;?></li> 
		
    </ul>
</fieldset> 
</td>
<td style="width:50%;border:0;text-align:left;" valign=top>
<fieldset>
<legend>save to excel</legend>

<?php echo af_txt_dump_odlist_27;?> <?php echo f_mkOptArr();?>

<input type="submit" value="<?php echo af_txt_save;?>" style="text-align:center;">

</fieldset>  

</td>
</tr>
</table>

</fieldset>    
        
</form>
</body>
</html>
<?
}//else 문 끝
?>
