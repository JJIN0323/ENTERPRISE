<?
### 애드폼 주문서 접수번호 셋팅 start
function f_af_order_no_set($type)
{
if ($type == "formmail") $headtoken = "n-";
if ($type == "orderform") $headtoken = "n-";

global $DBconn;
$res_forOrderNo = $DBconn->f_selectDB("*",TABLE4,"order by no desc limit 1");//접수테이블에서 가장 최근행 뽑아옴
$row_forOrderNo = mysql_fetch_array($res_forOrderNo[result]);				 //위 결과를 배열

if($row_forOrderNo)															 //접수내역이 있을 때
	{
	$last_af_order_no = explode("-",$row_forOrderNo[1]);					 //년월일 구분자로 부터 배열화

	if($last_af_order_no[1] != date("Ymd"))										 
		{
		$af_order_no_tail = "0001";											 //같은날 접수내역이 없을 때 후미 정의
		}
	else{																		 
		$af_order_no_tail = $last_af_order_no[2] + 1;	
		$mathN = 4;
		$cnt_af_order_no_tail = strlen($af_order_no_tail);
		$addZero = "0";
		for($i = $cnt_af_order_no_tail; $i < $mathN;$i++)
			{
			$af_order_no_tail = $addZero.$af_order_no_tail;					 //같은날 접수내역이 있을 때 후미정의
			}

		}
	 $af_order_no = $headtoken.date("Ymd")."-".$af_order_no_tail;			 //접수번호 셋팅
	}
else $af_order_no = $headtoken.date("Ymd")."-0001";							 //접수내역이 하나도 없을 때 셋팅
$arr = array();
$arr["af_order_no"] = $af_order_no;
return $arr;
}
### 애드폼 주문서 접수번호 셋팅 end
?>