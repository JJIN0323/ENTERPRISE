<!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
<!--############################  주문 정보 루핑 start   ############################ -->
<!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
<?
function f_af_od_loop()
{
	global $af_TABLE5;
	global $number_formatN;

	global $it_name;
	global $it_price;
	global $it_unit;
	global $it_num;
	global $opt_price;	
	global $opt_text;
	global $it_sumPrice_tax;
	global $it_sumPrice;
	global $it_price_taxDB;

	for ($i=0;$i<count($it_name);$i++) {					//품목 배열의길이 만큼 루프
	
		$number = $i+1;										//표시 순서

		##############################	옵션(규격)란 표시방법 정의 ###############################
		if($it_price[$i] > 0 and $opt_price[$i] > 0) {		//품목과 옵션(규격) 모두에 값이 있을 때
			if($af_TABLE5["secret_price"] == 0) $opt_price_display = "";	//폼설정이 비밀견적일 때는 옵션가격 표시안되게
			else {											//자동견적일 때는, 규격 또는 옵션(규격)란에 옵션(규격)가격 표시
			$opt_price_display = "(+ ".$af_TABLE5['coin_unit'].number_format($opt_price[$i],$number_formatN).")";	
			}
		}
															//품목 또는 옵션(규격) 한곳에만 값이 있거나															
		else $opt_price_display = "";						//둘다 가격이 없을때, 옵션(규격)가격 표시 안되게		


		if($opt_text[$i] != ""){							//선택한 옵션(규격)이 있을 때 옵션(규격)과 가격 표시
			$option[$i] = str_replace("#","<br>",$opt_text[$i])." ".$opt_price_display;			
		}	
		

		##############################	  단가란 표시방법 정의     ###############################
		if($it_price[$i] == "0") {							//품목의 값이 0원일 경우															
			$unit_cost[$i] = number_format($opt_price[$i],$number_formatN);	//단가를 옵션(규격)의 가격으로...
		}
		else $unit_cost[$i] = number_format($it_price[$i],$number_formatN);	//폼목의값이 있을 경우, 단가를 품목의 가격으로...

		##############################	  1행 소계 세액      ###############################
		$it_sumPrice_tax[$i] = $it_sumPrice[$i] * $it_price_taxDB[$i]/100;	//소계 세액			
		$it_sumPrice_tax[$i] = number_format($it_sumPrice_tax[$i],$number_formatN);

		##############################	  1행 소계			 ###############################
		$it_sumPrice[$i] = number_format($it_sumPrice[$i],$number_formatN);	//소계금액 콤마 찍고...


			echo("	
	<tr>
	    <!-- 번 호  -->
        <td style='width:7%;border-bottom:1px solid #000000;padding:3px;background-color:white'>
            $number
        </td>
		<!-- 품 목  -->
        <td style='text-align:left;border-bottom:1px solid #000000;padding:3px;background-color:white'>
            $it_name[$i]
        </td>
		<!-- 규격 또는 옵션  -->
        <td style='text-align:left;border-bottom:1px solid #000000;padding:3px;background-color:white'>
             $option[$i]
        </td>
		<!-- 단 위  -->
        <td style='text-align:center;border-bottom:1px solid #000000;padding:3px;background-color:white'>
            $it_unit[$i]
        </td>
		<!-- 수 량  -->
        <td style='text-align:center;border-bottom:1px solid #000000;padding:3px;background-color:white' >
           $it_num[$i]
        </td>
		<!-- 단 가  -->
        <td style='text-align:right;border-bottom:1px solid #000000;padding:3px;background-color:white;' class='secret_price'>
           $unit_cost[$i]
        </td>
		<!-- 소 계 -->
        <td style='text-align:right;border-bottom:1px solid #000000;padding:3px;background-color:white' class='secret_price'>
            $it_sumPrice[$i]
        </td> 
		<!-- 부가세 -->
        <td style='text-align:right;border-bottom:1px solid #000000;padding:3px;background-color:white' class='secret_price'>
            $it_sumPrice_tax[$i]
        </td>     
    </tr>
				
				"); 
    }	//for문 끝
}		//함수 끝

?> 
