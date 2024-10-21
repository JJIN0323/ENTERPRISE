<?php
	if($af_TABLE5["form_type"] == "0"){?>
	<div id="order_table_div">	
		<table id="order_table" class="roll_table">
		<tbody>
			<tr>
				<td class="title_td" style='border-left-width:2px;width:20px;text-align:center;'> 
					<!--	체크 박스	-->
					<input type="checkbox" name="chkbox_all" onclick="chk_all_item(this.form,this,'');">
				</td>

				<td class="title_td" nowrap style="text-align:center">
					<!--	품 목	-->
					<?php echo $af_sectionArr[1];?>
				</td>	
				
				<td class="title_td" nowrap style="border-right:0;text-align:right;width:35px;">   
					<!--	수 량	-->
					<?php echo $af_sectionArr[4];?>
				</td>	

				<td class="title_td" nowrap style="width:11px;">   
					<!--	수 량 조 절	-->
					
				</td>
				
				<td class="title_td" nowrap style="text-align:center;width:50px;">   
					<!--	단 위	-->
					<?php echo $af_sectionArr[3];?>
				</td>

				<td class='secret_price' nowrap style="border-top-width:2px;border-right: 1px solid #ffffff;border-bottom-width:1px;background-color:#656565;color:#ffffff;font-weight:bold;text-align:center;width:70px;">   
					<!--	단 가	-->
					<?php echo $af_sectionArr[5];?>
				</td>

				<td class='secret_price' style="border-top-width:2px;border-right: 1px solid #ffffff;border-bottom-width:1px;background-color:#656565;color:#ffffff;font-weight:bold;width:80px;text-align:center;" nowrap> 
					<!--	소 계	-->
					<?php echo $af_sectionArr[6];?>
				</td>	

				<td class='secret_price' style="border-top-width:2px;border-right-width:2px;border-bottom-width:1px;background-color:#656565;color:#ffffff;font-weight:bold;width:70px;text-align:center;" nowrap> 
					<!--	세 액	-->
					<?php echo $af_sectionArr[7];?>
				</td>

			</tr>

			<!-- 설정한 품목 반복 출력  -->
			<?php echo af_get_dbTable_recode()?>
			
			<!-- subtotal -->
			<tr class='secret_price'>			
				<td colspan="4" style="border:0">			
				</td>
				<td colspan="2" style='border:2px solid #656565;border-bottom:1px solid #ffffff;text-align:right;background-color:#656565;'>
					<!-- subtoal(소계)-->
					<strong style="color:#ffffff;"><?php echo $arr_dummy14[2];?> <?php echo $af_TABLE5["coin_unit"];?></strong>
				</td>
				<td style='border:1px solid #656565;text-align:right;'>
					<input type="text" name="total_sum" value="0" readonly style="text-align:right;color:blue;width:90%;padding:3px;" class="noborder" size="13">
					<!-- 한자, 한글 금액 입력을 위한 히든 필드(total_sum3를 소스로 하여 total_sum2에 문자화 입력) -->
					<input type="hidden" name="total_sum2" value="0" readonly>
					<input type="hidden" name="total_sum3" value="0" readonly>		
				</td>
				<td style='text-align:right;border:1px solid #656565;border-right-width:2px;'>
				<!-- 부가세 계산용(보이기만 하기 위한 용도) -->
					<input type="text" name="sumTax" value="0" readonly style="text-align:right;color:blue;width:90%;padding:3px;" class="noborder" size="10">								
				</td>
			</tr>
			<!-- TOTAL -->
			<tr class='secret_price'>
				<td colspan="4" style="border:0">
				
				</td>
				<td colspan="2" style='border:2px solid #656565;border-top:1px solid #ffffff;text-align:right;background-color:#656565;'>
					<!-- TOTAL(합계)-->
					<strong style="color:#ffffff;"><?php echo $arr_dummy14[3];?> <?php echo $af_TABLE5["coin_unit"];?></strong>
				</td>		
				<td colspan="2" style='border:1px solid #656565;border-right-width:2px;border-bottom-width:2px;text-align:right;'>
					<!-- 부가세와 소계합을 더한 금액(보이기만 하기 위한 용도) -->
					<input type="text" name="taxPlusTotal" value="0" readonly style="text-align:right;color:red;font-weight:bold;width:90%;padding:3px;" class="noborder" size="18">	
				</td>
			</tr>
			
			</tbody>
		</table>
	</div>


	<!--++++++++++++++	주문폼 고객정보 입력란과 파일첨부 구성 파일   ++++++++++++++++-->
	<?php include_once("sheet/php/client_orderform.php");?>
	<!--++++++++++++++	주문폼 고객정보 입력란과 파일첨부 구성 파일   ++++++++++++++++-->
	

	<div id="submit">
	<?php if($af_TABLE5["secret_price"] == "1"){?>
		<?php
			$af_arr_format = array("jpg","jpeg","gif");				//업로드 된 허용확장자
			$token_chk_btnImg = 0;		
			for($z=0; $z < count($af_arr_format);$z++)
				{
				if(file_exists("upload/".$af_TABLE5[name]."/btn_estimate.".$af_arr_format[$z].""))
					{						
					echo "<a href='#'><img src='upload/".$af_TABLE5[name]."/btn_estimate.".$af_arr_format[$z]."' onclick='chk_email(document.form1.client_email);mix_shipTo(document.form1);chk_checkBox(document.form1,nextScript,\"pop\");' alt='견적보기'></a>";
					$token_chk_btnImg++;
					}								
				}
			if($token_chk_btnImg == 0)
				{
					echo "<input type=button value='".$arr_dummy14[1]."' onclick='chk_email(this.form.client_email);mix_shipTo(this.form);chk_checkBox(this.form,nextScript,\"pop\");' class='btn_big'>";
				}
		?>	
	<?php }?>
		<?php
			$af_arr_format = array("jpg","jpeg","gif");				//업로드 된 허용확장자
			$token_chk_btnImg = 0;		
			for($z=0; $z < count($af_arr_format);$z++)
				{
				if(file_exists("upload/".$af_TABLE5[name]."/btn_submit.".$af_arr_format[$z].""))
					{						
					echo "<a href='#'><img src='upload/".$af_TABLE5[name]."/btn_submit.".$af_arr_format[$z]."' onclick='chk_email(document.form1.client_email);mix_shipTo(document.form1);chk_checkBox(document.form1,nextScript,\"\");' alt='주문하기'></a>";
					$token_chk_btnImg++;
					}								
				}
			if($token_chk_btnImg == 0)
				{
					echo "<input type=button value='".$arr_dummy14[0]."' name='ok' onclick='chk_email(this.form.client_email);mix_shipTo(this.form);chk_checkBox(this.form,nextScript,\"\");' class='btn_big'>";
				}
		?>		
	</div>
<?}?>