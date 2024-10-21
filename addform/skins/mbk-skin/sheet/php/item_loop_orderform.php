<?php
#---------------------------------------------------------------------------------------#			
#	폼형식이 주문폼일 때, 주문항목을 루핑하는 파일입니다.								#
#---------------------------------------------------------------------------------------#	
	if($dummy8 and $dummy8 != "http://www.addform.net/images/tip/itemThumb.gif") 
		{
		$dummy8 = "<td style='border:0;width:70px;'>
							<img src='$dummy8' style='width:70px;height:50px;border:1px solid #ccc;' onclick=\"pop_img('$dummy8')\">
						</td>";
		}
	if(!$dummy8 or $dummy8 == "http://www.addform.net/images/tip/itemThumb.gif") 
		{
		$dummy8 = "";
		}
	$select_style = "";
echo("	
		<tr>
			<!--	체크 박스   -->
			<td style='padding-left:0;padding-right:0;border-left-width:2px;border-right:1px solid #cccccc;text-align:top;$end_tdStyle'>
				<input type='checkbox' name='chk_list[$i]' id='chk_list$i' value='$price' onclick='subtotal(this.form,$i)' $class style='border:0;width:20px;'>
				<input type='hidden' name='chk_dummy1'>
			</td>

			<!--	품	목   -->
			<td style='padding-left:3;padding-right:0;text-align:left;border-right:1px solid #cccccc;$end_tdStyle'>
				<table width=100%>
					<tr>
						$dummy8
						<td valign='top' style='border:0;padding-left:5px;'>									
							<span class='order_item'>$name_it</span><br>
							<span class='order_item_tip'>$dummy7 </span>
							<input type='hidden' name='it_name[$i]' id='it_name$i' value='$name_it' class='noborder' style='width:100px;text-align:left;' readonly>
							
							<!--	옵션 또는 규격 선택상자	-->																			
							<!--선택상자에서 선택한 옵션값이 들어오기 위한 히든 필드-->	
							<input type='hidden' name='hiddenOpt[$i]' size='3' onblur='Numbering(this)'>
							");
							if($dummy3 =="yes")											   //사용자입력형일 경우 한줄글상자 출력
							{
								echo "<div class='order_item_opt_text'>";
								echo "<span>".af_txt_skin_function_skin_9." :</span>";
								echo "<input type='text' name='chk_lis[".$i."]' value=''>";
								echo "</div>";
							}
							else														   //아니고 옵션이 있을 경우 선택상자 출력	
							{
							if($opt)	
								{
								echo "<div class='order_item_opt_selectBox'>";
								echo "<span>".$af_sectionArr[2]." :</span>"; 
								echo f_mkOptArr($no,$i,$af_TABLE5["coin_unit"],$opt_type,$select_style);
								echo "</div>";
								}
							}					
				echo("
						</td>
					</tr>
				</table>
			</td>
			
			<!--	수	량   -->	
			<td style='padding-left:0;padding-right:0;text-align:center;$end_tdStyle'>
				<input type='text' name='it_num[$i]' id='it_num$i' size='3' value='1' onblur='Numbering(this)' onkeyup='Numbering2(this);this.form[\"chk_list[$i]\"].checked=true;subtotal(this.form,$i);' style='text-align:right;'>
			</td>

			<!--  수량 조절  -->
			<td style='border-right:1px solid #cccccc;$end_tdStyle'>
				<img src='imgs/btn_up.gif' onclick='it_num_decrease(document.form1,$i,\"up\",\"\",\"\");' onmouseover='this.src=\"imgs/btn_up_over.gif\";' onmouseout='this.src=\"imgs/btn_up.gif\";'><br>
				<img src='imgs/btn_down.gif' onclick='it_num_decrease(document.form1,$i,\"down\",\"\",\"\");' onmouseover='this.src=\"imgs/btn_down_over.gif\";' onmouseout='this.src=\"imgs/btn_down.gif\";'>
			</td>
			

			<!--	단 위	-->	
			<td style='text-align:center;padding-left:0;padding-right:0;$right_tdStyle;$end_tdStyle'>
				<input type='text' name='it_unit[$i]' id='it_unit$i' size='3' value=$unit readonly class='noborder' style='text-align:center;$visible'>						
			</td>
			<!--	단 가	-->	
			<td class='secret_price' style='padding-right:3;text-align:right;border-right:1px solid #cccccc;$end_tdStyle'>
				<!-- 이 필드값은 후 기능 없음 -->
				<input type='text' name='price[$i]' id='price$i' style='width:90%;border:0;text-align:right;' readonly value='$price'>					
			</td>
			
			<!--	소	계	-->	
			<td class='secret_price' style='padding-left:0;padding-right:3;border-right:1px solid #cccccc;text-align:right;$end_tdStyle'>						
				<input type='text' name='it_sumPrice[$i]' id='it_sumPrice$i' value='0' onblur='Numbering(this)' class='subTotal'  style='width:90%' readonly>							
			</td>	
			<!--	세 액	-->	
			<td class='secret_price' style='padding-left:0;padding-right:3;border-right-width:2px;text-align:right;$end_tdStyle'>						
				<input type='text' name='it_price_tax[$i]' id='it_price_tax$i' value='0' onblur='Numbering(this)' class='subTax'  style='width:90%;' readonly>
				<input type='hidden' name='it_price_taxDB[$i]' id='it_price_taxDBx$i' value='$dummy6' readonly>		
			</td>	
				
		</tr>             
	
	"); 

?>