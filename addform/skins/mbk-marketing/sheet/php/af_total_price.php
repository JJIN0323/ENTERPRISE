<?php
################	품목별 세액 합계와 총합계 구하기 start		  #######################
################	주문서와 견적서출력에 소숫점 반영 여부		  ####################### 

if (substr_count($arr_formdata[2],".") > 0)					//옵션값에서 소수출현회수
{									
		$opt_price_dot = "yes";
}
else $opt_price_dot = "no";

if (substr_count($arr_formdata[5],".") > 0)					//품목값에서 소수출현횟수
{									
		$it_price_dot = "yes";
}
else $it_price_dot = "no";

if ($opt_price_dot == "yes" || $it_price_dot == "yes")		//둘 중 하나라도 소수가 있다면
{					
$number_formatN = "2";
}
else $number_formatN = "0";



$taxTotal = 0;												//각품목별 세액의 합

for ($i=0;$i<count($it_name);$i++)							//품목 배열의길이 만큼 루프
{
															//1행 소계 세액
	$it_sumPrice_tax[$i] = $it_sumPrice[$i] * $it_price_taxDB[$i]/100;
	$taxTotal = $taxTotal + $it_sumPrice_tax[$i];			//품목별 세액 합계
}
$taxTotal_txt = number_format($taxTotal,$number_formatN);
															//부가세포함 총합계
if($clean['total_sum']) $total_thispage = number_format($clean['total_sum'] + $taxTotal,$number_formatN);
if($af_TABLE4['sum']) $total_thispage = number_format($af_TABLE4['sum'] + $taxTotal,$number_formatN);
$total_forText = str_replace(",","",$total_thispage);		//문자화하기 위해, 쉼표제거(견적서에서 사용됨)
?>

