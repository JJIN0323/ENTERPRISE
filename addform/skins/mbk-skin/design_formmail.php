<?php
	if($af_TABLE5["form_type"] == "1"){?>					
	<div id="form_head">
	</div>
	<div>
		<table id='formmail_items' class="roll_table">
			<TBODY>
			<!-- 설정한 품목/항목 반복 출력 함수 -->
			<?php echo af_get_dbTable_recode();?>	

			<!-- 첨부 파일 -->
			<tr><td class="client_file" colspan='4' style='height:10px;border:0;'></td></tr>
			<tr class="client_file">
				<td class="item" style='width:100px;' nowrap>				
				&nbsp;&nbsp;<?php echo $arr_dummy13[1];?>
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
			</TBODY>
		</table>
	</div>	
	<!-- 품목 하단 마무리 div  -->
	<div id="form_foot">
		<table style="width:100%;">
			<tr>
				<td>					
				</td>
			</tr>	
		</table>
	</div>
	<!-- 폼메일 계산기능 사용일 때, 합계출력 -->
	<div id="formmail_sum">
		<table>
			<tr>
				<td>
					<!--합계금액-->
					<?php echo $arr_dummy13[2];?>
				</td>
				<td style="width:200px;">
					<input type="text" name="total_sum_comma" value="0" readonly class="noborder" size="15"><?php echo $af_TABLE5[coin_unit];?> 
					<input type="hidden" name="total_sum" value="0" readonly>
				</td>
			</tr>
		</table>
	</div>
	<?php if($_POST["mode"] == "modify" or $_GET["mode"] == "admine"){?>				   
	<!--  관리자모드일 때 공급자/신청인/접수날짜  090402 -->
	<div style="margin:auto;text-align:center;margin-top:20px;margin-bottom:20px;">
		<table style="margin:0;padding:0;border-collapse:collapse;width:100%;">
			<tr>
				<td style="width:50%;margin:0;padding:0;">
					<table style="border-collapse:collapse;border:2px solid #777777;width:100%;font-size:13px;">
						<tr>
							<td style="border:1px solid #777777;background-color:#ccc;width:100px;padding:5px;text-align:center;font-weight:bold;">
								접수번호
							</td>
							<td style="border:1px solid #777777;text-align:center;font-weight:bold;">
								<?php echo $af_TABLE4['af_order_no'];?>
							</td>									
						</tr>
						<tr>
							<td style="border:1px solid #777777;background-color:#ccc;width:100px;padding:5px;text-align:center;font-weight:bold;">
								공급자
							</td>
							<td style="border:1px solid #777777;text-align:center;">
								<?php echo $af_TABLE1['supply_name'];?>
							</td>									
						</tr>
						<tr>
							<td style="border:1px solid #777777;background-color:#ccc;width:100px;padding:5px;text-align:center;font-weight:bold;">
								신청인
							</td>
							<td style="border:1px solid #777777;text-align:center;">
								<?php echo $clean['client_name'].$af_TABLE4['client_name'];?>
							</td>									
						</tr>
					</table>
				</td>
				<td style="text-align:center;border:0;">					
					<p style="font-size:1.5em;color:#666;font-weight:bold;">
					<?php 
					if($af_TABLE4['input_date']) 
						{						
							echo date("Y년m월d일",$af_TABLE4['input_date']);
						}
					else echo date("Y년m월d일",time());
					?>
					</p>
				</td>
			</tr>
		</table>
	</div>
	<?php }?>

	<!-- 폼메일 전송 버튼	-->	
	<div id="submit">
		<table <?php if($_GET["mode"] == "admine") echo "style='display:none;'";?>>
			<tr>
				
				<td style="width:250px;text-align:center;" class="print">
				<?php if($_GET["mode"] != "admine") {//관리자모드가 아닐 때?>
						<?php
						$af_arr_format = array("jpg","jpeg","gif");				//업로드 된 허용확장자
							$token_chk_btnImg = 0;		
							for($z=0; $z < count($af_arr_format);$z++)
								{
								if(file_exists("upload/".$af_TABLE5[name]."/btn_submit.".$af_arr_format[$z].""))
									{						
									echo "<a href='#'><img src='upload/".$af_TABLE5[name]."/btn_submit.".$af_arr_format[$z]."' name='ok' onclick='chk_email(document.form1.client_email);chk_selectOpt_formmail(document.form1);' alt='접수버튼'></a>";
									$token_chk_btnImg++;
									}								
								}
							if($token_chk_btnImg == 0)
								{
									echo "<input type=button value='".$arr_dummy13[0]."' name='ok' onclick='chk_email(this.form.client_email);chk_selectOpt_formmail(this.form);' class='btn_big'>";								
								}
						?>
						<?php
						$af_arr_format = array("jpg","jpeg","gif");				//업로드 된 허용확장자
							$token_chk_btnImg = 0;		
							for($z=0; $z < count($af_arr_format);$z++)
								{
								if(file_exists("upload/".$af_TABLE5[name]."/btn_retry.".$af_arr_format[$z].""))
									{						
									echo "<a href='#'><img src='upload/".$af_TABLE5[name]."/btn_retry.".$af_arr_format[$z]."' name='reentery' onclick='reset();' alt='다시작성버튼'></a>";
									$token_chk_btnImg++;
									}								
								}
						?>					
				<?php }?>				
				</td>
			</tr>
		</table>
		
		<?php if($_GET["mode"] == "admine") {//관리자모드 일 때?>
		<?php if($_GET["mode2"] != "normal") {?>
			<div style='text-align:right;'>
			<input type=button value='수정하기' name='ok' onclick='chk_email(this.form.client_email);chk_selectOpt_formmail(this.form);' class="btn_big">			
			</div>
		<?php }?>
		<?php }?>
		
	</div>
<?}?>