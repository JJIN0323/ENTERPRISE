<?php
	if($af_client_itemsN > 0)
	{
	?>
	<?php
		if($af_client_itemsArr[0] && $af_client_itemsArr[1]) 
			{												//이름과 이메일 동시사용일 때
				$c1_trEnd = "";
				$c2_trStart = "";
				$c_colspan = "1";
			}
			else 
			{	
				$c1_trEnd = "</tr>";
				$c2_trStart = "<tr>";
				$c_colspan = "3";
			}
	?>

	<div id="order_field">		
		<table id="order_client" class="roll_table">
			<TBODY>
<!-- 구매자 start -->
				<tr>
					<td class='af_divi' colspan="4">
						<!-- 구매자 표시자 -->
						<strong><?php echo $arr_dummy14[4];?></strong>
					</td>										
				</tr>

				
				<?php if($af_client_itemsArr[0]){?>
				<tr>
					<!-- 고객 이름 -->
					<td class='item' nowrap>
						<span style='color:red;'>*</span> <?php echo $af_TABLE5["client_text_name"];?>
					</td>
					<td class='val' colspan='<?php echo $c_colspan;?>'>
						<input type='text' name='client_name' value='' onblur='quot_Del(this)' class='ess' style='ime-mode:active;'>
					</td>
					<?php echo $c1_trEnd;?>
				<?php }?>
				<?php if($af_client_itemsArr[1]){?>
					<!-- 고객 이메일 -->
					<?php echo $c2_trStart;?>
					<td class='item' nowrap>
						<span style='color:red;'>*</span> <?php echo $af_TABLE5["client_text_email"];?>
					</td>
					<td class='val' colspan='<?php echo $c_colspan;?>'>
						<input type='text' name='client_email' value='' class='ess' style='ime-mode:inactive;'>
					</td>		
				</tr>
				<?php }?>
	<?php 
		if($af_client_itemsArr[2] && $af_client_itemsArr[3]) 
		{												//휴대폰과 전화번호 동시사용일 때
			$c1_trEnd = "";
			$c2_trStart = "";
			$c_colspan = "1";
		}
		else 
		{	
			$c1_trEnd = "</tr>";
			$c2_trStart = "<tr>";
			$c_colspan = "3";
		}
	?>				
				
				<?php if($af_client_itemsArr[2]){?>
				<tr>
					<!--	고객 휴대폰	 -->
					<td class='item' nowrap>
						<span style='color:red;'>*</span> <?php echo $af_TABLE5["client_text_hp"];?>
					</td>
					<td class='val' colspan='<?php echo $c_colspan;?>'>
					<?php if(addform_rang == "korean"){ //한국어 설정일 때...?>
						<select name='sel_client_hp' id='sel_client_hp' onchange="this.form['client_hp1'].value=this.options[this.selectedIndex].value;dummys_input('client_hp','client_hp_dummy1');client_hp2.focus();">
							<?php echo $af_kr_hpNum;?>							
						</select>
						<input type='hidden' name='client_hp1' id='client_hp_dummy1' onkeyup="Numbering2(this);dummys_input('client_hp','client_hp_dummy1');" onmouseout="Numbering2(this);dummys_input('client_hp','client_hp_dummy1');"> -					
					<?php } else {	//한국어 설정이 아닐때 국번...?>
						<input type='text' name='client_hp1' id='client_hp_dummy1' onkeyup="Numbering2(this);dummys_input('client_hp','client_hp_dummy1');" onmouseout="Numbering2(this);dummys_input('client_hp','client_hp_dummy1');" size='4' class='ess'> - 					
					<?}?>
						<input type='text' name='client_hp2' id='client_hp_dummy2' onkeyup="Numbering2(this);dummys_input('client_hp','client_hp_dummy2');if(this.value.length >= 4)client_hp3.focus();" onmouseout="Numbering2(this);dummys_input('client_hp','client_hp_dummy2');" size='4' class='ess'> -
						<input type='text' name='client_hp3' id='client_hp_dummy3' onkeyup="Numbering2(this);dummys_input('client_hp','client_hp_dummy3');" onmouseout="Numbering2(this);dummys_input('client_hp','client_hp_dummy3');" size='4' class='ess'>

						<input type='hidden' name='client_hp' id='client_hp' value=''>
					</td>
					<?php echo $c1_trEnd;?>
				<?php }?>
				<?php if($af_client_itemsArr[3]){?>
					<!-- 고객 전화번호 -->
					<?php echo $c2_trStart;?>
					<td class='item' nowrap>
						&nbsp;&nbsp;<?php echo $af_TABLE5["client_text_tel"];?>
					</td>
					<td class='val' colspan='<?php echo $c_colspan;?>'>
					<?php if(addform_rang == "korean"){ //한국어 설정일 때...?>
						<select name='sel_client_tel' id='sel_client_tel' onchange="this.form['client_tel1'].value=this.options[this.selectedIndex].value;dummys_input('client_tel','client_tel_dummy1');client_tel2.focus()">
							<?php echo $af_kr_areaCode;?>
						</select>
						<input type='hidden' name='client_tel1' id='client_tel_dummy1' onkeyup="Numbering2(this);dummys_input('client_tel','client_tel_dummy1');" onmouseout="Numbering2(this);dummys_input('client_tel','client_tel_dummy1');"> - 
					<?php } else {?>
						<input type='text' name='client_tel1' id='client_tel_dummy1' onkeyup="Numbering2(this);dummys_input('client_tel','client_tel_dummy1');" onmouseout="Numbering2(this);dummys_input('client_tel','client_tel_dummy1');" size='4'> -
					<?php }?>
						<input type='text' name='client_tel2' id='client_tel_dummy2' onkeyup="Numbering2(this);dummys_input('client_tel','client_tel_dummy2');if(this.value.length >= 4)client_tel3.focus();" onmouseout="Numbering2(this);dummys_input('client_tel','client_tel_dummy2');" size='4'> -
						<input type='text' name='client_tel3' id='client_tel_dummy3' onkeyup="Numbering2(this);dummys_input('client_tel','client_tel_dummy3');" onmouseout="Numbering2(this);dummys_input('client_tel','client_tel_dummy3');" size='4'>
						
						<input type='hidden' name='client_tel' id='client_tel' value=''>
					</td>					
				</tr>
				<?php }?>		
				
				
				<!--	고객 팩스	 -->
				<?php if($af_client_itemsArr[4]){?>
				<tr>
					<td class='item' nowrap>
						&nbsp;&nbsp;<?php echo $af_TABLE5["client_text_fax"];?>
					</td>
					<td class='val' colspan='3'>
						<input type='text' name='client_fax1' id='client_fax_dummy1' onkeyup="Numbering2(this);dummys_input('client_fax','client_fax_dummy1');" onmouseout="Numbering2(this);dummys_input('client_fax','client_fax_dummy1');"size='4'> - 
						<input type='text' name='client_fax2' id='client_fax_dummy2' onkeyup="Numbering2(this);dummys_input('client_fax','client_fax_dummy2');" onmouseout="Numbering2(this);dummys_input('client_fax','client_fax_dummy2');" size='4'> -
						<input type='text' name='client_fax3' id='client_fax_dummy3' onkeyup="Numbering2(this);dummys_input('client_fax','client_fax_dummy3');" onmouseout="Numbering2(this);dummys_input('client_fax','client_fax_dummy3');" size='4'>

						<input type='hidden' name='client_fax' id='client_fax' value=''>
					</td>					
				</tr>
				<?php }?>
					
				<!--	고객 주소	 -->
				<?php if($af_client_itemsArr[5]){?>
				<tr>
					<td class="item">
						&nbsp;&nbsp;<?php echo $af_TABLE5["client_text_address"];?>
					</td>
					<td class="tdAlignLEFT" colspan='3'>
						<?php
						if(addform_rang == "korean")		 //090402(설정이 한국일 때)
							{
							$onclick_zipcode = "onclick=\"javascript:void(window.open('zipcode_search.php?w=500&amp;h=380&amp;id1=client_zipcode1&amp;id2=client_zipcode2&amp;id3=client_zipcode3&amp;id4=client_zipcode4&amp;formname=form1','zipcode','width=500,height=380,statusbar=no,scrollbars=yes,toolbar=no'))\"";
							
							echo ("
							<table class='c_address'>
								<tr>
									<td>
										<input type='text' name='client_zipcode1' id='client_zipcode1' value='' size='5' style='text-align:center;font-weight:bold;' readonly ".$onclick_zipcode."> -
										<input type='text' name='client_zipcode2' id='client_zipcode2' value='' size='5' style='text-align:center;font-weight:bold;' readonly ".$onclick_zipcode.">				
										<img src='skins/$af_TABLE5[skin_name]/img/btn_zipcode.gif' alt='우편번호찾기' ".$onclick_zipcode." style='cursor:hand;vertical-align:top;margin-top:1px;'>
									</td>
								</tr>
								<tr>
									<td colspan='2'>
										<input type='text' name='client_zipcode3' id='client_zipcode3' value='' size='50' readonly ".$onclick_zipcode.">
									</td>
								</tr>
								<tr>
									<td colspan='2'>
										<input type='text' name='client_zipcode4' id='client_zipcode4' value='' size='42' onblur='this.form.client_address.value=\"[\"+this.form.client_zipcode1.value+\"-\"+this.form.client_zipcode2.value+\"] \"+this.form.client_zipcode3.value+\" \"+this.form.client_zipcode4.value;quot_Del(this);this.style.backgroundColor=\"white\";' style='ime-mode:active;'>
										<img src='skins/$af_TABLE5[skin_name]/img/address.png' alt='상세주소' style='vertical-align:middle;'>
									</td>
								</tr>
							</table>
							<input type='hidden' name='client_address' value='' style='width:100%;ime-mode:active;' onblur='quot_Del(this)'>
							");
							}
						else								//090402(설정이 한국이 아닐 때는 주소입력을 일반  text모드로)
							{
							echo ("<input type='text' name='client_address' value='' style='width:100%;ime-mode:active;' onblur='quot_Del(this)'>");
							}
						?>
					</td>					
				</tr>
				<?php }?>


<!-- 수취인 start -->
				<tr>					
					<td class='af_divi' colspan="4">
						<!-- 수취인 표시자 -->
						<strong><?php echo $arr_dummy14[5];?></strong> 
						<input type="checkbox" name="eq_clientChk" onclick="eq_client(this.form,this);">
						<?php echo $arr_dummy14[6];?>
					</td>	
				</tr>

				<tr>
					<!-- 수취인 이름 -->
					<td class='item' nowrap>
						&nbsp;&nbsp;<?php echo $af_TABLE5["client_text_name"];?>
					</td>
					<td class='val'>
						<input type='text' name='client_ship' value='' onblur='quot_Del(this)' style='ime-mode:active;'>
					</td>
					<!-- 수취인 이메일 -->
					<td class='item' nowrap>
						&nbsp;&nbsp;<?php echo $af_TABLE5["client_text_email"];?>
					</td>
					<td class='val'>
						<input type='text' name='client_email_ship' value='' style='ime-mode:inactive;'>
					</td>
				</tr>

				<tr>
					<!-- 수취인 휴대폰 -->
					<td class='item' nowrap>
						&nbsp;&nbsp;<?php echo $af_TABLE5["client_text_hp"];?>
					</td>
					<td class='val'>
						<input type='text' name='client_hp1_ship' id='client_hp_ship_dummy1' onkeyup="Numbering2(this);dummys_input('client_hp_ship','client_hp_ship_dummy1');" onmouseout="Numbering2(this);dummys_input('client_hp_ship','client_hp_ship_dummy1');" size='4'> - 
						<input type='text' name='client_hp2_ship' id='client_hp_ship_dummy2' onkeyup="Numbering2(this);dummys_input('client_hp_ship','client_hp_ship_dummy2');" onmouseout="Numbering2(this);dummys_input('client_hp_ship','client_hp_ship_dummy2');" size='4'> -
						<input type='text' name='client_hp3_ship' id='client_hp_ship_dummy3' onkeyup="Numbering2(this);dummys_input('client_hp_ship','client_hp_ship_dummy3');" onmouseout="Numbering2(this);dummys_input('client_hp_ship','client_hp_ship_dummy3');" size='4'>

						<input type='hidden' name='client_hp_ship' id='client_hp_ship' value=''>
					</td>
					<!-- 수취인 전화번호 -->
					<td class='item' style='width:100px;' nowrap>
						&nbsp;&nbsp;<?php echo $af_TABLE5["client_text_tel"];?>
					</td>
					<td class='val'>
						<input type='text' name='client_tel1_ship' id='client_tel_ship_dummy1' onkeyup="Numbering2(this);dummys_input('client_tel_ship','client_tel_ship_dummy1');" onmouseout="Numbering2(this);dummys_input('client_tel_ship','client_tel_ship_dummy1');" size='4'> - 
						<input type='text' name='client_tel2_ship' id='client_tel_ship_dummy2' onkeyup="Numbering2(this);dummys_input('client_tel_ship','client_tel_ship_dummy2');" onmouseout="Numbering2(this);dummys_input('client_tel_ship','client_tel_ship_dummy2');" size='4'> -
						<input type='text' name='client_tel3_ship' id='client_tel_ship_dummy3' onkeyup="Numbering2(this);dummys_input('client_tel_ship','client_tel_ship_dummy3');" onmouseout="Numbering2(this);dummys_input('client_tel_ship','client_tel_ship_dummy3');" size='4'>

						<input type='hidden' name='client_tel_ship' id='client_tel_ship' value=''>
					</td>				
				</tr>

				<!-- 수취인 팩스 -->
				<tr>
					<td class='item' nowrap>
						&nbsp;&nbsp;<?php echo $af_TABLE5["client_text_fax"];?>
					</td>
					<td class='val' colspan='3'>
						<input type='text' name='client_fax1_ship' id='client_fax_ship_dummy1' onkeyup="Numbering2(this);dummys_input('client_fax_ship','client_fax_ship_dummy1');" onmouseout="Numbering2(this);dummys_input('client_fax_ship','client_fax_ship_dummy1');" size='4'> - 
						<input type='text' name='client_fax2_ship' id='client_fax_ship_dummy2' onkeyup="Numbering2(this);dummys_input('client_fax_ship','client_fax_ship_dummy2');" onmouseout="Numbering2(this);dummys_input('client_fax_ship','client_fax_ship_dummy2');" size='4'> -
						<input type='text' name='client_fax3_ship' id='client_fax_ship_dummy3' onkeyup="Numbering2(this);dummys_input('client_fax_ship','client_fax_ship_dummy3');" onmouseout="Numbering2(this);dummys_input('client_fax_ship','client_fax_ship_dummy3');" size='4'>

						<input type='hidden' name='client_fax_ship' id='client_fax_ship' value=''>		
					</td>
				</tr>

				<!--	수취인 주소	 -->				
				<tr>					
					<td class="item">
						&nbsp;&nbsp;<?php echo $af_TABLE5["client_text_address"];?>
					</td>
					<td class="tdAlignLEFT" colspan='3'>
						<?php
						if(addform_rang == "korean")		 //090402(설정이 한국일 때)
							{
							$onclick_zipcode = "onclick=\"javascript:void(window.open('zipcode_search.php?w=500&amp;h=380&amp;id1=client_ship_zipcode1&amp;id2=client_ship_zipcode2&amp;id3=client_ship_zipcode3&amp;id4=client_ship_zipcode4&amp;formname=form1','zipcode','width=500,height=380,statusbar=no,scrollbars=yes,toolbar=no'))\"";
							
							echo ("
							<table class='c_address'>
								<tr>
									<td>
										<input type='text' name='client_ship_zipcode1' id='client_ship_zipcode1' value='' size='5' style='text-align:center;font-weight:bold;' readonly ".$onclick_zipcode."> -
										<input type='text' name='client_ship_zipcode2' id='client_ship_zipcode2' value='' size='5' style='text-align:center;font-weight:bold;' readonly ".$onclick_zipcode.">				
										<img src='skins/$af_TABLE5[skin_name]/img/btn_zipcode.gif' alt='우편번호찾기' ".$onclick_zipcode." style='cursor:hand;vertical-align:top;margin-top:1px;'>
									</td>
								</tr>
								<tr>
									<td colspan='2'>
										<input type='text' name='client_ship_zipcode3' id='client_ship_zipcode3' value='' size='50' readonly ".$onclick_zipcode.">
									</td>
								</tr>
								<tr>
									<td colspan='2'>
										<input type='text' name='client_ship_zipcode4' id='client_ship_zipcode4' value='' size='42' onblur='this.form.client_address_ship.value=\"[\"+this.form.client_ship_zipcode1.value+\"-\"+this.form.client_ship_zipcode2.value+\"] \"+this.form.client_ship_zipcode3.value+\" \"+this.form.client_ship_zipcode4.value;quot_Del(this);this.style.backgroundColor=\"white\";' style='ime-mode:active;'>
										<img src='skins/$af_TABLE5[skin_name]/img/address.png' alt='상세주소' style='vertical-align:middle;'>
									</td>
								</tr>
							</table>
							<input type='hidden' name='client_address_ship' value='' style='width:100%;ime-mode:active;' onblur='quot_Del(this)'>
							");
							}
						else								//090402(설정이 한국이 아닐 때는 주소입력을 일반  text모드로)
							{
							echo ("<input type='text' name='client_address_ship' value='' style='width:100%;ime-mode:active;' onblur='quot_Del(this)'>");
							}
						?>						
					</td>
				</tr>
				
				
<!-- 첨부 파일 -->
				<tr>					
					<td class='af_divi' colspan="4">
					 &nbsp;
					</td>	
				</tr>
				<tr class="client_file">
					<td class="item" style='width:100px;' nowrap>
					&nbsp;&nbsp;<?php echo af_txt_view_addform_skin_8;?>
					</td>
					<td class='val' colspan='3'>
					<span style='color:#c0c0c0;font-size:11px;'><?php echo $af_TABLE5["attachFormat"];?>  < <?php echo number_format(intval($af_TABLE5["max_file_size"]) / 1024 / 1024,2);?> MB</span>
					<?php 
					if($af_TABLE5["dummy7"] == 1)
						{
						echo "<p id='upload$i' class='upload'><input type=file name='client_file[]' value='' size='50' style='height:20px;'></p>";
						}
					else
						{
							for($i = 0; $i < $af_TABLE5["dummy7"]; $i++)
							{
							$af_uploadN = $i+1;

								
								
									if($i == 0 )
									{
									echo "<p id='upload$i' class='upload'><input type=file name='client_file[]' value='' size='50' style='height:20px;'><input type='button' value='+' onclick=\"display_upload('$af_uploadN')\"><br></p>";	
									}
									else if($i < $af_TABLE5["dummy7"]-1 )
									{
									echo "<p id='upload$i' class='upload2'><input type=file name='client_file[]' value='' size='50' style='height:20px;'><input type='button' value='+' onclick=\"display_upload('$af_uploadN')\"><br></p>";	
									}
									else
									{
									echo "<p id='upload$i' class='upload2'><input type=file name='client_file[]' value='' size='50' style='height:20px;'></p>";
									}
							}
						
						}			
					?>
					</td>
				</tr>

				
<!--	고객 메모	 -->
				<?php if($af_client_itemsArr[6]){?>
				<tr>
					<td class="item">
						&nbsp;&nbsp;<?php echo $af_TABLE5["client_text_memo"];?>
					</td>
					<td colspan='3'>
						<textarea name="client_memo" id="client_memo" rows="7" onblur='quot_Del(this)' style='ime-mode:active;'></textarea>					
					</td>
				</tr>
				<?php }?>

				
				<tr>
				<td colspan='4' class="boundary">
<!-- 수취인 데이타 통합 입력 히든필드 -->
				<input type="hidden" name="shipTo">	
				</td>
				</tr>

			</TBODY>
		</table>
	</div>
<?php } ?>